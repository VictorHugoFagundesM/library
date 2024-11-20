@extends("main")

@section("content")

<div class="page-content">

    <div class="page-header">

        @include('components.alert', ['oneError' => true ])

        <h3>Livros</h3>
        <a class="btn btn-primary" href="books/create">Novo livro</a>
    </div>

    <div class="page-body">

        @include('components.filter',[
            "path" => "books",
            "placeholder" => "Pesquise pelo nome do livro, autor ou nº de cadastro",
            "search" => $search,
            "paginate" => $paginate,
            "simpleSelects" => [
                [
                    "title" => "Situação",
                    "options" => ["Emprestado", "Disponível"],
                    "selected" => $situation,
                    "name" => "situation",
                ]
            ],
            "multipleSelects" => [
                [
                    "genres" => $genres
                ]
            ],
        ])

        <div>
            <p>Resultado(s) encontrado(s): <b class="fw-500">{{$books->total()}}</b></p>
        </div>

        @if (count($books))

            <div class="table-wrapper">

                <table class="table-index">

                    <tr class="table-header">
                        <th>Id</th>
                        <th>Situação</th>
                        <th>Nome</th>
                        <th>N° de cadastro</th>
                        <th>Autor</th>
                        <th>Gêneros</th>
                        <th>Criação</th>
                        <th>Edição</th>
                        <th>Ações</th>
                    </tr>

                    @foreach ($books as $book)

                        <tr>
                            <td>{{$book->id}}</td>
                            <td>
                                <div class="tags">
                                    <div class="tag tag-{{$book->is_available ? "success" : "danger"}}">
                                        {{$book->is_available ? "Disponível" : "Emprestado"}}
                                    </div>
                                </div>
                            </td>
                            <td>{{$book->name}}</td>
                            <td>{{$book->register_number}}</td>
                            <td>{{$book->author}}</td>
                            <td>

                                <div class="tags">

                                    @foreach ($book->genres as $genre)
                                        <div class="tag">{{$genre->name}}</div>
                                    @endforeach

                                </div>
                            </td>
                            <td>{{ isset($book->created_at) ? $book->created_at->format('d/m/Y H:i') : '-'}}</td>
                            <td>{{ isset($book->updated_at) ? $book->updated_at->format('d/m/Y H:i') : '-'}}</td>
                            <td class="table-actions">
                                <a href="{{url('books/'.$book->id.'/edit')}}" title="Editar item" class="btn btn-icon btn-icon-primary"><i class="fa-solid fa-pen"></i></a>

                                <form method="POST" action="{{url('books')}}" class="">
                                    @method( "DELETE" )
                                    @csrf
                                    <input type="hidden" name="id" value="{{$book->id}}" />

                                    <button class="btn btn-icon btn-icon-danger" type="submit" title="Excluir item">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                </form>
                            </td>
                        </tr>

                    @endforeach

                </table>
            </div>

        @else

            <div class="no-results">
                <div class="text-center w-100 mb-5"> Nenhum livro encontrado para os filtros selecionados. </div>
            </div>

        @endif

        <div class="pagination-container">
            {{ $books->links() }}
        </div>

    </div>

</div>

@endsection
