<?php
session_start();
include_once '../conexion/conexion.php';

try {
    $usuario = filter_input(INPUT_POST, 'username');
    $pwd = filter_input(INPUT_POST, 'pwd');

    $_SESSION['usuario'] = $usuario;

    $sql = "SELECT nombre_usuario, psswd_usuario FROM tbl_usuarios WHERE nombre_usuario = :usuario";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR); 
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($pwd, $row['psswd_usuario'])) {
        header("Location: ../paginaBienvenida.php"); 
        exit();
    } else {
        header("Location: ../entrada/login.php?error=1"); 
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
