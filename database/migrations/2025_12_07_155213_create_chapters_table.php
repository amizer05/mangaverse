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
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manga_id')->constrained()->onDelete('cascade');
            $table->integer('chapter_number');
            $table->string('title')->nullable();
            $table->enum('language', ['VF', 'VO', 'EN'])->default('VF'); // VF = Version Française, VO = Version Originale, EN = English
            $table->integer('page_count')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
            
            // Ensure unique chapter number per manga and language
            $table->unique(['manga_id', 'chapter_number', 'language'], 'unique_manga_chapter_language');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};
