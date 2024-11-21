@extends('main')

@section('content')

<div class="page-content">

    <div class="page-header">

        @include('components.alert', ['oneError' => true ])

        <h3>
            {{ $loan->id ? "Empréstimo" : "Novo Empréstimo"}}
            <p>{{ $loan->id ? "Modifique as informações do empréstimo" :"Insira as informações para cadastrar um novo empréstimo"}}</p>
        </h3>

    </div>

    <div class="page-body d-flex flex-column">

        <form class="form-container" method="POST" action="{{ url('loans') }}" data-parsley-validate="">

            @method( $loan->id ? "PUT" : "POST" )

            <input type="hidden" name="id" value="{{$loan->id}}">

            @csrf

            <div class="row">

                <div class="form-group col-12">

                    <div class="form-check">
                        <input name="is_returned" class="form-check-input" type="checkbox" value="1" id="flexCheckDefault-2" {{$loan->is_returned ? "checked" : ""}}>
                        <label class="form-check-label" for="flexCheckDefault-2">
                            Entregue?
                        </label>
                    </div>

                </div>

                <div class="form-group col-12">

                    <div class="form-check col-12">
                        <input name="past_due_time" class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" {{$loan->past_due_time ? "checked" : ""}}>
                        <label class="form-check-label" for="flexCheckDefault">
                            Atrasado?
                        </label>
                    </div>

                </div>

            </div>

            <div class="row">

                <div class="form-group col-12 col-md-6">

                    <label>Usuário *</label>

                    <select name="user_id" class="form-select">
                        <option>Selecione um usuário</option>
                        @foreach ($users as $user)
                            <option value="{{$user->id}}" {{$user->id == $loan->user_id ? "selected" : ""}}>{{$user->name}}</option>
                        @endforeach
                    </select>

                </div>

                <div class="form-group col-12 col-md-6">

                    <label>livro *</label>

                    <select name="book_id" class="form-select">
                        <option>Selecione um livro</option>
                        @foreach ($books as $book)
                            <option value="{{$book->id}}" {{$book->id == $loan->book_id ? "selected" : ""}}>{{$book->name}}</option>
                        @endforeach
                    </select>

                </div>

            </div>

            <div class="row">

                <div class="form-group col-12 col-md-6">
                    <label>Data de retorno *</label>
                    <input type="date" name="return_date" class="form-control" required value="{{old('return_date', ($loan->return_date ? $loan->return_date->format('Y-m-d') : ''))}}" maxlength="80">
                </div>

            </div>

            <div class="form-footer">
                <a href="{{ url()->previous() }}" class="btn btn-outline-dark mr-auto">Voltar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>

        </form>

    </div>

</div>

@endsection
