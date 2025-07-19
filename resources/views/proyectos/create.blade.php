@extends('layouts.app')

@section('title', 'Nuevo Proyecto')

@section('content')
<div class="container py-4">

    <h1 class="h4 mb-4">Registrar nuevo proyecto</h1>

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

    <form method="POST" action="{{ route('proyectos.store') }}">
        @csrf

        {{-- Código autogenerado (solo lectura) --}}
        <div class="form-group mb-3">
            <label>Código</label>
            <input type="text" name="codigo" class="form-control-plaintext fw-bold" value="{{ $codigoSiguiente }}" readonly>
        </div>

        {{-- Plan al que pertenece --}}
        <div class="form-group mb-3">
            <label for="idPlan">Plan institucional *</label>
            <select id="idPlan" name="idPlan"
                    class="form-select @error('idPlan') is-invalid @enderror" required>
                <option value="" disabled selected>— Seleccione —</option>
                @foreach ($planes as $id => $texto)
                    <option value="{{ $id }}" @selected(old('idPlan') == $id)>
                        {{ $texto }}
                    </option>
                @endforeach
            </select>
            <small class="form-text text-muted">
                Muestra: Plan — Programa
            </small>
            @error('idPlan') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Selects dependientes --}}
        <div class="row g-3">

            {{-- Objetivo --}}
            <div class="col-md-4">
                <label for="idObjetivo" class="form-label">Objetivo</label>
                <select id="idObjetivo" name="idObjetivo" class="form-select" data-programa-route="{{ url('ajax/objetivos/:id/programas') }}" required>
                    <option value="">-- Seleccione Objetivo --</option>
                    @foreach ($objetivos as $id => $nombre)
                        <option value="{{ $id }}" @selected(old('idObjetivo') == $id)>{{ $nombre }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Programa --}}
            <div class="col-md-4">
                <label for="idPrograma" class="form-label">Programa</label>
                <select id="idPrograma" name="idPrograma" class="form-select" data-plan-route="{{ url('ajax/programas/:id/planes') }}" 
                data-old="{{ old('idPrograma') }}" required>
                    <option value="">-- Seleccione Programa --</option>
                </select>
            </div>

            {{-- Plan --}}
            <div class="col-md-4">
                <label for="idPlan" class="form-label">Plan</label>
                <select id="idPlan" name="idPlan" class="form-select" data-old="{{ old('idPlan') }}" required>
                    <option value="">-- Seleccione Plan --</option>
                </select>
            </div>

        </div>

        {{-- Nombre --}}
        <div class="form-group mb-3">
            <label for="nombre">Nombre *</label>
            <input id="nombre" name="nombre" type="text" required
                   value="{{ old('nombre') }}"
                   class="form-control @error('nombre') is-invalid @enderror">
            @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Descripción --}}
        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="3"
                      class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion') }}</textarea>
            @error('descripcion') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Presupuesto --}}
        <div class="form-group mb-3">
            <label for="monto_presupuesto">Monto presupuesto (USD)</label>
            <input id="monto_presupuesto" name="monto_presupuesto" type="number" step="0.01" min="0"
                   value="{{ old('monto_presupuesto') }}"
                   class="form-control @error('monto_presupuesto') is-invalid @enderror">
            @error('monto_presupuesto') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Fechas --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="fecha_inicio">Fecha inicio</label>
                <input id="fecha_inicio" name="fecha_inicio" type="date"
                       value="{{ old('fecha_inicio') }}"
                       class="form-control @error('fecha_inicio') is-invalid @enderror">
                @error('fecha_inicio') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mt-3 mt-md-0">
                <label for="fecha_fin">Fecha fin</label>
                <input id="fecha_fin" name="fecha_fin" type="date"
                       value="{{ old('fecha_fin') }}"
                       class="form-control @error('fecha_fin') is-invalid @enderror">
                @error('fecha_fin') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        {{-- Estado --}}
        <div class="form-group mb-4">
            <label for="estado">Estado</label>
            <select id="estado" name="estado" class="form-select">
                <option value="1" @selected(old('estado',1)==1)>Activo</option>
                <option value="0" @selected(old('estado')==='0')>Inactivo</option>
            </select>
        </div>

        {{-- Botones --}}
        <button type="submit" class="btn btn-primary">Guardar proyecto</button>
        <a href="{{ route('proyectos.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(function () {

    /** función genérica para cargar hijos **/
    function loadChildren($parent, routeAttr, $child) {
        const id   = $parent.val();
        const tmpl = $parent.data(routeAttr);   // ej: "/ajax/objetivos/:id/programas"
        if (!id || !tmpl) {
            $child.html('<option value="">-- Seleccione --</option>').trigger('change');
            return;
        }

        $.getJSON(tmpl.replace(':id', id), function (items) {
            let options = '<option value="">-- Seleccione --</option>';
            $.each(items, (_, it) => options += `<option value="${it.value}">${it.text}</option>`);
            $child.html(options);

            // seleccionar valor previo (cuando vuelve de error 422)
            const old = $child.data('old');
            if (old) { $child.val(old).data('old', null); }

            $child.trigger('change'); // encadena al siguiente nivel
        });
    }

    // cascada Objetivo → Programa
    $('#idObjetivo').on('change', function () {
        loadChildren($(this), 'programa-route', $('#idPrograma'));
    });

    // cascada Programa → Plan
    $('#idPrograma').on('change', function () {
        loadChildren($(this), 'plan-route', $('#idPlan'));
    });

    // si había valores antiguos (error de validación) disparamos al inicio
    if ($('#idObjetivo').val()) {
        $('#idObjetivo').trigger('change');
    }
});
</script>
@endpush