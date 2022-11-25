<?= $this->extend('layout/main') ?>
<?= $this->extend('layout/menu') ?>
<?= $this->section('isi') ?>
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.css" />

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js"></script> -->

<div class="col-sm-12">
    <div class="card m-b-30 mt-5">

        <div class="card-body">
            <div class="card-title">
                <h4 class="page-title text-center">Data Dosen</h4>
                <button type="button" class="btn btn-primary btn-sm tomboltambah">
                    <i class="fa fa-plus-circle"></i> Tambah Data
                </button>
                <!-- <button type="button" class="btn btn-info btn-sm tomboltambahbanyak">
                    <i class="fa fa-plus-circle"></i> Tambah Data Banyak
                </button> -->
            </div>
            <p class="card-text viewdata">

            </p>
            <table class="table table-sm table-striped" id="datadosen">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama Dosen</th>
                        <th>Email</th>
                        <th>Telp</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>

                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>



<script>
    function listdatadosen() {

        $(document).ready(function() {
            $('#datadosen').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'colvis',
                    'excel',
                    'pdf'
                ],
                processing: true,
                serverSide: true,
                ajax: '<?= site_url('admin/dosen/getdosen') ?>',
                order: [],
                columns: [{
                        data: 'no',
                        orderable: false
                    },
                    {
                        data: 'nip'
                    },
                    {
                        data: 'nama_dsn'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'telp'
                    },
                    {
                        data: 'nama_jabatan'
                    },
                    {
                        data: 'action',
                        orderable: false,
                    },

                ],
                "bDestroy": true

            });
        });

    }
    $(document).ready(function() {
        listdatadosen();
        $('.tomboltambah').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('admin/dosen/formtambah'); ?>",
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
        // $('.tomboltambahbanyak').click(function(e) {
        //     e.preventDefault();
        //     $.ajax({
        //         url: "<?= site_url('mahasiswa/formtambahbanyak'); ?>",
        //         dataType: "json",
        //         beforeSend: function() {
        //             $('.viewdata').html('<i class="fa fa-spin fa-spinner"></i>');
        //         },
        //         success: function(response) {
        //             $('.viewdata').html(response.data).show();
        //         },
        //         error: function(xhr, ajaxOptions, thrownError) {
        //             alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        //         }
        //     });
        // });

    });

    function edit(id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/dosen/formedit'); ?>",
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


    function hapus(id) {
        Swal.fire({
            title: 'Hapus?',
            text: `Yakin menghapus data mahasiswa ini dengan id ${id} ?`,
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
                    url: "<?= site_url('admin/dosen/hapus'); ?>",
                    data: {
                        id: id
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