@extends('layouts.master')

@section('titulo', "Listado noticias")

@section('contenido')
    <form action="{{ route('noticias.search') }}" method="GET" class="col-6 row" style="margin-left: 2rem">
        <input name="titulo" type="text" class="col form-control mr-2 mb-2" placeholder="Título" maxlength="40" value="{{$titulo ?? ''}}">
        <input type="text" name="tema" class="col form-control mr-2 mb-2" style="margin-left: 2rem" placeholder="Tema" maxlength="20" value="{{$tema ?? ''}}">
        <button type="submit" class="col btn btn-primary mr-2 mb-2" style="margin-left: 2rem; max-width: fit-content">Buscar</button>
        <a href="{{ route('noticias.index') }}">
            <button type="button" class="col btn btn-primary mb-2">Quitar filtro</button>
        </a>
    </form>

    <div class="row">
        {{-- falta auth para solo usuarios con role redactor --}}
        <div class="mr-2 text-end">
            <p>Nueva noticia
                <a href="{{ route('noticias.create') }}" class="btn btn-success ml-2">+</a>
            </p>
        </div>
    </div>
    <div class="row mx-auto" style="width: 60%">
        @foreach ($noticias as $noticia)
            <div class="card mb-5" style="width: 100%;">
                <img class="card-img-top mx-auto" style="width: 100vh" src="{{ $noticia->imagen ? asset('storage/' . config('filesystems.noticiasImageDir')) . '/' . $noticia->imagen : asset('storage/' . config('filesystems.noticiasImageDir')) . '/default.jpg'}}" alt="Imagen noticia {{ $noticia->titulo }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $noticia->titulo }}</h5>
                    <p class="card-text">
                        @php
                        $resumenTexto = substr($noticia->texto, 0, 400);
                        @endphp
                    {{ $resumenTexto }} <a href="{{ route('noticias.show', $noticia->id) }}">[...]</a>
                    </p>
                </div>
                <ul class="list-group list-group-flush">
                    {{-- solo lo verán editores, redactores y admin --}}
                    <li class="list-group-item">{{ $noticia->user->name }}</li>

                    <li class="list-group-item">{{ $noticia->published_at }}</li>
                </ul>
                <div class="card-body d-flex">
                    <div class="mx-3">
                        <img src="{{ asset('images/buttons/comments.png') }}" alt="Icono comentarios">
                        {{sizeof($noticia->comentarios)}}
                    </div>
                    <div class="mx-2">
                        <a href="{{ route('noticias.show', $noticia->id) }}"><img src="{{ asset('images/buttons/show.png') }}" alt="Detalles noticia" style="width: 30px"></a>
                    </div>
                    {{-- auth editor --}}
                    <div class="mx-3">
                        <a href="{{ route('noticias.destroy', $noticia->id) }}"><img src="{{ asset('images/buttons/delete.png') }}" alt="Borrar noticia" style="width: 30px"></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div>
        <p>Mostrando {{sizeof($noticias)}} de {{$noticias->total()}}</p>
    </div>

    <div class="col-10 text-start">{{$noticias->links()}}</div>


    @endsection
