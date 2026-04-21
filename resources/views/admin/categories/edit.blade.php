@extends('layouts-admin.admin')

@section('title', 'Admin | Edit Category')

@section('content')

<!-- HEADER BOX -->
<div class="bg-white rounded-xl shadow p-5 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.categories.index') }}"
                class="w-10 h-10 flex items-center justify-center rounded-lg
                  bg-stone-100 text-stone-600 hover:bg-stone-200 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-[#280905]">
                    Edit Category
                </h2>
            </div>
        </div>
    </div>
</div>

<!-- FORM CARD -->
<div class="bg-white rounded-xl shadow p-6">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="category_name" class="block text-sm font-medium text-stone-700 mb-2">
                Category Name <span class="text-red-500">*</span>
            </label>
            <input type="text" id="category_name" name="category_name"
                   value="{{ old('category_name', $category->category_name) }}"
                   class="w-full px-4 py-3 border border-stone-300 rounded-lg
                          focus:outline-none focus:ring-2 focus:ring-[#A27B5C] focus:border-[#A27B5C]
                          @error('category_name') border-red-500 @enderror"
                   placeholder="Masukkan nama kategori">
            @error('category_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3">
            <button type="submit"
                    class="px-6 py-2.5 bg-[#280905] hover:bg-[#A27B5C] text-white rounded-lg
                           transition font-medium">
                <i class="fa-solid fa-save mr-2"></i>
                Simpan
            </button>
        </div>
    </form>
</div>

@endsection