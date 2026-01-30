<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::with('ruangan')
            ->latest()
            ->paginate(10);
            
        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();
        
        return view('users.create', compact('ruangans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'in:admin,staff'],
            'ruangan_id' => ['nullable', 'exists:ruangans,id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email sudah digunakan',
            'role.required' => 'Role tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'ruangan_id' => $validated['ruangan_id'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    public function show(User $user): View
    {
        $user->load('ruangan');
        
        return view('users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();
        
        return view('users.edit', compact('user', 'ruangans'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:admin,staff'],
            'ruangan_id' => ['nullable', 'exists:ruangans,id'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email sudah digunakan',
            'role.required' => 'Role tidak boleh kosong',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'ruangan_id' => $validated['ruangan_id'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}