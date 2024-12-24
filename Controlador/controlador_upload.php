<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: ../Vista/vista_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedExts = array('jpg', 'jpeg', 'png', 'gif');
        
        if (in_array($fileExtension, $allowedExts)) {
            $uploadFileDir = '../Recursos/imagenes/';
            $dest_path = $uploadFileDir . $fileName;

            // Asegúrate de que la carpeta exista y tenga permisos de escritura
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true); // Crear la carpeta si no existe
            }

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                header("Location: ../Vista/vista_admin.php?status=success");
            } else {
                header("Location: ../Vista/vista_admin.php?status=error");
            }
        } else {
            header("Location: ../Vista/vista_admin.php?status=invalid_extension");
        }
    } else {
        header("Location: ../Vista/vista_admin.php?status=error");
    }
}