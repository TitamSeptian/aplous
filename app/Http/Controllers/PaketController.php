<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paket;
use App\Jenis;
use App\Outlet;
use App\Log;
use Auth;
use Validator;
use Date;
use DataTables;
use PDF;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.paket.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.paket.create');
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
            'nama.required' => 'Nama Harus diisi',
            'nama.min' => 'Nama Minimal 2 karakter',
            'nama.max' => 'Nama Maksimal 32 karakter',
            'outlet.required' => 'Pilih Outlet',
            'jenis.required' => 'Pilih Jenis',
            'harga.required' => 'Harga Harus diisi',
            'harga.numeric' => 'Harga hanya diisi angka',
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:2|max:32',
            'outlet' => 'required',
            'jenis' => 'required',
            'harga' => 'required|numeric',
        ], $messages);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $data = Paket::create([
            'nama_paket' => $request->nama,
            'id_outlet' => $request->outlet,
            'id_jenis' => $request->jenis,
            'harga' => $request->harga,
        ]);

        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Menambahkan Paket '. $data->nama_paket
        ]);

        return response()->json(['msg' => "$data->nama_paket Berhasil Ditambahkan"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Paket::findOrFail($id);
        return view('pages.paket.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [];
        $data['data'] = Paket::findOrFail($id);
        $data['jenis'] = Jenis::all();
        $data['outlet'] = Outlet::all();
        return view('pages.paket.edit', $data);
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
            'nama.required' => 'Nama Harus diisi',
            'nama.min' => 'Nama Minimal 2 karakter',
            'nama.max' => 'Nama Maksimal 32 karakter',
            'outlet.required' => 'Pilih Outlet',
            'jenis.required' => 'Pilih Jenis',
            'harga.required' => 'Harga Harus diisi',
            'harga.numeric' => 'Harga hanya diisi angka',
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:2|max:32',
            'outlet' => 'required',
            'jenis' => 'required',
            'harga' => 'required|numeric',
        ], $messages);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }
        $data = Paket::findOrFail($id);
        $data->update([
            'nama_paket' => $request->nama,
            'id_outlet' => $request->outlet,
            'id_jenis' => $request->jenis,
            'harga' => $request->harga,
        ]);

        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Merubah Paket '. $data->nama_paket
        ]);

        return response()->json(['msg' => "$data->nama_paket Berhasil Dirubah"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Paket::findOrFail($id);
        $data->delete();
        return response()->json(['msg' => "$data->nama_paket Berhasil Dibuang"], 200);
    }

    public function datatables()
    {
        $paket = Paket::query()->orderBy('created_at', 'DESC')->with(['outlet', 'jenis']);

        return DataTables::of($paket)
            ->addColumn('action', function($paket){
                return view('pages.paket.action', [
                    'model' => $paket,
                    'url_edit' => route('paket.edit', $paket->id),
                    'url_show' => route('paket.show', $paket->id),
                    'url_delete' => route('paket.destroy', $paket->id),
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);
    }

    public function softDeleteIndex()
    {
        return view('pages.trash.paket');
    }

     public function softDeleteData()
    {
        $paket = Paket::query()->onlyTrashed()->orderBy('deleted_at', "DESC")->with(['jenis', 'outlet']);
        return DataTables::of($paket)
            ->addColumn('delete_time', function ($paket){
                $time = Date::parse($paket->deleted_at)->format('d F Y h:i');
                return $time;
            })
            ->addColumn('action', function ($paket) {
                return view('pages.paket.softDel-action', [
                    'model' => $paket,
                    'url_restore' => route('paket.softDelete.restore', $paket->id),
                    'url_delete' => route('paket.softDelete.deletePermanent', $paket->id),
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);
    }

    // function for retore data 
    public function restoreData(Request $request, $id)
    {
        $data = Paket::onlyTrashed()->where('id', $id);
        $myData = $data->first();
        $data->restore();
        Log::create([
            'user_id' => Auth::id(),
            'msg' => "Mengembalikan Paket ". $myData->name
        ]);
        return response()->json(['msg' => $myData->name. ' Berhasil Dikembalikan'], 200);
    }

    // delete permanent spesifik data dorm storrage
    public function deletePermanent($id)
    {
        $data = Paket::onlyTrashed()->where('id', $id);
        $myData = $data->first();
        $data->forceDelete();
        Log::create([
            'user_id' => Auth::id(),
            'msg' => "Menghapus Permanen Paket ". $myData->name
        ]);
        return response()->json(['msg' => $myData->name. ' Berhasil Dihapus'], 200);
    }

    // restore all data
    public function all(Request $request)
    {
        $data = Paket::onlyTrashed();
        if (request()->isMethod("POST")) {
            $data->restore();
            Log::create([
                'user_id' => Auth::id(),
                'msg' => "Mengembalikan Semua Paket"
            ]);
            return response()->json(['msg' => 'Berhasil Dikembalikan'], 200);
        }else if (request()->isMethod("PUT")) {
            $data->forceDelete();
            Log::create([
                'user_id' => Auth::id(),
                'msg' => "Mengembalikan Semua Paket"
            ]);
            return response()->json(['msg' => 'Berhasil Dihapus'], 200);
        }
    }

    public function findPaket()
    {
        $data = Paket::where('deleted_at', null)->where('nama_paket', 'LIKE', "%". request('q'). "%")->get();
        return response()->json(["items" => $data], 200);
    }

    public function findPaketByOutlet()
    {
        $paket = Paket::query()->where('id_outlet', request('q'))->with(['jenis', 'outlet']);
        return DataTables::of($paket)->addIndexColumn()->make(true);
    }

    public function pdf()
    {
        $data = [];
        if (Auth::user()->level == 'admin') {
            $data['data'] = Paket::orderBy('id_outlet', 'ASC')->get();;
        }else{
            $data['data'] = Paket::orderBy('nama_paket', 'ASC')->where('id_outlet', Auth::user()->tbUser->id_outlet)->get();
        }
        $data['tanggal'] = Date::now()->format('d F Y');

        $pdf = PDF::loadView('laporan.pdf.paket', $data);

        Log::create([
            'user_id' => Auth::id(),
            'msg' => "Membuat Laporan PDF Paket"
        ]);

        return $pdf->download('Paket.pdf');
        // return view('laporan.pdf.paket', $data);
    }

    public function pdfOutlet($id)
    {
        $data = [];
        $data['data'] = Paket::where('id_outlet', $id)->get();
        $data['tanggal'] = Date::now()->format('d F Y');
        $out = \App\Outlet::findOrFail($id);

        $pdf = PDF::loadView('laporan.pdf.paket', $data);

        Log::create([
            'user_id' => Auth::id(),
            'msg' => "Membuat Laporan PDF Paket di $out->nama"
        ]);

        return $pdf->download('Paket - '.$out->nama.'.pdf');
    }
}
