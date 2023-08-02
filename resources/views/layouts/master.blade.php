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
<body class="container-fluid" style="">
    {{-- PARTE SUPERIOR --}}
    @section('navegacion')
    @php($pagina = Route::currentRouteName())
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm nav-pills">
            <div class="container-fluis" style="width: 100%">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    {{-- Left Side of Navbar --}}
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item mr-2">
                            <a href="{{ url('/')}}" class="nav-link {{ $pagina=='portada' ? 'active' : '' }}">Noticias</a>
                        </li>
                        {{-- auth if si es redactor --}}
                        <li class="nav-item mr-2">
                            <a href="{{ route('noticias.create') }}" class="nav-link {{ $pagina=='noticias.create' ? 'active' : '' }}">Crear noticia</a>
                        </li>
                        {{-- OPCIONAL: auth is si es editor --}}
                        {{-- <li class="nav-item mr-2">
                            <a href="{{ route('noticias.index') }}" class="nav-link {{ $pagina=='noticias.list' ? 'active' : '' }}">Noticias sin publicar</a>
                        </li> --}}
                        {{-- auth if si es editor y redactor - Noticias borradas y noticias no publicadas --}}
                        <li class="nav-item mr-2">
                            <a href="{{ route('no_published.noticias') }}" class="nav-link {{ $pagina=='no_published.noticias' ? 'active' : '' }}">Noticias no publicadas</a>
                        </li>
                        <li class="nav-item mr-2">
                            <a href="{{ route('deleted.noticias') }}" class="nav-link {{ $pagina=='deleted.noticias' ? 'active' : '' }}">Noticias borradas</a>
                        </li>
                        {{-- auth if si es administrador --}}
                        <li class="nav-item mr-2">
                            <a href="{{ route('admin.users') }}" class="nav-link {{ $pagina=='admin.users' ? 'active' : '' }}">Gestión usuarios</a>
                        </li>
                    </ul>

                    {{-- Right side of navbar --}}
                    <ul class="navbar-nav ms-auto">
                        {{-- Authentication links --}}
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link  {{$pagina=='login' ? 'active' : ''}}" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link {{$pagina=='register' ? 'active' : ''}}" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} ({{ Auth::user()->email}})
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        {{ __('Home') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    @show

    {{-- PARTE CENTRAL --}}
    <h1 class="my-2 text-center">Laranews</h1>

    <main>
        <h2 style="margin: 2rem">@yield('titulo')</h2>

        @if(Session::has('success'))
            <x-alert type="success" message="{{Session::get('success')}}"/>
        @endif

        @if($errors->any())
        <x-alert type="danger" message="Se han producido errores:">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </x-alert>
        @endif

        @yield('contenido')

    </main>

    {{-- PARTE INFERIOR --}}
    @section('pie')
        <footer class="page-footer font-small-p-4 bg-light">
            <p>Aplicación creada por Montse Alguacil. Desarrollada haciendo uso de <b>Laravel</b> y <b>bootstrap</b>.</p>
        </footer>
    @show
</body>
</html>
