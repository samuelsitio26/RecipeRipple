<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{

    public function index($recipeId)
    {
        $comments = Comment::where('recipe_id', $recipeId)->get();
        return view('comments.index', compact('comments'));
    }

    // Tambah komentar baru
    public function store(Request $request)
    {
        try {
            $request->validate([
                'comment_text' => 'required|string',
                'user_id' => 'required|exists:users,id',
                'recipe_id' => 'required|exists:recipes,id',
            ]);

            $comment = Comment::create([
                'comment_text' => $request->comment_text,
                'user_id' => $request->user_id,
                'recipe_id' => $request->recipe_id,
                'isRead' => false,
            ]);

            // Buat notifikasi untuk pemilik resep
            $recipe = Recipe::find($request->recipe_id);
            Notification::create([
                'user_id' => $recipe->user_id,
                'recipe_id' => $recipe->id,
                'type' => 'comment',
                'message' => 'Ada komentar baru pada resep Anda.',
            ]);

            return response()->json([
                'comment' => $comment,
                'authorName' => $comment->user->name, // Mengambil nama user dari relasi
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

    // Hapus komentar
    public function destroy($id)
    {
        try {
            $comment = Comment::findOrFail($id);

            // Periksa apakah pengguna yang sedang login adalah pemilik komentar
            if ($comment->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to delete this comment.',
                ], 403);
            }

            $comment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Comment deleted successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting comment: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete comment.',
            ]);
        }
    }

    // Ambil semua komentar dengan status belum dibaca
    public function unreadComments()
    {
        try {
            $unreadComments = Comment::where('isRead', false)->with('user')->get();
            return response()->json(['comments' => $unreadComments], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching unread comments: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load unread comments.'], 500);
        }
    }

    // Admin index untuk menampilkan semua komentar
    public function adminIndex()
    {
        try {
            $comments = Comment::with(['user', 'recipe'])
                ->latest()
                ->paginate(15);

            // Calculate statistics
            $totalComments = Comment::count();
            $recentComments = Comment::where('created_at', '>=', now()->subDays(7))->count();
            $unreadComments = Comment::where('isRead', false)->count();

            return view('Admin.komentarPage', compact('comments', 'totalComments', 'recentComments', 'unreadComments'));
        } catch (\Exception $e) {
            Log::error('Error in admin comment index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan.');
        }
    }

    // Admin delete comment
    public function adminDestroy($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();

            return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting comment by admin: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus komentar.');
        }
    }
}
