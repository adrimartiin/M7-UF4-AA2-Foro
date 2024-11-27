<?php
if (isset($_GET['id'])) {
    $id_usuario = intval($_GET['id']); 
    echo "ID del usuario seleccionado: " . $id_usuario;
}
?>
