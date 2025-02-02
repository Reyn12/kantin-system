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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kasir_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('total_harga', 10, 2);
            $table->enum('status', ['menunggu_pembayaran', 'dibayar', 'selesai', 'dibatalkan'])->default('menunggu_pembayaran');
            $table->string('nomor_meja');
            $table->text('catatan')->nullable();
            $table->timestamp('waktu_pembayaran')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};