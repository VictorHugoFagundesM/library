@extends("main")

@section("content")

<div class="page-content">

    <div class="page-header">

        @include('components.alert', ['oneError' => true ])

        <h3>Usuários</h3>
        <div class="btn btn-primary">Novo usuário</div>
    </div>

    <div class="page-body">

        @include('components._filter',[
            "path" => "users",
            "placeholder" => "Pesquise pelo nome ou email do usuário",
            "search" => $search,
            "paginate" => $paginate
        ])

        <div>
            <p>Resultado(s) encontrado(s): <b class="fw-500">{{$users->total()}}</b></p>
        </div>

        @if (count($users))

            <div class="table-wrapper">

                <table class="table-index">

                    <tr class="table-header">
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Criação</th>
                        <th>Edição</th>
                        <th>Ações</th>
                    </tr>

                    @foreach ($users as $user)

                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email ?? "-"}}</td>
                            <td>{{ isset($user->created_at) ? $user->created_at->format('d/m/Y H:i') : '-'}}</td>
                            <td>{{ isset($user->updated_at) ? $user->updated_at->format('d/m/Y H:i') : '-'}}</td>
                            <td class="table-actions">
                                <a href="{{url('users/'.$user->id.'/edit')}}" title="Editar item" class="btn btn-icon btn-icon-primary"><i class="fa-solid fa-pen"></i></a>
                                <button data-url="{{url('users')}}" data-id="{{$user->id}}"  title="Excluir item" class="btn btn-icon btn-icon-danger delete-item"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>

                    @endforeach

                </table>
            </div>

        @else

            <div class="no-results">
                <img class="no-results-image" src="{{asset('img/404.png')}}">
                <div class="text-center w-100 mb-5"> Nenhum usuário encontrado para os filtros selecionados. </div>
            </div>

        @endif

        <div class="pagination-container">
            {{ $users->links() }}
        </div>

    </div>

</div>

@endsection
