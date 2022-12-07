<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\Jabatan;
use App\Models\Modeldosen;

class Dosen extends BaseController
{
    public function __construct()
    {
    }
    public function index()
    {
        $data['title'] = 'Data Dosen';
        return view('admin/dosen/viewtampildata', $data);
    }

    // public function ambildata()
    // {
    //     $dsn = new Modeldosen();

    //     if ($this->request->isAJAX()) {

    //         $data = [
    //             'Dosen' => $this->dsn->findAll()
    //         ];

    //         $msg = [
    //             'data' => view('dosen/datadosen', $data)
    //         ];

    //         echo json_encode($msg);
    //     } else {
    //         exit('Maaf tidak dapat diproses');
    //     }
    // }

    public function getdosen()
    {
        $dosen = new Modeldosen();
        $dosen->select('id,nip, nama_dsn, telp, nama_jabatan, email')
            ->join('jabatan', 'jabatan.id_jabatan=dosen.id_jabatan');

        return DataTable::of($dosen)->addNumbering('no')
            ->add('action', function ($row) {
                return '
                <button type="button" class="btn btn-info btn-sm" onclick="edit(\'' . $row->id  . '\')"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger btn-sm" onclick="hapus(\'' . $row->id  . '\')"><i class="fa fa-trash"></i></button>';
            }, 'last')
            ->toJson(true);
    }

    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $jabatan = new Jabatan();
            $data = [
                'jabatan' => $jabatan->findall(),

            ];
            $msg = [
                'data' => view('admin/dosen/modaltambah', $data)

            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();

            $valid = $this->validate([
                'nip' => [
                    'label' => 'NIP',
                    'rules' => 'required|is_unique[dosen.nip]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'nama' => [
                    'label' => 'Nama Dosen',
                    'rules' => 'required|is_unique[dosen.nama_dsn]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'jabatan' => [
                    'label' => 'Jabatan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nip' => $validation->getError('nip'),
                        'nama' => $validation->getError('nama'),
                        'jabatan' => $validation->getError('jabatan')
                    ]
                ];
            } else {
                //save data untuk login
                $simpanuser = [
                    'username' => $this->request->getVar('nip'),
                    'password' => password_hash($this->request->getVar('nip'), PASSWORD_DEFAULT),
                    'userlevelid' => 3
                ];
                $this->UsersModel->insert($simpanuser);

                $id = $this->UsersModel->getInsertID();
                $simpandata = [
                    'id' => $id,
                    'nip' => $this->request->getVar('nip'),
                    'nama_dsn' => $this->request->getVar('nama'),
                    'email' => $this->request->getVar('email'),
                    'telp' => $this->request->getVar('telp'),
                    'id_jabatan' => $this->request->getVar('jabatan'),
                ];

                $this->dsn->insert($simpandata);
                $msg = [
                    'sukses' => 'Data dosen berhasil tersimpan'
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

            $id = $this->request->getVar('id');

            $data = [
                'dosen' => $this->dsn->find($id),
                'jabatan' => $this->jbt->findAll(),
            ];
            $msg = [
                'sukses' => view('admin/dosen/modaledit', $data)
            ];

            echo json_encode($msg);
        }
    }

    function test()
    {
        $nip = $this->request->getVar('nip');
        $nobp = $this->request->getVar('nobp');

        $data = [
            'mhs' => $this->mhs->find($nobp),
            'dsn' => $this->dsn->find($nip),
            'jabatan' => $this->jbt->findAll()
        ];

        return view('dosen/test', $data);
    }

    public function updatedata()
    {

        if ($this->request->isAJAX()) {

            $simpandata = [
                'nama_dsn' => $this->request->getVar('nama'),
                'email' => $this->request->getVar('email'),
                'telp' => $this->request->getVar('telp'),
                'id_jabatan' => $this->request->getVar('jabatan'),
            ];
            $nip = $this->request->getVar('id');
            $this->dsn->update($nip, $simpandata);

            $msg = [
                'sukses' => 'Data mahasiswa berhasil Update'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $nip = $this->request->getVar('id');
            // $mhs = new Modelmahasiswa;
            $this->dsn->delete($nip);

            $msg = [
                'sukses' => "Mahasiswa dengan nobp $nip berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }
}
