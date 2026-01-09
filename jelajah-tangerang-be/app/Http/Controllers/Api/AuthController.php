<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // REGISTER
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil, silakan cek email untuk verifikasi.',
            'data'    => $user,
            'token'   => $token,
            'token_type' => 'Bearer'
        ], 201);
    }

    // LOGIN
    // LOGIN
    public function login(Request $request)
    {
        // 1. Cek apakah Email & Password cocok
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        // 2. [TAMBAHAN BARU] Cek apakah Email sudah diverifikasi?
        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email Anda belum diverifikasi. Silakan cek inbox/spam email Anda untuk verifikasi.'
            ], 403); // Return 403 Forbidden
        }

        // 3. Jika lolos verifikasi, baru buat Token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'data'    => $user,
            'token'   => $token,
            'token_type' => 'Bearer'
        ]);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
