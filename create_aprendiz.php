<?php
session_start();
require 'includes/functions.php';
checkPermission('coordinator'); // Solo los coordinadores pueden crear aprendices.

require 'includes/Database.php';
require 'includes/Coordinator.php';

$coordinator = new Coordinator();

// Obtener las fichas disponibles
$fichas = $coordinator->getFichas();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $ficha_id = $_POST['ficha_id'];

    if ($coordinator->createAprendiz($name, $ficha_id)) {
        redirect('dashboard.php');
    } else {
        $error = "Error al crear el aprendiz";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Aprendiz</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-green-50 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
        <h1 class="text-2xl font-bold text-green-700 text-center mb-4">Crear Aprendiz</h1>

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
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nombre del Aprendiz</label>
                <input class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500" 
                       id="name" name="name" type="text" placeholder="Nombre del Aprendiz" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="ficha_id">Ficha</label>
                <select class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500" 
                        id="ficha_id" name="ficha_id" required>
                    <option value="">---------</option>
                    <?php foreach ($fichas as $ficha): ?>
                        <option value="<?php echo $ficha['id']; ?>"><?php echo $ficha['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex justify-between">
                <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" type="submit">Crear Aprendiz</button>
                <a href="dashboard.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">Regresar</a>
            </div>
        </form>
    </div>
</body>
</html>
