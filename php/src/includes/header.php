<?php
// Header include: session-safe, reads user if needed and renders navbar.
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Try to load json_connect if read_user isn't available
if (!function_exists('read_user') && file_exists(__DIR__ . '/json_connect.php')) {
  require_once __DIR__ . '/json_connect.php';
}

$user = $user ?? null;
if ($user === null) {
  $userId = $_SESSION['user_id'] ?? $_COOKIE['user_id'] ?? null;
  if ($userId !== null && function_exists('read_user')) {
    $_SESSION['user_id'] = $userId;
    $u = read_user($userId);
    if ($u !== false) $user = is_array($u) && isset($u[0]) ? $u[0] : $u;
  }
}

$show_search = $show_search ?? false;
?>

<header class="header">
  <div class="container-fluid d-flex align-items-center navbar navbar-expand-md navbar-dark" style="position:relative;">
    <a class="navbar-brand" href="index.php">
      <img src="./public/img/Logo_Tapes.png" alt="Logo" style="width:70px;">
    </a>

    <button class="navbar-toggler d-md-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <nav class="collapse navbar-collapse justify-content-center" id="mainNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
        <li class="nav-item"><a class="nav-link" href="productos.php">Productos</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Sell</a></li>
      </ul>
    </nav>

    <div class="d-flex align-items-center ms-auto">
      <?php if (!empty($show_search)): ?>
        <!-- Compact search toggle: shows a small icon that expands a search panel (used on productos.php) -->
        <div class="position-relative me-2">
          <button class="btn btn-outline-light btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#headerSearchPanel" aria-expanded="false" aria-controls="headerSearchPanel" title="Buscar">
            <!-- simple magnifier icon (bootstrap icons not required) -->
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.85-3.85zm-5.242 1.656a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"/>
            </svg>
          </button>
          <div class="collapse header-search-panel p-2 bg-dark rounded" id="headerSearchPanel">
            <form action="productos.php" method="get" class="d-flex">
              <input class="form-control form-control-sm" type="search" name="q" placeholder="Buscar productos..." aria-label="Buscar">
              <button class="btn btn-sm btn-primary ms-2" type="submit">Ir</button>
            </form>
          </div>
        </div>
      <?php endif; ?>

      <?php if (empty($user)): ?>
        <a class="btn btn-outline-light btn-sm ms-3" href="auth/login.php">Iniciar sesión</a>
      <?php else: ?>
        <div class="dropdown ms-3">
          <a class="btn btn-outline-light btn-sm dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false"><?php echo htmlspecialchars($user['nom_usuari'] ?? $user['nom'] ?? 'Cuenta'); ?></a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="auth/profile.php">Mi perfil</a></li>
            <li><a class="dropdown-item" href="auth/logout.php">Cerrar sesión</a></li>
          </ul>
        </div>
      <?php endif; ?>
    </div>
  </div>
</header>
