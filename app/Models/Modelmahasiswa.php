<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelmahasiswa extends Model
{
    protected $table      = 'mahasiswa';
    protected $useTimestamps = true;
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'npm', 'nama_mhs', 'jenkel', 'mhsprodiid', 'foto'];



    public function count()
    {
        $builder = $this->db->table('mahasiswa');
        $builder->select('*');
        $query = $builder->countAll();
        return $query;
    }
}
