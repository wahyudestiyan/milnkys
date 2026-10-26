<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('profile.edit', [
            'user' => request()->user(),
        ]);
    }

    
public function update(Request $request): RedirectResponse
{
    $user = $request->user();

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('users', 'email')->ignore($user->id),
        ],
        'current_password' => [
            'required',
            'current_password',
        ],
        'password' => [
            'nullable',
            'string',
            'min:8',
            'confirmed',
        ],
    ], [
        'email.unique' => 'Email sudah digunakan akun lain.',
        'current_password.required' => 'Password lama wajib diisi.',
        'current_password.current_password' => 'Password lama tidak sesuai.',
        'password.min' => 'Password baru minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
    ]);

    $user->name = $validated['name'];
    $user->email = $validated['email'];

    if (!empty($validated['password'])) {
        $user->password = $validated['password'];
    }

    $user->save();

    return redirect()
        ->route('profile.edit')
        ->with('success', 'Profil berhasil diperbarui.');
}

}
