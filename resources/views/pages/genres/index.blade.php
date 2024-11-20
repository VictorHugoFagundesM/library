@extends("main")

@section("content")

<div class="page-content">

    <div class="page-header">

        @include('components.alert', ['oneError' => true ])

        <h3>Gêneros</h3>
        <a class="btn btn-primary" href="genres/create">Novo gênero</a>
    </div>

    <div class="page-body">

        @include('components.filter',[
            "path" => "genres",
            "placeholder" => "Pesquise pelo nome do gênero",
            "search" => $search,
            "paginate" => $paginate
        ])

        <div>
            <p>Resultado(s) encontrado(s): <b class="fw-500">{{$genres->total()}}</b></p>
        </div>

        @if (count($genres))

            <div class="table-wrapper">

                <table class="table-index">

                    <tr class="table-header">
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Criação</th>
                        <th>Edição</th>
                        <th>Ações</th>
                    </tr>

                    @foreach ($genres as $genre)

                        <tr>
                            <td>{{$genre->id}}</td>
                            <td>{{$genre->name}}</td>
                            <td>{{ isset($genre->created_at) ? $genre->created_at->format('d/m/Y H:i') : '-'}}</td>
                            <td>{{ isset($genre->updated_at) ? $genre->updated_at->format('d/m/Y H:i') : '-'}}</td>
                            <td class="table-actions">
                                <a href="{{url('genres/'.$genre->id.'/edit')}}" title="Editar item" class="btn btn-icon btn-icon-primary"><i class="fa-solid fa-pen"></i></a>

                                <form method="POST" action="{{url('genres')}}" class="">
                                    @method( "DELETE" )
                                    @csrf
                                    <input type="hidden" name="id" value="{{$genre->id}}" />

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
                <div class="text-center w-100 mb-5"> Nenhum gênero encontrado para os filtros selecionados. </div>
            </div>

        @endif

        <div class="pagination-container">
            {{ $genres->links() }}
        </div>

    </div>

</div>

@endsection
