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
        Schema::create('movie_rented', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movieId')->constrained('movies')->onUpdate('cascade')->onDelete('restrict');
            $table->string('buyerId', 255);
            $table->string('transactionId', 255);
            $table->string('token', 255);
            $table->string('system', 255)->nullable();
            $table->string('browser', 255)->nullable();
            $table->decimal('price', $precision=8, $escala=2)->default(0)->nullable(false);
            $table->dateTime('buyerDate');
            $table->dateTime('expireDate');
            $table->boolean('active')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_rented');
    }
};
