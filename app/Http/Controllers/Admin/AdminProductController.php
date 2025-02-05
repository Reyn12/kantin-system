<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use Barryvdh\DomPDF\Facade\Pdf;


class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Log::info('Mengambil semua data produk');
        $products = Product::all();
        Log::info('Total produk: ' . $products->count());

        $categories = Category::all();
        Log::info('Total kategori: ' . $categories->count());

        return view('admin.products.product', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Mencoba menyimpan produk baru', $request->all());

        try {
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'nama_produk' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'harga' => 'required|numeric|min:0',
                'stok' => 'required|integer|min:0',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            Log::info('Validasi berhasil, mencoba upload gambar');
            $gambarPath = $request->file('gambar')->store('produk', 'public');
            Log::info('Gambar berhasil diupload ke: ' . $gambarPath);

            $product = Product::create([
                'category_id' => $request->category_id,
                'nama_produk' => $request->nama_produk,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'gambar_url' => $gambarPath,
                'status' => true
            ]);

            Log::info('Produk berhasil disimpan dengan ID: ' . $product->id);
            return response()->json(['message' => 'Produk berhasil ditambahkan']);

        } catch (\Exception $e) {
            Log::error('Error saat menyimpan produk: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Log::info('Mencoba get data produk ID: ' . $id);

        try {
            $product = Product::findOrFail($id);
            $categories = Category::all();
            Log::info('Produk ditemukan');
            return response()->json([
                'product' => $product,
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            Log::error('Error saat get produk: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Log::info('Mencoba update produk ID: ' . $id, $request->all());

        try {
            $product = Product::findOrFail($id);
            Log::info('Produk ditemukan');

            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'nama_produk' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'harga' => 'required|numeric|min:0',
                'stok' => 'required|integer|min:0',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $data = [
                'category_id' => $request->category_id,
                'nama_produk' => $request->nama_produk,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'stok' => $request->stok
            ];

            if ($request->hasFile('gambar')) {
                Log::info('Ada upload gambar baru');
                if ($product->gambar_url) {
                    Log::info('Menghapus gambar lama: ' . $product->gambar_url);
                    Storage::disk('public')->delete($product->gambar_url);
                }
                $data['gambar_url'] = $request->file('gambar')->store('produk', 'public');
                Log::info('Gambar baru diupload ke: ' . $data['gambar_url']);
            }

            $product->update($data);
            Log::info('Produk berhasil diupdate');
            return response()->json(['message' => 'Produk berhasil diupdate']);

        } catch (\Exception $e) {
            Log::error('Error saat update produk: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Log::info('Mencoba hapus produk ID: ' . $id);

        try {
            $product = Product::findOrFail($id);
            
            if ($product->gambar_url) {
                Log::info('Menghapus gambar: ' . $product->gambar_url);
                Storage::disk('public')->delete($product->gambar_url);
            }

            $product->delete();
            Log::info('Produk berhasil dihapus');
            return response()->json(['message' => 'Produk berhasil dihapus']);

        } catch (\Exception $e) {
            Log::error('Error saat hapus produk: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateStock(Request $request, string $id)
    {
        Log::info('Mencoba update stok produk ID: ' . $id, ['stok' => $request->stock]);

        try {
            $request->validate([
                'stock' => 'required|integer|min:0'
            ]);

            $product = Product::findOrFail($id);
            $product->update(['stok' => $request->stock]);
            
            Log::info('Stok berhasil diupdate');
            return response()->json(['message' => 'Stok berhasil diupdate']);

        } catch (\Exception $e) {
            Log::error('Error saat update stok: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request, string $id)
    {
        Log::info('Mencoba update status produk ID: ' . $id, ['status' => $request->status]);

        try {
            $request->validate([
                'status' => 'required|boolean'
            ]);

            $product = Product::findOrFail($id);
            $product->update([
                'status' => $request->status ? 'tersedia' : 'habis'
            ]);
            
            Log::info('Status berhasil diupdate');
            return response()->json(['message' => 'Status berhasil diupdate']);

        } catch (\Exception $e) {
            Log::error('Error saat update status: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function downloadPDF()
    {
        $products = Product::with('category')->get();
        $pdf = PDF::loadView('admin.products.pdf', compact('products'));
        return $pdf->download('products.pdf');
    }

    public function downloadExcel()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
}
