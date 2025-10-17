<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kategoris', function (Blueprint $table) {
            if (!Schema::hasColumn('kategoris', 'slug')) {
                $table->string('slug')->unique()->after('nama');
            }
            if (!Schema::hasColumn('kategoris', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('kategoris', 'icon')) {
                $table->string('icon')->nullable()->after('deskripsi');
            }
            if (!Schema::hasColumn('kategoris', 'image')) {
                $table->string('image')->nullable()->after('icon');
            }
            if (!Schema::hasColumn('kategoris', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('kategoris', function (Blueprint $table) {
            $table->dropColumn(['slug', 'deskripsi', 'icon', 'image', 'is_active']);
        });
    }
};
