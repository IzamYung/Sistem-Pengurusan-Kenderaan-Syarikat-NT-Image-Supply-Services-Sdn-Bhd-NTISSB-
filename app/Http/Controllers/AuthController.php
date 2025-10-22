<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Show the login page
     */
    public function login()
    {
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

        // store session data
        $request->session()->put([
            'loginId' => $user->id_pekerja,
            'role'    => $user->role,
        ]);
        $request->session()->save();

        // redirect based on role
        $redirectPath = $user->role === 'admin' 
            ? 'admin/dashboard' 
            : 'user/dashboard';

        return redirect($redirectPath);
    }

    /**
     * Handle user logout
     */
    public function logout()
    {
        Session::forget('loginId');
        Session::forget('role');

        return redirect('login');
    }
}
