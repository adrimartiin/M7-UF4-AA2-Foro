<?php
session_start();
include_once '../conexion/conexion.php';
$id_pregunta = $_POST['idPregunta'];
$usuario = $_SESSION['usuario'];


if (!isset($usuario)) {
    echo 'Error: debes tener usuario para poder guardar preguntas';
} else {
    try {
        // ==== QUERY PARA COMPROBAR QUE EL ESTADO DE LA PREGUNTA ES NO GUARDADA ====
        $sql = 'SELECT guardar_preguntas, id_usuario FROM tbl_preguntas WHERE id_preguntas = :id_pregunta';
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id_pregunta', $id_pregunta);
        $stmt->execute();
        $resultado_pregunta = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Verificar query devuelve algo
        if (!$resultado_pregunta) {
            echo "Error: la pregunta no existe.";
            exit;
        }
    
        // ==== QUERY PARA COMPROBAR EL USUARIO QUE INTENTA GUARDAR LA PREGUNTA ====
        $sql_usuario = "SELECT id_usuario, nombre_usuario FROM tbl_usuarios WHERE nombre_usuario = :nombre_usuario";
        $stmt_usuario = $conexion->prepare($sql_usuario);
        $stmt_usuario->bindParam(":nombre_usuario", $usuario);
        $stmt_usuario->execute();
        $resultado_usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
    
        // Verificar query devuelve algo
        if (!$resultado_usuario) {
            echo "Error: el usuario no existe.";
            exit;
        }
    
        /* === SI LA PREGUNTA NO ESTA GUARDADA Y EL USUARIO QUE INTENTA GUARDARLA ES DIFERENTE AL LOGUEADO 
        SE ACTUALIZA EL ESTADO DE LA PREGUNTA A GUARDADA SINO MUESTRA MENSAJE DE ERROR === */
        if ($resultado_pregunta['guardar_preguntas'] === 'no guardada' && $resultado_usuario['id_usuario'] != $resultado_pregunta['id_usuario']) {
            $sql_update = "UPDATE tbl_preguntas SET guardar_preguntas = 'guardada' WHERE id_preguntas = :id_pregunta";
            $stmt_update = $conexion->prepare($sql_update);
            $stmt_update->bindParam(':id_pregunta', $id_pregunta);
            $stmt_update->execute();
            echo "Pregunta guardada exitosamente.";
        } else {
            // cambiar por sweet alert
            echo "Error: no puedes guardar tu propia pregunta o la pregunta ya está guardada.";
        }
    
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}



