<?php
session_start();
include '../Dbo/db_connect.php'; // Conexión a la base de datos

// Verificar que el usuario es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../Vista/vista_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar datos del formulario
    $user_id = $_POST['user_id'];
    $purchases = intval($_POST['purchases']);

    // Validar cantidad de compras
    if ($purchases > 0) {
        // Actualizar la tabla users para incrementar las compras
        $stmt = $mysqli->prepare("UPDATE users SET purchases = purchases + ? WHERE id = ?");
        $stmt->bind_param("ii", $purchases, $user_id);

        if ($stmt->execute()) {
            // Redirigir con mensaje de éxito
            header("Location: ../Vista/vista_admin.php?status=success");
        } else {
            // Redirigir con mensaje de error
            header("Location: ../Vista/vista_admin.php?status=error");
        }
        $stmt->close();
    } else {
        header("Location: ../Vista/vista_admin.php?status=error");
    }
}
?>