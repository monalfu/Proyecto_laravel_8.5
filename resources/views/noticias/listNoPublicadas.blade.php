@extends('layouts.master')

@section('titulo', "Listado noticias")

@section('contenido')
    
    {{-- BUSCADOR DE NOTICIAS, solo las no publicadas --}}
    <form action="{{ route('noticias.searchNoPublicadas') }}" method="GET" class="col-6 row">
        <input name="titulo" type="text" class="col form-control mr-2 mb-2" placeholder="Título" maxlength="50" value="{{$titulo ?? ''}}">
        <input type="text" name="tema" class="col form-control mr-2 mb-2" placeholder="Tema" maxlength="20" value="{{$tema ?? ''}}">
        {{-- <input type="text" name="name" class="col form-control mr-2 mb-2" placeholder="Redactor" maxlength="20" value="{{$redactor ?? ''}}"> --}}

        <button type="submit" class="col btn btn-primary mr-2 mb-2">Buscar</button>
        <a href="{{route('no_published.noticias')}}">
            <button type="button" class="col btn btn-primary mb-2">Quitar filtro</button>
        </a>
    </form>

    
    <div class="row">

        <div class="text-end">
            <p>Nueva noticia
                <a href="{{ route('noticias.create') }}" class="btn btn-success ml-2">+</a>
            </p>
        </div>

    </div>
    
    <div class="d-flex flex-wrap justify-content-around" style="padding: 0 2rem">
        
        {{-- LISTADO NOTICIAS NO PUBLICADAS --}}
        @foreach ($noticias as $noticia)
            <div class="card mb-5 p-0" style="width: 30vw;">
                <img class="card-img-top mx-auto" style="max-height: 30vw" src="{{ $noticia->imagen ? asset('storage/' . config('filesystems.noticiasImageDir')) . '/' . $noticia->imagen : asset('storage/' . config('filesystems.noticiasImageDir')) . '/default.jpg'}}" alt="Imagen noticia {{ $noticia->titulo }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $noticia->titulo }}</h5>
                    <p class="card-text" maxlength="300">
                        @php
                        $resumenTexto = substr($noticia->texto, 0, 400);
                        @endphp
                    {{ $resumenTexto }} <a href="{{ route('noticias.show', $noticia->id) }}">[...]</a>
                    </p>
                </div>

                {{-- INFORMACIÓN NOTICIA --}}
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{ $noticia->user->name }}</li>
                    <li class="list-group-item">{{ $noticia->tema }}</li>
                    <li class="list-group-item">{{ $noticia->published_at }}</li>
                </ul>

                {{-- ICONOS ACCIONES NOTICIA --}}
                <div class="card-body d-flex justify-content-between" style="max-width: 100%">
                    <div class="mx-2">
                        <a href="{{ route('noticias.show', $noticia->id) }}"><img src="{{ asset('images/buttons/show.png') }}" alt="Detalles noticia" style="width: 30px"></a>
                    </div>
                    <div class="d-flex">
                        <div class="mx-3">
                            <img src="{{ asset('images/icons/comments.png') }}" alt="Icono comentarios">
                            {{sizeof($noticia->comentarios)}}
                        </div>
                        @can('delete', $noticia)
                        @if ($noticia->rejected == 1)
                            <img src="{{ asset('images/icons/noCheck.png') }}" alt="Rechazada" style="width: 20px">
                        @endif
                        <div class="mx-3">
                            <a href="{{ route('noticias.destroy', $noticia->id) }}"><img src="{{ asset('images/buttons/delete.png') }}" alt="Borrar noticia" style="width: 30px"></a>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- MOSTRAR TOTAL DE NOTICIAS SE MUESTRAN DEL TOTAL NO PUBLICADAS --}}
    <div>
        <p>Mostrando {{sizeof($noticias)}} de {{$noticias->total()}}</p>
    </div>

    {{-- LINKS PAGINADOR --}}
    <div class="col-10 text-start">{{$noticias->links()}}</div>


    @endsection

