@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<div class="container">

    {{-- Tarjeta envolvente --}}
    <div class="card shadow-sm">

        {{-- Encabezado de la tarjeta --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Listado de usuarios</h5>

            {{-- Botón “Nuevo” --}}
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-person-plus"></i> Nuevo
            </a>
        </div>

        {{-- Mensaje flash --}}
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
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Actor</th>
                        <th>Instituciones</th>
                        <th>Roles</th>
                        <th>Estado</th>
                        <th class="text-center" style="width:150px;">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->idUsuario }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->actor }}<td>
                                @forelse ($usuario->instituciones as $inst)
                                    {{ $inst->nombre }}
                                @empty
                                    —
                                @endforelse
                            </td>
                            <td>
                                @foreach ($usuario->getRoleNames() as $role)
                                    {{ $role }}
                                @endforeach
                            </td>
                            <td>{{ $usuario->estado ? 'Activo' : 'Inactivo' }}</td>
                            <td class="text-end">

                                <div class="btn-group-vertical" role="group" aria-label="Acciones">
                                    {{-- Botón Ver --}}
                                    <a href="{{ route('usuarios.show', $usuario) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil-square me-1"></i> Ver
                                    </a>
                                    {{-- Botón Editar --}}
                                    <a href="{{ route('usuarios.edit', $usuario) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil-square me-1"></i> Editar
                                    </a>
                                    {{-- Botón Eliminar --}}
                                    <form action="{{ route('usuarios.destroy', ['usuario' => $usuario->idUsuario]) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Está seguro de eliminar esta usuario?');">
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
                            <td colspan="7" class="text-center">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $usuarios->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection