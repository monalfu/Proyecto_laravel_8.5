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
        <h3 class="text-center mt-4">Noticias escritas</h3>
        <table class="table table-stripped table-bordered mx-auto" style="width: 80%">
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
                    <td class="text-center align-middle" style="">{{ $noticia->titulo }}</td>
                    <td class=" align-middle">{{  $noticia->tema }}</td>
                    <td>
                        @php
                            $resumenTexto = substr($noticia->texto, 0, 200);
                        @endphp
                        {{ $resumenTexto }}
                    </td>
                    <td class="text-center align-middle">
                        <img src="{{ $noticia->imagen ? asset('storage/'. config('filesystems.noticiasImageDir')) . '/' . $noticia->imagen : asset('storage/'. config('filesystems.noticiasImageDir')) . '/default.jpg' }}" alt="" class="rounded" style="width: 10rem">
                    </td>
                    <td class="text-center align-middle">{{  $noticia->created_at }}</td>
                    <td class="text-center align-middle">{{  $noticia->updated_at }}</td>
                    <td class="text-center align-middle">
                        @if ($noticia->rejected == true)
                        <div class="text-center align-middle">
                            <img style="width: 40px" src="{{asset('images/icons/noCheck.png')}}" title="Noticia publicada">
                        </div>
                        @endif
                    </td>
                    <td class="text-center align-middle">
                        @if ($noticia->published_at != NULL)
                            <div class="text-center align-middle">
                                <img style="width: 40px" src="{{ asset('images/icons/check.png') }}" title="Noticia publicada">
                                <p>{{ $noticia->published_at }}</p>
                            </div>
                        @else
                            <div class="text-center align-middle">
                                <img style="width: 40px" src="{{ asset('images/icons/noCheck.png') }}" title="Noticia publicada">
                            </div>
                        @endif
                    </td>
                    <td class="text-center align-middle">
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

{{-- Noticias eliminadas --}}
    @if (count($deletedNoticias))
        <h3 class="text-center mt-4">Noticias eliminadas:</h3>
        <table class="table table-striped table-bordered mx-auto" style="width: 80%">
            <tr class="text-center">
                <th>Título</th>
                <th>Fecha eliminación</th>
                <th></th>
            </tr>
            @foreach ($deletedNoticias as $noticia)
            <tr>
                <td class="text-center">{{ $noticia->titulo }}</td>
                <td class="text-center">{{ $noticia->deleted_at }}</td>
                <td class="text-center">
                    <div class="container">
                        <div class="row align-items-center">
                            <a href="{{ route('noticias.restore', $noticia->id) }}" class="col text-center">
                                <button class="btn btn-success">Restaurar</button>
                            </a>
                            <form action="{{ route('noticias.purge') }}" method="POST" class="col text-center">
                            @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="noticia_id" value="{{ $noticia->id }}">
                                <input type="submit" value="Eliminar" alt="Eliminar" title="Eliminar" class="btn btn-danger">
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
    @endif


{{-- Comentarios escritos por usuario registrado --}}
    <h3 class="text-center mt-4">Comentarios:</h3>
        <table class="table table-striped table-bordered mx-auto" style="width: 80%">
            <tr class="text-center">
                <th>Noticia</th>
                <th>Comentario</th>
                <th></th>
            </tr>
            @foreach ($comentarios as $comentario)
            <tr class="text-center">
                <td>{{ $comentario->noticia->titulo }}</td>
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
