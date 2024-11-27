<?php
session_start();
include_once '../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['title'];            // Título de la respuesta
    $contenido = $_POST['content'];       // Contenido de la respuesta
    $usuario = $_SESSION['usuario'];     // Usuario de la sesión
    $id_pregunta = $_POST['id_pregunta']; // ID de la pregunta 

    try {
        // Obtener el id_usuario correspondiente al nombre de usuario en la sesión
        $sql_user = "SELECT id_usuario FROM tbl_usuarios WHERE nombre_usuario = :usuario";
        $stmt_user = $conexion->prepare($sql_user);
        $stmt_user->bindParam(':usuario', $usuario);
        $stmt_user->execute();
        $user_result = $stmt_user->fetch(PDO::FETCH_ASSOC);

        if ($user_result) {
            $user_id = $user_result['id_usuario'];

            // Validar que la pregunta existe
            $sql_check_pregunta = "SELECT id_preguntas FROM tbl_preguntas WHERE id_preguntas = :id_pregunta";
            $stmt_check_pregunta = $conexion->prepare($sql_check_pregunta);
            $stmt_check_pregunta->bindParam(':id_pregunta', $id_pregunta);
            $stmt_check_pregunta->execute();
            $pregunta_result = $stmt_check_pregunta->fetch(PDO::FETCH_ASSOC);

            if ($pregunta_result) {
                $sql = "INSERT INTO tbl_respuestas (titulo_respuestas, texto_respuestas, id_preguntas, id_usuario, estado_respuestas, fecha_respuestas) 
                        VALUES (:title, :content, :id_pregunta, :user_id, 'no contestada', NOW())";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':title', $titulo);
                $stmt->bindParam(':content', $contenido);
                $stmt->bindParam(':id_pregunta', $id_pregunta);  // Asocia respuesta con la pregunta
                $stmt->bindParam(':user_id', $user_id);  // Asocia respuesta con el usuario
                $stmt->execute();

                header('Location:../paginas/preguntas.php');
            } else {
                echo "La pregunta no existe o no es válida.";
            }
        } else {
            echo "Usuario no encontrado.";
        }
    } catch (PDOException $e) {
        echo "Error al insertar la respuesta: " . $e->getMessage();
    }
}
