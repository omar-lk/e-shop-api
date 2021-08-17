<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    //

    public function register(Request $request)
    {
        $this->validate($request, [
            "name" => 'required',
            "email" => 'required|email|unique:users',
            "password" => 'required|min:8'
        ]);
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
        $token = $user->createToken('token')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if(auth()->attempt($credentials))
        {
            $token=auth()->user()->createToekn('token')->acessToken;
            return response()->json(['token'=>$token],200);
        }
        else
        {
            return response()->json(['error' => 'UnAuthorised Access'], 401);
        }
      
    }
    public function getAuthenticatedUser()
    {
        return response()->json(['user'=>auth()->user()],200);
    }
}
