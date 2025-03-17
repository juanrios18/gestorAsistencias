<?php
session_start();
require 'includes/functions.php';
require 'includes/Database.php';
require 'includes/Coordinator.php';

checkPermission('coordinator');

$coordinator = new Coordinator();
$fichas = $coordinator->getFichas();
$reportes = [];

// Si se selecciona una ficha
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ficha_id'])) {
    $ficha_id = $_POST['ficha_id'];
    $reportes = $coordinator->getReportesPorFicha($ficha_id);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de Asistencias</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-green-50 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-3xl">
        <h1 class="text-3xl font-bold text-green-700 text-center mb-6">Reportes de Asistencias</h1>

        <!-- Botón de regresar -->
        <div class="flex justify-end mb-4">
            <form action="dashboard.php" method="POST">
                <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition">
                    Regresar
                </button>
            </form>
        </div>

        <!-- Selector de Fichas -->
        <form method="POST" class="mb-6">
            <label for="ficha_id" class="block text-lg font-semibold text-gray-700">Selecciona una ficha:</label>
            <select name="ficha_id" id="ficha_id" required class="border p-2 rounded w-full focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="" disabled selected>Seleccione una ficha</option>
                <?php foreach ($fichas as $ficha): ?>
                    <option value="<?php echo $ficha['id']; ?>">
                        <?php echo htmlspecialchars($ficha['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded mt-3 transition w-full">
                📄 Ver Reporte
            </button>
        </form>

        <!-- Tabla de Reportes -->
        <?php if (!empty($reportes)): ?>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="w-full table-auto">
                    <thead class="bg-green-700 text-white">
                        <tr>
                            <th class="py-3 px-4 text-left">📌 Aprendiz</th>
                            <th class="py-3 px-4 text-center">🚫 Faltas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reportes as $reporte): ?>
                            <tr class="border-b <?php echo ($reporte['faltas'] >= 3) ? 'bg-red-500 text-white' : 'hover:bg-green-100'; ?>">
                                <td class="py-3 px-4"><?php echo htmlspecialchars($reporte['aprendiz_name']); ?></td>
                                <td class="py-3 px-4 text-center font-bold"><?php echo (int) $reporte['faltas']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>