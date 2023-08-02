@extends('layouts.master')

@section('contenido')

{{-- Detalles usuario --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Mi perfil</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Identificado correctamente') }}
                    <h3>Detalles:</h3>
                    <div>
                        <div>Nombre:</div>
                        <div>{{ Auth::user()->name }}</div>
                    </div>
                    <div>
                        <div>Email:</div>
                        <div>{{ Auth::user()->email }}</div>
                    </div>
                    <div>
                        <div>Fecha de alta:</div>
                        <div>{{ Auth::user()->created_at }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Noticias redactadas si es redactor --}}
    @if (Auth::user()->hasRole('redactor'))
        <h3>Noticias escritas</h3>
        <table class="table table-stripped table-bordered">
            <tr class="text-center">
                <th>Título</th>
                <th>Tema</th>
                <th>Texto</th>
                <th>Imagen</th>
                <th>Fecha creación</th>
                <th>Fecha actualización</th>
                <th>Rechazado</th>
                <th>Publicado</th>
                <th></th>
            </tr>
            @foreach ($noticias as $noticia)
                <tr>
                    <td class="text-center" style="max-width: 80px">{{ $noticia->titulo }}</td>
                    <td>{{  $noticia->tema }}</td>
                    <td>
                        @php
                            $resumenTexto = substr($noticia->texto, 0, 200);
                        @endphp
                        {{ $resumenTexto }}
                    </td>
                    <td>{{  $noticia->imagen }}</td>
                    <td>{{  $noticia->created_at }}</td>
                    <td>{{  $noticia->updated_at }}</td>
                    <td>
                        @if ($noticia->rejected == true)
                            Revisar
                        @endif
                    </td>
                    <td>
                        sin hacer
                    </td>
                    <td>
                        <a href="{{route('noticias.show',$noticia->id)}}">
                            <img height="20" width="20" src="{{asset('images/buttons/show.png')}}" alt="Ver detalles" title="Ver detalles">
                        </a>
                        <a href="{{route('noticias.edit', $noticia->id)}}">
                            <img height="20" width="20" src="{{asset('images/buttons/update.png')}}" alt="Modificar" title="Modificar">
                        </a>
                        <a href="{{route('noticias.destroy',$noticia->id)}}">
                            <img height="20" width="20" src="{{asset('images/buttons/delete.png')}}" alt="Borrar" title="Borrar">
                        </a>
                    </td>
                </tr>

            @endforeach
        </table>
    @endif

{{-- Comentarios escritos por usuario registrado --}}
    <h3>Comentarios:</h3>
        <table class="table table-stripped table-bordered">
            <tr class="text-center">
                <th>Noticia</th>
                <th>Comentario</th>
                <th></th>
            </tr>
            @foreach ($comentarios as $comentario)
            <tr class="text-center">
                <td>{{ $noticia->titulo }}</td>
                <td>{{ $comentario->texto }}</td>
                <td>
                    <a href="{{ route('comentarios.delete',$comentario->id) }}">
                        <img height="20" width="20" src="{{asset('images/buttons/delete.png')}}" alt="Borrar" title="Borrar">
                    </a>
                </td>
            </tr>
            @endforeach
        </table>
@endsection
