<?php

namespace App\Models;

use CodeIgniter\Model;

class ProposalModel extends Model
{
    protected $table      = 'proposal';
    protected $primaryKey = 'id_judul';
    protected $allowedFields = ['id_judul', 'judul', 'id_mahasiswa', 'status', 'id_dosen', 'files', 'ket', 'tahunakademikid'];
    protected $useTimestamps = true;

    public function getprodi()
    {
        $builder = $this->db->table('prodi');
        $query = $builder->get();
        $row = $query->getResult();
        return $row;
    }
    public function gettahun()
    {
        $builder = $this->db->table('tahun_akademik');
        $query = $builder->get();
        $row = $query->getResult();
        return $row;
    }
    public function gettahunaktif()
    {
        $builder = $this->db->table('tahun_akademik');
        $builder->where('status', 1);
        $query = $builder->get();
        $row = $query->getRow();
        return $row;
    }
    public function proposal($id)
    {
        $builder = $this->db->table('proposal');
        $builder->select('*');
        $builder->join('mahasiswa', 'mahasiswa.id = proposal.id_mahasiswa');
        $builder->join('dosen', 'dosen.id = proposal.id_dosen', 'left');
        $row = $builder->getwhere(['id_mahasiswa' => $id]);
        $rows = $row->getRowArray();
        return $rows;
    }
    public function editproposal($id)
    {
        $builder = $this->db->table('proposal');
        $builder->select('*');
        $builder->join('mahasiswa', 'mahasiswa.id = proposal.id_mahasiswa');
        $builder->join('dosen', 'dosen.id = proposal.id_dosen', 'left');
        $builder->join('prodi', 'prodi.prodiid = mahasiswa.mhsprodiid');
        $row = $builder->getwhere(['id_judul' => $id]);
        $rows = $row->getRowArray();
        return $rows;
    }
    public function accproposal($id1)
    {
        $where = "id_mahasiswa=$id1 and status='1'";
        $builder = $this->db->table('proposal');
        $builder->select('*');
        $builder->join('mahasiswa', 'mahasiswa.id = proposal.id_mahasiswa');
        $builder->join('dosen', 'dosen.id = proposal.id_dosen');
        $row = $builder->getWhere($where);
        $rows = $row->getRowArray();
        return $rows;
    }
}
