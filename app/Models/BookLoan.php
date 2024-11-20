<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookLoan extends Model
{
    /** @use HasFactory<\Database\Factories\BookLoanFactory> */
    use HasFactory;

    protected $casts = [
        'return_date' => 'date',
        'returned_at' => 'datetime',
    ];

    /**
     * Obtém todos os dados relacionados ao empréstimo e se necessário aplica os devidos filtros
     *
     * @param [type] $query
     * @param [type] $request
     * @return void
    */
    public function scopeSearch($query, $request = null) {

        $query->from("book_loans as l")
        ->join("users as u", "u.id", "l.user_id")
        ->join("books as b", "b.id", "l.book_id")
        ->select("l.*", "u.name as user_name", "b.name as book_name");

        if (isset($request->search) && $request->search) {

            $query->where(function ($query) use ($request){
                $query->whereRaw("LOWER(u.name) LIKE '%$request->search%'")
                ->orWhereRaw("LOWER(b.name) LIKE '%$request->search%'");
            });

        }

        $query->orderBy("l.created_at", "desc");
    }

}
