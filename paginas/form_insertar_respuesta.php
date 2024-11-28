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

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Respuesta</title>
</head>

<body>
    <h1>Insertar Respuesta</h1>

    <form action="../acciones/insertar_respuesta.php" method="POST">
        <input type="hidden" name="id_pregunta" value="<?php echo $id_pregunta; ?>">

        <label for="title">Título de la respuesta</label>
        <input type="text" name="title" required><br>

        <label for="content">Contenido de la respuesta</label><br>
        <textarea name="content" required></textarea><br>

        <button type="submit">Enviar respuesta</button>
    </form>
</body>

</html>
