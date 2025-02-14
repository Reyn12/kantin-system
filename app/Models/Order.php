<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'kasir_id',
        'total_harga',
        'status',
        'nomor_meja',
        'catatan',
        'waktu_pembayaran'
    ];

    protected $casts = [
        'waktu_pembayaran' => 'datetime'
    ];

    // Relasi ke user (customer)
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke kasir
    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


    // Helper method untuk update status
    public function updateStatus($status)
    {
        if (in_array($status, ['menunggu_pembayaran', 'dibayar','diproses', 'selesai', 'dibatalkan'])) {
            $this->update(['status' => $status]);
            
            if ($status === 'dibayar') {
                $this->update(['waktu_pembayaran' => now()]);
            }
        }
    }
}