<?php
session_start();
require 'includes/functions.php';
checkPermission('coordinator');

require 'includes/Database.php';
require 'includes/Coordinator.php';

$coordinator = new Coordinator();

$reportes = $coordinator->getReportes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de Asistencias</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Reportes de Asistencias</h1>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Aprendiz</th>
                    <th class="py-2 px-4 border-b">Faltas</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($reportes)): ?>
                    <?php foreach ($reportes as $reporte): ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?php echo $reporte['aprendiz_name']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $reporte['faltas']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="py-2 px-4 border-b text-center">No hay reportes disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>