<?php
session_start();
require 'includes/functions.php';
checkPermission('coordinator');

require 'includes/Database.php';
require 'includes/Coordinator.php';

$coordinator = new Coordinator();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $programa_id = $_POST['programa_id'];
    $ambiente_id = $_POST['ambiente_id'];
    $name = $_POST['name'];
    if ($coordinator->createFicha($programa_id, $ambiente_id, $name)) {
        $success = "Ficha creada exitosamente";
        redirect('dashboard.php');
    } else {
        $error = "Error al crear la ficha";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Ficha</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Crear Ficha</h1>
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
        <form method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="programa_id">Programa</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="programa_id" name="programa_id" required>
                <option value="">--------</option>
                    <?php
                    $programas = $coordinator->getProgramas();
                    foreach ($programas as $programa): ?>
                        <option value="<?php echo $programa['id']; ?>"><?php echo $programa['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="ambiente_id">Ambiente</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="ambiente_id" name="ambiente_id" required>
                    <option value="">--------</option>
                    <?php
                    $ambientes = $coordinator->getAmbientes();
                    foreach ($ambientes as $ambiente): ?>
                        <option value="<?php echo $ambiente['id']; ?>"><?php echo $ambiente['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Numero de la Ficha</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" type="text" placeholder="Numero de la Ficha" required>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Crear Ficha</button>
            </div>
        </form>
    </div>
</body>
</html>