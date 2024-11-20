<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    /** @use HasFactory<\Database\Factories\GenreFactory> */
    use HasFactory;

    public function books() {
        return $this->belongsToMany('App\Models\Book', 'book_genres');
    }

    /**
     * Obtém todos os dados relacionados ao gênero e se necessário aplica os devidos filtros
     *
     * @param [type] $query
     * @param [type] $request
     * @return void
    */
    public function scopeSearch($query, $request = null) {

        $query->from("genres");

        if (isset($request->search) && $request->search) {

            $query->where(function ($query) use ($request){
                $query->whereRaw("LOWER(name) LIKE '%$request->search%'");
            });

        }

        $query->orderBy("created_at", "desc");

    }

}
