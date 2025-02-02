<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class OrderItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'jumlah',
        'harga_satuan',
        'subtotal'
    ];

    // Relasi ke order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi ke product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessor untuk format harga
    protected function hargaSatuan(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 0, ',', '.'),
        );
    }

    protected function subtotal(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 0, ',', '.'),
        );
    }
}