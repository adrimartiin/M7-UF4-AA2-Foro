<?php
include_once '../conexion/conexion.php';

try {
    $username = filter_input(INPUT_POST, 'nombre_usuario');
    $nombreReal = filter_input(INPUT_POST, 'nombreReal');
    $telf = filter_input(INPUT_POST, 'numTelefono');
    $pwd = filter_input(INPUT_POST, 'pwd');
    $repetirPassword = filter_input(INPUT_POST, 'repetirPassword');

    $encriptedPsswd = password_hash($pwd, PASSWORD_BCRYPT);

    $sql = "SELECT nombre_usuario FROM tbl_usuarios WHERE nombre_usuario = :username";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $usuarioExistente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuarioExistente) {
        header('Location: ../entrada/register.php?error=1');
        exit();
    } else {
        $sql = "INSERT INTO tbl_usuarios (nombre_usuario, nombreReal_usuario, telf_usuario, psswd_usuario) 
                VALUES (:username, :nombreReal, :telf, :pwd)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':nombreReal', $nombreReal, PDO::PARAM_STR);
        $stmt->bindParam(':telf', $telf, PDO::PARAM_STR);
        $stmt->bindParam(':pwd', $encriptedPsswd, PDO::PARAM_STR);
        $stmt->execute();

        header('Location: ../entrada/login.php');
        exit();
    }
} catch (PDOException $e) {
    error_log("Error en el registro: " . $e->getMessage(), 0);
    header('Location: ../entrada/register.php?error=server_error');
    exit();
}
?>
