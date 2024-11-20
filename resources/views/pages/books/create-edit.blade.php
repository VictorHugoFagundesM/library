@extends('main')

@section('content')

<div class="page-content">

    <div class="page-header">

        @include('components.alert', ['oneError' => true ])

        <h3>
            {{ $book->id ? "Livro" : "Novo Livro"}}
            <p>{{ $book->id ? "Modifique as informações do livro" :"Insira as informações para cadastrar um novo livro"}}</p>
        </h3>

    </div>

    <div class="page-body d-flex flex-column">

        <form class="form-container" method="POST" action="{{ url('books') }}" data-parsley-validate="">

            @method( $book->id ? "PUT" : "POST" )

            <input type="hidden" name="id" value="{{$book->id}}">

            @csrf

            <div class="row">

                <div class="form-group col-12 col-md-6">
                    <label>Nome *</label>
                    <input type="text" name="name" class="form-control" required placeholder="Informe o nome do livro" value="{{old('name', $book->name)}}" maxlength="80">
                </div>

                <div class="form-group col-12 col-md-6">
                    <label>Autor *</label>
                    <input type="text" name="author" class="form-control" required placeholder="Informe o autor do livro" value="{{old('name', $book->author)}}" maxlength="80">
                </div>

            </div>

            <div class="row">

                <div class="form-group col-12 col-md-6">
                    <label>Número de registro *</label>
                    <input type="text" name="register_number" class="form-control" required placeholder="Informe o número de registro do livro" value="{{old('register_number', $book->register_number)}}" maxlength="80">
                </div>

                @php
                    $bookGenreIds = old('genres', $book->genres->pluck("id")->toArray());
                @endphp

                <div class="form-group col-12 col-md-6">

                    <label>Gêneros *</label>

                    <select name="genres[]" class="select2" required multiple>
                        @foreach ($genres as $genre)
                            <option value="{{$genre->id}}" {{in_array($genre->id, ($bookGenreIds ?? [])) ? "selected" : ""}}>{{$genre->name}}</option>
                        @endforeach
                    </select>

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
