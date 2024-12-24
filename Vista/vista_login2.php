<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cliente Preferencial</title>
    <link rel="stylesheet" href="../Recursos/css/login.css"> <!-- Enlazar al archivo CSS de login -->
</head>
<body>
    <div class="container">
        <h1>Iniciar Sesión - Cliente Preferencial</h1>
        <form action="../Controlador/controlador_login2.php" method="POST">
            <label for="username">Usuario:</label>
            <input type="text" name="username" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>

            <button type="submit">Iniciar Sesión</button>
        </form>

        <?php
        // Manejo de errores
        if (isset($_GET['error'])) {
            if ($_GET['error'] == '1') {
                echo "<p style='color: red;'>Usuario o contraseña incorrectos.</p>";
            } elseif ($_GET['error'] == 'rol_incorrecto') {
                echo "<p style='color: red;'>Acceso denegado. Solo los usuarios preferenciales pueden acceder.</p>";
            }
        }
        ?>
    </div>
</body>
</html>