
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="login-container">
        <h1>Iniciar Sesión</h1>
        <form action="../validacionesPHP/validaLogin.php" method="POST">
            <label for="username">Nombre de usuario</label>
            <input type="text" name="username" placeholder="Nombre de usuario">
            <label for="username">Contraseña</label>
            <input type="password" name="pwd" placeholder="Contraseña">
            <button type="submit" class="login-btn">Entrar</button>
            <a href="./register.php">No tienes una cuenta? Registrarse</a>
            <?php
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
                echo "<p style='color: red'>Usuario o contraseña incorrectos </p>";
            }
            ?>
        </form>
    </div>
</body>
</html>
