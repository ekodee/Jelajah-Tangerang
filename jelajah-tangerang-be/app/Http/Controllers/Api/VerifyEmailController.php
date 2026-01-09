<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function verify(Request $request)
    {
        // 1. Cari user berdasarkan ID di URL
        $user = User::find($request->route('id'));

        // Jika user tidak ada
        if (!$user) {
            return redirect('http://localhost:5173/login?error=invalid_user');
        }

        // 2. Validasi Hash (Keamanan Link)
        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return redirect('http://localhost:5173/login?error=invalid_link');
        }

        // 3. Jika user sudah verifikasi sebelumnya, langsung lempar ke login
        if ($user->hasVerifiedEmail()) {
            return redirect('http://localhost:5173/login?verified=1');
        }

        // 4. Proses Verifikasi
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect('http://localhost:5173/login?verified=1');
    }

    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        // 1. Cek apakah user ada
        if (!$user) {
            return response()->json(['message' => 'Email tidak ditemukan.'], 404);
        }

        // 2. Cek apakah sudah verifikasi duluan?
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email ini sudah diverifikasi sebelumnya. Silakan login.'], 400);
        }

        // 3. Kirim ulang notifikasi (Bawaan Laravel)
        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Link verifikasi baru telah dikirim ke email Anda.']);
    }
}
