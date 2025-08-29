<?php
if(!defined('NOMBRE_SITIO')){
    include_once(__DIR__ . '/../../config/config.php');
}

session_start();
if(!isset($_SESSION['usuario'])){
    header("location: " . URL_BASE . "admin/inicioSesion.php");
    exit;
}else{
    if($_SESSION['usuario'] == 'ok'){
        $nombreUsuario = $_SESSION["nombreUsuario"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitio Web 2</title>
    <link rel="stylesheet" href="<?php echo URL_BASE ?>/assets/css/bootstrap.min.css"/>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <ul class="nav navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#"><span class="sr-only">Sitio Web</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URL_BASE?>admin/">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URL_BASE?>admin/pages/productos.php">Productos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URL_BASE?>index.php">Ingresar como Cliente</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger" href="<?php echo URL_BASE?>admin/iniciosesion.php">Cerrar sesión</a>
            </li>
        </ul>
    </nav>
    <br>
    <div class="container">
        <div class="row">
