<?php

session_start();

if (isset($_GET['id'])) {
    $id_usuario = intval($_GET['id']); 
}

include_once('../conexion/conexion.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
    <title>CodePlus</title>
    <style>
    .barra-izquierda a[name="usuarios"] i,
    .barra-izquierda a[name="usuarios"] span {
        color: black;
    }
</style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php"><img src="../img/nav_logo.png" id="nav_img" alt="Logo"></a>
            <?php 
                 if(!isset($_SESSION['usuario'])){
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="d-flex w-100" role="search">
                    <input class="form-control search-bar" type="search" placeholder="Buscar" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <form action = "./cerrar_sesion.php" method = "POST">
                <input type="submit" value="Logout" class="btn btn-primary ms-3" name="logout">
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="barra-izquierda">
            <a href="./verUsuarios.php" name="usuarios" class="d-flex align-items-center text-decoration-none">
                <i class="fa-solid fa-users me-2"></i><span>Usuarios</span>
            </a>
            <br>
            <a href="#" name="discusiones" class="d-flex align-items-center text-decoration-none">
                <i class="fa-solid fa-comments me-2"></i><span>Discusiones</span>
            </a>
            <br>
            <a href="../paginas/preguntas.php" name="preguntas" class="d-flex align-items-center text-decoration-none">
                <i class="fa-solid fa-question-circle me-2"></i><span>Preguntas</span>
            </a>
            <br>
            <a href="#" name="guardados" class="d-flex align-items-center text-decoration-none">
                <i class="fa-solid fa-bookmark me-2"></i><span>Guardados</span>
            </a>
        </div>

        <div class="barra-derecha">
            <?php
            try {
                $stmt = $conexion->prepare("
                SELECT id_preguntas, titulo_preguntas, texto_preguntas,estado_preguntas, fecha_preguntas, tbl_preguntas.id_usuario, nombre_usuario 
                FROM tbl_preguntas 
                INNER JOIN tbl_usuarios ON tbl_preguntas.id_usuario = tbl_usuarios.id_usuario 
                WHERE tbl_preguntas.id_usuario = :id_usuario 
                ORDER BY fecha_preguntas DESC");

                $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $stmt->execute();
            
                
                $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC); //obtengo los resultados 

                if ($preguntas) {
                    echo "<h2>Preguntas realizadas por el usuario:</h2>";
                    echo "<ul style='list-style-type: none; padding: 0;'>";
                    foreach ($preguntas as $pregunta) {
                        echo '<li class="pregunta-container" style="margin-bottom: 20px; position: relative;">';
                        echo '<form action="guardar_preguntas.php" method="post">';
                        echo '<button class="btn btn-success" style="position: absolute; top: 5px; right: 10px;">';
                        echo '<i class="fas fa-save"></i> ';
                        echo '</button>';
                        echo '</form>';                        echo "<strong>Título:</strong> <span>" . htmlspecialchars($pregunta['titulo_preguntas']) . "</span><br>";
                        echo "<strong>Texto:</strong> <span>" . htmlspecialchars($pregunta['texto_preguntas']) . "</span><br>";
                        echo "<strong>Estado:</strong> <span>" . htmlspecialchars($pregunta['estado_preguntas']) . "</span>";

                        echo '<div class="button-group" style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">';

                        echo '<div style="display: flex; gap: 10px;">';
                        echo '<form action="verRespuestas.php" method="POST">';
                        echo '<input type="hidden" name="id_pregunta" value="' . $pregunta['id_preguntas'] . '">';
                        echo '<button type="submit" name="verRespuesta" class="btn btn-primary">Ver Respuestas</button>';
                        echo '</form>';

                        echo '<form action="form_insertar_respuesta.php" method="POST">';
                        echo '<input type="hidden" name="id_pregunta" value="' . $pregunta['id_preguntas'] . '">';
                        echo '<button type="submit" name="respuesta" class="btn btn-primary">Responder</button>';
                        echo '</form>';
                        echo '</div>'; 
                        echo '</div>'; 
                        echo '</li>';                    }
                    echo "</ul>";
                }
                 else {
                    echo "Este usuario no ha realizado preguntas.";
                }
            } catch (PDOException $e) {
                echo "Error en la conexión: " . $e->getMessage();
            }

            ?>
        </div>
    </div>

</body>