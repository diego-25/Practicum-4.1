@extends('layouts.app')

@section('title', 'Editar Programa')

@section('content')
<div class="container py-4">

    <h1 class="h4 mb-4">Editar programa</h1>

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

    {{-- === FORMULARIO ================================================ --}}
    <form method="POST"
          action="{{ route('programas.update', $programa) }}">
        @csrf
        @method('PUT')

        {{-- Código (solo lectura) --}}
        <div class="form-group mb-3">
            <label>Código</label>
            <input type="text"
                   class="form-control-plaintext fw-bold"
                   value="{{ $programa->codigo ?? 'PR-'.str_pad($programa->idPrograma,6,'0',STR_PAD_LEFT) }}"
                   readonly>
        </div>

        {{-- Objetivo estratégico --}}
        <div class="form-group mb-3">
            <label for="idObjetivo">Objetivo estratégico *</label>
            <select id="idObjetivo" name="idObjetivo" class="form-select @error('idObjetivo') is-invalid @enderror" required>
                <option disabled>— Seleccione —</option>
                @foreach ($objetivos as $id => $nombre)
                    <option value="{{ $id }}" @selected(old('idObjetivo', $programa->idObjetivoEstrategico) == $id)>
                        {{ $nombre }}
                    </option>
                @endforeach
            </select>
            @error('idObjetivo') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Nombre --}}
        <div class="form-group mb-3">
            <label for="nombre">Nombre *</label>
            <input id="nombre" name="nombre" type="text" required alue="{{ old('nombre', $programa->nombre) }}"
                   class="form-control @error('nombre') is-invalid @enderror">
            @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Descripción --}}
        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="3"
                      class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $programa->descripcion) }}</textarea>
            @error('descripcion') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Vigencia --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="vigencia_desde">Vigencia desde</label>
                <input id="vigencia_desde" name="vigencia_desde" type="date"
                       value="{{ old('vigencia_desde', $programa->vigencia_desde) }}"
                       class="form-control @error('vigencia_desde') is-invalid @enderror">
                @error('vigencia_desde') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mt-3 mt-md-0">
                <label for="vigencia_hasta">Vigencia hasta</label>
                <input id="vigencia_hasta" name="vigencia_hasta" type="date"
                       value="{{ old('vigencia_hasta', $programa->vigencia_hasta) }}"
                       class="form-control @error('vigencia_hasta') is-invalid @enderror">
                @error('vigencia_hasta') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        {{-- Estado --}}
        <div class="form-group mb-4">
            <label for="estado">Estado</label>
            <select id="estado" name="estado" class="form-select">
                <option value="1" @selected(old('estado', $programa->estado)==1)>Activo</option>
                <option value="0" @selected(old('estado', $programa->estado)==0)>Inactivo</option>
            </select>
        </div>

        {{-- Botones --}}
        <button type="submit" class="btn btn-primary">Actualizar programa</button>
        <a href="{{ route('programas.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection