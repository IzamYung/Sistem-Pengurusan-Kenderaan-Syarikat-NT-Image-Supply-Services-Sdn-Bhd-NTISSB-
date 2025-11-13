<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $users = User::where('role', 'user')
            ->when($query, function ($q) use ($query) {
                $q->where('nama', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%");
            })
            ->orderBy('nama', 'asc')
            ->paginate(10); // paginate 10 users per page

        return view('admin_site.senarai_pengguna', [
            'users' => $users,
            'editUser' => null,
            'tambahMode' => false
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $users = User::where('role', 'user')
            ->when($query, function($q) use ($query) {
                $q->where('nama', 'like', "%{$query}%");
            })
            ->get();

        return response()->json($users);
    }

    public function create()
    {
        return view('admin_site.senarai_pengguna', [
            'users' => [],
            'editUser' => null,
            'tambahMode' => true
        ]);
    }

    public function edit($id)
    {
        $users = User::where('role', 'user')->get();
        $editUser = User::findOrFail($id);
        return view('admin_site.senarai_pengguna', [
            'users' => $users,
            'editUser' => $editUser,
            'tambahMode' => false
        ]);
    }

    // ADD
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pekerja' => 'required|unique:users,id_pekerja',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'jawatan' => 'nullable|string|max:255',
            'no_tel' => 'nullable|string|max:20',
        ], [
            'id_pekerja.unique' => 'ID Pekerja sudah digunakan.',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'user';
        User::create($validated);

        return redirect()->route('admin_site.senarai_pengguna')->with('success', 'Pengguna baru berjaya ditambah!');
    }

    // EDIT
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'id_pekerja' => 'required|unique:users,id_pekerja,' . $user->id_pekerja . ',id_pekerja',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id_pekerja . ',id_pekerja',
            'jawatan' => 'nullable|string|max:255',
            'no_tel' => 'nullable|string|max:20',
            'password' => 'nullable|min:6',
        ]);

        // Handle password separately
        if ($request->filled('password')) {
            if (Hash::check($request->password, $user->password)) {
                return back()->withErrors(['password' => 'Kata laluan baru tidak boleh sama dengan yang lama.'])->withInput();
            }
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        // Separate ID update
        $newId = $validated['id_pekerja'];
        unset($validated['id_pekerja']); // remove from mass update

        $user->update($validated); // update other fields
        $user->id_pekerja = $newId; // update primary key manually
        $user->save();

        return redirect()->route('admin_site.senarai_pengguna')->with('success', 'Maklumat pengguna dikemas kini!');
    }

    public function destroy(Request $request)
    {
        $ids = $request->ids; // array of user IDs from checkboxes
        if (!$ids || !is_array($ids)) {
            return response()->json(['message' => 'Tiada pengguna dipilih'], 400);
        }

        User::whereIn('id_pekerja', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Pengguna berjaya dipadam']);
    }
}
