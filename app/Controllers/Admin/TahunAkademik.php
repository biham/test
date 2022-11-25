<?php

namespace App\Controllers\Admin;

use App\Models\TahunAkademikModel;
use App\Controllers\BaseController;
use Hermawan\DataTables\DataTable;

class TahunAkademik extends BaseController
{

    public function index()
    {
        $data = [
            'title' => 'Tahun Akademik',
        ];
        return view('admin/TahunAkademik/index', $data);
    }

    public function getdata()
    {
        $builder = $this->db->table('tahun_akademik')
            ->select('tahunakademikid, tahunakademik, semester, status')
            ->orderBy('status', 'DESC');
        return DataTable::of($builder)->addNumbering('no')
            ->add('action', function ($row) {
                if ($row->status == '1') {
                    return '
                    <button type="button" class="btn btn-info btn-sm" onclick="edit(\'' . $row->tahunakademikid  . '\')"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus(\'' . $row->tahunakademikid  . '\')"><i class="fa fa-trash"></i></button>';
                } else {
                    return '
                    <button type="button" class="btn btn-success btn-sm" onclick="aktif_tahun(\'' . $row->tahunakademikid  . '\')">Aktif</button>
                    <button type="button" class="btn btn-info btn-sm" onclick="edit(\'' . $row->tahunakademikid  . '\')"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus(\'' . $row->tahunakademikid  . '\')"><i class="fa fa-trash"></i></button>';
                }
            }, 'last')


            ->toJson(true);
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {

            $validation = \config\Services::validation();

            $valid = $this->validate([
                'tahun' => [
                    'label' => 'tahun akademik',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'semester' => [
                    'label' => 'semester',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',

                    ]
                ],
                'statuss' => [
                    'label' => 'status',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',

                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'tahun' => $validation->getError('tahun'),
                        'semester' => $validation->getError('semester'),
                        'statuss' => $validation->getError('statuss'),
                    ]
                ];
            } else {

                $simpandata = [
                    'tahunakademik' => $this->request->getVar('tahun'),
                    'semester' => $this->request->getVar('semester'),
                    'status' => $this->request->getVar('statuss'),
                ];

                $code = 0;
                if ($simpandata['status'] == 1) {
                    $builder = $this->db->table('tahun_akademik');
                    $builder->set('status', $code);
                    $builder->update();
                    $tahun = new TahunAkademikModel();
                    $tahun->insert($simpandata);
                }
                if ($simpandata['status'] == 0) {
                    $tahun = new TahunAkademikModel();
                    $tahun->insert($simpandata);
                }

                $msg = [
                    'sukses' => 'Berhasil tersimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function aktif_tahun()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('tahunakademikid');
            $code = 0;
            $updatedata = [
                'status' => 1
            ];
            $builder = $this->db->table('tahun_akademik');
            $builder->set('status', $code);
            $builder->update();
            $tahun = new TahunAkademikModel();
            $tahun->update($id, $updatedata);

            $msg = [
                'sukses' => 'Berhasil Mengaktifkan Tahun'
            ];


            echo json_encode($msg);
        }
    }
    public function formedit()
    {

        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id');
            $tahuna = new TahunAkademikModel();
            $data = [
                'tahun' => $tahuna->find($id)
            ];
            $msg = [
                'sukses' => view('admin/tahunakademik/modaledit', $data)
            ];

            echo json_encode($msg);
        }
    }
}
