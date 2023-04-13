<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login
     *
     * @return ResponseFormatter|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {

        $credentials = $request->validated();
        $user = User::whereEmail($request->email)->first();

        if (Hash::check($request->password, $user->password)) {
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Gagal login'
                ], 'Authentication Failed', 401);
            }
        } else {
            return ResponseFormatter::error([
                'message' => 'Password salah'
            ], 'Authentication Failed', 401);
        }

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return ResponseFormatter::success([
            'access_token' => $tokenResult,
            'user' => new UserResource($user)
        ], 'Login berhasil');
    }

    /**
     * Logout
     *
     * @return ResponseFormatter
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return ResponseFormatter::success(null, 'Token Revoked');
    }
}
