<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portal de Incendios')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Leaflet (Mapas) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Chart.js (Gráficos) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
        }
        .navbar {
            background-color: #00684A; /* Verde Beni */
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: bold;
        }
    </style>
    @stack('css')
</head>
<body>
    <nav class="navbar navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('public.home') }}">🇧🇴 Portal de Monitoreo de Incendios - Beni</a>
        </div>
    </nav>

    <main class="container mt-4">
        @yield('content')
    </main>

    <footer class="text-center py-4 text-muted">
        <p>&copy; {{ date('Y') }} - Gobernación del Beni. Todos los derechos reservados.</p>
    </footer>

    @stack('javascript')
</body>
</html>
