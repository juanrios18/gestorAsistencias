<?php
session_start();
require 'includes/functions.php';
checkPermission('super_admin');

require 'includes/Database.php';
require 'includes/SuperAdmin.php';

$superAdmin = new SuperAdmin();
$regionales = $superAdmin->getRegionales();
$centros = $superAdmin->getCentros();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regionales y Centros</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-green-50">
    <div class="container mx-auto p-6">
        <!-- Barra superior -->
        <div class="bg-green-700 text-white p-4 rounded-lg flex justify-between items-center shadow-md mb-6">
            <h1 class="text-2xl font-bold">Regionales y Centros</h1>
            <a href="dashboard.php" 
               class="bg-gray-600 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                Regresar
            </a>
        </div>

        <!-- Regionales -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-green-700">Regionales</h2>
                <a href="create_regional.php" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                    Crear Nueva Regional
                </a>
            </div>
            
            <?php if (empty($regionales)): ?>
                <p class="text-gray-600 italic">No hay regionales registradas.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-semibold text-gray-700">ID</th>
                                <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-semibold text-gray-700">Nombre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($regionales as $regional): ?>
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $regional['id']; ?></td>
                                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $regional['name']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Centros -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-green-700">Centros</h2>
                <a href="create_centro.php" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                    Crear Nuevo Centro
                </a>
            </div>
            
            <?php if (empty($centros)): ?>
                <p class="text-gray-600 italic">No hay centros registrados.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-semibold text-gray-700">ID</th>
                                <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-semibold text-gray-700">Nombre</th>
                                <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-semibold text-gray-700">Regional</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($centros as $centro): ?>
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $centro['id']; ?></td>
                                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $centro['name']; ?></td>
                                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $centro['regional_name']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>