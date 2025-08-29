<?php
include('../includes/header.php');
include('../config/conexion.php');

// si hay carrito
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

// eliminar producto
if (isset($_POST['eliminar'])) {
    $idEliminar = $_POST['producto_id'];
    if (($key = array_search($idEliminar, $_SESSION['carrito'])) !== false) {
        unset($_SESSION['carrito'][$key]);
        $_SESSION['carrito'] = array_values($_SESSION['carrito']); // reindexar asi bien maquiavelico
        echo "<script>alert('Producto eliminado del carrito');</script>";
    }
}

// Si carrito tiene productos, traerlos de la BD
$productosCarrito = [];
$total = 0;

if (!empty($carrito)) {
    $ids = implode(",", array_map("intval", $carrito));
    $sql = "SELECT * FROM producto WHERE id_producto IN ($ids)";
    $resultado = $conn->query($sql);

    while ($fila = $resultado->fetch_assoc()) {
        $productosCarrito[] = $fila;
        $total += $fila['precio'];
    }
}
?>

<div class="container mt-4">
    <h2>Carrito de Compras</h2>
    <hr>

    <?php if (empty($productosCarrito)) { ?>
        <div class="alert alert-info">Tu carrito está vacío.</div>
    <?php } else { ?>
        <div class="row">
            <?php foreach ($productosCarrito as $producto) { ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <img class="card-img-top" 
                             src="data:image/jpeg;base64,<?php echo base64_encode($producto['imagen']); ?>" 
                             alt="<?php echo $producto['nombre']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                            <p class="card-text">
                                <strong>Precio:</strong> Q<?php echo number_format($producto['precio'],2); ?><br>
                                <strong>Stock:</strong> <?php echo $producto['stock']; ?>
                            </p>
                            <form method="POST" action="">
                                <input type="hidden" name="producto_id" value="<?php echo $producto['id_producto']; ?>">
                                <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="mt-4">
            <h4>Total: <span class="text-success">Q<?php echo number_format($total,2); ?></span></h4>
            <button class="btn btn-success mt-2">Completar compra</button>
        </div>
    <?php } ?>
</div>

<?php
include('../includes/footer.php');
?>
