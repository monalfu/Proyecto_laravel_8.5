<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @php
            include 'css/bootstrap.min.css';
        @endphp
    </style>
</head>
<body class="container p-3">
    <header class="container row bg-light p-4 my-4">
        <figure class="img-fluid col-2">
            <img style="width:20px height:20px" src="{{ asset('images/logo.gif')}}" alt="logo">
        </figure>
        <h1 class="col-10">{{ config('app.name') }}</h1>
    </header>
    <main>
        <h2>Felicidades</h2>
        <h3>¡Has llegado a 1000 visitas en el dulce {{ $dulce->nombre }}!</h3>
    </main>
    <footer class="page-footer font-small p-4 my-4 bg-light">
        <p>Aplicación creada por Montse Alguacil como ejemplo de clase.</p>
        <p>Desarrollada haciendo uso de <b>Laravel</b> y <b>Bootstrap</b></p>
    </footer>
</body>
</html>
