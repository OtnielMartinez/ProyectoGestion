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
    }
}

// Muestra el carrito de compras
echo '<div class="carrito-container">';
echo '<h2>Carrito de Compras</h2>';

if (!empty($_SESSION['carrito'])) {
    echo '<form method="post" action="?action=modificar">';
    echo '<table class="carrito-table">';
    echo '<tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Cantidad</th><th>Total</th><th>Acciones</th></tr>';

    // Conecta a la base de datos
    include 'conexion.php';

    // Obtiene los productos en el carrito
    $productosCarrito = array_keys($_SESSION['carrito']);
    $productosIds = implode(',', $productosCarrito);

    $consultaCarrito = "SELECT id, nombre, precio FROM productos WHERE id IN ($productosIds)";
    $resultadoCarrito = $conexion->query($consultaCarrito);

    $totalCarrito = 0;

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
        echo '<td><input type="number" name="cantidad[' . $productoId . ']" value="' . $cantidad . '" min="1"></td>';
        echo '<td>$' . number_format($totalProducto, 2) . '</td>';
        echo '<td><a href="?action=eliminar&id=' . $productoId . '">Eliminar</a></td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '<p class="carrito-total">Total: $' . number_format($totalCarrito, 2) . '</p>';
    echo '<input type="submit" name="actualizar" value="Actualizar Cantidad">';
    echo '</form>';
    echo '<p><a href="?action=limpiar">Limpiar Carrito</a></p>';
} else {
    echo '<p>El carrito de compras está vacío.</p>';
}

echo '</div>';
?>

