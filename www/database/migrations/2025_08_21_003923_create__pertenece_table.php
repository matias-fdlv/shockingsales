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
        Schema::create('Pertenece', function (Blueprint $table) {
            $table->unsignedBigInteger('IDProductoI');
            $table->unsignedBigInteger('IDCategoria');
            $table->foreign('IDProductoI')->references('IDProductoI')->on('ProductoInterno')->onDelete('cascade');
            $table->foreign('IDCategoria')->references('IDCategoria')->on('Categoria')->onDelete('cascade');
            $table->primary('IDProductoI', 'IDCategoria');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Pertenece');
    }
};
