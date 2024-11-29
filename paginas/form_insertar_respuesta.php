<?php
session_start();
include_once '../conexion/conexion.php';

// Get the question ID from the POST request
if (isset($_POST['id_pregunta'])) {
    $id_pregunta = $_POST['id_pregunta'];
} else {
    die("ID de la pregunta no proporcionado");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Insertar Respuesta</title>
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
        <h1 class="login-title">Insertar Respuesta</h1>
        <form action="../acciones/insertar_respuesta.php" method="POST" class="login-form" id="formRespuesta">
            <input type="hidden" name="id_pregunta" value="<?php echo $id_pregunta; ?>">

            <label for="title" class="form-label">Título de la Respuesta</label>
            <input type="text" id="title" name="title" placeholder="Título de la respuesta" class="form-input">
            <span class="error-message" id="title-error"></span>

            <label for="content" class="form-label">Detalles de la Respuesta</label>
            <textarea name="content" id="content" placeholder="Detalles de la respuesta" class="form-control"></textarea>
            <span class="error-message" id="content-error"></span>

            <button type="submit" class="login-btn">Enviar Respuesta</button>
        </form>
        <br><br>

        <button onclick="history.back()" class="btn-volver mt-3">Volver</button>
    </div>
    <script src="../funcionesJS/validaRespuestas.js"></script>
</body>

</html>
