<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class WebAuthController extends Controller
{
    public function auth(Request $request){
        return view("pages.auth");
    }

    public function register(Request $request){
        $request->validate([
            "name"   => "required",
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->name);
        $user->save();
        return back()->with("success","User registered successfully!!");
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        // if (Auth::attempt($credentials)) {
        //     return redirect("/")
        //                 ->withSuccess('Signed in');
        // }
        // return back()->with('error',"Unable to login, Please try after sometimes!!");
        try{
            Auth::attempt($credentials);
            dd(auth()->user());
        }catch(\Exception $e){
            dd($e->getMessage());
        }
    }
}
