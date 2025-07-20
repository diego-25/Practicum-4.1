@extends('layouts.app')

@section('title', 'Planes institucionales')

@section('content')
<div class="container">

    <div class="card shadow-sm">

        {{-- ENCABEZADO + BOTÓN “NUEVO” --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Listado de planes</h5>
            <a href="{{ route('planes.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Nuevo
            </a>
        </div>

        {{-- FLASH --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- TABLA --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Programa</th>
                        <th>Objetivo</th>
                        <th>Vigencia</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($planes as $plan)
                        <tr>
                            <td>{{ $plan->idPlan }}</td>
                            <td>{{ $plan->codigo ?? '—' }}</td>
                            <td>{{ $plan->nombre }}</td>
                            {{-- Jerarquía --}}
                            <td>{{ $plan->programa->nombre ?? '—' }}</td>
                            <td>{{ $plan->programa->objetivo->nombre ?? '—' }}</td>

                            {{-- Vigencia --}}
                            <td>
                                @if ($plan->vigencia_desde || $plan->vigencia_hasta)
                                    {{ optional($plan->vigencia_desde)->format('Y') ?? '—' }}
                                    –
                                    {{ optional($plan->vigencia_hasta)->format('Y') ?? '—' }}
                                @else
                                    —
                                @endif
                            </td>

                            {{-- Estado --}}
                            <td>{{ $plan->estado ? 'Activo' : 'Inactivo' }}</td>

                            {{-- ACCIONES --}}
                            <td class="text-center">
                                <div class="btn-group-vertical" role="group" aria-label="Acciones">
                                    {{-- Botón ver --}}
                                    <a href="{{ route('planes.show', $plan) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil-square me-1"></i> Ver
                                    </a>
                                    {{-- Botón Editar --}}
                                    <a href="{{ route('planes.edit', $plan) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil-square me-1"></i> Editar
                                    </a>
                                    {{-- Botón Eliminar --}}
                                    <form action="{{ route('planes.destroy', $plan) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Está seguro de eliminar este plan?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger w-100 rounded-0 border-top-0">
                                            <i class="bi bi-trash me-1"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No hay planes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINACIÓN --}}
        <div class="card-footer">
            {{ $planes->links('pagination::bootstrap-5') }}
        </div>
    </div>

</div>
@endsection