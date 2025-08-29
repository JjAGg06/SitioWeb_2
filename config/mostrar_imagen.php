<?php
include('../config/conexion.php');

if(isset($_GET['id'])){
    $id = intval($_GET['id']);

    $sql = "SELECT imagen FROM producto WHERE id_producto = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($row = $resultado->fetch_assoc() && !empty($row['imagen'])){
        // Enviar cabecera correcta
        header("Content-Type: image/jpeg"); // si todas tus imágenes son jpeg
        echo $row['imagen']; // enviar el binario directamente
        exit;
    } else {
        // Imagen por defecto si no hay BLOB
        header("Content-Type: image/png");
        readfile('../assets/img/default.png');
        exit;
    }
}
?>