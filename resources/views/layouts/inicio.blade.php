<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sección Clientes')</title>

    {{-- Bootstrap + Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    {{-- Estilos adicionales para mejor contraste en modo oscuro --}}

    <style>
html, body {
    height: 100%;
    margin: 0;
    font-size: 16px;
}

body {
    transition: background 0.3s, color 0.3s;
    font-size: 1rem;
    background-image: url('/storage/fondos/alineacion.png'); /* Cambia esta ruta si es necesario */
    background-size: cover;
    background-position: center;
    position: relative;
    z-index: 1;
}

/* Overlay oscuro/claro */
body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.6); /* fondo claro por defecto */
    z-index: -1;
    transition: background 0.3s;
}

/* Modo oscuro */
[data-bs-theme="dark"] body::before {
    background: rgba(0,0,0,0.6);
}

.navbar, .card, .alert, .container {
    transition: background 0.3s, color 0.3s;
}

.formulario-registro {
    max-width: 480px;
    background-color: var(--bs-light);
    padding: 2rem;
    margin: 0 auto;
    border-radius: 0.5rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.formulario-registro h2 {
    text-align: center;
    margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
    html {
        font-size: 14px;
    }
    .formulario-registro {
        padding: 1.5rem;
    }
}

[data-bs-theme="dark"] .container {
    background-color: #2c2c2c !important;
    color: #f8f9fa !important;
}

[data-bs-theme="dark"] .form-label {
    color: #f8f9fa !important;
}

[data-bs-theme="dark"] input.form-control {
    background-color: #343a40 !important;
    color: #f8f9fa !important;
    border-color: #6c757d !important;
}

[data-bs-theme="dark"] .btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

[data-bs-theme="dark"] .formulario-registro {
    background-color: #2c2c2c !important;
    color: #f8f9fa !important;
}
</style>


</head>
<body class="bg-light text-dark">

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="bi bi-calendar2-week me-2"></i> FullAuto Solutions
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navLinks">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navLinks">
                <ul class="navbar-nav ms-auto">
                    <!-- Mostrar el nombre del usuario y su perfil -->
                     
                   
                    <li class="nav-item d-flex align-items-center ms-3">
                        <div class="form-check form-switch text-light">
                            <input class="form-check-input" type="checkbox" id="modoOscuroSwitch">
                            <label class="form-check-label" for="modoOscuroSwitch">Modo Oscuro</label>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/mision') }}"class="nav-link">
                            <i class="bi bi-house"></i> Quienes Somos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('clientes.login.form') }}" class="nav-link">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('agregar') }}" class="nav-link">
                            <i class="bi bi-plus-circle"></i> Registrate
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Activar modo oscuro si el sistema lo tiene activo --}}
    <script>
    const modoOscuroSwitch = document.getElementById('modoOscuroSwitch');

    // Función para activar o desactivar modo oscuro
    function toggleDarkMode(forceDark = null) {
        if (forceDark !== null) {
            if (forceDark) {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                document.body.classList.replace('bg-light', 'bg-dark');
                document.body.classList.replace('text-dark', 'text-light');
            } else {
                document.documentElement.setAttribute('data-bs-theme', 'light');
                document.body.classList.replace('bg-dark', 'bg-light');
                document.body.classList.replace('text-light', 'text-dark');
            }
        } else {
            document.body.classList.toggle('bg-dark');
            document.body.classList.toggle('bg-light');
            document.body.classList.toggle('text-dark');
            document.body.classList.toggle('text-light');

            const isDark = document.body.classList.contains('bg-dark');
            document.documentElement.setAttribute('data-bs-theme', isDark ? 'dark' : 'light');
        }
    }

    // Leer preferencia previa (si existe)
    if (localStorage.getItem('modoOscuro') === 'true') {
        modoOscuroSwitch.checked = true;
        toggleDarkMode(true);
    }

    modoOscuroSwitch.addEventListener('change', function() {
        const activar = modoOscuroSwitch.checked;
        toggleDarkMode(activar);
        localStorage.setItem('modoOscuro', activar);
    });

    // Detectar configuración del sistema al cargar si no hay preferencia
    if (localStorage.getItem('modoOscuro') === null) {
        const isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (isDarkMode) {
            modoOscuroSwitch.checked = true;
            toggleDarkMode(true);
            localStorage.setItem('modoOscuro', true);
        }
    }
</script>

</body>
</html>