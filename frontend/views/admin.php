<?php
session_start();

// Control de acceso extricto a nivel de servidor .

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador'){

//si no esta logueado o no pertenece aqui, es expulsado al login inmediatamente
header('location: index.html');
exit();

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>
</head>
<body>
    <!-- htmlspecialchars previene ataques XSS al renderisar datos del usuario. -->
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></h1>
    <h3>Rol actual: <?php echo ($_SESSION['rol']); ?>(acceso Total)</h3>
    <p>Area exclusiva de administracion</p>

    <a href="../../backend/api/logout.php">Cerrar Sesion de manera segura... </a>
</body>
</html>