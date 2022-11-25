<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailbimbinganModel extends Model
{
    protected $table      = 'detail_bimbingan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_bimbingan', 'id_dosen', 'id_mhs', 'tgl', 'materi', 'files', 'files_2', 'ket', 'ket_2', 'paraf'];


    public function getbimbingan($slug = false)
    {

        if ($slug === false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}
