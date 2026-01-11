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
    $user = is_array($u) && isset($u[0]) ? $u[0] : $u;
  }
}

// Cargar datos de ejemplo (películas) desde JSON local
$dataFile = __DIR__ . '/public/data/peliculas.json';
$peliculas = [];
if (file_exists($dataFile)) {
    $raw = file_get_contents($dataFile);
    $json = json_decode($raw, true);
    if ($json !== null && isset($json['peliculas'])) {
        $peliculas = $json['peliculas'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Productos - Lost Tapes</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Estilos propios -->
  <link rel="stylesheet" href="./public/css/estilos.css">
  <link rel="stylesheet" href="./public/css/estilo_footer.css">
</head>

<body>

<?php $show_search = true; include __DIR__ . '/includes/header.php'; ?>

<main class="container mt-5 pt-5">
  <section class="text-center mb-4">
    <h2 class="section-title">Productos — Lost Media</h2>
    <p class="lead">Películas, archivos, música y otros objetos del underground. Filtra y explora nuestro catálogo.</p>
  </section>

  <!-- Grid de productos -->
  <div class="row g-4">
    <?php if (!empty($peliculas)): ?>
      <?php foreach ($peliculas as $p): ?>
        <div class="col-12 col-md-6 col-lg-4">
          <div class="card pelicula-card h-100">
            <?php
              // Determinar ruta de imagen:
              // - si el JSON proporciona 'imagen' usamos esa ruta (archivo único)
              // - si proporciona 'carpeta' intentamos cargar '1.jpg' dentro de esa carpeta
              // - si no, usamos una imagen por defecto
              if (isset($p['imagen']) && $p['imagen']) {
                  $imgPath = $p['imagen'];
              } elseif (isset($p['carpeta']) && $p['carpeta']) {
                  $imgPath = $p['carpeta'] . '1.jpg';
              } else {
                  $imgPath = './public/img/peliculas/default.jpg';
              }
              // Normalizar rutas que vienen con './' y eliminar dobles slashes
              $imgPath = str_replace('./', '', $imgPath);
              $imgPath = preg_replace('#/+#', '/', $imgPath);
            ?>
            <img src="/<?php echo htmlspecialchars($imgPath); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($p['nombre']); ?>">
            <div class="card-body">
              <div class="d-flex justify-content-between mb-2">
                <h5 class="card-title"><?php echo htmlspecialchars($p['nombre']); ?></h5>
                <span class="duracion"><?php echo htmlspecialchars($p['duracion'] ?? '—'); ?>'</span>
              </div>
              <p class="card-text"><?php echo htmlspecialchars($p['descripcion']); ?></p>
              <a href="pelicula.php?id=<?php echo urlencode($p['id']); ?>" class="btn btn-dark">Ver detalle</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12">
        <p class="text-center">No hay productos disponibles. Vuelve más tarde.</p>
      </div>
    <?php endif; ?>
  </div>

</main>

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
