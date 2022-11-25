<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Dosen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('admin/dosen/updatedata', ['class' => 'formdosen']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <form>
                    <input type="hidden" id="id" name="id" value="<?= $dosen['id']; ?>">
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">NIP</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="nip" name="nip" value="<?= $dosen['nip']; ?>" readonly>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Nama Dosen</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= $dosen['nama_dsn']; ?>">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" id="email" name="email" value="<?= $dosen['email']; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Telp</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="telp" name="telp" value="<?= $dosen['telp']; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-6">
                            <select name="jabatan" id="jabatan" class="form-control">
                                <option value="">--Pilih--</option>
                                <?php foreach ($jabatan as $ngr) { ?>
                                    <option <?= $ngr['id_jabatan'] == $dosen['id_jabatan'] ? 'selected=selected' : null ?> value="<?= $ngr['id_jabatan'] ?>"><?= $ngr['nama_jabatan'] ?></option>
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
        $('.formdosen').submit(function(e) {
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
                    listdatadosen();

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }

            });
            return false;
        });
    });
</script>