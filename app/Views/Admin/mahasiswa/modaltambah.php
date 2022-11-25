<!-- Modal -->
<div class="modal fade" id="modaltambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Mahasiswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('admin/mahasiswa/simpandata', ['class' => 'formmahasiswa']) ?>
            <?= csrf_field() ?>
            <form>
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">NPM</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="npm" name="npm" maxlength="7">
                            <div class="invalid-feedback errornpm">

                            </div>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Nama Mahasiswa</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="nama" name="nama">
                            <div class="invalid-feedback errorNama">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-6">
                            <select name="jenkel" id="jenkel" class="form-control">
                                <option value="">--Pilih--</option>
                                <option value="L">laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Prodi</label>
                        <div class="col-sm-6">
                            <select name="prodi" id="prodi" class="form-control">
                                <option value="">--Pilih--</option>
                                <?php foreach ($prodi as $m) : ?>
                                    <option value="<?= $m['prodiid']; ?>">
                                        <?= $m['prodinama']; ?>
                                    </option>
                                <?php endforeach ?>

                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btnsimpan">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.formmahasiswa').submit(function(e) {
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
                    if (response.error) {
                        if (response.error.npm) {
                            $('#npm').addClass('is-invalid');
                            $('.errornpm').html(response.error.npm);
                        } else {
                            $('#npm').removeClass('is-invalid');
                            $('.errornpm').html('');
                        }

                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errorNama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.errorNama').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses
                        })
                        $('#modaltambah').modal('hide');
                        datamahasiswa();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }

            });
            return false;
        });
    });
</script>