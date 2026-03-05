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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
             $table->string('featured_image')->nullable();

            $table->string('post_title');
            $table->string('title')->nullable();

            $table->longText('blog_post'); 
            $table->text('description')->nullable();

            $table->string('tags')->nullable(); 
            $table->string('category')->nullable();

            $table->string('slug')->unique();
            $table->string('author')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
