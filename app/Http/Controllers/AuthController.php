<?php

namespace App\Http\Controllers;

use App\Http\Requests\loginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => "required",
            'password' => 'required'
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid username or password'
            ], 401);
        }

        $user = User::where('username', $request->username)->first();


        $token = $request->user()->createToken($request->username);
        return response()->json([
            'success' => true,
            'user' => $token
        ]);
    }

    public function Logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out',
        ]);
    }
}
