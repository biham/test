<?= $this->extend('layout/main') ?>
<?= $this->extend('layout/menu') ?>
<?= $this->section('isi') ?>
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js"></script>
<div class="col-sm-12"> -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.css" />

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.js"></script> -->
<div class="page-title-box">
    <!-- <h4 class="page-title"><?= $title; ?></h4> -->
</div>
</div>

<div id="data-bimbingan" class="col-sm-12">
    <div class="card m-b-30">

        <div class="card-body">
            <div class="card-title text-center">
                <h5><?= $title; ?></h5>
                <!-- <button type="button" class="btn btn-primary btn-sm tomboltambah">
                    <i class="fa fa-plus-circle"></i> Tambah Data
                </button>
                <button type="button" class="btn btn-info btn-sm tomboltambahbanyak">
                    <i class="fa fa-plus-circle"></i> Tambah Data Banyak
                </button> -->
            </div>
            <p class="card-text viewdata">

            </p>
            <div class="table-responsive">
                <table class="table table-sm table-striped" id="databimbingan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="text-center">Judul</th>
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

<div id="detail" class="col-sm-12">
    <div class="card m-b-30">
        <form role="form" method="POST" action="" id="form-data">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="table table-borderless">
                            <table>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>:</th>
                                    <td>
                                        <p id="nama_mhs"></p>
                                    </td>

                                </tr>
                                <tr>
                                    <th>NIM</th>
                                    <th>:</th>
                                    <td>
                                        <p id="npm"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Program Studi</th>
                                    <th>:</th>
                                    <td>
                                        <p id="prodinama"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nama Pembimbing</th>
                                    <th>:</th>
                                    <td>
                                        <p id="dosen"></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="table table-borderless">
                            <table>
                                <tr>
                                    <th>Judul Penelitian</th>
                                    <th>:</th>
                                    <td>
                                        <p id="Judul"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jenis Penelitian</th>
                                    <th>:</th>
                                    <td>
                                        <p id="Jenis"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <th>:</th>
                                    <td>
                                        <div id="Status"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Action</th>
                                    <th>:</th>
                                    <td>

                                        <div id="input"></div>
                                        <div class="form-group">
                                            <div id="button"></div>
                                            <p class="h7 text-gray-dark">klik button ini jika penelitian sudah selesai</p>
                                        </div>

                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="form-inline">
                            <div id="upload"></div>

                            <form role="form" method="POST" action="" id="form-cetak">

                                <div id="input_cetak"></div>
                                <button type="button" class="btn btn-danger btn-sm ml-3" id="cetak">Cetak Laporan<i class="fas fa-print ml-2"></i></button>

                            </form>

                        </div>
                    </div>

                    <div class="col-12 table-responsive">
                        <div id="proposal"></div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-striped" id="detail-data" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="text-center">Materi</th>
                                <th>Files</th>
                                <th>Keterangan</th>
                                <th>status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <!-- <table class="table table-striped" id="detail-data">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Materi</th>
                            <th>Files</th>
                            <th>Keterangan</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table> -->
                <div class="card-body">
                    <button type="button" name="back" class="btn btn-primary float-right" onClick="data();">Back Button</button>
                </div>
            </div>

        </form>
    </div>
</div>
</div>

<!-- <div id="detail-bimbingan" class="col-sm-12">
    <div class="card m-b-30">
        <div class="card-body">
            <div class="card-title text-center">
                <h5><?= $title; ?></h5>
                <button type="button" class="btn btn-primary btn-sm tomboltambah">
                    <i class="fa fa-plus-circle"></i> Tambah Data
                </button>
                <button type="button" class="btn btn-info btn-sm tomboltambahbanyak">
                    <i class="fa fa-plus-circle"></i> Tambah Data Banyak
                </button>
            </div>
            <p class="card-text viewdata">

            </p>
            <div class="table-responsive">

        </div>
    </div>
</div> -->

<script type="text/javascript">
    // function data() {
    //     $('#databimbingan').hide();
    //     $('#form-data').hide();

    // }

    $(document).ready(function() {
        data();
        listdatabimbingan();


    });

    function listdatabimbingan() {
        $('#databimbingan').DataTable({
            // dom: 'Bfrtip',
            // buttons: [
            //     'colvis',
            //     'excel',
            //     'pdf'
            // ],
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '<?= site_url('dosen/getdatabimbingan') ?>',


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
                    data: 'nama_mhs'
                },
                {
                    data: 'prodinama',

                },
                {
                    data: 'status',
                },
                {
                    data: 'action',
                    orderable: false,
                },
            ],
            "bDestroy": true,
        });
    }

    function detail(id) {
        $(document).ready(function() {
            $('#detail-data').DataTable({
                // dom: 'Bfrtip',
                // buttons: [
                //     'colvis',
                //     'excel',
                //     'pdf'
                // ],
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '<?= site_url('dosen/detail_bimbingan') ?>',
                    data: {
                        id: id
                    }
                },
                order: [],
                columns: [{
                        data: 'no',
                        orderable: false
                    },
                    {
                        "width": "10%",
                        data: 'materi',
                    },
                    {
                        data: 'files',

                    },
                    {
                        data: 'ket',

                    },
                    {
                        data: 'status',
                    },
                    {
                        data: 'action',
                        orderable: false,
                    },
                ],
                "bDestroy": true,
            });
            form_data();
        });
    }



    // $(document).ready(function() {
    //     // get_detail_bimbingan();
    //     // $('#mydata').dataTable();
    //     // form_data()
    //     // $('.tomboltambah').click(function(e) {
    //     //     e.preventDefault();
    //     //     $.ajax({
    //     //         url: "<?= site_url('admin/proposal/formtambah'); ?>",
    //     //         dataType: "json",
    //     //         success: function(response) {
    //     //             $('.viewmodal').html(response.data).show();

    //     //             $('#modaltambah').modal('show');
    //     //         },
    //     //         error: function(xhr, ajaxOptions, thrownError) {
    //     //             alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
    //     //         }
    //     //     });
    //     // })

    // });

    function data() {
        $('#databimbingan').show();
        $('#data-bimbingan').show();
        $('#detail').show();
        $('#form-data').hide();
        $('#mydata').hide();
        $('#show_data').hide();
    }

    function form_data() {
        // $('p#hidden').empty();
        // $('p#NIM').empty();
        // $('p#NIM1').empty();
        // $('p#NIM2').empty();
        // $('p#NPP').empty();
        // $('p#Jenis').empty();
        // $('p#Judul').empty();
        // $('p#Status').empty();


        $('#form-data').show();
        $('#databimbingan').hide();
        $('#data-bimbingan').hide();
        $('#form-upload').hide();
        // $('#mydata').show();
        // $('#show_data').show();

        $('#modal-default').modal('hide')
        $('.modal-title').text('Detail Penelitian');
    }

    // function view_data1(id) {
    //     $.ajax({
    //         url: url: '<?= site_url('dosen/get_detail_bimbingan'); ?>',
    //         data: {
    //             id: id
    //         },
    //         cache: false,
    //         type: "POST",
    //         success: function(data) {
    //             // form_data();

    //             // data = JSON.parse(data);
    //             // $('p#hidden').html(data.hidden);
    //             // $('p#NIM').html(data.NIM);
    //             // $('p#NIM1').html(data.NIM1);
    //             // $('p#NIM2').html(data.NIM2);
    //             // $('p#NPP').html(data.NPP);
    //             // $('p#Jenis').html(data.Jenis);
    //             // $('p#Judul').html(data.Judul);
    //             // $('#Status').html(data.Status);
    //             // $('#proposal').html(data.proposal);
    //             // $('#button').html(data.button);
    //             // $('#input').html(data.input);
    //             // $('#input_cetak').html(data.input_cetak);
    //             // $('#upload').html(data.upload);
    //         }
    //     });
    //     // localStorage.setItem("PenelitianID", id);
    // }


    function gabung(id) {
        detail(id);
        datadetail(id);

    }

    function get_detail_bimbingan(id) {
        $.ajax({
            // $('#mydata').DataTable({
            // ajax: {
            url: '<?= site_url('dosen/get_detail_bimbingan'); ?>',
            // },
            type: "post",
            data: {
                id: id
            },
            async: true,
            dataType: "json",
            success: function(data) {

                var html = '';
                var i;
                var no = 1;
                $("#mydata").DataTable().clear();
                var length = Object.keys(data.table).length;
                for (var i = 0; i < length + 1; i++) {
                    var table = data.table[i];
                    var customer = data.table['table' + i];
                    // for (i = 0; i < data.table.length; i++) {
                    // html += '<tr>' +
                    //     '<td>' + no++ + '</td>' +
                    //     '<td>' + data.table[i].materi + '</td>' +
                    //     '<td>' + '<a href ="/assets/bimbingan/' + data.table[i].files + '">Download</a>' + '</td>' +
                    //     '<td>' + data.table[i].ket + '</td>' +
                    //     '<td>' + data.table[i].ket_2 + '</td>' +
                    //     '<td>' + data.table[i].status + '</td>' +
                    //     '<td style="text-align:right;">' +
                    //     '<a href="javascript:void(0);" class="btn btn-info btn-sm item_edit" data-product_code="' + data.table[i].product_code + '" data-product_name="' + data.table[i].product_name + '" data-price="' + data.table[i].product_price + '">Edit</a>' + ' ' +
                    //     '<a href="javascript:void(0);" class="btn btn-danger btn-sm item_delete" data-product_code="' + data.table[i].product_code + '">Delete</a>' +
                    //     '</td>' +
                    //     '</tr>';

                    // var table = data.table[i];
                    // You could also use an ajax property on the data table initialization
                    $('#mydata').dataTable().fnAddData([
                        no++,
                        table.materi,
                        table.ket,
                        table.ket_2,
                        table.ket_2,
                        // '<a href="javascript:void(0);" class="btn btn-danger btn-sm item_delete" data-product_code="' + data.table[i].materi + '">Delete</a>'

                    ]);
                }
                // $('#show_data').html(html);
                // form_data();
                console.log(table.materi);

            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });


    }

    function datadetail(id) {
        $.ajax({
            // $('#mydata').DataTable({
            // ajax: {
            url: '<?= site_url('dosen/get_detail_bimbingan'); ?>',
            // },
            type: "post",
            data: {
                id: id
            },
            async: true,
            dataType: "json",
            success: function(data) {

                $('p#hidden').html(data.hidden);
                $('#nama_mhs').html(data.table[0].ket);
                $('p#NIM1').html(data.NIM1);


                console.log(data.table[0].ket);

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