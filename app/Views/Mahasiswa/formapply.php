<!-- Button trigger modal -->
<?= $this->extend('layout/main') ?>
<?= $this->extend('layout/menu') ?>
<?= $this->section('isi') ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js"></script>
<div class="col-sm-12">
    <div class="page-title-box">
        <h4 class="page-title"></h4>
    </div>
</div>

<div class="col-sm-12">
    <div class="card m-b-30">

        <div class="card-body">
            <div class="card-title">
                <h5 class="text-center"><?= $title; ?></h5>
                <button type="button" class="btn btn-primary btn-sm tomboltambah">
                    <i class="fa fa-plus-circle"></i> Tambah Data
                </button>
                <!-- <button type="button" class="btn btn-info btn-sm tomboltambahbanyak">
                    <i class="fa fa-plus-circle"></i> Tambah Data Banyak
                </button> -->
            </div>
            <p class="card-text viewdata">
            <div class="form-group">
                <label for="Filter"></label>
                <select name="id_mahasiswa" id='id_mahasiswa' class="form-control">
                    <option value="">--plih--</option>
                    <?php foreach ($getdata as $data) : ?>
                        <option value="<?= $data['id_mahasiswa']; ?>"><?= $data['id_mahasiswa']; ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            </p>
            <table class="table table-sm table-striped" id="datadosen">
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
    function listdataskripsi() {
        $(document).ready(function() {
            table = $('#datadosen').DataTable({
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
                    url: '<?= site_url('admin/skripsi/getskripsi') ?>',
                    data: function(d) {
                        d.id_mahasiswa = $('#id_mahasiswa').val();
                    }
                },

                order: [],
                columns: [{
                        data: 'no',
                        orderable: false
                    },
                    {
                        "width": "30%",
                        data: 'judul_skripsi',
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
                            if (row.status == '1') {
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
        listdataskripsi();
        $('.tomboltambah').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('admin/skripsi/formtambah'); ?>",
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
            url: "<?= site_url('admin/skripsi/formedit'); ?>",
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
            text: `Yakin menghapus data skripsi ini dengan nobp ${judul} ?`,
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
                    url: "<?= site_url('admin/skripsi/hapus'); ?>",
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


<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Apply Bimbingan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('mahasiswa/applybimbingan', ['class' => 'formapply']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="col-lg">
                    <form>
                        <input type="hidden" name="id" value="<?= $bimbingan['id']; ?>">
                        <div class=" form-group row">
                            <label for="" class="col-sm-2 col-form-label">Tanggal Bimbingan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="nobp" name="nobp" value="<?= $bimbingan['tgl']; ?>" readonly>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Materi</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="nama" name="materi">

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Keterangan</label>
                            <div class="col-sm-6">
                                <textarea id="ket" name="ket" class="form-control" rows="5" cols="20"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Dokumen</label>
                            <div class="col-sm-6">
                                <input type="file" id="files" name="files">
                                <div class="invalid-feedback errorfiles">

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btnsimpan">Apply</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        <?= form_close() ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.btnsimpan').click(function(e) {
                e.preventDefault();

                let form = $('.formapply')[0];

                let data = new FormData(form);
                $.ajax({
                    type: "post",
                    url: "<?= site_url('mahasiswa/applybimbingan'); ?>",
                    data: data,
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    cache: false,
                    dataType: "json",
                    beforeSend: function(e) {
                        $('.btnsimpan').prop('disable', 'disabled');
                        $('.btnsimpan').html(`<i class="fa fa-spin fa-spinner"></i>`);

                    },
                    complete: function(e) {
                        $('.btnsimpan').removeAttr('disable', 'disabled');
                        $('.btnsimpan').html(`upload`);
                    },
                    success: function(response) {
                        if (response.error) {
                            if (response.error.files) {
                                $('#files').addClass('is-invalid');
                                $('.errorfiles').html(response.error.files);

                            }

                        } else {
                            Swal.fire({
                                icon: 'success',
                                tittle: 'berhasil',
                                text: response.sukses,
                            })
                            window.location = 'index';
                        }

                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });

            });
        });
    </script>
    <?= $this->endsection('') ?>