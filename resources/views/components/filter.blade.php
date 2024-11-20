<form class="search-filter mb-2" method="GET" action="{{ url($path) }}">

    @php
        $quantities = [10,15,20,25,30,35,40];
    @endphp

    <div class="form-body">

        <div class="row">

            <div class="form-group col-12 {{isset($simpleSelects) && count($simpleSelects) == 1 ? 'col-md-6' : 'col-md-8'}}">
                <label>Pesquisar</label>
                <input type="text" name="search" value="{{$search ?? ''}}" class="input form-control" placeholder="{{$placeholder}}" maxlength="80">
            </div>

            @if (isset($simpleSelects) && count($simpleSelects) == 1)

                <div class="form-group col-12 col-md-4">

                    <label>{{$simpleSelects[0]["title"]}}</label>

                    <select class="input form-select" name="{{$simpleSelects[0]["name"]}}">

                        <option value="">Selecione uma opção</option>

                        @foreach ($simpleSelects[0]["options"] as $key => $option )
                            <option value="{{ $key }}" {{ $simpleSelects[0]["selected"] !== null && $simpleSelects[0]["selected"] == $key ? "selected" : '' }}> {{ $option }} </option>
                        @endforeach

                    </select>

                </div>

            @endif

            <div class="form-group col-12 {{isset($simpleSelects) && count($simpleSelects) == 1 ? 'col-md-2' : 'col-md-4'}}">

                <label>Itens por página</label>

                <select class="input form-select col-12 col-md-6" name="paginate">

                    <option value="">Selecione a quantidade de itens</option>

                    @foreach ($quantities as $qty )
                        <option value="{{ $qty }}" {{ $paginate && $paginate == $qty ? "selected" : '' }}> {{ $qty }} </option>
                    @endforeach

                </select>

            </div>
        </div>

        <button class="btn btn-primary mt-2">Aplicar Filtros</button>

    </div>

</form>
