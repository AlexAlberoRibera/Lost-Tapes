<?php
session_start();

$erroresHtml = ''; // Para mostrar errores dentro del HTML

// Validación por servidor (PHP) solo si el checkbox NO está marcado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $asunto = trim($_POST["asunto"] ?? '');
    $mensaje = trim($_POST["mensaje"] ?? '');
    $validarPHP = !isset($_POST["btn-validar"]); // PHP solo valida si checkbox no marcado

    $errores = [];

    if ($validarPHP) {
        if (empty($nombre)) $errores[] = "Por favor, ingresa tu nombre completo (PHP).";
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "Por favor, ingresa un correo electrónico válido (PHP).";
        if (empty($asunto)) $errores[] = "Por favor, ingresa el asunto (PHP).";
        if (empty($mensaje)) $errores[] = "Por favor, escribe tu mensaje (PHP).";

        if (!empty($errores)) {
            foreach ($errores as $error) {
                $erroresHtml .= "<p style='color:red; margin:5px 0;'>$error</p>";
            }
        } else {
            $_SESSION['estado_envio'] = "Mensaje enviado con éxito.";
            header("Location: index.php");
            exit;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PI Lost Tapes</title>
  <link rel="stylesheet" href="./public/css/estilo_Contacto.css" />
</head>
<body>
  <header>
    <img src="./public/img/Logo Tapes.png" alt="Logo Tapes" />
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="contacto.php" class="active">Contacto</a></li>
        <li><a href="#">Productos</a></li>
        <li><a href="#">Sell</a></li>
      </ul>
    </nav>
  </header>

  <!-- Mensajes de PHP justo debajo del header -->
  <div class="errores-php" style="margin-top:90px; text-align:center;">
      <?php echo $erroresHtml; ?>
      <?php
      if (isset($_SESSION['estado_envio'])) {
          echo "<p style='color:green;'>" . $_SESSION['estado_envio'] . "</p>";
          unset($_SESSION['estado_envio']);
      }
      ?>
  </div>

  <main>
    <section class="contacto">
      <h1>Contáctanos</h1>
      <p>¿Tienes alguna duda o comentario? Envíanos un mensaje y te responderemos pronto.</p>

      <form action="contacto.php" method="post" class="form-contacto">
        <label for="nombre">Nombre completo:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" />

        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" placeholder="tu@correo.com"/>

        <label for="asunto">Asunto:</label>
        <input type="text" id="asunto" name="asunto" placeholder="Motivo del mensaje"/>

        <label for="mensaje">Mensaje:</label>
        <textarea id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí..."></textarea>

        <label for="validar">Validar por JavaScript</label>
        <input type="checkbox" id="btn-validar" name="btn-validar" value="1">

        <button type="submit">Enviar</button>
      </form>
    </section>
  </main>

  <script src="./js/validacion.js"></script>
</body>
</html>
