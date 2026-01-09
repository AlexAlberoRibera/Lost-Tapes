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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Lost Tapes</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS propio -->
  <link rel="stylesheet" href="./public/css/estilos.css">
</head>

<body>

<!-- HEADER -->
<header class="header">
  <img src="./public/img/Logo_Tapes.png" alt="Logo">

  <nav>
    <ul>
      <li><a href="#">Home</a></li>
      <li><a href="contacto.php">Contacto</a></li>
      <li><a href="#">Productos</a></li>
      <li><a href="#">Sell</a></li>
    </ul>
  </nav>

  <form class="search-bar">
    <input type="text" placeholder="Buscar...">
    <button>Buscar</button>
  </form>
</header>

<main class="container mt-5 pt-5">

  <!-- HERO -->
  <!-- HERO / Carousel -->
  <section class="text-center mb-5">
    <h2 class="section-title">New Cult Movies</h2>

    <div id="mainCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="./public/img/peliculas/harakiri/1.jpg" class="d-block w-100" alt="Harakiri">
          <div class="carousel-caption d-none d-md-block text-start">
            <h5>Harakiri</h5>
            <p>Drama samurái que desmonta el código del honor y la hipocresía feudal.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="./public/img/peliculas/brandedToKill/1.jpg" class="d-block w-100" alt="Branded To Kill">
          <div class="carousel-caption d-none d-md-block text-start">
            <h5>Branded To Kill</h5>
            <p>Thriller experimental japonés de los años 60.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="./public/img/peliculas/andreiRublev/1.jpg" class="d-block w-100" alt="Andrei Rublev">
          <div class="carousel-caption d-none d-md-block text-start">
            <h5>Andrei Rublev</h5>
            <p>Tarkovski retrata el arte, la fe y la condición humana.</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </section>

  <!-- PELÍCULAS -->
  <div class="row g-4">

    <!-- CARD -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card pelicula-card h-100">
        <img src="./public/img/peliculas/harakiri/1.jpg" class="card-img-top">
        <div class="card-body">
          <div class="d-flex justify-content-between mb-2">
            <h5 class="card-title">Harakiri</h5>
            <span class="duracion">127'</span>
          </div>
          <p class="card-text">
            Drama samurái que desmonta el código del honor y la hipocresía feudal.
          </p>
        </div>
      </div>
    </div>

    <!-- CARD -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card pelicula-card h-100">
        <img src="./public/img/peliculas/brandedToKill/1.jpg" class="card-img-top">
        <div class="card-body">
          <div class="d-flex justify-content-between mb-2">
            <h5 class="card-title">Branded To Kill</h5>
            <span class="duracion">92'</span>
          </div>
          <p class="card-text">
            Thriller experimental japonés de los años 60.
          </p>
        </div>
      </div>
    </div>

    <!-- CARD -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card pelicula-card h-100">
        <img src="./public/img/peliculas/andreiRublev/1.jpg" class="card-img-top">
        <div class="card-body">
          <div class="d-flex justify-content-between mb-2">
            <h5 class="card-title">Andrei Rublev</h5>
            <span class="duracion">205'</span>
          </div>
          <p class="card-text">
            Tarkovski retrata el arte, la fe y la condición humana.
          </p>
        </div>
      </div>
    </div>

  </div>

    <!-- VIDEO PROMOCIONAL -->
    <!-- Se añade margen superior para mostrar el vídeo un poco más abajo y se activan los controles -->
    <section class="mb-5 video-section mt-5">
    <div class="container">
      <div class="ratio ratio-16x9">
        <video id="reproductor" class="w-100 h-100" controls preload="metadata" loop playsinline loading="lazy" poster="./public/img/poster.jpg">
          <source src="./public/videos/whiteMare.mp4" type="video/mp4">
          Tu navegador no soporta el elemento <code>video</code>.
        </video>
      </div>
    </div>
  </section>

</main>

<footer class="footer bg-dark text-light mt-5 py-4">
  <div class="container">
    <div class="row">
      <div class="col-md-4 mb-3">
        <h6>Lost Tapes</h6>
        <p class="small">Tu tienda de lost media. Encuentra películas, merchandising y ofertas exclusivas.</p>
      </div>

      <div class="col-md-4 mb-3">
        <h6>Enlaces</h6>
        <ul class="list-unstyled small">
          <li><a href="index.php" class="text-light">Inicio</a></li>
          <li><a href="contacto.php" class="text-light">Contacto</a></li>
          <li><a href="productos.php" class="text-light">Productos</a></li>
          <li><a href="sell.php" class="text-light">Vender</a></li>
        </ul>
      </div>

      <div class="col-md-4 mb-3">
        <h6>Legal & Ayuda</h6>
        <ul class="list-unstyled small">
          <li><a href="about.php" class="text-light">Sobre nosotros</a></li>
          <li><a href="terms.php" class="text-light">Términos y condiciones</a></li>
          <li><a href="privacy.php" class="text-light">Política de privacidad</a></li>
          <li><a href="help.php" class="text-light">Ayuda / FAQ</a></li>
        </ul>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-12 text-center small">
        <p class="mb-0">© <?php echo date('Y'); ?> Lost Tapes. Todos los derechos reservados.</p>
        <p class="mb-0">Queda prohibida la reproducción total o parcial de los contenidos sin autorización.</p>
      </div>
    </div>
  </div>
</footer>

<!-- Bootstrap JS (bundle includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>