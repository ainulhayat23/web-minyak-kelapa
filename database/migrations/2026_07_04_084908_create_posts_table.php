<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            // Admin yang membuat tulisan
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            // Ringkasan yang tampil pada daftar kegiatan
            $table->text('excerpt')->nullable();

            // Isi lengkap berita atau kegiatan
            $table->longText('content');

            // Lokasi gambar utama
            $table->string('image')->nullable();

            // Status draf atau sudah diterbitkan
            $table->boolean('is_published')->default(false);

            // Waktu tulisan diterbitkan
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};