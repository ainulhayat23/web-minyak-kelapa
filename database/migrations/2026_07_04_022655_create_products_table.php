<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel products.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('size')->nullable();

            $table->unsignedBigInteger('price');
            $table->unsignedInteger('stock')->default(0);

            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->text('composition')->nullable();

            $table->string('image')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Menghapus tabel products.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};