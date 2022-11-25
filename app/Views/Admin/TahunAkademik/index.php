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
    <div class="row">
        <div class="col-sm-6">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="card-title text-center">
                        <h5>Tambah Tahun</h5>
                    </div>

                    <?= form_open('admin/tahunakademik/simpandata', ['class' => 'tambahdata']) ?>
                    <?= csrf_field() ?>
                    <form>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Tahun</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="tahun" id="tahun"></textarea>
                                <div class="invalid-feedback errortahun">

                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Semester</label>
                            <div class="col-sm-10">
                                <select name="semester" id="semester" class="form-control">
                                    <option value="">--silahkan pilih--</option>
                                    <option value="1">Ganjil</option>
                                    <option value="2">Genap</option>
                                </select>
                                <div class="invalid-feedback errorsemester">

                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="statuss" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <select name="statuss" id="statuss" class="form-control">
                                    <option value="">--silahkan pilih--</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                                <div class="invalid-feedback errorstatuss">

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-primary btnsimpan">Simpan</button>
                            <button type="reset" class="btn btn-sm btn-primary">Reset</button>
                        </div>
                    </form>
                    <?= form_close() ?>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
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
                    <table class="table table-sm table-striped" id="datatahun">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="text-center">Tahun Akademik</th>
                                <th>Semester</th>
                                <th>Status</th>
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
    </div>
</div>


<script>
    function listdatatahun() {
        $(document).ready(function() {
            $('#datatahun').DataTable({
                // dom: 'Bfrtip',
                // buttons: [
                //     'colvis',
                //     'excel',
                //     'pdf'
                // ],
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '<?= site_url('admin/tahunakademik/getdata') ?>',
                order: [],
                columns: [{
                        data: 'no',
                        orderable: false
                    },
                    {
                        data: 'tahunakademik',
                    },
                    {
                        data: 'semester',
                        "render": function(data, type, row) {
                            if (row.semester == '1') {
                                return 'Ganjil';
                            } else {
                                return 'Genap';
                            }
                        }
                    },
                    {
                        data: 'status',
                        "render": function(data, type, row) {
                            if (row.status == '1') {
                                return '<span class="badge badge-success">Aktif</badge>';
                            } else {
                                return '<span class="badge badge-warning">Tidak Aktif</badge>';
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
        listdatatahun();

        $('.tambahdata').submit(function(e) {
            e.preventDefault();
            let form = $('.tambahdata')[0];

            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: "<?= site_url('admin/tahunakademik/simpandata'); ?>",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnsimpan').attr('disable', 'disabled');
                    $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"> </i>');
                },
                complete: function() {
                    $('.btnsimpan').removeAttr('disable');
                    $('.btnsimpan').html('Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.tahun) {
                            $('#tahun').addClass('is-invalid');
                            $('.errortahun').html(response.error.tahun);
                        } else {
                            $('#tahun').removeClass('is-invalid');
                            $('.errortahun').html('');
                        }
                        if (response.error.statuss) {
                            $('#statuss').addClass('is-invalid');
                            $('.errorstatuss').html(response.error.statuss);
                        } else {
                            $('#statuss').removeClass('is-invalid');
                            $('.errorstatuss').html('');
                        }
                        if (response.error.semester) {
                            $('#semester').addClass('is-invalid');
                            $('.errorsemester').html(response.error.semester);
                        } else {
                            $('#semester').removeClass('is-invalid');
                            $('.errorsemester').html('');
                        }

                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses
                        })
                        listdatatahun();
                    }

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }

            });
            return false;
        });

    });

    function edit(TahunAkademikID) {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/tahunakademik/formedit'); ?>",
            data: {
                id: TahunAkademikID
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


    function aktif_tahun(tahunakademikid) {
        Swal.fire({
            title: '',
            text: `ingin mengaktifkan tahun akademik ?`,
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
                    url: "<?= site_url('admin/tahunakademik/aktif_tahun'); ?>",
                    data: {
                        tahunakademikid: tahunakademikid
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.sukses,
                            });
                            listdatatahun();
                        }

                    }
                });
            }
        })
    }
</script>
<?= $this->endsection('') ?>