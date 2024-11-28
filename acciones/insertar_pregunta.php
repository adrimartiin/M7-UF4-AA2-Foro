<?php
session_start();
include_once '../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['title'];
    $contenido = $_POST['content'];
    $usuario = $_SESSION['usuario']; 

    try {
        // Obtener el id_usuario correspondiente al nombre de usuario en la sesión
        $sql_user = "SELECT id_usuario FROM tbl_usuarios WHERE nombre_usuario = :usuario";
        $stmt_user = $conexion->prepare($sql_user);
        $stmt_user->bindParam(':usuario', $usuario);
        $stmt_user->execute();
        $user_result = $stmt_user->fetch(PDO::FETCH_ASSOC);

        if ($user_result) {
            $user_id = $user_result['id_usuario'];

            // Insertar la pregunta con el id_usuario correspondiente
            $sql = "INSERT INTO tbl_preguntas (titulo_preguntas, texto_preguntas, id_usuario, fecha_preguntas) 
                    VALUES (:title, :content, :user_id, NOW())";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':title', $titulo);
            $stmt->bindParam(':content', $contenido);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            header('Location:../paginas/preguntas.php');
        } 
    } catch (PDOException $e) {
        echo "Error al haacer la pregunta: " . $e->getMessage();
    }
}
