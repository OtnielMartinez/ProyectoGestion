<?php
        $conexion = new mysqli("localhost", "root", "", "estetica", "3306");
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }
        $conexion->set_charset("utf8");
        $sql = "SELECT id, fecha, hora, nombre_usuario, servicio FROM citas ORDER BY id DESC";
        $result = $conexion->query($sql);
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar_id'])) {
            $id_producto = $_POST['eliminar_id'];
            $sql_eliminar = "DELETE FROM citas WHERE id = $id_producto";
    
            if ($conexion->query($sql_eliminar) === TRUE) {
                header("Location: Citas.php");
                exit();
            } else {
                echo "Error al eliminar cita: " . $conexion->error;
            }
        }
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Estilos/admin.css">
    <title>Agenda de Citas</title>
</head>

<body>
    <nav class="navbar">
        <div class="nav navbar-nav">
            <button class="nav-item nav-link" onclick="window.location.href='admin.php'">Inicio</button>
            <button class="nav-item nav-link" onclick="window.location.href='Productos.php'">Productos</button>
            <button class="nav-item nav-link active" onclick="window.location.href='Citas.php'">Citas</button>
            <button class="nav-item nav-link" onclick="window.location.href='login.php'">Cerrar sesión</button>
        </div>
    </nav>

    <div class="container">
        <h2>Agenda de Citas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Cliente</th>
                    <th>Servicio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["fecha"] . "</td>";
                        echo "<td>" . $row["hora"] . "</td>";
                        echo "<td>" . $row["nombre_usuario"] . "</td>";
                        echo "<td>" . $row["servicio"] . "</td>";
                        echo "<td>
                            <form method='post'>
                                <input type='hidden' name='eliminar_id' value='" . $row["id"] . "'>
                                <button type='button' class='btn btn-danger' onclick='confirmarEliminacion(" . $row["id"] . ")'>Eliminar</button>
                            </form>
                            <button type='button' class='btn btn-primary' onclick='editarProducto(" . $row["id"] . ")'>Editar</button>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay productos disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <?php
        $conexion->close();
        ?>
    </div>

    <script>
        function confirmarEliminacion(id) {
            if (confirm("¿Estás seguro de que deseas eliminar esta cita?")) {
                document.querySelector("input[name='eliminar_id']").value = id;
                document.querySelector("form").submit();
            }
        }

        function editarProducto(id) {
            window.location.href = 'editarcita.php?id=' + id;
        }
    </script>
</body>

</html>
