@extends('layouts.app')

@section('title', 'Editar institución')

@section('content')
<div class="container py-4">

    {{-- Encabezado + volver --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Editar institución</h2>
        <a href="{{ route('instituciones.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver al listado
        </a>
    </div>

    {{-- Validación de errores --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Se encontraron errores:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('instituciones.update', $institucion) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                {{-- Código --}}
                <div class="col-md-4">
                    <label for="codigo" class="form-label fw-semibold">Código *</label>
                    <input type="number" required class="form-control @error('codigo') is-invalid @enderror" id="codigo" name="codigo" value="{{ old('codigo', $institucion->codigo) }}">
                    @error('codigo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Nombre --}}
                <div class="col-md-8">
                    <label for="nombre" class="form-label fw-semibold">Nombre *</label>
                    <input type="text" required class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre"value="{{ old('nombre', $institucion->nombre) }}">
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Siglas --}}
                <div class="col-md-4">
                    <label for="siglas" class="form-label fw-semibold">Siglas *</label>
                    <input type="text" required class="form-control @error('siglas') is-invalid @enderror" id="siglas" name="siglas" value="{{ old('siglas', $institucion->siglas) }}">
                    @error('siglas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- RUC (10 dígitos) --}}
                <div class="col-md-4">
                    <label for="ruc" class="form-label fw-semibold">RUC *</label>
                    <input type="text" required pattern="\d{10}" class="form-control @error('ruc') is-invalid @enderror" id="ruc" name="ruc" value="{{ old('ruc', $institucion->ruc) }}">
                    <div class="form-text">10 dígitos numéricos</div>
                    @error('ruc')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- E-mail --}}
                <div class="col-md-4">
                    <label for="email" class="form-label fw-semibold">E-mail *</label>
                    <input type="email" required class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $institucion->email) }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Teléfono --}}
                <div class="col-md-4">
                    <label for="telefono" class="form-label fw-semibold">Teléfono *</label>
                    <input type="text" required pattern="09\d{8}" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono', $institucion->telefono) }}">
                    <div class="form-text">Debe iniciar en 09 y tener 10 dígitos</div>
                    @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Dirección --}}
                <div class="col-md-8">
                    <label for="direccion" class="form-label fw-semibold">Dirección *</label>
                    <input type="text" required class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion', $institucion->direccion) }}">
                    @error('direccion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Estado (activo / inactivo) --}}
                <div class="col-md-4">
                    <label for="estado" class="form-label fw-semibold">Estado *</label>
                    <select id="estado" name="estado" class="form-select @error('estado') is-invalid @enderror" required>
                        <option value="1" {{ old('estado', $institucion->estado) ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('estado', $institucion->estado) ? '' : 'selected' }}>Inactivo</option>
                    </select>
                    @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Botones --}}
                <div class="col-12 d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('instituciones.index') }}" class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Guardar cambios
                    </button>
                </div>
            </form>

        </div><!-- /.card-body -->
    </div><!-- /.card -->
</div><!-- /.container -->
@endsection