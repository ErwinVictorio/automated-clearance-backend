<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
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

        $token = $request->user()->createToken($request->username);
        return response()->json([
            'success' => true,
            'user' => $token
        ]);
    }


    public function Regiter(Request $request)
    {

        try {
            $validated =  $request->validate([
                'full_name' => 'required',
                'course' => 'required',
                'section' => 'required',
                'username' => 'required|unique:users,username',
                'password' => 'required',
                'yearlavel' => 'required',
            ]);


            User::create([
                'full_name' => $validated['full_name'],
                'course' => $validated['course'],
                'section' =>  $validated['section'],
                'username' => $validated['username'],
                'password' =>  $validated['password'],
                'yearlavel' =>  $validated['yearlavel'],
                'role' => 2
            ]);

            return response([
                'success' => true,
                'message' => "Hi $validated[full_name] thank you for registering. You may now log in. "
            ]);
        } catch (\Throwable $th) {

            return response([
                'success' => false,
                'error' => $th->getMessage()
            ], 500);
        }
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
