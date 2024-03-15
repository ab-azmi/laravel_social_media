<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function index(User $user){
        return Inertia::render('Profile/View', [
            'mustVerifyEmail' => $user instanceof MustVerifyEmail,
            'status' => session('status'),
            'user' => new UserResource($user)
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return back()->with('status', 'User updated successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updateImage(Request $request, User $user){
        
        $request->validate([
            'cover' => ['image', 'nullable', 'mimes:jpeg,png,jpg,svg'],
            'avatar' => ['image', 'nullable', 'mimes:jpeg,png,jpg,svg'],
        ]);

        //save file cover to cover/user-id/cover.jpg
        if($request->hasFile('cover')){
            $cover_path = $request->file('cover')->storeAs($user->id, 'cover', 'public');
            $cover_path = asset('storage/'.$cover_path);
            $user->update(['cover_path' => $cover_path]);
        }

        //save file avatar to avatar/user-id/avatar.jpg
        if($request->hasFile('avatar')){
            $avatar_path = $request->file('avatar')->storeAs($user->id, 'avatar', 'public');
            $avatar_path = asset('storage/'.$avatar_path);
            $user->update(['avatar_path' => $avatar_path]);
        }

        return back()->with('status', 'Profile image updated successfully!');
    }
}
