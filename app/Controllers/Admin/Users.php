<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Hermawan\DataTables\DataTable;

class Users extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Data Users'
        ];
        return view('Admin/Users/index', $data);
    }
    public function getdata()
    {
        $builder = $this->db->table('users')
            ->select('id, username, password, userlevelid, levelnama')
            ->join('levels', 'levels.levelid=users.userlevelid');
        return DataTable::of($builder)->addNumbering('no')
            ->add('action', function ($row) {
                return '
                    <button type="button" class="btn btn-success btn-sm" onclick="aktif_tahun(\'' . $row->id  . '\')">Aktif</button>
                    <button type="button" class="btn btn-info btn-sm" onclick="edit(\'' . $row->id  . '\')"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus(\'' . $row->id  . '\')"><i class="fa fa-trash"></i></button>';
            }, 'last')
            ->toJson(true);
    }
    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id');

            $this->UsersModel->delete($id);
            $msg = [
                'sukses' => "berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }
}
