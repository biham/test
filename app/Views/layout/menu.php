<?= $this->extend('layout/main') ?>

<?= $this->section('menu') ?>

<li class="has-submenu">
    <a href="<?= site_url('layout/index') ?>"><i class="mdi mdi-airplay"></i>Beranda</a>
</li>

<?php
$session = \Config\Services::session();
if ($session->idlevel == 1) :
?>
    <li class="has-submenu">
        <a href="<?= site_url('admin/mahasiswa') ?>"><i class="fa-user-circle-o"></i>Mahasiswa</a>
    </li>
    <li class="has-submenu">
        <a href="<?= site_url('admin/dosen') ?>"><i class="fa fa-user-o"></i>Dosen</a>
    </li>
    <li class="has-submenu">
        <a href="<?= site_url('admin/proposal') ?>"><i class="mdi mdi-file-outline"></i>Proposal</a>
    </li>
    <li class="has-submenu">
        <a href="<?= site_url('admin/tahunakademik') ?>"><i class="mdi mdi-file-outline"></i>Tahun Akademik</a>
    </li>
<?php endif; ?>


<?php if ($session->idlevel == 2) : ?>
    <li class="has-submenu">
        <a href="<?= site_url('mahasiswa/index') ?>">Home</a>
    </li>
    <li class="has-submenu">
        <a href="<?= site_url('dataku/index') ?>">Data Ku</a>
    </li>
    <li class="has-submenu">
        <a href="<?= site_url('mahasiswa/judul') ?>">Proposal</a>
    </li>
    <li class="has-submenu">
        <a href="<?= site_url('bimbingan/index') ?>">Bimbingan</a>
    </li>
<?php endif; ?>
<?php if ($session->idlevel == 3) : ?>
    <li class="has-submenu">
        <a href="<?= site_url('dosen/index') ?>">Home</a>
    </li>
    <li class="has-submenu">
        <a href="<?= site_url('bimbingan/index') ?>">Bimbingan</a>
    </li>
<?php endif; ?>

<?= $this->endSection() ?>