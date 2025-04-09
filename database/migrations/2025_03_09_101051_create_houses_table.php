<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title'); // عنوان مختصر للإعلان
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->float('area')->nullable(); // مساحة
            $table->enum('status', ['unavailable', 'rent' ,'sale'])->default('unavailable');
            $table->enum('type', ['apartment', 'villa', 'house', 'studio'])->default('house');
            $table->boolean('is_furnished')->default(false);
            $table->unsignedInteger('favorites_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
