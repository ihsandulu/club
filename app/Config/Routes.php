<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->add('/', 'Utama::index');
$routes->add('/utama', 'Utama::index');
$routes->add('/login', 'Utama::login');
$routes->add('/logout', 'Utama::logout');
$routes->add('api', 'Api::index');
$routes->add('api/(:any)', 'Api::$1');
$routes->add('/transaction/sdspdf', 'Transaction\Sds::pdf');
$routes->add('/transaction/papipdf', 'Transaction\Papi::pdf');
$routes->add('/transaction/istpdf', 'Transaction\Ist::pdf');

$routes->add('/transactionm/qmbti', 'Transactionm\Qmbti::index');
$routes->add('/transactionm/qpapi', 'Transactionm\Qpapi::index');
$routes->add('/transactionm/qist', 'Transactionm\Qist::index');
$routes->add('/transactionm/qsds', 'Transactionm\Qsds::index');


$routes->add('/transactionm/nilai', 'Transactionm\nilai::index');
$routes->add('/transactionm/pay', 'Transactionm\pay::index');


$routes->add('/master/midentity', 'Master\Midentity::index');
$routes->add('/master/mschools', 'Master\Mschools::index');
$routes->add('/master/mclass', 'Master\Mclass::index');
$routes->add('/master/msbank', 'Master\Msbank::index');

$routes->add('/master/muser', 'Master\Muser::index');
$routes->add('/master/mmember', 'Master\Muser::member');
$routes->add('/master/madmin', 'Master\Muser::admin');
$routes->add('/mpassword', 'Master\Mpassword::index');


$routes->add('/master/rmbti', 'Master\Rmbti::index');
$routes->add('/master/mmbti', 'Master\Mmbti::index');
$routes->add('/master/tpapi', 'Master\Tpapi::index');
$routes->add('/master/rpapi', 'Master\Rpapi::index');
$routes->add('/master/mpapi', 'Master\Mpapi::index');
$routes->add('/master/tist', 'Master\Tist::index');
$routes->add('/master/rist', 'Master\Rist::index');
$routes->add('/master/rme', 'Master\Rme::index');
$routes->add('/master/riq', 'Master\Riq::index');
$routes->add('/master/mse', 'Master\Mse::index');
$routes->add('/master/mwa', 'Master\Mwa::index');
$routes->add('/master/man', 'Master\Man::index');
$routes->add('/master/mge', 'Master\Mge::index');
$routes->add('/master/mme', 'Master\Mme::index');
$routes->add('/master/mra', 'Master\Mra::index');
$routes->add('/master/mzr', 'Master\Mzr::index');
$routes->add('/master/mfa', 'Master\Mfa::index');
$routes->add('/master/mwu', 'Master\Mwu::index');
$routes->add('/master/tsds', 'Master\Tsds::index');
$routes->add('/master/rsds', 'Master\Rsds::index');
$routes->add('/master/msds', 'Master\Msds::index');
$routes->add('/transaction/mbti', 'Transaction\Mbti::index');
$routes->add('/transaction/papi', 'Transaction\Papi::index');
$routes->add('/transaction/ist', 'Transaction\Ist::index');
$routes->add('/transaction/sds', 'Transaction\Sds::index');


$routes->add('/transaction/pay', 'Transaction\Pay::index');
$routes->add('/transaction/tagihan', 'Transaction\Tagihan::index');
$routes->add('/transaction/inv', 'Transaction\Inv::index');
$routes->add('/transaction/nilai', 'Transaction\Nilai::index');
$routes->add('/transaction/ujian', 'Transaction\Ujian::index');
$routes->add('/transaction/ujiand', 'Transaction\Ujiand::index');
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
