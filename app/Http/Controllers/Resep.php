<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Recipe;
use App\Models\Comment;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Resep extends Controller
{
    // Store a new recipe
    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'video_path' => 'nullable|string',
                'bahan' => 'required|array',
                'langkah' => 'required|array',
            ]);

            // Simpan resep ke database
            $recipe = Recipe::create([
                'name' => $request->name,
                'description' => $request->description,
                'video_path' => $request->video_path,
                'bahan' => $request->bahan,
                'langkah' => $request->langkah,
            ]);

            return redirect()->route('recipe.index')->with('success', 'Recipe added successfully!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to add recipe.');
        }
    }
    // Show recipes and related comments
    public function show()
    {
        try {
            // Ambil semua resep
            $recipes = Recipe::all();

            // Ambil semua komentar dengan data user terkait
            $comments = Comment::with('user')->get();

            // Hitung jumlah komentar yang belum dibaca
            $unreadCount = Comment::where('isRead', 0)->count();

            // Kirim data resep dan komentar ke view
            return view('resepPage', [
                'recipes' => $recipes,
                'comments' => $comments,
                'counts' => $unreadCount,
            ]);
        } catch (\Exception $e) {
            Log::error('Error displaying recipes or comments: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to load recipes and comments.']);
        }
    }

    // Add a new comment
    public function addComment(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'comment_text' => 'required|string',
                'user_id' => 'required|integer|exists:users,id',
            ]);

            // Cek apakah user ada
            $user = User::find($request->user_id);

            // Simpan komentar
            $comment = Comment::create([
                'comment_text' => $request->comment_text,
                'user_id' => $request->user_id,
                'isRead' => false,
            ]);

            // Return data komentar beserta nama user
            return response()->json([
                'comment' => $comment,
                'authorName' => $user->name,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error adding comment: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to add comment',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Delete a comment
    public function destroy($id)
    {
        try {
            // Mencari komentar berdasarkan ID
            $comment = Comment::findOrFail($id);

            // Menghapus komentar
            $comment->delete();

            // Mengembalikan response JSON jika berhasil
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting comment: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus komentar',
            ]);
        }
    }

    // Search recipes
    public function search(Request $request)
    {
        try {
            $query = $request->input('query');

            // Pencarian berdasarkan nama, deskripsi, atau bahan
            $recipes = Recipe::where('name', 'LIKE', '%' . $query . '%')
                ->orWhere('description', 'LIKE', '%' . $query . '%')
                ->orWhereJsonContains('bahan', $query)
                ->get();

            return view('recipes.search', compact('recipes', 'query'));
        } catch (\Exception $e) {
            Log::error('Error searching recipes: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to perform search.']);
        }

    }

    public function show_all() {
        $data['resep'] = DB::table('recipes')->get()->toArray();

        return view('searchresepPage', compact('data'));
    }

}
