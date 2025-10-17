<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class RecipeController extends Controller
{
    protected $uploadPaths = [
        'video' => 'uploads/recipe/video',
        'image' => 'uploads/recipe/image',
        'gambar' => 'uploads/recipe/gambar'
    ];

    public function __construct()
    {
        // Ensure upload directories exist
        foreach ($this->uploadPaths as $path) {
            if (!File::exists(public_path($path))) {
                File::makeDirectory(public_path($path), 0755, true);
            }
        }
    }

    public function index(Request $request)
    {
        try {
            $query = Recipe::with('kategori');

            // Filter by category
            if ($request->has('kategori') && $request->kategori != '') {
                $query->where('kategori_id', $request->kategori);
            }

            // Search
            if ($request->has('search') && $request->search != '') {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            }

            // Sort
            $sortBy = $request->get('sort', 'latest');
            switch ($sortBy) {
                case 'popular':
                    $query->orderBy('average_rating', 'desc')
                        ->orderBy('total_ratings', 'desc');
                    break;
                case 'most_viewed':
                    $query->orderBy('views_count', 'desc');
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                default:
                    $query->latest();
            }

            $recipes = $query->paginate(12);
            $categories = Kategori::all();

            return view('recipe.index', compact('recipes', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error fetching recipes: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data resep.');
        }
    }

    public function create()
    {
        try {
            $kategori = Kategori::all();
            return view('recipe.create', compact('kategori'));
        } catch (\Exception $e) {
            Log::error('Error loading create form: ' . $e->getMessage());
            return redirect()->route('recipe.index')->with('error', 'Terjadi kesalahan saat memuat halaman.');
        }
    }

    public function store(Request $request)
    {
        try {
            // Log semua input untuk debugging
            Log::info('Recipe Store - All Input:', $request->all());
            Log::info('Recipe Store - User ID:', ['user_id' => Auth::id()]);

            $validated = $request->validate([
                'name' => 'required|string|max:255|min:3',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'description' => 'required|string|min:10|max:1000',
                'kategori_id' => 'required|exists:kategori,id',
                'bahan' => 'required|array|min:1',
                'langkah' => 'required|array|min:1',
                'video_type' => 'nullable|in:file,youtube,url',
                'video' => 'nullable|mimes:mp4,mov,avi,webm|max:51200',
                'video_url' => 'nullable|url|max:500',
                'langkah_image' => 'sometimes|array',
                'langkah_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ], [
                'name.required' => 'Judul resep wajib diisi.',
                'name.min' => 'Judul resep minimal 3 karakter.',
                'description.required' => 'Deskripsi resep wajib diisi.',
                'description.min' => 'Deskripsi resep minimal 10 karakter.',
                'kategori_id.required' => 'Kategori wajib dipilih.',
                'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
                'bahan.required' => 'Bahan-bahan wajib diisi.',
                'bahan.min' => 'Minimal harus ada 1 bahan.',
                'langkah.required' => 'Langkah-langkah wajib diisi.',
                'langkah.min' => 'Minimal harus ada 1 langkah.',
                'gambar.image' => 'File gambar utama harus berupa gambar.',
                'gambar.max' => 'Ukuran gambar utama maksimal 5 MB.',
                'video.mimes' => 'Format video harus MP4, MOV, AVI, atau WEBM.',
                'video.max' => 'Ukuran video maksimal 50 MB.',
                'video_url.url' => 'URL YouTube tidak valid.',
                'langkah_image.*.image' => 'File gambar langkah harus berupa gambar.',
                'langkah_image.*.max' => 'Ukuran gambar langkah maksimal 5 MB (per gambar).',
            ]);

            DB::beginTransaction();

            $validated['bahan'] = array_filter($validated['bahan'], fn($item) => !empty(trim($item)));
            $validated['langkah'] = array_filter($validated['langkah'], fn($item) => !empty(trim($item)));

            // Handle langkah images
            $langkah_images = [];
            if ($request->hasFile('langkah_image')) {
                foreach ($request->file('langkah_image') as $file) {
                    if ($file && $file->isValid()) {
                        $filename = $this->generateUniqueFilename($file, 'image');
                        $file->move(public_path('uploads/recipe/image'), $filename);
                        $langkah_images[] = $filename;
                    } else {
                        $langkah_images[] = null;
                    }
                }
            }

            // Handle video
            $video_filename = null;
            $video_url = null;
            $video_type = $request->input('video_type');

            if ($video_type === 'file' && $request->hasFile('video')) {
                $file = $request->file('video');
                $video_filename = $this->generateUniqueFilename($file, 'video');
                $file->move(public_path('uploads/recipe/video'), $video_filename);
            } elseif ($video_type === 'youtube' && $request->has('video_url')) {
                $video_url = $request->input('video_url');
            }

            // Handle main image
            $gambar_filename = null;
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $gambar_filename = $this->generateUniqueFilename($file, 'gambar');
                $file->move(public_path('uploads/recipe/gambar'), $gambar_filename);
            }

            // Create recipe
            Log::info('About to create recipe with data:', [
                'video_path' => $video_filename,
                'video_type' => $video_type,
                'video_url' => $video_url,
                'name' => trim($validated['name']),
                'gambar' => $gambar_filename,
                'description' => trim($validated['description']),
                'kategori_id' => $validated['kategori_id'],
                'bahan' => $validated['bahan'],
                'langkah' => $validated['langkah'],
                'langkah_image' => $langkah_images,
                'user_id' => Auth::id(),
            ]);

            $recipe = Recipe::create([
                'video_path' => $video_filename,
                'video_type' => $video_type,
                'video_url' => $video_url,
                'name' => trim($validated['name']),
                'gambar' => $gambar_filename,
                'description' => trim($validated['description']),
                'kategori_id' => $validated['kategori_id'],
                'bahan' => $validated['bahan'],  // Kirim sebagai array (akan di-cast ke JSON otomatis)
                'langkah' => $validated['langkah'],  // Kirim sebagai array (akan di-cast ke JSON otomatis)
                'langkah_image' => $langkah_images,  // Kirim sebagai array (akan di-cast ke JSON otomatis)
                'user_id' => Auth::id(),
            ]);

            Log::info('Recipe object after create:', [
                'recipe_exists' => $recipe ? 'yes' : 'no',
                'recipe_id' => $recipe ? $recipe->id : 'null',
                'recipe_attributes' => $recipe ? $recipe->getAttributes() : 'null'
            ]);

            Log::info('Recipe Created Successfully:', ['recipe_id' => $recipe->id, 'recipe_name' => $recipe->name]);

            DB::commit();

            return redirect('/resep')->with('success', 'Resep berhasil ditambahkan.');

        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error('Recipe Validation Failed:', [
                'errors' => $e->errors(),
                'input' => $request->except(['video', 'gambar', 'langkah_image'])
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating recipe: ' . $e->getMessage());
            Log::error('Exception trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        try {
            $recipe = Recipe::with([
                'kategori',
                'ratings' => function ($query) {
                    $query->with('user')->latest()->limit(5);
                },
                'comments'
            ])->findOrFail($id);

            // Increment views
            $recipe->incrementViews();

            // Get user's rating if exists
            $userRating = null;
            if (Auth::check()) {
                $userRating = $recipe->ratings()->where('user_id', Auth::id())->first();
            }

            // Get related recipes
            $relatedRecipes = Recipe::where('kategori_id', $recipe->kategori_id)
                ->where('id', '!=', $recipe->id)
                ->orderBy('average_rating', 'desc')
                ->limit(4)
                ->get();

            return view('recipe.show', compact('recipe', 'userRating', 'relatedRecipes'));
        } catch (\Exception $e) {
            Log::error('Error showing recipe: ' . $e->getMessage());
            return redirect()->route('recipe.index')->with('error', 'Resep tidak ditemukan.');
        }
    }

    public function edit($id)
    {
        try {
            $recipe = Recipe::findOrFail($id);

            // Check permission
            if (Auth::user()->role !== 'admin' && Auth::id() !== $recipe->user_id) {
                return redirect()->route('recipe.index')->with('error', 'Anda tidak memiliki izin untuk mengedit resep ini.');
            }

            $kategori = Kategori::all();

            $data = [
                'recipe' => $recipe,
                'kategori' => $kategori
            ];

            return view('recipe.edit', compact('data'));
        } catch (\Exception $e) {
            Log::error('Error loading edit form: ' . $e->getMessage());
            return redirect()->route('recipe.index')->with('error', 'Resep tidak ditemukan.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $recipe = Recipe::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255|min:3',
                'description' => 'required|string|min:10|max:1000',
                'kategori_id' => 'required|exists:kategori,id',
                'bahan' => 'required|array|min:1',
                'langkah' => 'required|array|min:1',
                'video_type' => 'nullable|in:file,youtube,url',
                'video' => 'nullable|mimes:mp4,mov,avi,webm|max:51200',
                'video_url' => 'nullable|url',
                'langkah_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'check_video' => 'nullable|string',
                'remove_image' => 'nullable|string'
            ], [
                'name.required' => 'Judul resep wajib diisi.',
                'name.min' => 'Judul resep minimal 3 karakter.',
                'description.required' => 'Deskripsi resep wajib diisi.',
                'description.min' => 'Deskripsi resep minimal 10 karakter.',
                'kategori_id.required' => 'Kategori wajib dipilih.',
                'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
                'bahan.required' => 'Bahan-bahan wajib diisi.',
                'bahan.min' => 'Minimal harus ada 1 bahan.',
                'langkah.required' => 'Langkah-langkah wajib diisi.',
                'langkah.min' => 'Minimal harus ada 1 langkah.',
                'gambar.image' => 'File gambar utama harus berupa gambar.',
                'gambar.max' => 'Ukuran gambar utama maksimal 5 MB.',
                'video.mimes' => 'Format video harus MP4, MOV, AVI, atau WEBM.',
                'video.max' => 'Ukuran video maksimal 50 MB.',
                'video_url.url' => 'URL video tidak valid.',
                'langkah_image.*.image' => 'File gambar langkah harus berupa gambar.',
                'langkah_image.*.max' => 'Ukuran gambar langkah maksimal 5 MB (per gambar).',
            ]);

            DB::beginTransaction();

            $recipe->name = trim($validated['name']);
            $recipe->description = trim($validated['description']);
            $recipe->kategori_id = $validated['kategori_id'];
            $recipe->bahan = array_filter($validated['bahan']);
            $recipe->langkah = array_filter($validated['langkah']);

            // Handle video removal
            if ($request->input('check_video') == 'remove') {
                if ($recipe->video_path) {
                    $this->deleteFile($recipe->video_path, 'video');
                }
                $recipe->video_path = null;
                $recipe->video_url = null;
                $recipe->video_type = null;
            }

            // Handle video type
            $videoType = $request->input('video_type');

            if ($videoType === 'file' && $request->hasFile('video')) {
                // Upload file video
                if ($recipe->video_path) {
                    $this->deleteFile($recipe->video_path, 'video');
                }

                $file = $request->file('video');
                $filename = $this->generateUniqueFilename($file, 'video');
                $file->move(public_path('uploads/recipe/video'), $filename);

                $recipe->video_path = $filename;
                $recipe->video_url = null;
                $recipe->video_type = 'file';

            } elseif ($videoType === 'youtube' && $request->has('video_url')) {
                // YouTube URL
                if ($recipe->video_path) {
                    $this->deleteFile($recipe->video_path, 'video');
                }

                $recipe->video_path = null;
                $recipe->video_url = $request->input('video_url');
                $recipe->video_type = 'youtube';
            }

            // Handle main image removal
            if ($request->input('remove_image') == '1') {
                if ($recipe->gambar) {
                    $this->deleteFile($recipe->gambar, 'gambar');
                    $recipe->gambar = null;
                }
            }
            // Handle main image upload
            elseif ($request->hasFile('gambar')) {
                if ($recipe->gambar) {
                    $this->deleteFile($recipe->gambar, 'gambar');
                }

                $file = $request->file('gambar');
                $filename = $this->generateUniqueFilename($file, 'gambar');
                $file->move(public_path('uploads/recipe/gambar'), $filename);
                $recipe->gambar = $filename;
            }

            // Handle step images
            $existing_images = $recipe->langkah_image ?? [];
            $new_images = [];

            if ($request->hasFile('langkah_image')) {
                foreach ($request->file('langkah_image') as $index => $file) {
                    if ($file && $file->isValid()) {
                        $filename = $this->generateUniqueFilename($file, 'image');
                        $file->move(public_path('uploads/recipe/image'), $filename);
                        $new_images[] = $filename;
                    } else {
                        $new_images[] = $existing_images[$index] ?? null;
                    }
                }
            } else {
                $new_images = $existing_images;
            }

            $this->cleanupOrphanedStepImages($existing_images, $new_images);
            $recipe->langkah_image = $new_images;

            $recipe->updated_at = now();
            $recipe->save();

            DB::commit();

            return redirect()->route('recipe.edit', $id)->with('success', 'Resep berhasil diperbarui.');

        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating recipe: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $recipe = Recipe::findOrFail($id);

            // Check permission
            if (Auth::user()->role !== 'admin' && Auth::id() !== $recipe->user_id) {
                return redirect()->route('recipe.index')->with('error', 'Anda tidak memiliki izin untuk menghapus resep ini.');
            }

            DB::beginTransaction();

            // Delete associated files
            $this->deleteFile($recipe->video_path, 'video');
            $this->deleteFile($recipe->gambar, 'gambar');

            $step_images = $recipe->langkah_image ?? [];
            foreach ($step_images as $image) {
                if ($image) {
                    $this->deleteFile($image, 'image');
                }
            }

            $recipe->delete();

            DB::commit();

            return redirect()->route('recipe.index')->with('success', 'Resep berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting recipe: ' . $e->getMessage());
            return redirect()->route('recipe.index')->with('error', 'Terjadi kesalahan saat menghapus resep.');
        }
    }

    public function getByCategory($categorySlug)
    {
        try {
            $category = Kategori::where('slug', $categorySlug)->firstOrFail();

            $recipes = Recipe::where('kategori_id', $category->id)
                ->orderBy('average_rating', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            return view('recipe.by-category', compact('recipes', 'category'));
        } catch (\Exception $e) {
            Log::error('Error fetching recipes by category: ' . $e->getMessage());
            return redirect()->route('recipe.index')->with('error', 'Kategori tidak ditemukan.');
        }
    }

    public function getPopular()
    {
        try {
            $recipes = Recipe::with('kategori')
                ->popular(20)
                ->get();

            return view('recipe.popular', compact('recipes'));
        } catch (\Exception $e) {
            Log::error('Error fetching popular recipes: ' . $e->getMessage());
            return redirect()->route('recipe.index')->with('error', 'Terjadi kesalahan.');
        }
    }

    // Helper methods
    private function generateUniqueFilename($file, $type)
    {
        $extension = $file->getClientOriginalExtension();
        $timestamp = now()->format('YmdHis');
        $random = uniqid();
        return "{$type}_{$timestamp}_{$random}.{$extension}";
    }

    private function deleteFile($filename, $type)
    {
        $paths = [
            'video' => 'uploads/recipe/video',
            'image' => 'uploads/recipe/image',
            'gambar' => 'uploads/recipe/gambar'
        ];

        if ($filename && isset($paths[$type])) {
            $filePath = public_path($paths[$type] . '/' . $filename);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
    }

    private function cleanupOrphanedStepImages($oldImages, $newImages)
    {
        $orphaned = array_diff($oldImages, $newImages);
        foreach ($orphaned as $image) {
            if ($image) {
                $this->deleteFile($image, 'image');
            }
        }
    }

    private function optimizeAndSaveImage($file, $path, $maxWidth = 1200, $maxHeight = 900)
    {
        try {
            // Check if Intervention Image is available
            if (class_exists('Intervention\Image\Facades\Image')) {
                $img = Image::make($file);

                // Maintain aspect ratio
                $img->resize($maxWidth, $maxHeight, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                // Optimize quality
                $img->save($path, 85);
            } else {
                // Fallback: just move the file
                $file->move(dirname($path), basename($path));
            }
        } catch (\Exception $e) {
            Log::warning('Image optimization failed, using fallback: ' . $e->getMessage());
            $file->move(dirname($path), basename($path));
        }
    }

    // Admin functions
    public function adminIndex()
    {
        try {
            $recipes = Recipe::with(['kategori', 'user'])
                ->withCount('ratings')
                ->latest()
                ->paginate(15);

            return view('Admin.resepPage', compact('recipes'));
        } catch (\Exception $e) {
            Log::error('Error in admin index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan.');
        }
    }

    public function adminEdit($id)
    {
        return $this->edit($id);
    }

    public function search(Request $request)
    {
        try {
            $query = $request->input('q', '');
            $categoryId = $request->input('category');

            $recipes = Recipe::with('kategori')
                ->when($query, function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%")
                        ->orWhere('bahan', 'like', "%{$query}%");
                })
                ->when($categoryId, function ($q) use ($categoryId) {
                    $q->where('kategori_id', $categoryId);
                })
                ->orderBy('average_rating', 'desc')
                ->paginate(12);

            $categories = Kategori::all();

            return view('recipe.search', compact('recipes', 'query', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error in search: ' . $e->getMessage());
            return redirect()->route('recipe.index')->with('error', 'Terjadi kesalahan saat mencari.');
        }
    }

    public function dashboard($id)
    {
        return $this->show($id);
    }

    public function produk()
    {
        return $this->index(request());
    }

    public function myRecipes()
    {
        try {
            $recipes = Recipe::with(['kategori', 'comments'])
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            return view('recipe.my-recipes', compact('recipes'));
        } catch (\Exception $e) {
            Log::error('Error fetching my recipes: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat resep Anda.');
        }
    }
}
