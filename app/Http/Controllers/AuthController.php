<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Show the login page (auto-redirect if already logged in)
     */
    public function login(Request $request)
    {
        // Check if user already logged in
        if ($request->session()->has('loginId')) {
            $role = $request->session()->get('role');

            return redirect($role === 'admin' ? 'admin/dashboard' : 'user/dashboard');
        }

        // If not logged in, show login view
        return view('auth.login');
    }

    /**
     * Handle user login
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

        // Store session data
        $request->session()->put([
            'loginId' => $user->id_pekerja,
            'role'    => $user->role,
        ]);

        // Redirect based on role
        return redirect($user->role === 'admin' ? 'admin/dashboard' : 'user/dashboard');
    }

    /**
     * Handle user logout
     */
    public function logout()
    {
        Session::forget(['loginId', 'role']);

        return redirect('login');
    }
}
