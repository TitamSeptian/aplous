<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'AuthController@getLogin')->name('getLogin');
// Route::get('/log', 'AuthController@getLogin')->name('getLogin');
Route::post('/log1', 'AuthController@postLogin')->name('postLogin');

Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/outlet', function () {
    return view('pages.outlet.index');
});
Route::get('/produk', function () {
    return view('pages.produk.index');
});
Route::get('/laporan', function () {
    return view('pages.laporan.laporan');
});
Route::get('/transaksi', function () {
	$date = date('Y-m-d');
    return view('pages.transaksi.index',[
    	'date' => $date,
    ]);
});

Route::get('/transaksi/create', function () {
	$date = date('Y-m-d');
    return view('pages.transaksi.create',[
    	'date' => $date,
    ]);
});
