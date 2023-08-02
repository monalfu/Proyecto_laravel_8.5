@extends('layouts.master')

@section('titulo', "Editar noticia $noticia->titulo")

@section('contenido')
<form class="my-2 border p-5" method="POST" action="{{route('dulces.update', $dulce->id)}}" enctype="multipart/form-data" >
    @csrf
    <input name="_method" type="hidden" value="PUT">
    <div class="form-group row">
        <label for="inputTitulo" class="col-sm-2 col-form-label">Titulo</label>
        <input type="text" name="titulo" class="up form-control col-sm-10" id="inputTitulo" placeholder="{{old('titulo')}}" maxlength="30" value="{{$noticia->titulo}}" required>
    </div>
    <div class="form-group row">
        <label for="inputTexto" class="col-sm-2 col-form-label">Porciones</label>
        <textarea name="texto" type="text" class="up form-control col-sm-10" id="inputTexto" placeholder="{{old('texto')}}" value="{{$noticia->texto}}"  required>
    </div>
    <div class="form-group d-flex align-items-center">
        <div>
            <p>Foto actual:</p>
            <img class="rounded" style="max-width: 80%" src="{{$noticia->imagen ? asset('storage/' . config('filesystems.noticiasImageDir')) . '/' . $dulce->imagen : asset('storage/' . config('filesystems.dulcesImageDir')) . '/default.png'}}" alt="Imagen de {{$dulce->nombre}}" title="Imagen de {{$dulce->nombre}}">
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