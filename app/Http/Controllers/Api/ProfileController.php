<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user(); // Mendapatkan data pengguna yang sedang login

        // Tambahkan link HATEOAS
        $user->links = [
            'self' => route('api.profile.show'),
            'update' => route('api.profile.update'),
            'delete' => route('api.profile.destroy'),
        ];

        return response()->json($user); // Mengembalikan data pengguna dalam format JSON
    }

    public function update(Request $request)
    {
        // Mendapatkan data pengguna yang sedang login
        $user = $request->user();

        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nomor_telepon' => 'required|string|max:15',
        ]);

        // Update data pengguna
        $user->update([
            'name' => $request->input('name'),       // Mengupdate kolom 'name' dengan input dari request
            'email' => $request->input('email'),     // Mengupdate kolom 'email' dengan input dari request
            'nomor_telepon' => $request->input('nomor_telepon'),     // Mengupdate kolom 'nomor_telepon' dengan input dari request
        ]);

        // Tambahkan link HATEOAS
        $user->links = [
            'self' => route('api.profile.show'),
            'update' => route('api.profile.update'),
            'delete' => route('api.profile.destroy'),
        ];

        // Mengembalikan respon sukses
        return response()->json($user, 200);
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        $user->delete();

        return response()->json([
            'message' => 'Profile deleted successfully',
            'links' => [
                'register' => route('register'),
                'login' => route('login'),
            ]
        ]);
    }
}