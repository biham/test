<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Layout');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'auth\auth::index');
// $routes->get('mahasiswa', 'Mahasiswa::index');
// $routes->get('/mahasiswa', 'Mahasiswa::index', ['filter' => 'ceklogin']);
// $routes->get('/mahasiswa/(:any)', 'Mahasiswa::$1', ['filter' => 'ceklogin']);
$routes->group('admin', ['namespace' => '\App\Controllers\Admin'], function ($routes) {
    //mahasiswa index
    $routes->get('mahasiswa', 'Mahasiswa::index', ['filter' => 'ceklogin']);
    $routes->get('mahasiswa/index', 'Mahasiswa::index', ['filter' => 'ceklogin']);
    //mahasiswa data
    $routes->get('mahasiswa/ambildata', 'Mahasiswa::ambildata', ['filter' => 'ceklogin']);
    $routes->get('mahasiswa/(:any)', 'Mahasiswa::$1', ['filter' => 'ceklogin']);
    $routes->post('mahasiswa/listdata', 'Mahasiswa::listdata');
    //mahasiswa crud
    $routes->get('mahasiswa/formtambah', 'Mahasiswa::formtambah');
    $routes->post('mahasiswa/simpandata', 'Mahasiswa::simpandata');
    $routes->post('mahasiswa/formedit', 'Mahasiswa::formedit');
    $routes->post('mahasiswa/updatedata', 'Mahasiswa::updatedata');
    $routes->post('mahasiswa/hapus', 'Mahasiswa::hapus');
});
$routes->group('admin', ['namespace' => '\App\Controllers\Admin'], function ($routes) {
    //dosen index
    $routes->get('dosen', 'dosen::index', ['filter' => 'ceklogin']);
    $routes->get('dosen/index', 'dosen::index', ['filter' => 'ceklogin']);
    //dosen  getdata datatables
    $routes->get('dosen/getdosen', 'dosen::getdosen', ['filter' => 'ceklogin']);
    //dosen crud
    $routes->get('dosen/formtambah', 'dosen::formtambah');
    $routes->post('dosen/simpandata', 'dosen::simpandata');
    $routes->post('dosen/formedit', 'dosen::formedit');
    $routes->post('dosen/updatedata', 'dosen::updatedata');
    $routes->post('dosen/hapus', 'dosen::hapus');
});

$routes->group('admin', ['namespace' => '\App\Controllers\Admin'], function ($routes) {
    //skripsi index
    $routes->get('skripsi', 'skripsi::index', ['filter' => 'ceklogin']);
    $routes->get('skripsi/index', 'skripsi::index', ['filter' => 'ceklogin']);
    //skripsi getdata datatables
    $routes->get('skripsi/getskripsi', 'skripsi::getskripsi', ['filter' => 'ceklogin']);
    //skripsi crud
    $routes->get('skripsi/formtambah', 'skripsi::formtambah');
    $routes->post('skripsi/simpandata', 'skripsi::simpandata');
    $routes->post('skripsi/formedit', 'skripsi::formedit');
    $routes->post('skripsi/updatedata', 'skripsi::updatedata');
    $routes->post('skripsi/hapus', 'skripsi::hapus');
});

$routes->get('login/(:any)', 'login::index');
$routes->post('login/cekuser', 'login::cekuser');
$routes->get('layout/(:any)', 'layout::index');
// $routes->get('admin/dosen', 'Admin\Dosen::index');
// $routes->get('/admin/dosen/(:any)', 'admin\dosen::$1');
// $routes->get('admin/mahasiswa', 'Admin\Mahasiswa::index');
// $routes->get('/admin/mahasiswa/(:any)', 'Admin\Mahasiswa::$1');
// $routes->get('admin/skripsi', 'Admin\Skripsi::index');
// $routes->get('/admin/skripsi/(:any)', 'Admin\skripsi::$1');



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
