<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'username', 'password', 'userlevelid'];

    public function cekdosen()
    {
        $builder = $this->db->table('users');
        $builder->select('*');
        $builder->join('comments', 'comments.id = blogs.id');
        $query = $builder->get();
    }
}
