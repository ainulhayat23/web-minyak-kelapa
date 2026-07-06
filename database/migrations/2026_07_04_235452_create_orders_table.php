<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Kode unik pesanan, contoh: ORD-20260705-0001
            $table->string('order_code')->unique();

            // Informasi pelanggan
            $table->string('customer_name');
            $table->string('customer_phone', 20);
            $table->text('customer_address');
            $table->text('customer_notes')->nullable();

            // Total seluruh belanja
            $table->unsignedBigInteger('total_amount')->default(0);

            // pending, processed, completed, atau cancelled
            $table->string('status')->default('pending');

            // Waktu pelanggan diarahkan ke WhatsApp
            $table->timestamp('whatsapp_redirected_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};