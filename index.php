<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="./css/styles.css" rel="stylesheet">
    <title>CodePlus</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="./img/nav_logo.png" id="nav_img" alt="Logo"></a>
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
            <form action = "./paginas/cerrar_sesion.php" method = "POST">
                <input type="submit" value="Logout" class="btn btn-primary ms-3" name="logout">
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="barra-izquierda">
            <a href="./paginas/verUsuarios.php" name="usuarios" class="d-flex align-items-center text-decoration-none">
                <i class="fa-solid fa-users me-2"></i><span>Usuarios</span>
            </a>
            <br>
            <a href="#" name="discusiones" class="d-flex align-items-center text-decoration-none">
                <i class="fa-solid fa-comments me-2"></i><span>Discusiones</span>
            </a>
            <br>
            <a href="./paginas/preguntas.php" name="preguntas" class="d-flex align-items-center text-decoration-none">
                <i class="fa-solid fa-question-circle me-2"></i><span>Preguntas</span>
            </a>
            <br>
            <a href="#" name="guardados" class="d-flex align-items-center text-decoration-none">
                <i class="fa-solid fa-bookmark me-2"></i><span>Guardados</span>
            </a>
        </div>
        <div class="barra-derecha">
            <div class="central-content">
                <div class="left-content">
                    <h2>¡Todo <span class="highlight">Programador</span> necesita CodePlus!</h2>
                    <p class="description">CodePlus es una comunidad de programadores que te ayuda a aprender, compartir
                        y mejorar tus habilidades.</p>
                    <div class="buttons">
                        <button class="btn btn-primary btn-sm">Sign Up</button>
                        <a class="btn btn-link fs-6" role="button">Visitar la comunidad</a>
                    </div>
                </div>
                <div class="right-content">
                    <img src="./img/index_div.png" alt="Imagen de ejemplo">
                </div>
            </div>
        </div>


</body>

</html>
