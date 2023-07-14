<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loginUser(Request $request): Response
    {
        
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('example')->accessToken;
            $user->token =$token;
        
            return response(['status' => 200, 'user' => $user], 200);
        } else {
            return response(['status' => 401, 'message' => 'Unauthorized'], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getUserDetail(Request $request): Response
    {
        $user = $request->user('api');
        return response(['data' => $user], 200);
    }

    /**
     * Display the specified resource.
     */
    public function userLogout(): Response
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return response(['status' => 200, 'message' => 'Logged out successfully'], 200);
    }
}
