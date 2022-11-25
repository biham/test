<?= $this->extend('layout/main') ?>
<?= $this->extend('layout/menu') ?>
<?= $this->section('isi') ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js"></script>
<div class="col-sm-12">
    <div class="page-title-box">
        <!-- <h4 class="page-title"><?= $title; ?></h4> -->
    </div>
</div>

<div class="col-sm-12">
    <div class="card m-b-30">

        <div class="card-body">
            <div class="card-title text-center">
                <h5><?= $title; ?></h5>
                <!-- <button type="button" class="btn btn-primary btn-sm tomboltambah">
                    <i class="fa fa-plus-circle"></i> Tambah Data
                </button> -->
                <!-- <button type="button" class="btn btn-info btn-sm tomboltambahbanyak">
                    <i class="fa fa-plus-circle"></i> Tambah Data Banyak
                </button> -->
            </div>
            <p class="card-text viewdata">

            </p>
            <!-- <div class="table-responsive"> -->
            <table class="table table-sm table-striped" id="datadosen">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="text-center">Judul</th>
                        <th>Download Judul</th>
                        <th>Nama Mahaiswa</th>
                        <th>Prodi</th>
                        <th>status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<div class="viewmodal" style="display: none;"></div>



<script>
    function listdataproposal() {
        $(document).ready(function() {
            $('#datadosen').DataTable({
                // dom: 'Bfrtip',
                // buttons: [
                //     'colvis',
                //     'excel',
                //     'pdf'
                // ],
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '<?= site_url('dosen/getdata') ?>',
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

                                return '<a href="' + data + '" download>Download</a>';
                            }

                            return data;
                        },
                    },
                    {
                        data: 'nama_mhs'
                    },
                    {
                        data: 'prodinama',

                    },
                    {
                        data: 'status',
                        "render": function(data, type, row) {
                            if (row.status == '1') {
                                return '<span class="badge badge-primary">di terima</badge>';
                            } else if (row.status == '2') {
                                return '<span class="badge badge-warning">di tolak</badge>';
                            } else {
                                return '<span class="badge badge-warning">Menunggu Kofirmasi</badge>';
                            }
                        }

                    },
                    {
                        data: 'action',
                        orderable: false,

                    },

                ],
                "bDestroy": true,


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


    function terima(id_judul) {
        Swal.fire({
            title: 'Yakin?',
            text: `ingin menerima proposal ini ?`,
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
                    url: "<?= site_url('dosen/terima'); ?>",
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

    function tolak(id_judul) {
        Swal.fire({
            title: 'Yakin?',
            text: `ingin menolak proposal ini ?`,
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
                    url: "<?= site_url('dosen/tolak'); ?>",
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