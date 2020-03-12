<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Log;
use Auth;
use App\Transaksi;
use Date;
use DataTables;
use Validator;
use PDF;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.member.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.member.create');
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
            'alamat.required' => 'Alamat Harus di isi',
            'tlp.required' => 'No. Telepon Harus di Isi',
            'tlp.digits_between' => 'No. Telepon Tidak Valid',
            'tlp.numeric' => "hanya di isi angka",
            'jenis_kelamin.required' => 'Nama Harus di isi',
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:2|max:32',
            'alamat' => 'required',
            'tlp' => 'required|numeric|digits_between:5,15',
            'jenis_kelamin' => 'required'
        ], $messages);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $data = Member::create([
            'nama' => $request->nama,
            'tlp' => $request->tlp,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin
        ]);

        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Menambahkan Member '. $data->nama
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
        $data = Member::findOrFail($id);
        return view('pages.member.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Member::findOrFail($id);
        return view('pages.member.edit', compact('data'));
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
            'alamat.required' => 'Alamat Harus di isi',
            'tlp.required' => 'No. Telepon Harus di Isi',
            'tlp.digits_between' => 'No. Telepon Tidak Valid',
            'tlp.numeric' => "hanya di isi angka",
            'jenis_kelamin.required' => 'Nama Harus di isi',
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:2|max:32',
            'alamat' => 'required',
            'tlp' => 'required|numeric|digits_between:5,15',
            'jenis_kelamin' => 'required'
        ], $messages);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $data = Member::findOrFail($id);

        $data->update([
            'nama' => $request->nama,
            'tlp' => $request->tlp,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin
        ]);

        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Mengubah Member '. $data->nama
        ]);

        return response()->json(['msg' => "$data->nama Berhasil Diubah"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Member::findOrFail($id);
        $transaksi = \App\Transaksi::where('id_member', $id)
                    ->where('status', '!=', 'diambil')
                    ->where('dibayar', '!=', 'dibayar')
                    ->get();
        if (count($transaksi) > 0) {
            return response()->json(['msg' => "$data->nama Masih Memiliki Pesanan"], 401);
        }

        $data->delete();
        Log::create([
            'user_id' => Auth::id(),
            'msg' => "Membuang Member $data->nama",
        ]);

        return response()->json(['msg' => "$data->name Berhasil Dibuang"], 200);
    }

    public function datatables()
    {
        $member = Member::query()->orderBy('created_at', 'DESC')->with(['transaksi']);
        return DataTables::of($member)
            ->addColumn('action', function ($member){
                return view('pages.member.action',[
                    'model' => $member,
                    'url_show' => route('member.show', $member->id),
                    'url_edit' => route('member.edit', $member->id),
                    'url_delete' => route('member.destroy', $member->id),
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);
    }

    public function softDeleteIndex()
    {
        return view('pages.trash.member');
    }

    // soft delete data for view trash
    public function softDeleteData()
    {
        $member = Member::query()->onlyTrashed()->orderBy('deleted_at', "DESC");
        return DataTables::of($member)
            ->addColumn('delete_time', function ($member){
                $time = Date::parse($member->deleted_at)->format('d F Y h:i');
                return $time;
            })
            ->addColumn('action', function ($member) {
                return view('pages.member.softDel-action', [
                    'model' => $member,
                    'url_restore' => route('member.softDelete.restore', $member->id),
                    'url_delete' => route('member.softDelete.deletePermanent', $member->id),
                ]);
            })->rawColumns(['action'])->addIndexColumn()->make(true);
    }

    // function for retore data 
    public function restoreData(Request $request, $id)
    {
        $data = Member::onlyTrashed()->where('id', $id);
        $myData = $data->first();
        $data->restore();
        Log::create([
            'user_id' => Auth::id(),
            'msg' => "Mengembalikan Member ". $myData->nama
        ]);
        return response()->json(['msg' => $myData->nama. ' Berhasil Dikembalikan'], 200);
    }

    // delete permanent spesifik data dorm storrage
    public function deletePermanent($id)
    {
        $data = Member::onlyTrashed()->where('id', $id);
        $myData = $data->first();
        $data->forceDelete();
        Log::create([
            'user_id' => Auth::id(),
            'msg' => "Menghapus Permanen Member ". $myData->nama
        ]);
        return response()->json(['msg' => $myData->nama. ' Berhasil Dihapus'], 200);
    }

    // restore all data
    public function all(Request $request)
    {
        $data = Member::onlyTrashed();
        if (request()->isMethod("POST")) {
            $data->restore();
            Log::create([
                'user_id' => Auth::id(),
                'msg' => "Mengembalikan Semua Member"
            ]);
            return response()->json(['msg' => 'Berhasil Dikembalikan'], 200);
        }else if (request()->isMethod("PUT")) {
            $data->forceDelete();
            Log::create([
                'user_id' => Auth::id(),
                'msg' => "Mengembalikan Semua Member"
            ]);
            return response()->json(['msg' => 'Berhasil Dihapus'], 200);
        }else{
            return response()->json(['msg' => 'Terjadi Kesalahah'], 500);
        }
    }

    // find member by name for data select2
    public function findMember()
    {
        $data = Member::where('deleted_at', null)->where('nama', 'LIKE', "%". request('q'). "%")->get();
        return response()->json(["items" => $data], 200);
    }

    // public function findOutletById($id)
    // {
    //     return response()->json(['data' => Outlet::findOrFail($id)]);
    // }

    public function pdf()
    {
        $data = [];
        $data['data'] = Member::orderBy('nama', 'ASC')->get();;
        $data['tanggal'] = Date::now()->format('d F Y');

        $pdf = PDF::loadView('laporan.pdf.member', $data);
        Log::create([
            'user_id' => Auth::id(),
            'msg' => "Membuat Laporan PDF Paket"
        ]);

        return $pdf->download('Member.pdf');
        // return view('laporan.pdf.paket', $data);
    }
}
