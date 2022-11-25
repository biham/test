<?= $this->extend('layout/main') ?>
<?= $this->extend('layout/menu') ?>
<?= $this->section('isi') ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<div class="col-sm-12">
    <div class="row">
        <div class="card-body">
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="card m-b-30">
        <hr>
        <h5 class="text-center">Input Jadwal Bimbingan</h5>
        <hr>
        <div class="card-body">
            <?= form_open('dosen/simpandata', ['class' => 'formbimbingan']) ?>
            <?= csrf_field() ?>
            <form>
                <div class="card-body">
                    <div>
                        <h6 class="text-muted fw-400">input tangal</h6>
                        <div class="input-group">
                            <input type="text" class="form-control" id="datepicker" name="tgl">
                            <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary btnsimpan">Upload</button>
                </div>
            </form>
            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });

    });

    $(document).ready(function() {
        $('.formbimbingan').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.sukses
                    })
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }



            });
            return false;
        });
    });
</script>
<?= $this->endsection('') ?>