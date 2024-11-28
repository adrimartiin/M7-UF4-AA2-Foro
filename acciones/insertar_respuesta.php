<?php
session_start();
include_once '../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure session is active and the user is logged in
    if (!isset($_SESSION['usuario'])) {
        die("Usuario no autenticado.");
    }

    // Get form values
    $titulo = $_POST['title'];
    $contenido = $_POST['content'];
    $usuario = $_SESSION['usuario'];
    $id_pregunta = $_POST['id_pregunta'];

    try {
        // Get user ID
        $stmt_user = $conexion->prepare("SELECT id_usuario FROM tbl_usuarios WHERE nombre_usuario = :usuario");
        $stmt_user->bindParam(':usuario', $usuario);
        $stmt_user->execute();
        $user_result = $stmt_user->fetch(PDO::FETCH_ASSOC);

        if ($user_result) {
            $user_id = $user_result['id_usuario'];

            // Insert the response into the database
            $sql = "INSERT INTO tbl_respuestas (titulo_respuestas, texto_respuestas, id_preguntas, id_usuario, estado_respuestas, fecha_respuestas)
                    VALUES (:title, :content, :id_pregunta, :user_id, 'no contestada', NOW())";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':title', $titulo);
            $stmt->bindParam(':content', $contenido);
            $stmt->bindParam(':id_pregunta', $id_pregunta);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            // Redirect to the question page after the response is inserted
            header('Location: ../paginas/preguntas.php');
        } else {
            echo "Usuario no encontrado.";
        }
    } catch (PDOException $e) {
        echo "Error al insertar la respuesta: " . $e->getMessage();
    }
}
?>
