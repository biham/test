<?= $this->extend('layout/main') ?>
<?= $this->extend('layout/menu') ?>
<?= $this->section('isi') ?>
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js"></script> -->


<div class="col-sm-12 mt-5">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h5 class="text-center"><?= $title; ?></h5>

                <!-- <button type="button" class="btn btn-info btn-sm tomboltambahbanyak">
                    <i class="fa fa-plus-circle"></i> Tambah Data Banyak
                </button> -->
            </div>
            <p class="card-text viewdata">

            </p>


            <div class="card-header">Custom Filter</div>

            <div class="row mt-4">
                <div class="col-sm-3">
                    <label>Prodi:
                        <select name="prodi" id='prodi' class="form-control custom-select custom-select-sm" style="width: 10rem;">
                            <option value="">All</option>
                            <?php foreach ($prodi as $data) : ?>
                                <option value="<?= $data->prodinama; ?>"><?= $data->prodinama; ?></option>
                            <?php endforeach ?>
                        </select>
                    </label>
                </div>
                <div class="col-sm-3">
                    <label>Tahun Akademik:
                        <select name="tahun" id='tahun' class="form-control custom-select custom-select-sm" style="width: 10rem;">
                            <option value="">All</option>
                            <?php foreach ($tahun as $data) : ?>
                                <option value="<?= $data->TahunAkademik; ?>"><?= $data->TahunAkademik; ?></option>
                            <?php endforeach ?>
                        </select>
                    </label>
                </div>
                <div class="col-sm-3">
                    <label>Semester:
                        <select name="semester" id='semester' class="form-control custom-select custom-select-sm" style="width: 10rem;">
                            <option value="">All</option>
                            <?php foreach ($tahun as $data) : ?>
                                <option value="<?= $data->Semester; ?>"><?= $data->Semester; ?></option>
                            <?php endforeach ?>
                        </select>
                    </label>
                </div>
                <div class="col-sm-3">
                    <button type="button" class="btn btn-primary btn-sm tomboltambah" style="float: right">
                        <i class=" fa fa-plus-circle"></i> Tambah Data
                    </button>
                </div>
            </div>


            <div class="table-responsive mt-4">
                <table class="table table-sm table-striped" id="dataproposal">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="text-center">Judul</th>
                            <th>Download Judul</th>
                            <th>Nama Mahaiswa</th>
                            <th>Prodi</th>
                            <th>Dosen Pembimbing</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>



<script>
    function listdataproposal() {
        $(document).ready(function() {
            table = $('#dataproposal').DataTable({

                // dom: 'Bfrtip',
                // buttons: [
                //     'colvis',
                //     'excel',
                //     'pdf'
                // ],
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= site_url('admin/proposal/getdata') ?>',
                    data: function(d) {
                        d.prodi = $('#prodi').val();
                        d.tahun = $('#tahun').val();
                        d.semester = $('#semester').val();
                    }
                },

                order: [],
                columns: [{
                        data: 'no',
                        orderable: false
                    },
                    {
                        "width": "30%",
                        data: 'judul',
                    },
                    {
                        data: 'files',
                        render: function(data, type) {
                            if (type === 'display') {
                                let link = 'files';

                                return '<a href="' + data + '" download>download</a>';
                            }

                            return data;
                        },
                    },
                    {
                        data: 'nama_mhs'
                    },
                    {
                        data: 'prodinama'
                    },
                    {
                        data: 'nama_dsn',
                        "render": function(data, type, row) {
                            if (row.nama_dsn == null) {
                                return '<span class="badge badge-warning">Belum ada pembimbing</badge>';
                            } else {
                                return data;
                            }
                        }
                    },
                    {
                        data: 'status',
                        name: 'proposal.status',
                        "render": function(data, type, row) {
                            if (row.status == '1') {
                                return '<span class="badge badge-success">di terima</badge>';
                            } else if (row.status == '0') {
                                return '<span class="badge badge-warning">Menunggu Konfirmasi</badge>';
                            } else {
                                return '<span class="badge badge-warning">di tolak</badge>';
                            }
                        }

                    },
                    {
                        data: 'action',
                        orderable: false
                    },

                ],
                "bDestroy": true,


            });
            $('#prodi').change(function(e) {
                table.ajax.reload();
            });
            $('#tahun').change(function(e) {
                table.ajax.reload();
            });
            $('#semester').change(function(e) {
                table.ajax.reload();
            });


        });

    }
    $(document).ready(function() {
        listdataproposal();
        $('.tomboltambah').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('admin/proposal/formtambah'); ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.data).show();

                    $('#modaltambah').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })

    });

    function edit(id_judul) {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/proposal/formedit'); ?>",
            data: {
                id_judul: id_judul
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modaledit').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }


    function hapus(id_judul) {
        Swal.fire({
            title: 'Hapus?',
            text: `Yakin menghapus data proposal ini ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {

            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('admin/proposal/hapus'); ?>",
                    data: {
                        id_judul: id_judul
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.sukses,
                            });
                            listdatadosen();
                        }

                    }
                });
            }
        })
    }
</script>
<?= $this->endsection('') ?>