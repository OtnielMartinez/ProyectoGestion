<?php
session_start();

$conexion = new mysqli("localhost", "root", "", "estetica", "3306");
$conexion->set_charset("utf8");

$mensajeError = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = mysqli_real_escape_string($conexion, $_POST["usuario"]);
    $password = mysqli_real_escape_string($conexion, $_POST["password"]);

    $consulta = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND password = '$password'";
    $resultado = mysqli_query($conexion, $consulta);

    if($resultado && mysqli_num_rows($resultado) > 0) {
        $filas = mysqli_fetch_array($resultado);
        if($filas['idrol'] == 4){
            header("Location: admin.php");
            exit();
        } elseif($filas['idrol'] == 3){
            $_SESSION['nombre_usuario'] = $usuario;
            header("Location: inicio.php");
            exit();
        } else {
            $mensajeError = '<div style="color: #ff5151; background-color: #ffe5e5; padding: 15px; border-radius: 8px; margin-top: 20px; font-size: 20px; display: flex; align-items: center; justify-content: center; animation: shake 2s ease-in-out;">Credenciales incorrectas. Por favor, intenta nuevamente.</div>';
        }
    } else {
        $mensajeError = '<div style="color: #ff5151; background-color: #ffe5e5; padding: 15px; border-radius: 8px; margin-top: 20px; font-size: 20px; display: flex; align-items: center; justify-content: center; animation: shake 2s ease-in-out;">No se encontraron resultados para el usuario y contraseña proporcionados.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="Estilos/style.css">
    <style>
        .mensaje-error {
            display: <?php echo empty($mensajeError) ? 'none' : 'block'; ?>;
            color: #ff0000; 
            font-size: 14px;
            margin-top: 10px; 
        }
    </style>
</head>
<body>
    <div class="blob"></div>
    <div class="wrapper">
        <form action="" method="post">
        <div class="logo-container">
    <img src="https://i.imgur.com/vTKbBKt.jpeg" alt="Logo de tu empresa">
</div>
            <h2>Login</h2>
            <div class="input-box">
                <label for="usuario">Nombre de usuario</label>
            </div>
            <div class="input-box">
                <input id="usuario" type="text" class="input" name="usuario" required autocomplete="off">
                <span class="icon"><ion-icon name="mail"></ion-icon></span>
            </div>
            <div class="input-box">
                <label for="input">Contraseña</label>
            </div>
            <div class="input-box">
                <input type="password" id="input" class="input" name="password" required>
                <span class="icon"><ion-icon name="lock"></ion-icon></span>
            </div>
            <div class="recordar">
                <a href="#">¿Has olvidado tu contraseña?</a>
            </div>
            <button type="submit">Iniciar</button>
            <div class="signUp-link">
                <p>¿No tienes una cuenta? <a href="register.php" class="signUpBtn-link">Registrarse</a></p>
            </div>
            <div class="mensaje-error"><?php echo $mensajeError; ?></div>
        </form>
    </div>
    <script src="script.js"></script>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
</body>
</html>

