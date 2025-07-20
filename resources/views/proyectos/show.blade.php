@extends('layouts.app')

@section('title', 'Detalle de proyecto')

@section('content')
<div class="container py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('objetivos.index') }}">Objetivos</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('objetivos.show', $proyecto->plan->programa->objetivo) }}">
                    {{ $proyecto->plan->programa->objetivo->codigo }}
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('programas.show', $proyecto->plan->programa) }}">
                    {{ $proyecto->plan->programa->codigo }}
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('planes.show', $proyecto->plan) }}">
                    {{ $proyecto->plan->codigo }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ $proyecto->codigo }}
            </li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">{{ $proyecto->nombre }}</h1>

        <div>
            <a href="{{ route('proyectos.edit', $proyecto) }}" class="btn btn-sm btn-primary">
                Editar
            </a>
            <a href="{{ route('proyectos.index') }}" class="btn btn-sm btn-outline-secondary">
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
                    <span class="fw-semibold">{{ $proyecto->codigo }}</span>
                </div>
                <div class="col-md-3">
                    <h6 class="text-muted mb-1">Presupuesto (USD)</h6>
                    <span class="fw-semibold">{{ number_format($proyecto->monto_presupuesto, 2) }}</span>
                </div>
                <div class="col-md-3">
                    <h6 class="text-muted mb-1">Fecha inicio</h6>
                    <span class="fw-semibold">{{ $proyecto->fecha_inicio->format('d/m/Y') }}</span>
                </div>
                <div class="col-md-3">
                    <h6 class="text-muted mb-1">Fecha fin</h6>
                    <span class="fw-semibold">{{ $proyecto->fecha_fin->format('d/m/Y') }}</span>
                </div>
                <div class="col-12">
                    <h6 class="text-muted mb-1">Descripción</h6>
                    <p class="mb-0">{{ $proyecto->descripcion }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs" id="proyTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="info-tab" data-bs-toggle="tab"
                    data-bs-target="#info" type="button" role="tab">
                Información
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="audit-tab" data-bs-toggle="tab"
                    data-bs-target="#audit" type="button" role="tab">
                Auditoría
            </button>
        </li>
    </ul>

    <div class="tab-content border border-top-0 p-3" id="proyTabsContent">
        {{-- Información extra (vacio por ahora) --}}
        <div class="tab-pane fade show active" id="info" role="tabpanel">
            {{-- Puedes añadir KPIs, avances, etc. --}}
            <p class="text-muted">No hay información adicional.</p>
        </div>

        {{-- Historial de auditoría --}}
        <div class="tab-pane fade" id="audit" role="tabpanel">
            @if ($proyecto->audits->isEmpty())
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
                            @foreach ($proyecto->audits as $audit)
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