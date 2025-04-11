<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <title>Template app</title>
</head>
<body>
<a href="bienvenida">Inicio</a> |
<a href="clientes">Clientes</a> |
<a href="servicios">Servicios</a> |
<a href="Citas">Gestión de Citas</a> |
<a href="horarios">Horarios</a> |
<br>
@yield('content') 
<!-- //Es una instrucción de Blade. -->
    <br>Hola ... template operando!!

</body>
</html>