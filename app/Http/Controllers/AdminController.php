<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function profile()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        return view('admin.profile.profile', [
            'title' => 'Profile',
            'user' => $user,
        ]);
    }

    // 🔹 Update profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|min:6',
        ]);

        // Update data
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Kalau password diisi → update
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profile berhasil diperbarui');
    }
}
