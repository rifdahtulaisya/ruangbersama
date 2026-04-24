<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);

        $search = $request->input('search');

        $categories = Category::when($search, function ($query, $search) {
            return $query->where('category_name', 'like', '%' . $search . '%');
        })->paginate($perPage);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_names' => 'required|array',
            'category_names.*' => 'required|string|max:255|distinct|unique:categories,category_name',
        ], [
            'category_names.*.required' => 'Nama kategori tidak boleh kosong.',
            'category_names.*.distinct' => 'Nama kategori tidak boleh sama antar input.',
            'category_names.*.unique'   => 'Kategori ":input" sudah ada.',
        ]);

        foreach ($request->category_names as $name) {
            Category::create([
                'category_name' => $name
            ]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Banyak kategori berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name,' . $id,
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->only('category_name'));

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
