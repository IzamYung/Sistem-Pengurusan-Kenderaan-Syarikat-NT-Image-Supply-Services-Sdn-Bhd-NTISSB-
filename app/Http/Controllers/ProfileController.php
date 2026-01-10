<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function showProfile(Request $request)
    {
        $userId = $request->session()->get('loginId');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Sila log masuk terlebih dahulu.');
        }

        $user = User::where('id_pekerja', $userId)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Maklumat pengguna tidak dijumpai.');
        }

        if ($user->role === 'admin') {
            return view('admin_site.profile', compact('user'));
        } else {
            return view('user_site.profile', compact('user'));
        }
    }
}