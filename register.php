<?php
session_start();
require 'includes/Database.php';
require 'includes/User.php';
require 'includes/functions.php';

$user = new User();

// Verificar si ya hay usuarios registrados
$result = $user->getConnection()->query("SELECT COUNT(*) AS total FROM users");
$row = $result->fetch_assoc();
$totalUsers = $row['total'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($user->register($username, $password, $role)) {
        redirect('dashboard.php');
    } else {
        $error = "Error al registrar el usuario";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-96">
        <h2 class="text-3xl font-bold text-center mb-6">Registro</h2>

        <?php if (isset($success)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="block text-black text-lg font-bold mb-2" for="username">Usuario</label>
                <input class="shadow-lg border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" 
                       id="username" name="username" type="text" placeholder="Usuario" required>
            </div>

            <div class="mb-4">
                <label class="block text-black text-lg font-bold mb-2" for="password">Contraseña</label>
                <input class="shadow-lg border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" 
                       id="password" name="password" type="password" placeholder="Contraseña" required>
            </div>

            <div class="mb-4">
                <label class="block text-black text-lg font-bold mb-2" for="role">Rol</label>
                <select class="shadow-lg border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" 
                        id="role" name="role" required>
                    <option value="">-------------</option>
                    <option value="super_admin">Super Administrador</option>
                </select>
            </div>

            <div class="flex flex-col items-center space-y-4">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full focus:outline-none focus:shadow-outline" 
                        type="submit">
                    Registrarse
                </button>
                <a href="dashboard.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full text-center">
                    Regresar
                </a>
            </div>
        </form>
    </div>
</body>
</html>