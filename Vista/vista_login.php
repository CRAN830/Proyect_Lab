<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Administrador</title>
    <link rel="stylesheet" href="../Recursos/css/login.css"> <!-- Enlazar al nuevo archivo CSS -->
</head>
<body>
    <div class="container">
        <h1>Iniciar Sesión  Administrador</h1>
        <form action="../Controlador/controlador_login.php" method="POST">
            <label for="username">Usuario:</label>
            <input type="text" name="username" required>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <?php
        if (isset($_GET['error'])) {
            echo "<p>Usuario o contraseña incorrectos.</p>";
        }
        ?>
    </div>
</body>
</html>