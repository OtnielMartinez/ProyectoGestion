<?php
session_start();

// Inicializa el carrito de compras si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

// Acciones
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'agregar':
            if (isset($_GET['id'])) {
                // Agrega el producto al carrito
                $productoId = $_GET['id'];
                if (array_key_exists($productoId, $_SESSION['carrito'])) {
                    $_SESSION['carrito'][$productoId]++;
                } else {
                    $_SESSION['carrito'][$productoId] = 1;
                }
            }
            break;

        case 'eliminar':
            if (isset($_GET['id'])) {
                // Elimina el producto del carrito
                $productoId = $_GET['id'];
                unset($_SESSION['carrito'][$productoId]);
            }
            break;

        case 'limpiar':
            // Limpia el carrito
            $_SESSION['carrito'] = array();
            break;

        case 'modificar':
            if (isset($_POST['actualizar'])) {
                // Actualiza las cantidades del carrito
                foreach ($_POST['cantidad'] as $productoId => $cantidad) {
                    $_SESSION['carrito'][$productoId] = $cantidad;
                }
            }
            break;

            case 'comprar':
                // Realizar compra
                if (!empty($_SESSION['carrito'])) {
                    // Conecta a la base de datos
                    include 'conexion.php'; // Asegúrate de tener un archivo de conexión adecuado
                    
                    // Obtener el ID del usuario (sustituye esto por tu lógica de obtención de ID de usuario)
                    $usuarioId = 1; // Por ejemplo, asumamos que el ID del usuario es 1
            
                    // Prepara la consulta para insertar en la tabla de compras
                    $consultaInsertarCompra = $conexion->prepare("INSERT INTO compras (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)");
                    
                    // Itera sobre los productos en el carrito y ejecuta la consulta para cada uno
                    foreach ($_SESSION['carrito'] as $productoId => $cantidad) {
                        // Inserta la compra en la base de datos
                        $consultaInsertarCompra->bind_param("iii", $usuarioId, $productoId, $cantidad);
                        if (!$consultaInsertarCompra->execute()) {
                            echo "Error al insertar datos en la tabla de compras: " . $conexion->error;
                            exit();
                        }
                    }
            
                    // Cierra la conexión
                    $conexion->close();
            
                    // Limpia el carrito
                    $_SESSION['carrito'] = array();
            
                    // Redirige al usuario a una página de confirmación
                    header("Location: confirmacion_compra.php");
                    exit();
                }
                break;
            
    }
}
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title >Catálogo de Productos</title>
    <link rel="stylesheet" type="text/css" href="Estilos/catalogo.css">

</head>
<body>
    <div class="header">
        <h2>Catálogo de Productos</h2>
        <button onclick="window.location.href='inicio.php'">Volver a Inicio</button>
    </div>

    <div class="catalogo-container">
    <table class="producto-table">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Agregar al carrito</th>
                <th>Eliminar del carrito</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Conecta a la base de datos
            include 'conexion.php';
            
            // Prepara y ejecuta la consulta SQL
            $sql = "SELECT id, nombre, cantidad, precio, imagen FROM productos";
            $result = $conexion->query($sql);
            
            // Muestra los productos en la tabla
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td><img src="' . $row['imagen'] . '" alt="' . $row['nombre'] . '" width="75" height="75"></td>';
                echo '<td>' . $row['nombre'] . '</td>';
                echo '<td>$' . $row['precio'] . '</td>';
                echo '<td>' . $row['cantidad'] . '</td>';
                echo '<td><a href="?action=agregar&id=' . $row['id'] . '" class="btn-link agregar">Agregar al carrito</a></td>';
                echo '<td><a href="?action=eliminar&id=' . $row['id'] . '" class="btn-link eliminar">Eliminar del carrito</a></td>';

                echo '</tr>';
            }
            
            // Cierra la conexión
            $conexion->close();
            ?>
        </tbody>
    </table>
</div>


<div class="carrito-container">
    <h2>Carrito de Compras</h2>
    <?php
    if (!empty($_SESSION['carrito'])) {
        echo '<form method="post" action="?action=modificar">';
        echo '<table class="carrito-table">';
        echo '<tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Cantidad</th><th>Total</th><th>Acciones</th></tr>';

        // Conecta a la base de datos
        // Incluye tu archivo de conexión a la base de datos aquí
        include 'conexion.php';

        // Obtiene los productos en el carrito
        $productosCarrito = array_keys($_SESSION['carrito']);
        if (!empty($productosCarrito)) { // Verifica si la lista de IDs no está vacía
            $productosIds = implode(',', $productosCarrito);

            $consultaCarrito = "SELECT id, nombre, precio FROM productos WHERE id IN ($productosIds)";
            $resultadoCarrito = $conexion->query($consultaCarrito);

            $totalCarrito = 0;

            // Muestra los productos en el carrito
            while ($filaCarrito = $resultadoCarrito->fetch_assoc()) {
                $productoId = $filaCarrito['id'];
                $nombre = $filaCarrito['nombre'];
                $precio = $filaCarrito['precio'];
                $cantidad = $_SESSION['carrito'][$productoId];
                $totalProducto = $precio * $cantidad;

                $totalCarrito += $totalProducto;

                echo '<tr>';
                echo '<td>' . $productoId . '</td>';
                echo '<td>' . $nombre . '</td>';
                echo '<td>$' . $precio . '</td>';
                echo '<td><input type="number" name="cantidad[' . $productoId . ']" value="' . $cantidad . '" min="1", " max="cantidad"></td>';
                echo '<td>$' . number_format($totalProducto, 2) . '</td>';
                echo '<td><a href="?action=eliminar&id=' . $productoId . '" class="btn-link eliminar">Eliminar</a></td>';
                echo '</tr>';
            }

            echo '</table>';
            echo '<p class="carrito-total">Total: $' . number_format($totalCarrito, 2) . '</p>';
            echo '<input type="submit" name="actualizar" value="Actualizar Cantidad" class="boton-actualizar">';
            echo '<input type="submit" name="comprar" value="Comprar" class="boton-comprar">';

            echo '</form>';
            echo '<p><a href="?action=limpiar" class="btn-link limpiar">Limpiar Carrito</a></p>';
        } else {
            echo '</table>';
            echo '<p>El carrito de compras está vacío.</p>';
        }
    } else {
        echo '<p>El carrito de compras está vacío.</p>';
    }
    ?>
</div>
</body>
</html>