@extends('layouts.app')

@section('title', 'Editar Objetivo Estratégico')

@section('content')
<div class="container py-4">

    <h1 class="h4 mb-4">Editar objetivo estratégico</h1>

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

    <form method="POST" action="{{ route('objetivos.update', $objetivo->idObjetivo) }}">
        @csrf
        @method('PUT')

        {{-- Código (solo lectura) --}}
        <div class="form-group mb-3">
            <label>Código</label>
            <input type="text"
                   class="form-control-plaintext fw-bold"
                   value="{{ $objetivo->codigo }}"
                   readonly>
        </div>

        {{-- Tipo --}}
        <div class="form-group mb-3">
            <label for="tipo">Tipo *</label>
            <select id="tipo" name="tipo"
                    class="form-select @error('tipo') is-invalid @enderror" required>
                <option value="" disabled>— Seleccione —</option>
                <option value="Institucional"  @selected(old('tipo', $objetivo->tipo)=='Institucional')>
                    Institucional
                </option>
                <option value="ODS" @selected(old('tipo', $objetivo->tipo)=='ODS')>
                    ODS
                </option>
                <option value="PND" @selected(old('tipo', $objetivo->tipo)=='PND')>
                    Plan Nacional de Desarrollo
                </option>
            </select>
            @error('tipo') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Nombre --}}
        <div class="form-group mb-3">
            <label for="nombre">Nombre *</label>
            <input id="nombre" name="nombre" type="text" required
                   value="{{ old('nombre', $objetivo->nombre) }}"
                   class="form-control @error('nombre') is-invalid @enderror">
            @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Descripción --}}
        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="3"
                      class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $objetivo->descripcion) }}</textarea>
            @error('descripcion') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Vigencia --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="vigencia_desde">Vigencia desde</label>
                <input id="vigencia_desde" name="vigencia_desde" type="date"
                       value="{{ old('vigencia_desde', $objetivo->vigencia_desde) }}"
                       class="form-control @error('vigencia_desde') is-invalid @enderror">
                @error('vigencia_desde') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mt-3 mt-md-0">
                <label for="vigencia_hasta">Vigencia hasta</label>
                <input id="vigencia_hasta" name="vigencia_hasta" type="date"
                       value="{{ old('vigencia_hasta', $objetivo->vigencia_hasta) }}"
                       class="form-control @error('vigencia_hasta') is-invalid @enderror">
                @error('vigencia_hasta') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        {{-- Estado --}}
        <div class="form-group mb-4">
            <label for="estado">Estado</label>
            <select id="estado" name="estado" class="form-select">
                <option value="1" @selected(old('estado', $objetivo->estado)==1)>Activo</option>
                <option value="0" @selected(old('estado', $objetivo->estado)==0)>Inactivo</option>
            </select>
        </div>

        {{-- Botones --}}
        <button type="submit" class="btn btn-primary">Actualizar objetivo</button>
        <a href="{{ route('objetivos.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection