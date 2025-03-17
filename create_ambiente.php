<?php
session_start();
require 'includes/functions.php';
checkPermission('coordinator');

require 'includes/Database.php';
require 'includes/Coordinator.php';

$coordinator = new Coordinator();
$centros = $coordinator->getCentros();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $centro_id = $_POST['centro_id'];
    if ($coordinator->createAmbiente($name, $centro_id)) {
        redirect('dashboard.php');
    } else {
        $error = "Error al crear el ambiente";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Ambiente</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-green-50">
    <div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
        <h1 class="text-3xl font-semibold text-green-700 mb-4 text-center">Crear Ambiente</h1>
        <?php if (isset($success)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                <span class="block sm:inline font-medium"><?php echo $success; ?></span>
            </div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                <span class="block sm:inline font-medium"><?php echo $error; ?></span>
            </div>
        <?php endif; ?>
        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nombre del Ambiente</label>
                <input class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-green-500 focus:outline-none" id="name" name="name" type="text" placeholder="Nombre del Ambiente" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="centro_id">Centro</label>
                <select class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-green-500 focus:outline-none" id="centro_id" name="centro_id" required>
                    <option value="">Seleccionar Centro</option>
                    <?php foreach ($centros as $centro): ?>
                        <option value="<?php echo $centro['id']; ?>"><?php echo $centro['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex justify-between">
                <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" type="submit">Crear Ambiente</button>
                <a href="dashboard.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">Regresar</a>
            </div>
        </form>
    </div>
</body>
</html>