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
        font-size: 16px;
    }
    body {
        transition: background 0.3s, color 0.3s;
        font-size: 1rem;
    }
    .navbar, .card, .alert, .container {
        transition: background 0.3s, color 0.3s;
    }
    @media (max-width: 768px) {
        html {
            font-size: 14px;
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

    [data-bs-theme="dark"] .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    /* --- MODO CLARO --- */
    [data-bs-theme="light"] .titulo-mision,
    [data-bs-theme="light"] .texto-mision {
        color: #333 !important; /* texto oscuro en modo claro */
    }

    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap');

    .container-mision {
        max-width: 60%;
        margin: 0 auto;
        text-align: center;
        padding: 50px 20px;
        height: 80vh; /* Extiende el contenedor verticalmente */
        display: flex;
        flex-direction: column;
        justify-content: center; /* Centrado vertical */
        align-items: center;
    }

    .titulo-mision {
        font-family: 'Playfair Display', serif;
        font-style: italic;
        font-size: 2.5em;
        font-weight: 700;
        color: white;
        margin-bottom: 20px;
    }

    .texto-mision {
        font-family: 'Playfair Display', serif;
        font-size: 1.5em;
        font-style: italic; /* Letra itálica */
        color: white;
        line-height: 1.8;
        text-align: center; /* Texto centrado */
        max-width: 700px;
        margin-top: 20px;
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
                    <a href="{{ route('clientes.login.form') }}" class="nav-link">
                        <i class="bi bi-box-arrow-in-right"></i> Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/mision') }}" class="nav-link">
                        <i class="bi bi-house"></i> Misión
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/vision') }}" class="nav-link">
                        <i class="bi bi-house"></i> Visión
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
