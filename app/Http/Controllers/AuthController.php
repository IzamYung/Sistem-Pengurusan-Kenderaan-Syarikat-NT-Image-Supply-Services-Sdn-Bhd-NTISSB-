<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->session()->has('loginId')) {
            $role = $request->session()->get('role');
            return redirect()->route($role === 'admin' ? 'admin_site.halaman_utama' : 'user_site.permohonan.index');
        }

        if ($request->hasCookie('remember_token')) {
            $token = $request->cookie('remember_token');
            $user = User::where('remember_token', $token)->first();

            if ($user) {
                $request->session()->put([
                    'loginId' => $user->id_pekerja,
                    'role'    => $user->role,
                ]);

                return redirect()->route($user->role === 'admin' ? 'admin_site.halaman_utama' : 'user_site.permohonan.index');
            }
        }

        return view('auth.login');
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('fail', 'Invalid credentials');
        }

        $request->session()->regenerate();

        $request->session()->put([
            'loginId' => $user->id_pekerja,
            'role'    => $user->role,
        ]);

        $token = bin2hex(random_bytes(32));
        $user->update(['remember_token' => $token]);
        cookie()->queue('remember_token', $token, 60 * 24 * 7);

        config(['session.lifetime' => 60 * 24 * 7]);
        config(['session.expire_on_close' => false]);

        return redirect()->route($user->role === 'admin' ? 'admin_site.halaman_utama' : 'user_site.permohonan.index');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::forget(['loginId', 'role']);

        cookie()->queue(cookie()->forget('remember_token'));

        return redirect('login')->with('success', 'Logged out successfully');
    }
}