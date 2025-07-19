@extends('layouts.app')

@section('title', 'Editar Proyecto')

@section('content')
<div class="container py-4">

    <h1 class="h4 mb-4">Editar proyecto</h1>

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

    <form method="POST" action="{{ route('proyectos.update', $proyecto) }}">
        @csrf
        @method('PUT')

        {{-- Código (solo lectura) --}}
        <div class="form-group mb-3">
            <label>Código</label>
            <input type="text"
                   class="form-control-plaintext fw-bold"
                   value="{{ $proyecto->codigo ?? 'PRY-'.str_pad($proyecto->idProyecto,6,'0',STR_PAD_LEFT) }}"
                   readonly>
        </div>

        {{-- Objetivo --}}
        <div class="form-group mb-3">
            <label for="idObjetivo" class="form-label">Objetivo estratégico *</label>
            <select id="idObjetivo" name="idObjetivo" required
                    class="form-select @error('idObjetivo') is-invalid @enderror"
                    data-programa-route="{{ url('/ajax/objetivos/:id/programas') }}">
                <option disabled>— Seleccione —</option>
                @foreach ($objetivos as $id => $texto)
                    <option value="{{ $id }}"
                        @selected(old('idObjetivo', $proyecto->plan->programa->idObjetivo) == $id)>
                        {{ $texto }}
                    </option>
                @endforeach
            </select>
            @error('idObjetivo') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Programa --}}
        <div class="form-group mb-3">
            <label for="idPrograma" class="form-label">Programa institucional *</label>
            <select id="idPrograma" name="idPrograma" required
                    class="form-select @error('idPrograma') is-invalid @enderror"
                    data-plan-route="{{ url('/ajax/programas/:id/planes') }}"
                    data-old="{{ old('idPlan', $proyecto->idPlan) }}">
                <option disabled>— Seleccione —</option>
                @foreach ($programas as $id => $texto)
                    <option value="{{ $id }}"
                        @selected(old('idPrograma', $proyecto->idPrograma) == $id)>
                        {{ $texto }}
                    </option>
                @endforeach
            </select>
            @error('idPrograma') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Plan --}}
        <div class="form-group mb-3">
            <label for="idPlan">Plan institucional *</label>

            <select id="idPlan" name="idPlan"
                    class="form-select @error('idPlan') is-invalid @enderror"
                    required>
                <option disabled>— Seleccione —</option>
                @foreach ($planes as $id => $texto)
                    <option value="{{ $id }}"
                        @selected(old('idPlan', $proyecto->idPlan) == $id)>
                        {{ $texto }}
                    </option>
                @endforeach
            </select>
            @error('idPlan') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Nombre --}}
        <div class="form-group mb-3">
            <label for="nombre">Nombre *</label>
            <input id="nombre" name="nombre" type="text" required
                   value="{{ old('nombre', $proyecto->nombre) }}"
                   class="form-control @error('nombre') is-invalid @enderror">
            @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Descripción --}}
        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="3"
                      class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $proyecto->descripcion) }}</textarea>
            @error('descripcion') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Presupuesto --}}
        <div class="form-group mb-3">
            <label for="monto_presupuesto">Monto presupuesto (USD)</label>
            <input id="monto_presupuesto" name="monto_presupuesto" type="number" step="0.01" min="0"
                   value="{{ old('monto_presupuesto', $proyecto->monto_presupuesto) }}"
                   class="form-control @error('monto_presupuesto') is-invalid @enderror">
            @error('monto_presupuesto') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Fechas --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="fecha_inicio">Fecha inicio</label>
                <input id="fecha_inicio" name="fecha_inicio" type="date"
                       value="{{ old('fecha_inicio', $proyecto->fecha_inicio) }}"
                       class="form-control @error('fecha_inicio') is-invalid @enderror">
                @error('fecha_inicio') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mt-3 mt-md-0">
                <label for="fecha_fin">Fecha fin</label>
                <input id="fecha_fin" name="fecha_fin" type="date"
                       value="{{ old('fecha_fin', $proyecto->fecha_fin) }}"
                       class="form-control @error('fecha_fin') is-invalid @enderror">
                @error('fecha_fin') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        {{-- Estado --}}
        <div class="form-group mb-4">
            <label for="estado">Estado</label>
            <select id="estado" name="estado" class="form-select">
                <option value="1" @selected(old('estado', $proyecto->estado)==1)>Activo</option>
                <option value="0" @selected(old('estado', $proyecto->estado)==0)>Inactivo</option>
            </select>
        </div>

        {{-- Botones --}}
        <button type="submit" class="btn btn-primary">Actualizar proyecto</button>
        <a href="{{ route('proyectos.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection