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
    // Obtener los datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password']; // Contraseña en texto plano
    $role = $_POST['role'];
    $purchases = $_POST['purchases'];

    // Validar los campos
    if (!empty($username) && !empty($password) && !empty($role)) {
        // No se encripta la contraseña, se utiliza tal cual
        $plain_password = $password;

        // Preparar la consulta para insertar el nuevo usuario
        $stmt = $mysqli->prepare("INSERT INTO users (username, password, role, purchases) VALUES (?, ?, ?, ?)");

        // Verificar si la preparación fue exitosa
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $mysqli->error);
        }

        // Vincular los parámetros
        $stmt->bind_param("sssi", $username, $plain_password, $role, $purchases);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir al panel de administración con un mensaje de éxito
            header("Location: ../Vista/vista_admin.php?status=success&message=Usuario agregado correctamente.");
        } else {
            // Redirigir al panel de administración con un mensaje de error
            header("Location: ../Vista/vista_admin.php?status=error&message=Hubo un error al agregar el usuario.");
        }

        $stmt->close();
    } else {
        // Redirigir con un mensaje de error si algún campo está vacío
        header("Location: ../Vista/vista_admin.php?status=error&message=Todos los campos son requeridos.");
    }
}
?>