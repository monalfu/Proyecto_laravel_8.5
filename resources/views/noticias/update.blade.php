@extends('layouts.master')

@section('titulo', "Editar noticia $noticia->titulo")

@section('contenido')
<form class="my-2 border p-5" method="POST" action="{{route('noticias.update', $noticia->id)}}" enctype="multipart/form-data" >
    @csrf
    <input name="_method" type="hidden" value="PUT">
    <div class="form-group row">
        <label for="inputTitulo" class="col-sm-2 col-form-label">Título:</label>
        <input name="titulo" type="text" class="up form-control col-sm-10" id="inputTitulo" placeholder="{{old('titulo')}}" value="{{$noticia->titulo}}" maxlength="300" required>
    </div>
    <div class="form-group row">
        <label for="temas">Tema:</label>
        <select name="tema" id="tema" required>
            <option selected="true" disabled>{{ $noticia->tema }}</option>
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
        <textarea name="texto" id="" cols="30" rows="6" class="up form-control col-sm-10" style="resize: none" placeholder="{{old('texto')}}"> {{ $noticia->texto }}</textarea>
    </div>

    <div class="form-group d-flex align-items-center justify-content-around">
        <div>
            <p>Foto actual:</p>
            <img class="rounded mr-3" style="max-width: 30rem" src="{{$noticia->imagen ? asset('storage/' . config('filesystems.noticiasImageDir')) . '/' . $noticia->imagen : asset('storage/' . config('filesystems.noticiasImageDir')) . '/default.jpg'}}" alt="Imagen de {{$noticia->nombre}}" title="Imagen de {{$noticia->nombre}}">
        </div>
        <div>
            @if ($noticia->imagen)
                <div class="row">
                    <label for="inputImagen">Sustituir imagen:</label>
                    <input type="file" name="imagen" id="inputImagen" class="form-control-file col-sm-10">
                </div>
            @else
            <div>
                <label for="inputImagen">Subir imagen:</label>
                <input type="file" name="imagen" id="inputImagen" class="form-control-file col-sm-10">
            </div>
            @endif

            @if($noticia->imagen)
            <div class="form-check">
                <input type="checkbox" name="eliminar_imagen" id="eliminar_imagen" value="1" class="form-check-input">
                <label for="eliminar_imagen">Eliminar imagen</label>
            </div>
            <script>
                eliminar_imagen.onchange = function(){
                    inputImagen.disabled = this.checked;
                }
            </script>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <button type="submit" class="btn btn-success m-2 mt-5">Guardar</button>
        <button type="reset" class="btn btn-secondary m-2">Restablecer</button>
    </div>
</form>
@endsection
