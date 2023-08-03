@extends('layouts.master')

@section('titulo', "Listado noticias")

@section('contenido')

    <div class="d-flex flex-wrap justify-content-between" style="padding: 0 2rem">
        @foreach ($noticias as $noticia)
            <div class="card mb-5" style="width: 30vw;">
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
                        <a href="#"><img src="{{ asset('images/buttons/show.png') }}" alt="Detalles noticia" style="width: 30px"></a>
                    </div>
                    {{-- auth editor --}}
                    <div class="mx-3">
                        <a href="#"><img src="{{ asset('images/buttons/delete.png') }}" alt="Borrar noticia" style="width: 30px"></a>
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

