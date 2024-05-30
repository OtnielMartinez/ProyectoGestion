<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["producto"];
    $cantidad = $_POST["cantidad"];
    $precio = $_POST["precio"];
    $conexion = new mysqli("localhost", "root", "", "estetica", 3306);
    $conexion->set_charset("utf8");
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }
    
    // Obtener el id_producto del formulario
    $id_producto = $_POST["id_producto"];
    $sql = "UPDATE productos SET nombre='$nombre', cantidad='$cantidad', precio='$precio' WHERE id=$id_producto";
    $result = $conexion->query($sql);
    if ($result === TRUE) {
        // Producto actualizado correctamente
        $conexion->close();
        header("Location: Productos.php"); // Redireccionar a Productos.php
        exit();
    } else {
        echo "Error al actualizar el producto: " . $conexion->error;
    }
    $conexion->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Producto</title>
    <link rel="stylesheet" type="text/css" href="Estilos/style.css">
</head>
<body class="text-bg-secondary p-3">
    <div class="blob"></div>
    <div class="wrapper">
        <div class="container formLogin text-bg-info p-5">
            <div class="alert alert-secondary lb-login" role="alert"></div>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // El formulario ya fue procesado y redirigido, no se necesita mostrar nada aquí.
            } else {
                // Si no es una solicitud POST, muestra el formulario para editar el producto
                $id_producto = isset($_GET['id']) ? $_GET['id'] : null;
                
                if (!$id_producto) {
                    die("ID del producto no especificado.");
                }
                
                $conexion = new mysqli("localhost", "root", "", "estetica", 3306);
                $conexion->set_charset("utf8");
                if ($conexion->connect_error) {
                    die("Conexión fallida: " . $conexion->connect_error);
                }
                $sql = "SELECT nombre, cantidad, precio FROM productos WHERE id = $id_producto";
                $result = $conexion->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $nombre_actual = $row["nombre"];
                    $cantidad_actual = $row["cantidad"];
                    $precio_actual = $row["precio"];
                } else {
                    die("No se encontró ningún producto con el ID especificado.");
                }
                ?>
                <form action="editar.php" method="post">
                    <h2>Actualizar Producto</h2>
                    <div class="input-box">
                        <label for="producto" class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control" id="producto" name="producto" value="<?php echo $nombre_actual; ?>">
                    </div>
                    <div class="input-box">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="text" class="form-control" id="cantidad" name="cantidad" value="<?php echo $cantidad_actual; ?>">
                    </div>
                    <div class="input-box">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="text" class="form-control" id="precio" name="precio" value="<?php echo $precio_actual; ?>">
                    </div>
                    <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                    <a href="Productos.php" class="btn btn-outline-danger">Cancelar</a>
                    <button type="submit" class="btn btn-success">Actualizar Producto</button>
                </form>
                <?php
            }
            ?>
        </div>
    </div>
</body>
</html>

