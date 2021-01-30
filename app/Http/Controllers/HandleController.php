<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;
use Auth;
use DB;

class HandleController extends Controller
{
	public function index()
	{
	    return view('pages.trash.index');
	}

	public function laporanIndex()
	{
		$data = [];
		$data['outlet'] = \App\Outlet::all();
		// $data['member'] = \App\Member::all();
		return view('pages.laporan.index', $data);
	}

	public function dashboard()
	{
		$data = [];
		$data['member'] = \App\Member::all();
		$data['outlet'] = \App\Outlet::all();
		$data['jenis'] = \App\Jenis::all();
		$data['user'] = \App\TbUser::all();
		if (Auth::user()->level == 'admin') {
			$data['transaksi'] = \App\Transaksi::all();
			$data['paket'] = \App\Paket::all();
		}else{
			$data['transaksi'] = \App\Transaksi::where('id_outlet', Auth::user()->tbUser->id_outlet)->get();
			$data['paket'] = \App\Paket::where('id_outlet', Auth::user()->tbUser->id_outlet)->get();
		}

		$data['x'] = DB::table('tb_detail_transaksi')
                    ->join('tb_paket', 'tb_detail_transaksi.id_paket', '=', 'tb_paket.id')
                    ->select(DB::raw('SUM(tb_detail_transaksi.qty * tb_paket.harga) AS total'))
                    ->get();
        // $data['pajak'] = $pajak = $data['data']->pajak/100 * $data['a']->total;
        // $data['diskon'] = $diskon = $data['data']->diskon/100 * $data['a']->total;
        // $data['total'] = $data['a']->total + $pajak - $diskon + $data['data']->biaya_tambahan;
        // dd($data['a']);

		return view('dashboard', $data);
	}

	public function about()
	{
		return view('pages.tentang.about');
	}
}
