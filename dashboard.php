<?php
session_start();
require 'includes/functions.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user'])) {
    redirect('login.php');
}

$user = $_SESSION['user'];

// Cerrar sesión si se hace clic en el botón de "Cerrar Sesión"
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    redirect('login.php');
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <!-- Barra superior con el nombre de usuario y botón de cerrar sesión -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Bienvenido, <?php echo $user['username']; ?></h1>
            <a href="dashboard.php?logout=true" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Cerrar Sesión
            </a>
        </div>

        <!-- Funcionalidades según el rol -->
        <div class="bg-white p-6 rounded shadow-md">
            <?php if ($user['role'] == 'super_admin'): ?>
                <h2 class="text-xl font-bold mb-4">Funciones de Super Administrador</h2>
                <ul>
                    <li><a href="register.php" class="text-blue-500 hover:underline">Crear Usuario</a></li>
                </ul>
            <?php elseif ($user['role'] == 'coordinator'): ?>
                <h2 class="text-xl font-bold mb-4">Funciones de Coordinador</h2>
                <ul>
                    <li><a href="create_instructor.php" class="text-blue-500 hover:underline">Agregar Instructor</a></li>
                    <li><a href="create_program.php" class="text-blue-500 hover:underline">Crear Programa</a></li>
                    <li><a href="create_ambiente.php" class="text-blue-500 hover:underline">Crear Ambiente</a></li>
                    <li><a href="create_ficha.php" class="text-blue-500 hover:underline">Crear Ficha</a></li>
                    <li><a href="create_aprendiz.php" class="text-blue-500 hover:underline">Crear Aprendiz</a></li>
                    <li><a href="reports.php" class="text-blue-500 hover:underline">Ver Reporte de Estudiantes</a></li>
                </ul>
            <?php elseif ($user['role'] == 'instructor'): ?>
                <h2 class="text-xl font-bold mb-4">Funciones de Instructor</h2>
                <ul>
                    <li><a href="take_attendance.php" class="text-blue-500 hover:underline">Tomar Lista</a></li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
