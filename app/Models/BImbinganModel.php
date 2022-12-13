<?php

namespace App\Models;

use CodeIgniter\Database\MySQLi\Builder;
use CodeIgniter\Model;

class BimbinganModel extends Model
{
    protected $table      = 'bimbingan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'id_judul', 'id_dosen', 'id_mahasiswa', 'materi', 'files', 'files_2', 'ket', 'ket_2', 'paraf', 'status'];


    public function getbimbingan($id = false)
    {
        $builder = $this->db->table('detail_bimbingan');
        $builder->select('detail_bimbingan.id, materi, files, ket, ket_2, paraf, detail_bimbingan.status');
        $builder->join('bimbingan', 'bimbingan.id = detail_bimbingan.id_bimbingan');
        // $builder->join('mahasiswa', 'mahasiswa.id = bimbingan.id_mahasiswa');
        // $builder->join('dosen', 'dosen.id = bimbingan.id_dosen');
        $rows = $builder;
        $row = $builder->get();
        if ($id === false) {
            return $row->getResult();
        }
        // return $row;
        // $builder->select('*,bimbingan.id');
        $builder->select('detail_bimbingan.id, materi, files, ket, ket_2, paraf, detail_bimbingan.status');
        $builder->join('bimbingan', 'bimbingan.id = detail_bimbingan.id_bimbingan');
        // $builder->join('mahasiswa', 'mahasiswa.id = bimbingan.id_mahasiswa');
        // $builder->join('dosen', 'dosen.id = bimbingan.id_dosen');
        // $builder->join('proposal', 'proposal.id_judul = bimbingan.id_judul');
        // $builder->join('prodi', 'prodi.prodiid = mahasiswa.mhsprodiid');

        return $rows->getWhere(['detail_bimbingan.id' => $id])->getResult();
    }
    public function getbimbinganvalid($idl)
    {
        $where = "id_mahasiswa=$idl and detail_bimbingan.status='1'";
        $builder = $this->db->table('detail_bimbingan');
        $builder->select('*');
        $builder->join('bimbingan', 'bimbingan.id = detail_bimbingan.id_bimbingan');
        $row = $builder->where($where)->countAllResults();
        return $row;
    }

    public function get($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }

    public function bimbingan_mhs($id)
    {
        $where = "id_mahasiswa=$id";
        $builder = $this->db->table('bimbingan');
        $builder->join('mahasiswa', 'mahasiswa.id = bimbingan.id_mahasiswa');
        $builder->select('bimbingan.id, nama_mhs, npm');
        $row = $builder->getWhere($where)->getRowArray();
        return $row;
    }
    public function detail_bimbingan($id)
    {
        $where = "bimbingan.id=$id";
        $builder = $this->db->table('bimbingan');
        $builder->join('mahasiswa', 'mahasiswa.id = bimbingan.id_mahasiswa');
        $builder->join('prodi', 'prodi.prodiid = mahasiswa.mhsprodiid');
        $builder->join('dosen', 'dosen.id = bimbingan.id_dosen');
        $builder->join('proposal', 'proposal.id_judul = bimbingan.id_judul');
        $builder->select('bimbingan.id, nama_mhs, npm, nama_dsn, judul, prodinama');
        $row =  $builder->getWhere($where);
        return $row;
    }
}
