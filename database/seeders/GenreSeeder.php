<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $genres = ["Ficção científica", "Romance", "Mistério", "Terror", "Fantasia", "Aventura", "Drama", "Histórico", "Biografia",
        "Autoajuda", "Psicologia", "Filosofia", "Poesia", "Ensaios", "Tragédia", "Comédia",
        "Policial", "Jovem adulto", "Erótico", "Distopia", "Espionagem"];

        foreach ($genres as $key => $genre) {

            $genre = new Genre([
                'name' => $genre,
            ]);

            $genre->save();

        }
    }
}
