<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto de Tarefas</title>

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
<!-- Tailwind via CDN -->
<script src="https://cdn.tailwindcss.com"></script>

</html>
