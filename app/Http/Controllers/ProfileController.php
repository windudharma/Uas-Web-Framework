<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Mendapatkan semua pengguna dengan role admin
        $adminUsers = User::where('role', 'admin')->get();

        // Meneruskan data user dan adminUsers ke view
        return view('profile.edit', [
            'user' => $request->user(),
            'adminUsers' => $adminUsers,
        ]);
    }


    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        // Validasi data
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // Validasi file gambar
        ]);

        $user = $request->user();
        $user->fill($validated);

        // Reset verifikasi jika email diubah
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Simpan hasil crop foto profil
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }
  


        $user->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    /**
     * Update the role of a user.
     */

     public function updateRole(Request $request)
     {
         $request->validate([
             'email' => 'required|email|exists:users,email',
             'role' => 'required|in:admin,user',
         ]);

         $user = User::where('email', $request->email)->first();
         $user->role = $request->role;
         $user->save();

         return back()->with('status', "Role updated to '{$user->role}' for user with email {$user->email}.");
     }


}
