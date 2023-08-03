@extends('layouts.master')

@section('titulo', 'Nueva noticia')

@section('contenido')
    <form class="my-2 border border-dark border-3 rounded-5 p-5 mx-auto " style="width: 60%" action="{{route('noticias.store')}}" method="post" enctype="multipart/form-data">
    @csrf
        <div class="form-group row">
            <label for="inputTitulo" class="col-sm-2 col-form-label">Título:</label>
            <input name="titulo" type="text" class="up form-control col-sm-10" id="inputTitulo" placeholder="Título" maxlength="300" required>
        </div>
        <div class="form-group row">
            <label for="temas">Tema:</label>
            <select name="temas" id="temas" placeholder="Escoge una opcón" required>
                <option selected="true" disabled>Escoge un tema</option>
                <option value="politica">Política</option>
                <option value="deporte">Deporte</option>
                <option value="economia">Economía</option>
                <option value="cultural">Cultural</option>
                <option value="social">Social</option>
                <option value="entretenimiento">Entretenimiento</option>
                <option value="ciencia">Ciencia</option>
                <option value="suceso">Sucesos</option>
                <option value="corazon">Corazón</option>
            </select>
        </div>
        <div class="form-group row">
            <label for="inputTexto" class="col-sm-2 col-form-label">Texto:</label>
            <textarea name="texto" id="" cols="30" rows="6" class="up form-control col-sm-10" style="resize: none"></textarea>
        </div>

        <div class="form-group row py-3">
            <label for="inputImagen" class="col-sm-2 col-form-label">Imagen</label>
            <input type="file" name="imagen" id="inputImagen" class="form-control-file col-sm-10">
        </div>
        <div class="form-group row">
            <button type="submit" class="btn btn-success m-2 mt-5">Guardar</button>
            <button type="reset" class="btn btn-secondary m-2">Borrar</button>
        </div>
    </form>
@endsection
