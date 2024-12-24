<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Post - Panel de Administración</title>
    <link rel="stylesheet" href="../Recursos/css/admin.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Editar Post</h1>
            <nav>
                <a href="../Vista/vista_cliente.php" class="view-client-portal">Ver Portal Cliente</a>
            </nav>
        </header>
        <section class="post">
            <h2>Formulario de Edición</h2>
            <form id="editForm" action="../Controlador/actualizar_post.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="post_id" id="post_id">
                <label for="title">Título:</label>
                <input type="text" name="title" id="title" required>
                <br><br>
                <label for="content">Contenido:</label>
                <textarea name="content" id="content" rows="4" required></textarea>
                <br><br>
                <label for="image">Seleccionar Imagen:</label>
                <input type="file" name="image" id="image" accept="image/*">
                <br><br>
                <button type="submit">Actualizar</button>
            </form>
        </section>
        
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const postId = urlParams.get('post_id');

            if (postId) {
                fetch(`../Controlador/get_post.php?post_id=${postId}`)
                    .then(response => response.json())
                    .then(post => {
                        if (!post.error) {
                            document.getElementById('post_id').value = post.id;
                            document.getElementById('title').value = post.title;
                            document.getElementById('content').value = post.content;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
        </script>
    </div>
</body>
</html>