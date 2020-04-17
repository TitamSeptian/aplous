<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\TbUser;
use App\Log;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    // return to view Login
    public function getLogin()
    {
    	return view('pages.auth.login');
    }

    public function postLogin(LoginRequest $request)
    {
    	$credentials = [
    		'username' => $request->uname,
    		'password' => $request->pwd,
    	];

        // check credentials
    	if (Auth::attempt($credentials)) {
            // insert to log
    		Log::create([
    			'user_id' => Auth::id(),
    			'msg' => "Masuk"
    		]);
    		return response()->json(['msg' => 'Login Berhasil'], 200);
    	}else{
            // not match
    		$uname = User::where('username', $request->uname)->first();
    		$pwd = User::where('password', $request->pwd)->first();

    		if (!$uname) {
    			return response()->json(['msg' => 'Nama Pengguna tidak Valid'], 401);
    		} else if (!$pwd) {
    			return response()->json(['msg' => 'Kata Sandi tidak valid'], 401);
    		} else {
                return response()->json(['msg' => 'Terjadi Kesalahan'], 500);
            }
    	}
    }

    public function logout(Request $request)
    {
        // create log
        Log::create([
            'user_id' => Auth::id(),
            'msg' => "Logout"
        ]);
        // logout
        Auth::logout();

        return redirect()->route('getLogin');
    }
}
