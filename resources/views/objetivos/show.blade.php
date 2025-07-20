@extends('layouts.app')

@section('title', 'Detalle de objetivo')

@section('content')
<div class="container py-4">

    {{-- BREADCRUMB --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('objetivos.index') }}">Objetivos</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ $objetivo->codigo }}
            </li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">{{ $objetivo->nombre }}</h1>

        <div>
            <a href="{{ route('objetivos.edit', $objetivo) }}" class="btn btn-sm btn-primary">
                Editar
            </a>
            <a href="{{ route('objetivos.index') }}" class="btn btn-sm btn-outline-secondary">
                Volver
            </a>
        </div>
    </div>

    {{-- Atributos --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-3">
                    <h6 class="text-muted mb-1">Código</h6>
                    <span class="fw-semibold">{{ $objetivo->codigo }}</span>
                </div>
                <div class="col-md-3">
                    <h6 class="text-muted mb-1">Estado</h6>
                    <span class="fw-semibold">
                        {{ $objetivo->estado ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
                <div class="col-12">
                    <h6 class="text-muted mb-1">Descripción</h6>
                    <p class="mb-0">{{ $objetivo->descripcion }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Programas --}}
    <h5 class="mb-3">Programas relacionados</h5>
    @if ($objetivo->programas->isEmpty())
        <p class="text-muted">Este objetivo aún no tiene programas asociados.</p>
    @else
        <div class="table-responsive mb-4">
            <table class="table table-sm table-hover align-middle">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Planes</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($objetivo->programas as $prog)
                        <tr>
                            <td>{{ $prog->codigo }}</td>
                            <td>{{ $prog->nombre }}</td>
                            <td>{{ $prog->planes_count }}</td>
                            <td class="text-end">
                                <a href="{{ route('programas.show', $prog) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    Ver
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Tabs --}}
    <ul class="nav nav-tabs" id="objTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="info-tab"
                    data-bs-toggle="tab" data-bs-target="#info"
                    type="button" role="tab">
                Información
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="audit-tab"
                    data-bs-toggle="tab" data-bs-target="#audit"
                    type="button" role="tab">
                Auditoría
            </button>
        </li>
    </ul>

    <div class="tab-content border border-top-0 p-3">
        <div class="tab-pane fade show active" id="info" role="tabpanel">
            <p class="text-muted">Sin información adicional.</p>
        </div>

        {{-- Auditoría --}}
        <div class="tab-pane fade" id="audit" role="tabpanel">
            @if ($objetivo->audits->isEmpty())
                <p class="text-muted mb-0">Sin registros de auditoría.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-sm table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Evento</th>
                                <th>Usuario</th>
                                <th>Fecha</th>
                                <th>Cambios</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($objetivo->audits as $audit)
                            <tr>
                                <td>{{ ucfirst($audit->event) }}</td>
                                <td>{{ $audit->user->name ?? '—' }}</td>
                                <td>{{ $audit->created_at }}</td>
                                <td>
                                    <details>
                                        <summary class="small text-primary" style="cursor:pointer">
                                            Ver diff
                                        </summary>
<pre class="small bg-light p-2 mb-0">
Old: {{ json_encode($audit->old_values, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}

New: {{ json_encode($audit->new_values, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}
</pre>
                                    </details>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection