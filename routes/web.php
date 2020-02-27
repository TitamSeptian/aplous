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

// auth
Route::get('/', 'AuthController@getLogin')->name('getLogin')->middleware('guest');
Route::post('/log', 'AuthController@postLogin')->name('postLogin');
Route::post('logout', 'AuthController@logout')->name('logout')->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    // log
    // store serach
    Route::post('/ss', 'LogController@searchStore')->name('log.search.store');

    // outlet
    Route::resource('/outlet', 'OutletController');
    Route::get('d/o', 'OutletController@datatables')->name('outlet.data');



    Route::group(['prefix' => '/trash'], function () {
        // Trash form all soft delete
        Route::get('/', 'HandleController@index')->name('trash.index');
        // ooutlet soft delete data
        Route::get('/d/o', 'OutletController@softDeleteData')->name('outlet.softDelete.data');
        Route::post('/{id}/o', 'OutletController@restoreData')->name('outlet.softDelete.restore');
        Route::delete('/o/{id}', 'OutletController@deletePermanent')->name('outlet.softDelete.deletePermanent');
        Route::match(['post', 'delete'],'/rs/all', 'OutletController@all')->name('outlet.softDelete.all');
        // Route::post('/del/all', 'OutletController@deleteAll')->name('outlet.softDelete.deleteAll');


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
});

