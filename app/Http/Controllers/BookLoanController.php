<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\BookLoan;
use App\Models\User;

class BookLoanController extends Controller
{

    /**
     * Redireciona à index de exibição dos empréstimos
     */
    public function index(Request $request) {
        $paginate = $request->paginate ?? 10;
        $loans = BookLoan::search($request)->paginate($paginate);

        $data = [
            "loans" => $loans,
            "search" => $request->search,
            "paginate" => $paginate
        ];

        return view("pages.loans.index", $data);
    }

    /**
     * Redireciona à página de criação de empréstimo
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function createEdit(int $id = null) {
        $loan = $id ? BookLoan::find($id) : new BookLoan();
        $users = User::orderBy("name", "asc")->get();
        $books = Book::orderBy("name", "asc")->get();

        if ($loan) {

            $data = [
                "loan" => $loan,
                "users" => $users,
                "books" => $books,
            ];

            return view("pages.loans.create-edit", $data);

        } else {
            return back()->withErrors("Empréstimo não encontrado.");
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
            'id' => ['nullable', 'required_if:method,PUT', 'exists:book_loans,id'],
            'user_id' => ['required', 'exists:users,id'],
            'book_id' => ['required', 'exists:books,id'],
            'is_returned' => ['nullable', 'boolean'],
            'past_due_time' => ['nullable', 'boolean'],
            'return_date' => ['required', 'date_format:Y-m-d'],
        ]);

        return $validator;

    }

    /**
     * Insere ou atualiza o registro do empréstimo no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insertUpdate(Request $request) {

        try {

            $validation = $this->validation($request);

            if (!$validation->fails()) {
                $loan = $request->id ? BookLoan::find($request->id) : new BookLoan();;

                if ($loan) {
                    $this->save($request, $loan);
                    Session::flash("success", "Empréstimo ". ( $request->id ? 'atualizado' : 'criado' ) . " com sucesso!");
                    return redirect("loans");

                } else {
                    return back()->withErrors('Empréstimo não encontrado.');
                }

            }

            return back()->withErrors("Não foi possível ". ( $request->id ? 'atualizar' : 'criar' ) ." o empréstimo: ". $validation->errors()->first());

        } catch (Exception $e) {
            return back()->withErrors("Ocorreu um problema ao tentar ". ($request->id ? 'atualizar' : 'criar') . " o empréstimo, tente novamente mais tarde ou contate um administrador");
        }

    }

    /**
     * Salva os dados do empréstimo
     *
     * @param Request $request
     * @param BookLoan $loan
     */
    private function save(Request $request, BookLoan $loan) {

        try {
            $loan->user_id = $request->user_id;
            $loan->book_id = $request->book_id;
            $loan->return_date = $request->return_date;
            $loan->is_returned = !!$request->is_returned;
            $loan->past_due_time = !!$request->past_due_time;
            $loan->save();

        } catch (Exception $e) {
            Log::error("[SAVE-LOAN]".$e->GetMessage());
            throw new Exception($e);
        }

    }

    /**
     * Marca o retorno do livro
     *
     * @param [type] $request
     * @return void
     */
    public function returnBook(Request $request) {
        $loan = BookLoan::where(["id" => $request->id])->first();

        if ($loan) {
            $loan->is_returned = 1;
            $loan->returned_at = now();
            $loan->save();
            return back()->withSuccess("Livro devolvido com sucesso!");
        }

        return back()->withErrors("Não é possível atualizar este empréstimo: empréstimo não econtrado.");
    }

    /**
     * Marca o atraso do livro
     *
     * @param [type] $request
     * @return void
     */
    public function markPastDue(Request $request) {
        $loan = BookLoan::where(["id" => $request->id])->first();

        if ($loan) {
            $loan->past_due_time = 1;
            $loan->save();
            return back()->withSuccess("Livro devolvido com sucesso!");
        }

        return back()->withErrors("Não é possível atualizar este empréstimo: empréstimo não econtrado.");
    }

}
