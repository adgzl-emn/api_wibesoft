<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    //token a gore kullanicinin bilgilerini verir
    public function get_user_info(Request $request)
    {
        if (!$request->header('Authorization'))
        {
            return response()->json(['error' => 'Token eksik.'], 401);
        }

        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user = User::where('token',$token)->first();
        if (!$user) {
            return response()->json(['error' => 'Geçersiz token.'], 401);
        }

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'status' => $user->status,
        ], 200);
    }

    //admin ekler
    public function add_admin(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->password = Hash::make($request->password);
            $user->email = $request->email;
            $user->status = 1; // admin
            $token = Str::random(60);
            $user->token = $token;
            $user->save();

            return response()->json(['message' => $request->name . ' Kişi Admin Olarak Eklendi Token i kaydedin =>.', 'token' => $token], 201);
        }
        catch (QueryException $e) {
            return response()->json(['error' =>  $e->getMessage()], 500);
        }
    }

    //user ekler
    public function add_user(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->password = Hash::make($request->password);
            $user->email = $request->email;
            $user->status = 2; // user
            $token = Str::random(60);
            $user->token = $token;
            $user->save();

            return response()->json(['message' => $request->name . ' Kişi User Olarak Eklendi Token i kaydedin =>.', 'token' => $token], 201);
        }
        catch (QueryException $e) {
            return response()->json(['error' => 'Veritabanı hatası: ' . $e->getMessage()], 500);
        }
    }



}
