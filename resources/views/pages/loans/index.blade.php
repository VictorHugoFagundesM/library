@extends("main")

@section("content")

<div class="page-content">

    <div class="page-header">

        @include('components.alert', ['oneError' => true ])

        <h3>Empréstimos</h3>
        <a class="btn btn-primary" href="loans/create">Novo empréstimo</a>
    </div>

    <div class="page-body">

        @include('components.filter',[
            "path" => "loans",
            "placeholder" => "Pesquise pelo nome do usuário ou livro",
            "search" => $search,
            "paginate" => $paginate
        ])

        <div>
            <p>Resultado(s) encontrado(s): <b class="fw-500">{{$loans->total()}}</b></p>
        </div>

        @if (count($loans))

            <div class="table-wrapper">

                <table class="table-index">

                    <tr class="table-header">
                        <th>Id</th>
                        <th>Devolvido?</th>
                        <th>Atrasado?</th>
                        <th>Usuário</th>
                        <th>Livro</th>
                        <th>Limite Retorno</th>
                        <th>Retorno</th>
                        <th>Criação</th>
                        <th>Ações</th>
                    </tr>

                    @foreach ($loans as $loan)

                        <tr>
                            <td>{{$loan->id}}</td>
                            <td>
                                <div class="tags">
                                    <div class="tag tag-{{$loan->is_returned ? "success" : "danger"}}">
                                        {{$loan->is_returned ? "Sim" : "Não"}}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="tags">
                                    <div class="tag tag-{{$loan->past_due_time  ? "danger" : ""}}">
                                        {{$loan->past_due_time  ? "Sim" : "Não"}}
                                    </div>
                                </div>
                            </td>
                            <td>{{$loan->user_name ?? "-"}}</td>
                            <td>{{$loan->book_name}}</td>
                            <td>{{ isset($loan->return_date) ? $loan->return_date->format('d/m/Y') : '-'}}</td>
                            <td>{{ isset($loan->returned_at) ? $loan->returned_at->format('d/m/Y H:i') : '-'}}</td>
                            <td>{{ isset($loan->updated_at) ? $loan->updated_at->format('d/m/Y H:i') : '-'}}</td>
                            <td class="table-actions">

                                <a href="{{url('loans/'.$loan->id.'/edit')}}" title="Editar item" class="btn btn-icon btn-icon-primary"><i class="fa-solid fa-pen"></i></a>

                                @if (!$loan->is_returned && !$loan->past_due_time)

                                    <form method="POST" action="{{url('loans/'.$loan->id.'/mark-past')}}" class="">
                                        @method( "POST" )
                                        @csrf
                                        <input type="hidden" name="id" value="{{$loan->id}}" />

                                        <button class="btn btn-icon btn-icon-danger" type="submit" title="Marcar como atrasado">
                                            <i class="fa-solid fa-clock"></i>
                                        </button>

                                    </form>

                                @endif


                                @if (!$loan->is_returned)

                                    <form method="POST" action="{{url('loans/'.$loan->id.'/return')}}" class="">
                                        @method( "POST" )
                                        @csrf
                                        <input type="hidden" name="id" value="{{$loan->id}}" />

                                        <button class="btn btn-icon btn-icon-danger" type="submit" title="Marcar como entregue">
                                            <i class="fa-solid fa-check"></i>
                                        </button>

                                    </form>

                                @endif

                            </td>
                        </tr>

                    @endforeach

                </table>
            </div>

        @else

            <div class="no-results">
                <div class="text-center w-100 mb-5"> Nenhum empréstimo encontrado para os filtros selecionados. </div>
            </div>

        @endif

        <div class="pagination-container">
            {{ $loans->links() }}
        </div>

    </div>

</div>

@endsection
