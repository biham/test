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
            <table class="table table-sm table-striped" id="bimbingan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>Prodi</th>
                        <th class="text-center">Materi</th>
                        <th>Keterangan</th>
                        <th>File</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>

<script>
    function listdatabimbingan() {
        $(document).ready(function() {
            table = $('#bimbingan').DataTable({
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
                    url: '<?= site_url('bimbingan/getdata_d') ?>',
                },

                order: [],
                columns: [{
                        data: 'no',
                        orderable: false
                    },
                    {
                        "width": "15%",
                        data: 'nama_mhs',
                    },
                    {
                        "width": "10%",
                        data: 'prodinama',
                    },
                    {
                        "width": "10%",
                        data: 'materi',
                    },

                    {
                        "width": "20%",
                        data: 'ket',
                    },
                    {
                        data: 'files',
                        render: function(data, type) {
                            if (type === 'display') {
                                let link = 'files';

                                return '<a href="/assets/bimbingan/' + data + '" blank>download</a>';
                            }

                            return data;
                        },
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
        listdatabimbingan();
        $('.tomboltambah').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('bimbingan/formtambah'); ?>",
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

    function edit(id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('bimbingan/formedit_d'); ?>",
            data: {
                id: id
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
                    url: "<?= site_url('bimbingan/hapus'); ?>",
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
                            listdatabimbingan();
                        }

                    }
                });
            }
        })
    }
</script>
<?= $this->endsection('') ?>