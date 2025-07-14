@extends('layouts.app')

@section('title', 'Objetivos estratégicos')

@section('content')
<div class="container">

    {{-- Tarjeta envolvente --}}
    <div class="card shadow-sm">

        {{-- Encabezado --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Listado de objetivos estratégicos</h5>

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
                        <th class="text-center" style="width:150px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($objetivos as $obj)
                        <tr>
                            <td>{{ $obj->idObjetivoEstrategico }}</td>
                            <td>{{ $obj->codigo ?? '—' }}</td>
                            <td>{{ $obj->nombre }}</td>

                            <td>
                                @php
                                    $colors = ['INSTITUCIONAL' => 'primary',
                                               'ODS'           => 'success',
                                               'PND'           => 'info'];
                                @endphp
                                <span class="badge bg-{{ $colors[$obj->tipo] ?? 'secondary' }}">
                                    {{ $obj->tipo }}
                                </span>
                            </td>

                            <td>
                                @if ($obj->vigencia_desde || $obj->vigencia_hasta)
                                    {{ optional($obj->vigencia_desde)->format('Y') ?? '—' }}
                                    –
                                    {{ optional($obj->vigencia_hasta)->format('Y') ?? '—' }}
                                @else
                                    —
                                @endif
                            </td>

                            <td>
                                <span class="badge {{ $obj->estado ? 'bg-success' : 'bg-danger' }}">
                                    {{ $obj->estado ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>

                            <td class="text-center">
                                <a href="{{ route('objetivos.edit', $obj) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('objetivos.destroy', $obj) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar este objetivo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
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
            {{ $objetivos->links() }}
        </div>
    </div>

</div>
@endsection