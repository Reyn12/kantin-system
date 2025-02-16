<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::with('category')
            ->get()
            ->map(function($product) {
                return [
                    'ID' => $product->id,
                    'Kategori' => $product->category->nama_kategori,
                    'Nama Produk' => $product->nama_produk,
                    'Deskripsi' => $product->deskripsi,
                    'Harga' => 'Rp ' . number_format($product->harga, 0, ',', '.'),
                    'Stok' => $product->stok,
                    'Status' => $product->status
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kategori',
            'Nama Produk',
            'Deskripsi',
            'Harga',
            'Stok',
            'Status'
        ];
    }
}