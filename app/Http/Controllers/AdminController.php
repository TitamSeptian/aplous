<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\TbUser;
use App\Log;
use Date;
use Auth;
use DataTables;
use Validator;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.user.admin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.user.admin.create');
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
            'username.required' => 'Username Harus Diisi',
            'password.required' => 'Password Harus Diisi',
            'password.confirmed' => 'Password tidak Cocok',
            'username.unique' => 'Username Sudah Ada',
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:2|max:32',
            'username' => 'required|unique:users',
            'password' => 'required|confirmed',
        ], $messages);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $data = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'level' => 'admin',
        ]);

        $admin = TbUser::create([
            // 'username' => $request->username,
            // 'password' => bcrypt($request->password),
            'role' => 'admin',
            'id_outlet' => null,
            'nama' => $request->nama,
            'id_user' => $data->id,
        ]);



        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Menambahkan Admin '. $admin->nama
        ]);

        return response()->json(['msg' => "$admin->nama Berhasil Ditambahkan"], 200);
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
        return 'aasdas';
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
        return view('pages.user.admin.edit', compact('data'));
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
            'username.required' => 'Username Harus Diisi',
            'password.confirmed' => 'Password tidak Cocok',
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:2|max:32',
            'username' => 'required',
            'password' => 'confirmed',
        ], $messages);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $data = User::findOrFail($id);
        $data_update = [];
        $data_admin = [];
        if ($request->password == null) {
            $data_update = [
                'username' => $request->username,
            ];
            $data_admin = [
                // 'username' => $request->username,
                'role' => $request->role,
                'nama' => $request->nama,
                'id_user' => $data->id,
            ];
        }else{
            $data_update = [
                'username' => $request->username,
                'password' => bcrypt($request->password),
            ];
            $data_admin = [
                // 'username' => $request->username,
                // 'password' => bcrypt($request->password),
                'role' => $request->role,
                'nama' => $request->nama,
                'id_user' => $data->id,
            ];
        }
        $data->update($data_update);
        $data->tbUser->update($data_admin);


        Log::create([
            'user_id' => Auth::id(),
            'msg' => 'Mengubah Admin '. $data->admin->nama
        ]);

        return response()->json(['msg' => $data->admin->nama ." Berhasil Diubah"], 200);
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
        if (Auth::id() == $id) {
            return response()->json(['msg' => 'User Sedang Login'], 401);
        }else{
            $admin = TbUser::where('user_id', $data->id)->delete();
            $data->delete();
            Log::create([
                'user_id' => Auth::id(),
                'msg' => 'Menghapus Admin '. $data->username
            ]);

            return response()->json(['msg' => $data->username." Berhasil dihapus"], 200);
        }

    }

    public function datatables()
    {
        $admin = User::query()->where('level', 'admin')->with(['tbUser']);
        return DataTables::of($admin)->addColumn('action', function ($admin){
            return view('pages.user.admin.action', [
                'model' => $admin,
                // 'url_show' => route('admin.show', $admin->id),
                'url_edit' => route('admin.edit', $admin->id),
                'url_delete' => route('admin.destroy', $admin->id),
            ]);
        })->rawColumns(['action'])->addIndexColumn()->make(true);
    }
}
