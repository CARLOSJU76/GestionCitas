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
    html {
        font-size: 14px;
    }
    body {
        transition: background 0.3s, color 0.3s;
        font-size: 1rem;
    background-image: url('/storage/fondos/cliente.png'); /* Cambia esta ruta si es necesario */
    background-size: cover;
    background-position: center;
    position: relative;
    z-index: 1;
    }
    .navbar, .card, .alert, .container {
        transition: background 0.3s, color 0.3s;
    }

    /* Formulario de registro */
    .formulario-registro {
        max-width: 480px;
        background-color: var(--bs-light);
        padding: 2rem;
        margin: 0 auto;
        border-radius: 0.5rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Ajustes de título */
    .formulario-registro h2 {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    /* Para pantallas pequeñas */
    @media (max-width: 768px) {
        html {
            font-size: 14px;
        }
        .formulario-registro {
            padding: 1.5rem;
        }
    }

    /* --- MODO OSCURO --- */
    [data-bs-theme="dark"] .container {
        background-color: #2c2c2c !important; /* fondo oscuro para formularios */
        color: #f8f9fa !important; /* texto claro */
    }

    [data-bs-theme="dark"] .form-label {
        color: #f8f9fa !important; /* etiquetas del formulario en claro */
    }

    [data-bs-theme="dark"] input.form-control {
        background-color: #343a40 !important; /* fondo oscuro en inputs */
        color: #f8f9fa !important; /* texto claro en inputs */
        border-color: #6c757d !important; /* bordes suaves */
    }

    [data-bs-theme="dark"] .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    [data-bs-theme="dark"] .formulario-registro {
    background-color: #2c2c2c !important; /* fondo oscuro para el formulario */
    color: #f8f9fa !important; /* texto claro */
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
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item ms-4">
                    <div class="form-check form-switch text-light">
                        <input class="form-check-input" type="checkbox" id="modoOscuroSwitch">
                        <label class="form-check-label" for="modoOscuroSwitch">Modo Oscuro</label>
                    </div>
                </li>
                <li class="nav-item">
                        <a href="{{ url('bienvenida1') }}" class="nav-link">
                            <i class="bi bi-house"></i> Inicio
                        </a>
                    </li>
                <li class="nav-item ms-4">
                    <a href="{{ url('createMyCar') }}" class="nav-link px-2">
                        <i class="bi bi-calendar3"></i> Mis Vehículos
                    </a>
                </li>
                <li class="nav-item ms-4">
                    <a href="{{ url('verMisCitas') }}" class="nav-link px-2">
                        <i class="bi bi-calendar3"></i> Mis Citas
                    </a>
                </li>
                <li class="nav-item ms-4">
                    <a href="{{ url('agendar') }}" class="nav-link px-2">
                        <i class="bi bi-pencil-square"></i> Agendar Citas
                    </a>
                </li>
                <li class="nav-item ms-4">
                    <a href="{{ url('misDatos') }}" class="nav-link px-2">
                        <i class="bi bi-person-badge"></i> Mis Datos
                    </a>
                </li>
                <li class="nav-item ms-4">
                    <a href="{{ url('myHistorial') }}" class="nav-link px-2">
                        <i class="bi bi-clock-history"></i> Mi Historial
                    </a>
                </li>
                <li class="nav-item">
                        <a href="{{ url('/editPassword') }}"class="nav-link">
                            <i class="bi bi-house"></i> Cambiar Contraseña
                        </a>
                    </li>
                <li class="nav-item ms-4">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-white px-2">
                            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

      <!-- Mostrar el nombre del usuario y su perfil -->
      <p class="nav-item">
                       <p>Bienvenido, {{ session('usuario_nombre') }}</p>
    </p>

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