<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Redireciona à index de exibição dos usuários
     */
    public function index(Request $request) {
        $paginate = $request->paginate ?? 10;
        $users = User::search($request)->paginate($paginate);

        $data = [
            "users" => $users,
            "search" => $request->search,
            "paginate" => $paginate
        ];

        return view("pages.users.index", $data);
    }

    /**
     * Redireciona à página de criação de usuário
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function createEdit(int $id = null) {
        $user = $id ? User::find($id) : new User();

        if ($user) {

            $data = [
                "user" => $user,
            ];

            return view("pages.users.create-edit", $data);

        } else {
            return back()->withErrors("Usuário não encontrado.");
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
            'id' => ['nullable', 'required_if:method,PUT', 'exists:users,id'],
            'name' => ['required', 'string', 'max:80'],
            'email' => ['required', 'string', 'max:100', 'unique:users,email,'.$request->id],
        ]);

        return $validator;

    }

    /**
     * Insere ou atualiza o registro do usuário no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insertUpdate(Request $request) {

        try {

            $validation = $this->validation($request);

            if (!$validation->fails()) {
                $user = $request->id ? User::find($request->id) : new User();;

                if ($user) {
                    $this->save($request, $user);
                    Session::flash("success", "Usuário atualizado com sucesso!");
                    return redirect("users");

                } else {
                    return back()->withErrors('Usuário não encontrado.');
                }

            }

            return back()->withErrors('Não foi possível atualizar o usuário: '. $validation->errors()->first());

        } catch (Exception $e) {
            return back()->withErrors("Ocorreu um problema ao tentar atualizar o usuário, tente novamente mais tarde ou contate um administrador");
        }

    }

    /**
     * Salva os dados do usuário
     *
     * @param Request $request
     * @param User $user
     */
    private function save(Request $request, User $user) {

        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

        } catch (Exception $e) {
            Log::error("[SAVE-USER]".$e->GetMessage());
            throw new Exception($e);
        }

    }

    /**
     * Deleta um usuário
     *
     * @param [type] $adId
     * @return void
     */
    public function delete(Request $request) {
        $user = User::where(["id" => $request->id])->first();

        if ($user) {
            $user->delete();
            return back()->withSuccess("Usuário removido com sucesso!");
        }

        return back()->withErrors("Não é possível remover este usuário.");
    }

}
