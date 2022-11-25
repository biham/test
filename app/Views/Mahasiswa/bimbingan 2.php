<?= $this->extend('layout/main') ?>
<?= $this->extend('layout/menu') ?>
<?= $this->section('isi') ?>


<!-- <div class="card-body">
    <div class="card" style="width: 50%;">
        <hr>
        <h5 class="text-center">
            List Jadwal Bimbingan
        </h5>
        <hr>
        <div class="card-body">

            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quicard's content.</p>
            <button type="submit" class="btn btn-primary btn-sm">Apply </button>
        </div>
    </div>
</div> -->

<div class="row mt-5 ml-5">

    <div class="card">
        <h5 class="text-center">Bimbingan</h5>
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Pembimbing</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($jadwal as $jadwal) : ?>
                    <tr>
                        <td>
                            <?= $no++;  ?>
                        </td>
                        <td>
                            <?= esc($jadwal['id_dosen']) ?>
                        </td>
                        <td>
                            <?= esc($jadwal['tgl']) ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary btnapply" onclick="apply(<?= $jadwal['id'] ?>)">Apply</button>
                        </td>

                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<div class=" viewmodal" style="display: none;">
</div>

<script>
    $(document).ready(function() {
        $('.btnsimpan').click(function(e) {
            e.preventDefault();

            let form = $('.formupload')[0];

            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: "<?= site_url('mahasiswa/simpandata'); ?>",
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function(e) {
                    $('.btnupload').prop('disable', 'disabled');
                    $('.btnupload').html(`<i class="fa fa-spin fa-spinner"></i>`);

                },
                complete: function(e) {
                    $('.btnupload').removeAttr('disable', 'disabled');
                    $('.btnupload').html(`upload`);
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

    function apply(id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('mahasiswa/apply'); ?>",
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
</script>
<?= $this->endsection('') ?>