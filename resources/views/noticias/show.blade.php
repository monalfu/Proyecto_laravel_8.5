@extends('layouts.master')

@section('titulo', "$noticia->titulo")

@section('contenido')
<div class="row mx-auto" style="width: 80%">
    <div class="card mb-5">
        <img class="card-img-top mx-auto" style="width: 100vh" src="{{ $noticia->imagen ? asset('storage/' . config('filesystems.noticiasImageDir')) . '/' . $noticia->imagen : asset('storage/' . config('filesystems.noticiasImageDir')) . '/default.jpg'}}" alt="Imagen noticia {{ $noticia->titulo }}">
        <div class="card-body">
            <div class="card-text">{{ $noticia->texto }}</div>
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
            {{-- auth editor --}}
            <div class="mx-3">
                <a href="{{ route('noticias.destroy', $noticia->id) }}"><img src="{{ asset('images/buttons/delete.png') }}" alt="Borrar noticia" style="width: 30px"></a>
            </div>
            {{-- mostrar si es redactor no está publicada y es suya o si es editor --}}
            <div class="mx-3">
                <a href="{{ route('noticias.edit', $noticia->id) }}"><img src="{{ asset('images/buttons/update.png') }}" alt="Actualizar noticia" style="width: 30px"></a>
            </div>
        </div>
    </div>
</div>

<section style="background-color: #eee;">
    <div class="container my-5 py-5">
        <h4>Comentarios</h4>
        <div class="row d-flex justify-content-center">
            <div class="col-md-12 col-lg-10 col-xl-8">
                @foreach ($comentarios as $comentario)                        
                <div class="card">
                    <div class="card-body">
                        <h6 class="fw-bold text-primary mb-1">{{ $comentario->user->name }}</h6>
                        <p class="text-muted small mb-0">Publicado {{ $comentario->created_at }}</p>
                    </div>
                </div>
                <p class="mt-3 mb-4 pb-2">{{ $comentario->texto }}</p>
                    @auth
                    @if (Auth::user()->can('delete', $comentario))
                    <div class="small d-flex justify-content-start">
                        <a href="{{ route('comentarios.destroy', $comentario->id) }}"><img src="{{ asset('images/buttons/delete.png') }}" alt="Borrar comentario" style="width: 30px"></a>
                    </div>
                    @endif
                    @endauth
                @endforeach
            </div>
            <div>
                <p>Mostrando {{sizeof($comentarios)}} de {{$comentarios->total()}}</p>
            </div>
            <div class="col-10 text-start">{{$comentarios->links()}}</div>
        </div>
    </div>
  </section>

@endsection
