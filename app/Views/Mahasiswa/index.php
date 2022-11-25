<?= $this->extend('layout/main') ?>
<?= $this->extend('layout/menu') ?>
<?= $this->section('isi') ?>

<div class="card-body">

</div>

<div class="col-sm-12">

    <div class="row">
        <div class="col-sm-12">
            <div class="card-body">
                <div class="card border-success">
                    <div class="card-header text-center">Judul Proposal</div>
                    <div class="card-body">
                        <p class="card-text">
                        <h5 class="text-center">
                            <?= strtoupper($judul);

                            ?></p>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="card-body">
                <div class="card border-success">
                    <div class="card-header text-center">Pembimbing</div>
                    <div class="card-body">
                        <p class="card-text">
                        <h5>
                            <?= $dospem; ?>
                        </h5>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card-body">
                <div class="card border-success">
                    <div class="card-header text-center">Jumlah Bimbingan</div>
                    <div class="card-body">
                        <p class="card-text">
                        <h5>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis sed quia sequi harum ut dolores cum nulla qui itaque recusandae, in at iusto deleniti voluptatum, quaerat quae saepe nihil distinctio?
                        </h5>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<?= $this->endsection('') ?>