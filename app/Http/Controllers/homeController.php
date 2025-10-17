<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Kategori;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Kategori::active()->withCount('recipes')->orderBy('recipes_count', 'desc')->get();
        $popularRecipes = Recipe::with('kategori')->popular(8)->get();
        $latestRecipes = Recipe::with('kategori')->latest()->limit(8)->get();

        return view('HomePage', compact('categories', 'popularRecipes', 'latestRecipes'));
    }
}
