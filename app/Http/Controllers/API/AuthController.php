<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        if (!$user) {
            return ResponseFormatter::error([
                'message' => 'Email tidak terdaftar'
            ], 'Authentication Failed', 401);
        }

        // load mahasiswa, kelompok, and pembimbing
        $user->load('mahasiswa.kelompoks.pembimbings.user', 'mahasiswa.prodi', 'dosen');

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

    public function storeToken(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->firebase_token = $request->firebase_token;
        $user->save();

        return ResponseFormatter::success(null, 'Token berhasil disimpan');
    }

    /**
     * Logout
     *
     * @return ResponseFormatter
     */
    public function logout()
    {
        $user = User::find(auth()->user()->id);
        $user->firebase_token = null;
        $user->save();
        auth()->user()->tokens()->delete();

        return ResponseFormatter::success(null, 'Token Revoked');
    }
}
