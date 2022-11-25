<?php

namespace App\Models;

use CodeIgniter\Database\MySQLi\Builder;
use CodeIgniter\Model;

class BImbinganModel extends Model
{
    protected $table      = 'bimbingan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'id_judul', 'materi', 'files', 'files_2', 'ket', 'ket_2', 'paraf', 'status'];


    public function getbimbingan()
    {
        $builder = $this->db->table('skripsi');
        $builder->select('*');
        $builder->join('mahasiswa', 'mahasiswa.id = skripsi.id_mahasiswa');
        $builder->join('dosen', 'dosen.id = skripsi.id_dosen');
    }

    public function get($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
}
