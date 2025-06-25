<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de palnificacion e inversion publica - SIPeIP - @yield('title')</title>

    {{-- Escribir estilos --}}

    <style>
    </style>


</head>
<body>
        {{-- Header --}}
        <header>
            <h1>Sistema integrado de palnificacion e inversion publica</h1>
        </header>
        {{--Barras de navegacion --}}
        <nav>
            <a href="{{url('/')}}">Inicio</a>
            <a href="{{route('entidades.index')}}">Entidades</a>
        </nav>
        {{-- Contenido principal --}}
        <main>
            @yield('content');
        </main>
        {{-- Pie de pagina --}}
        <footer>
            <small>&copy; </small>
        </footer>
</body>
</html>