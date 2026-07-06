<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan penanda waktu saat pesanan dibaca admin.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table
                ->timestamp('read_at')
                ->nullable()
                ->after('status')
                ->index();
        });

        /*
         * Pesanan lama dianggap sudah dibaca agar tidak langsung
         * menghasilkan banyak notifikasi setelah fitur dipasang.
         */
        DB::table('orders')
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
            ]);
    }

    /**
     * Menghapus kolom read_at jika migration dibatalkan.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('read_at');
        });
    }
};