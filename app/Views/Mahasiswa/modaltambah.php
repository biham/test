<!-- Modal -->
<div class="modal fade" id="modaltambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Proposal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('mahasiswa/simpandata', ['class' => 'formtambah']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Judul Proposal</label>
                        <div class="col-sm-10">
                            <textarea id="judul" class="form-control" maxlength="225" name="judul" rows="2"></textarea>
                            <div class="invalid-feedback errorjudul">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <textarea id="textarea" class="form-control" maxlength="225" name="ket" rows="3" placeholder=""></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="file" class="form-control" id="files" name="files">
                                <div class="invalid-feedback errorfiles">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btnsimpan">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                    <?= form_close() ?>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.formtambah').submit(function(e) {
                e.preventDefault();
                let form = $('.formtambah')[0];

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
                        $('.btnsimpan').prop('disable', 'disabled');
                        $('.btnsimpan').html(`<i class="fa fa-spin fa-spinner"></i>`);

                    },
                    complete: function(e) {
                        $('.btnsimpan').removeAttr('disable', 'disabled');
                        $('.btnsimpan').html(`Simpan`);
                    },
                    success: function(response) {
                        if (response.error) {
                            if (response.error.files) {
                                $('#files').addClass('is-invalid');
                                $('.errorfiles').html(response.error.files);
                            } else {
                                $('#files').removeClass('is-invalid');
                                $('.errorfiles').html('');
                            }
                            if (response.error.judul) {
                                $('#judul').addClass('is-invalid');
                                $('.errorjudul').html(response.error.judul);

                            } else {
                                $('#judul').removeClass('is-invalid');
                                $('.errorjudul').html('');
                            }
                        } else {
                            Swal.fire({
                                icon: 'success',
                                tittle: 'berhasil',
                                text: response.sukses,
                            })
                            $('#modaltambah').modal('hide');
                            listdataproposal();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });
        });
    </script>