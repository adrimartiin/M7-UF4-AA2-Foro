<?php

try{
    $conexion = new PDO('mysql:host=localhost;dbname=bd_foro', 'root', '');
    echo 'Conexión realizada';
}catch(Exception $e){
    echo "Error de conexión —-----> $e";
}
