<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Mahasiswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('admin/mahasiswa/updatedata', ['class' => 'formmahasiswa']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="id" value="<?= $mhs['id']; ?>">
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">NPM</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="npm" name="npm" value="<?= $mhs['npm']; ?>" readonly>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Nama Mahasiswa</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= $mhs['nama_mhs']; ?>">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-6">
                            <select name="jenkel" id="jenkel" class="form-control">
                                <option value="L" <?php if ($jenkel == 'L') echo "selected"; ?>>Laki-Laki</option>
                                <option value="P" <?php if ($jenkel == 'P') echo "selected"; ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Prodi</label>
                        <div class="col-sm-6">
                            <select name="mhsprodiid" id="mhsprodiid" class="form-control">
                                <?php foreach ($prodi as $ngr) { ?>
                                    <option <?= $ngr['prodiid'] == $mhs['mhsprodiid'] ? 'selected=selected' : null ?> value="<?= $ngr['prodiid'] ?>"><?= $ngr['prodinama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btnsimpan">Update</button>
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
                    $('.btnsimpan').html('Update');
                },
                success: function(response) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.sukses

                    })
                    $('#modaledit').modal('hide');
                    datamahasiswa();

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }

            });
            return false;
        });
    });
</script>