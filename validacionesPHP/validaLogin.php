<?php
session_start();
include_once '../conexion/conexion.php';

try {
    $usuario = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');

    $_SESSION['usuario'] = $usuario;

    $sql = "SELECT nombre_usuario, psswd_usuario FROM tbl_usuarios WHERE nombre_usuario = :usuario";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($password, $row['psswd_usuario'])) {
        header("Location: ../index.php"); 
        exit();
    } else {
        header("Location: ../index.php?error=1");
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
