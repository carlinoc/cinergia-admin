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
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('title', 500);
            $table->string('slug', 500);
            $table->text('description')->nullable();
            $table->string('logo', 500)->nullable();
            $table->string('background', 500)->nullable();
            $table->string('color1', 255)->nullable();
            $table->string('color2', 255)->nullable();
            $table->string('color3', 255)->nullable();
            $table->string('color4', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
