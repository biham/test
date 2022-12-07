<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Modeldosen;
use App\Models\Modelmahasiswa;
use App\Models\ProposalModel;
use Hermawan\DataTables\DataTable;

class proposal extends BaseController

{
    public function index()
    {
        $proposal = new ProposalModel();
        $data = [
            'title' => 'Data Proposal',
            'prodi' => $proposal->getprodi(),
            'tahun' => $proposal->gettahun(),

        ];
        return view('admin/proposal/index', $data);
        // dd($data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {

            $builder = $this->db->table('proposal')
                ->select('id_judul, judul, id_mahasiswa, proposal.status, id_dosen, nama_mhs, nama_dsn, files, prodinama')
                ->join('mahasiswa', 'mahasiswa.id=proposal.id_mahasiswa', 'left')
                ->join('dosen', 'dosen.id=proposal.id_dosen', 'left')
                ->join('prodi', 'prodi.prodiid = mahasiswa.mhsprodiid')
                ->join('tahun_akademik', 'tahun_akademik.TahunAkademikID = proposal.tahunakademikid');

            return DataTable::of($builder)
                ->filter(function ($builder, $request) {

                    if ($request->prodi)
                        $builder->where('prodinama', $request->prodi);
                    if ($request->tahun)
                        $builder->where('TahunAkademik', $request->tahun);
                    if ($request->semester)
                        $builder->where('Semester', $request->semester);
                })
                ->addNumbering('no')

                ->add('action', function ($row) {
                    return '
                <button type="button" class="btn btn-info btn-sm" onclick="edit(\'' . $row->id_judul  . '\')"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger btn-sm" onclick="hapus(\'' . $row->id_judul  . '\')"><i class="fa fa-trash"></i></button>';
                }, 'last')
                ->format('judul', function ($value) {
                    return strtoupper($value);
                })
                ->toJson(true);
        }
    }

    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $dosen = new Modeldosen();
            $mahasiswa = new Modelmahasiswa();


            $data = [
                'dosen' => $dosen->findall(),
                'mahasiswa' => $mahasiswa->findAll(),
            ];
            $msg = [
                'data' => view('admin/proposal/modaltambah', $data)

            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $proposal = new ProposalModel();
            $simpandata = [
                'judul' => $this->request->getVar('judul'),
                'id_mahasiswa' => $this->request->getVar('id_mahasiswa'),
                'id_dosen' => $this->request->getVar('id_dosen'),
                'status' => $this->request->getVar('status'),
                'tahunakademikid' => $proposal->gettahunaktif()->TahunAkademikID,
            ];


            $this->ProposalModel->insert($simpandata);

            $msg = [
                'sukses' => 'Data dosen berhasil tersimpan'
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function formedit()
    {

        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id_judul');
            $skr = new ProposalModel();
            $data = [
                'proposal' => $this->ProposalModel->editproposal($id),
                'dosen' => $this->dsn->findAll(),
                'mahasiswa' => $this->mhs->findAll(),
            ];
            $msg = [
                'sukses' => view('admin/proposal/modaledit', $data)
            ];

            echo json_encode($msg);
        }
    }

    function test()
    {
        $nip = $this->request->getVar('nip');
        $nobp = $this->request->getVar('nobp');

        $data = [
            'mhs' => $this->mhs->find($nobp),
            'dsn' => $this->dsn->find($nip),
            'jabatan' => $this->jbt->findAll()
        ];

        return view('dosen/test', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $nip = $this->request->getVar('id_judul');
            $simpandata = [
                'judul' => $this->request->getVar('judul'),
                // 'id_mahasiswa' => $this->request->getVar('id_mahasiswa'),
                'id_dosen' => $this->request->getVar('id_dosen'),
                // 'status' => $this->request->getVar('status'),
            ];
            $this->ProposalModel->update($nip, $simpandata);

            $msg = [
                'sukses' => 'Data mahasiswa berhasil Update'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id = $this->session->get('idlogin');
            $proposal = new ProposalModel;
            $proposaldata = $proposal->proposal($id);
            $id_judul = $this->request->getVar('id_judul');
            // $mhs = new Modelmahasiswa;
            $file = $this->request->getFile('files');
            // if (file_exists('assets/images/foto', $proposaldata->id_mahasiswa . '_' . $proposaldata->nama_mhs . '.' . $file->getExtension())) {
            //     unlink('assets/images/foto', $proposaldata->id_mahasiswa . '_' . $proposaldata->nama_mhs . '.' . $file->getExtension());
            // }
            $this->ProposalModel->delete($id);
            $msg = [
                'sukses' => "berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }
}
