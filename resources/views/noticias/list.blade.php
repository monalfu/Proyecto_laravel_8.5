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

    <table class="table table-striped table-bordered">
        <tr class="text-center">
            {{-- auth para que el id solo lo vea redactor, editor y admin --}}
            <th>Id</th>

            <th>Imagen</th>
            <th>Título</th>
            <th>Tema</th>
            <th></th>
        </tr>
    </table>

@endsection
