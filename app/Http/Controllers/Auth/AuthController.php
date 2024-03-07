<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login(){
        return view('auth.login');
    }

    public function post_login(Request $request){
        $request->validate([
            'username'=>'required',
            'password'=>'required',
        ]);

        $postLogin = [
            'username'=>$request->username,
            'password'=>$request->password,
        ];

        if(Auth::attempt($postLogin)){
            return redirect('/');
        }else{
            return redirect('/login')->withErrors('Check username & password');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
