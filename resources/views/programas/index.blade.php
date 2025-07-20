@extends('layouts.app')

@section('title', 'Programas institucionales')

@section('content')
<div class="container">

    <div class="card shadow-sm">
        {{-- ENCABEZADO + BOTÓN NUEVO --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Listado de programas</h5>
            <a href="{{ route('programas.create') }}" class="btn btn-primary btn-sm">
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
                        <th>Objetivo estratégico</th>
                        <th>Vigencia</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($programas as $prog)
                        <tr>
                            <td>{{ $prog->idPrograma }}</td>
                            <td>{{ $prog->codigo ?? '—' }}</td>
                            <td>{{ $prog->nombre }}</td>

                            {{-- Objetivo Estratégico --}}
                            <td> {{ $prog->objetivo->nombre ?? '—' }}</td>

                            {{-- Vigencia --}}
                            <td>
                                @if ($prog->vigencia_desde || $prog->vigencia_hasta)
                                    {{ optional($prog->vigencia_desde)->format('Y') ?? '—' }}
                                    –
                                    {{ optional($prog->vigencia_hasta)->format('Y') ?? '—' }}
                                @else
                                    —
                                @endif
                            </td>

                            {{-- Estado --}}
                            <td>{{ $prog->estado ? 'Activo' : 'Inactivo' }}</td>

                            <td class="text-center">
                                <div class="btn-group-vertical" role="group" aria-label="Acciones">
                                    {{-- Botón Ver --}}
                                    <a href="{{ route('programas.show', $prog) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil-square me-1"></i> Ver
                                    </a>
                                    {{-- Botón Editar --}}
                                    <a href="{{ route('programas.edit', $prog) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil-square me-1"></i> Editar
                                    </a>
                                    {{-- Botón Eliminar --}}
                                    <form action="{{ route('programas.destroy', $prog) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Está seguro de eliminar este programa?');">
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
                        <tr><td colspan="7" class="text-center">No hay programas registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINACIÓN --}}
        <div class="card-footer">
            {{ $programas->links('pagination::bootstrap-5') }}
        </div>
    </div>

</div>
@endsection