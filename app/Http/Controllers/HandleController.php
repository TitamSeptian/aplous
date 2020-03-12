<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;

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
		$data['member'] = \App\Member::all();
		return view('pages.laporan.index', $data);
	}
}
