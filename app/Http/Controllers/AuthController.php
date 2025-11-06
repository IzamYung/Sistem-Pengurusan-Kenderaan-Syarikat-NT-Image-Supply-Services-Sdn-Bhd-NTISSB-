<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * 🩵 Show login page
     * Auto-redirects to dashboard if already logged in
     */
    public function login(Request $request)
    {
        // Check if user already logged in via session
        if ($request->session()->has('loginId')) {
            $role = $request->session()->get('role');
            return redirect()->route($role === 'admin' ? 'admin_site.halaman_utama' : 'user_site.dashboard');
        }

        // Check if remember_token cookie exists (auto-login)
        if ($request->hasCookie('remember_token')) {
            $token = $request->cookie('remember_token');
            $user = User::where('remember_token', $token)->first();

            if ($user) {
                // Restore session automatically
                $request->session()->put([
                    'loginId' => $user->id_pekerja,
                    'role'    => $user->role,
                ]);

                return redirect()->route($user->role === 'admin' ? 'admin_site.halaman_utama' : 'user_site.dashboard');
            }
        }

        // Otherwise, show the login view
        return view('auth.login');
    }

    /**
     * 💫 Handle login request
     */
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

        // Regenerate session (security)
        $request->session()->regenerate();

        // Store session data
        $request->session()->put([
            'loginId' => $user->id_pekerja,
            'role'    => $user->role,
        ]);

        // 💾 Generate and store a persistent remember_token (auto-login later)
        $token = bin2hex(random_bytes(32));
        $user->update(['remember_token' => $token]);
        cookie()->queue('remember_token', $token, 60 * 24 * 7); // 7 days

        // ⚙️ Optional: extend session lifetime for long-term login
        config(['session.lifetime' => 60 * 24 * 7]); // 7 days
        config(['session.expire_on_close' => false]);

        // Redirect to the correct dashboard
        return redirect()->route($user->role === 'admin' ? 'admin_site.halaman_utama' : 'user_site.dashboard');
    }

    /**
     * 🚪 Logout user (clear session & cookie)
     */
    public function logout(Request $request)
    {
        // Clear all session data
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::forget(['loginId', 'role']);

        // Remove remember_token cookie
        cookie()->queue(cookie()->forget('remember_token'));

        return redirect('login')->with('success', 'Logged out successfully');
    }
}
