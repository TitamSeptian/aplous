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

    	if (Auth::attempt($credentials)) {
    		Log::create([
    			'user_id' => Auth::id(),
    			'msg' => Auth::id() . "Login"
    		]);
    		return response()->json(['msg' => 'Login Berhasil'], 200);
    	}else{
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
}
