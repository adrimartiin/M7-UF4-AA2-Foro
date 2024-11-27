<?php
session_start();
include_once '../conexion/conexion.php';
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Preguntas</title>
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
            <a href="../paginas/verUsuarios.php" name="usuarios" class="d-flex align-items-center text-decoration-none">
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
                    // Consulta para recuperar todas las preguntas con el usuario que las ha hecho
                    $stmt = $conexion->query("SELECT id_preguntas, titulo_preguntas, texto_preguntas, fecha_preguntas, tbl_preguntas.id_usuario, nombre_usuario 
                    FROM tbl_preguntas 
                    INNER JOIN tbl_usuarios ON tbl_preguntas.id_usuario = tbl_usuarios.id_usuario ORDER BY fecha_preguntas DESC");

                    // Obtener todos los resultados como un array asociativo
                    $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Si no hay preguntas muestra mensaje de que no hay, si hay muestra preguntas
                    if (empty($preguntas)) {
                        echo "No hay preguntas en este momento";
                    } else {
                        echo '<ul style="list-style-type: none; padding: 0;">';
                    foreach ($preguntas as $pregunta) {
                        echo '<li style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">';
                        echo '<strong style="font-size: 16px; color: #007BFF;">Título:</strong> ' . htmlspecialchars($pregunta['titulo_preguntas']) . '<br>';
                        echo '<strong style="font-size: 14px; color: #333;">Texto:</strong> ' . htmlspecialchars($pregunta['texto_preguntas']) . '<br>';
                        echo '<strong style="font-size: 14px; color: #666;">Estado:</strong> ' . htmlspecialchars($pregunta['nombre_usuario']) . '<br>';
                        echo '<strong style="font-size: 14px; color: #666;">Fecha:</strong> ' . htmlspecialchars($pregunta['fecha_preguntas']) . '<br>';
                        echo '<form action="form_respuestas.php" method="POST">';
                            echo '<button type="submit" name="respuesta" class="btn btn-primary ms-3"> Responder </button>';
                        echo '</form>';
                        echo '</li>';
                    }
                    echo '</ul>';
                    }
                } catch (PDOException $e) {
                    echo 'Error en la consulta: ' . $e->getMessage();
                }
                ?>
                <form action="form_insertar_pregunta.php" method="POST">
                    <button type="submit" name="insertPreg" class="btn btn-primary ms-3">Haz una pregunta!</button>
                </form>
            
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HoA1K1fLdABEl+3t4zFQxtptCkQnz4BHo9LYUDe0w5l0yAyPi6gt74cHkXz6f1KP" crossorigin="anonymous">
            </script>
</body>
</html>