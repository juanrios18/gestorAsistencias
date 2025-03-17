<?php
session_start();
require 'includes/functions.php';
checkPermission('instructor');

require 'includes/Database.php';
require 'includes/Instructor.php';

$instructor = new Instructor();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aprendiz_id = $_POST['aprendiz_id'];
    $fecha = $_POST['fecha'];
    $asistio = isset($_POST['asistio']) ? 1 : 0;

    if ($instructor->tomarLista($aprendiz_id, $fecha, $asistio)) {
        $success = "Asistencia registrada exitosamente";
    } else {
        $error = "Error al registrar la asistencia";
    }
}

$fichas = $instructor->getFichas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tomar Lista</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Tomar Lista</h1>
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
                <label class="block text-gray-700 text-sm font-bold mb-2" for="ficha_id">Seleccione una Ficha</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="ficha_id" name="ficha_id">
                    <?php foreach ($fichas as $ficha): ?>
                        <option value="<?php echo $ficha['id']; ?>"><?php echo $ficha['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="fecha">Fecha</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="fecha" name="fecha" type="date">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Aprendices</label>
                <?php
                if (isset($_POST['ficha_id'])) {
                    $aprendices = $instructor->getAprendices($_POST['ficha_id']);
                    foreach ($aprendices as $aprendiz): ?>
                        <div class="flex items-center mb-2">
                            <input type="checkbox" id="aprendiz_<?php echo $aprendiz['id']; ?>" name="aprendiz_id[]" value="<?php echo $aprendiz['id']; ?>" class="mr-2">
                            <label for="aprendiz_<?php echo $aprendiz['id']; ?>"><?php echo $aprendiz['name']; ?></label>
                        </div>
                    <?php endforeach;
                }
                ?>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Tomar Lista</button>
            </div>
        </form>
    </div>
</body>
</html>