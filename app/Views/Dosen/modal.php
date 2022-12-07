<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="example-text-input" class="col-sm-2 col-form-label">Materi</label>
                        <div class="col-sm-10">
                            <select name="materi" id="materi" class="form-control">
                                <option value="">--Pilih--</option>
                                <option value="BAB I">BAB I</option>
                                <option value="BAB II">BAB II</option>
                                <option value="BAB III">BAB III</option>
                                <option value="BAB IV">BAB IV</option>
                            </select>
                            <div class="invalid-feedback errormateri">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <textarea id="ket" class="form-control" maxlength="225" name="ket" id="ket" rows="3" placeholder=""></textarea>
                            <div class="invalid-feedback errorket">

                            </div>
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
                    url: "<?= site_url('bimbingan/simpandata'); ?>",
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
                            if (response.error.materi) {
                                $('#materi').addClass('is-invalid');
                                $('.errormateri').html(response.error.materi);

                            } else {
                                $('#materi').removeClass('is-invalid');
                                $('.errormateri').html('');
                            }
                            if (response.error.ket) {
                                $('#ket').addClass('is-invalid');
                                $('.errorket').html(response.error.ket);

                            } else {
                                $('#ket').removeClass('is-invalid');
                                $('.errorket').html('');
                            }
                        } else {
                            Swal.fire({
                                icon: 'success',
                                tittle: 'berhasil',
                                text: response.sukses,
                            })
                            $('#modaltambah').modal('hide');
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