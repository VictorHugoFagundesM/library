@extends("main")

@section("content")

<div class="page-content">

    <div class="page-header">

        @include('components.alert', ['oneError' => true ])

        <h3>Usuários</h3>
        <a class="btn btn-primary" href="users/create">Novo usuário</a>
    </div>

    <div class="page-body">

        @include('components.filter',[
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

                                <input type="hidden" name="_method" value="DELETE" />
                                <input type="hidden" name="_token" value="${csrfToken()}" />
                                <input type="hidden" name="id" value="${id}" />

                                <form method="POST" action="{{url('users')}}" class="">
                                    @method( "DELETE" )
                                    @csrf
                                    <input type="hidden" name="id" value="{{$user->id}}" />

                                    <button class="btn btn-icon btn-icon-danger" type="submit">
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
                <div class="text-center w-100 mb-5"> Nenhum usuário encontrado para os filtros selecionados. </div>
            </div>

        @endif

        <div class="pagination-container">
            {{ $users->links() }}
        </div>

    </div>

</div>

@endsection
