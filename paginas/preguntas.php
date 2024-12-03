<?php
session_start();
include_once '../conexion/conexion.php';

// Obtener el término de búsqueda si se ha enviado
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

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
    <style>
        .barra-izquierda a[name="preguntas"] i,
        .barra-izquierda a[name="preguntas"] span {
            color: black;
        }
        .pregunta-container {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            position: relative;
        }
        .pregunta-container:hover {
            background-color: #f0f0ff;
        }
        .responder-btn-container {
            position: absolute;
            bottom: 15px;
            right: 15px;
        }
        .preguntas-contenedor {
            margin-top: 30px;
        }
        .insert-pregunta-btn-container {
            position: relative;
            top: -10px;
            right: 0;
            z-index: 10;
            margin-bottom: 20px;        }

        .barra-derecha {
            padding-right: 15px;
        }
        .navbar {
            margin-bottom: 30px;
        }
        .button-group {
            display: flex;
            gap: 10px; /* Espacio entre los botones */
            justify-content: flex-start;
        }
    </style>
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
                <form class="d-flex w-100" role="search" action="" method="get">
                    <input class="form-control search-bar" type="search" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Buscar" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <form action="../paginas/cerrar_sesion.php" method="POST">
                <input type="submit" value="Logout" class="btn btn-primary ms-3" name="logout">
            </form>
        </div>
    </nav>

    <div class="container">
        <!-- Contenedor de las preguntas y el botón "Haz una pregunta" -->
        <div class="preguntas-contenedor">
            <!-- Botón "Haz una pregunta" en la parte superior derecha -->
            <div class="insert-pregunta-btn-container">
                <form action="form_insertar_pregunta.php" method="POST">
                    <button type="submit" name="insertPreg" class="btn btn-primary ms-3">Haz una pregunta!</button>
                </form>
            </div>

            <div class="barra-izquierda">
                <a href="./verUsuarios.php" name="usuarios" class="d-flex align-items-center text-decoration-none">
                    <i class="fa-solid fa-users me-2"></i><span>Usuarios</span>
                </a>
                <br>
                <a href="./discusiones.php" name="discusiones" class="d-flex align-items-center text-decoration-none">
                    <i class="fa-solid fa-comments me-2"></i><span>Discusiones</span>
                </a>
                <br>
                <a href="./preguntas.php" name="preguntas" class="d-flex align-items-center text-decoration-none">
                    <i class="fa-solid fa-question-circle me-2"></i><span>Preguntas</span>
                </a>
                <br>
                <a href="./guardados.php" name="guardados" class="d-flex align-items-center text-decoration-none">
                    <i class="fa-solid fa-bookmark me-2"></i><span>Guardados</span>
                </a>
            </div>

            <div class="barra-derecha">
                <?php
                try {
                    // Si hay un término de búsqueda, modificar la consulta para filtrar por él
                    $query = "SELECT id_preguntas, titulo_preguntas, texto_preguntas, fecha_preguntas, tbl_preguntas.id_usuario, nombre_usuario 
                    FROM tbl_preguntas 
                    INNER JOIN tbl_usuarios ON tbl_preguntas.id_usuario = tbl_usuarios.id_usuario";

                    // Filtrar si hay término de búsqueda
                    if ($searchTerm != '') {
                        $query .= " WHERE titulo_preguntas LIKE :searchTerm OR texto_preguntas LIKE :searchTerm";
                    }

                    $query .= " ORDER BY fecha_preguntas DESC";

                    // Preparar y ejecutar la consulta
                    $stmt = $conexion->prepare($query);

                    if ($searchTerm != '') {
                        $stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
                    }

                    $stmt->execute();

                    $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Si no hay preguntas muestra mensaje de que no hay, si hay muestra preguntas
                    if (empty($preguntas)) {
                        echo "No hay preguntas en este momento";
                    } else {
                        echo '<ul style="list-style-type: none; padding: 0;">';
                        foreach ($preguntas as $pregunta) {
                            echo '<li class="pregunta-container" style="margin-bottom: 20px; position: relative;">';
                            echo '<form action="guardar_preguntas.php" method="post">';
                                echo '<input type="hidden" name="idPregunta" value="'. $pregunta['id_preguntas']. '">';
                                echo '<button class="btn btn-success" style="position: absolute; top: 5px; right: 10px;">';
                                echo '<i class="fas fa-save"></i> ';
                            echo '</button>';
                            echo '</form>';
                            echo '<strong style="font-size: 16px; color: #007BFF;">Título:</strong> ' . htmlspecialchars($pregunta['titulo_preguntas']) . '<br>';
                            echo '<strong style="font-size: 14px; color: #333;">Texto:</strong> ' . htmlspecialchars($pregunta['texto_preguntas']) . '<br>';
                            echo '<strong style="font-size: 14px; color: #666;">Usuario:</strong> ' . htmlspecialchars($pregunta['nombre_usuario']) . '<br>';
                            echo '<strong style="font-size: 14px; color: #666;">Fecha:</strong> ' . htmlspecialchars($pregunta['fecha_preguntas']) . '<br>';

                            echo '<div class="button-group" style="margin-top: 10px;">';

                            echo '<form action="verRespuestas.php" method="POST" style="display: inline-block; margin-right: 10px;">'; // Espacio añadido
                            echo '<input type="hidden" name="id_pregunta" value="' . $pregunta['id_preguntas'] . '">';
                            echo '<button type="submit" name="verRespuesta" class="btn btn-primary">Ver Respuestas</button>';
                            echo '</form>';

                            echo '<form action="form_insertar_respuesta.php" method="POST" style="display: inline-block;">';
                            echo '<input type="hidden" name="id_pregunta" value="' . $pregunta['id_preguntas'] . '">';
                            echo '<button type="submit" name="respuesta" class="btn btn-primary">Responder</button>';
                            echo '</form>';
                            echo '</div>'; 
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
