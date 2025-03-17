<?php
session_start();
require 'includes/functions.php';
checkPermission('coordinator');

require 'includes/Database.php';
require 'includes/Coordinator.php';

$coordinator = new Coordinator();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    if ($coordinator->createProgram($name)) {
        redirect('dashboard.php');
    } else {
        $error = "Error al crear el programa";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Programa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-green-50 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
        <h1 class="text-2xl font-bold text-green-700 mb-6 text-center">Crear Programa</h1>
        
        <?php if (isset($success)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $success; ?></span>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $error; ?></span>
            </div>
        <?php endif; ?>
        
        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-black text-lg font-bold mb-2" for="name">Nombre del Programa</label>
                <input class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500" id="name" name="name" type="text" placeholder="Nombre del Programa" required>
            </div>
            <div class="flex justify-between">
                <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" type="submit">Crear Programa</button>
                <a href="dashboard.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">Regresar</a>
            </div>
        </form>
    </div>
</body>
</html>
