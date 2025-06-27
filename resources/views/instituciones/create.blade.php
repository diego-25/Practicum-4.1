@extends('layouts.app')

@section('title','Nueva Institución')

@section('content')
    
    @if ($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                <li> - {{$error}} </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario para la creación de entidades --}}
    <form action="{{ route('instituciones.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Nombre --}}
        <div>
            <x-input-label for="nombre" value="Nombre *"/>
            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full"
                          :value="old('nombre')" required maxlength="255"/>
        </div>

        {{-- Siglas --}}
        <div>
            <x-input-label for="siglas" value="Siglas"/>
            <x-text-input id="siglas" name="siglas" type="text" class="mt-1 block w-1/2"
                          :value="old('siglas')" maxlength="50" placeholder="SNP"/>
        </div>

        {{-- RUC --}}
        <div>
            <x-input-label for="ruc" value="RUC *"/>
            <x-text-input id="ruc" name="ruc" type="text" class="mt-1 block w-1/2"
                          :value="old('ruc')" required maxlength="13" placeholder="9999999999999"/>
        </div>

        {{-- Correo --}}
        <div>
            <x-input-label for="email" value="Correo electrónico"/>
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                          :value="old('email')" placeholder="contacto@entidad.gob.ec"/>
        </div>

        {{-- Teléfono --}}
        <div>
            <x-input-label for="telefono" value="Teléfono"/>
            <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-1/2"
                          :value="old('telefono')" maxlength="20"/>
        </div>

        {{-- Dirección --}}
        <div>
            <x-input-label for="direccion" value="Dirección"/>
            <textarea id="direccion" name="direccion" rows="2"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('direccion') }}</textarea>
        </div>

        {{-- Estado --}}
        <div class="flex items-center">
            <input id="estado" name="estado" type="checkbox" value="1"
                   class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                   {{ old('estado', true) ? 'checked' : '' }}>
            <label for="estado" class="ml-2 text-sm text-gray-700">Activo</label>
        </div>

        {{-- Botones --}}
        <div class="pt-4 flex items-center space-x-4">
            <x-primary-button>Guardar</x-primary-button>

            <a href="{{ route('instituciones.index') }}"
               class="text-sm text-gray-600 hover:text-indigo-600 underline">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection