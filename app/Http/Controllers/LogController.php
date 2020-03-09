<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;
use Auth;
use Date;
use DataTables;

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

	public function index()
	{
		return view('pages.log.index');
	}

	public function destroy($id)
	{
		$data = Log::findOrFail($id);
		$data->delete();

		return response()->json(['msg' => 'Berhasil Di hapus'], 200);
	}

	public function deleteAll()
	{
		$a = Log::truncate();
		// dd($a);
		return response()->json(['msg' => 'Behasil di Hapus Semua'], 200);
	}

	public function datatables()
	{
		$log = Log::query()->orderBy('created_at', "DESC")->with(['user']);
        return DataTables::of($log)
            ->addColumn('user', function ($log){
            	return $log->user->tbUser->nama;
            })
            ->addColumn('time', function ($log){
                $time = Date::parse($log->created_at)->format('d F Y h:i');
                return $time;
            })
            
            ->addColumn('action', function ($log) {
                return view('pages.log.action', [
                    'model' => $log,
                    'url_delete' => route('log.destroy', $log->id),
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);
	}
}
