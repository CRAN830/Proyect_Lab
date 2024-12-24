<?php
session_start();

// Verificar si el usuario está autenticado y tiene el rol de administrador
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../Vista/vista_login.php");
    exit();
}

include '../Dbo/db_connect.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Portafolio</title>
    <link rel="stylesheet" href="../Recursos/css/admin.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Panel de Administración</h1>
            <!-- Enlaces de navegación -->
            <nav>
                <a href="../Vista/vista_cliente.php" class="nav-link">Ver mi publicidad</a>
                <a href="../Controlador/cerrar_sesion.php" class="nav-link logout-link">Cerrar Sesión</a>
            </nav>
        </header>

        <!-- Mensajes de estado -->
        <?php
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
            if ($status == 'success') {
                echo "<p class='status success'>Operación exitosa.</p>";
            } elseif ($status == 'error') {
                echo "<p class='status error'>Hubo un error con la operación.</p>";
            } elseif ($status == 'post_success') {
                echo "<p class='status success'>Post publicado con éxito.</p>";
            } elseif ($status == 'post_error') {
                echo "<p class='status error'>Error al publicar el post.</p>";
            } elseif ($status == 'invalid_extension') {
                echo "<p class='status error'>Extensión de archivo no válida.</p>";
            } elseif ($status == 'delete_success') {
                echo "<p class='status success'>Post eliminado con éxito.</p>";
            } elseif ($status == 'delete_error') {
                echo "<p class='status error'>Error al eliminar el post.</p>";
            }
        }
        ?>

        <!-- Formulario para publicar en el foro con imagen -->
        <section class="post">
            <h2><center>Publicar anuncio </center></h2>
            <form action="../Controlador/controlador_post.php" method="post" enctype="multipart/form-data">
                <label for="title">Título:</label>
                <input type="text" name="title" id="title" required>
                <br><br>
                <label for="content">Contenido:</label>
                <textarea name="content" id="content" rows="4" required></textarea>
                <br><br>
                <label for="image">Seleccionar Imagen:</label>
                <input type="file" name="image" id="image" accept="image/*" required>
                <br><br>
                <button type="submit">Publicar</button>
            </form>
        </section>

        <!-- Sección para administrar posts -->
        <section class="manage-posts">
            <h2>Administrar mis anuncios</h2>
            <?php
            if ($mysqli) {
                $result = $mysqli->query("SELECT id, title, content, image_ FROM posts ORDER BY created_at DESC");

                if ($result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr><th>Título</th><th>Contenido</th><th>Imagen</th><th>Acciones</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['content']) . "</td>";

                        // Mostrar imagen si existe
                        if (!empty($row['image_'])) {
                            $imagePath = '../Recursos/imagenes/' . htmlspecialchars($row['image_']);
                            echo "<td><img src='" . $imagePath . "' alt='Imagen' width='100'></td>";
                        } else {
                            echo "<td>Sin imagen</td>";
                        }

                        // Botón de eliminar con JavaScript
                        echo "<td>
                            <form id='deleteForm-" . $row['id'] . "' action='../Controlador/eliminar_post.php' method='post'>
                                <input type='hidden' name='post_id' value='" . $row['id'] . "'>
                                <button class='delete-post-button' data-post-id='" . $row['id'] . "' type='button'>Eliminar</button>
                            </form>
                        </td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No hay posts publicados.</p>";
                }
            } else {
                echo "<p>No se pudo conectar a la base de datos.</p>";
            }
            ?>
        </section>

<!-- Sección para asignar compras a los usuarios -->
<section class="assign-purchases">
    <h2>Asignar compras a usuarios</h2>

    <!-- Mostrar mensaje de estado si existe -->
    <?php
    if (isset($_GET['message']) && !empty($_GET['message'])) {
        $message = $_GET['message'];
        $status = isset($_GET['status']) ? $_GET['status'] : 'error';
        
        // Mostrar mensaje con el estado correspondiente
        echo "<p class='status $status'>$message</p>";
    }
    ?>

    <form action="../Controlador/assign_purchase.php" method="post">
        <label for="user">Seleccionar usuario:</label>
        <select name="user_id" id="user" required>
            <?php
            // Obtener solo los usuarios con el rol 'user', excluyendo los administradores
            $usersResult = $mysqli->query("SELECT id, username FROM users WHERE role = 'user'");
            while ($user = $usersResult->fetch_assoc()) {
                echo "<option value='" . $user['id'] . "'>" . htmlspecialchars($user['username']) . "</option>";
            }
            ?>
        </select>
        <br><br>

        <label for="purchases">Cantidad de compras:</label>
        <input type="number" name="purchases" id="purchases" required min="1">
        <br><br>

        <button type="submit">Asignar compras</button>
    </form>
</section>

<!-- Modal de confirmación -->
<div id="confirmDeleteModal" class="modal">
    <div class="modal-content">
        <h2>Confirmar Eliminación</h2>
        <p>¿Estás seguro de que deseas eliminar este post?</p>
        <div class="modal-buttons">
            <button class="confirm-delete">Confirmar</button>
            <button class="cancel-delete">Cancelar</button>
        </div>
    </div>
</div>
</div>

<!-- Sección para agregar un nuevo usuario -->
<section class="add-user">
    <h2>Agregar nuevo usuario</h2>
    <form action="../Controlador/add_user.php" method="post">
        <label for="username">Nombre de usuario:</label>
        <input type="text" name="username" id="username" required>
        <br><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
        <br><br>

        <label for="role">Rol:</label>
        <select name="role" id="role" required>
            <option value="admin">Administrador</option>
            <option value="user">Usuario</option>
        </select>
        <br><br>

        <label for="purchases">Compras asignadas:</label>
        <input type="number" name="purchases" id="purchases" value="0" min="0">
        <br><br>

        <button type="submit">Agregar usuario</button>
    </form>
</section>

<!-- Incluir el archivo JavaScript -->
<script src="../Js/eliminar_post.js"></script>
</body>
</html>