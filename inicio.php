<?php
session_start();
// Verifica si hay un mensaje de éxito o error y muéstralo
$mensajeExito = isset($_SESSION['mensaje_exito']) ? $_SESSION['mensaje_exito'] : "";
$mensajeError = isset($_SESSION['mensaje_error']) ? $_SESSION['mensaje_error'] : "";

// Elimina los mensajes de la sesión para que no se muestren nuevamente después de un refresh
unset($_SESSION['mensaje_exito']);
unset($_SESSION['mensaje_error']);

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['nombre_usuario'])) {
    // Si no ha iniciado sesión, redirige a la página de login
    header("Location: login.php");
    exit();
}


$nombreUsuario = $_SESSION['nombre_usuario'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a la Estética Glamoure</title>
    <link rel="stylesheet" type="text/css" href="Estilos/style.css">
</head>

<body>

    <div class="navbar">
        <div>
            <img src="https://i.imgur.com/IFz9itE.png" alt="Cerrar sesión" onclick="window.location.href='logout.php'" />
            <span>Cerrar sesión</span>
        </div>

        <div>
            <img src="https://i.imgur.com/tilOdk9.jpeg" alt="Reservar cita" onclick="openModal()" />
            <span>Reservar cita</span>
        </div>

        <div>
            <img src="https://i.imgur.com/Nlu81Vd.jpeg" alt="Catálogo de productos" onclick="window.location.href='catalogo.php'" />
            <span>Catálogo de productos</span>
        </div>
    </div>
    
    <div class="pink-container">
        <h2>Bienvenido a la estética Glamoure, <?php echo $nombreUsuario; ?></h2>
        <p>¡Disfruta de una experiencia única y personalizada con nosotros!</p>
    </div>
    
    <?php
    if (!empty($mensajeError)) {
        echo '<div class="error-message">' . $mensajeError . '</div>';
    }
    ?>

    <div class="services-container">
        <div class="service-box">
            <a href="EstilosCortes.php">
                <img src="https://i.imgur.com/9vVPm22.jpeg" alt="Servicio 1">
                <h3>Cortes de cabello</h3>
                <p>Damas, Caballeros y Niños</p>
            </a>
        </div>

        <div class="service-box">
            <a href="Depilacion.php">
                <img src="https://i.imgur.com/VTmbimo.png" alt="Servicio 2">
                <h3>Depilado de cejas</h3>
                <p>Depilación con pinza o navaja</p>
            </a>
        </div>

        <div class="service-box">
            <a href="Tintes.php">
                <img src="https://i.imgur.com/2Hjtpih.png" alt="Servicio 3">
                <h3>Tintes de cabello</h3>
                <p>Tono uniforme, Marmoleado, Mechas, Luces</p>
            </a>
        </div>

        <div class="service-box">
            <a href="Bases.php">
                <img src="https://i.imgur.com/hHMREcp.jpeg" alt="Servicio 4">
                <h3>Bases</h3>
                <p>Rizado de Cabello</p>
            </a>
        </div>
    </div>

    <div class="modal" id="calendarModal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">✖</span>
            <h2>Reserva tu cita!</h2>
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>
            <label for="hora">Hora:</label>
            <input type="time" id="hora" name="hora" required>
            
            <label for="servicio">Servicio:</label>
            <select id="servicio" name="servicio" required>
                <option value="">Seleccione un servicio</option>
                <option value="Cortes de cabello">Cortes de cabello</option>
                <option value="Depilado de cejas">Depilado de cejas</option>
                <option value="Tintes de cabello">Tintes de cabello</option>
                <option value="Bases">Bases</option>
            </select>
            
            <button type="button" onclick="verificarDisponibilidad()">Verificar disponibilidad</button>
        </div>
    </div>

    <form id="reservaForm" action="guardar_cita.php" method="post">
        <input type="hidden" name="nombreUsuario" value="<?php echo $nombreUsuario; ?>">
        <input type="hidden" name="fecha" id="fechaReserva" required>
        <input type="hidden" name="hora" id="horaReserva" required>
    </form>

    <div id="disponibilidadMensaje" style="text-align: center;"></div>

    <footer>
        <div class="contact-info">
            <p>Información de Contacto:</p>
            <p>Número de Teléfono: <span>9811324567</span></p>
            <p>Dirección: <span>Calle Calcita, Colonia Minas</span></p>
        </div>
    </footer>

    <script>
        function openModal() {
            document.getElementById('calendarModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('calendarModal').style.display = 'none';
        }

        function verificarDisponibilidad() {
            var fecha = document.getElementById('fecha').value;
            var hora = document.getElementById('hora').value;
            var servicio = document.getElementById('servicio').value;

            // Realizar la solicitud AJAX para verificar la disponibilidad
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "guardar_cita.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var respuesta = JSON.parse(xhr.responseText);
                    if (respuesta.exito) {
                        // Si la cita se guarda exitosamente, mostrar mensaje de éxito
                        alert('¡Cita agendada exitosamente!');
                    } else {
                        // Si hubo un error, mostrar mensaje de error
                        alert('Hubo un problema al agendar la cita. Por favor, inténtalo de nuevo.');
                    }
                }
            };
            xhr.send("nombreUsuario=<?php echo $nombreUsuario; ?>&fecha=" + fecha + "&hora=" + hora + "&servicio=" + servicio);
        }

        function guardarCita() {
            // Enviar el formulario para guardar la cita en la base de datos
            document.getElementById('reservaForm').submit();
            // Mostrar mensaje de éxito
            document.getElementById('disponibilidadMensaje').innerText = '¡Cita agendada exitosamente! Te esperamos en la fecha y hora seleccionadas.';
            // Ocultar el mensaje de éxito después de 5 segundos
            setTimeout(function() {
                document.getElementById('disponibilidadMensaje').innerText = '';
            }, 5000);
            // Cerrar el modal después de 5 segundos
            setTimeout(function() {
                closeModal();
            }, 5000);
        }
    </script>
</body>
</html>

