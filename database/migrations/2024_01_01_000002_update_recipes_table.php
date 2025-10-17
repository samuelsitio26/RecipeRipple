<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            if (!Schema::hasColumn('recipes', 'video_type')) {
                $table->enum('video_type', ['file', 'youtube', 'url'])->default('file')->after('video_path');
            }
            if (!Schema::hasColumn('recipes', 'video_url')) {
                $table->string('video_url')->nullable()->after('video_type');
            }
            if (!Schema::hasColumn('recipes', 'average_rating')) {
                $table->decimal('average_rating', 3, 2)->default(0)->after('langkah_image');
            }
            if (!Schema::hasColumn('recipes', 'total_ratings')) {
                $table->integer('total_ratings')->default(0)->after('average_rating');
            }
            if (!Schema::hasColumn('recipes', 'views_count')) {
                $table->integer('views_count')->default(0)->after('total_ratings');
            }
            if (!Schema::hasColumn('recipes', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('views_count');
            }
        });
    }

    public function down(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn(['video_type', 'video_url', 'average_rating', 'total_ratings', 'views_count', 'is_featured']);
        });
    }
};
