<?php
require_once __DIR__ . '/../includes/json_connect.php';
session_start();

$flash = '';
if (!empty($_SESSION['estado_envio'])) {
  $flash = $_SESSION['estado_envio'];
  unset($_SESSION['estado_envio']);
}

$errores = ['global' => '', 'nom_usuari' => '', 'contrasenya' => ''];
$nom_usuari = $contrasenya = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_usuari = trim($_POST['nom_usuari'] ?? '');
    $contrasenya = trim($_POST['contrasenya'] ?? '');

    if (empty($nom_usuari)) $errores['nom_usuari'] = 'Por favor, ingresa tu nombre de usuario';
    if (empty($contrasenya)) $errores['contrasenya'] = 'Por favor, ingresa la contraseña';

    if (empty(array_filter($errores))) {
        // buscar usuario por nombre de usuario
        $res = read_user(null, ['nom_usuari' => $nom_usuari]);
        if ($res === false) {
            error_log('json_connect error: read_user returned false for login');
            $errores['global'] = 'Error al conectar con el servicio. Intenta más tarde.';
        } else {
            if (empty($res)) {
                $errores['global'] = 'Usuario o contraseña incorrectos.';
            } else {
                // json-server devuelve array al filtrar
                $usuario = is_array($res) ? $res[0] : $res;
                if (!isset($usuario['contrasenya']) || !password_verify($contrasenya, $usuario['contrasenya'])) {
                    $errores['global'] = 'Usuario o contraseña incorrectos.';
                } else {
          // login ok
          $_SESSION['user_id'] = $usuario['id'];
          setcookie('user_id', $usuario['id'], time() + 3600, '/');
          header('Location: ../index.php');
          exit;
                }
            }
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="../public/css/estilo_Auth.css">
</head>
<body>
  <main class="auth-wrapper">
    <div class="auth-card">
      <h1>Iniciar sesión</h1>
      <?php if (!empty($flash)): ?><div class="flash"><?= htmlspecialchars($flash, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div><?php endif; ?>
      <?php if (!empty($errores['global'])): ?><div class="global-error"><?= htmlspecialchars($errores['global'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div><?php endif; ?>
      <form method="post" action="">
        <div class="campo">
          <label for="nom_usuari">Nombre de usuario</label>
          <input id="nom_usuari" name="nom_usuari" type="text" value="<?= htmlspecialchars($nom_usuari ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
          <?php if (!empty($errores['nom_usuari'])): ?><div class="error"><?= htmlspecialchars($errores['nom_usuari'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div><?php endif; ?>
        </div>
        <div class="campo">
          <label for="contrasenya">Contraseña</label>
          <input id="contrasenya" name="contrasenya" type="password" autocomplete="current-password">
          <?php if (!empty($errores['contrasenya'])): ?><div class="error"><?= htmlspecialchars($errores['contrasenya'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div><?php endif; ?>
        </div>

        <div class="auth-actions">
          <div class="muted">¿No tienes cuenta? <a href="register.php">Regístrate</a></div>
          <button class="btn" type="submit">Entrar</button>
        </div>
      </form>
    </div>
  </main>
</body>
</html>
