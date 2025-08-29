<?php
include("../includes/header.php");
include("../config/conexion.php");

$txtId = (isset($_POST['txtId'])) ? $_POST['txtId'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtPrecio = (isset($_POST['txtPrecio'])) ? $_POST['txtPrecio'] : "";
$txtStock = (isset($_POST['txtStock'])) ? $_POST['txtStock'] : "";
$action = (isset($_POST['accion'])) ? $_POST['accion'] : "";

switch ($action) {

    case "Agregar":
        $imagenData = null;

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
            $rutaTemporal = $_FILES['imagen']['tmp_name'];
            $imagenData = file_get_contents($rutaTemporal); // leer binario
        }

        // convertir valores a los tipos correctos
        $precio = floatval($txtPrecio);
        $stock  = intval($txtStock);

        $sql = "INSERT INTO producto (nombre, precio, stock, imagen) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $null = NULL; // marcador para bind_param blob
        $stmt->bind_param("sdib", $txtNombre, $precio, $stock, $null);

        if ($imagenData !== null) {
            $stmt->send_long_data(3, $imagenData);
        }

        $stmt->execute();
        $action = "";
        break;

    case "Seleccionar":
        $sql = "SELECT * FROM producto WHERE id_producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $txtId);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $producto = $resultado->fetch_assoc();
        $txtNombre = $producto['nombre'];
        $txtPrecio = $producto['precio'];
        $txtStock = $producto['stock'];
        break;

    case "Modificar":
    $precio = floatval($txtPrecio); // mejor usar floatval
    $stock  = intval($txtStock);

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $rutaTemporal = $_FILES['imagen']['tmp_name'];
        $imagenData = file_get_contents($rutaTemporal);

        $sql = "UPDATE producto 
                SET nombre = ?, precio = ?, stock = ?, imagen = ? 
                WHERE id_producto = ?";
        $stmt = $conn->prepare($sql);

        $null = NULL;
        $stmt->bind_param("sdibi", $txtNombre, $precio, $stock, $null, $txtId);
        $stmt->send_long_data(3, $imagenData);
        $stmt->execute(); // 🚀 AQUÍ ES DONDE SE EJECUTA
    } else {
        $sql = "UPDATE producto 
                SET nombre = ?, precio = ?, stock = ? 
                WHERE id_producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdii", $txtNombre, $precio, $stock, $txtId);
        $stmt->execute(); // 🚀 IMPORTANTE
    }

    $action = "";
    break;



    case "Borrar":
        $sql = "UPDATE producto SET estado = 0 WHERE id_producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $txtId);
        $stmt->execute();
        break;

    case "SubirImagen":
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
            $rutaTemporal = $_FILES['imagen']['tmp_name'];
            $imagenData = file_get_contents($rutaTemporal);

            $sql = "UPDATE producto SET imagen = ? WHERE id_producto = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("bi", $null, $txtId);
            $stmt->send_long_data(0, $imagenData);
            $stmt->execute();
        }
        break;

    default:
        break;
}

// cargar lista de productos activos
$sql = "SELECT * FROM producto WHERE estado = 1";
$resultado = $conn->query($sql);
$listaProductos = [];
while ($fila = $resultado->fetch_assoc()) {
    $listaProductos[] = $fila;
}
?>

<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            Datos del Producto
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtId">ID:</label>
                    <input readonly type="text" class="form-control" name="txtId" id="txtId"
                        value="<?php echo $txtId ?>" placeholder="Ingresa ID">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input required type="text" class="form-control" name="txtNombre" id="txtNombre"
                        value="<?php echo $txtNombre ?>" placeholder="Ingrese Nombre">
                </div>

                <div class="form-group">
                    <label for="txtPrecio">Precio:</label>
                    <input required type="number" step="0.01" class="form-control" name="txtPrecio" id="txtPrecio"
                        value="<?php echo $txtPrecio ?>" placeholder="Ingrese Precio">
                </div>

                <div class="form-group">
                    <label for="txtStock">Stock:</label>
                    <input required type="number" min="0" class="form-control" name="txtStock" id="txtStock"
                        value="<?php echo $txtStock ?>" placeholder="Ingrese cantidad en stock">
                </div>

                <div class="form-group">
                    <label for="imagen">Imagen:</label>
                    <input type="file" class="form-control" name="imagen" id="imagen">
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaProductos as $producto) { ?>
                <tr>
                    <td><?php echo $producto['id_producto']; ?></td>
                    <td><?php echo $producto['nombre']; ?></td>
                    <td>Q. <?php echo number_format($producto['precio'], 2); ?></td>
                    <td><?php echo $producto['stock']; ?></td>
                    <td>
                        <?php if (!empty($producto['imagen'])) { ?>
                            <img src="../../admin/config/mostrar_imagen.php?id=<?php echo $producto['id_producto']; ?>"
                                alt="Producto <?php echo $producto['nombre']; ?>"
                                width="120">
                        <?php } else { ?>
                            <span>Sin imagen</span>
                        <?php } ?>
                    </td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="txtId" value="<?php echo $producto['id_producto']; ?>">
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />
                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
include("../includes/footer.php");
?>