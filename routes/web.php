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
    Route::get('dashboard', function () {
        return view('dashboard');
    });

    // log
    // store serach
    Route::post('/ss', 'LogController@searchStore')->name('log.search.store');

    // outlet
    Route::resource('/outlet', 'OutletController');
    Route::get('d/o', 'OutletController@datatables')->name('outlet.data');
    Route::get('d/o/sel2', 'OutletController@findOutlet')->name('outlet.data.sel2'); //data select 2
    Route::get('d/o/{id}', 'OutletController@findOutletById')->name('outlet.data.id'); //data select 2

    // jenis
    Route::resource('/jenis', 'JenisController');
    Route::get('d/j', 'JenisController@datatables')->name('jenis.data');
    Route::get('d/j/sel2', 'JenisController@findJenis')->name('jenis.data.sel2'); //data select 2

    // paket
    Route::resource('/paket', 'PaketController');
    Route::get('d/p', 'PaketController@datatables')->name('paket.data');
    Route::get('d/p/sel2', 'JenisController@findPaket')->name('paket.data.sel2'); //data select 2

    // member
    Route::resource('/member', 'MemberController');
    Route::get('d/m', 'MemberController@datatables')->name('member.data');
    // Route::get('d/p/sel2', 'JenisController@findPaket')->name('paket.data.sel2'); //data select 2

    // user (people can login[kasir,owner]) 
    // Route::get('d/u/sel2', 'UserController@findUser')->name('user.data.sel2'); //data select 2

    // admin
    Route::group(['prefix' => '/pengguna'], function () {
        Route::resource('/user', 'UserController');
        Route::get('d/u', 'UserController@datatables')->name('user.data');

        Route::resource('/admin', 'AdminController')->except([
            'show'
        ]);
        Route::get('d/a', 'AdminController@datatables')->name('admin.data');
    });

    Route::group(['prefix' => '/trash'], function () {
        // ooutlet soft delete data
        Route::get('/outlet', 'OutletController@softDeleteIndex')->name('outlet.softDelete.index');
        Route::get('/d/o', 'OutletController@softDeleteData')->name('outlet.softDelete.data');
        Route::post('/{id}/o', 'OutletController@restoreData')->name('outlet.softDelete.restore');
        Route::delete('/o/{id}', 'OutletController@deletePermanent')->name('outlet.softDelete.deletePermanent');
        Route::match(['post', 'put'],'/o/all', 'OutletController@all')->name('outlet.softDelete.all');

        // jenis soft delete
        Route::get('/jenis', 'JenisController@softDeleteIndex')->name('jenis.softDelete.index');
        Route::get('d/j', 'JenisController@softDeleteData')->name('jenis.softDelete.data');
        Route::post('/{id}/j', 'JenisController@restoreData')->name('jenis.softDelete.restore');
        Route::delete('/j/{id}', 'JenisController@deletePermanent')->name('jenis.softDelete.deletePermanent');
        Route::match(['post', 'put'],'/j/all', 'JenisController@all')->name('jenis.softDelete.all');

        // paket softdelete
        Route::get('/paket', 'PaketController@softDeleteIndex')->name('paket.softDelete.index');
        Route::get('d/p', 'PaketController@softDeleteData')->name('paket.softDelete.data');
        Route::post('/{id}/p', 'PaketController@restoreData')->name('paket.softDelete.restore');
        Route::delete('/p/{id}', 'PaketController@deletePermanent')->name('paket.softDelete.deletePermanent');
        Route::match(['post', 'put'],'/p/all', 'PaketController@all')->name('paket.softDelete.all');


        // member softdelete
        Route::get('/member', 'MemberController@softDeleteIndex')->name('member.softDelete.index');
        Route::get('d/m', 'MemberController@softDeleteData')->name('member.softDelete.data');
        Route::post('/{id}/m', 'MemberController@restoreData')->name('member.softDelete.restore');
        Route::delete('/m/{id}', 'MemberController@deletePermanent')->name('member.softDelete.deletePermanent');
        Route::match(['post', 'put'],'/m/all', 'MemberController@all')->name('member.softDelete.all');

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

