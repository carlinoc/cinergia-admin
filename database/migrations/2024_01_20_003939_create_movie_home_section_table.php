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
        Schema::create('home_section_movie', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('home_section_id');
            $table->unsignedBigInteger('movie_id');

            $table->foreign('home_section_id')->references('id')->on('home_section')->onDelete('cascade');
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_section_movie');
    }
};
