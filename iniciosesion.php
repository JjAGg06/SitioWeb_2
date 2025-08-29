<?php
if (!defined('NOMBRE_SITIO')) {
    include_once(__DIR__ . '/config/config.php');
}

session_start();

if ($_POST) {
    include_once(__DIR__ . '/config/conexion.php'); // conexión mysqli

    $usuario = $_POST['txtUsuario'];
    $contra = $_POST['txtContra'];

    // Consulta a la BD
    $sql = "SELECT * FROM usuario WHERE username = ? AND contra = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usuario, $contra);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($row = $resultado->fetch_assoc()) {
        // Usuario encontrado, ahora validamos su tipo
        if ($row['tipo'] === "user") {
            // Solo admins pueden entrar aquí
            $_SESSION['usuario'] = "ok";
            $_SESSION['nombreUsuario'] = $row['username'];
            $_SESSION['tipoUsuario'] = $row['tipo'];

            header("Location: index.php"); // index del admin
            exit;
        } else {
            $mensaje = "Ingrese un usuario cliente";
        }
    } else {
        $mensaje = "Las credenciales son inválidas";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="<?php echo URL_BASE ?>/assets/css/bootstrap.min.css" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <br><br><br>
                <div class="card">
                    <div class="card-header">
                        Inicia Sesion
                    </div>
                    <div class="card-body">
                        <?php if (!empty($mensaje)) { ?>
                            <div class="alert alert-danger">
                                <?php echo $mensaje; ?>
                            </div>
                        <?php } ?>
                        <form method="POST">
                            <div class="form-group">
                                <label for="txtUsuario">Usuario</label>
                                <input required type="text" class="form-control" name="txtUsuario" id="txtUsuario" placeholder="Ingrese Usuario">

                            </div>
                            <div class="form-group">
                                <label for="txtContra">Contraseña</label>
                                <input required type="password" class="form-control" name="txtContra" id="txtContra" placeholder="Contraseña">
                            </div>
                            <button type="submit" class="btn btn-primary">Iniciar Sesion</button>
                        </form>


                    </div>

                </div>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>

</body>

</html>