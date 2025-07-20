@extends('layouts.app')

@section('title', 'Proyectos')

@section('content')
<div class="container">

    <div class="card shadow-sm">

        {{-- ENCABEZADO + “NUEVO” --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Listado de proyectos</h5>
            <a href="{{ route('proyectos.create') }}" class="btn btn-primary btn-sm">
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
                        <th>Plan</th>
                        <th>Programa</th>
                        <th>Objetivo</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($proyectos as $proy)
                        <tr>
                            <td>{{ $proy->idProyecto }}</td>
                            <td>{{ $proy->codigo ?? '—' }}</td>
                            <td>{{ $proy->nombre }}</td>

                            {{-- Jerarquía --}}
                            <td>{{ $proy->plan->nombre ?? '—' }}</td>
                            <td>{{ $proy->plan->programa->nombre ?? '—' }}</td>
                            <td>{{ $proy->plan->programa->objetivo->nombre ?? '—' }}</td>

                            {{-- Monto --}}
                            <td>
                                @if ($proy->monto_presupuesto)
                                    $ {{ number_format($proy->monto_presupuesto, 2, ',', '.') }}
                                @else
                                    —
                                @endif
                            </td>

                            {{-- Estado --}}
                            <td>{{ $proy->estado ? 'Activo' : 'Inactivo' }}</td>

                            {{-- ACCIONES --}}
                            <td class="text-center">
                                <div class="btn-group-vertical" role="group" aria-label="Acciones">
                                    {{-- Botón Ver --}}
                                    <a href="{{ route('proyectos.show', $proy) }}"
                                       class="btn btn-sm btn-outline-secondary me-1">
                                        <i class="bi bi-pencil-square me-1"></i> Ver
                                    </a>
                                    {{-- Botón Editar --}}
                                    <a href="{{ route('proyectos.edit', $proy) }}"
                                       class="btn btn-sm btn-outline-secondary me-1">
                                        <i class="bi bi-pencil-square me-1"></i> Editar
                                    </a>
                                    {{-- Botón Eliminar --}}
                                    <form action="{{ route('proyectos.destroy', $proy) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Está seguro de eliminar este proyecto?');">
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
                            <td colspan="9" class="text-center">No hay proyectos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINACIÓN --}}
        <div class="mt-3">
            {{ $proyectos->links('pagination::bootstrap-5') }}
        </div>
    </div>

</div>
@endsection