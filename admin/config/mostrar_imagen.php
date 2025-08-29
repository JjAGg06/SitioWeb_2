<?php
include("../config/conexion.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT imagen FROM producto WHERE id_producto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($imagen);
    $stmt->fetch();
    $stmt->close();

    if ($imagen) {
        header("Content-Type: image/jpeg"); // cambiar a image/png
        echo $imagen;
    } else {
        // mostrar una imagen por defecto si no hay
        header("Content-Type: image/png");
        readfile("../imagenes/no-image.png");
    }
}
?>
