<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        return view($user->role === 'admin' ? 'profile.admin' : 'profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update nama dan email.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        $request->user()->save();

        return Redirect::to(route('profile.edit') . '#profile-info')
            ->with('status', 'profile-updated');
    }

    /**
     * Upload / ganti foto profil.
     */
    public function updatePhoto(Request $request): RedirectResponse
    {
        $request->validateWithBag('updatePhoto', [
            'profile_photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = $request->user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->profile_photo = $request->file('profile_photo')
            ->store('profile-photos', 'public');
        $user->save();

        return Redirect::to(route('profile.edit') . '#profile-photo')
            ->with('status', 'photo-updated');
    }

    /**
     * Hapus foto profil.
     */
    public function destroyPhoto(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->profile_photo = null;
            $user->save();
        }

        return Redirect::to(route('profile.edit') . '#profile-photo')
            ->with('status', 'photo-deleted');
    }

    /**
     * Hapus akun.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}