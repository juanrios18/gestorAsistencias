<?php
session_start();
require 'includes/functions.php';
checkPermission('coordinator'); // Solo coordinadores pueden acceder.

require 'includes/Database.php';
require 'includes/Coordinator.php';

$coordinator = new Coordinator();
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
        <h1 class="text-2xl font-bold mb-4">Bienvenido, <?php echo $_SESSION['user']['username']; ?></h1>
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-xl font-bold mb-4">Funciones de Coordinador</h2>
            <ul>
                <li><a href="create_program.php" class="text-blue-500 hover:underline">Crear Programa</a></li>
                <li><a href="create_ambiente.php" class="text-blue-500 hover:underline">Crear Ambiente</a></li>
                <li><a href="create_ficha.php" class="text-blue-500 hover:underline">Crear Ficha</a></li>
                <li><a href="create_instructor.php" class="text-blue-500 hover:underline">Crear Instructor</a></li>
            </ul>
        </div>
    </div>
</body>
</html>