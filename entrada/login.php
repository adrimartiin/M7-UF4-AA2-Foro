
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
        <h1 class="login-title">Iniciar Sesión</h1>
        <form action="../validacionesPHP/validaLogin.php" method="POST" id="loginForm" class="login-form">
            <label for="username" class="form-label">Nombre de usuario</label>
            <input type="text" name="username" id="username" placeholder="Nombre de usuario" class="form-input">
            <span class="error-message" id="error-nombre"></span>
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="pwd" id="password" placeholder="Contraseña" class="form-input">
            <span class="error-message" id="error-pwd"></span>
            <button type="submit" class="login-btn">Entrar</button>
            <a href="./register.php" class="register-link">No tienes una cuenta? Registrarse</a>
            <?php
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
                echo "<p class='error-message'>Usuario o contraseña incorrectos </p>";
            }
            ?>
        </form>
    </div>
<script src="../funcionesJS/validaLogin.js"></script>
</body>
</html>