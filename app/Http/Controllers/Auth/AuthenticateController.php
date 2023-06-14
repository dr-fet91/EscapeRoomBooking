<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class AuthenticateController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'max:256', 'email', 'exists:users,email'],
                'password' => ['required'],
            ]);

            if (!Auth::attempt($request->only(['email', 'password']))) {
                throw new Exception('Unauthorized! The username or password is incorrect', 401);
            }

            /** @var User $user */
            $user = Auth::user();

            return response([
                'token' => $user->createToken("API TOKEN")->plainTextToken,
            ], 200);
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Logged out']);
    }
}
