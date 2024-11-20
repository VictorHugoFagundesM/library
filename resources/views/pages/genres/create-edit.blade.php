@extends('main')

@section('content')

<div class="page-content">

    <div class="page-header">

        @include('components.alert', ['oneError' => true ])

        <h3>
            {{ $genre->id ? "Gênero" : "Novo Gênero"}}
            <p>{{ $genre->id ? "Modifique as informações do gênero" :"Insira as informações para cadastrar um novo gênero"}}</p>
        </h3>

    </div>

    <div class="page-body d-flex flex-column">

        <form class="form-container" method="POST" action="{{ url('genres') }}" data-parsley-validate="">

            @method( $genre->id ? "PUT" : "POST" )

            <input type="hidden" name="id" value="{{$genre->id}}">

            @csrf

            <div class="row">

                <div class="form-group col-12 col-md-6">
                    <label>Nome *</label>
                    <input type="text" name="name" class="form-control" required placeholder="Informe o nome do gênero" value="{{old('name', $genre->name)}}" maxlength="80">
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
