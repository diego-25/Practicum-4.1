@extends('layouts.app')

@section('title', 'Panel de control')

@section('content')
<div class="container">

    {{-- Saludo al usuario --}}
    <h2 class="mb-4">Hola, {{ Auth::user()->name }}</h2>

    {{-- MÉTRICAS ------------------------------------------------------ --}}
    <div class="row g-4 mb-5">
        {{-- Total usuarios --}}
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h6 class="card-title text-muted mb-1">Usuarios</h6>
                    <h3 class="fw-semibold">{{ \App\Models\User::count() }}</h3>
                </div>
            </div>
        </div>

        {{-- Instituciones --}}
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h6 class="card-title text-muted mb-1">Instituciones</h6>
                    <h3 class="fw-semibold">{{ \App\Models\Institucion::count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- ACCESOS RÁPIDOS (según rol) ---------------------------------- --}}
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

        {{-- Añade más bloques @role('Tecnico') … @endrole si los necesitas --}}
    </div>

</div>
@endsection