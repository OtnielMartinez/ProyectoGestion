<!doctype html>
<html lang="en">

<head>
    <title>Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="Estilos/admin.css">
    <style>
               body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            text-align: center;
        }

        .container {
            width: 100%;
            max-width: 800px;
        }

        img {
            width: 100%;
            max-width: 500px; /* Ajusta el tamaño máximo */
            height: auto;
            border: 2px solid #000; /* Borde negro */
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3); /* Sombra */
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="nav navbar-nav">
            <button class="nav-item nav-link active" onclick="window.location.href='admin.php'">Inicio</button>
            <button class="nav-item nav-link" onclick="window.location.href='Productos.php'">Productos</button>
            <button class="nav-item nav-link" onclick="window.location.href='Citas.php'">Citas</button>
            <button class="nav-item nav-link" onclick="window.location.href='login.php'">Cerrar sesión</button>
        </div>
    </nav>
   
    <div class="container">
        <h1 class="welcome-text">Bienvenido</h1>
        <div class="row">
            <div class="col-12">
                <br />
                <div class="row">
                <h1>Estética Glamoure</h1>
                    <img src="https://i.imgur.com/vTKbBKt.jpeg" alt="Descripción de la imagen">
                </div>
            </div>
        </div>
    </div>
</body>

</html>

