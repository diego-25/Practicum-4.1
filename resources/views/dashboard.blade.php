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
                    <i class="bbi bi-people"></i>
                </a>
            </div>

            <div class="col-12 col-md-6 col-xl-4">
                <a href="{{ route('objetivos.index') }}" class="btn btn-danger w-100 py-4 d-flex justify-content-between align-items-center shadow">
                    <span>Gestionar objetivos</span>
                    <i class="bi bi-people"></i>
                </a>
            </div>

            <div class="col-12 col-md-6 col-xl-4">
                <a href="{{ route('programas.index') }}" class="btn btn-danger w-100 py-4 d-flex justify-content-between align-items-center shadow">
                    <span>Gestionar programas</span>
                    <i class="bi bi-people"></i>
                </a>
            </div>

            <div class="col-12 col-md-6 col-xl-4">
                <a href="{{ route('planes.index') }}" class="btn btn-danger w-100 py-4 d-flex justify-content-between align-items-center shadow">
                    <span>Gestionar planes</span>
                    <i class="bi bi-people"></i>
                </a>
            </div>

            <div class="col-12 col-md-6 col-xl-4">
                <a href="{{ route('proyectos.index') }}" class="btn btn-danger w-100 py-4 d-flex justify-content-between align-items-center shadow">
                    <span>Gestionar proyectos</span>
                    <i class="bi bi-people"></i>
                </a>
            </div>
        @endrole
    </div>

</div>
@endsection