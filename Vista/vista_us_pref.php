<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'user') {
    header("Location: ../Vista/vista_login.php");
    exit();
}

include '../Dbo/db_connect.php';

$user_id = $_SESSION['user_id'];

// Consultar las compras del usuario
$result = $mysqli->query("SELECT purchases FROM users WHERE id = $user_id");
$purchases = 0;

if ($result) {
    $row = $result->fetch_assoc();
    $purchases = $row['purchases'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <link rel="stylesheet" href="../Recursos/css/usuario.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        </header>
        <section class="purchases">
            <h2>Mis Compras</h2>
            <p>Tienes un total de <strong><?php echo $purchases; ?></strong> compras asignadas.</p>
        </section>
    </div>
</body>
</html>