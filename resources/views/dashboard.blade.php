@extends('layouts.app')

@section('title', 'Panel de control')

@section('content')
<div class="container">

    {{-- Saludo al usuario --}}
    <h2 class="mb-4">Hola, {{ Auth::user()->name }}</h2>

    {{-- ACCESOS RÁPIDOS (según rol) --}}
    <div class="row g-4">

        @role('Control')
            <div class="col-12 col-md-6 col-xl-4">
                <a href="{{ route('usuarios.index') }}" class="btn btn-primary w-100 py-4 d-flex justify-content-between align-items-center shadow">
                    <span>Gestionar usuarios</span>
                    <i class="bi bi-people"></i>
                </a>
            </div>

            <div class="col-12 col-md-6 col-xl-4">
                <a href="{{ route('instituciones.index') }}" class="btn btn-danger w-100 py-4 d-flex justify-content-between align-items-center shadow">
                    <span>Gestionar instituciones</span>
                    <i class="bi bi-building"></i>
                </a>
            </div>
        @endrole
    </div>

</div>
@endsection