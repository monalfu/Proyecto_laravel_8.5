<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Proyecto final Laranews">

    <title>{{config('app.name')}} - @yield('titulo')</title>

    {{-- Scripts --}}
    <script src="{{ asset('js/bootstrap.bundle.js') }}" defer></script>

    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
</head>
<body class="container p-3">
    {{-- PARTE SUPERIOR --}}
    @section('navegacion')
    @php($pagina = Route::currentRouteName())
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm nav-pills">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                {{-- Left Side of Navbar --}}
                <ul class="navbar-nav me-auto">
                    <li class="nav-item mr-2">
                        <a href="{{ url('/')}}" class="nav-link {{ $pagina=='portada' ? 'active' : '' }}">Noticias</a>
                    </li>
                    
                </ul>
            </div>

        </nav>
    @show


</body>
</html>
