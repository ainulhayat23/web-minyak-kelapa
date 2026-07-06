<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan penanda bahwa stok pesanan telah dikurangi.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table
                ->timestamp('stock_deducted_at')
                ->nullable()
                ->after('whatsapp_redirected_at');
        });
    }

    /**
     * Menghapus kolom penanda pengurangan stok.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('stock_deducted_at');
        });
    }
};