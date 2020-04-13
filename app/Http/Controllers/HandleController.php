<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;
use Auth;

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
		$data['member'] = count(\App\Member::all());
		$data['outlet'] = count(\App\Outlet::all());
		$data['jenis'] = count(\App\Jenis::all());
		$data['user'] = count(\App\TbUser::all());
		if (Auth::user()->level == 'admin') {
			$data['transaksi'] = count(\App\Transaksi::all());
			$data['paket'] = count(\App\Paket::all());
		}else{
			$data['transaksi'] = count(\App\Transaksi::where('id_outlet', Auth::user()->tbUser->id_outlet)->get());
			$data['paket'] = count(\App\Paket::where('id_outlet', Auth::user()->tbUser->id_outlet)->get());
		}
		// dd($data['member']);

		return view('dashboard', $data);
	}
}
