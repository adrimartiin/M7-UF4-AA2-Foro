<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="login-container">
        <h1 class="login-title">Regístrate</h1>
        <form action="../validacionesPHP/validaRegister.php" method="POST" class="login-form" id="registerLogin">
            <label for="nombre_usuario" class="form-label">Nombre de usuario</label>
            <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-input" placeholder="Nombre de usuario">
            <span class="error-message" id="error-nombre"></span>

            <label for="nombreReal" class="form-label">Nombre real</label>
            <input type="text" id="nombreReal" name="nombreReal" class="form-input" placeholder="Nombre">
            <span class="error-message" id="error-nombreReal"></span>

            <label for="numTelefono" class="form-label">Número de teléfono</label>
            <input type="tel" id="numTelefono" name="numTelefono" class="form-input" placeholder="Número de teléfono">
            <span class="error-message" id="error-telefono"></span>

            <label for="password" class="form-label">Contraseña</label>
            <input type="password" id="password" name="pwd" class="form-input" placeholder="Contraseña">
            <span class="error-message" id="error-password"></span>

            <label for="repetirPassword" class="form-label">Repite la contraseña</label>
            <input type="password" id="repetirPassword" name="repetirPassword" class="form-input" placeholder="Repite la contraseña">
            <span class="error-message" id="error-repetirPassword"></span>

            <button type="submit" class="login-btn">Registrarse</button>

            <?php
                if (isset($_GET['error']) && $_GET['error'] == '1') {
                    echo "<p class='error-message'>El nombre de usuario ya existe</p>";
                }
            ?>
        </form>
        <a href="login.php" class="register-link">¿Ya tienes una cuenta? Inicia sesión</a>
    </div>
    <script src="../funcionesJS/validaRegister.js"></script>
</body>
</html>

