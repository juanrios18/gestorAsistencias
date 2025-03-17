<?php
session_start();
require 'includes/functions.php';
checkPermission('coordinator');

require 'includes/Database.php';
require 'includes/Coordinator.php';

$coordinator = new Coordinator();
$centros = $coordinator->getCentros();
$programas = [];
$ambientes = [];

// Si se seleccionó un centro, cargamos sus programas y ambientes asociados
if (isset($_POST['centro_id']) && !empty($_POST['centro_id'])) {
    $centro_id = $_POST['centro_id'];
    $programas = $coordinator->getProgramasByCentro($centro_id);
    $ambientes = $coordinator->getAmbientesByCentro($centro_id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $programa_id = $_POST['programa_id'];
    $ambiente_id = $_POST['ambiente_id'];
    $name = $_POST['name'];
    if ($coordinator->createFicha($programa_id, $ambiente_id, $name)) {
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
    <script>
        function submitCentroForm() {
            document.getElementById("centro-form").submit();
        }
    </script>
</head>
<body class="bg-green-50 flex items-center justify-center min-h-screen py-8">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
        <h1 class="text-2xl font-bold text-green-700 mb-6 text-center">Crear Ficha</h1>
        
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $error; ?></span>
            </div>
        <?php endif; ?>
        
        <!-- Selección de centro -->
        <form id="centro-form" method="POST" class="space-y-4 mb-6">
            <div>
                <label class="block text-black text-lg font-bold mb-2" for="centro_id">Seleccionar Centro</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500" id="centro_id" name="centro_id" onchange="submitCentroForm()" required>
                    <option value="">Seleccionar Centro</option>
                    <?php foreach ($centros as $centro): ?>
                        <option value="<?php echo $centro['id']; ?>" <?php echo (isset($_POST['centro_id']) && $_POST['centro_id'] == $centro['id']) ? 'selected' : ''; ?>>
                            <?php echo $centro['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <?php if (!empty($programas) && !empty($ambientes)): ?>
            <!-- Formulario para crear ficha -->
            <form method="POST" class="space-y-4">
                <input type="hidden" name="centro_id" value="<?php echo $_POST['centro_id']; ?>">
                <div>
                    <label class="block text-black text-lg font-bold mb-2" for="name">Número de Ficha</label>
                    <input class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500" id="name" name="name" type="text" placeholder="Número de Ficha" required>
                </div>
                <div>
                    <label class="block text-black text-lg font-bold mb-2" for="programa_id">Programa</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500" id="programa_id" name="programa_id" required>
                        <option value="">Seleccionar Programa</option>
                        <?php foreach ($programas as $programa): ?>
                            <option value="<?php echo $programa['id']; ?>"><?php echo $programa['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-black text-lg font-bold mb-2" for="ambiente_id">Ambiente</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500" id="ambiente_id" name="ambiente_id" required>
                        <option value="">Seleccionar Ambiente</option>
                        <?php foreach ($ambientes as $ambiente): ?>
                            <option value="<?php echo $ambiente['id']; ?>"><?php echo $ambiente['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex justify-between">
                    <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" type="submit" name="submit">Crear Ficha</button>
                    <a href="dashboard.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">Regresar</a>
                </div>
            </form>
        <?php elseif (isset($_POST['centro_id']) && !empty($_POST['centro_id'])): ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4" role="alert">
                <span class="block sm:inline">No hay programas o ambientes disponibles para este centro. Por favor, cree primero programas y ambientes asociados a este centro.</span>
            </div>
            <div class="flex justify-center">
                <a href="dashboard.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">Regresar</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>