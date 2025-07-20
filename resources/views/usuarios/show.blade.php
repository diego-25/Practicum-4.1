@extends('layouts.app')

@section('title', 'Detalle de usuario')

@section('content')
<div class="container py-4">

    {{-- BREADCRUMB --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('usuarios.index') }}">Usuarios</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ $usuario->name }}
            </li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">{{ $usuario->name }}</h1>

        <div>
            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-sm btn-primary">
                Editar
            </a>
            <a href="{{ route('usuarios.index') }}" class="btn btn-sm btn-outline-secondary">
                Volver
            </a>
        </div>
    </div>

    {{-- Atributos --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-4">
                    <h6 class="text-muted mb-1">Nombre</h6>
                    <span class="fw-semibold">{{ $usuario->name }}</span>
                </div>
                <div class="col-md-4">
                    <h6 class="text-muted mb-1">Correo</h6>
                    <span class="fw-semibold">{{ $usuario->email }}</span>
                </div>
                <div class="col-md-4">
                    <h6 class="text-muted mb-1">Roles</h6>
                    <span class="fw-semibold">{{ $roles ?: '—' }}</span>
                </div>
                <div class="col-md-4">
                    <h6 class="text-muted mb-1">Estado</h6>
                    <span class="fw-semibold">
                        {{ $usuario->estado ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
                <div class="col-md-4">
                    <h6 class="text-muted mb-1">Creado</h6>
                    <span class="fw-semibold">{{ $usuario->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="col-md-4">
                    <h6 class="text-muted mb-1">Última actualización</h6>
                    <span class="fw-semibold">{{ $usuario->updated_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs" id="userTabs" role="tablist">
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
        {{-- Información adicional (vacío por ahora) --}}
        <div class="tab-pane fade show active" id="info" role="tabpanel">
            <p class="text-muted">Sin información adicional.</p>
        </div>

        {{-- Auditoria --}}
        <div class="tab-pane fade" id="audit" role="tabpanel">
            @if ($usuario->audits->isEmpty())
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
                        @foreach ($usuario->audits as $audit)
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