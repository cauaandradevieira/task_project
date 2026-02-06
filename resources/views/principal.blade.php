<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto de Teste</title>

    <!-- CSS compilado do Tailwind e style.css -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-BYZY9sof.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/style-tn0RQdqM.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">

    <header>
        @include('header')
    </header>

    <main>
        @yield('content')
    </main>

</body>
</html>
