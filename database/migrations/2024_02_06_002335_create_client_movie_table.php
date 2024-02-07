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
        Schema::create('client_movie', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('movie_id');

            $table->string('transactionId', 255)->nullable(false);
            $table->decimal('amount', $precision=8, $escala=2)->default(0)->nullable(false);

            $table->dateTime('date_start')->nullable(false);
            $table->dateTime('date_end')->nullable(false);

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_movie');
    }
};
