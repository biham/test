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
        <a href="<?= site_url('admin/mahasiswa') ?>"><i class="fa fa-user-o"></i>Mahasiswa</a>
    </li>
    <li class="has-submenu">
        <a href="<?= site_url('admin/dosen') ?>"><i class="fa fa-user-o"></i>Dosen</a>
    </li>
    <li class="has-submenu">
        <a href="<?= site_url('admin/proposal') ?>"><i class="fa fa-folder-open-o"></i>Proposal</a>
    </li>
    <li class="has-submenu">
        <a href="<?= site_url('admin/tahunakademik') ?>"><i class="fa fa-calendar-o"></i>Tahun Akademik</a>
    </li>
    <li class="has-submenu">
        <a href="<?= site_url('admin/users') ?>"><i class="fa fa-calendar-o"></i>User Management</a>
    </li>
<?php endif; ?>


<?php if ($session->idlevel == 2) : ?>
    <li class="has-submenu">
        <a href="<?= site_url('mahasiswa/index') ?>"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
    </li>
    <li class="has-submenu">
        <a href="<?= site_url('dataku/index') ?>"><i class="fa fa-user-circle" aria-hidden="true"></i>Profil</a>
    </li>
    <li class="has-submenu">
        <a href="<?= site_url('mahasiswa/judul') ?>"><i class="fa fa-folder-open-o"></i>Proposal</a>
    </li>
    <li class="has-submenu">
        <a href="<?= site_url('bimbingan/index') ?>"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i>Bimbingan</a>
    </li>
<?php endif; ?>
<?php if ($session->idlevel == 3) : ?>
    <li class="has-submenu">
        <a href="<?= site_url('dosen/index') ?>"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
    </li>
    <li class="has-submenu">
        <a href="<?= site_url('bimbingan/index') ?>"><i class="fa fa-calendar" aria-hidden="true"></i>Bimbingan</a>
    </li>
    <li class="has-submenu">
        <a href="<?= site_url('dosen/bimbingan') ?>"><i class="fa fa-calendar" aria-hidden="true"></i>Bimbingan D</a>
    </li>
<?php endif; ?>

<?= $this->endSection() ?>