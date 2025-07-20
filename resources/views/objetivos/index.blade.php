@extends('layouts.app')

@section('title', 'Objetivos estratégicos')

@section('content')
<div class="container">

    {{-- Tarjeta envolvente --}}
    <div class="card shadow-sm">

        {{-- Encabezado --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Listado de objetivos</h5>

            <a href="{{ route('objetivos.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Nuevo
            </a>
        </div>

        {{-- Flash de éxito --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Tabla --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Vigencia</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($objetivos as $obj)
                        <tr>
                            <td>{{ $obj->idObjetivo }}</td>
                            <td>{{ $obj->codigo ?? '—' }}</td>
                            <td>{{ $obj->nombre }}</td>
                            <td>{{ $obj->tipo }}</td>
                            <td>
                                @if ($obj->vigencia_desde || $obj->vigencia_hasta)
                                    {{ optional($obj->vigencia_desde)->format('Y') ?? '—' }}
                                    –
                                    {{ optional($obj->vigencia_hasta)->format('Y') ?? '—' }}
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $obj->estado ? 'Activo' : 'Inactivo' }}</td>

                            <td class="text-center">
                                <div class="btn-group-vertical" role="group" aria-label="Acciones">
                                    {{-- Botón Ver --}}
                                    <a href="{{ route('objetivos.show', $obj) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil-square me-1"></i> Ver
                                    </a>
                                    {{-- Botón Editar --}}
                                    <a href="{{ route('objetivos.edit', $obj) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil-square me-1"></i> Editar
                                    </a>
                                    {{-- Botón Eliminar --}}
                                    <form action="{{ route('objetivos.destroy', $obj) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Está seguro de eliminar este objetivo?');">
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
                            <td colspan="7" class="text-center">No hay objetivos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Paginación --}}
        <div class="card-footer">
            {{ $objetivos->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection