<?php
session_start();
require 'includes/functions.php';
checkPermission('instructor'); // Solo los instructores pueden tomar lista.

require 'includes/Database.php';
require 'includes/Instructor.php';

$instructor = new Instructor();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['ficha_id'], $_POST['fecha']) || empty($_POST['ficha_id']) || empty($_POST['fecha'])) {
        $error = "Debe seleccionar una ficha y una fecha.";
    } else {
        $ficha_id = $_POST['ficha_id'];
        $fecha = $_POST['fecha'];

        if (!empty($_POST['asistio']) && is_array($_POST['asistio'])) {
            foreach ($_POST['asistio'] as $aprendiz_id => $asistio) {
                $asistio = ($asistio == '1') ? 1 : 0;
                $instructor->tomarLista($aprendiz_id, $fecha, $asistio);
            }
            $_SESSION['success'] = "Asistencia registrada exitosamente";
            header('Location: dashboard.php');
            exit();
        } else {
            $error = "No se seleccionaron aprendices para tomar lista.";
        }
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
        <div class="flex justify-end mb-4">
            <form action="dashboard.php" method="POST">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Cerrar Sesión</button>
            </form>
        </div>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['success']; ?></span>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $error; ?></span>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="ficha_id">Seleccione una Ficha</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="ficha_id" name="ficha_id" required>
                    <option value="">------------</option>
                    <?php foreach ($fichas as $ficha): ?>
                        <option value="<?php echo htmlspecialchars($ficha['id']); ?>"><?php echo htmlspecialchars($ficha['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="fecha">Fecha</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="fecha" name="fecha" type="date" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Aprendices</label>
                <div id="aprendices-container" class="p-2 bg-white border rounded">
                    <p>Seleccione una ficha para ver los aprendices.</p>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Tomar Lista</button>
            </div>
        </form>
    </div>

    <script>
    document.getElementById('ficha_id').addEventListener('change', function() {
        let fichaId = this.value;
        let aprendicesContainer = document.getElementById('aprendices-container');

        if (fichaId) {
            fetch(`get_aprendices.php?ficha_id=${fichaId}`)
                .then(response => response.json())
                .then(data => {
                    let html = '';
                    if (data.length > 0) {
                        data.forEach(aprendiz => {
                            html += `
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" id="aprendiz_${aprendiz.id}" name="asistio[${aprendiz.id}]" value="1" class="mr-2">
                                    <label for="aprendiz_${aprendiz.id}">${aprendiz.name}</label>
                                </div>
                            `;
                        });
                    } else {
                        html = "<p>No hay aprendices en esta ficha.</p>";
                    }
                    aprendicesContainer.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error cargando aprendices:', error);
                    aprendicesContainer.innerHTML = "<p>Error al cargar los aprendices.</p>";
                });
        } else {
            aprendicesContainer.innerHTML = "<p>Seleccione una ficha para ver los aprendices.</p>";
        }
    });
    </script>
</body>
</html>