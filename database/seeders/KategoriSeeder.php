<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'nama' => 'Appetizer',
                'slug' => 'appetizer',
                'deskripsi' => 'Hidangan pembuka yang menggugah selera',
                'icon' => 'fas fa-utensils',
                'is_active' => true
            ],
            [
                'nama' => 'Main Course',
                'slug' => 'main-course',
                'deskripsi' => 'Hidangan utama yang lezat dan mengenyangkan',
                'icon' => 'fas fa-drumstick-bite',
                'is_active' => true
            ],
            [
                'nama' => 'Dessert',
                'slug' => 'dessert',
                'deskripsi' => 'Hidangan penutup yang manis',
                'icon' => 'fas fa-ice-cream',
                'is_active' => true
            ],
            [
                'nama' => 'Beverage',
                'slug' => 'beverage',
                'deskripsi' => 'Minuman segar dan menyegarkan',
                'icon' => 'fas fa-glass-martini-alt',
                'is_active' => true
            ],
            [
                'nama' => 'Salad',
                'slug' => 'salad',
                'deskripsi' => 'Salad segar dan sehat',
                'icon' => 'fas fa-leaf',
                'is_active' => true
            ],
            [
                'nama' => 'Soup',
                'slug' => 'soup',
                'deskripsi' => 'Sup hangat dan menghangatkan',
                'icon' => 'fas fa-bowl-food',
                'is_active' => true
            ],
            [
                'nama' => 'Snack',
                'slug' => 'snack',
                'deskripsi' => 'Camilan ringan untuk segala suasana',
                'icon' => 'fas fa-cookie',
                'is_active' => true
            ],
            [
                'nama' => 'Breakfast',
                'slug' => 'breakfast',
                'deskripsi' => 'Menu sarapan untuk memulai hari',
                'icon' => 'fas fa-bacon',
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Kategori::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
