@extends('layouts.app')

@section('title', 'Editar Plan Institucional')

@section('content')
<div class="container py-4">

    <h1 class="h4 mb-4">Editar plan institucional</h1>

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

    <form method="POST" action="{{ route('planes.update', $plan) }}">
        @csrf
        @method('PUT')

        {{-- Código (solo lectura) --}}
        <div class="form-group mb-3">
            <label>Código</label>
            <input type="text" class="form-control-plaintext fw-bold" value="{{ $plan->codigo ?? 'PL-' . str_pad($plan->idPlan, 6, '0', STR_PAD_LEFT) }}" readonly>
        </div>

        {{-- Programa al que pertenece --}}
        <div class="form-group mb-3">
            <label for="idPrograma">Programa institucional *</label>
            <select id="idPrograma" name="idPrograma"
                    class="form-select @error('idPrograma') is-invalid @enderror"
                    required>
                <option disabled>— Seleccione —</option>
                @foreach($programas as $id => $nombre)
                    <option value="{{ $id }}"
                        @selected(old('idPrograma', $plan->idPrograma) == $id)>
                        {{ $nombre }}
                    </option>
                @endforeach
            </select>
            @error('idPrograma') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Nombre --}}
        <div class="form-group mb-3">
            <label for="nombre">Nombre *</label>
            <input id="nombre" name="nombre" type="text" required value="{{ old('nombre', $plan->nombre) }}"
                   class="form-control @error('nombre') is-invalid @enderror">
            @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Descripción --}}
        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="3"
                      class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $plan->descripcion) }}</textarea>
            @error('descripcion') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Vigencia --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="vigencia_desde">Vigencia desde</label>
                <input id="vigencia_desde" name="vigencia_desde" type="date"
                       value="{{ old('vigencia_desde', $plan->vigencia_desde) }}"
                       class="form-control @error('vigencia_desde') is-invalid @enderror">
                @error('vigencia_desde') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mt-3 mt-md-0">
                <label for="vigencia_hasta">Vigencia hasta</label>
                <input id="vigencia_hasta" name="vigencia_hasta" type="date"
                       value="{{ old('vigencia_hasta', $plan->vigencia_hasta) }}"
                       class="form-control @error('vigencia_hasta') is-invalid @enderror">
                @error('vigencia_hasta') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        {{-- Estado --}}
        <div class="form-group mb-4">
            <label for="estado">Estado</label>
            <select id="estado" name="estado" class="form-select">
                <option value="1" @selected(old('estado', $plan->estado)==1)>Activo</option>
                <option value="0" @selected(old('estado', $plan->estado)==0)>Inactivo</option>
            </select>
        </div>

        {{-- Botones --}}
        <button type="submit" class="btn btn-primary">Actualizar plan</button>
        <a href="{{ route('planes.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection