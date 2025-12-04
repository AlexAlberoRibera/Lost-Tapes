<?php
session_start();
require_once __DIR__ . '/includes/json_connect.php';

// Determine logged in user (if any)
$user = null;
$userId = null;
if (!empty($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];
} elseif (!empty($_COOKIE['user_id'])) {
  $userId = $_COOKIE['user_id'];
  $_SESSION['user_id'] = $userId;
}
if ($userId !== null) {
  $u = read_user($userId);
  if ($u !== false) {
    // json-server may return object or array in some calls
    $user = is_array($u) && isset($u[0]) ? $u[0] : $u;
  }
}

?>



<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lost Tapes</title>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./public/css/estilos.css" />
  <link rel="stylesheet" href="./public/css/session.css" />
  <link rel="stylesheet" href="./public/css/estilos_carrusel.css" />
</head>

<body>
  <header>
    <div class="header-left">
      <img src="./public/img/Logo_Tapes.png" alt="Logo Tapes" />

      <!-- Session icon / menu placed between logo and nav -->
      <div class="session">
        <?php if (empty($user)): ?>
          <a class="session-login" href="auth/login.php">Iniciar sesión</a>
        <?php else: ?>
          <button class="session-btn" id="sessionToggle" aria-haspopup="true" aria-expanded="false" title="Cuenta">
            <?= htmlspecialchars($user['nom_usuari'] ?? $user['nom'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
          </button>
          <div class="session-dropdown" id="sessionDropdown" role="menu" aria-hidden="true">
            <div class="session-info">
              <div class="session-info-name"><?= htmlspecialchars($user['nom_usuari'] ?? $user['nom'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div>
              <?php if (!empty($user['email'])): ?>
                <div class="session-info-email"><?= htmlspecialchars($user['email'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div>
              <?php endif; ?>
            </div>
            <div class="session-actions">
              <a class="session-link" href="auth/profile.php" role="menuitem">Mi perfil</a>
              <a class="session-link" href="auth/logout.php" role="menuitem">Cerrar sesión</a>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <nav>
      <ul>
        <li><a href="index.php" class="vibrar">Home</a></li>
        <li><a href="contacto.php"class="vibrar">Contacto</a></li>
        <li><a href="#" class="vibrar">Productos</a></li>
        <li><a href="#" class="vibrar">Sell</a></li>
      </ul>
    </nav>
    <form class="search-bar" action="#" method="get">
      <input type="text" name="q" placeholder="Buscar..." />
      <button type="submit">Buscar</button>
    </form>
  </header>

  <main>
    <section class="hero">
      <h2 class="section-title">Best Lost Media</h2>

      <div class="carrusel">
        <!-- Botón previo -->
        <button class="carrusel-btn prev" aria-label="Anterior">&#10094;</button>

        <div class="carrusel-track">
          <article class="carrusel-item">
            <img src="./public/img/bkgdHQ.jpg" alt="Portada mixtape 1">
          </article>
          <article class="carrusel-item active">
            <img src="./public/img/harakiri.png" alt="Portada mixtape 2">
          </article>
          <article class="carrusel-item">
            <img src="./public/img/ladron.png" alt="Portada mixtape 3">
          </article>

        </div>

        <!-- Botón siguiente -->
        <button class="carrusel-btn next" aria-label="Siguiente">&#10095;</button>
      </div>

      <!-- Indicadores (puntos de navegación) -->
      <div class="carrusel-indicators">
        <span class="dot"></span>
        <span class="dot active"></span>
        <span class="dot"></span>
      </div>
    </section>
  </main>
  <script src="./js/carousel.js"></script>

  <h2 class="titulo">New Cult Movies</h2>

  <div class="peliculas">

    <a class="pelicula" href="pelicula.php?id=1">
      <img class="portada" src="./public/img/peliculas/harakiri/1.jpg" alt="harakiri">

      <div class="info">
        <span class="title">Harakiri</span>
        <span class="duracion">Duracion: 127'</span>
      </div>

      <div class="descripcion">
        <p>Un poderoso drama samurái que desmonta el código del honor a través de una historia
          contundente y humana. Una crítica feroz a la hipocresía del sistema feudal japonés.”</p>
      </div>

  </a>


    <div class="pelicula">
      <img class="portada" src="./public/img/peliculas/brandedToKill/1.jpg" alt="brandedToKill">

      <div class="info">
        <span class="title">Branded To Kill</span>
        <span class="duracion">Duracion: 92'</span>
      </div>

      <div class="descripcion">
        <p>Un thriller delirante y estilizado sobre un asesino obsesionado con el olor
          del arroz hervido. Una explosión del cine experimental japonés de los 60.</p>
      </div>

    </div>

    <div class="pelicula">
      <img class="portada" src="./public/img/peliculas/andreiRublev/1.jpg" alt="andreiRublev">

      <div class="info">
        <span class="title">Andrei Rublev</span>
        <span class="duracion">Duracion: 205'</span>
      </div>

      <div class="descripcion">
        <p>Tarkovski retrata el viaje espiritual de un pintor medieval
          en una Rusia convulsa. Cine monumental sobre la fe, el arte y la condición humana.</p>
      </div>

    </div>


  </div>
  <section class="video-cine">
  <h2>Reconstrucción de <em>The White Mare</em></h2>
  <video id="reproductor" width="720" height="400" preload controls loop poster="./public/img/whiteMare.jpg" class="video-cine-video">
    <source src="./public/videos/whiteMare.webm" type='video/webm; codecs="vp8, vorbis"' />
    <source src="./public/videos/whiteMare.ogv" type='video/ogg; codecs="theora, vorbis"' />
    <source src="./public/videos/whiteMare.mp4" type="video/mp4" />
  </video>

  <div class="video-cine-texto">
    <p>
      La reconstrucción de <em>The White Mare</em>, la película de animación,
      ha sido un proceso meticuloso que combina investigación histórica y restauración digital.
      Cada fotograma fue cuidadosamente revisado para preservar los colores originales y
      la esencia narrativa de la obra.
    </p>

    <p>
      Gracias a esta labor, se ha logrado devolver a la película su esplendor visual
      y musical, permitiendo a nuevas audiencias disfrutar de esta joya animada.
      La reconstrucción resalta la importancia del patrimonio cinematográfico
      y la preservación de la animación clásica.
    </p>
  </div>
</section>
  <script src="./js/rotador_peliculas.js"></script>
  <script src="./js/main.js"></script>
    <!-- <script src="./js/comments.js"></script> -->
  <footer class="footer">
    <div class="footer-contenedor">

      <div class="footer-logo">
        <img src="./public/img/Logo_Tapes.png" alt="Logo Tapes">
        <p>Lost Tapes</p>
      </div>

      <div class="footer-links">
        <h4>Explorar</h4>
        <a href="index.php">Home</a>
        <a href="#">Productos</a>
        <a href="contacto.php">Contacto</a>
        <a href="#">Vender</a>
      </div>

      <div class="footer-info">
        <h4>Información</h4>
        <a href="#">Política de privacidad</a>
        <a href="#">Términos y condiciones</a>
        <a href="#">Aviso legal</a>
      </div>

      <div class="footer-social">
        <h4>Síguenos</h4>
        <a href="#">Instagram</a>
        <a href="#">Twitter</a>
        <a href="#">YouTube</a>
      </div>

    </div>

    <hr class="footer-line">

    <p class="footer-copy">
      © 2025 Tapes Films — Archivo digital y mixtapes ocultas del underground.
    </p>
  </footer>

</body>

</html>