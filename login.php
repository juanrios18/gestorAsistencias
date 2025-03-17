<?php
session_start();
require 'includes/Database.php';
require 'includes/User.php';
require 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isFieldEmpty($email) || isFieldEmpty($password)) {
        $error = "Por favor, ingrese su email y contraseña";
    } else {
        $user = new User();
        $loggedInUser = $user->login($email, $password);

        if ($loggedInUser) {
            $_SESSION['user'] = $loggedInUser;
            // Redirigir al dashboard después del login
            redirect('dashboard.php');
        } else {
            $error = "Email o contraseña incorrectos";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-96">
        <h2 class="text-3xl font-bold mb-6 text-center">Login</h2>
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $error; ?></span>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-4">
                <label class="block text-black text-lg font-bold mb-2" for="email">Correo Electrónico</label>
                <input class="shadow-lg appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                       id="email" name="email" type="email" placeholder="Correo Electrónico" required>
            </div>
            <div class="mb-6">
                <label class="block text-black text-lg font-bold mb-2" for="password">Contraseña</label>
                <input class="shadow-lg appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                       id="password" name="password" type="password" placeholder="Contraseña" required>
            </div>
            <div class="flex flex-col items-center space-y-4">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full" 
                        type="submit">
                    Iniciar Sesión
                </button>
                <p class="text-sm text-gray-600 text-center mt-4">¿No tienes una cuenta?</p>
                <a href="register.php" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full text-center">
                    Registrarse
                </a>
            </div>
        </form>
    </div>
</body>

</html>