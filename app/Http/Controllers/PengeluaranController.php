<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pengeluaran;
use App\Outlet;
use App\Log;
use Auth;
use Validator;
use Date;
use DataTables;
use PDF;
use DB;

class PengeluaranController extends Controller
{
    function __construct()
    {
        // pajak setup
        $this->rules_owner = [
            'rules' => [
                'nama' => 'required|min:2|max:32',
                'harga' => 'required|numeric',
                'ket' => 'nullable'
            ],
            'messages' => [
                'nama.required' => 'Nama Harus diisi',
                'nama.min' => 'Nama Minimal 2 karakter',
                'nama.max' => 'Nama Maksimal 32 karakter',
                'harga.required' => 'Harga Harus diisi',
                'harga.numeric' => 'Harga hanya diisi angka',
            ],
        ];

        $this->rules_admin = [
            'rules' => [
                'nama' => 'required|min:2|max:32',
                'outlet' => 'required',
                'harga' => 'required|numeric',
                'ket' => 'nullable'
            ],
            'messages' => [
                'nama.required' => 'Nama Harus diisi',
                'nama.min' => 'Nama Minimal 2 karakter',
                'nama.max' => 'Nama Maksimal 32 karakter',
                'outlet.required' => 'Pilih Toko',
                'harga.required' => 'Harga Harus diisi',
                'harga.numeric' => 'Harga hanya diisi angka',
            ],
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.pengeluaran.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.pengeluaran.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->level == 'admin') {
            $validator = Validator::make($request->all(), $this->rules_admin['rules'], $this->rules_admin['messages']);
        }else if (Auth::user()->level == 'owner'){
            $validator = Validator::make($request->all(), $this->rules_owner['rules'], $this->rules_owner['messages']);
        }else{
            return response()->json(['msg' => 'Terjadi Kesalahan dengan Hak Akses'], 500);
        }
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $data = Pengeluaran::create([
            'nama' => $request->nama,
            'id_outlet' => Auth::user()->level == 'admin' ? $request->outlet : Auth::user()->tbUser->id_outlet,
            'harga' => $request->harga,
            'ket' => $request->ket,
            'bulan' => date('n'),
        ]);

        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Menambahkan Pengeluaran '. $data->nama
        ]);

        return response()->json(['msg' => "$data->nama Berhasil Ditambahkan"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [];
        $data['data'] = Pengeluaran::findOrFail($id);
        $data['bulan'] = $this->cekBulan($data['data']->bulan);
        return view('pages.pengeluaran.show', $data);
    }

    public function cekBulan($bulanNum)
    {
        switch ($bulanNum) {
            case '1': return 'Januari'; break;
            case 2: return 'Febuari'; break;
            case 3: return 'Maret'; break;
            case 4: return 'April'; break;
            case 5: return 'Mei'; break;
            case 6: return 'Juni'; break;
            case 7:return 'Juli'; break;
            case 8: return 'Agustus'; break;
            case 9: return 'September'; break;
            case 10: return 'Oktober'; break;
            case 11: return 'November'; break;
            case 12: return 'Desember'; break;
            
            default:
                return 'terjadi Kesalahan';
                break;
        }
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
        $data['data'] = Pengeluaran::findOrFail($id);
        $data['outlet'] = Outlet::all();
        return view('pages.pengeluaran.edit', $data);
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
        if (Auth::user()->level == 'admin') {
            $validator = Validator::make($request->all(), $this->rules_admin['rules'], $this->rules_admin['messages']);
        }else if (Auth::user()->level == 'owner'){
            $validator = Validator::make($request->all(), $this->rules_owner['rules'], $this->rules_owner['messages']);
        }else{
            return response()->json(['msg' => 'Terjadi Kesalahan dengan Hak Akses'], 500);
        }
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $pengeluaran = Pengeluaran::findOrFail($id);

        $pengeluaran->update([
            'nama' => $request->nama,
            'id_outlet' => Auth::user()->level == 'admin' ? $request->outlet : Auth::user()->tbUser->id_outlet,
            'harga' => $request->harga,
            'ket' => $request->ket,
            'bulan' => date('n'),
        ]);

        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Mengubah Pengeluaran '. $pengeluaran->nama
        ]);

        return response()->json(['msg' => "$pengeluaran->nama Berhasil Ditambahkan"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Pengeluaran::findOrFail($id);

        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Menghapus Pengeluaran '. $data->nama
        ]);

        $data->delete();

        return response()->json(['msg' => "$data->nama Berhasil Dibuang"], 200);
    }

    public function datatables()
    {
        $pengeluaran = Pengeluaran::query()->orderBy('bulan', 'ASC')->with(['outlet']);

        return DataTables::of($pengeluaran)
            ->addColumn('action', function($pengeluaran){
                return view('pages.pengeluaran.action', [
                    'model' => $pengeluaran,
                    'url_edit' => route('pengeluaran.edit', $pengeluaran->id),
                    'url_show' => route('pengeluaran.show', $pengeluaran->id),
                    'url_delete' => route('pengeluaran.destroy', $pengeluaran->id),
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);
    }

    public function datatables2($id_outlet)
    {
        $pengeluaran = Pengeluaran::query()->orderBy('bulan', 'ASC')->where('id_outlet', $id_outlet)->with(['outlet']);

        return DataTables::of($pengeluaran)
            ->addColumn('action', function($pengeluaran){
                return view('pages.pengeluaran.action', [
                    'model' => $pengeluaran,
                    'url_edit' => route('pengeluaran.edit', $pengeluaran->id),
                    'url_show' => route('pengeluaran.show', $pengeluaran->id),
                    'url_delete' => route('pengeluaran.destroy', $pengeluaran->id),
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);
    }

    public function softDeleteIndex()
    {
        return view('pages.trash.pengeluaran');
    }

     public function softDeleteData()
    {
        $pengeluaran = Pengeluaran::query()->onlyTrashed()->orderBy('deleted_at', "DESC")->with(['outlet']);
        return DataTables::of($pengeluaran)
            ->addColumn('delete_time', function ($pengeluaran){
                $time = Date::parse($pengeluaran->deleted_at)->format('d F Y h:i');
                return $time;
            })
            ->addColumn('action', function ($pengeluaran) {
                return view('pages.pengeluaran.softDel-action', [
                    'model' => $pengeluaran,
                    'url_restore' => route('pengeluaran.softDelete.restore', $pengeluaran->id),
                    'url_delete' => route('pengeluaran.softDelete.deletePermanent', $pengeluaran->id),
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);
    }

    // function for retore data 
    public function restoreData(Request $request, $id)
    {
        $data = Pengeluaran::onlyTrashed()->where('id', $id);
        $myData = $data->first();
        $data->restore();
        Log::create([
            'user_id' => Auth::id(),
            'msg' => "Mengembalikan Pengeluaran ". $myData->name
        ]);
        return response()->json(['msg' => $myData->name. ' Berhasil Dikembalikan'], 200);
    }

    // delete permanent spesifik data dorm storrage
    public function deletePermanent($id)
    {
        $data = Pengeluaran::onlyTrashed()->where('id', $id);
        $myData = $data->first();
        $data->forceDelete();
        Log::create([
            'user_id' => Auth::id(),
            'msg' => "Menghapus Permanen Pengeluaran ". $myData->name
        ]);
        return response()->json(['msg' => $myData->name. ' Berhasil Dihapus'], 200);
    }

    // restore all data
    public function all(Request $request)
    {
        $data = Pengeluaran::onlyTrashed();
        if (request()->isMethod("POST")) {
            $data->restore();
            Log::create([
                'user_id' => Auth::id(),
                'msg' => "Mengembalikan Semua Pengeluaran"
            ]);
            return response()->json(['msg' => 'Berhasil Dikembalikan'], 200);
        }else if (request()->isMethod("PUT")) {
            $data->forceDelete();
            Log::create([
                'user_id' => Auth::id(),
                'msg' => "Mengembalikan Semua Pengeluaran"
            ]);
            return response()->json(['msg' => 'Berhasil Dihapus'], 200);
        }
    }

    public function findPaket()
    {
        $data = Pengeluaran::where('deleted_at', null)->where('nama', 'LIKE', "%". request('q'). "%")->get();
        return response()->json(["items" => $data], 200);
    }
}
