<?php
session_start();
include '../Dbo/db_connect.php'; // Ruta corregida para incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta preparada para evitar inyecciones SQL
    $stmt = $mysqli->prepare("SELECT id, username, role FROM users WHERE username = ? AND password = ? AND role = 'user'");
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $mysqli->error);
    }

    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        // Usuario encontrado, obtener datos
        $stmt->bind_result($user_id, $username, $role);
        $stmt->fetch();

        // Guardar en la sesión los datos del usuario
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['user_role'] = $role;

        // Redirigir a la vista de usuario preferencial
        header("Location: ../Vista/vista_us_pref.php");
        exit();
    } else {
        // Si las credenciales son incorrectas
        header("Location: ../Vista/vista_login2.php?error=1");
        exit();
    }
}
?>