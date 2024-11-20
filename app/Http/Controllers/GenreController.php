<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Genre;

class GenreController extends Controller
{
    /**
     * Redireciona à index de exibição dos gêneros
     */
    public function index(Request $request) {
        $paginate = $request->paginate ?? 10;
        $genres = Genre::search($request)->paginate($paginate);

        $data = [
            "genres" => $genres,
            "search" => $request->search,
            "paginate" => $paginate
        ];

        return view("pages.genres.index", $data);
    }

    /**
     * Redireciona à página de criação de gênero
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function createEdit(int $id = null) {
        $genre = $id ? Genre::find($id) : new Genre();

        if ($genre) {

            $data = [
                "genre" => $genre,
            ];

            return view("pages.genres.create-edit", $data);

        } else {
            return back()->withErrors("Gênero não encontrado.");
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
            'id' => ['nullable', 'required_if:method,PUT', 'exists:genres,id'],
            'name' => ['required', 'string', 'max:80'],
        ]);

        return $validator;

    }

    /**
     * Insere ou atualiza o registro do gênero no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insertUpdate(Request $request) {

        try {

            $validation = $this->validation($request);

            if (!$validation->fails()) {
                $genre = $request->id ? Genre::find($request->id) : new Genre();;

                if ($genre) {
                    $this->save($request, $genre);
                    Session::flash("success", "Gênero ". ( $request->id ? 'atualizado' : 'criado' ) . " com sucesso!");
                    return redirect("genres");

                } else {
                    return back()->withErrors('Gênero não encontrado.');
                }

            }

            return back()->withErrors("Não foi possível ". ( $request->id ? 'atualizar' : 'criar' ) ." o gênero: ". $validation->errors()->first());

        } catch (Exception $e) {
            return back()->withErrors("Ocorreu um problema ao tentar ". ($request->id ? 'atualizar' : 'criar') . " o gênero, tente novamente mais tarde ou contate um administrador");
        }

    }

    /**
     * Salva os dados do gênero
     *
     * @param Request $request
     * @param Genre $genre
     */
    private function save(Request $request, Genre $genre) {

        try {
            $genre->name = $request->name;
            $genre->save();

        } catch (Exception $e) {
            Log::error("[SAVE-USER]".$e->GetMessage());
            throw new Exception($e);
        }

    }

    /**
     * Deleta um gênero
     *
     * @param [type] $request
     * @return void
     */
    public function delete(Request $request) {
        $genre = Genre::where(["id" => $request->id])->first();

        if ($genre) {
            $genre->delete();
            return back()->withSuccess("Gênero removido com sucesso!");
        }

        return back()->withErrors("Não é possível remover este gênero: gênero não econtrado.");
    }

}

