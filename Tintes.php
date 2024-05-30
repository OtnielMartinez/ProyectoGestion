<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estilos de Tintes de Cabello</title>
    <link rel="stylesheet" href="Estilos/estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   
</head>
<body>
    <div class="header">
        <a href="inicio.php"><i class="fas fa-arrow-left fa-2x"></i> </a>
        <h2>Estilos de Tintes de Cabello</h2>
    </div>
    
    <div class="container">
        <?php
        $sections = [
            'tintes-uniformesF' => 'Tintes de Cabello Uniformes, Colores Fantasía',
            'tintes-uniformes' => 'Tintes de Cabello Uniformes',
            'tintes-marmoleados' => 'Tintes de Cabello Marmoleados',
            'mechas-luces' => 'Mechas y Luces',
            'tintes-personalizados' => 'Tintes de Cabello Personalizados'
        ];

        foreach ($sections as $id => $title) {
            echo "<section id=\"$id\">";
            echo "<h2>$title</h2>";
            echo "<div class=\"carousel\">";
        
            // Obtener las imágenes de la carpeta correspondiente
            $images = array_merge(
                glob("images/$id/*.jpg"),
                glob("images/$id/*.jpeg"),
                glob("images/$id/*.png"),
                glob("images/$id/*.gif")
            );
            foreach ($images as $image) {
                echo "<div class=\"carousel-item\">";
                echo "<img src=\"$image\" alt=\"$title\">";
                echo "</div>";
            }
        
            echo "</div>";
            echo "</section>";
        }
        ?>
    </div>

    <script src="script.js"></script>
</body>
</html>
