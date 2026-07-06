<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi.
     */
    protected $fillable = [
        'order_code',
        'customer_name',
        'customer_phone',
        'customer_address',
        'customer_notes',
        'total_amount',
        'status',
        'read_at',
        'whatsapp_redirected_at',
        'stock_deducted_at',
    ];

    /**
     * Konversi tipe data otomatis.
     */
    protected function casts(): array
    {
        return [
            'total_amount' => 'integer',
            'read_at' => 'datetime',
            'whatsapp_redirected_at' => 'datetime',
            'stock_deducted_at' => 'datetime',
        ];
    }

    /**
     * Relasi pesanan dengan daftar produk.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Mengambil pesanan yang belum dibaca admin.
     */
    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    /**
     * Memeriksa apakah pesanan belum dibaca.
     */
    public function isUnread(): bool
    {
        return is_null($this->read_at);
    }

    /**
     * Menandai pesanan sebagai sudah dibaca.
     */
    public function markAsRead(): void
    {
        if (! $this->isUnread()) {
            return;
        }

        /*
         * Menyimpan read_at tanpa mengubah updated_at,
         * karena membuka pesanan bukan perubahan isi pesanan.
         */
        static::withoutTimestamps(function (): void {
            $this->forceFill([
                'read_at' => now(),
            ])->saveQuietly();
        });
    }
}