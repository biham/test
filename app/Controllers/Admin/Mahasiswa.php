<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Codeigniter\Modelmahasiswa as CodeigniterModelmahasiswa;
use App\Models\Modelmahasiswa;
use App\Models\Modeldatamahasiswa;
use App\Models\Prodi;
use Config\Services;

class Mahasiswa extends BaseController
{
    function test()
    {
        // $mhs = new modelmahasiswa();
        // $prodi = new Prodi();

        // $data = [
        //     'tampildata' => $mhs->findall(),
        //     'prodi' => $prodi->findAll()
        // ];

        // return view('admin/mahasiswa/test', $data);

        // $pass = password_hash(('admin'), PASSWORD_DEFAULT);
        // echo $pass;
    }

    public function index()
    {
        $data['title'] = 'Mahasiswa';
        return view('admin/mahasiswa/viewtampildata', $data);
        // $pass = password_hash(('admin'), PASSWORD_DEFAULT);
        // echo $pass;
    }
    public function ambildata()
    {
        $mhs = new modelmahasiswa();
        $prodi = new Prodi();

        if ($this->request->isAJAX()) {

            $data = [
                'tampildata' => $mhs->findall(),
                'prodi' => $prodi->findAll()
            ];

            $msg = [
                'data' => view('admin/mahasiswa/datamahasiswa', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function listdata()
    {
        $request = Services::request();
        $datamodel = new Modeldatamahasiswa($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tomboledit = "<button type=\"button\" class=\"btn btn-info btn-sm\" onclick=\"edit('" . $list->id . "')\"><i class=\"fa fa-tags\"></i></button>";

                $tombolhapus = "<button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"hapus('" . $list->id . "')\">
                <i class=\"fa fa-trash\"></i>
            </button>";

                $tombolupload = "<button type=\"button\" class=\"btn btn-warning btn-sm\" onclick=\"upload('" . $list->id . "')\">
                <i class=\"fa fa-image\"></i>
            </button>";

                $row[] = "<input type=\"checkbox\" name=\"npm[]\" class=\"centangnpm\" value=\"$list->id\">";
                $row[] = $no;
                $row[] = $list->npm;
                $row[] = $list->nama_mhs;
                $row[] = $list->jenkel;
                $row[] = $list->prodinama;
                $row[] = $list->Jenjang;
                $row[] = $tomboledit . " " . $tombolhapus . " " . $tombolupload;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $prodi = new Prodi();
            $data = [
                'prodi' => $prodi->findall(),

            ];
            $msg = [
                'data' => view('admin/mahasiswa/modaltambah', $data)


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
                'npm' => [
                    'label' => 'Nomor BP',
                    'rules' => 'required|is_unique[mahasiswa.npm]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'nama' => [
                    'label' => 'Nama Mahasiswa',
                    'rules' => 'required|is_unique[mahasiswa.nama_mhs]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'npm' => $validation->getError('npm'),
                        'nama' => $validation->getError('nama')
                    ]
                ];
            } else {
                $simpanuser = [
                    'username' => $this->request->getVar('npm'),
                    'password' => password_hash($this->request->getVar('npm'), PASSWORD_DEFAULT),
                    'userlevelid' => 2,
                ];
                $this->users->insert($simpanuser);
                $id = $this->users->getInsertID();
                $simpandata = [
                    'id' => $id,
                    'npm' => $this->request->getVar('npm'),
                    'nama_mhs' => $this->request->getVar('nama'),
                    'tmplahir' => $this->request->getVar('tempat'),
                    'tgllahir' => $this->request->getVar('tgl'),
                    'jenkel' => $this->request->getVar('jenkel'),
                    'mhsprodiid' => $this->request->getVar('prodi'),
                ];

                $mhs = new Modelmahasiswa;
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

            $npm = $this->request->getVar('id');
            // $mhs = new Modelmahasiswa;

            $row = $this->mhs->find($npm);


            $data = [
                'mhs' => $this->mhs->find($npm),
                'prodi' => $this->prodi->findAll(),
                'jenkel' => $row['jenkel'],
            ];
            $msg = [
                'sukses' => view('admin/mahasiswa/modaledit', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $simpandata = [
                'nama' => $this->request->getVar('nama'),
                'tmplahir' => $this->request->getVar('tempat'),
                'tgllahir' => $this->request->getVar('tgl'),
                'jenkel' => $this->request->getVar('jenkel'),
                'mhsprodiid' => $this->request->getVar('mhsprodiid'),
            ];


            $npm = $this->request->getVar('id');
            $this->mhs->update($npm, $simpandata);

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
            $npm = $this->request->getVar('id');
            // $mhs = new Modelmahasiswa;
            $this->mhs->delete($npm);

            $msg = [
                'sukses' => "Mahasiswa dengan npm $npm berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    public function formtambahbanyak()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('admin/mahasiswa/formtambahbanyak')

            ];
            echo json_encode($msg);
        }
    }

    public function simpandatabanyak()
    {
        if ($this->request->isAJAX()) {

            if ($this->request->isAJAX()) {
                $npm = $this->request->getVar('npm');
                $nama = $this->request->getVar('nama');
                $tempat = $this->request->getVar('tempat');
                $tgl = $this->request->getVar('tgl');
                $jenkel = $this->request->getVar('jenkel');

                $jmldata = count($npm);

                for ($i = 0; $i < $jmldata; $i++) {
                    $this->mhs->insert([
                        'npm' => $npm[$i],
                        'nama' => $nama[$i],
                        'tmplahir' => $tempat[$i],
                        'tgllahir' => $tgl[$i],
                        'jenkel' => $jenkel[$i],
                    ]);
                }
                $msg = [
                    'sukses' => "$jmldata data berhasil disimpan"
                ];

                echo json_encode($msg);
            }
        }
    }

    public function hapusbanyak()
    {
        if ($this->request->isAJAX()) {
            $npm = $this->request->getVar('npm');
            $jmldata = count($npm);
            for ($i = 0; $i < $jmldata; $i++) {
                $this->mhs->delete($npm[$i]);
            }

            $msg = [
                'sukses' => "$jmldata data berhasil disimpan"
            ];

            echo json_encode($msg);
        }
    }

    public function formupload()
    {
        if ($this->request->isAJAX()) {
            $npm = $this->request->getVar('npm');

            $data = [
                'npm' => $npm
            ];

            $msg = [
                'sukses' => view('admin/mahasiswa/modalupload', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function doupload()
    {
        if ($this->request->isAJAX()) {
            $npm = $this->request->getVar('npm');

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
                $cekdata = $this->mhs->find($npm);
                $fotolama = $cekdata['foto'];
                if ($fotolama != NULL || $fotolama != "") {
                    unlink($fotolama);
                }
                $filefoto = $this->request->getFile('foto');
                $filefoto->move('assets/images/foto', $npm . '.' . $filefoto->getExtension());

                $updatedata = [
                    'foto' => './assets/images/foto/' . $filefoto->getname()
                ];

                $this->mhs->update($npm, $updatedata);

                $msg = [
                    'sukses' => 'Berhasil diupload'
                ];
            }

            echo json_encode($msg);
        }
    }
}
