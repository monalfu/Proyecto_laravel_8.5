@extends('layouts.master')
@section('contenido')

<div class="container row mt-2">
    <h3>USUARIO BLOQUEADO</h3>
    <div class="col-10 alert alert-danger p-4">
        <p>Has sido <b>bloqueado</b> por un administrador</p>
        <p>Si no estás de acuerdo o quieres conocer los motivos, contacta mediante el <a href="{{ route('contacto') }}">formulario de contacto</a></p>
    </div>

</div>

@endsection
