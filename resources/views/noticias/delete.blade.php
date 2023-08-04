@extends('layouts.master')

@section('titulo', "Confirmación de borrado de $noticia->titulo")

@section('contenido')
    <form action="{{ URL::temporarySignedRoute('noticias.purge')}}" method="post">
    @csrf
        <input type="hidden" name="_method" value="DELETE">
        <label for="confirmDelete">¿Estás seguro que deseas eliminar la noticia {{ $noticia->titulo }}?</label>
        <input type="submit" value="Borrar" alt="Borrar" class="btn btn-danger m-4">
    </form>
