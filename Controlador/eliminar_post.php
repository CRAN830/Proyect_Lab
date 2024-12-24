<?php
include '../Dbo/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si se ha enviado el post_id a través del formulario
    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);

    if (!$post_id) {
        header("Location: ../Vista/vista_admin.php?status=invalid_post_id");
        exit;
    }

    // Preparar la consulta para eliminar el post
    $stmt = $mysqli->prepare("DELETE FROM posts WHERE id = ?");
    if ($stmt === false) {
        echo "Error preparando la consulta: " . $mysqli->error;
        exit;
    }

    // Vincular el parámetro post_id como entero
    $stmt->bind_param("i", $post_id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir si la eliminación fue exitosa
        header("Location: ../Vista/vista_admin.php?status=delete_success");
    } else {
        // Mostrar el error específico si la eliminación falla
        echo "Error al eliminar el post: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    // Redirigir si no se envió ningún post_id
    header("Location: ../Vista/vista_admin.php?status=missing_post_id");
    exit;
}

// Cerrar la conexión a la base de datos
$mysqli->close();
?>