@extends('layouts.app')

@section('title', 'Instituciones')

@section('content')
<div class="container py-4">

    {{-- Encabezado + botón --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Listado de instituciones</h2>

        <a href="{{ route('instituciones.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Nueva Institución
        </a>
    </div>

    {{-- Mensaje --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabla --}}
    <div class="card">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Siglas</th>
                        <th scope="col">RUC</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Estado</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($instituciones as $inst)
                        <tr>
                            <td>{{ $inst->idInstitucion }}</td>
                            <td>{{ $inst->codigo ?? '—' }}</td>
                            <td>{{ $inst->nombre }}</td>
                            <td>{{ $inst->siglas }}</td>
                            <td>{{ $inst->ruc }}</td>
                            <td>{{ $inst->email }}</td>
                            <td>{{ $inst->telefono }}</td>
                            <td>{{ $inst->direccion }}</td>
                            <td>{{ $inst->estado ? 'Activo' : 'Inactivo' }}</td>

                            <td class="text-center">
                                <div class="btn-group-vertical" role="group" aria-label="Acciones">
                                    {{-- Botón Editar --}}
                                    <a href="{{ route('instituciones.edit', $inst) }}"
                                       class="btn btn-sm btn-outline-secondary me-1">
                                       <i class="bi bi-pencil-square me-1"></i> Editar
                                    </a>
                                    {{-- Botón Eliminar --}}
                                    <form action="{{ route('instituciones.destroy', $inst) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Está seguro de eliminar esta institución?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger mt-2">
                                            <i class="bi bi-trash me-1"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection