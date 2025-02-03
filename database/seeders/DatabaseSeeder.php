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
            'name' => 'Kasir 1',
            'email' => 'kasir@kantin.test',
            'password' => Hash::make('kasir'),
            'role' => 'kasir'
        ]);

        $kasir2 = User::create([
            'name' => 'Kasir 2',
            'email' => 'kasir2@kantin.test',
            'password' => Hash::make('kasir'),
            'role' => 'kasir'
        ]);

        $customer = User::create([
            'name' => 'Customer',
            'email' => 'customer@kantin.test',
            'password' => Hash::make('customer'),
            'role' => 'customer'
        ]);

        // Create more customers
        $customer2 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'customer'
        ]);

        $customer3 = User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'customer'
        ]);

        $customer4 = User::create([
            'name' => 'Deni Wijaya',
            'email' => 'deni@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'customer'
        ]);

        // Create Categories
        $makananBerat = Category::create(['nama_kategori' => 'Makanan Berat']);
        $minuman = Category::create(['nama_kategori' => 'Minuman']);
        $snack = Category::create(['nama_kategori' => 'Snack']);
        $seafood = Category::create(['nama_kategori' => 'Seafood']);
        $ayam = Category::create(['nama_kategori' => 'Ayam']);
        $mie = Category::create(['nama_kategori' => 'Mie']);
        $dessert = Category::create(['nama_kategori' => 'Dessert']);

        // Create Products
        $nasiGoreng = Product::create([
            'category_id' => $makananBerat->id,
            'nama_produk' => 'Nasi Goreng Spesial',
            'deskripsi' => 'Nasi goreng dengan telur dan ayam',
            'harga' => 15000,
            'stok' => 50,
            'status' => 'tersedia',
            'gambar_url' => 'images/products/nasi-goreng.jpg'
        ]);

        $esTeh = Product::create([
            'category_id' => $minuman->id,
            'nama_produk' => 'Es Teh Manis',
            'deskripsi' => 'Es teh manis segar',
            'harga' => 5000,
            'stok' => 100,
            'status' => 'tersedia',
            'gambar_url' => 'images/products/es-teh.jpg'
        ]);

        $kentangGoreng = Product::create([
            'category_id' => $snack->id,
            'nama_produk' => 'Kentang Goreng',
            'deskripsi' => 'Kentang goreng crispy',
            'harga' => 10000,
            'stok' => 30,
            'status' => 'tersedia',
            'gambar_url' => 'images/products/kentang-goreng.jpg'
        ]);

        // Tambah produk baru
        $mieGoreng = Product::create([
            'category_id' => $mie->id,
            'nama_produk' => 'Mie Goreng Special',
            'deskripsi' => 'Mie goreng dengan telur dan sayuran',
            'harga' => 12000,
            'stok' => 40,
            'status' => 'tersedia',
            'gambar_url' => 'images/products/mie-goreng.jpg'
        ]);

        $udangGoreng = Product::create([
            'category_id' => $seafood->id,
            'nama_produk' => 'Udang Goreng Tepung',
            'deskripsi' => 'Udang goreng crispy dengan saus sambal',
            'harga' => 25000,
            'stok' => 25,
            'status' => 'tersedia',
            'gambar_url' => 'images/products/udang-goreng.jpg'
        ]);

        $ayamGeprek = Product::create([
            'category_id' => $ayam->id,
            'nama_produk' => 'Ayam Geprek',
            'deskripsi' => 'Ayam geprek dengan sambal level 1-5',
            'harga' => 18000,
            'stok' => 35,
            'status' => 'tersedia',
            'gambar_url' => 'images/products/ayam-geprek.jpg'
        ]);

        $esKrim = Product::create([
            'category_id' => $dessert->id,
            'nama_produk' => 'Es Krim Sundae',
            'deskripsi' => 'Es krim dengan topping coklat dan kacang',
            'harga' => 15000,
            'stok' => 20,
            'status' => 'tersedia',
            'gambar_url' => 'images/products/es-krim.jpg'
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
            'kasir_id' => $kasir2->id,
            'total_harga' => 15000,
            'status' => 'menunggu_pembayaran',
            'nomor_meja' => 'B2',
        ]);

        $order3 = Order::create([
            'user_id' => $customer->id, 
            'kasir_id' => $kasir->id,
            'total_harga' => 25000,
            'status' => 'diproses',
            'nomor_meja' => 'C3',
            'waktu_pembayaran' => now(),
        ]);

        // Create more orders
        $order4 = Order::create([
            'user_id' => $customer2->id,
            'kasir_id' => $kasir2->id,
            'total_harga' => 55000,
            'status' => 'selesai',
            'nomor_meja' => 'D4',
            'waktu_pembayaran' => now()->subHours(2),
        ]);

        $order5 = Order::create([
            'user_id' => $customer3->id,
            'kasir_id' => $kasir->id,
            'total_harga' => 30000,
            'status' => 'menunggu_pembayaran',
            'nomor_meja' => 'E5',
        ]);

        $order6 = Order::create([
            'user_id' => $customer4->id,
            'kasir_id' => $kasir->id,
            'total_harga' => 43000,
            'status' => 'diproses',
            'nomor_meja' => 'F6',
            'waktu_pembayaran' => now()->subMinutes(30),
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

        OrderItem::create([
            'order_id' => $order4->id,
            'product_id' => $udangGoreng->id,
            'jumlah' => 2,
            'harga_satuan' => 25000,
            'subtotal' => 50000
        ]);

        OrderItem::create([
            'order_id' => $order4->id,
            'product_id' => $esTeh->id,
            'jumlah' => 1,
            'harga_satuan' => 5000,
            'subtotal' => 5000
        ]);

        OrderItem::create([
            'order_id' => $order5->id,
            'product_id' => $ayamGeprek->id,
            'jumlah' => 1,
            'harga_satuan' => 18000,
            'subtotal' => 18000
        ]);

        OrderItem::create([
            'order_id' => $order5->id,
            'product_id' => $mieGoreng->id,
            'jumlah' => 1,
            'harga_satuan' => 12000,
            'subtotal' => 12000
        ]);

        OrderItem::create([
            'order_id' => $order6->id,
            'product_id' => $nasiGoreng->id,
            'jumlah' => 2,
            'harga_satuan' => 15000,
            'subtotal' => 30000
        ]);

        OrderItem::create([
            'order_id' => $order6->id,
            'product_id' => $esKrim->id,
            'jumlah' => 1,
            'harga_satuan' => 13000,
            'subtotal' => 13000
        ]);
    }
}