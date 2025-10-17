<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kategoris', function (Blueprint $table) {
            if (!Schema::hasColumn('kategoris', 'slug')) {
                $table->string('slug')->nullable()->after('nama');
            }
            if (!Schema::hasColumn('kategoris', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('nama');
            }
            if (!Schema::hasColumn('kategoris', 'icon')) {
                $table->string('icon')->nullable()->after('nama');
            }
            if (!Schema::hasColumn('kategoris', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('nama');
            }
        });

        // Update slug for existing categories
        DB::statement('UPDATE kategoris SET slug = LOWER(REPLACE(nama, " ", "-")) WHERE slug IS NULL');
    }

    public function down(): void
    {
        Schema::table('kategoris', function (Blueprint $table) {
            $table->dropColumn(['slug', 'deskripsi', 'icon', 'is_active']);
        });
    }
};
