<?php
session_start();
include_once '../conexion/conexion.php';

if (isset($_POST['id_pregunta'])) {
    $id_pregunta = (int)$_POST['id_pregunta'];  
} else {
    die("ID de la pregunta no proporcionado");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Preguntas y Respuestas</title>
    <style>
        .barra-izquierda a[name="preguntas"] i,
        .barra-izquierda a[name="preguntas"] span {
            color: black;
        }
        .pregunta-container, .respuesta-container {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .responder-btn-container {
            margin-top: 10px;
        }
        .barra-derecha {
            border-left: 2px solid #ddd;
            padding-left: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php"><img src="../img/nav_logo.png" id="nav_img" alt="Logo"></a>
            <?php
            if (!isset($_SESSION['usuario'])) {
                echo '<form action="./entrada/login.php"><button class="btn btn-primary ms-3">Login</button></form>';
            } else {
                echo htmlspecialchars($_SESSION['usuario']);
            }
            ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="d-flex w-100" role="search">
                    <input class="form-control search-bar" type="search" placeholder="Buscar" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
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
                    $sql = $conexion->prepare("
                        SELECT 
                            tbl_respuestas.id_respuestas, 
                            tbl_respuestas.titulo_respuestas, 
                            tbl_respuestas.texto_respuestas, 
                            tbl_respuestas.fecha_respuestas, 
                            tbl_usuarios.nombre_usuario AS nombre_usuario_respuesta, 
                            tbl_preguntas.titulo_preguntas, 
                            tbl_preguntas.texto_preguntas, 
                            tbl_preguntas.fecha_preguntas, 
                            tbl_usuarios_pregunta.nombre_usuario AS nombre_usuario_pregunta
                        FROM 
                            tbl_respuestas
                        INNER JOIN 
                            tbl_usuarios ON tbl_respuestas.id_usuario = tbl_usuarios.id_usuario
                        INNER JOIN 
                            tbl_preguntas ON tbl_respuestas.id_preguntas = tbl_preguntas.id_preguntas
                        INNER JOIN 
                            tbl_usuarios AS tbl_usuarios_pregunta ON tbl_preguntas.id_usuario = tbl_usuarios_pregunta.id_usuario
                        WHERE 
                            tbl_respuestas.id_preguntas = :id_pregunta
                        ORDER BY 
                            tbl_respuestas.fecha_respuestas DESC
                    ");
                    $sql->bindParam(':id_pregunta', $id_pregunta, PDO::PARAM_INT);
                    $sql->execute();

                    $respuestas = $sql->fetchAll(PDO::FETCH_ASSOC);

                    // Mostrar pregunta principal
                    if (!empty($respuestas)) {
                        $pregunta = $respuestas[0];
                        echo '<div class="pregunta-container">';
                        echo '<h5>' . htmlspecialchars($pregunta['titulo_preguntas']) . '</h5>';
                        echo '<p>' . nl2br(htmlspecialchars($pregunta['texto_preguntas'])) . '</p>';
                        echo '<small>Por: ' . htmlspecialchars($pregunta['nombre_usuario_pregunta']) . ' | Fecha: ' . htmlspecialchars($pregunta['fecha_preguntas']) . '</small>';
                        echo '<div class="responder-btn-container">';
                        echo '<form action="form_insertar_respuesta.php" method="POST">';
                        echo '<input type="hidden" name="id_pregunta" value="' . $id_pregunta . '">';
                        echo '<button type="submit" class="btn btn-primary">Responder</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<p>No hay respuestas para esta pregunta.</p>';
                    }

                    // Mostrar respuestas
                    echo '<h5>Respuestas:</h5>';
                    if (!empty($respuestas)) {
                        foreach ($respuestas as $respuesta) {
                            echo '<div class="respuesta-container">';
                            echo '<h6>' . htmlspecialchars($respuesta['titulo_respuestas']) . '</h6>';
                            echo '<p>' . nl2br(htmlspecialchars($respuesta['texto_respuestas'])) . '</p>';
                            echo '<small>Por: ' . htmlspecialchars($respuesta['nombre_usuario_respuesta']) . ' | Fecha: ' . htmlspecialchars($respuesta['fecha_respuestas']) . '</small>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No hay respuestas todavía.</p>';
                    }
                } catch (PDOException $e) {
                    echo '<p>Error al cargar las respuestas: ' . htmlspecialchars($e->getMessage()) . '</p>';
                }
                ?>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
