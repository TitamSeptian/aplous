<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;
use Auth;

class LogController extends Controller
{
	public function searchStore(Request $request)
	{
		Log::create([
			'user_id' => Auth::id(),
			'msg' => "Mencari '$request->search' di '$request->place'"
		]);

		return response()->json(['msg' => 1], 200);
	}
}
