<?php
require_once __DIR__ . '/../includes/json_connect.php';
session_start();

$nom = $cognoms = $email = $contrasenya = $contrasenya_confirm = $nom_usuari = $data_registre ='';

//crear array de errores con campos especificos para cada error
$errores= [
    "nom_usuari" => "",
    "nom" => "",
    "cognoms" => "",
    "email" => "",
    "contrasenya" => "",
    "contrasenya_confirm" => "",
    "data_registre" => "",
    "global" => "",


];

// process only on POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // recibir valores del post
  $nom_usuari = trim($_POST['nom_usuari'] ?? '');
  $nom = trim($_POST['nom'] ?? '');
  $cognoms = trim($_POST['cognoms'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $contrasenya = trim($_POST['contrasenya'] ?? '');
  $contrasenya_confirm = trim($_POST['contrasenya_confirm'] ?? '');

  // validaciones varias para los campos
  if (empty($nom_usuari)) $errores['nom_usuari'] = 'Por favor, ingresa tu nombre de usuario';
  if (empty($nom)) $errores['nom'] = 'Por favor, ingresa tu nombre.';
  if (empty($cognoms)) $errores['cognoms'] = 'Por favor, ingresa tus apellidos completos.';
  if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores['email'] = 'Por favor, ingresa un correo electrónico válido.';
  if (empty($contrasenya)) $errores['contrasenya'] = 'Por favor, ingresa la contraseña.';
  if ($contrasenya !== $contrasenya_confirm) $errores['contrasenya_confirm'] = 'Las contraseñas no coinciden.';

  // uso de validar_contraseña definido en json_connect.php, en caso de que la contraseña no este vacía
  if (!empty($contrasenya)) {
    $errores_contrasenya = validar_contrasenya($contrasenya, $contrasenya_confirm, 6, 12);
    if (!empty($errores_contrasenya)) {
      $errores['contrasenya'] = implode(' ', $errores_contrasenya);
    }
  }

  if (empty(array_filter($errores))) {
    // buscar por email
    $busquedaEmail = read_user(null, ['email' => $email]);
    if ($busquedaEmail === false) {
      error_log('json_connect error: read_user returned false for email check. base=' . JSON_SERVER_BASE);
      $errores['global'] = 'No se ha podido conectar con el servicio. Comprueba que el json-server está activo en ' . JSON_SERVER_BASE . ' (ruta /users).';
    } else {
      if (!empty($busquedaEmail)) $errores['email'] = 'Ya existe una cuenta con ese correo.';
    }

    // buscar por nombre de usuario
    $busquedaUsuario = read_user(null, ['nom_usuari' => $nom_usuari]);
    if ($busquedaUsuario === false) {
      if ($errores['global'] === '') {
        error_log('json_connect error: read_user returned false for username check. base=' . JSON_SERVER_BASE);
        $errores['global'] = 'No se ha podido conectar con el servicio. Comprueba que el json-server está activo en ' . JSON_SERVER_BASE . ' (ruta /users).';
      }
    } else {
      if (!empty($busquedaUsuario)) $errores['nom_usuari'] = 'Ya existe una cuenta con ese nombre de usuario.';
    }
  }

  // Si todo sigue sin errores, crear el usuario
  if (empty(array_filter($errores))) {
    $hash = password_hash($contrasenya, PASSWORD_DEFAULT);
    $data = [
      'nom_usuari' => $nom_usuari,
      'contrasenya' => $hash,
      'cognoms' => $cognoms,
      'email' => $email,
      'nom' => $nom,
      'data_registre' => date('c')
    ];

    $postResult = write_user($data);
    if ($postResult === false) {
      error_log('json_connect POST error: write_user returned false. base=' . JSON_SERVER_BASE);
      $errores['global'] = 'No se pudo crear la cuenta en este momento. Comprueba que el json-server está activo en ' . JSON_SERVER_BASE . ' (ruta /users).';
    } else {
      $_SESSION['estado_envio'] = 'Usuario registrado con éxito. Ya puedes iniciar sesión.';
      header('Location: login.php');
      exit;
    }
  }
}

?>


<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Registro</title>
  <link rel="stylesheet" href="../public/css/estilo_Auth.css">
</head>
<body>
  <main class="auth-wrapper">

    <div class="auth-card">
      <h1>Crear cuenta</h1>

      <?php if (!empty($_SESSION['user_id']) || !empty($_COOKIE['user_id'])): ?>
        <div style="margin-bottom:10px;">
          Estás conectado. <a href="logout.php" style="color:#fff;background:#b33;padding:6px 8px;border-radius:6px;text-decoration:none;">Cerrar sesión</a>
        </div>
      <?php endif; ?>

    <!-- Mensaje flash (desde $_SESSION tras registro exitoso) -->
    <?php if (!empty($_SESSION['estado_envio'])): ?>
      <div class="flash"><?= htmlspecialchars($_SESSION['estado_envio'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div>
      <?php unset($_SESSION['estado_envio']); ?>
    <?php endif; ?>

    <!-- Mensaje global de error -->
    <?php if (!empty($errores['global'])): ?>
      <div class="global-error"><?= htmlspecialchars($errores['global'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div>
    <?php endif; ?>
  <form method="post" action="">

      <div class="campo">
        <label for="nom_usuari">Nombre de usuario</label>
        <input id="nom_usuari" name="nom_usuari" type="text" value="<?= htmlspecialchars($nom_usuari ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
        <?php if (!empty($errores['nom_usuari'])): ?><div class="error"><?= htmlspecialchars($errores['nom_usuari'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div><?php endif; ?>
      </div>

      <div class="campo">
        <label for="nombre">Nombre real</label>
        <input id="nom" name="nom" type="text" value="<?= htmlspecialchars($nom ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
        <?php if (!empty($errores['nom'])): ?><div class="error"><?= htmlspecialchars($errores['nom'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div><?php endif; ?>
      </div>

      <div class="campo">
        <label for="cognoms">Apellidos</label>
        <input id="cognoms" name="cognoms" type="text" value="<?= htmlspecialchars($cognoms ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
        <?php if (!empty($errores['cognoms'])): ?><div class="error"><?= htmlspecialchars($errores['cognoms'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div><?php endif; ?>
      </div>

      <div class="campo">
        <label for="email">Correo electrónico</label>
        <input id="email" name="email" type="email" value="<?= htmlspecialchars($email ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
        <?php if (!empty($errores['email'])): ?><div class="error"><?= htmlspecialchars($errores['email'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div><?php endif; ?>
      </div>

      <div class="campo">
        <label for="contrasenya">Contraseña</label>
        <input id="contrasenya" name="contrasenya" type="password" autocomplete="new-password">
        <?php if (!empty($errores['contrasenya'])): ?><div class="error"><?= htmlspecialchars($errores['contrasenya'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div><?php endif; ?>
        <small>Requerimientos: mínimo 6 caracteres, incluir mayúscula, minúscula y número.</small>
      </div>

      <div class="campo">
        <label for="contrasenya_confirm">Confirmar contraseña</label>
        <input id="contrasenya_confirm" name="contrasenya_confirm" type="password" autocomplete="new-password">
        <?php if (!empty($errores['contrasenya_confirm'])): ?><div class="error"><?= htmlspecialchars($errores['contrasenya_confirm'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div><?php endif; ?>
      </div>

      <div class="auth-actions">
        <div class="muted">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></div>
        <button class="btn" type="submit">Crear cuenta</button>
      </div>
    </form>
    </div>
  </main>
</body>
</html>