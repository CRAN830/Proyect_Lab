<?php
session_start();
include '../Dbo/db_connect.php';

// Verificar si el usuario está autenticado y tiene el rol de administrador
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../Vista/vista_login.php");
    exit();
}

// Verificar si los datos fueron enviados desde el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $purchases = $_POST['purchases'];

    // Verificar que los campos no estén vacíos
    if (!empty($user_id) && !empty($purchases)) {
        // Obtener el número actual de compras del usuario
        $stmt = $mysqli->prepare("SELECT purchases FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($current_purchases);
        $stmt->fetch();
        $stmt->close();

        if ($current_purchases !== null) {
            // Sumar las compras existentes con las nuevas
            $new_purchases = $current_purchases + $purchases;

            // Actualizar la columna 'purchases' en la base de datos
            $stmt = $mysqli->prepare("UPDATE users SET purchases = ? WHERE id = ?");
            $stmt->bind_param("ii", $new_purchases, $user_id);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Redirigir con un mensaje de éxito
                header("Location: ../Vista/vista_admin.php?status=success&message=Compras asignadas correctamente.");
            } else {
                die("Error al ejecutar la consulta: " . $stmt->error);
            }

            $stmt->close();
        } else {
            header("Location: ../Vista/vista_admin.php?status=error&message=Usuario no encontrado.");
        }
    } else {
        // Redirigir con un mensaje de error si los campos están vacíos
        header("Location: ../Vista/vista_admin.php?status=error&message=Todos los campos son requeridos.");
    }
}
?>