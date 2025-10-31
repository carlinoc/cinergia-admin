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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('countryId')->constrained('countries')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('categoryId')->constrained('categories')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('languageId')->constrained('languages')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('directorId')->constrained('directors')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('ageRateId')->constrained('agerates')->onUpdate('cascade')->onDelete('restrict');
            $table->string('name', 500);
            $table->string('slug', 500);
            $table->text('description')->nullable();
            $table->text('whySee')->nullable();
            $table->integer('movieLength')->default(0);
            $table->integer('rating')->default(0);
            $table->dateTime('releaseYear')->nullable();
            $table->decimal('price', $precision=8, $escala=2)->default(0)->nullable(false);
            $table->string('payment_type', 2)->nullable();
            $table->string('trailer')->nullable();
            $table->string('urlId')->nullable();
            $table->string('image1', 500)->nullable();
            $table->string('image2', 500)->nullable();
            $table->string('poster1', 500)->nullable();
            $table->string('poster2', 500)->nullable();
            $table->string('ytUrlId')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
