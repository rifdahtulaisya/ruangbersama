<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Schema::enableForeignKeyConstraints();

        $categories = [
            ['category_name' => 'Bisnis'],
            ['category_name' => 'Teknologi'],
            ['category_name' => 'Sains'],
            ['category_name' => 'Fiksi'],
            ['category_name' => 'Sejarah'],
            ['category_name' => 'Non Fiksi'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}