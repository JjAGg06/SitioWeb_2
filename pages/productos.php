<?php
include('../includes/header.php');
include('../config/conexion.php');

// cargar lista de productos
$sql = "SELECT * FROM producto WHERE estado = 1";
$resultado = $conn->query($sql);
$listaProductos = [];
while ($fila = $resultado->fetch_assoc()) {
    $listaProductos[] = $fila;
}

// manejo del carrito
if (isset($_POST['agregar'])) {
    $idProducto = $_POST['producto_id'];

    if (!isset($_SESSION['usuario'])) {
        echo "<script>alert('Necesitas iniciar sesión para agregar al carrito');</script>";
    } else {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        if (!in_array($idProducto, $_SESSION['carrito'])) {
            $_SESSION['carrito'][] = $idProducto;
            echo "<script>alert('Producto agregado al carrito');</script>";
        } else {
            echo "<script>alert('ℹEl producto ya está en el carrito');</script>";
        }
    }
}
?>

<div class="row">
<?php foreach ($listaProductos as $producto) {
    $sinStock = ($producto['stock'] <= 0);
?>
    <div class="col-md-3">
        <div class="card <?php echo $sinStock ? 'opacity-50' : ''; ?>">
            <img class="card-img-top" 
                 src="data:image/jpeg;base64,<?php echo base64_encode($producto['imagen']); ?>" 
                 alt="<?php echo $producto['nombre']; ?>">
            <div class="card-body">
                <h4 class="card-title"><?php echo $producto['nombre']; ?></h4>
                <p class="card-text">
                    <strong>Precio:</strong> Q<?php echo number_format($producto['precio'],2); ?><br>
                    <strong>Stock:</strong> <?php echo $sinStock ? "<span class='text-danger'>Sin Stock</span>" : $producto['stock']; ?>
                </p>

                <?php if (!$sinStock) { ?>
                    <form method="POST" action="">
                        <input type="hidden" name="producto_id" value="<?php echo $producto['id_producto']; ?>">
                        <button type="submit" name="agregar" class="btn btn-primary">Agregar al carrito</button>
                    </form>
                <?php } else { ?>
                    <button class="btn btn-secondary" disabled>Sin Stock</button>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
</div>

<?php
include('../includes/footer.php');
?>