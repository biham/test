<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Proposal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('admin/proposal/updatedata', ['class' => 'formproposal']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="id_judul" value="<?= $proposal['id_judul']; ?>">
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Judul proposal</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="judul" name="judul" value="<?= $proposal['judul']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Nama Mahasiswa</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="" name="" value="<?= $proposal['nama_mhs']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Prodi</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="" name="" value="<?= $proposal['prodinama']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Desen Pembimbing</label>
                        <div class="col-sm-6">
                            <select name="id_dosen" id="id_dosen" class="form-control">
                                <option value="">--Pilih--</option>
                                <?php foreach ($dosen as $dsn) { ?>
                                    <option <?= $dsn['id'] == $proposal['id_dosen'] ? 'selected=selected' : null ?> value="<?= $dsn['id'] ?>"><?= $dsn['nama_dsn'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">status</label>
                        <div class="col-sm-6">
                            <select name="status" id="" class="form-control">
                                <option value="">--Pilih--</option>
                                <option value="0">Di tolak</option>
                                <option value="1">Di terima</option>
                            </select>
                        </div>
                    </div> -->
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
        $('.formproposal').submit(function(e) {
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
                    listdataproposal();

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }

            });
            return false;
        });
    });
</script>