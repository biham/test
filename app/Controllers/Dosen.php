<?php

namespace App\Controllers;

use App\Controllers\Admin\proposal;
use App\Controllers\BaseController;
use App\Models\BImbinganModel;
use App\Models\proposalModel;
use Hermawan\DataTables\DataTable;

class Dosen extends BaseController
{
    public function getdata()
    {
        $id = session('idlogin');
        $builder = $this->db->table('proposal')
            ->select('id_judul, judul, id_mahasiswa, status, id_dosen, nama_mhs, nama_dsn, files, prodinama')
            ->where('id_dosen', $id)
            ->join('mahasiswa', 'mahasiswa.id=proposal.id_mahasiswa',)
            ->join('dosen', 'dosen.id=proposal.id_dosen',)
            ->join('prodi', 'prodi.prodiid = mahasiswa.mhsprodiid');



        return DataTable::of($builder)->addNumbering('no')
            ->add('action', function ($row) {
                if ($row->status == '0') {
                    return '
                    <button type="button" class="btn btn-success btn-sm" onclick="terima(\'' . $row->id_judul  . '\')">Terima</button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="tolak(\'' . $row->id_judul  . '\')">Tolak</button>';
                } else if ($row->status == '1') {
                    return '
                    <button type="button" class="btn btn-info btn-sm">sudah di terima</button>';
                } else {
                    return '
                    <button type="button" class="btn btn-warning btn-sm">sudah di tolak</button>';
                }
            }, 'last')
            ->format('judul_proposal', function ($value) {
                return strtoupper($value);
            })
            ->toJson(true);
    }

    public function terima()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_judul');


            $updatedata = [
                'status' => 1
            ];

            $this->proposalModel->update($id, $updatedata);

            $msg = [
                'sukses' => 'Berhasil disetujui'
            ];


            echo json_encode($msg);
        }
    }
    public function tolak()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_judul');


            $updatedata = [
                'status' => 2
            ];

            $this->proposalModel->update($id, $updatedata);

            $msg = [
                'sukses' => 'Berhasil Update data'
            ];


            echo json_encode($msg);
        }
    }

    public function index()
    {
        $id = session('iduser');
        $data = [
            'title' => 'Data Mahasiswa Terbimbing'
        ];
        return view('dosen/index', $data);
        // dd($id);
    }

    public function bimbingan()
    {
        $data =
            [
                'title' => 'Jadwal Bimbingan Mahasiswa'
            ];
        return view('dosen/bimbingan', $data);
    }

    public function simpandata()
    {

        if ($this->request->isAJAX()) {
            $id = $this->session->get('iduser');
            $simpandata = [
                'tgl' => $this->request->getVar('tgl'),
                'id_dosen' => $id,
            ];

            $bimbinganmodel = new BImbinganModel();
            $bimbinganmodel->insert($simpandata);

            $msg = [
                'sukses' => 'Berhasil input tanggal bimbingan'
            ];

            echo json_encode($msg);
        } else {

            exit('Maaf tidak dapat diproses');
        }
    }

    public function simpan()
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
                $judul =  $this->request->getVar('judul');
                $file = $this->request->getFile('files');
                $file->move('assets/images/foto', $data['nobp'] . '_' . $data['nama_mhs'] . '_' . $judul .   '.' . $file->getExtension());
                $simpandata = [
                    'judul_proposal' => $this->request->getVar('judul'),
                    'ket' => $this->request->getVar('ket'),
                    'files' => '/assets/images/foto/' . $file->getname(),
                    'id_mahasiswa' => $data['nobp']
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
}
