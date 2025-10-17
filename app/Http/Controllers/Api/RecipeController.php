<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        return Recipe::latest()->paginate(10);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        return Recipe::create($request->all());
    }

    public function show(Recipe $recipe)
    {
        return $recipe;
    }

    public function update(Request $request, Recipe $recipe)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $recipe->update($request->all());

        return response()->noContent();
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return response()->noContent();
    }
}
