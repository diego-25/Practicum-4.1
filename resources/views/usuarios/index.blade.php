@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<div class="container">

    {{-- Flash --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Nuevo --}}
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> Nuevo usuario
        </a>
    </div>

    {{-- Tabla --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th><th>Nombre</th><th>Email</th><th>Actor</th>
                    <th>Roles</th><th>Estado</th>
                    <th class="text-center" style="width: 150px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @if ($usuarios->isEmpty())
                <tr><td colspan="7" class="text-center">No hay usuarios registrados.</td></tr>
            @else
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td><span class="badge bg-info">{{ $usuario->actor }}</span></td>
                        <td>
                            @foreach ($usuario->getRoleNames() as $role)
                                <span class="badge bg-secondary">{{ $role }}</span>
                            @endforeach
                        </td>
                        <td>
                            <span class="badge {{ $usuario->estado ? 'bg-success' : 'bg-danger' }}">
                                {{ $usuario->estado ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('usuarios.edit', $usuario) }}"
                               class="btn btn-sm btn-warning" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('usuarios.destroy', $usuario) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este usuario?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    {{ $usuarios->links() }}
</div>
@endsection