<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request){
        $validate=$request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|String|max:255|unique:users',
            'password'=>'required|min:6',
        ]);

        $user=User::create([
            'name'=>$request->name,
              'email'=>$request->email,
              'password'=>Hash::make($request->password),

        ]);
        if($user){
            return response()->json([
                'status'=>true,
                'message'=>'Successfully Registered',
                'user'=>$user,
            ],200);
        }else{
            return response()->json(['error' => 'not registered'], 401);
        }
    }

    public function login(Request $request){
        $validate=$request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);
       $credentials= $request->only('email','password');
        if(Auth::attempt($credentials)){
            
            $user=Auth::user();
            $token=$user->createToken('authToken')->accessToken;

            return response()->json([
                'status'=>true,
                'message'=>'Login Success',
                'access_token'=> $token,
            ]);
        }else{
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
    }

    
}
