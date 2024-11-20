@extends('main')

@section('content')

<div class="page-content">

    <div class="page-header">

        @include('components.alert', ['oneError' => true ])

        <h3>
            {{ $user->id ? "Usuário" : "Novo Usuário"}}
            <p>{{ $user->id ? "Modifique as informações do usuário" :"Insira as informações para cadastrar um novo usuário"}}</p>
        </h3>

    </div>

    <div class="page-body d-flex flex-column">

        <form class="form-container" method="POST" action="{{ url('users') }}" data-parsley-validate="">

            @method( $user->id ? "PUT" : "POST" )

            <input type="hidden" name="id" value="{{$user->id}}">

            @csrf

            <div class="row">

                <div class="form-group col-12 col-md-6">
                    <label>Nome *</label>
                    <input type="text" name="name" class="form-control" required placeholder="Informe o nome do usuário" value="{{old('name', $user->name)}}" maxlength="80">
                </div>

                <div class="form-group col-12 col-md-6">
                    <label>Email *</label>
                    <input type="text" name="email" class="form-control" required placeholder="Informe o email do usuário" value="{{old('name', $user->email)}}" maxlength="100">
                </div>

            </div>

            <div class="row">

                <div class="form-group col-12 col-md-6">
                    <label>Número de registro *</label>
                    <input type="text" name="register_number" class="form-control" required placeholder="Informe o número de registro do usuário" value="{{old('register_number', $user->register_number)}}" maxlength="80">
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
