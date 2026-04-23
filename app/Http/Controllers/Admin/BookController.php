<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Pagination - default 5 items per page
        $perPage = $request->input('per_page', 5);

        // Search functionality
        $search = $request->input('search');

        $books = Book::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->paginate($perPage);

        return view('admin.books.index', compact('books'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stock' => 'required|integer|min:0'
        ]);

        $data = $request->only('category_id', 'title', 'author', 'stock');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        Book::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::with('category')->findOrFail($id);
        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'remove_image' => 'nullable|boolean'
        ]);

        $book = Book::findOrFail($id);

        $book->title = $request->title;
        $book->author = $request->author;
        $book->stock = $request->stock;

        // Handle image removal
        if ($request->remove_image == '1') {
            if ($book->image && Storage::exists('public/' . $book->image)) {
                Storage::delete('public/' . $book->image);
            }
            $book->image = null;
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($book->image && Storage::exists('public/' . $book->image)) {
                Storage::delete('public/' . $book->image);
            }

            $imagePath = $request->file('image')->store('books', 'public');
            $book->image = $imagePath;
        }

        $book->save();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        // Hapus semua riwayat peminjaman buku ini terlebih dahulu
        $book->loans()->delete();

        // Hapus image jika ada
        if ($book->image && Storage::exists('public/' . $book->image)) {
            Storage::delete('public/' . $book->image);
        }

        // Soft delete buku
        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Book and its loan history deleted successfully.');
    }
}
