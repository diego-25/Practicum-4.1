@extends('layouts.app')

@section('title', 'Editar Institución')

@section('content')
<div class="container py-4">

    <h1 class="h4 mb-4">Editar institución</h1>

    {{-- Alertas de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('instituciones.update', $institucion->idInstitucion) }}">
        @csrf
        @method('PUT')

        {{-- Código sólo lectura (mismo look que create) --}}
        <div class="form-group mb-3">
            <label>Código</label>
            <input type="text" class="form-control-plaintext fw-bold"
                   value="{{ str_pad($institucion->idInstitucion, 6, '0', STR_PAD_LEFT) }}" readonly>
        </div>

        {{-- Nombre --}}
        <div class="form-group mb-3">
            <label for="nombre">Nombre *</label>
            <input id="nombre" name="nombre" type="text" required
                   value="{{ old('nombre', $institucion->nombre) }}"
                   class="form-control @error('nombre') is-invalid @enderror">
            @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Siglas --}}
        <div class="form-group mb-3">
            <label for="siglas">Siglas</label>
            <input id="siglas" name="siglas" type="text" value="{{ old('siglas', $institucion->siglas) }}"
                   class="form-control">
        </div>

        {{-- RUC --}}
        <div class="form-group mb-3">
            <label for="ruc">RUC *</label>
            <input id="ruc" name="ruc" type="text" required value="{{ old('ruc', $institucion->ruc) }}"
                   class="form-control @error('ruc') is-invalid @enderror">
            <div class="form-text">10 dígitos numéricos</div>
            @error('ruc') <small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Email --}}
        <div class="form-group mb-3">
            <label for="email">Correo electrónico *</label>
            <input id="email" name="email" type="email" required value="{{ old('email', $institucion->email) }}"
                   class="form-control @error('email') is-invalid @enderror">
            @error('email') <small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Teléfono --}}
        <div class="form-group mb-3">
            <label for="telefono">Teléfono *</label>
            <input id="telefono" name="telefono" type="text" required pattern="09\d{8}"
                   value="{{ old('telefono', $institucion->telefono) }}"
                   class="form-control @error('telefono') is-invalid @enderror">
            <div class="form-text">Debe iniciar en 09 y tener 10 dígitos</div>
            @error('telefono') <small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Dirección --}}
        <div class="form-group mb-3">
            <label for="direccion">Dirección *</label>
            <textarea id="direccion" name="direccion" rows="2" required
                      class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion', $institucion->direccion) }}</textarea>
            @error('direccion') <small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Estado --}}
        <div class="form-group mb-4">
            <label for="estado">Estado</label>
            <select id="estado" name="estado" class="form-control">
                <option value="1" @selected(old('estado', $institucion->estado)==1)>Activo</option>
                <option value="0" @selected(old('estado', $institucion->estado)==0)>Inactivo</option>
            </select>
        </div>

        {{-- Botones --}}
        <button type="submit" class="btn btn-primary">Actualizar institución</button>
        <a href="{{ route('instituciones.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection