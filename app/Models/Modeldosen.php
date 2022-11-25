<?php

namespace App\Models;

use CodeIgniter\Model;
use Hermawan\DataTables;
use Hermawan\DataTables\DataTable;

class Modeldosen extends Model
{
    protected $table      = 'dosen';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'nip', 'nama_dsn', 'foto', 'telp', 'id_jabatan', 'email'];
    protected $useTimestamps = true;

    public function getdosen()
    {
        $dosen = new Modeldosen();
        $dosen->select('id,nip, nama_dsn, telp, nama_jabatan')
            ->join('jabatan', 'jabatan.id_jabatan=dosen.id_jabatan');

        return DataTable::of($dosen)->addNumbering()
            ->add('action', function ($row) {
                return '
                <button type="button" class="btn btn-info btn-sm" onclick="edit(\'' . $row->id  . '\')"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger btn-sm" onclick="hapus(\'' . $row->id  . '\')"><i class="fa fa-trash"></i></button>';
            }, 'last')
            ->toJson();
    }

    public function count()
    {
        $builder = $this->db->table('dosen');
        $builder->select('*');
        $query = $builder->countAll();
        return $query;
        return $this->count();
    }
}
