<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function register(Request $request ){

       $validation= $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

       $user=User::create($validation);
       $access_token =  $user->createToken('MyApp')->accessToken; 
      
       return response(['user'=>$user, 'acces_token'=>$access_token], 200);
        

    }
}
