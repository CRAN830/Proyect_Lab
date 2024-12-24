<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foro del Cliente</title>
    <link rel="stylesheet" href="../Recursos/css/cliente.css">
</head>
<body>
    <header>
        <h1>Cliente Preferencial</h1>
        <a href="../index.php" class="logout-link">Salir</a>
    </header>
    <div class="container">
        <div class="forum">
            <h2>Últimos Mensajes</h2>
            
            <?php
            include '../Dbo/db_connect.php';

            if ($mysqli) {
                $result = $mysqli->query("SELECT title, content, image_ FROM posts ORDER BY created_at DESC");

                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='post'>";
                        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                        echo "<p>" . htmlspecialchars($row['content']) . "</p>";

                        // Mostrar imagen si existe
                        if (!empty($row['image_'])) {
                            $imagePath = '../Recursos/imagenes/' . htmlspecialchars($row['image_']);

                            if (file_exists($imagePath)) {
                                echo "<img src='" . $imagePath . "' alt='Imagen del post' class='post-image'>";
                            } else {
                                echo "<p>Imagen no encontrada.</p>";
                            }
                        }
                        echo "</div>";
                    }
                } else {
                    echo "<p>Error en la consulta: " . $mysqli->error . "</p>";
                }
            } else {
                echo "<p>No se pudo conectar a la base de datos.</p>";
            }
            ?>
        </div>
        <div class="contact">
            <h2>Contacto</h2>
            <ul>
                <li>WhatsApp: <a href="tel:+123456789">+57 3237617305</a></li>
                <li>Gmail: <a href="mailto:contacto@example.com">cristianvaleroigua830@gmail.com</a></li>
                <li>hotmail: <a href="mailto:contacto@example.com">cristianvaleroigua830@hotmail.com</a></li>
            </ul>
        </div>
    </div>
</body>
</html>