<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Outlet;
use App\Log;
use DataTables;
use Auth;
use Validator;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.outlet.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.outlet.create');
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
            'nama.max' => 'Nama Maksimal 2 karakter',
            'alamat.required' => 'Alamat Harus di isi',
            'tlp.required' => 'No. Telepon Harus di Isi',
            'tlp.min' => 'No. Telepon Tidak Valid 1',
            'tlp.max' => 'No. Telepon Tidak Valid',
            'tlp.numeric' => "hanya di isi angka"
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:2|max:100',
            'alamat' => 'required',
            'tlp' => 'required|alpha_num|min:5|max:15',
        ], $messages);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $data = Outlet::create([
            'nama' => $request->nama,
            'tlp' => $request->tlp,
            'alamat' => $request->alamat,
        ]);

        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Menambahkan Outlet '. $data->nama
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
        $data = Outlet::findOrFail($id);
        return view('pages.outlet.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Outlet::findOrFail($id);
        return view('pages.outlet.edit', compact('data'));
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
            'nama.max' => 'Nama Maksimal 2 karakter',
            'alamat.required' => 'Alamat Harus di isi',
            'tlp.required' => 'No. Telepon Harus di Isi',
            'tlp.min' => 'No. Telepon Tidak Valid',
            'tlp.max' => 'No. Telepon Tidak Valid',
            'tlp.numeric' => "hanya di isi angka"
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:2|max:100',
            'alamat' => 'required',
            'tlp' => 'required|alpha_num|min:5|max:15',
        ], $messages);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $data = Outlet::findOrFail($id);
        $data->update([
            'nama' => $request->nama,
            'tlp' => $request->tlp,
            'alamat' => $request->alamat,
        ]);

        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Merubah Outlet '. $data->nama
        ]);

        return response()->json(['msg' => "$data->name Berhasil Diubah"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\TbUser::where('id_outlet', $id)->get();
        \App\Paket::where('id_outlet', $id)->get();
        \App\Paket::where('id_outlet', $id)->get();
        $data = Outlet::findOrFail($id);
        $data->delete();
        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Menghapus Outlet '. $data->nama
        ]);
        return response()->json(['msg' => "$data->name Berhasil Dihapus"], 200);
    }

    // data for view index
    public function datatables()
    {
        $outlet = Outlet::query()->orderBy('created_at', "DESC");
        return DataTables::of($outlet)->addColumn('action', function ($outlet) {
            return view('pages.outlet.action', [
                'model' => $outlet,
                'url_show' => route('outlet.show', $outlet->id),
                'url_edit' => route('outlet.edit', $outlet->id),
                'url_delete' => route('outlet.destroy', $outlet->id),
            ]);
        })->rawColumns(['action'])->addIndexColumn()->make(true);
    }
}
