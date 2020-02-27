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
}
