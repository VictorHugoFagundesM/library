<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    public function genres() {
        return $this->belongsToMany('App\Models\Genre', 'book_genres');
    }

    /**
     * Obtém todos os dados relacionados ao livro e se necessário aplica os devidos filtros
     *
     * @param [type] $query
     * @param [type] $request
     * @return void
    */
    public function scopeSearch($query, $request = null) {

        $query->from("books as b")->selectRaw("b.*,
        CASE WHEN (
            select is_returned from book_loans as bl
            where b.id = bl.book_id
            and bl.is_returned = 0
            limit 1
        ) IS NOT NULL THEN 0 ELSE 1 END AS is_available");

        if (isset($request->search) && $request->search) {

            $query->where(function ($query) use ($request){
                $query->whereRaw("LOWER(b.name) LIKE '%$request->search%'")
                ->orWhereRaw("LOWER(b.author) LIKE '%$request->search%'")
                ->orWhereRaw("LOWER(b.register_number) LIKE '%$request->search%'");
            });

        }

        if ($request->situation !== null) {
            $query->having("is_available", $request->situation);
        }

        $query->orderBy("b.created_at", "desc");

    }

}
