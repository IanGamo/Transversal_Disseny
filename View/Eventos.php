<?php
session_start();
$loggedIn = !empty($_SESSION['logged']);
$userName = htmlspecialchars($_SESSION['usuario_name'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eventos | Race&Meet</title>
    <link rel="stylesheet" href="../src/css/Eventos.css">
</head>
<body>

    <header class="header">
        <h1>EVENTOS</h1>
        <img src="../src/images/Logotipo_Vicente.png" alt="Logo Race&Meet" class="logo">
    </header>

    <main class="container eventos-container">

        <a href="Carrito_evento1.html" class="evento">
            <div class="evento-info">
                <p>Salón internacional de innovación automotriz</p>
                <span>€45</span>
            </div>
            <div class="evento-foto">
                <img src="../src/images/eurocrewmotorland26.jpg" alt="Folleto del evento">
                <div class="evento-hover-info">
                    Salón de Innovación
                    <span>Haz clic para comprar tu entrada · €45</span>
                </div>
            </div>
        </a>

        <a href="Carrito_evento2.html" class="evento">
            <div class="evento-info">
                <p>Exhibición internacional de autos nuevos</p>
                <span>€35</span>
            </div>
            <div class="evento-foto">
                <img src="../src/images/imagen1.png" alt="Folleto del evento">
                <div class="evento-hover-info">
                    Exhibición Internacional
                    <span>Haz clic para comprar tu entrada · €35</span>
                </div>
            </div>
        </a>

        <a href="Carrito_evento3.html" class="evento">
            <div class="evento-info">
                <p>Festival de velocidad y demostraciones en pista</p>
                <span>€80</span>
            </div>
            <div class="evento-foto">
                <img src="../src/images/imagen2.png" alt="Folleto del evento">
                <div class="evento-hover-info">
                    Festival de Velocidad
                    <span>Haz clic para comprar tu entrada · €80</span>
                </div>
            </div>
        </a>

        <a href="Carrito_evento4.html" class="evento">
            <div class="evento-info">
                <p>Competencia de elegancia y diseño automotriz</p>
                <span>€120</span>
            </div>
            <div class="evento-foto">
                <img src="../src/images/imagen3.png" alt="Folleto del evento">
                <div class="evento-hover-info">
                    Competencia de Diseño
                    <span>Haz clic para comprar tu entrada · €120</span>
                </div>
            </div>
        </a>

    </main>

    <footer class="container">
        <a href="Home.php">
            <button class="volver-btn">Volver a HOME</button>
        </a>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../src/js/eventos.js"></script>

</body>
</html>