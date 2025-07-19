@extends('layouts.app')

@section('title', 'Nuevo Plan Institucional')

@section('content')
<div class="container py-4">

    <h1 class="h4 mb-4">Registrar nuevo plan institucional</h1>

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

    <form method="POST" action="{{ route('planes.store') }}">
        @csrf

        {{-- Código autogenerado (solo lectura) --}}
        <div class="form-group mb-3">
            <label>Código</label>
            <input type="text" name="codigo" class="form-control-plaintext fw-bold" value="{{ $codigoSiguiente }}" readonly>
        </div>

        {{-- Objetivo --}}
        <div class="form-group mb-3">
            <label for="idObjetivo" class="form-label">Objetivo</label>
            <select id="idObjetivo" name="idObjetivo" class="form-select" data-programa-route="{{ url('ajax/objetivos/:id/programas') }}" required>
                <option value="">-- Seleccione Objetivo --</option>
                @foreach ($objetivos as $id => $nombre)
                    <option value="{{ $id }}" @selected(old('idObjetivo') == $id)>{{ $nombre }}</option>
                @endforeach
            </select>
        </div>

        {{-- Programa --}}
        <div class="form-group mb-3">
            <label for="idPrograma" class="form-label">Programa</label>
            <select id="idPrograma" name="idPrograma" class="form-select" data-plan-route="{{ url('ajax/programas/:id/planes') }}" 
            data-old="{{ old('idPrograma') }}" required>
                <option value="">-- Seleccione Programa --</option>
            </select>
        </div>

        {{-- Nombre --}}
        <div class="form-group mb-3">
            <label for="nombre">Nombre *</label>
            <input id="nombre" name="nombre" type="text" required value="{{ old('nombre') }}"
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

        {{-- Vigencia --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="vigencia_desde">Vigencia desde</label>
                <input id="vigencia_desde" name="vigencia_desde" type="date" value="{{ old('vigencia_desde') }}"
                       class="form-control @error('vigencia_desde') is-invalid @enderror">
                @error('vigencia_desde') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mt-3 mt-md-0">
                <label for="vigencia_hasta">Vigencia hasta</label>
                <input id="vigencia_hasta" name="vigencia_hasta" type="date" value="{{ old('vigencia_hasta') }}"
                       class="form-control @error('vigencia_hasta') is-invalid @enderror">
                @error('vigencia_hasta') <small class="text-danger">{{ $message }}</small> @enderror
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
        <button type="submit" class="btn btn-primary">Guardar plan</button>
        <a href="{{ route('planes.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
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