<?php
session_start();
include_once '../conexion/conexion.php';

if (!isset($_SESSION['usuario'])) {
    echo 'Error! Debes loguearte para ver preguntas guardadas';
    exit;
}

try {
    // Obtener ID del usuario logueado
    $usuario = $_SESSION['usuario'];
    $stmt_usuario = $conexion->prepare("SELECT id_usuario FROM tbl_usuarios WHERE nombre_usuario = :nombre_usuario");
    $stmt_usuario->bindParam(':nombre_usuario', $usuario);
    $stmt_usuario->execute();
    $resultado_usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);

    if (!$resultado_usuario) {
        echo "Error: Usuario no encontrado.";
        exit;
    }

    $id_usuario = $resultado_usuario['id_usuario'];

    // Consultar preguntas guardadas
    $stmt = $conexion->prepare("
        SELECT titulo_preguntas, texto_preguntas, nombre_usuario, fecha_preguntas
        FROM tbl_preguntas
        INNER JOIN tbl_usuarios ON tbl_preguntas.id_usuario = tbl_usuarios.id_usuario
        WHERE guardar_preguntas = 'guardada' AND tbl_preguntas.id_usuario = :id_usuario
    ");
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->execute();
    $guardados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar preguntas guardadas
    if (empty($guardados)) {
        echo "No tienes preguntas guardadas en este momento.";
    } else {
        echo '<ul>';
        foreach ($guardados as $pregunta) {
            echo '<li>';
            echo '<strong>Título:</strong> ' . htmlspecialchars($pregunta['titulo_preguntas']) . '<br>';
            echo '<strong>Texto:</strong> ' . htmlspecialchars($pregunta['texto_preguntas']) . '<br>';
            echo '<strong>Usuario:</strong> ' . htmlspecialchars($pregunta['nombre_usuario']) . '<br>';
            echo '<strong>Fecha:</strong> ' . htmlspecialchars($pregunta['fecha_preguntas']) . '<br>';
            echo '</li>';
        }
        echo '</ul>';
    }
} catch (PDOException $e) {
    echo 'Error en la consulta: ' . $e->getMessage();
}
?>
