<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticController extends Controller
{
    public function form(){
        return view('Auth.login');
    }

    public function login(Request $request){
           // dd($request);
           $validate=$request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);
        $crds=$request->only('email','password');
        if(Auth::attempt($crds)){
                return redirect()->route('product.index')->with('success','Loggedin successfully');
        }else{
            return redirect()->back()->with('error','user not found');
        }
    }

    public function registerForm(){
        return view('Auth.register');
    }

    public function registerStore(Request $request){
        //dd($request);
        $val=$request->validate([
            'email'=>'required|unique:users',
            'password'=>'required',
            'name'=>'required',
        ]);
        $save=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        if($save){
            Auth::logout();
            return redirect()->route('form')->with('success','registered Successfully, Login to proceed!');
        }else{
            return redirect()->back()->with('error','Not registered');
        }
    }

    public function logout()
    {
        Auth::logout(); 
        return redirect()->route('form')->with('success', 'You have been logged out successfully.');
    }

}
