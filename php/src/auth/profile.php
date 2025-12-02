<?php
require_once __DIR__ . '/../includes/json_connect.php';
session_start();

$user = null;
$userId = null;
if (!empty($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} elseif (!empty($_COOKIE['user_id'])) {
    $userId = $_COOKIE['user_id'];
    $_SESSION['user_id'] = $userId;
}

if (empty($userId)) {
    header('Location: login.php');
    exit;
}

// fetch user
$user = read_user($userId);
if ($user === false) {
    // could not connect
    $error = 'No se ha podido obtener la información del usuario. Intenta más tarde.';
} elseif (is_array($user) && isset($user[0])) {
    // when filtering by id, json-server may still return array in some setups
    $user = $user[0];
}

$message = '';
$error = $error ?? '';

// handle update (PATCH)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patch = [];
    $nom = trim($_POST['nom'] ?? '');
    $cognoms = trim($_POST['cognoms'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($nom !== ($user['nom'] ?? '')) $patch['nom'] = $nom;
    if ($cognoms !== ($user['cognoms'] ?? '')) $patch['cognoms'] = $cognoms;
    if ($email !== ($user['email'] ?? '')) $patch['email'] = $email;

    if (!empty($patch)) {
        $res = json_patch('/users/' . urlencode((string)$userId), $patch);
        if ($res === false) {
            $error = 'No se pudo actualizar la información. Intenta más tarde.';
        } else {
            $message = 'Perfil actualizado con éxito.';
            // refresh user data
            $user = read_user($userId);
            if (is_array($user) && isset($user[0])) $user = $user[0];
        }
    } else {
        $message = 'No hay cambios para guardar.';
    }
}

?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Perfil</title>
  <link rel="stylesheet" href="../public/css/estilo_Auth.css">
</head>
<body>
  <main class="auth-wrapper">
    <div class="auth-card">
      <h1>Perfil de <?= htmlspecialchars($user['nom_usuari'] ?? 'usuario', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></h1>
      <?php if (!empty($error)): ?>
        <div class="global-error"><?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div>
      <?php endif; ?>
      <?php if (!empty($message)): ?>
        <div class="flash"><?= htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div>
      <?php endif; ?>

      <form method="post" action="">
        <div class="campo">
          <label for="nom_usuari">Nombre de usuario</label>
          <input id="nom_usuari" name="nom_usuari" type="text" value="<?= htmlspecialchars($user['nom_usuari'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>" disabled>
        </div>

        <div class="campo">
          <label for="nom">Nombre</label>
          <input id="nom" name="nom" type="text" value="<?= htmlspecialchars($user['nom'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
        </div>

        <div class="campo">
          <label for="cognoms">Apellidos</label>
          <input id="cognoms" name="cognoms" type="text" value="<?= htmlspecialchars($user['cognoms'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
        </div>

        <div class="campo">
          <label for="email">Correo electrónico</label>
          <input id="email" name="email" type="email" value="<?= htmlspecialchars($user['email'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
        </div>

        <div class="auth-actions">
          <a class="muted" href="logout.php">Cerrar sesión</a>
          <button class="btn" type="submit">Guardar cambios</button>
        </div>
      </form>
    </div>
  </main>
</body>
</html>
