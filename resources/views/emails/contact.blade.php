<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        *{
            font-family: Arial, Helvetica, sans-serif;
        }

        header, main, footer {
            border: solid 1px #ddd;
            padding: 15px;
            margin: 10px;
        }

        header, footer {
            background-color: #eeeeee
        }

        header {
            display: flex;
        }

        header figure {
            flex: 1;
        }

        header h1 {
            flex: 4;
        }

        .cursiva {
            font-style: italic;
        }

        .logo {
            width: 100%;
        }

    </style>
</head>
<body>
    <header>
        <figure>
            <img src="{{asset('images/logo.gif')}}" alt="Logo" class="logo">
        </figure>
        <h1>{{config('app.name')}}</h1>
    </header>

    <main>
        <h2>Mensaje recibido: {{$mensaje->asunto}}</h2>
        <p class="cursiva">De: {{$mensaje->nombre}}
            <a href="mailto:{{$mensaje->email}}">&lt;{{$mensaje->email}}&gt;</a>
        </p>
        <p>{{$mensaje->mensaje}}</p>
    </main>

    <footer>
        <p>Aplicación creada por Montse Alguacil para CIFO Valles como ejemplo de clase.</p>
    </footer>
</body>
</html>
