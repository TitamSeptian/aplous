<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jenis;
use App\Log;
use Auth;
use Date;
use DataTables;
use Validator;

class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.jenis.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.jenis.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'nama.required' => 'Nama Harus di isi',
            'nama.min' => 'Nama Minimal 2 karakter',
            'nama.max' => 'Nama Maksimal 32 karakter',
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:2|max:32',
        ], $messages);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $data = Jenis::create([
            'name' => $request->nama,
            'ket' => $request->ket,
        ]);

        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Menambahkan Jenis '. $data->name
        ]);

        return response()->json(['msg' => "$data->name Berhasil Ditambahkan"], 200);
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
        $data = Jenis::findOrFail($id);
        return view('pages.jenis.edit', compact('data'));
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
        $messages = [
            'nama.required' => 'Nama Harus di isi',
            'nama.min' => 'Nama Minimal 2 karakter',
            'nama.max' => 'Nama Maksimal 32 karakter',
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:2|max:32',
        ], $messages);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $data = Jenis::findOrFail($id);
        $data->update([
            'name' => $request->nama,
            'ket' => $request->ket,
        ]);

        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Merubah Jenis '. $data->name
        ]);

        return response()->json(['msg' => "$data->name Berhasil Dirubah"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paket = \App\Paket::where('id_jenis', $id)->get();
        if (count($paket) > 0) {
            return response()->json(['msg' => 'Jenis digunakan di salah satu paket']);
        }
        $data = Jenis::findOrFail($id);
        $data->delete();
        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Menghapus Jenis '. $data->name,
        ]);

        return response()->json(['msg' => "$data->name Berhasil dihapus"]);
    }

    public function datatables()
    {
        $jenis = Jenis::query()->orderBy('created_at', 'DESC');

        return DataTables::of($jenis)
            ->addColumn('action', function($jenis){
                return view('pages.jenis.action', [
                    'model' => $jenis,
                    'url_edit' => route('jenis.edit', $jenis->id),
                    'url_delete' => route('jenis.destroy', $jenis->id),
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);
    }

    public function softDeleteIndex()
    {
        return view('pages.trash.jenis');
    }

     public function softDeleteData()
    {
        $jenis = Jenis::query()->onlyTrashed()->orderBy('deleted_at', "DESC");
        return DataTables::of($jenis)
            ->addColumn('delete_time', function ($jenis){
                $time = Date::parse($jenis->deleted_at)->format('d F Y h:i');
                return $time;
            })
            ->addColumn('action', function ($jenis) {
                return view('pages.jenis.softDel-action', [
                    'model' => $jenis,
                    'url_restore' => route('jenis.softDelete.restore', $jenis->id),
                    'url_delete' => route('jenis.softDelete.deletePermanent', $jenis->id),
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);
    }

    // function for retore data 
    public function restoreData(Request $request, $id)
    {
        $data = Jenis::onlyTrashed()->where('id', $id);
        $myData = $data->first();
        $data->restore();
        Log::create([
            'user_id' => Auth::id(),
            'msg' => "Mengembalikan Jenis ". $myData->name
        ]);
        return response()->json(['msg' => $myData->name. ' Berhasil Dikembalikan'], 200);
    }

    // delete permanent spesifik data dorm storrage
    public function deletePermanent($id)
    {
        $data = Jenis::onlyTrashed()->where('id', $id);
        $myData = $data->first();
        $data->forceDelete();
        Log::create([
            'user_id' => Auth::id(),
            'msg' => "Menghapus Permanen Jenis ". $myData->name
        ]);
        return response()->json(['msg' => $myData->name. ' Berhasil Dihapus'], 200);
    }

    // restore all data
    public function all(Request $request)
    {
        $data = Jenis::onlyTrashed();
        if (request()->isMethod("POST")) {
            $data->restore();
            Log::create([
                'user_id' => Auth::id(),
                'msg' => "Mengembalikan Semua Jenis"
            ]);
            return response()->json(['msg' => 'Berhasil Dikembalikan'], 200);
        }else if (request()->isMethod("PUT")) {
            $data->forceDelete();
            Log::create([
                'user_id' => Auth::id(),
                'msg' => "Mengembalikan Semua Jenis"
            ]);
            return response()->json(['msg' => 'Berhasil Dihapus'], 200);
        }
    }
}
