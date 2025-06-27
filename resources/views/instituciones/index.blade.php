@extends('layouts.app')

@section('title', 'Instituciones')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold flex items-center space-x-2">
            <x-lucide-building-2 class="w-6 h-6 text-indigo-600"/>
            <span>Catálogo de Instituciones</span>
        </h1>

        @can('instituciones.create')
            <x-primary-button
                onclick="window.location='{{ route('instituciones.create') }}'">
                <x-lucide-plus class="w-4 h-4 mr-1"/> Nueva institución
            </x-primary-button>
        @endcan
    </div>

    {{-- Filtro / búsqueda --}}
    <form method="GET" action="{{ route('instituciones.index') }}"
          class="mb-4 grid md:grid-cols-3 gap-4">

        {{-- Texto libre --}}
        <div>
            <x-input-label for="search" value="Buscar"/>
            <x-text-input id="search" name="search" type="text"
                          placeholder="Nombre, siglas o RUC"
                          :value="request('search')" class="w-full"/>
        </div>

        {{-- Estado --}}
        <div>
            <x-input-label for="estado" value="Estado"/>
            <select id="estado" name="estado"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">— Todos —</option>
                <option value="1" @selected(request('estado')==='1')>Activas</option>
                <option value="0" @selected(request('estado')==='0')>Inactivas</option>
            </select>
        </div>

        <div class="flex items-end">
            <x-primary-button class="h-10 px-6">Filtrar</x-primary-button>
            <a href="{{ route('instituciones.index') }}"
               class="ml-2 text-sm text-gray-600 hover:underline">Limpiar</a>
        </div>
    </form>

    {{-- Tabla --}}
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">#</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Nombre</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Siglas</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">RUC</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Estado</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($instituciones as $i => $inst)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $instituciones->firstItem() + $i }}</td>
                        <td class="px-4 py-2 font-medium">{{ $inst->nombre }}</td>
                        <td class="px-4 py-2">{{ $inst->siglas ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $inst->ruc }}</td>
                        <td class="px-4 py-2">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs
                                    {{ $inst->estado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $inst->estado ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 space-x-1 whitespace-nowrap">
                            @can('instituciones.edit')
                                <x-secondary-button
                                    onclick="window.location='{{ route('instituciones.edit', $inst) }}'">
                                    <x-lucide-pencil-line class="w-4 h-4"/>
                                </x-secondary-button>
                            @endcan

                            @can('instituciones.show')
                                <x-secondary-button
                                    onclick="window.location='{{ route('instituciones.show', $inst) }}'">
                                    <x-lucide-eye class="w-4 h-4"/>
                                </x-secondary-button>
                            @endcan

                            @can('instituciones.destroy')
                                <x-danger-button
                                    onclick="document.getElementById('del-{{ $inst->id }}').submit()">
                                    <x-lucide-trash-2 class="w-4 h-4"/>
                                </x-danger-button>

                                {{-- Formulario oculto para DELETE --}}
                                <form id="del-{{ $inst->id }}" method="POST"
                                      action="{{ route('instituciones.destroy', $inst) }}"
                                      class="hidden">
                                    @csrf @method('DELETE')
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            No se encontraron instituciones.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-6">
        {{ $instituciones->withQueryString()->links() }}
    </div>
</div>
@endsection