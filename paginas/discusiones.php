<?php
session_start();
include_once '../conexion/conexion.php';

// Obtener el término de búsqueda si se ha enviado
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
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
    <title>Discusiones</title>
</head>

<style>
        .barra-izquierda a[name="discusiones"] i,
        .barra-izquierda a[name="discusiones"] span {
            color: black;
        }

</style>

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
            <form action="./paginas/cerrar_sesion.php" method="POST">
                <input type="submit" value="Logout" class="btn btn-primary ms-3" name="logout">
            </form>
        </div>
    </nav>

    <div class="container">
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
            <a href="./discusiones.php" name="discusiones"
                class="d-flex align-items-center text-decoration-none">
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
                // Consulta SQL con filtro de búsqueda si el término de búsqueda está presente
                $query = "SELECT p.id_preguntas, p.titulo_preguntas, p.texto_preguntas, COUNT(r.id_respuestas) AS total_respuestas 
                          FROM tbl_preguntas p
                          JOIN tbl_respuestas r ON p.id_preguntas = r.id_preguntas
                          GROUP BY p.id_preguntas
                          HAVING total_respuestas >= 2";

                // Si hay un término de búsqueda, agregar el filtro
                if ($searchTerm != '') {
                    $query .= " AND (p.titulo_preguntas LIKE :searchTerm OR p.texto_preguntas LIKE :searchTerm)";
                }

                // Preparar la consulta
                $stmt = $conexion->prepare($query);

                // Enlazar el parámetro de búsqueda si es necesario
                if ($searchTerm != '') {
                    $stmt->bindValue(':searchTerm', "%" . $searchTerm . "%", PDO::PARAM_STR);
                }

                // Ejecutar la consulta
                $stmt->execute();
                $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($preguntas) {
                    foreach ($preguntas as $pregunta) {
                        echo '<div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($pregunta['titulo_preguntas']) . '</h5>
                                <p class="card-text">' . htmlspecialchars($pregunta['texto_preguntas']) . '</p>
                                <p class="text-muted">Total respuestas: ' . htmlspecialchars($pregunta['total_respuestas']) . '</p>
                                <div style="display: flex; gap: 10px;">
                                    <form action="verRespuestas.php" method="POST">
                                        <input type="hidden" name="id_pregunta" value="' . htmlspecialchars($pregunta['id_preguntas']) . '">
                                        <button type="submit" name="verRespuesta" class="btn btn-primary">Ver Respuestas</button>
                                    </form>
                                    <form action="form_insertar_respuesta.php" method="POST">
                                        <input type="hidden" name="id_pregunta" value="' . htmlspecialchars($pregunta['id_preguntas']) . '">
                                        <button type="submit" name="respuesta" class="btn btn-primary">Responder</button>
                                    </form>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    echo '<p>No hay preguntas con más de dos respuestas.</p>';
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pzjw8f+ua7Kw1TIq0spbMQF1UoE2bhcY3nZf6hu0bVsYoVvT5vTq77p9bRXg5HUP"
        crossorigin="anonymous"></script>
</body>
</html>
