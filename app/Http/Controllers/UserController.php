<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
{
    $perPage = in_array($request->per_page, [10, 25, 50, 100]) ? (int)$request->per_page : 10;

    $users = User::latest()
        ->when($request->filled('search'), fn($q) =>
            $q->where('name', 'like', '%'.$request->search.'%')
              ->orWhere('email', 'like', '%'.$request->search.'%')
        )
        ->when($request->filled('role'), fn($q) =>
            $q->where('role', $request->role)
        )
        ->paginate($perPage)
        ->appends($request->query());

    return view('users', compact('users'));
}

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:manajer,superadmin,petugas,security',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'avatar'   => $avatarPath,
        ]);

        return back()->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,'.$user->id,
            'role'     => 'required|in:manajer,superadmin,petugas,security',
            'password' => 'nullable|min:6',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return back()->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun yang sedang aktif.');
        }

        if ($user->avatar) Storage::disk('public')->delete($user->avatar);

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
        public function updateAvatar(Request $request)
    {
        $request->validate(['avatar' => ['required', 'image', 'max:2048']]);
        $user = auth()->user();
        if ($user->avatar) Storage::disk('public')->delete($user->avatar);
        $user->update(['avatar' => $request->file('avatar')->store('avatars', 'public')]);
        return back()->with('success', 'Foto profil berhasil diubah.');
    }

    public function deleteAvatar()
    {
        $user = auth()->user();
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }
        return back()->with('success', 'Foto profil berhasil dihapus.');
    }
}