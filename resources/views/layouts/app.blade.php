<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Título --}}
    <title>Sistema Integrado de Planificación e Inversión Pública - SIPeIP - @yield('title')</title>

    {{-- Google Fonts (Roboto) --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" defer></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f2f2f2;
            color: #333;
        }

        header, nav, footer {
            padding: 15px;
        }

        header {
            background-color: #003366;
            color: white;
        }

        nav {
            background-color: #0055a5;
        }

        nav a {
            color: white;
            margin-right: 20px;
            text-decoration: none;
        }

        nav a:hover {
            text-decoration: underline;
        }

        main {
            padding: 20px;
        }

        footer {
            background-color: #ddd;
            text-align: center;
        }
    </style>

</head>

<body>
    <header>
           <h1>Sistema Integrado de Planificación e Inversión Pública</h1> 
    </header>

    {{-- NAVBAR --}}

    <nav class="d-flex me-auto gap-3 ">
        <a href="{{ url('/dashboard')}}">Inicio</a>
        <a href="{{ route('instituciones.index')}}"">Instituciones</a>
        <a href="{{ route('usuarios.index')}}">Usuarios</a>
    </nav>

    {{-- CONTENIDO --}}
    <main class="flex-grow-1 py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-top py-3 text-center text-muted small">
        <small>&copy; </small>
    </footer>
</body>
</html>