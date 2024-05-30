<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $nombre_usuario = $_POST["nombre_usuario"];
    $servicio = $_POST["servicio"];
    $id_producto = $_POST["id"]; // Obtén el ID del producto desde el formulario
    
    $conexion = new mysqli("localhost", "root", "", "estetica", "3306");
    $conexion->set_charset("utf8");
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }
    
    $sql = "UPDATE citas SET fecha='$fecha', hora='$hora', nombre_usuario='$nombre_usuario', servicio='$servicio' WHERE id=$id_producto";
    $result = $conexion->query($sql);
    
    if ($result === TRUE) {
        // Cita actualizada correctamente, redirige a Citas.php
        header("Location: Citas.php");
        exit; // Asegúrate de que el script se detenga después de la redirección
    } else {
        echo "Error al actualizar cita: " . $conexion->error;
    }
    
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="Estilos/style.css">
</head>

<body class="text-bg-secondary p-3">
    <div class="blob"></div>
    <div class="wrapper">
        <div class="container formLogin text-bg-info p-5">
            <div class="alert alert-secondary lb-login" role="alert"></div>
            <?php
            // Verifica si se ha enviado un formulario POST
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Mostrar un mensaje de confirmación o errores aquí
            } else {
                // Si no es una solicitud POST, obtén los valores actuales de la cita y muestra el formulario
                $id_producto = $_GET['id']; // Suponiendo que tienes el ID del producto en el URL
                
                $conexion = new mysqli("localhost", "root", "", "estetica", "3306");
                $conexion->set_charset("utf8");
                if ($conexion->connect_error) {
                    die("Conexión fallida: " . $conexion->connect_error);
                }
                
                $sql = "SELECT fecha, hora, nombre_usuario, servicio FROM citas WHERE id = $id_producto";
                $result = $conexion->query($sql);
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $fecha_actual = $row["fecha"];
                    $hora_actual = $row["hora"];
                    $nombre_usuario_actual = $row["nombre_usuario"];
                    $servicio_actual = $row["servicio"];
                }
            ?>
                <form action="editarcita.php" method="post">
                    <h2>Editar Cita</h2>
                    <div class="input-box">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $fecha_actual; ?>" required>
                    </div>
                    <div class="input-box">
                        <label for="hora" class="form-label">Hora</label>
                        <input type="time" class="form-control" id="hora" name="hora" value="<?php echo $hora_actual; ?>" required>
                    </div>
                    <div class="input-box">
                        <label for="nombre_usuario" class="form-label">Cliente</label>
                        <p class="form-control-plaintext"><?php echo $nombre_usuario_actual; ?></p>
                        <input type="hidden" id="nombre_usuario" name="nombre_usuario" value="<?php echo $nombre_usuario_actual; ?>">
                    </div>
                    <div class="input-box">
                        <label for="servicio" class="form-label">Servicio</label>
                        <select class="form-control" id="servicio" name="servicio" required>
                            <option value="">Seleccione un servicio</option>
                            <option value="Cortes de cabello" <?php if($servicio_actual == 'Cortes de cabello') echo 'selected'; ?>>Cortes de cabello</option>
                            <option value="Depilado de cejas" <?php if($servicio_actual == 'Depilado de cejas') echo 'selected'; ?>>Depilado de cejas</option>
                            <option value="Tintes de cabello" <?php if($servicio_actual == 'Tintes de cabello') echo 'selected'; ?>>Tintes de cabello</option>
                            <option value="Bases" <?php if($servicio_actual == 'Bases') echo 'selected'; ?>>Bases</option>
                        </select>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id_producto; ?>"> <!-- Agrega un campo oculto para enviar el ID del producto -->
                    <a href="Citas.php" class="btn btn-outline-danger">Cancelar</a>
                    <button type="submit" class="btn btn-success">Actualizar Cita</button>
                </form>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>

