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
                        <th>Username</th>
                        <th>Userlevel</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <div class="viewmodal" style="display: none;"></div>
    </div>
</div>


<script>
    function listusers() {
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
                ajax: '<?= site_url('admin/users/getdata') ?>',
                order: [],
                columns: [{
                        data: 'no',
                        orderable: false
                    },
                    {
                        data: 'username',
                    },
                    {
                        data: 'levelnama',
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
        listusers();

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


    function hapus(id) {
        Swal.fire({
            title: '',
            text: `ingin menghapus data ?`,
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
                    url: "<?= site_url('admin/users/hapus'); ?>",
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
                            listusers();
                        }

                    }
                });
            }
        })
    }
</script>
<?= $this->endsection('') ?>