<?php
session_start();
require 'includes/functions.php';
checkPermission('coordinator');

require 'includes/Database.php';
require 'includes/Coordinator.php';

$coordinator = new Coordinator();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($coordinator->createInstructor($username,$email, $password)) {
        redirect('dashboard.php');
    } else {
        $error = "Error al crear el instructor";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Instructor</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-green-50 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
        <h1 class="text-2xl font-bold text-green-700 text-center mb-4">Crear Instructor</h1>

        <!-- Mensajes de éxito y error -->
        <?php if (isset($success)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <span class="block sm:inline"><?php echo $success; ?></span>
            </div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <span class="block sm:inline"><?php echo $error; ?></span>
            </div>
        <?php endif; ?>

        <!-- Formulario -->
        <form method="POST">
            <div class="mb-4">
                <label class="block text-black text-lg font-bold mb-2" for="username">Usuario</label>
                <input class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500" 
                       id="username" name="username" type="text" placeholder="Usuario">
            </div>
            <div class="mb-4">
                <label class="block text-black text-lg font-bold mb-2" for="email">Correo Electrónico</label>
                <input class="shadow-lg border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" 
                       id="email" name="email" type="email" placeholder="Correo Electrónico" required>
            </div>

            <div class="mb-4">
                <label class="block text-black text-lg font-bold mb-2" for="password">Contraseña</label>
                <input class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500" 
                       id="password" name="password" type="password" placeholder="Contraseña">
            </div>

            <div class="flex justify-between">
                <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" type="submit">Crear Instructor</button>
                <a href="dashboard.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">Regresar</a>
            </div>
        </form>
    </div>
</body>
</html>
