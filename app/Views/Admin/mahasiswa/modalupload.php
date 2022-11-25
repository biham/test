<!-- Modal -->
<div class="modal fade" id="modalupload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('', ['class' => 'formupload']) ?>
            <?= csrf_field() ?>
            <input type="hidden" value="<?= $npm; ?>" name="npm">
            <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">Upload Foto</label>
                        <div class="col-sm-4">
                            <input type="file" class="form-control" id="foto" name="foto">
                            <div class="invalid-feedback errorfoto">

                            </div>

                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnupload">Upload</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.btnupload').click(function(e) {
            e.preventDefault();

            let form = $('.formupload')[0];

            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: "<?= site_url('admin/mahasiswa/doupload'); ?>",
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
                        if (response.error.foto) {
                            $('#foto').addClass('is-invalid');
                            $('.errorfoto').html(response.error.foto);

                        }

                    } else {
                        Swal.fire({
                            icon: 'success',
                            tittle: 'berhasil',
                            text: response.sukses,
                        })
                        $('#modalupload').modal('hide');
                    }

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });

        });
    });
</script>