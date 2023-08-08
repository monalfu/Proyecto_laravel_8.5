@extends('layouts.master')

@section('titulo', 'Contactar con Laranews')

@section('contenido')
    <div class="container row mx-auto">
        <form action="{{--route(contacto.email)--}}" method="POST" class="col-7-my-2 border p-4 mx-auto">
            @csrf
            <div class="form-group row">
                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                <input type="email" name="email" id="inputEmail" class="up form-control" placeholder="Email" maxlength="255" required>
            </div>
            <div class="form-group row">
                <label for="inputNombre" class="col-sm-2 col-form">Nombre</label>
                <input type="text" name="nombre" id="inputNombre" class="up form-control" placeholder="Nombre" maxlength="255" value="{{old('nombre')}}" required>
            </div>
            <div class="form-group row">
                <label for="inputAsunto" class="col-sm-2 col-form">Asunto</label>
                <input type="text" name="asunto" id="inputAsunto" class="up form-control" placeholder="Asunto" maxlength="255" value="{{old('asunto')}}" required>
            </div>
            <div class="form-group row">
                <label for="inputMensaje" class="col-sm-2 col-form">Mensaje</label>
                <textarea style="resize: none" name="mensaje" id="inputMensaje" cols="30" rows="10" maxlength="400" placeholder="Escribe tu mensaje" value="{{old('mensaje')}}" required></textarea>
            </div>
            <div class="form-group row">
                <button style="max-width: 25rem" type="submit" class="btn btn-success mx-auto m-2 mt-5">Enviar</button>
                <button style="max-width: 25rem" type="reset" class="btn btn-danger mx-auto m-2 mt-5">Borrar</button>
            </div>
        </form>
        
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d191186.61024636962!2d1.9631793164062417!3d41.519641499999985!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a4952ef0b8c6e9%3A0xb6f080d2f180b111!2sCIFO%20Valles!5e0!3m2!1ses!2ses!4v1688580099047!5m2!1ses!2ses" min-width="300px" min-height="300px" class="col-5 my-2 border p-3 mx-auto" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
@endsection

@section('enlaces')
    @parent
    <a href="{{route('noticias.index')}}" class="btn btn-primary m-2">Noticias</a>
@endsection
