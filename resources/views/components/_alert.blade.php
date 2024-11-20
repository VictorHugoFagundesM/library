<div class="alert-container">
    @foreach (['danger', 'warning', 'success', 'info', 'errors', 'default'] as $msg)

        @if(Session::has($msg))

            <div class="alert d-flex alert-{{ ($msg == 'errors' || $msg == 'danger') ? 'danger' : 'success' }} alert-block">

                @php
                    $sessionMessage = Session::get($msg);
                    $message = is_string($sessionMessage) ? $sessionMessage : $sessionMessage->first();
                @endphp

                <strong>{{ $message }}</strong>
                <button type="button" class="btn close ml-auto" data-dismiss="alert">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

        @endif

    @endforeach
</div>
