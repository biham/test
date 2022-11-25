<?= $this->extend('layout/main') ?>
<?= $this->extend('layout/menu') ?>
<?= $this->section('isi') ?>

<div class="col-sm-12">
    <div class="card m-b-30 mt-5">

        <div class="card-body">
            <div class="card-title">
                <h5 class="text-center"><?= $title; ?></h5>
                <!-- <button type="button" class="btn btn-info btn-sm tomboltambahbanyak">
                    <i class="fa fa-plus-circle"></i> Tambah Data Banyak
                </button> -->
            </div>

            <button type="button" class="btn btn-primary btn-sm tomboltambah">
                <i class="fa fa-plus-circle"></i> Tambah Data
            </button>
            <p class="card-text viewdata">

            </p>
            <table class="table table-sm table-striped" id="proposal">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="text-center">Judul</th>
                        <th>Download Judul</th>
                        <th>Nama Mahaiswa</th>
                        <th>Prodi</th>
                        <th>Dosen Pembimbing</th>
                        <th>status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>

<script>
    function listdataproposal() {
        $(document).ready(function() {
            table = $('#proposal').DataTable({
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
                    url: '<?= site_url('mahasiswa/getproposal') ?>',
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
                        "render": function(data, type, row) {
                            if (row.status == '0') {
                                return '<span class="badge badge-primary">Menunggu Konfirmasi</badge>';
                            } else if (row.status == '1') {
                                return '<span class="badge badge-primary">di terima</badge>';
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
            $('#id_mahasiswa').change(function(e) {
                table.ajax.reload();
            });


        });

    }
    $(document).ready(function() {
        listdataproposal();
        $('.tomboltambah').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('mahasiswa/formtambah'); ?>",
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
            text: `Yakin menghapus data`,
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
                    url: "<?= site_url('mahasiswa/hapus'); ?>",
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
                            listdataproposal();
                        }

                    }
                });
            }
        })
    }
</script>
<?= $this->endsection('') ?>