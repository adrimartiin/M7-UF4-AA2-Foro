<?php

session_start();

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
                    <form action="../entrada/login.php">
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
            <div class="usuario-container">
                <?php
                try {
                    // Consulta a la base de datos
                    $stmt = $conexion->query("SELECT nombre_usuario, id_usuario FROM tbl_usuarios");
                    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener todos los resultados como un array asociativo

                    for ($i = 0; $i < count($usuarios); $i++) {
                        echo '<div class="usuario-item">';
                        echo '<a href="./preguntasUsuario.php?id=' . urlencode($usuarios[$i]['id_usuario']) . '">'; // Aquí pasas el ID
                        echo '<img src="../img/perfil.png" alt="Foto de perfil">'; 
                        echo '<span>' . htmlspecialchars($usuarios[$i]['nombre_usuario']) . '</span>';
                        echo '</a>';
                        echo '</div>';
                    }
                    
                } catch (PDOException $e) {
                    echo 'Error en la consulta: ' . $e->getMessage();
                }
                ?>
            </div>
        </div>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HoA1K1fLdABEl+3t4zFQxtptCkQnz4BHo9LYUDe0w5l0yAyPi6gt74cHkXz6f1KP"
            crossorigin="anonymous">
        </script>
</body>

</html>
