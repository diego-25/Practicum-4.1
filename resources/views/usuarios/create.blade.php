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

        {{-- Institucion --}}
        <div class="form-group mb-4">
            <label for="instituciones">Instituciones *</label>

            <select id="instituciones"
                    name="instituciones[]"
                    class="form-select @error('instituciones') is-invalid @enderror"
                    multiple
                    size="5">
                @foreach ($instituciones as $id => $nombre)
                    <option value="{{ $id }}" @selected( in_array($id, old('instituciones', [])) )>
                        {{ $nombre }}
                    </option>
                @endforeach
            </select>

            <div class="form-text">
                Mantén pulsado <kbd>Ctrl</kbd> para seleccionar mas de una.
            </div>

            @error('instituciones')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Estado --}}
        <div class="form-group mb-4">
            <label for="estado">Estado</label>
            <select id="estado" name="estado" class="form-select">
                <option value="1" @selected(old('estado',1)==1)>Activo</option>
                <option value="0" @selected(old('estado')==='0')>Inactivo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar usuario</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection