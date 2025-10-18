<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RatingController extends Controller
{
    public function store(Request $request, $recipeId)
    {
        try {
            $validated = $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'nullable|string|max:1000',
                'guest_name' => 'nullable|string|max:255',
                'guest_email' => 'nullable|email|max:255'
            ], [
                'rating.required' => 'Rating harus dipilih',
                'rating.min' => 'Rating minimal 1 bintang',
                'rating.max' => 'Rating maksimal 5 bintang',
                'review.max' => 'Review maksimal 1000 karakter',
                'guest_email.email' => 'Format email tidak valid'
            ]);

            $recipe = Recipe::findOrFail($recipeId);

            DB::beginTransaction();

            if (Auth::check()) {
                // User yang login
                $rating = Rating::updateOrCreate(
                    [
                        'recipe_id' => $recipeId,
                        'user_id' => Auth::id()
                    ],
                    [
                        'rating' => $validated['rating'],
                        'review' => $validated['review'] ?? null
                    ]
                );
            } else {
                // Guest user
                $guestIdentifier = md5($request->ip() . $request->userAgent());

                $rating = Rating::updateOrCreate(
                    [
                        'recipe_id' => $recipeId,
                        'guest_identifier' => $guestIdentifier
                    ],
                    [
                        'rating' => $validated['rating'],
                        'review' => $validated['review'] ?? null,
                        'guest_name' => $validated['guest_name'] ?? 'Guest',
                        'guest_email' => $validated['guest_email'] ?? null
                    ]
                );
            }

            $recipe->updateRating();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Rating berhasil disimpan',
                'data' => [
                    'average_rating' => $recipe->average_rating,
                    'total_ratings' => $recipe->total_ratings,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving rating: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan'], 500);
        }
    }

    public function getUserRating($recipeId)
    {
        try {
            $rating = null;
            if (Auth::check()) {
                $rating = Rating::where('recipe_id', $recipeId)->where('user_id', Auth::id())->first();
            } else {
                $guestIdentifier = md5(request()->ip() . request()->userAgent());
                $rating = Rating::where('recipe_id', $recipeId)->where('guest_identifier', $guestIdentifier)->first();
            }

            return response()->json([
                'success' => true,
                'rating' => $rating ? $rating->rating : null,
                'review' => $rating ? $rating->review : null
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $rating = Rating::findOrFail($id);
            if (Auth::check() && (Auth::id() === $rating->user_id || Auth::user()->role === 'admin')) {
                $recipeId = $rating->recipe_id;
                $rating->delete();
                Recipe::find($recipeId)->updateRating();
                return response()->json(['success' => true, 'message' => 'Rating berhasil dihapus']);
            }
            return response()->json(['success' => false, 'message' => 'Tidak memiliki izin'], 403);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }

    public function adminIndex()
    {
        try {
            $ratings = Rating::with(['recipe', 'user'])
                ->latest()
                ->paginate(15);

            // Calculate statistics
            $totalRatings = Rating::count();
            $averageRating = Rating::avg('rating');
            $topRatedRecipes = Recipe::where('average_rating', '>=', 4)->count();

            return view('Admin.ratings', compact('ratings', 'totalRatings', 'averageRating', 'topRatedRecipes'));
        } catch (\Exception $e) {
            Log::error('Error in admin rating index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan.');
        }
    }

    public function getRecipeRatings($recipeId)
    {
        try {
            $recipe = Recipe::findOrFail($recipeId);
            $ratings = $recipe->ratings()->with('user')->latest()->paginate(10);

            return response()->json([
                'success' => true,
                'ratings' => $ratings,
                'average_rating' => $recipe->average_rating,
                'total_ratings' => $recipe->total_ratings
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }
}
