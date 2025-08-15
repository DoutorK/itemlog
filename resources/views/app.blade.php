<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Meu Projeto</title>

    {{-- Fonte bonita só pra não ficar sem graça --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

</head>
<body class="antialiased" style="font-family: 'Inter', sans-serif;">
    <div id="app"></div>
    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</body>
</html>