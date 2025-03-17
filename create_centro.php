<?php
session_start();
require 'includes/functions.php';
checkPermission('super_admin');

require 'includes/Database.php';
require 'includes/SuperAdmin.php';

$superAdmin = new SuperAdmin();
$regionales = $superAdmin->getRegionales();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $regional_id = $_POST['regional_id'];
    if ($superAdmin->createCentro($name, $regional_id)) {
        redirect('dashboard.php');
    } else {
        $error = "Error al crear el centro";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Centro</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-green-50">
    <div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
        <h1 class="text-3xl font-semibold text-green-700 mb-4 text-center">Crear Centro</h1>
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
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nombre del Centro</label>
                <input class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-green-500 focus:outline-none" id="name" name="name" type="text" placeholder="Nombre del Centro" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="regional_id">Regional</label>
                <select class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-green-500 focus:outline-none" id="regional_id" name="regional_id" required>
                    <option value="">Seleccionar Regional</option>
                    <?php foreach ($regionales as $regional): ?>
                        <option value="<?php echo $regional['id']; ?>"><?php echo $regional['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex justify-between">
                <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" type="submit">Crear Centro</button>
                <a href="dashboard.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">Regresar</a>
            </div>
        </form>
    </div>
</body>
</html>