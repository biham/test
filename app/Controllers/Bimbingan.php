<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\proposalModel;
use App\Models\BImbinganModel;
use App\models\DetailbimbinganModel;
use Hermawan\DataTables\DataTable;


class Bimbingan extends BaseController
{

    public function index()
    {
        $id1 = session('idlogin');
        $id2 = session('idlevel');

        $data = [
            'title' => 'Bimbingan',
            'cek' => $this->proposalModel->accproposal($id1)
        ];
        if ($id2 == 2) {
            return view('bimbingan/index_m', $data);
        } else {
            return view('bimbingan/index_d', $data);
        }
        // dd($bimbingan);
    }

    public function getdata_d()
    {
        $id = session('idlogin');
        $builder = $this->db->table('bimbingan')
            ->select('bimbingan.id, id_mahasiswa, proposal.id_dosen, materi, bimbingan.files, files_2, bimbingan.ket, ket_2, bimbingan.status, nama_mhs, prodinama')
            ->where('id_dosen', $id)
            ->join('proposal', 'proposal.id_judul= bimbingan.id_judul')
            ->join('mahasiswa', 'mahasiswa.id=proposal.id_mahasiswa',)
            ->join('dosen', 'dosen.id=proposal.id_dosen',)
            ->join('prodi', 'prodi.prodiid = mahasiswa.mhsprodiid');



        return DataTable::of($builder)->addNumbering('no')
            ->add('action', function ($row) {
                return '
                    <button type="button" class="btn btn-warning btn-sm" onclick="edit(\'' . $row->id  . '\')"><i class="fa fa-eye"></i></button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="tolak(\'' . $row->id  . '\')">Tolak</button>';
            }, 'last')
            ->format('judul_proposal', function ($value) {
                return strtoupper($value);
            })
            ->toJson(true);
    }
    public function getdata_m()
    {
        $id = session('idlogin');
        $builder = $this->db->table('bimbingan')
            ->select('bimbingan.id, id_mahasiswa, proposal.id_dosen, materi, bimbingan.files, files_2, bimbingan.ket, ket_2, bimbingan.status')
            ->where('id_mahasiswa', $id)
            ->join('proposal', 'proposal.id_judul= bimbingan.id_judul')
            ->join('mahasiswa', 'mahasiswa.id=proposal.id_mahasiswa',)
            ->join('dosen', 'dosen.id=proposal.id_dosen',)
            ->join('prodi', 'prodi.prodiid = mahasiswa.mhsprodiid');



        return DataTable::of($builder)->addNumbering('no')
            ->add('action', function ($row) {
                return '
                    <button type="button" class="btn btn-success btn-sm" onclick="hapus(\'' . $row->id  . '\')">Hapus</button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="tolak(\'' . $row->id  . '\')">Tolak</button>';
            }, 'last')
            ->format('judul_proposal', function ($value) {
                return strtoupper($value);
            })
            ->toJson(true);
    }

    public function formtambah()
    {
        if ($this->request->isAJAX()) {

            $msg = [
                'data' => view('bimbingan/modaltambah')

            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function hapus()
    {
        if ($this->request->isAJAX()) {
            // $id = $this->session->get('idlogin');
            // $proposal = new proposalModel;
            // $proposaldata = $proposal->proposal($id);
            $id = $this->request->getVar('id');
            $bimbingan = $this->BImbinganModel->get($id);
            $file = $this->request->getFile('files');
            // $file_name = $proposaldata['npm'] . '_' . $proposaldata['nama_mhs'] . '_' . $file->getRandomName();
            $file_name = $bimbingan['files'];
            // if (array_map('file_exists', glob(FCPATH . "assets/bimbingan/$file_name.*"))) {
            //     array_map('unlink', glob(FCPATH . "assets/bimbingan/$file_name.*"));
            // }

            unlink('assets/bimbingan/' . $file_name);

            $this->BImbinganModel->delete($id);
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
            $data1 = $builder->getWhere(['id' => $id])->getRowArray();
            $data = $proposal->accproposal($id);


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
                'materi' => [
                    'label' => '',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} silahkan pilih materi'
                    ]
                ],
                'ket' => [
                    'label' => 'keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi'
                    ]
                ],


            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'files' => $validation->getError('files'),
                        'materi' => $validation->getError('materi'),
                        'ket' => $validation->getError('ket'),
                    ]
                ];
            } else {
                //cek data
                // $cekdata = $this->mhs->find($id);
                // $fotolama = $cekdata['files'];
                // if ($fotolama != NULL || $fotolama != "") {
                //     unlink($fotolama);
                // }

                $file = $this->request->getFile('files');
                $file->move('assets/bimbingan/', $data['npm'] . '_' . $data['nama_mhs'] . '_' .  $file->getRandomName());
                $simpandata = [
                    'id_judul' => $data['id_judul'],
                    'materi' => $this->request->getVar('materi'),
                    'ket' => $this->request->getVar('ket'),
                    'files' => $file->getname(),
                    'status' => '0',
                ];

                $mhs = new BImbinganModel();
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

    public function formedit_d()
    {

        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id');
            $bimbingan = new BImbinganModel();
            $data = [
                'bimbingan' => $this->BImbinganModel->find($id),
                'dosen' => $this->dsn->findAll(),
                'mahasiswa' => $this->mhs->findAll(),
            ];
            $msg = [
                'sukses' => view('bimbingan/modaledit_d', $data)
            ];

            echo json_encode($msg);
        }
    }
    public function update_d()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            // cek foto
            // $cekdata = $this->mhs->find($id);
            // $fotolama = $cekdata['files'];
            // if ($fotolama != NULL || $fotolama != "") {
            //     unlink($fotolama);
            // }
            $data = $this->BImbinganModel->find($id);
            $file = $this->request->getFile('files_2');
            if ($file->getError() == 4) {
                $files_lama = $data['files_2'];
                if ($files_lama != NULL || $files_lama != "") {
                    unlink('assets/bimbingan/' . $files_lama);
                }
                $updatedata = [
                    'materi' => $this->request->getVar('materi'),
                    'ket_2' => $this->request->getVar('ket_2'),
                    'status' => $this->request->getVar('status'),
                    'files_2' => null,
                ];
            } else {
                $files_lama = $data['files_2'];
                if ($files_lama != NULL || $files_lama != "") {
                    unlink('assets/bimbingan/' . $files_lama);
                }
                $file = $this->request->getFile('files_2');
                $file->move('assets/bimbingan/', $file->getRandomName());
                $updatedata = [
                    'materi' => $this->request->getVar('materi'),
                    'ket_2' => $this->request->getVar('ket_2'),
                    'status' => $this->request->getVar('status'),
                    'files_2' => $file->getname(),
                ];
            }

            $mhs = new BImbinganModel();
            $mhs->update($id, $updatedata);

            $msg = [
                'sukses' => 'Data mahasiswa berhasil tersimpan'
            ];


            echo json_encode($msg);
        }
    }
}
