<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    /**
     * Menampilkan daftar akun karyawan.
     */
    public function index(): View
    {
        $employees = User::where('role', 'staff')
            ->orderBy('name')
            ->get();

        return view('employees.index', compact('employees'));
    }

    /**
     * Menambahkan akun karyawan.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'staff',
        ]);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Akun karyawan berhasil ditambahkan.');
    }

    /**
     * Mengubah data akun karyawan.
     */
    public function update(Request $request, User $employee): RedirectResponse
    {
        abort_unless($employee->role === 'staff', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($employee->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $employee->name = $validated['name'];
        $employee->email = $validated['email'];

        if (!empty($validated['password'])) {
            $employee->password = Hash::make($validated['password']);
        }

        $employee->save();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Menghapus akun karyawan.
     */
    public function destroy(User $employee): RedirectResponse
    {
        abort_unless($employee->role === 'staff', 404);

        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Akun karyawan berhasil dihapus.');
    }
}
