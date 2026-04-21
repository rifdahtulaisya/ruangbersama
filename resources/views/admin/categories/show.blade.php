@extends('layouts-admin.admin')

@section('title', 'Admin | Category Detail')

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
                    Show Category
                </h2>
            </div>
        </div>
    </div>
</div>

<!-- DETAIL CARD -->
<div class="bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-[#280905] mb-6">Category Information</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-stone-600 mb-1">ID</label>
                <p class="text-lg font-semibold text-[#280905]">#{{ $category->id }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-stone-600 mb-1">Category Name</label>
                <p class="text-lg font-semibold text-[#280905]">{{ $category->category_name }}</p>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-stone-600 mb-1">Created At</label>
                <p class="text-lg text-stone-700">{{ $category->created_at->format('d M Y') }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-stone-600 mb-1">Updated At</label>
                <p class="text-lg text-stone-700">{{ $category->updated_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>
</div>

@endsection