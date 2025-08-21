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
        Schema::create('Wishlist', function (Blueprint $table) {
            $table->unsignedBigInteger('IDPersona');
            $table->unsignedBigInteger('IDProductoI');
            $table->foreign('IDPersona')->references('IDPersona')->on('Usuario')->onDelete('cascade');
            $table->foreign('IDProductoI')->references('IDProductoI')->on('ProductoInterno')->onDelete('cascade');
            $table->primary('IDPersona', 'IDProductoI');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Wishlist');
    }
};
