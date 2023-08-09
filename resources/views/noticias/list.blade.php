@extends('layouts.master')

@section('titulo', "Listado noticias")

@section('contenido')

{{-- BUSCADOR DE NOTICIAS, solo las publicadas --}}
    <form action="{{ route('noticias.searchPublicadas') }}" method="GET" class="col-6 row">
        <input name="titulo" type="text" class="col form-control mr-2 mb-2" placeholder="Título" maxlength="50" value="{{$titulo ?? ''}}">
        <input type="text" name="tema" class="col form-control mr-2 mb-2" placeholder="Tema" maxlength="20" value="{{$tema ?? ''}}">
        <button type="submit" class="col btn btn-primary mr-2 mb-2">Buscar</button>
        <a href="{{route('noticias.index')}}">
            <button type="button" class="col btn btn-primary mb-2">Quitar filtro</button>
        </a>
    </form>

    <div class="row">

        @can ('create', App\Models\Noticia::class)
        <div class="mr-2 text-end">
            <p>Nueva noticia
                <a href="{{ route('noticias.create') }}" class="btn btn-success ml-2">+</a>
            </p>
        </div>
        @endcan

    </div>

    <div class="row mx-auto" style="width: 60%">
        @foreach ($noticias as $noticia)
            <div class="card mb-5 mx-auto p-0" style="width: 100%; max-width: 800px; box-sizing: content-box">
                <div class="" style="width: 100%">
                    <img class="card-img-top" style="width: 100%" src="{{ $noticia->imagen ? asset('storage/' . config('filesystems.noticiasImageDir')) . '/' . $noticia->imagen : asset('storage/' . config('filesystems.noticiasImageDir')) . '/default.jpg'}}" alt="Imagen noticia {{ $noticia->titulo }}">
                </div>
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $noticia->titulo }}</h5>
                    <p class="card-text" style="text-align: justify">
                        @php
                        $resumenTexto = substr($noticia->texto, 0, 400);
                        @endphp
                    {{ $resumenTexto }} <a href="{{ route('noticias.show', $noticia->id) }}">[...]</a>
                    </p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{ $noticia->tema }}</li>
                    <li class="list-group-item">{{ $noticia->user->name }}</li>
                    <li class="list-group-item">{{ $noticia->published_at }}</li>
                </ul>
                <div class="card-body d-flex justify-content-between">
                    <div class="d-flex">
                        <div class="mx-2">
                            <a href="{{ route('noticias.show', $noticia->id) }}"><img src="{{ asset('images/buttons/show.png') }}" alt="Detalles noticia" style="width: 30px"></a>
                        </div>
    
                        @can('delete', $noticia)
                        <div class="mx-3">
                            <a href="{{ route('noticias.destroy', $noticia->id) }}"><img src="{{ asset('images/buttons/delete.png') }}" alt="Borrar noticia" style="width: 30px"></a>
                        </div>
                        @endcan
                    </div>

                    <div class="d-flex">
                        <div class="mx-3">
                            <img src="{{ asset('images/icons/comments.png') }}" alt="Icono comentarios">
                            {{sizeof($noticia->comentarios)}}
                        </div>
                        <div class="mx-3">
                            <img src="{{ asset('images/icons/visits.png') }}" alt="Icono visitas">
                            {{ $noticia->visitas }}
                        </div>
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
