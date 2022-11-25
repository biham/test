<?php

namespace App\Models;

use CodeIgniter\Model;

class Jabatan extends Model
{
    protected $table      = 'jabatan';
    protected $primaryKey = 'id_jabatan';
    protected $allowedFields = ['id_jabatan', 'nama_jabatan'];
}
