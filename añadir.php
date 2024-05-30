<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombre = $_POST["producto"];
    $cantidad = $_POST["cantidad"];
    $precio = $_POST["precio"];
    $imagen = $_POST["imagen"];
    
    // Crear la conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "estetica", "3306");
    $conexion->set_charset("utf8");
    
    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }
    
    // Preparar la consulta SQL para insertar los datos en la tabla "productos"
    $sql = "INSERT INTO productos (nombre, cantidad, precio, imagen) VALUES ('$nombre', '$cantidad', '$precio', '$imagen')";
    
    // Ejecutar la consulta SQL
    $result = $conexion->query($sql);
    
    // Verificar si la consulta se ejecutó correctamente
    if ($result === TRUE) {
        echo "Producto registrado correctamente";
    } else {
        echo "Error al registrar el producto: " . $conexion->error;
    }
    
    // Cerrar la conexión
    $conexion->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" type="text/css" href="Estilos/style.css">
</head>

<body class="text-bg-secondary p-3">
<div class="blob"></div>
    <div class="wrapper">
        <form action="" method="post">
            <h2>Añadir Producto</h2>
            <div class="input-box">
                    <label for="exampleInputEmail1" class="form-label">Nombre del Producto</label>
                    <input type="text" class="form-control" id="producto" name="producto">
                </div>
                <div class="input-box">
                    <label for="exampleInputEmail1" class="form-label">Cantidad</label>
                    <input type="text" class="form-control" id="cantidad" name="cantidad">
                </div>
                <div class="input-box">
                    <label for="exampleInputEmail1" class="form-label">Precio</label>
                    <input type="text" class="form-control" id="precio" name="precio">
                </div>
                <div class="input-box">
                    <label for="exampleInputEmail1" class="form-label">URL de la Imagen</label>
                    <input type="text" class="form-control" id="imagen" name="imagen">
                </div>
                
                <a href="Productos.php" class="btn btn-outline-danger">Cancelar</a>
                <button type="submit" class="btn btn-success">Registrar Producto</button>
        </form>
    </div>
    <script src="script.js"></script>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
</body>
</html>
