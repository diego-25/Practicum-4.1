@extends('layouts.app')

@section('title','Entidades')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Listado de entidades:</h2>

    {{-- Validacion mensaje --}}
        @if (session('success'))
            <div>
                {{session('success')}}
            </div>
        @endif

    {{--Boton para llamar al formulario crear entidades --}}

        <a href="{{route('entidades.create')}}">+ Nueva Entidad</a>

    {{-- Tabla para listar todas las entidades --}}

    <table style="background-color: #f8f8fa;">

        <thead>
            <tr>
                <th style="border: 1px solid #ccc; padding: 8px">ID</th>
                <th style="border: 1px solid #ccc; padding: 8px">Código</th>
                <th style="border: 1px solid #ccc; padding: 8px">Subsector</th>
                <th style="border: 1px solid #ccc; padding: 8px">Nivel de Gobierno</th>
                <th style="border: 1px solid #ccc; padding: 8px">Estado</th>
                <th style="border: 1px solid #ccc; padding: 8px">Fecha de Creación</th>
                <th style="border: 1px solid #ccc; padding: 8px">Fecha de Actualización</th>
                <th style="border: 1px solid #ccc; padding: 8px">Acciones</th>
            </tr>
        </thead>
        <tbody>

            @foreach($entidades as $entidad)
                <tr>
                    <td style="border: 1px solid #ccc; padding: 8px">{{$entidad->idEntidad}}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{$entidad->codigo}}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{$entidad->subSector}}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{$entidad->nivelGobierno}}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{$entidad->estado}}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{$entidad->fechaCreacion}}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">{{$entidad->fechaActualizacion}}</td>
                    <td style="border: 1px solid #ccc; padding: 8px">
                        <a href="{{route('entidades.edit', $entidad->idEntidad)}}">Editar</a>
                        <form action="{{ route('entidades.destroy', $entidad->idEntidad) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </td>
                        

                </tr>
            @endforeach

         

        </tbody>



    </table>



@endsection