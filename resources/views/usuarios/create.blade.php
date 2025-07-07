@extends('layouts.app')

@section('title', 'Nuevo usuario')

@section('content')
<div class="container py-4">

    <h1 class="h4 mb-4">Registrar nuevo usuario</h1>

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

    <form method="POST" action="{{ route('usuarios.store') }}">
        @csrf

        {{-- Nombre --}}
        <div class="form-group mb-3">
            <label for="name">Nombre completo *</label>
            <input id="name" name="name" type="text" required
                   value="{{ old('name') }}"
                   class="form-control @error('name') is-invalid @enderror">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Email --}}
        <div class="form-group mb-3">
            <label for="email">Correo electrónico *</label>
            <input id="email" name="email" type="email" required
                   value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Contraseña --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="password">Contraseña *</label>
                <input id="password" name="password" type="password" required minlength="8"
                       class="form-control @error('password') is-invalid @enderror">
                <div class="form-text">Mínimo 8 caracteres</div>
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="password_confirmation">Confirmar contraseña *</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required minlength="8"
                       class="form-control">
            </div>
        </div>

        {{-- Teléfono --}}
        <div class="form-group mb-3">
            <label for="telefono">Teléfono</label>
            <input id="telefono" name="telefono" type="text" pattern="09\d{8}"
                   value="{{ old('telefono') }}"
                   class="form-control @error('telefono') is-invalid @enderror">
            <div class="form-text">Debe iniciar en 09 y tener 10 dígitos</div>
            @error('telefono') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Cargo --}}
        <div class="form-group mb-3">
            <label for="cargo">Cargo</label>
            <input id="cargo" name="cargo" type="text"
                   value="{{ old('cargo') }}"
                   class="form-control">
        </div>

        {{-- Actor --}}
        <div class="form-group mb-3">
            <label for="actor">Actor *</label>
            <select id="actor" name="actor" class="form-select @error('actor') is-invalid @enderror" required>
                <option value="" disabled selected>-- elegir --</option>
                @foreach ($actors as $actor)
                    <option value="{{ $actor }}" @selected(old('actor') === $actor)>{{ $actor }}</option>
                @endforeach
            </select>
            @error('actor') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Estado --}}
        <div class="form-group mb-4">
            <label for="estado">Estado</label>
            <select id="estado" name="estado" class="form-select">
                <option value="1" @selected(old('estado',1)==1)>Activo</option>
                <option value="0" @selected(old('estado')==='0')>Inactivo</option>
            </select>
        </div>

        {{-- (Opcional) Roles extra: descomenta si alguna vez permites roles adicionales
        <div class="mb-4">
            <label class="form-label d-block">Roles adicionales</label>
            @foreach ($roles as $id => $rol)
                <div class="form-check form-check-inline">
                    <input class="form-check-input"
                           type="checkbox"
                           id="role{{ $id }}"
                           name="roles[]"
                           value="{{ $id }}"
                           @checked( in_array($id, old('roles', [])) )>
                    <label class="form-check-label" for="role{{ $id }}">{{ $rol }}</label>
                </div>
            @endforeach
        </div>
        --}}

        <button type="submit" class="btn btn-primary">Guardar usuario</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection