<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->constrained('recipes')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('guest_identifier')->nullable(); // Untuk guest yang tidak login
            $table->integer('rating')->unsigned()->default(1); // 1-5 stars
            $table->text('review')->nullable();
            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();
            $table->timestamps();

            // Prevent duplicate ratings from same user/guest
            $table->unique(['recipe_id', 'user_id']);
            $table->index(['recipe_id', 'guest_identifier']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
