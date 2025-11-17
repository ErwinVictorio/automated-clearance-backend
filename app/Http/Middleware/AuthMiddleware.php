<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,  $role): Response
    {
        // Get the authenticated user (works with Sanctum)
        $user = $request->user(); // or use auth()->user()
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated: please login to your account'
            ], 401);
        }

        // userMapping
        $Roles = [
            0 => 'admin',
            1 => 'teacher',
            2 => 'student'
        ];

          $userRoles = $Roles[$user->role];

        if ($userRoles !== $role) {

            return response()->json([
                'success' => false,
                'role' =>  $role,
                'message' => 'Access denied you dont have permission'
            ]);
        }

        return $next($request);
    }
}
