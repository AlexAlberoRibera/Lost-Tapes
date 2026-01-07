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
      <li><a href="#">Contacto</a></li>
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
  <section class="text-center mb-5">
    <h2 class="section-title">New Cult Movies</h2>
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

</main>

<footer class="footer mt-5">
  <p class="text-center">© 2025 Lost Tapes</p>
</footer>

</body>
</html>