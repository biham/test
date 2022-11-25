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
            <?= form_open_multipart('bimbingan/formedit_d', ['class' => 'formedit']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="id" value="<?= $bimbingan['id']; ?>">
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Materi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="materi" name="materi" value="<?= $bimbingan['materi']; ?>">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Catatan Bimbingan</label>
                        <div class="col-sm-10">
                            <textarea id="ket_2" class="form-control" maxlength="225" name="ket_2" rows="3"><?= $bimbingan['ket_2']; ?></textarea>
                            <div class="invalid-feedback errorket">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Berkas Bimbingan</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="files_2" name="files_2" value="<?= $bimbingan['files_2']; ?>">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Materi</label>
                        <div class="col-sm-10">
                            <select name="status" id="" class="form-control">
                                <option value="">--Pilih--</option>
                                <option value="1">Valid</option>
                                <option value="2">Tidak valid</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btnupdate">Update</button>
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
        $('.btnupdate').click(function(e) {
            e.preventDefault();

            let form = $('.formedit')[0];

            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: "<?= site_url('bimbingan/update_d'); ?>",
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function(e) {
                    $('.btnupdate').prop('disable', 'disabled');
                    $('.btnupdate').html(`<i class="fa fa-spin fa-spinner"></i>`);

                },
                complete: function(e) {
                    $('.btnupdate').removeAttr('disable', 'disabled');
                    $('.btnupdate').html(`upload`);
                },
                success: function(response) {
                    if (response.error) {

                    } else {
                        Swal.fire({
                            icon: 'success',
                            tittle: 'berhasil',
                            text: response.sukses,
                        })
                        $('#modaledit').modal('hide');
                        listdatabimbingan();
                    }

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });

        });
    });
</script>