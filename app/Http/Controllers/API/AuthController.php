<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request ){

        $validatedData= $request->validate([
             'name' => 'required',
             'email' => 'required|email|unique:users',
             'password' => 'required|min:6|confirmed',
         ]);
        $validatedData['password']=bcrypt($request->password);
        $user=User::create($validatedData);
        $access_token =  $user->createToken('MyApp')->accessToken; 
       
        return response(['user' => $user, 'acces_token' => $access_token], 200);
         
    }

    public function login(Request $request){

        $loginData=$request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);
        
        if(!auth()->attempt($loginData)){
            return response(['message' => 'Invalid credentials']);
        }

        $accessToken=auth()->user()->createToken('MyApp')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }
}
