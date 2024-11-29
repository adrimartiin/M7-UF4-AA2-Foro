<?php
session_start();
include_once '../conexion/conexion.php';

// Si el usuario no esta logueado mostrar mensaje de error ya que no puede hacer preguntas
if (!isset($_SESSION['usuario'])) {
    // cambiar por sweet alert
    echo "Error! Debes tener usuario para poder hacer preguntas.";
} else {
    ?>

    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/styles.css">
        <title>Hacer Pregunta</title>
        <style>
            .btn-volver {
                background-color: rgb(205, 205, 243);
                color: black;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                font-size: 16px;
                cursor: pointer;
            }

            .btn-volver:hover {
                background-color: rgb(180, 180, 230);
            }
        </style>
    </head>

    <body>
        <div class="login-container">
            <h1 class="login-title">Hacer Pregunta</h1>
            <form action="../acciones/insertar_pregunta.php" method="POST" class="login-form" id="preguntas-form">
                <label for="title" class="form-label">Título de la Pregunta</label>
                <input type="text" id="title" name="title" placeholder="Titulo de la pregunta" class="form-input">
                <span class="error-message" id="error-titulo"></span>
                <label for="content" class="form-label">Detalles de la Pregunta</label>
                <textarea name="content" id="content" placeholder="Detalles de la Pregunta" class="form-control"></textarea>
                <span class="error-message" id="error-content"></span>
                <button type="submit" class="login-btn">Añadir Pregunta</button>
            </form>
            <br><br>

            <button onclick="history.back()" class="btn-volver mt-3">Volver</button>
        </div>
        <script src="../funcionesJS/validaPreguntas.js"></script>
    </body>

    </html>
    <?php
}
?>
