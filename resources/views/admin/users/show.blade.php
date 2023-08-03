@extends('layouts.master')
@section('titulo', "Detalles del usuario $user->name")
@section('contenido')
    <div class="row">
        <table class="col-8 table table-striped table-bordered">
            <tr>
                <td>ID</td>
                <td>{{ $user->id }}</td>
            </tr>
            <tr>
                <td>Nombre</td>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
            </tr>
            <tr>
                <td>Fecha de alta</td>
                <td>{{ $user->created_at }}</td>
            </tr>
            <tr>
                <td>Fecha de verificación</td>
                <td> {{ $user->verified_at ?? 'Sin verificar' }} </td>
            </tr>
            <tr>
                <td>Roles</td>
                <td>
                    @foreach ($user->roles as $rol)
                        <span class="d-inline-block w-50">- {{ $rol->role }} </span>
                        <form action="{{ route('admin.user.removeRole') }}" class="d-inline-block p-1" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <input type="hidden" name="role_id" value="{{ $rol->id }}">
                            <input type="submit" value="Eliminar" class="btn btn-danger">
                        </form>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>Añadir rol</td>
                <td>
                    <form action="{{ route('admin.user.setRole') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="post">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <select class="form-select w-50 d-inline" name="role_id">
                        @foreach ($user->remainingRoles() as $rol)
                            <option selected disabled hidden>Escoge un rol</option>
                            <option value="{{ $rol->id }}">{{ $rol->role }}</option>
                        @endforeach
                        </select>
                        <input type="submit" value="Añadir" class="btn btn-success px-3 ml-1">
                    </form>
                </td>
            </tr>
        </table>
    </div>

    <div class="container mt-5">
        <h3>noticias del {{ $user->name }}</h3>
        <table class="table table-striped table-borderes">
            <tr class="text-center">
                <th>Id</th>
                <th>Imagen</th>
                <th>Título</th>
                <th>Texto</th>
                <th></th>
            </tr>
            @foreach ($noticias as $noticia)
                <tr class="text-center">
                    <td>{{$noticia->id}}</td>
                    <td class="text-center" style="max-width: 80px">
                        <img class="rounded" style="max-width: 80%" src="{{$noticia->imagen ? asset('storage/' . config('filesystems.noticiasImageDir')) . '/' . $noticia->imagen : asset('storage/' . config('filesystems.noticiasImageDir')) . '/default.jpg'}}" alt="Imagen de {{$noticia->titulo}}" title="Imagen de {{$noticia->titulo}}">
                    </td>
                    <td>{{$noticia->titulo}}</td>
                    <td>
                        @php
                        $resumenTexto = substr($noticia->texto, 0, 400);
                        @endphp
                        {{ $resumenTexto }}
                    </td>

                    <td class="">
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
    </div>
@endsection

@section('enlace')
    @parent
    <a href="{{ route('admin.users') }}" class="btn btn-primary m-2">Lista de usuarios</a>
@endsection
