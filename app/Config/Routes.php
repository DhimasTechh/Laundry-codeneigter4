<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ── Beranda ─────────────────────────────────────────────────────────────────
$routes->get('/', 'Home::index');

// ── Auth ─────────────────────────────────────────────────────────────────────
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

// ── Produk (legacy, jaga kompatibilitas) ─────────────────────────────────────
$routes->group('produk', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'ProdukController::index');
    $routes->post('', 'ProdukController::create');
    $routes->post('edit/(:any)', 'ProdukController::edit/$1');
    $routes->get('delete/(:any)', 'ProdukController::delete/$1');
    $routes->get('download', 'ProdukController::download');
});

// ── Keranjang & Checkout ─────────────────────────────────────────────────────
$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index');
    $routes->post('add', 'TransaksiController::cart_add');
    $routes->post('', 'TransaksiController::cart_add');      // backward compat
    $routes->post('edit', 'TransaksiController::cart_edit');
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
    $routes->get('clear', 'TransaksiController::cart_clear');

    // Checkout
    $routes->get('checkout', 'TransaksiController::checkout');
    $routes->post('checkout', 'TransaksiController::processCheckout');
    $routes->get('checkout/success', 'TransaksiController::checkoutSuccess');
});

// ── Riwayat Pesanan (Guest) ───────────────────────────────────────────────────
$routes->get('my-orders', 'TransaksiController::myOrders', ['filter' => 'auth']);

// ── Admin Panel ───────────────────────────────────────────────────────────────
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    // Dashboard (Overview)
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->get('dashboard/update-status/(:num)', 'Admin\Dashboard::updateStatus/$1');

    // Pesanan Masuk (dari buyer/guest)
    $routes->get('pesanan', 'Admin\Dashboard::pesanan');

    // Penghasilan
    $routes->get('penghasilan', 'Admin\Dashboard::penghasilan');

    // Manajemen Layanan
    $routes->get('layanan', 'Admin\Layanan::index');
    $routes->post('layanan/create', 'Admin\Layanan::create');
    $routes->post('layanan/edit/(:num)', 'Admin\Layanan::edit/$1');
    $routes->get('layanan/delete/(:num)', 'Admin\Layanan::delete/$1');
    $routes->get('layanan/download', 'Admin\Layanan::download');
});