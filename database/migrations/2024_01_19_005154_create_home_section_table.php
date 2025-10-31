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
        Schema::create('home_section', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sectionId')->constrained('sections')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('websiteId')->constrained('websites')->onUpdate('cascade')->onDelete('restrict');
            $table->string('title')->nullable();
            $table->string('background', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_section');
    }
};
