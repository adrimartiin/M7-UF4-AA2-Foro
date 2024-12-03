<?php
session_start();
include_once '../conexion/conexion.php';

// Verificar si el usuario está configurado en la sesión
if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Debes iniciar sesión para poder guardar preguntas.',
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

// Asignar el usuario de la sesión a la variable $usuario
$usuario = $_SESSION['usuario'];

$id_pregunta = $_POST['idPregunta'] ?? null; // Validar si se recibió el ID de la pregunta
if (!$id_pregunta) {
    echo "Error: No se recibió el ID de la pregunta.";
    exit();
}

try {
    // Verificar estado de la pregunta
    $sql = 'SELECT guardar_preguntas, id_usuario FROM tbl_preguntas WHERE id_preguntas = :id_pregunta';
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_pregunta', $id_pregunta);
    $stmt->execute();
    $resultado_pregunta = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$resultado_pregunta) {
        echo "Error: la pregunta no existe.";
        exit();
    }

    // Obtener ID del usuario logueado
    $sql_usuario = "SELECT id_usuario FROM tbl_usuarios WHERE nombre_usuario = :nombre_usuario";
    $stmt_usuario = $conexion->prepare($sql_usuario);
    $stmt_usuario->bindParam(":nombre_usuario", $usuario);
    $stmt_usuario->execute();
    $resultado_usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);

    if (!$resultado_usuario) {
        echo "Error: el usuario no existe.";
        exit();
    }

    $id_usuario_actual = $resultado_usuario['id_usuario'];

    // Verificar condiciones para guardar la pregunta
    if ($resultado_pregunta['guardar_preguntas'] === 'no guardada' && $resultado_pregunta['id_usuario'] != $id_usuario_actual) {
        // Actualizar estado de la pregunta a 'guardada' asignada al usuario actual
        $sql_update = "UPDATE tbl_preguntas SET guardar_preguntas = 'guardada' WHERE id_preguntas = :id_pregunta";
        $stmt_update = $conexion->prepare($sql_update);
        $stmt_update->bindParam(':id_pregunta', $id_pregunta);
        $stmt_update->execute();

        echo "Pregunta guardada correctamente.";
    } else {
        echo "Error: no puedes guardar tu propia pregunta o la pregunta ya está guardada.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
