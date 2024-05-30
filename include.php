<?php
    $conexion = new mysqli("localhost", "root", "", "estetica", "3306");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    $conexion->set_charset("utf8");
    $sql = "SELECT id, nombre, cantidad, precio, imagen FROM productos";
    $result = $conexion->query($sql);
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar_id'])) {
        $id_producto = $_POST['eliminar_id'];
        $sql_eliminar = "DELETE FROM productos WHERE id = $id_producto";

        if ($conexion->query($sql_eliminar) === TRUE) {
            header("Location: Productos.php");
            exit();
        } else {
            echo "Error al eliminar el producto: " . $conexion->error;
        }
    }
    ?>