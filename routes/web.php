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

Route::get('/123qwe123', function () {
    return view('laporan.layout-pdf');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', 'HandleController@dashboard')->name('dashboard');

    Route::group(['middleware' => 'admin'], function () {
        // log
        // store serach
        Route::post('/ss', 'LogController@searchStore')->name('log.search.store');
        Route::get('riwayat', 'LogController@index')->name('log.index');
        Route::delete('riwayat/{id}', 'LogController@destroy')->name('log.destroy');
        Route::get('log/d', 'LogController@datatables')->name('log.data');
        Route::post('riwayat/del', 'LogController@deleteAll')->name('log.delete-all');

        // outlet
        Route::resource('/outlet', 'OutletController');
        Route::get('d/o', 'OutletController@datatables')->name('outlet.data');
        Route::get('d/o/sel2', 'OutletController@findOutlet')->name('outlet.data.sel2'); //data select 2
        Route::get('d/o/{id}', 'OutletController@findOutletById')->name('outlet.data.id'); //data select 2
        // laporan outlet
        Route::get('o/pdf', 'OutletController@pdf')->name('outlet.pdf');

        // jenis
        Route::resource('/jenis', 'JenisController');
        Route::get('d/j', 'JenisController@datatables')->name('jenis.data');
        Route::get('d/j/sel2', 'JenisController@findJenis')->name('jenis.data.sel2'); //data select 2

        // paket
        Route::resource('/paket', 'PaketController');
        Route::get('d/p', 'PaketController@datatables')->name('paket.data');
        // paket laporan
        Route::get('j/pdf', 'PaketController@pdf')->name('paket.pdf');
        Route::get('j/pdf/{outlet}', 'PaketController@pdfOutlet')->name('paket.pdf.outlet');

        

        // admin
        Route::group(['prefix' => '/pengguna'], function () {
            Route::resource('/user', 'UserController');
            Route::get('d/u', 'UserController@datatables')->name('user.data');

            Route::resource('/admin', 'AdminController')->except(['show']);
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

            // transaksi
            Route::get('/transaksi', 'TransaksiController@softDeleteIndex')->name('transaksi.softDelete.index');
            Route::get('d/ts', 'TransaksiController@softDeleteData')->name('transaksi.softDelete.data');
            Route::post('/{id}/ts', 'TransaksiController@restoreData')->name('transaksi.softDelete.restore');
            Route::delete('/ts/{id}', 'TransaksiController@deletePermanent')->name('transaksi.softDelete.deletePermanent');
            Route::match(['post', 'put'],'/ts/all', 'TransaksiController@all')->name('transaksi.softDelete.all');

            // pengeluaran softdelete
            Route::get('/pengeluaran', 'PengeluaranController@softDeleteIndex')->name('pengeluaran.softDelete.index');
            Route::get('d/pout', 'PengeluaranController@softDeleteData')->name('pengeluaran.softDelete.data');
            Route::post('/{id}/pout', 'PengeluaranController@restoreData')->name('pengeluaran.softDelete.restore');
            Route::delete('/pout/{id}', 'PengeluaranController@deletePermanent')->name('pengeluaran.softDelete.deletePermanent');
            Route::match(['post', 'put'],'/pout/all', 'PengeluaranController@all')->name('pengeluaran.softDelete.all');
        });
    });

    // member
    Route::resource('/member', 'MemberController');
    Route::get('d/m', 'MemberController@datatables')->name('member.data');
    Route::get('d/m/sel2', 'MemberController@findMember')->name('member.data.sel2'); //data select 2
    // member laporan
    Route::get('m/pdf', 'MemberController@pdf')->name('member.pdf');

    
    // paket
    Route::get('d/p/sel2', 'JenisController@findPaket')->name('paket.data.sel2'); //data select 2
    Route::get('d/p/outlet', 'PaketController@findPaketByOutlet')->name('paket.data.outlet');

    // pengeluaran
    Route::resource('/pengeluaran', 'PengeluaranController');
    Route::get('d/pout', 'PengeluaranController@datatables')->name('pengeluaran.data');
    Route::get('d/pout/{outlet}', 'PengeluaranController@datatables2')->name('pengeluaran.data.out');
    // pengeluaran laporan
    Route::get('pengout/pdf', 'PengeluaranController@pdf')->name('pengeluaran.pdf');
    Route::get('pengout/pdf/{outlet}', 'PengeluaranController@pdfOutlet')->name('pengeluaran.pdf.outlet');    


    // transaksi
    Route::resource('/transaksi', 'TransaksiController');
    Route::get('d/t', 'TransaksiController@datatables')->name('transaksi.data');
    Route::get('/transaksi/ts/{id}', 'TransaksiController@viewStatus')->name('transaksi.transaksi');
    Route::put('/transaksi/stts/ts/{id}', 'TransaksiController@updateStatus')->name('transaksi.status');
    Route::post('/transaksi/pay/ts/{id}', 'TransaksiController@bayar')->name('transaksi.bayar');

    Route::get('d/ts/sel2', 'TransaksiController@findTransaksi')->name('transaksi.data.sel2'); //data select 2

    // transaksi done;
    Route::get('/transaksi/done/a', 'TransaksiController@doneIndex')->name('transaksi.done.index');
    Route::get('d/t/done', 'TransaksiController@doneDatatables')->name('transaksi.done.data');
    // nota & struk
    Route::get('nota/{id}', 'TransaksiController@notaPrint')->name('nota.print');
    Route::get('struk/{id}', 'TransaksiController@strukPrint')->name('struk.print');
    // transaksi laporan
    Route::get('t/pdf', 'TransaksiController@pdf')->name('transaksi.pdf');
    Route::get('t/pdf/{outlet}', 'TransaksiController@pdfOutlet')->name('transaksi.pdf.outlet');


    Route::get('/laporan', 'HandleController@laporanIndex')->name('laporan.index');

    

});

