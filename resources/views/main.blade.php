<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Styles / Scripts -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

</head>

<body>

    <ul class="nav">

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-book"></i>
                Teca
            </a>
        </li>

        <li class="nav-item">
          <a class="nav-link active" href="#">Início</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="users">Usuários</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="books">Livros</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="genres">Gêneros</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="loans">Empréstimos</a>
        </li>

    </ul>

    <div class="page-wrapper">
        @yield("content")
    </div>

</body>

</html>
