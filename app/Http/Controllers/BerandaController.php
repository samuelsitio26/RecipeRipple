<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    public function index()
    {
        // Hitung total resep yang ada
        $totalRecipes = Recipe::count();

        // Logika bertahap untuk Popular Recipes berdasarkan kondisi website
        if ($totalRecipes >= 20) {
            // Website sudah matang: filter ketat berdasarkan rating >= 4
            $popularRecipes = Recipe::with(['kategori', 'user'])
                ->withCount('comments')
                ->withAvg('ratings', 'rating')
                ->having('ratings_avg_rating', '>=', 4)
                ->orderByDesc('comments_count')
                ->orderByDesc('views_count')
                ->orderByDesc('ratings_avg_rating')
                ->limit(4)
                ->get();

            // Jika masih kurang dari 4, tambah dengan yang rating >= 3
            if ($popularRecipes->count() < 4) {
                $additionalRecipes = Recipe::with(['kategori', 'user'])
                    ->withCount('comments')
                    ->withAvg('ratings', 'rating')
                    ->having('ratings_avg_rating', '>=', 3)
                    ->whereNotIn('id', $popularRecipes->pluck('id'))
                    ->orderByDesc('comments_count')
                    ->orderByDesc('views_count')
                    ->orderByDesc('ratings_avg_rating')
                    ->limit(4 - $popularRecipes->count())
                    ->get();

                $popularRecipes = $popularRecipes->merge($additionalRecipes);
            }
        } elseif ($totalRecipes >= 10) {
            // Website berkembang: filter sedang berdasarkan rating >= 3
            $popularRecipes = Recipe::with(['kategori', 'user'])
                ->withCount('comments')
                ->withAvg('ratings', 'rating')
                ->having('ratings_avg_rating', '>=', 3)
                ->orderByDesc('comments_count')
                ->orderByDesc('views_count')
                ->orderByDesc('ratings_avg_rating')
                ->limit(4)
                ->get();

            // Jika kurang dari 4, tambah dengan resep terpopuler lainnya
            if ($popularRecipes->count() < 4) {
                $additionalRecipes = Recipe::with(['kategori', 'user'])
                    ->withCount('comments')
                    ->withAvg('ratings', 'rating')
                    ->whereNotIn('id', $popularRecipes->pluck('id'))
                    ->orderByDesc('comments_count')
                    ->orderByDesc('views_count')
                    ->orderByDesc('created_at')
                    ->limit(4 - $popularRecipes->count())
                    ->get();

                $popularRecipes = $popularRecipes->merge($additionalRecipes);
            }
        } else {
            // Website baru: tampilkan resep apa saja yang tersedia (prioritas terbaru dan yang ada interaksi)
            $popularRecipes = Recipe::with(['kategori', 'user'])
                ->withCount('comments')
                ->withAvg('ratings', 'rating')
                ->orderByDesc('comments_count')
                ->orderByDesc('views_count')
                ->orderByDesc('created_at')
                ->limit(4)
                ->get();
        }

        // Ambil kategori untuk bagian "Telusuri Berdasarkan" dengan statistik
        $categories = Kategori::withCount(['recipes as recipe_count'])
            ->limit(3)
            ->get()
            ->map(function ($category) {
                // Hitung statistik dasar untuk kategori
                $recipeStats = Recipe::where('kategori_id', $category->id)
                    ->withAvg('ratings', 'rating')
                    ->withCount('comments')
                    ->first();

                $category->avg_rating = $recipeStats ? ($recipeStats->ratings_avg_rating ?: 4.5) : 4.5;
                $category->total_comments = $recipeStats ? $recipeStats->comments_count : 0;

                return $category;
            });

        return view('berandaPage', compact('popularRecipes', 'categories'));
    }
}
