<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = Book::all();
        $categoryIds = Category::all()->pluck("id")->toArray();

        foreach ($books as $key => $book) {

            $categoryId = array_rand($categoryIds);

            new BookCategory([
                'book_id' => $book->id,
                'category_id' => $categoryId,
            ]);

        }

    }
}
