<?php
/* este archivo lo que hará es:
1) SELECT de todas las preguntas que ha guardado el usuario logueado
*/

session_start();
include_once '../conexion/conexion.php';

if (!isset($_SESSION['usuario'])) {
    echo 'Error! Debes loguearte para poder guardar preguntas';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Preguntas Guardadas</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php"><img src="../img/nav_logo.png" id="nav_img" alt="Logo"></a>
            <?php
            if (!isset($_SESSION['usuario'])) {
                ?>
                <form action="./entrada/login.php">
                    <?php
                    echo '<button class="btn btn-primary ms-3">Login</button>';
                    ?>
                </form>
                <?php
            } else {
                echo $_SESSION['usuario'];
            }
            ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="d-flex w-100" role="search">
                    <input class="form-control search-bar" type="search" placeholder="Buscar" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit"><i
                            class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <form action="../paginas/cerrar_sesion.php" method="POST">
                <input type="submit" value="Logout" class="btn btn-primary ms-3" name="logout">
            </form>
        </div>
    </nav>
    <div class="container">
        <div class="barra-izquierda">
            <a href="" name="usuarios" class="d-flex align-items-center text-decoration-none">
                <i class="fa-solid fa-users me-2"></i><span>Usuarios</span>
            </a>
            <br>
            <a href="" name="discusiones" class="d-flex align-items-center text-decoration-none">
                <i class="fa-solid fa-comments me-2"></i><span>Discusiones</span>
            </a>
            <br>
            <a href="" name="preguntas" class="d-flex align-items-center text-decoration-none">
                <i class="fa-solid fa-question-circle me-2"></i><span>Preguntas</span>
            </a>
            <br>
            <a href="" name="guardados" class="d-flex align-items-center text-decoration-none">
                <i class="fa-solid fa-bookmark me-2"></i><span>Guardados</span>
            </a>
        </div>

        <div class="barra-derecha">
            <?php
           try {
               // Verifica que el usuario esté logueado
               if (!isset($_SESSION['usuario'])) {
                   echo "Error: No estás logueado.";
                   exit;
               }
           
               // Obtener el id_usuario del usuario logueado
               $id_usuario = $_SESSION['usuario'];
           
               // ==== QUERY PARA RECUPERAR LAS PREGUNTAS GUARDADAS DEL USUARIO LOGUEADO ====
               $stmt = $conexion->prepare("SELECT titulo_preguntas, texto_preguntas, nombre_usuario, fecha_preguntas
                                           FROM tbl_preguntas
                                           INNER JOIN tbl_usuarios 
                                           ON tbl_preguntas.id_usuario = tbl_usuarios.id_usuario 
                                           WHERE guardar_preguntas = 'guardada' 
                                           AND tbl_preguntas.id_usuario = :id_usuario");
           
               // Enlazar el parámetro ':id_usuario' con el id del usuario logueado
               $stmt->bindParam(':id_usuario', $id_usuario);
           
               // Ejecutar la consulta
               $stmt->execute();
           
               // Recuperar los resultados
               $guardados = $stmt->fetchAll(PDO::FETCH_ASSOC);
           
               // Si no hay preguntas guardadas muestra mensaje de que no hay, si hay muestra preguntas
               if (empty($guardados)) {
                   echo "No tienes preguntas guardadas en este momento.";
               } else {
                   echo '<ul style="list-style-type: none; padding: 0;">';
                   foreach ($guardados as $guardado) {
                       echo '<li class="pregunta-container" style="margin-bottom: 20px; position: relative;">';
                       echo '<form action="guardar_preguntas.php" method="post">';
                       echo '<input type="hidden" name="idPregunta" value="' . $guardado['id_preguntas'] . '">';
                       echo '<button class="btn btn-success" style="position: absolute; top: 5px; right: 10px;">';
                       echo '<i class="fas fa-save"></i> ';
                       echo '</button>';
                       echo '</form>';
                       echo '<strong style="font-size: 16px; color: #007BFF;">Título:</strong> ' . htmlspecialchars($guardado['titulo_preguntas']) . '<br>';
                       echo '<strong style="font-size: 14px; color: #333;">Texto:</strong> ' . htmlspecialchars($guardado['texto_preguntas']) . '<br>';
                       echo '<strong style="font-size: 14px; color: #666;">Usuario:</strong> ' . htmlspecialchars($guardado['nombre_usuario']) . '<br>';
                       echo '<strong style="font-size: 14px; color: #666;">Fecha:</strong> ' . htmlspecialchars($guardado['fecha_preguntas']) . '<br>';
           
                       // Contenedor de botones
                       echo '<div class="button-group" style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">';
                       echo '<div style="display: flex; gap: 10px;">';
                       echo '<form action="verRespuestas.php" method="POST">';
                       echo '<button type="submit" name="verRespuesta" class="btn btn-primary">Ver Respuestas</button>';
                       echo '</form>';
           
                       echo '<form action="form_insertar_respuesta.php" method="POST">';
                       echo '<button type="submit" name="respuesta" class="btn btn-primary">Responder</button>';
                       echo '</form>';
                       echo '</div>'; // Cierre del grupo de botones
           
                       echo '</div>'; // Cierre del contenedor principal de botones
                       echo '</li>';
                   }
                   echo '</ul>';
               }
           } catch (PDOException $e) {
               echo 'Error en la consulta: ' . $e->getMessage();
           }
           
            ?>



        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HoA1K1fLdABEl+3t4zFQxtptCkQnz4BHo9LYUDe0w5l0yAyPi6gt74cHkXz6f1KP" crossorigin="anonymous">
        </script>
</body>

</html>