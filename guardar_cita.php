<?php
// Establecer la conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "estetica");
$conexion->set_charset("utf8");

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombreUsuario = $_POST["nombreUsuario"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $servicio = $_POST["servicio"];

    // Verificar si la hora está dentro del horario hábil (8am a 8pm)
    $horaSeleccionada = intval(substr($hora, 0, 2));
    if ($horaSeleccionada < 8 || $horaSeleccionada >= 20) {
        // Si la hora no está dentro del horario hábil, enviar mensaje de error
        echo json_encode(array('exito' => false, 'mensaje' => 'La hora seleccionada no está dentro del horario hábil.'));
        exit; // Terminar la ejecución del script
    }

    // Insertar la cita en la base de datos
    $consulta = "INSERT INTO citas (nombre_usuario, fecha, hora, servicio) VALUES ('$nombreUsuario', '$fecha', '$hora', '$servicio')";

    if ($conexion->query($consulta)) {
        // Si la inserción fue exitosa, enviar mensaje de éxito
        echo json_encode(array('exito' => true));
    } else {
        // Si hubo un error en la inserción, enviar mensaje de error
        echo json_encode(array('exito' => false, 'mensaje' => 'Hubo un problema al agendar la cita. Por favor, inténtalo de nuevo.'));
    }
} else {
    // Si no se recibieron los datos del formulario, enviar mensaje de error
    echo json_encode(array('exito' => false, 'mensaje' => 'No se recibieron datos del formulario.'));
}
?>