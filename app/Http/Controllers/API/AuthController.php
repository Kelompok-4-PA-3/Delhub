<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\DosenResource;
use App\Http\Resources\KelompokResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\MahasiswaResource;

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
     * Get data mahasiswa
     *
     * @return ResponseFormatter
     */
    public function getMahasiswa(){
        $mahasiswa = auth()->user()->mahasiswa;
        if ($mahasiswa) {
            return ResponseFormatter::success(new MahasiswaResource($mahasiswa), 'Data mahasiswa berhasil diambil');
        } else {
            return ResponseFormatter::error([
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 'Data mahasiswa gagal diambil', 404);
        }
    }

    /**
     * Get data kelompok
     *
     * @return ResponseFormatter
     */
    public function getKelompok(){
        $kelompok = auth()->user()->mahasiswa->kelompok_mahasiswa->where('status', '1')->first()->kelompok ?? null;
        if ($kelompok) {
            return ResponseFormatter::success(new KelompokResource($kelompok), 'Data kelompok berhasil diambil');
        } else {
            return ResponseFormatter::error([
                'message' => 'Data kelompok tidak ditemukan'
            ], 'Data kelompok gagal diambil', 404);
        }
    }

    /**
     * Get data dosen
     *
     * @return ResponseFormatter
     */
    public function getDosen(){
        $dosen = auth()->user()->dosen;
        if ($dosen) {
            return ResponseFormatter::success(new DosenResource($dosen), 'Data dosen berhasil diambil');
        } else {
            return ResponseFormatter::error([
                'message' => 'Data dosen tidak ditemukan'
            ], 'Data dosen gagal diambil', 404);
        }
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
