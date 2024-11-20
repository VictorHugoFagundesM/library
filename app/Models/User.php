<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Obtém todos os dados relacionados ao usuário e se necessário aplica os devidos filtros
     *
     * @param [type] $query
     * @param [type] $request
     * @return void
    */
    public function scopeSearch($query, $request = null) {

        $query->from("users")
        ->select("*");

        if (isset($request->search) && $request->search) {

            $query->where(function ($query) use ($request){
                $query->whereRaw("LOWER(name) LIKE '%$request->search%'")
                ->orWhereRaw("LOWER(email) LIKE '%$request->search%'");
            });

        }

        $query->orderBy("created_at", "desc");

    }

}
