<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Tahun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('tahunakademik/updatedata', ['class' => 'tahun']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="id" value="<?= $tahun['TahunAkademikID']; ?>">
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Tahun Akademik</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="tahun" name="tahun" value="<?= $tahun['TahunAkademik']; ?>">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Semester</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="semester" name="semester" value="<?= $tahun['Semester']; ?>">

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-6">
                            <select name="status" id="statuss" class="form-control">
                                <option value="L" <?php if ($tahun == '1') echo "selected"; ?>>Aktif</option>
                                <option value="P" <?php if ($tahun == '0') echo "selected"; ?>>Tidak Aktif</option>
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
        $('.tahun').submit(function(e) {
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