<?= $this->extend('layout/main') ?>
<?= $this->extend('layout/menu') ?>
<?= $this->section('isi') ?>
<div class="col-sm-12">
    <div class="page-title-box">

    </div>
</div>

<div class="col-sm-12">
    <div class="row">
        <div class="col-md-1 col-lg-2 col-xl-3">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="col-3 align-self-center">
                            <div class="round">
                                <i class="mdi mdi-account-multiple-plus"></i>
                            </div>
                        </div>
                        <div class="col-8 text-center align-self-center">
                            <div class="m-l-10 ">
                                <h5 class="mt-0 round-inner"><?= $mhs; ?></h5>
                                <p class="mb-0 text-muted">Jumlah Mahasiswa</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1 col-lg-2 col-xl-3">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="col-3 align-self-center">
                            <div class="round">
                                <i class="mdi mdi-account-multiple-plus"></i>
                            </div>
                        </div>
                        <div class="col-8 text-center align-self-center">
                            <div class="m-l-10 ">
                                <h5 class="mt-0 round-inner"><?= $dsn; ?></h5>
                                <p class="mb-0 text-muted">Jumlah Dosen</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endsection('') ?>