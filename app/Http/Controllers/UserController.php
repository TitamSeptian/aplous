<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TbUser;
use App\User;
use App\Log;
use Date;
use Auth;
use DataTables;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.user.outlet.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.user.outlet.create');
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
            'outlet.required' => 'Pilih Outlet',
            'role.required' => 'Pilih Peran',
            'username.required' => 'Username Harus Diisi',
            'password.required' => 'Password Harus Diisi',
            'password.confirmed' => 'Password tidak Cocok',
            'username.unique' => 'Username Sudah Ada',
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:2|max:32',
            'outlet' => 'required',
            'role' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|confirmed',
        ], $messages);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $data = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'level' => $request->role,
        ]);

        $user = TbUser::create([
            // 'username' => $request->username,
            // 'password' => bcrypt($request->password),
            'role' => $request->role,
            'id_outlet' => $request->outlet,
            'nama' => $request->nama,
            'id_user' => $data->id,
        ]);


        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Menambahkan Pengguna '. $user->nama
        ]);

        return response()->json(['msg' => "$user->nama Berhasil Ditambahkan"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::findOrFail($id);
        return view('pages.user.outlet.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('pages.user.outlet.edit', compact('data'));
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
            'outlet.required' => 'Pilih Outlet',
            'role.required' => 'Pilih Peran',
            'username.required' => 'Username Harus Diisi',
            'password.confirmed' => 'Password tidak Cocok',
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:2|max:32',
            'outlet' => 'required',
            'role' => 'required',
            'username' => 'required',
            'password' => 'confirmed',
        ], $messages);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $data = User::findOrFail($id);
        $data_update = [];
        $data_tb_user = [];
        if ($request->password == null) {
            $data_update = [
                'username' => $request->username,
            ];
            $data_tb_user = [
                // 'username' => $request->username,
                'role' => $request->role,
                'id_outlet' => $request->outlet,
                'nama' => $request->nama,
            ];
        }else{
            $data_update = [
                'username' => $request->username,
                'password' => bcrypt($request->password),
            ];
            $data_tb_user = [
                // 'username' => $request->username,
                // 'password' => bcrypt($request->password),
                'role' => $request->role,
                'id_outlet' => $request->outlet,
                'nama' => $request->nama,
            ];
        }
        $data->update($data_update);

        $data->tbUser->update($data_tb_user);


        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Mengubah Pengguna '. $data->tbUser->nama
        ]);

        return response()->json(['msg' => $data->tbUser->nama ." Berhasil Diubah"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $user = TbUser::where('id_user', $data->id)->delete();
        $data->delete();

        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Menghapus Pengguna '. $data->admin->nama
        ]);

        return response()->json(['msg' => $data->username." Berhasil dihapus"]);
    }

    public function datatables()
    {
        $user = User::query()->where('level', 'kasir')->orWhere('level', 'owner')->orderBy('created_at', 'DESC')->with(['tbUser']);

        return DataTables::of($user)->addColumn('action', function ($user) {
            return view('pages.user.outlet.action', [
                'model' => $user,
                'url_show' => route('user.show', $user->id),
                'url_edit' => route('user.edit', $user->id),
                'url_delete' => route('user.destroy', $user->id),
            ]);
        })->rawColumns(['action'])->addIndexColumn()->make(true);
    }
}
