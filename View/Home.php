<?php
session_start();
$loggedIn = !empty($_SESSION['logged']);
$userName = htmlspecialchars($_SESSION['usuario_name'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Home | Race&Meet</title>
    <link rel="stylesheet" href="../src/css/Home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <style>

        /* ── MODAL ── */
        #modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.75);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        #modal-overlay.active {
            display: flex;
        }
        #modal-box {
            background: #1a1a1a;
            border: 1px solid #ff3131;
            border-radius: 14px;
            padding: 36px 40px;
            max-width: 420px;
            width: 90%;
            text-align: center;
            color: #fff;
        }
        #modal-box h3 {
            color: #ff3131;
            margin-bottom: 12px;
            font-size: 1.3rem;
        }
        #modal-box p { color: #ccc; line-height: 1.6; }
        #modal-close {
            margin-top: 20px;
            background: #ff3131;
            color: #fff;
            border: none;
            padding: 10px 28px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
        }
        #modal-close:hover { background: #cc0000; }

        /* ── SLIDERS SECTION ── */
        .sliders-section {
            padding: 50px 20px;
            background: transparent;
        }
        .sliders-section h2 {
            color: #ff3131;
            text-align: center;
            margin-bottom: 24px;
            font-size: 1.4rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .slider-wrapper {
            margin-bottom: 60px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Slider eventos */
        .slide-evento {
            position: relative;
            outline: none;
            padding: 0 10px;
            box-sizing: border-box;
        }
        .slide-evento img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            border-radius: 10px;
            display: block;
        }
        .slide-evento .slide-titulo {
            position: absolute;
            bottom: 0;
            left: 10px;
            right: 10px;
            background: rgba(255,49,49,0.88);
            color: #fff;
            font-weight: 700;
            font-size: 0.88rem;
            padding: 8px 12px;
            border-radius: 0 0 10px 10px;
            text-align: center;
        }

        /* Slider equipo — tarjeta roja */
        .slide-promotor {
            background: #ff3131;
            border-radius: 12px;
            padding: 28px 24px;
            text-align: center;
            margin: 0 10px;
            outline: none;
            box-sizing: border-box;
        }
        .slide-promotor h4 {
            color: #fff;
            margin-bottom: 8px;
            font-size: 1rem;
            font-weight: 700;
        }
        .slide-promotor p {
            color: rgba(255,255,255,0.85);
            font-size: 0.85rem;
            line-height: 1.5;
        }

        /* Slick arrows y dots */
        .slick-prev:before,
        .slick-next:before { color: #ff3131; font-size: 22px; }
        .slick-dots li button:before { color: #ff3131; }
        .slick-dots li.slick-active button:before { color: #ff3131; }

    </style>
</head>
<body>

<!-- ── MODAL ── -->
<div id="modal-overlay">
    <div id="modal-box">
        <h3 id="modal-title">Más información</h3>
        <p id="modal-body"></p>
        <button id="modal-close">Cerrar</button>
    </div>
</div>

<header class="header">
    <img src="../src/images/Logotipo_Vicente.png" alt="Logo Race&Meet" class="logo">
    <nav class="navbar">
        <ul class="nav-links">
            <li><a href="Home.php">Inicio</a></li>
            <li><a href="Eventos.php">Eventos</a></li>
            <li><a href="Comunidad.html">Comunidad</a></li>
        </ul>
        <div class="nav-actions">
            <?php if ($loggedIn): ?>
                <a href="profile.php" style="color:#ff3131; font-weight:bold;
                   text-decoration:none; margin-right:12px;">
                    Hola, <?= $userName ?> 👤
                </a>
                <form method="POST" action="Login.php" style="display:inline;">
                    <button type="submit" name="Logout" class="btn-login">Cerrar sesión</button>
                </form>
            <?php else: ?>
                <a href="Login.php"><button class="btn-login">Iniciar sesión</button></a>
                <a href="Registro_user.php"><button class="btn-register">Registro</button></a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<main class="container">

    <section class="cabecera">
        <h1>HOME<br>RACE&MEET</h1>
        <p class="subtitle">Busca tú aventura</p>
        <div class="search-bar">
            <input type="text" placeholder="Buscar...">
            <button>Buscar</button>
        </div>
    </section>

    <section class="info">
        <div class="card">
            <h2>COMO SURGIMOS</h2>
            <p>Una aventura sobre ruedas. Race&Meet nació de la pasión compartida por el motor y el deseo de conectar a quienes viven la velocidad como un estilo de vida.</p>
        </div>
        <div class="card">
            <h2>NUESTROS EVENTOS</h2>
            <p>Tenemos gran variedad de eventos tanto oficiales como creados por nuestra propia comunidad.</p>
            <button type="button" class="info-btn btn-modal"
                data-title="Nuestros Eventos"
                data-body="Organizamos eventos de motor a lo largo de todo el año: exhibiciones, carreras, encuentros de coleccionistas y mucho más. ¡Atento al calendario!">
                Más Info
            </button>
        </div>
        <div class="card">
            <h2>NUESTRA COMUNIDAD</h2>
            <p>Estamos muy orgullosos de nuestra increíble comunidad y nos encantaría que formaras parte de ella.</p>
            <button type="button" class="info-btn btn-modal"
                data-title="Nuestra Comunidad"
                data-body="Somos miles de apasionados del motor. Únete a nuestra comunidad y comparte tu pasión.">
                Más Info
            </button>
        </div>
    </section>

</main>

<!-- ── SLIDERS ── -->
<section class="sliders-section">

    <div class="slider-wrapper">
        <h2>Próximos Eventos</h2>
        <div class="slider-eventos">
            <div class="slide-evento">
                <img src="../src/images/eurocrewmotorland26.jpg" alt="Evento 1">
                <div class="slide-titulo">Salón de Innovación Automotriz · €45</div>
            </div>
            <div class="slide-evento">
                <img src="../src/images/imagen1.png" alt="Evento 2">
                <div class="slide-titulo">Exhibición Internacional de Autos · €35</div>
            </div>
            <div class="slide-evento">
                <img src="../src/images/imagen2.png" alt="Evento 3">
                <div class="slide-titulo">Festival de Velocidad en Pista · €80</div>
            </div>
            <div class="slide-evento">
                <img src="../src/images/imagen3.png" alt="Evento 4">
                <div class="slide-titulo">Competencia de Diseño Automotriz · €120</div>
            </div>
        </div>
    </div>

    <div class="slider-wrapper">
        <h2>Nuestro Equipo</h2>
        <div class="slider-equipo">
            <div class="slide-promotor">
                <h4>Ishak L'harrak Afia</h4>
                <p>Web Developer & Tech Lead. Responsable de toda la arquitectura técnica de la plataforma.</p>
            </div>
            <div class="slide-promotor">
                <h4>Ian Cloyd Gamo</h4>
                <p>Community Manager & Public Relations. Gestiona la comunidad y las relaciones con los medios.</p>
            </div>
            <div class="slide-promotor">
                <h4>Iker Martín Escolà</h4>
                <p>Product Manager & Concept Designer. Define la visión del producto y el diseño de experiencia.</p>
            </div>
        </div>
    </div>

</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="../src/js/home.js"></script>

</body>
</html>