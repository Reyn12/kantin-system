<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.categories', compact('categories'));
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
        try {
            $request->validate([
                'nama_kategori' => 'required|string|max:255'
            ]);

            Category::create($request->all());

            return response()->json([
                'message' => 'Kategori berhasil ditambahkan'
            ]);

        } catch (\Exception $e) {
            Log::error('Error saat menambah kategori: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambah kategori'
            ], 500);
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
    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
            return response()->json($category);
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data kategori: ' . $e->getMessage());
            return response()->json([
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_kategori' => 'required|string|max:255'
            ]);

            $category = Category::findOrFail($id);
            $category->update($request->all());

            return response()->json([
                'message' => 'Kategori berhasil diupdate'
            ]);

        } catch (\Exception $e) {
            Log::error('Error saat update kategori: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat update kategori'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json([
                'message' => 'Kategori berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Error saat hapus kategori: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat hapus kategori'
            ], 500);
        }
    }
}
