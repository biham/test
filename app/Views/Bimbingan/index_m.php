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
            <?php if ($cek == null) : ?>

                <button type="button" class="btn btn-primary btn-sm tomboltambah" hidden>
                    <i class="fa fa-plus-circle"></i> Tambah Data
                </button>

            <?php endif ?>
            <?php if ($cek !== null) : ?>

                <button type="button" class="btn btn-primary btn-sm tomboltambah">
                    <i class="fa fa-plus-circle"></i> Tambah Data
                </button>

            <?php endif ?>
            <p class="card-text viewdata">

            </p>
            <table class="table table-sm table-striped" id="bimbingan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="text-center">Materi</th>
                        <th>Keterangan</th>
                        <th>Keterangan Dosen</th>
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
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'pdfHtml5',
                    orientation: 'potrait',
                    pageSize: 'A4',
                    title: 'TIC TICKET REPORT',
                    blank: 'yes',
                    download: 'open',
                    exportOptions: {
                        // content: [
                        //     'Bulleted list example:',
                        //     {
                        //         // to treat a paragraph as a bulleted list, set an array of items under the ul key
                        //         ul: [
                        //             'Item 1',
                        //             'Item 2',
                        //             'Item 3',
                        //             {
                        //                 text: 'Item 4',
                        //                 bold: true
                        //             },
                        //         ]
                        //     },
                        //     {
                        //         columns: [
                        //             [0, 1, 2, 3, 5]
                        //         ]
                        //     }
                        // ]
                    },
                    customize: function(doc) {
                        doc.defaultStyle.fontSize = 12; //2, 3, 4,etc //2, 3, 4,etc
                        doc.defaultStyle.alignment = 'center';
                        doc.styles.tableHeader.fontSize = 12; //2, 3, 4, etc
                        // doc.content[1].table.widths = ['5%', '10%', '15%', '15%',
                        //     '14%', '14%', '14%', '14%'
                        // ];
                        // doc.content[1].table = {
                        //     headerRows: 1,
                        //     widths: ['10%', 'auto', 'auto', '*'],

                        //     body: [
                        //         ['First', 'Second', 'Third', 'The last one'],
                        //     ],
                        //     columns: [0, 1, 2, 3, 5],
                        // }
                        doc = {
                            content: [
                                'Bulleted list example:',
                                {
                                    // to treat a paragraph as a bulleted list, set an array of items under the ul key
                                    ul: [
                                        'Item 1',
                                        'Item 2',
                                        'Item 3',
                                        {
                                            text: 'Item 4',
                                            bold: true
                                        },
                                    ]
                                },

                                'Numbered list example:',
                                {
                                    // for numbered lists set the ol key
                                    ol: [
                                        'Item 1',
                                        'Item 2',
                                        'Item 3'
                                    ]
                                }
                            ]
                        };
                    }

                }],

                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= site_url('bimbingan/getdata_m') ?>',
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
                        "width": "20%",
                        data: 'ket',
                    },
                    {
                        "width": "20%",
                        data: 'ket_2',

                    },
                    {
                        data: 'files_2',
                        "render": function(data, type, row) {
                            if (data === null || data === '') {
                                return 'Tidak ada file';
                                // let link = 'files_2';
                                // return '<a href="/assets/bimbingan/' + data + '" blank>download</a>';

                            } else {
                                // return 'tidak ada file';
                                let link = 'files_2';
                                return '<a href="/assets/bimbingan/' + data + '" blank>download</a>';


                            };

                        },
                    },
                    {
                        data: 'status',
                        "render": function(data, type, row) {
                            if (row.status === '0') {
                                return '<span class="badge badge-primary">Menunggu Konfirmasi</badge>';
                            } else if (row.status === '1') {
                                return '<span class="badge badge-success">Valid</badge>';
                            } else {
                                return '<span class="badge badge-warning">Tidak Valid</badge>';
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

    function edit(id_judul) {
        $.ajax({
            type: "post",
            url: "<?= site_url('bimbingan/formedit'); ?>",
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


    function hapus(id) {
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
                            listdatabimbingan();
                        }

                    }
                });
            }
        })
    }
</script>
<?= $this->endsection('') ?>