<!DOCTYPE html>
<html lang="es" data-bs-theme="auto">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestión de Horarios')</title>

    {{-- Bootstrap + Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- Estilos adicionales para mejor contraste en modo oscuro --}}
    <style>
        body {
            transition: background 0.3s, color 0.3s;
        }
        .navbar, .card, .alert {
            transition: background 0.3s, color 0.3s;
        }
    </style>
</head>
<body class="bg-light text-dark">
<!-- ===================================================================================================================================================== -->
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="bi bi-calendar2-week me-2"></i> Gestión de Citas
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navLinks">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navLinks">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ url('bienvenida') }}" class="nav-link">
                            <i class="bi bi-house"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('horarios.index') }}" class="nav-link">
                            <i class="bi bi-clock-history"></i> Horarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('horarios.create') }}" class="nav-link">
                            <i class="bi bi-plus-circle"></i> Agregar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<!-- ================================================================================================================================ -->
    {{-- Contenido --}}
    <main class="container">
        {{-- Alertas --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        {{-- Contenido dinámico --}}
        @yield('content')
    </main>
<!-- =======================FOOTER========================================================================================================== -->
    <footer class="text-center py-4 mt-5 text-muted">
        <small>Aplicación de Gestión de Horarios © {{ date('Y') }}</small>
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Activar modo oscuro si el sistema lo tiene activo --}}
    <script>
        const isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (isDarkMode) {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
            document.body.classList.replace('bg-light', 'bg-dark');
            document.body.classList.replace('text-dark', 'text-light');
        }
    </script>
</body>
</html>
