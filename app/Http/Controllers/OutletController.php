<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Outlet;
use App\Log;
use DataTables;
use Auth;
use Validator;
use Date;

class OutletController extends Controller
{
    // show index page
    public function index()
    {
        return view('pages.outlet.index');
    }

    // show create form
    public function create()
    {
        return view('pages.outlet.create');
    }

    // function create (store)
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

    // show one data or selected data
    // $id is int
    public function show($id)
    {
        $data = Outlet::findOrFail($id);
        return view('pages.outlet.show', compact('data'));
    }

    // show create form
    // $id is int
    public function edit($id)
    {
        $data = Outlet::findOrFail($id);
        return view('pages.outlet.edit', compact('data'));
    }

    // function edit (update)
    // $id is int
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

    // remove data using soft deletes
    public function destroy($id)
    {
        $tUser = \App\TbUser::where('id_outlet', $id)->get();
        $paket = \App\Paket::where('id_outlet', $id)->get();
        if (count($tUser) > 0) {
            return response()->json(['msg' => 'Gagal Membuang'], 401);
        }

        if (count($paket) > 0) {
            return response()->json(['msg' => 'Gagal Membuang'], 401);
        }
        $data = Outlet::findOrFail($id);
        $data->delete();
        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Membuang Outlet '. $data->nama
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

    public function softDeleteIndex()
    {
        return view('pages.trash.outlet');
    }

    // soft delete data for view trash
    public function softDeleteData()
    {
        $outlet = Outlet::query()->onlyTrashed()->orderBy('deleted_at', "DESC");
        return DataTables::of($outlet)
            ->addColumn('delete_time', function ($outlet){
                $time = Date::parse($outlet->deleted_at)->format('d F Y h:i');
                return $time;
            })
            ->addColumn('action', function ($outlet) {
                return view('pages.outlet.softDel-action', [
                    'model' => $outlet,
                    'url_restore' => route('outlet.softDelete.restore', $outlet->id),
                    'url_delete' => route('outlet.softDelete.deletePermanent', $outlet->id),
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);
    }

    // function for retore data 
    public function restoreData(Request $request, $id)
    {
        $data = Outlet::onlyTrashed()->where('id', $id);
        $myData = $data->first();
        $data->restore();
        Log::create([
            'user_id' => Auth::id(),
            'msg' => "Mengembalikan Outlet ". $myData->nama
        ]);
        return response()->json(['msg' => $myData->nama. ' Berhasil Dikembalikan'], 200);
    }

    // delete permanent spesifik data dorm storrage
    public function deletePermanent($id)
    {
        $data = Outlet::onlyTrashed()->where('id', $id);
        $myData = $data->first();
        $data->forceDelete();
        Log::create([
            'user_id' => Auth::id(),
            'msg' => "Menghapus Permanen Outlet ". $myData->nama
        ]);
        return response()->json(['msg' => $myData->nama. ' Berhasil Dihapus'], 200);
    }

    // restore all data
    public function all(Request $request)
    {
        $data = Outlet::onlyTrashed();
        if (request()->isMethod("POST")) {
            $data->restore();
            Log::create([
                'user_id' => Auth::id(),
                'msg' => "Mengembalikan Semua Outlet"
            ]);
            return response()->json(['msg' => 'Berhasil Dikembalikan'], 200);
        }else if (request()->isMethod("PUT")) {
            $data->forceDelete();
            Log::create([
                'user_id' => Auth::id(),
                'msg' => "Mengembalikan Semua Outlet"
            ]);
            return response()->json(['msg' => 'Berhasil Dihapus'], 200);
        }else{
            return response()->json(['msg' => 'Terjadi Kesalaha'], 500);
        }
    }

    public function findOutlet()
    {
        $data = Outlet::where('deleted_at', null)->where('nama', 'LIKE', "%". request('q'). "%")->get();
        return response()->json(["items" => $data], 200);
    }

    public function findOutletById($id)
    {
        return response()->json(['data' => Outlet::findOrFail($id)]);
    }
}
