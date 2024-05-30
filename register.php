<?php
$conexion = new mysqli("localhost", "root", "", "estetica", "3306");
$conexion->set_charset("utf8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $correo = $_POST["correo"];
    $idrol = $_POST["idrol"];

    $consulta = "INSERT INTO usuarios (usuario, password, nombre, apellido, correo, idrol) VALUES ('$usuario', '$password', '$nombre', '$apellido', '$correo','3')";
    $exito = $conexion->query($consulta);

    if ($exito) {
        // Redirige al usuario a la página de inicio de sesión
        header("Location: login.php");
        exit(); 
    } else {
        echo "Error al registrar el usuario. Por favor, intenta nuevamente.";
    }
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
<body>
    <div class="blob"></div>
    <div class="wrapper">
        <form action="" method="post">
            <h2>Registro</h2>
            <div class="input-box">
                <label for="usuario">Nombre de usuario</label>
            </div>
            <div class="input-box">
                <input id="usuario" type="text" class="input" name="usuario" required autocomplete="off">
                <span class="icon"><ion-icon name="mail"></ion-icon></span>
            </div>

            <div class="input-box">
                <label for="nombre">Nombre</label>
            </div>
            <div class="input-box">
                <input id="nombre" type="text" class="input" name="nombre" required>
            </div>

            <div class="input-box">
                <label for="apellido">Apellido</label>
            </div>
            <div class="input-box">
                <input id="apellido" type="text" class="input" name="apellido" required>
            </div>

            <div class="input-box">
                <label for="correo">Correo electrónico</label>
            </div>
            <div class="input-box">
                <input id="correo" type="email" class="input" name="correo" required>
                <span class="icon"><ion-icon name="mail"></ion-icon></span>
            </div>

            <div class="input-box">
                <label for="password">Contraseña</label>
            </div>
            <div class="input-box">
                <input type="password" id="password" class="input" name="password" required>
                <span class="icon"><ion-icon name="lock"></ion-icon></span>
            </div>
            <button type="submit">Registrarse</button>
            <div class="signUp-link">
                <p>¿Ya tienes una cuenta? <a href="login.php" class="signUpBtn-link">Iniciar sesión</a></p>
            </div>
            
        </form>
    </div>
    <script src="script.js"></script>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
</body>
</html>
