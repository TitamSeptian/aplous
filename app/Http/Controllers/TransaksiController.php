<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;
use App\Transaksi;
use App\Paket;
use App\Member;
use App\User;
use App\DetailTransaksi;
use Auth;
use Date;
use DataTables;
use DB;

class TransaksiController extends Controller
{

    public function pajak()
    {
        return 10;
    }

    public function kode_invoice()
    {
        $max_query = DB::table('tb_transaksi')->max('kode_invoice');
        // $kodeB = Inventaris::all();
        $date = date("ymdHi");

        if ($max_query != null) {
            $nilai = substr($max_query, 13, 13);
            $kode = (int) $nilai;
            // tambah 1
            $kode = $kode + 1;
            $auto_kode = "APL". $date . str_pad($kode, 4, "0",  STR_PAD_LEFT);
        } else {
            $auto_kode = "APL". $date . "0001";
        }

        return $auto_kode;
    }

    public function index()
    {
        return view('pages.transaksi.index');
    }

    public function create()
    {
        $data = [];
        $data['now'] = date('Y-m-d');
        return view('pages.transaksi.create', $data);
    }

    // store
    public function store(Request $request)
    {
        dd($request);
        $transaksi = Transaksi::create([
            'id_outlet' => $request->hd_outlet,
            'kode_invoice' => $this->kode_invoice(),
            'tgl' => date('y-m-d H:i:s'),
            'batas_waktu' => Date::parse($request->tgl_selesai)->format('y-m-d H:i:s'),
            // 'tgl_bayar' => null,
            'biaya_tambahan' => $request->biaya_tambahan,
            'diskon' => $request->diskon,
            'pajak' => $this->pajak(),
            'status' => 'baru',
            'dibayar' => 'belum_dibayar',
            'user_id' => Auth::id(),
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
