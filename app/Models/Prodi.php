<?php

namespace App\Models;

use CodeIgniter\Model;

class Prodi extends Model
{
    protected $table      = 'prodi';
    protected $primaryKey = 'prodiid';
    protected $allowedFields = ['prodinama'];
}
