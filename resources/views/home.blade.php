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

@endsection
