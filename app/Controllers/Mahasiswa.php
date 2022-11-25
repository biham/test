<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\proposalModel;
use App\Models\BImbinganModel;
use App\models\DetailbimbinganModel;
use Hermawan\DataTables\DataTable;

class Mahasiswa extends BaseController
{
    public function index()
    {
        $id = $this->session->get('idlogin');
        $proposal = new proposalModel;
        $proposaldata = $proposal->proposal($id);
        if ($proposaldata != null) {
            $data = [
                $proposaldata,
                'title' => 'Mahasiswa',
                // 'judul' => $proposaldata->judul_proposal,
                // 'dospem' => $proposaldata->nama_dsn,
            ];
            return view('Mahasiswa/index', $data);
        } else {
            $data = [
                'title' => 'Mahasiswa',
                'judul' => '',
                'dospem' => '',
            ];
            return view('Mahasiswa/index', $data);
        }

        // dd($proposaldata['id_mahasiswa']);
    }
    public function getproposal()
    {
        if ($this->request->isAJAX()) {
            $proposal = new proposalModel();
            $id = session('idlogin');
            $builder = $this->db->table('proposal')
                ->select('id_judul, judul, id_mahasiswa, status, id_dosen, nama_mhs, nama_dsn, files, prodinama')
                ->where('id_mahasiswa', $id)
                ->join('mahasiswa', 'mahasiswa.id=proposal.id_mahasiswa', 'left')
                ->join('dosen', 'dosen.id=proposal.id_dosen', 'left')
                ->join('prodi', 'prodi.prodiid = mahasiswa.mhsprodiid');


            return DataTable::of($builder)

                ->addNumbering('no')

                ->add('action', function ($row) {
                    if ('status' == 0) {
                        return '
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapus(\'' . $row->id_judul  . '\')"><i class="fa fa-trash"></i></button>';
                    } else {
                        return '
                        <button type="button" class="btn btn-warning btn-sm">Approved</button>';
                    }
                }, 'last')
                ->format('judul', function ($value) {
                    return strtoupper($value);
                })
                ->toJson(true);
        }
        // <button type="button" class="btn btn-info btn-sm" onclick="edit(\'' . $row->id_judul  . '\')"><i class="fa fa-edit"></i></button>
    }

    public function judul()

    {
        $id = $this->session->get('idlogin');
        $proposal = new proposalModel;
        $proposaldata = $proposal->proposal($id);
        // if ($proposaldata != null) {
        $data = [
            $proposaldata,
            'title' => 'Upload Proposal'
        ];
        return view('Mahasiswa/proposal', $data);
        // }
    }

    public function bimbingan()
    {
        $bimbingan = new BImbinganModel();
        $data = [
            'title' => 'bimbingan proposal',
            'jadwal' => $bimbingan->getbimbingan()
        ];


        return view('mahasiswa/bimbingan', $data);
    }

    public function formtambah()
    {
        if ($this->request->isAJAX()) {

            $msg = [
                'data' => view('mahasiswa/modaltambah')

            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id = $this->session->get('idlogin');
            $proposal = new proposalModel;
            $proposaldata = $proposal->proposal($id);
            $id_judul = $this->request->getVar('id_judul');
            $file_name = $proposaldata['npm'] . '_' . $proposaldata['nama_mhs'] . '_' . $proposaldata['judul'];

            if (array_map('file_exists', glob(FCPATH . "assets/proposal/$file_name.*"))) {
                array_map('unlink', glob(FCPATH . "assets/proposal/$file_name.*"));
            }

            $this->proposalModel->delete($id_judul);
            $msg = [
                'sukses' => "berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $proposal = new proposalModel();
            $builder = $this->db->table('mahasiswa');
            $id = $this->session->get('idlogin');
            $data = $builder->getWhere(['id' => $id])->getRowArray();

            $validation = \config\Services::validation();

            $valid = $this->validate([
                'files' => [
                    'label' => 'Upload Files',
                    'rules' => 'uploaded[files]|max_size[files,2048]|ext_in[files,pdf,doc,docx]',
                    'errors' => [
                        'uploaded' => '{field} wajib diisi',
                        'max_size' => '{field} max ukuran 2mb',
                        'ext_in' => 'tidak sesuai format (pdf/word)'

                    ]
                ],
                'judul' => [
                    'label' => 'Judul Proposal',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],


            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'files' => $validation->getError('files'),
                        'judul' => $validation->getError('judul')
                    ]
                ];
            } else {
                //cek data
                // $cekdata = $this->mhs->find($id);
                // $fotolama = $cekdata['files'];
                // if ($fotolama != NULL || $fotolama != "") {
                //     unlink($fotolama);
                // }

                $judul =  $this->request->getVar('judul');
                $file = $this->request->getFile('files');
                $file->move('assets/proposal', $data['npm'] . '_' . $data['nama_mhs'] . '_' . $judul .   '.' . $file->getExtension());
                $simpandata = [
                    'judul' => $this->request->getVar('judul'),
                    'ket' => $this->request->getVar('ket'),
                    'files' => '/assets/proposal/' . $file->getname(),
                    'id_mahasiswa' => $data['id'],
                    'tahunakademikid' => $proposal->gettahunaktif()->TahunAkademikID,
                ];

                $mhs = new proposalModel();
                $mhs->insert($simpandata);

                $msg = [
                    'sukses' => 'Data mahasiswa berhasil tersimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function formedit()
    {

        if ($this->request->isAJAX()) {

            $id_judul = $this->request->getVar('id_judul');
            $skr = new proposalModel();
            $data = [
                'proposal' => $this->proposalModel->find($id_judul),
                'dosen' => $this->dsn->findAll(),
                'mahasiswa' => $this->mhs->findAll(),
            ];
            $msg = [
                'sukses' => view('mahasiswa/modaledit', $data)
            ];

            echo json_encode($msg);
        }
    }
    public function doupload()
    {
        if ($this->request->isAJAX()) {
            $nobp = $this->request->getVar('id');

            $validation = \config\Services::validation();
            $valid = $this->validate([
                'foto' => [
                    'label' => 'Upload Foto',
                    'rules' => 'uploaded[foto]|mime_in[foto,image/png,image/jpg/jpg,image/jpeg]|is_image[foto]',
                    'errors' => [
                        'uploaded' => '{field} wahib diisi',
                        'mime_in' => 'Harus dalam bentuk gambar'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg  = [
                    'error' => [
                        'foto' => $validation->getError('foto')
                    ]
                ];
            } else {
                // cek foto
                $cekdata = $this->mhs->find($nobp);
                $fotolama = $cekdata['foto'];
                if ($fotolama != NULL || $fotolama != "") {
                    unlink($fotolama);
                }
                $filefoto = $this->request->getFile('foto');
                $filefoto->move('assets/images/foto', $nobp . '.' . $filefoto->getExtension());

                $updatedata = [
                    'foto' => './assets/images/foto/' . $filefoto->getname()
                ];

                $this->mhs->update($nobp, $updatedata);

                $msg = [
                    'sukses' => 'Berhasil diupload'
                ];
            }

            echo json_encode($msg);
        }
    }

    public function apply()
    {

        if ($this->request->isAJAX()) {

            $bimbingan = new bimbinganModel();
            $id = $this->request->getVar('id');

            $data = [
                'bimbingan' => $bimbingan->find($id)
            ];
            $msg = [
                'sukses' => view('mahasiswa/formapply', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function applybimbingan()

    {
        if ($this->request->isAJAX()) {

            $builder = $this->db->table('mahasiswa');
            $nobp = $this->session->get('iduser');
            $data = $builder->getWhere(['nobp' => $nobp])->getRowArray();

            $validation = \config\Services::validation();

            $valid = $this->validate([
                'files' => [
                    'label' => 'Upload Files',
                    'rules' => 'uploaded[files]|max_size[files,2048]',
                    'errors' => [
                        'uploaded' => '{field} wajib diisi',
                        'max_size' => '{field} max ukuran 2mb'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'files' => $validation->getError('files')
                    ]
                ];
            } else {
                $id_bimbingan =  $this->request->getVar('id');
                $file = $this->request->getFile('files');
                $file->move('assets/images/foto', $data['nobp'] . '_' . $data['nama_mhs'] . '.' . $file->getExtension());
                $simpandata = [
                    'id_bimbingan' => $id_bimbingan,
                    'materi' => $this->request->getVar('materi'),
                    'ket' => $this->request->getVar('ket'),
                    'files' => '/assets/images/foto/' . $file->getname(),
                    'id_mhs' => $data['nobp']
                ];

                $bimbingan = new DetailbimbinganModel();
                $bimbingan->insert($simpandata);

                $msg = [
                    'sukses' => 'Data mahasiswa berhasil tersimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}
