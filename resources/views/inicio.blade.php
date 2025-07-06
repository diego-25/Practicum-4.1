@extends('layouts.app')
@section('title','Home Page')
@section('content')
    <h2 class="text-2xl font-bold mb-4">
        Bienvenido al modulo de Planificación - SIPeIP
    </h2>
    <p class="mb-4"> 
        Selecione la opción del menú para comenzar: 
    </p>
    <ul class="list-disc ml-6 text-blue-700">
        <li><a href="{{route('instituciones.index')}}">Instituciones</a></li>
    </ul>
    <ul class="list-disc ml-6 text-blue-700">
        <li><a href="{{route('usuarios.index')}}">Usuarios</a></li>
    </ul>
@endsection