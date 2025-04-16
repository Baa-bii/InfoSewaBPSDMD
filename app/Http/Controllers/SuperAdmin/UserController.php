<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): View {
        $users = User::orderBy('name', 'asc')->get();
        return view('superAdmin.data_user', compact('users'));
    }
    
    public function create(){
        return view('superAdmin.create_user');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => 'required|string|max:255',
            'password' => 'required|string|min:6|max:255',
        ]);

        // Enkripsi password sebelum menyimpan
        $validatedData['password'] = bcrypt($validatedData['password']);

        // Simpan data ke database
        User::create($validatedData);

        return redirect()->route('sup-admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $users = User::findOrFail($id);
        return view('superAdmin.edit_user', compact('users'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => 'required|string|max:255',
            'password' => 'required|string|min:6|max:255',
        ]);

        $exists = User::where('name', $validated['name'])
                ->where('email', $validated['email'])
                ->where('id', '!=', $id)
                ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['name' => 'User ini sudah Ada.']);
        }

        // Find the RuangKelas by ID
        $users = User::findOrFail($id);

        // Update the RuangKelas instance
        $users->update($validated);

        // Redirect back with a success message
        return redirect()->route('sup-admin.user.update')->with('success', 'User updated successfully.');
    }
    
    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect()->route('sup-admin.user.index')->with('success', 'User berhasil dihapus.');
    }

}
