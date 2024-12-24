<?php
session_start();
include '../Dbo/db_connect.php'; // Actualiza la ruta según la nueva ubicación

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../Vista/vista_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Verificar si se ha subido una imagen
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedExts = array('jpg', 'jpeg', 'png', 'gif');
        
        if (in_array($fileExtension, $allowedExts)) {
            $uploadFileDir = '../Recursos/imagenes/';
            $dest_path = $uploadFileDir . $fileName;

            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $imagePath = $fileName; // Guarda solo el nombre del archivo
            } else {
                header("Location: ../Vista/vista_admin.php?status=error");
                exit;
            }
        } else {
            header("Location: ../Vista/vista_admin.php?status=invalid_extension");
            exit;
        }
    }

    // Insertar el post en la base de datos
    $stmt = $mysqli->prepare("INSERT INTO posts (title, content, image_) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content, $imagePath);

    if ($stmt->execute()) {
        header("Location: ../Vista/vista_admin.php?status=post_success");
    } else {
        header("Location: ../Vista/vista_admin.php?status=post_error");
    }
    $stmt->close();
}
$mysqli->close();