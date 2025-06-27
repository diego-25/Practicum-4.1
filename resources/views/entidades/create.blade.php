@extends('layouts.app')

@section('title','Nueva Entidad')

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

    <form action="{{ route ('entidades.store')}}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block">Código</label>
            <input type="number" name="codigo" require value="{{ old('codigo') }}">
        </div>

         <div>
            <label class="block">Subsector</label>
            <input type="text" name="subSector" require value="{{ old('subSector') }}">
        </div>

         <div>
            <label class="block">Nivel de Gobierno</label>
            <input type="text" name="nivelGobierno" require value="{{ old('nivelGobierno') }}">
        </div>

         <div>
            <label class="block">Estado</label>
            <input type="text" name="estado" require value="{{ old('estado') }}">
        </div>

         <div>
            <label class="block">Fecha de Creación</label>
            <input type="date" name="fechaCreacion" require value="{{ old('fechaCreacion') }}">
        </div>

         <div>
            <label class="block">Fecha de Actualización</label>
            <input type="date" name="fechaActualizacion" require value="{{ old('fechaActualizacion') }}">
        </div>

        <button type="submit">Guardar</button>

        <a href="{{route('entidades.index')}}">Volver</a>
        
    </form>


@endsection