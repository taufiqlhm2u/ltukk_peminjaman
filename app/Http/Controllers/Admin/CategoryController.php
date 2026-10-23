<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = Category::findOrFail($id);

        return view('admin.category.edit', compact('kategori'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        try {
            $category->delete();
            return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal saat menghapus data kategori.');
        }
    }
}
