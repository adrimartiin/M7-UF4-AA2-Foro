<?php
session_start();
include_once '../conexion/conexion.php';

if (!isset($_SESSION['usuario'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <title>Error</title>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Debes tener usuario para poder ver preguntas gaurdadas.',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../index.php'; 
                }
            });
        </script>
    </body>
    </html>
    <?php
    exit(); 
} 
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
        .barra-izquierda a[name="guardados"] i,
        .barra-izquierda a[name="guardados"] span {
            color: black;
        }

        /* Estilo para el contenedor de la pregunta */
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

        /* Posiciona el botón de responder en la parte inferior derecha */
        .responder-btn-container {
            position: absolute;
            bottom: 15px;
            right: 15px;
        }

        /* Estilo para el contenedor de preguntas y el botón "Haz una pregunta" */
        .preguntas-contenedor {
            margin-top: 30px;
            /* Deja un margen para separar el contenido del navbar */
        }

        /* Estilo para el botón de "Haz una pregunta" */
        .insert-pregunta-btn-container {
            position: relative;
            top: -10px;
            /* Ajusta la posición del botón hacia arriba */
            right: 0;
            z-index: 10;
            margin-bottom: 20px;
            /* Añade espacio entre el botón y el contenido */
        }

        .barra-derecha {
            padding-right: 15px;
        }

        /* Espaciado entre el navbar y el contenido */
        .navbar {
            margin-bottom: 30px;
            /* Aumenta el espacio entre el navbar y el contenido */
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
                <!-- event.preventDefault evita el comportamiento predeterminado del formulario, que sería recargar o navegar a una nueva página al enviarse. -->
                <form class="d-flex w-100" role="search" onsubmit="event.preventDefault(); buscarPreguntas();">
                    <input class="form-control search-bar" type="search" id="buscar" placeholder="Buscar" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <form action="../paginas/cerrar_sesion.php" method="POST">
                <input type="submit" value="Logout" class="btn btn-primary ms-3" name="logout">
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="preguntas-contenedor">
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
            // Obtener ID del usuario logueado
            $usuario = $_SESSION['usuario'];
            $stmt_usuario = $conexion->prepare("SELECT id_usuario FROM tbl_usuarios WHERE nombre_usuario = :nombre_usuario");
            $stmt_usuario->bindParam(':nombre_usuario', $usuario);
            $stmt_usuario->execute();
            $resultado_usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);

            if (!$resultado_usuario) {
                echo "Error: Usuario no encontrado.";
                exit;
            }

            $id_usuario = $resultado_usuario['id_usuario'];

            // Consultar preguntas guardadas por el usuario actual
            $stmt = $conexion->prepare("
                SELECT titulo_preguntas, texto_preguntas, nombre_usuario, fecha_preguntas, id_preguntas
                FROM tbl_preguntas
                INNER JOIN tbl_usuarios ON tbl_preguntas.id_usuario = tbl_usuarios.id_usuario
                WHERE guardar_preguntas = 'guardada'
            ");
            $stmt->execute();
            $guardados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Mostrar preguntas guardadas
            if (empty($guardados)) {
                echo "No tienes preguntas guardadas en este momento.";
            } else {
                echo '<ul style="list-style-type: none; padding: 0;" id="listaPreguntas">';
                foreach ($guardados as $pregunta) {
                    echo '<li class="pregunta-container" data-titulo="' . htmlspecialchars($pregunta['titulo_preguntas']) . '" data-texto="' . htmlspecialchars($pregunta['texto_preguntas']) . '">';
                    echo '<strong style="font-size: 16px; color: #007BFF;">Título:</strong> ' . htmlspecialchars($pregunta['titulo_preguntas']) . '<br>';
                    echo '<strong style="font-size: 14px; color: #333;">Texto:</strong> ' . htmlspecialchars($pregunta['texto_preguntas']) . '<br>';
                    echo '<strong style="font-size: 14px; color: #666;">Usuario:</strong> ' . htmlspecialchars($pregunta['nombre_usuario']) . '<br>';
                    echo '<strong style="font-size: 14px; color: #666;">Fecha:</strong> ' . htmlspecialchars($pregunta['fecha_preguntas']) . '<br>';
                    echo '<div class="button-group" style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">';

                    echo '<div style="display: flex; gap: 10px;">';
                    echo '<form action="verRespuestas.php" method="POST">';
                    echo '<input type="hidden" name="id_pregunta" value="' . $pregunta['id_preguntas'] . '">';
                    echo '<button type="submit" name="verRespuesta" class="btn btn-primary">Ver Respuestas</button>';
                    echo '</form>';
                    echo '</div>'; 
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

    <script>
        function buscarPreguntas() {
            const searchTerm = document.getElementById("buscar").value.toLowerCase();
            const preguntas = document.querySelectorAll(".pregunta-container");
            
            preguntas.forEach(pregunta => {
                const titulo = pregunta.getAttribute("data-titulo").toLowerCase();
                const texto = pregunta.getAttribute("data-texto").toLowerCase();

                if (titulo.includes(searchTerm) || texto.includes(searchTerm)) {
                    pregunta.style.display = "";
                } else {
                    pregunta.style.display = "none";
                }
            });
        }
    </script>
</body>
</html>
