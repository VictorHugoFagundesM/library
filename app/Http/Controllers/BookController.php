<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;
use App\Models\BookGenre;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Redireciona à index de exibição dos livros
     */
    public function index(Request $request) {
        $paginate = $request->paginate ?? 10;
        $books = Book::search($request)->paginate($paginate);
        $genres = Genre::all();

        $data = [
            "books" => $books,
            "genres" => $genres,
            "search" => $request->search,
            "situation" => $request->situation,
            "paginate" => $paginate
        ];

        return view("pages.books.index", $data);
    }

    /**
     * Redireciona à página de criação de livro
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function createEdit(int $id = null) {
        $book = $id ? Book::find($id) : new Book();
        $genres = Genre::all();

        if ($book) {

            $data = [
                "book" => $book,
                "genres" => $genres,
            ];

            return view("pages.books.create-edit", $data);

        } else {
            return back()->withErrors("Livro não encontrado.");
        }

    }

    /**
     * Valida os dados vindos da requisição
     *
     * @param Request $request
     * @var \Illuminate\Contracts\Validation\Validator $validator
     */
    private function validation(Request $request) {

        $validator = Validator::make($request->all(), [
            'id' => ['nullable', 'required_if:method,PUT', 'exists:books,id'],
            'name' => ['required', 'string', 'max:80'],
            'register_number' => ['required', 'numeric'],
            'genres' => ['required', 'array'],
            'genres.*' => ['exists:genres,id'],
        ]);

        return $validator;

    }

    /**
     * Insere ou atualiza o registro do livro no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insertUpdate(Request $request) {

        try {

            $validation = $this->validation($request);

            if (!$validation->fails()) {
                $book = $request->id ? Book::find($request->id) : new Book();;

                if ($book) {
                    $this->save($request, $book);
                    Session::flash("success", "Livro ". ( $request->id ? 'atualizado' : 'criado' ) . " com sucesso!");
                    return redirect("books");

                } else {
                    return back()->withErrors('Livro não encontrado.');
                }

            }

            return back()->withErrors("Não foi possível ". ( $request->id ? 'atualizar' : 'criar' ) ." o livro: ". $validation->errors()->first());

        } catch (Exception $e) {
            return back()->withErrors("Ocorreu um problema ao tentar ". ($request->id ? 'atualizar' : 'criar') . " o livro, tente novamente mais tarde ou contate um administrador");
        }

    }

    /**
     * Salva os dados do livro
     *
     * @param Request $request
     * @param Book $book
     */
    private function save(Request $request, Book $book) {

        try {

            DB::beginTransaction();

            $book->name = $request->name;
            $book->author = $request->author;
            $book->register_number = $request->register_number;
            $book->save();

            $book->genres()->sync($request->genres);

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("[SAVE-BOOK]".$e->GetMessage());
            throw new Exception($e);
        }

    }

    /**
     * Deleta um livro
     *
     * @param [type] $request
     * @return void
     */
    public function delete(Request $request) {
        $book = Book::where(["id" => $request->id])->first();

        if ($book) {
            $book->delete();
            return back()->withSuccess("Livro removido com sucesso!");
        }

        return back()->withErrors("Não é possível remover este livro: livro não econtrado.");
    }

}
