<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookGenre;
use App\Models\Genre;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = Book::all();
        $genreIds = Genre::all()->pluck("id")->toArray();

        try {
            foreach ($books as $key => $book) {

                $genreId = array_rand($genreIds);

                $bGenre = new BookGenre([
                    'book_id' => $book->id,
                    'genre_id' => $genreId,
                ]);

                $bGenre->save();

            }

        } catch (Exception $e) {
        }

    }
}
