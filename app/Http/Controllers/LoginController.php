<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function login(){
        return view('login');
    }

    public function loginproses(Request $request){
        // dd($request->all());
        $user = User::where('email', $request->email)->where('password', $request->password)->first();

        if ($user) {
            Auth::login($user);
            return redirect('/');
        }
    }

    public function register(){
        return view('register');
    }

    public function registeruser(Request $request){
        // dd($request->all());
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'created_at' => now()
        ]);

        return redirect('/login');
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
