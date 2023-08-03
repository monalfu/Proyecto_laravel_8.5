@extends('layouts.master')

@section('titulo', "$noticia->titulo")

@section('contenido')
<div class="row mx-auto" style="width: 60%">
    <div class="card mb-5">
        <img class="card-img-top" style="width: 100%" src="{{ $noticia->imagen ? asset('storage/' . config('filesystems.noticiasImageDir')) . '/' . $noticia->imagen : asset('storage/' . config('filesystems.noticiasImageDir')) . '/default.jpg'}}" alt="Imagen noticia {{ $noticia->titulo }}">
        <div class="card-body">
            <div class="card-text">{{ $noticia->texto }}</div>
        </div>
        <ul class="list-group list-group-flush">
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

                @auth
                    @if (Auth::user()->hasRole('editor'))
                        <form class="my-auto d-flex" method="POST" action="{{route('noticias.update', $noticia->id)}}">
                            @csrf
                            <input name="_method" type="hidden" value="PUT">
                            <input name="titulo" type="hidden" value="{{$noticia->titulo}}">
                            <input name="tema" type="hidden" value="{{$noticia->tema}}">
                            <input name="texto" type="hidden" value="{{ $noticia->texto }}">
                            <input name="imagen" type="hidden" value="{{$noticia->imagen}}">                        
                            
                            <div class="">
                                <label for="published">Publicar</label>
                                <input id="published" name="published" value="1" type="checkbox" class="form-check-input" {{$noticia->published ? "checked" : '' }}>
                                <input type="hidden" name="published_at" id="published_at">
                            </div>

                            <div style="margin: 0 1rem">
                                <label for="rechazado">Revisar</label>
                                <input id="rechazado" name="rechazado" value="1" type="checkbox" class="form-check-input" {{ $noticia->rejected ? "checked" : '' }}>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm">Actualizar</button>
                        </form>
                    @endif   
                @endauth
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
</div>

<section style="background-color: #eee;">
    <div class="container my-5 py-5">
        <h4>Comentarios</h4>
        <div class="row d-flex justify-content-center">
            <div class="col-md-12 col-lg-10 col-xl-8">
                @forelse ($comentarios as $comentario)
                <div class="card">
                    <div class="card-body">
                        <h6 class="fw-bold text-primary mb-1">{{ $comentario->user->name }}</h6>
                        <p class="text-muted small mb-0">Publicado {{ $comentario->created_at }}</p>
                    </div>
                </div>
                <p class="mt-3 mb-4 pb-2">{{ $comentario->texto }}</p>
                    @auth
                    @can ('delete', $comentario)
                    <div class="small d-flex justify-content-start">
                        <a href="{{ route('comentarios.destroy', $comentario->id) }}"><img src="{{ asset('images/buttons/delete.png') }}" alt="Borrar comentario" style="width: 30px"></a>
                    </div>
                    @endcan
                    @endauth
                @empty
                    <div>No hay comentarios en esta noticia.</div>
                @endforelse
            </div>

            <form class="my-2 border border-dark border-3 rounded-5 p-5 mx-auto " style="width: 60%" action="{{ route('comentarios.store') }}" method="post">
                @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="noticia_id" value="{{ $noticia->id }}">
                    <div class="form-group row">
                        <textarea name="texto" id="" cols="30" rows="6" class="up form-control col-sm-10" style="resize: none" placeholder="Escribe tu mensaje"></textarea>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="btn btn-success m-2 mt-5">Enviar</button>
                    </div>
                </form>
            <div>
                <p>Mostrando {{sizeof($comentarios)}} de {{$comentarios->total()}}</p>
            </div>
            <div class="col-10 text-start">{{$comentarios->links()}}</div>
        </div>
    </div>
  </section>

@endsection
