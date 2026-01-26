<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan halaman pengguna
    public function index()
    {
        $users = User::where('role', 'user')->get(); // Hanya mengambil pengguna dengan role 'user'
        return view('admin.userPage', compact('users')); // Mengirim data pengguna ke view
    }

    // Menambah pengguna baru
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Membuat pengguna baru
        User::create([
            'name' => $request->name,
            'nomor_telepon' => $request->nomor_telepon,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password  
            'role' => 'user', // Set default role 'user'
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    // Mengupdate data pengguna yang ada
    public function update(Request $request, $id)

    {
        $user = User::findOrFail($id);

        // Validasi data yang diupdate
        $request->validate([
            'name' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20|unique:users,nomor_telepon,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        // Update data pengguna
        $user->update([
            'name' => $request->name,
            'nomor_telepon' => $request->nomor_telepon,
            'email' => $request->email,
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');
    }

    // Menghapus pengguna
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Menghapus pengguna dari database
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}
