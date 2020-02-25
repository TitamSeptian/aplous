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
    			'msg' => "Login"
    		]);
    		return response()->json(['msg' => 'Login Berhasil'], 200);
    	}else{
            // not match
    		$uname = User::where('username', $request->uname)->first();
    		$pwd = User::where('password', $request->pwd)->first();

    		if (!$uname) {
    			return response()->json(['msg' => 'Username tidak valid'], 401);
    		}
    		if (!$pwd) {
    			return response()->json(['msg' => 'Password tidak valid'], 401);
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
