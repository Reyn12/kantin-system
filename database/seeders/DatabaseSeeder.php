<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Users
        $admin = User::create([
            'name' => 'Admin Kantin',
            'email' => 'admin@kantin.test',
            'password' => Hash::make('admin'),
            'role' => 'admin'
        ]);

        $kasir = User::create([
            'name' => 'Kasir Kantin',
            'email' => 'kasir@kantin.test',
            'password' => Hash::make('kasir'),
            'role' => 'kasir'
        ]);

        $customer = User::create([
            'name' => 'Customer',
            'email' => 'customer@kantin.test',
            'password' => Hash::make('customer'),
            'role' => 'customer'
        ]);

        // Create Categories
        $makananBerat = Category::create(['nama_kategori' => 'Makanan Berat']);
        $minuman = Category::create(['nama_kategori' => 'Minuman']);
        $snack = Category::create(['nama_kategori' => 'Snack']);

        // Create Products
        $nasiGoreng = Product::create([
            'category_id' => $makananBerat->id,
            'nama_produk' => 'Nasi Goreng Spesial',
            'deskripsi' => 'Nasi goreng dengan telur dan ayam',
            'harga' => 15000,
            'stok' => 50,
            'status' => 'tersedia'
        ]);

        $esTeh = Product::create([
            'category_id' => $minuman->id,
            'nama_produk' => 'Es Teh Manis',
            'deskripsi' => 'Es teh manis segar',
            'harga' => 5000,
            'stok' => 100,
            'status' => 'tersedia'
        ]);

        $kentangGoreng = Product::create([
            'category_id' => $snack->id,
            'nama_produk' => 'Kentang Goreng',
            'deskripsi' => 'Kentang goreng crispy',
            'harga' => 10000,
            'stok' => 30,
            'status' => 'tersedia'
        ]);

        // Create Orders
        $order1 = Order::create([
            'user_id' => $customer->id,
            'kasir_id' => $kasir->id,
            'total_harga' => 20000,
            'status' => 'selesai',
            'nomor_meja' => 'A1',
            'waktu_pembayaran' => now(),
        ]);

        $order2 = Order::create([
            'user_id' => $customer->id,
            'total_harga' => 15000,
            'status' => 'menunggu_pembayaran',
            'nomor_meja' => 'B2',
        ]);

        $order3 = Order::create([
            'user_id' => $customer->id,
            'kasir_id' => $kasir->id,
            'total_harga' => 25000,
            'status' => 'dibayar',
            'nomor_meja' => 'C3',
            'waktu_pembayaran' => now(),
        ]);

        // Create Order Items
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $nasiGoreng->id,
            'jumlah' => 1,
            'harga_satuan' => 15000,
            'subtotal' => 15000
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $esTeh->id,
            'jumlah' => 1,
            'harga_satuan' => 5000,
            'subtotal' => 5000
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $kentangGoreng->id,
            'jumlah' => 1,
            'harga_satuan' => 10000,
            'subtotal' => 10000
        ]);
    }
}