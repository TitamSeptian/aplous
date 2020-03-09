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
use Validator;

class TransaksiController extends Controller
{
    function __construct()
    {
        // pajak setup
        $this->pajak = 10;
        $this->status = ['baru', 'proses', 'selesai', 'diambil'];
        $this->dibayar = ['belum_dibayar', 'dibayar'];
        $this->rules_kasir = [
            'rules' => [
                "biaya_tambahan" => 'nullable|numeric',
                'tgl_selesai' => 'required',
                'member' => 'required',
                'diskon' => 'nullable|numeric|min:1|max:100',
            ],
            'messages' => [
                'tgl_selesai.required' => 'Estimasi Tanggal Harus diisi',
                'member.required' => 'Pilih Member',
                'diskon.digits_between' => 'Masukan ratusan',
                'biaya_tambahan.numeric' => 'Biaya Tambah hanya diisi angka',
                'diskon.numeric' => 'Diskon hanya diisi angka',
                'diskon.min' => 'Minimal 1%',
                'diskon.max' => 'Maksimal 100%',
            ],
        ];

        $this->rules_admin = [
            'rules' => [
                "biaya_tambahan" => 'nullable|numeric',
                'tgl_selesai' => 'required',
                'member' => 'required',
                'hd_outlet' => 'required',
                'diskon' => 'nullable|numeric|min:1|max:100',
            ],
            'messages' => [
                'tgl_selesai.required' => 'Estimasi Tanggal Harus diisi',
                'member.required' => 'Pilih Member',
                'diskon.digits_between' => 'Masukan ratusan',
                'biaya_tambahan.numeric' => 'Biaya Tambah hanya diisi angka',
                'diskon.numeric' => 'Diskon hanya diisi angka',
                'hd_outlet' => 'Pilih Outlet',
                'diskon.min' => 'Minimal 1%',
                'diskon.max' => 'Maksimal 100%',
            ],
        ];
    }

    // public function pajak()
    // {
    //     return 10;
    // }

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
        if (Auth::user()->level == 'admin') {
            $validator = Validator::make($request->all(), $this->rules_admin['rules'], $this->rules_admin['messages']);
        }else if (Auth::user()->level == 'kasir'){
            $validator = Validator::make($request->all(), $this->rules_kasir['rules'], $this->rules_kasir['messages']);
        }else{
            return response()->json(['msg' => 'Terjadi Kesalahan dengan Hak Akses'], 500);
        }
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }
        // dd(Date::parse($request->tgl_selesai)->format('Y-m-d H:i:s'));

        $transaksi = Transaksi::create([
            'id_outlet' => Auth::user()->level == 'admin' ? $request->hd_outlet : Auth::user()->tbUser->id_outlet,
            'id_member' => $request->member,
            'kode_invoice' => $this->kode_invoice(),
            'tgl' => Date::now(),
            'batas_waktu' => Date::parse($request->tgl_selesai)->format('Y-m-d H:i:s'),
            'biaya_tambahan' => $request->biaya_tambahan,
            'diskon' => $request->diskon,
            'pajak' => $this->pajak,
            'status' => $this->status[0],
            'dibayar' => $this->dibayar[0],
            'id_user' => Auth::user()->tbUser->id,
        ]);

        if (!$transaksi) {
            return response()->json(['msg' => 'Terjadi Kesalahan'], 500);
        }
        if (count($request->p_id) > 0) {
            foreach ($request->p_id as $key => $value) {
                $data = [
                    'id_transaksi' => $transaksi->id,
                    'keterangan' => $request->ket[$key],
                    'id_paket' => $request->p_id[$key],
                    'qty' => $request->qty[$key]
                ];
                $det_transaksi = DetailTransaksi::create($data);
            }
        }

        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Membuat Transaksi '.$transaksi->kode_invoice
        ]);

        return response()->json([
            'msg' => 'Berhasil Memesan',
            'url' => route('nota.print', $transaksi->id),
            'back' => route('transaksi.index')
        ], 200);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [];
        $data['data'] = Transaksi::findOrFail($id);
        $data['a'] = DB::table('tb_detail_transaksi')
                    ->join('tb_paket', 'tb_detail_transaksi.id_paket', '=', 'tb_paket.id')
                    ->select(DB::raw('SUM(tb_detail_transaksi.qty * tb_paket.harga) AS total'))
                    ->where('tb_detail_transaksi.id_transaksi', $id)
                    ->first();
        $data['pajak'] = $pajak = $data['data']->pajak/100 * $data['a']->total;
        $data['diskon'] = $diskon = $data['data']->diskon/100 * $data['a']->total;
        $data['total'] = $data['a']->total + $pajak - $diskon + $data['data']->biaya_tambahan;
        return view('pages.transaksi.show', $data);
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

    public function viewStatus($id)
    {
        $data = [];
        $data['data'] = Transaksi::findOrFail($id);
        $data['a'] = DB::table('tb_detail_transaksi')
                    ->join('tb_paket', 'tb_detail_transaksi.id_paket', '=', 'tb_paket.id')
                    ->select(DB::raw('SUM(tb_detail_transaksi.qty * tb_paket.harga) AS total'))
                    ->where('tb_detail_transaksi.id_transaksi', $id)
                    ->first();
        $data['pajak'] = $pajak = $data['data']->pajak/100 * $data['a']->total;
        $data['diskon'] = $diskon = $data['data']->diskon/100 * $data['a']->total;
        $data['total'] = $data['a']->total + $pajak - $diskon + $data['data']->biaya_tambahan;
        return view('pages.transaksi.ts', $data);
    }

    public function updateStatus(Request $request, $id)
    {
        $data = Transaksi::findOrFail($id);
        $data->update(['status' => $request->status]);

        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Mengubah Status Barang '.$data->kode_invoice
        ]);

        return response()->json(['msg' => 'Status Berhasil Dirubah'], 200);

    }

    public function datatables()
    {
        $ts = '';
        if (Auth::user()->level == 'admin') {
            $ts = Transaksi::query()->orderBy('created_at', 'DESC')->with(['outlet', 'tbUser', 'detailTransaksi', 'member'])->where('dibayar', 'belum_dibayar');
        }else if(Auth::user()->level == 'kasir'){
            $ts = Transaksi::query()->orderBy('created_at', 'DESC')->with(['outlet', 'tbUser', 'detailTransaksi', 'member'])->where('id_outlet', Auth::user()->tbUser->id_outlet)->where('dibayar', 'belum_dibayar');
        }

        return DataTables::of($ts)
            ->addColumn('total_harga', function ($ts){
                $a = DB::table('tb_detail_transaksi')
                    ->join('tb_paket', 'tb_detail_transaksi.id_paket', '=', 'tb_paket.id')
                    ->select(DB::raw('SUM(tb_detail_transaksi.qty * tb_paket.harga) AS total'))
                    ->where('tb_detail_transaksi.id_transaksi', $ts->id)
                    // ->count();
                    ->first();
                $pajak = $ts->pajak/100 * $a->total;
                $diskon = $ts->diskon/100 * $a->total;
                return $a->total + $pajak - $diskon + $ts->biaya_tambahan;
            })
            ->addColumn('action', function($ts){
                return view('pages.transaksi.action', [
                    'model' => $ts,
                    'url_transaksi' => route('transaksi.transaksi', $ts->id),
                    'url_edit' => route('transaksi.edit', $ts->id),
                    'url_show' => route('transaksi.show', $ts->id),
                    'url_delete' => route('transaksi.destroy', $ts->id),
                ]);
            })->rawColumns(['action', 'total_harga'])->addIndexColumn()->make(true);
    }

    public function notaPrint($id)
    {
        $ts = Transaksi::findOrFail($id);
        $data = [];

        $data['data'] = $ts;
        $data['masuk'] = Date::parse($ts->tgl)->format('d F Y');
        $data['esti'] = Date::parse($ts->batas_waktu)->format('d F Y');

        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Mambuat Nota '.$ts->kode_invoice
        ]);

        return view('laporan.nota.nota', $data); 
    }

    public function bayar(Request $request, $id)
    {
        $rules = [
            'bayar' => 'required|numeric',
        ];
        $messages = [
            'bayar.required' => 'Tidak ada Uang',
            'bayar.numeric' => 'Hanya di Isi Angka'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }
        $data = Transaksi::findOrFail($id);
        $data->update([
            'dibayar' => $this->dibayar[1],
            'bayar' => $request->bayar,
            'tgl_bayar' => Date::now(),
        ]);

        Log::create([
            'user_id' => Auth::id(),
            'msg' => "Melakukan Pembayaran $data->kode_invoice",
        ]);

        return response()->json([
            'msg' => 'Pembayaran Berhasil',
            'url' => route('struk.print', $data->id),
            'back' => route('transaksi.index'),
        ], 200);
    }

    public function strukPrint($id)
    {
        $ts = Transaksi::findOrFail($id);
        $data = [];

        $data['data'] = $ts;
        $data['masuk'] = Date::parse($ts->tgl)->format('d F Y');
        $data['esti'] = Date::parse($ts->batas_waktu)->format('d F Y');

        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Mambuat Struk '.$ts->kode_invoice,
        ]);

        return view('laporan.nota.struk', $data); 
    }
}
