<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use Config\Validation;

$session = session();

class Auth extends BaseController
{
    public function __construct()
    {
        $this->db = \config\Database::connect();
    }
    public function index()
    {
        return redirect()->to(site_url('auth/auth/login'));
    }

    public function login()
    {
        if (session('idlevel') == 1) {
            return redirect()->to(site_url('layout/index'));
        } else if (session('idlevel') == 2) {
            return redirect()->to(site_url('mahasiswa/index'));
        } else {
            return view('login/index');
        }
    }
    public function cekuser()
    {
        if ($this->request->isAJAX()) {
            $username = $this->request->getVar('username');
            $pass = $this->request->getVar('password');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'username' => [
                    'label' => 'User',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],

                'password' => [
                    'label' => 'Password',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'username' => $validation->getError('username'),
                        'password' => $validation->getError('password'),
                    ]
                ];
            } else {


                //cek user dulu ke database
                // $query_cekdosen = $this->db->query("SELECT * FROM users JOIN levels on levelid=userlevelid JOIN  dosen on dosen.id = users.id WHERE username='$username'");
                $query_cekdosen = $this->db->query("SELECT * FROM users JOIN levels on levelid=userlevelid  JOIN  dosen on dosen.id = users.id  WHERE username='$username'");

                $query_cekmahasiswa = $this->db->query("SELECT * FROM users JOIN levels ON levelid=userlevelid  JOIN mahasiswa on mahasiswa.id = users.id WHERE username='$username'");
                $query_cekadmin = $this->db->query("SELECT * FROM users JOIN levels ON levelid=userlevelid  WHERE username='$username'");

                $result_admin = $query_cekadmin->getResult();
                $result = $query_cekdosen->getResult();
                $result_mhs = $query_cekmahasiswa->getResult();

                if (count($result) > 0) {
                    // lanjutkan
                    $row = $query_cekdosen->getRow();
                    $password_user = $row->password;

                    if (password_verify($pass, $password_user)) {
                        //buat session
                        $simpan_session = [
                            'login' => true,
                            'idlogin' => $row->id,
                            'iduser' => $username,
                            'namauser' => $row->nama_dsn,
                            'idlevel' => $row->userlevelid,
                            'namalevel' => $row->levelnama
                        ];
                        $this->session->set($simpan_session);

                        $msg = [
                            'sukses' => [
                                'link' => site_url('layout/index')
                            ]
                        ];
                    } else {
                        $msg = [
                            'error' => [
                                'password' => 'Maaf password anda salah'
                            ]
                        ];
                    }
                } elseif (count($result_mhs) > 0) {
                    $row_mhs = $query_cekmahasiswa->getRow();
                    $pass_mhs = $row_mhs->password;

                    if (password_verify($pass, $pass_mhs)) {
                        $simpan_session = [
                            'login' => true,
                            'iduser' => $username,
                            'idlogin' => $row_mhs->id,
                            'namauser' => $row_mhs->nama_mhs,
                            'idlevel' => $row_mhs->userlevelid,
                            'namalevel' => $row_mhs->levelnama
                        ];
                        $this->session->set($simpan_session);

                        $msg = [
                            'sukses' => [
                                'link' => site_url('layout/index')
                            ]
                        ];
                    } else {
                        $msg = [
                            'error' => [
                                'password' => 'Maaf password anda salah'
                            ]
                        ];
                    }
                } elseif (count($result_admin) > 0) {
                    $row_admin = $query_cekadmin->getRow();
                    $pass_admin = $row_admin->password;

                    if (password_verify($pass, $pass_admin)) {
                        $simpan_session = [
                            'login' => true,
                            'idlogin' => $row_admin->id,
                            'iduser' => $username,
                            'idlevel' => $row_admin->userlevelid,
                            'namalevel' => $row_admin->levelnama
                        ];
                        $this->session->set($simpan_session);

                        $msg = [
                            'sukses' => [
                                'link' => site_url('layout/index')
                            ]
                        ];
                    } else {
                        $msg = [
                            'error' => [
                                'password' => 'Maaf password anda salah'
                            ]
                        ];
                    }
                } else {
                    $msg = [
                        'error' => [
                            'username' => 'Maaf ID User tidak ditemukan'
                        ]
                    ];
                }
            }

            echo json_encode($msg);
        }
    }

    public function keluar()
    {

        $this->session->destroy();

        return redirect()->to('auth/auth/index');
    }
}
