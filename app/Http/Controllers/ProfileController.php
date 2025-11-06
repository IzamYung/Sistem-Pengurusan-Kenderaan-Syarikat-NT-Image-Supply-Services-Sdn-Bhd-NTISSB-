<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function showProfile(Request $request)
    {
        // get the user ID from session
        $userId = $request->session()->get('loginId');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Sila log masuk terlebih dahulu.');
        }

        // get user data
        $user = User::where('id_pekerja', $userId)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Maklumat pengguna tidak dijumpai.');
        }

        // render view based on role
        if ($user->role === 'admin') {
            return view('admin_site.profile', compact('user'));
        } else {
            return view('user_site.profile', compact('user'));
        }
    }
}
