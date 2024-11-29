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
    <title>Insertar Respuesta</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-volver {
            background-color: rgb(205, 205, 243);
            color: black;
        }
        .btn-volver:hover {
            background-color: rgb(180, 180, 230);
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Insertar Respuesta</h1>

        <form action="../acciones/insertar_respuesta.php" method="POST" class="shadow p-4 rounded bg-light">
            <input type="hidden" name="id_pregunta" value="<?php echo $id_pregunta; ?>">

            <div class="mb-3">
                <label for="title" class="form-label">Título de la respuesta</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Contenido de la respuesta</label>
                <textarea name="content" class="form-control" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">Enviar respuesta</button>
        </form>

        <a href="javascript:history.back()" class="btn btn-volver w-100 mt-3">Volver</a>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
