<?php
// database/seeders/BookSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::find(1);
        
        if (!$category) {
            $this->command->error('Category dengan ID 1 tidak ditemukan!');
            $this->command->info('Buat category terlebih dahulu atau jalankan CategorySeeder');
            return;
        }

        $books = [
            [
                'title' => 'Eternal Romance',
                'author' => 'Jacqueline Thompson',
                'image' => 'books/1.png',
                'stock' => 1,
            ],
            [
                'title' => 'Wonder Bloom',
                'author' => 'Estelle Darcy',
                'image' => 'books/2.png',
                'stock' => 1,
            ],
            [
                'title' => 'Holding Hearts',
                'author' => 'Estelle Darcy',
                'image' => 'books/3.png',
                'stock' => 1,
            ],
            [
                'title' => 'Whispers of the Heart',
                'author' => 'Olivia Wilson',
                'image' => 'books/4.png',
                'stock' => 1,
            ],
            [
                'title' => 'Diary Book',
                'author' => 'Harumi Kobayashi',
                'image' => 'books/5.png',
                'stock' => 1,
            ],
            [
                'title' => 'The Moonlit Portico of The Bellavere',
                'author' => 'Avery Davis',
                'image' => 'books/6.png',
                'stock' => 1,
            ],
        ];

        foreach ($books as $bookData) {
            Book::create([
                'category_id' => 1,
                'title' => $bookData['title'],
                'author' => $bookData['author'],
                'image' => $bookData['image'],
                'stock' => $bookData['stock'],
            ]);
        }

        $this->command->info('Seeder buku berhasil dijalankan!');
        $this->command->info('Total buku: ' . count($books));
    }
}