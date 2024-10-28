<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    //register
    public function register(Request $request){
        //Validation
        $request->validate([
            "name"=>"required|string",
            "role"=>"required",
            "email"=>"required|string|email|unique:users",
            "password"=>"required",
        ]);
        
        //User model to save user database
        $user = User::create([
            "name"=>$request->name,
            "role"=>$request->role,
            "email"=>$request->email,
            "password"=>bcrypt($request->password),
        ]);

        return response()->json([
            "status" => true,
            "messege" => "Registrasi berhasil",
            'user' => $user,
            'role' => $request->role
        ]);
    }

    //Login
    public function login(Request $request){
        //Validation
        $request->validate([
            "email"=>"required|email",
            "password"=>"required",
        ]);

        //Auth Facade
        $token = Auth::attempt([
            "email"=> $request->email,
            "password"=> $request->password,
        ]);

        if (!$token) { 
            return response()->json([
                "status"=> false,
                "message"=>"Invalid login details"
            ]);
        }

        $user = Auth::user();
        return response()->json([
            'user'   => $user,
            'status' => true,
            'logged'=> true,
            'authorization' => [
                'token' => $token,
                'type'  => 'bearer',
            ]
            
        ]);
    }

    //Refresh Token
    public function refresh(){

        return response()->json([
            "user"=>Auth::user(),
            "authorisation"=>[
                "token"=>Auth::refresh(),
                "type"=>'bearer',
            ]
        ]);
    }

    //Logout
    public function logout(){
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
    
}