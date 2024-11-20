<form class="search-filter" method="GET" action="{{ url($path) }}">

    @php
        $quantities = [10,15,20,25,30,35,40];
    @endphp

    <div class="form-body">

        <div class="row">

            <div class="form-group col-12 col-md-8">
                <label>Pesquisar</label>
                <input type="text" name="search" value="{{$search ?? ''}}" class="input form-control" placeholder="{{$placeholder}}" maxlength="80">
            </div>

            <div class="form-group col-12 col-md-4">

                <label>Itens por página</label>

                <select class="input form-select col-12 col-md-6" name="paginate">

                    <option value="">Selecione a quantidade de itens</option>

                    @foreach ($quantities as $qty )
                        <option value="{{ $qty }}" {{ $paginate && $paginate == $qty ? "selected" : '' }}> {{ $qty }} </option>
                    @endforeach

                </select>

            </div>

        </div>

    </div>

    <div type="submit" class="btn btn-primary">Aplicar Filtros</div>

</form>
