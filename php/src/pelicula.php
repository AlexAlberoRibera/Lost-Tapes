<?php
session_start();
require_once __DIR__ . '/includes/json_connect.php';

$id = isset($_GET['id']) ? (string)$_GET['id'] : '1';

$data = @file_get_contents(__DIR__ . '/public/data/peliculas.json');
$parsed = $data ? json_decode($data, true) : null;
$movie = null;
if (isset($parsed['peliculas']) && is_array($parsed['peliculas'])) {
  foreach ($parsed['peliculas'] as $p) {
    if ((string)($p['id'] ?? '') === $id) {
      $movie = $p;
      break;
    }
  }
}

if (!$movie) {
  http_response_code(404);
  echo "<p>Película no encontrada.</p>";
  exit;
}

// determine user (for header behavior like index.php)
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
  if ($u !== false) $user = is_array($u) && isset($u[0]) ? $u[0] : $u;
}
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($movie['nombre'] ?? 'Película', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></title>
  <!-- Bootstrap (css) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./public/css/estilos.css">
  <link rel="stylesheet" href="./public/css/session.css">
  <link rel="stylesheet" href="./public/css/comments.css">
  <link rel="stylesheet" href="./public/css/estilo_footer.css">
  <link rel="stylesheet" href="./public/css/estilos_accesibilidad.css">
</head>

<body>
  <?php $show_search = false;
  include __DIR__ . '/includes/header.php'; ?>

  <main style="padding-top:120px; max-width:1000px; margin:24px auto;">
    <article class="movie-detail">
      <h1><?= htmlspecialchars($movie['nombre'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></h1>
      <div style="display:flex; gap:18px; align-items:flex-start;">
        <div style="flex:0 0 420px;">
          <?php
          // Determinar ruta de imagen para la película (soporta 'imagen' o 'carpeta')
          if (!empty($movie['imagen'])) {
            $img = $movie['imagen'];
          } elseif (!empty($movie['carpeta'])) {
            $img = $movie['carpeta'] . '1.jpg';
          } else {
            $img = './public/img/peliculas/default.jpg';
          }
          // Normalizar y limpiar ruta
          $img = str_replace('./', '', $img);
          $img = preg_replace('#/+#', '/', $img);
          ?>
          <img src="/<?php echo htmlspecialchars($img, ENT_QUOTES); ?>" alt="<?php echo htmlspecialchars($movie['nombre'], ENT_QUOTES); ?>" style="width:100%; border-radius:8px;">
        </div>
        <div style="flex:1;">
          <p><strong>Duración:</strong> <?= htmlspecialchars($movie['duracion'] ?? '-', ENT_QUOTES) ?>'</p>
          <p><?= htmlspecialchars($movie['descripcion'] ?? '-', ENT_QUOTES) ?></p>
        </div>
      </div>

      <section style="margin-top:18px;">
        <div style="margin-bottom:12px;" id="rating-area-<?= htmlspecialchars($id) ?>" data-product-id="<?= htmlspecialchars($id) ?>" class="rating-wrap">
          <button class="like-btn" id="likeBtn">👍 <span id="likeCount">0</span></button>
          <span class="rating-info" id="ratingInfo" style="margin-left:12px;color:#666;">—</span>
        </div>

        <div id="comments-area-<?= htmlspecialchars($id) ?>" data-product-id="<?= htmlspecialchars($id) ?>" class="comments-wrap">
          <h3>Opiniones</h3>
          <form class="comments-form">
            <label for="comment_content">Deja tu comentario</label>
            <textarea id="comment_content" name="content" placeholder="Escribe tu opinión..."></textarea>
            <button type="submit">Enviar comentario</button>
          </form>
          <div class="comments-list">Cargando comentarios...</div>
        </div>
      </section>
    </article>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>

  <?php include __DIR__ . '/includes/accesibilidad.php'; ?>

  <script src="./js/accesibilidad.js"></script>

  <script src="./js/main.js"></script>
  <script src="./js/comments.js"></script>
  <script src="./js/ratings.js"></script>
</body>

</html>