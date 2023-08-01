@extends('layouts.master')

@section('titulo', "Listado noticias")

@section('contenido')
    <form action="{{ route('noticias.search') }}" method="GET" class="col-6 row">
        <input name="titulo" type="text" class="col form-control mr-2 mb-2" placeholder="Título" maxlength="40" value="{{$titulo ?? ''}}">
        <input type="text" name="tema" class="col form-control mr-2 mb-2" placeholder="Ingrediente" maxlength="20" value="{{$tema ?? ''}}">
        <button type="submit" class="col btn btn-primary mr-2 mb-2">Buscar</button>
        <a href="{{ route('noticias.index') }}">
            <button type="button" class="col btn btn-primary mb-2">Quitar filtro</button>
        </a>
    </form>

    <div class="row">
        {{-- falta auth para solo usuarios con role redactor --}}
        <div class="text-end">
            <p>Nueva noticia
                <a href="{{ route('noticias.create') }}" class="btn btn-success ml-2">+</a>
            </p>
        </div>
    </div>

    @foreach ($noticias as $noticia)
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="{{ $noticia->imagen ? asset('storage/' . config('filesystems.noticiasImageDir')) . '/' . $noticia->imagen : asset('storage/' . config('filesystems.noticiasImageDir')) . '/default.jpg'}}" alt="Imagen noticia {{ $noticia->titulo }}">
            <div class="card-body">
                <h5 class="card-title">{{ $noticia->titulo }}</h5>
                <p class="card-text" maxlength="300">
                    @php
                    $resumenTexto = substr($noticia->texto, 0, 200);
                    @endphp
                {{ $resumenTexto }} <a href="{{ route('noticias.show', $noticia->id) }}">[...]</a>
                </p>
            </div>
            <ul class="list-group list-group-flush">
                {{-- solo lo verán editores, redactores y admin --}}
                <li class="list-group-item">{{ $noticia->user->name }}</li>

                <li class="list-group-item">{{ $noticia->published_at }}</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
            </div>
        </div>
    @endforeach

    @endsection
