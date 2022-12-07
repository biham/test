<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailBimbinganModel extends Model
{
    protected $table      = 'detail_bimbingan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_bimbingan', 'id_dosen', 'id_mhs', 'tgl', 'materi', 'files', 'files_2', 'ket', 'ket_2', 'paraf'];


    public function getdetail($id = false)
    {
        $builder = $this->db->table('detail_bimbingan');
        $builder->select('materi, files, ket, ket_2, paraf, detail_bimbingan.status, id_bimbingan, files_2');
        $builder->join('bimbingan', 'bimbingan.id = detail_bimbingan.id_bimbingan');
        // $builder->join('mahasiswa', 'mahasiswa.id = bimbingan.id_mahasiswa');
        // $builder->join('dosen', 'dosen.id = bimbingan.id_dosen');
        $row = $builder->get();
        if ($id === false) {
            return $row;
        }
        // return $row;
        // $builder->select('*,bimbingan.id');
        $builder->select('detail_bimbingan.id_bimbingan, materi, files, ket, ket_2, paraf, detail_bimbingan.status');
        $builder->join('bimbingan', 'bimbingan.id = detail_bimbingan.id_bimbingan');
        // $builder->join('mahasiswa', 'mahasiswa.id = bimbingan.id_mahasiswa');
        // $builder->join('dosen', 'dosen.id = bimbingan.id_dosen');
        // $builder->join('proposal', 'proposal.id_judul = bimbingan.id_judul');
        // $builder->join('prodi', 'prodi.prodiid = mahasiswa.mhsprodiid');
        $query = $builder->getwhere(['detail_bimbingan.id_bimbingan' => $id]);
        return $query;
        // return $row->getResult();
        // return $rows->getwhere(['detail_bimbingan.id_bimbingan' => $id])->getResult();
    }
}
