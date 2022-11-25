<?php

namespace App\Models;

use CodeIgniter\Model;

class TahunAkademikModel extends Model
{
    protected $table      = 'tahun_akademik';
    protected $primaryKey = 'tahunakademikid';
    protected $allowedFields = ['tahunakademik', 'semester', 'status'];
    protected $useTimestamps = true;

    public function getdata()
    {
        return $this->findall();
    }
}
