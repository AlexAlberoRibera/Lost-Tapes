<?php
session_start();
//Validacion por servidor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = trim($_POST["nombre"]) ?? '';
  $email = trim($_POST["email"]);
  $asunto = trim($_POST["asunto"]);
  $mensaje = trim($_POST["mensaje"]);
  $validar = isset($_POST["btn-validar"]);

  $errores = [];


  if ($validar) {
    // Validar nombre
    if (empty($nombre)) {
      $errores[] = "Por favor, ingresa tu nombre completo.";
    }

    // Validar correo electrónico
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errores[] = "Por favor, ingresa un correo electrónico válido.";
    }

    // Validar asunto
    if (empty($asunto)) {
      $errores[] = "Por favor, ingresa el asunto.";
    }

    if (empty($mensaje)) {
      $errores[] = "Por favor, escribe tu mensaje.";
    }

    if (!empty($errores)) {
      foreach ($errores as $error) {
        echo "<p style='color:red;'>$error</p>";
      }
    } else {
      $_SESSION['estado_envio'] = "Mensaje enviado con éxito.";
      header("Location: index.php");
      exit;
    }
  }
}

//Checkbox para validar con js
?>



<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PI Lost Tapes</title>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="./public/css/estilo_Contacto.css" />
</head>

<body>
  <header>
    <img src="./public/img/Logo Tapes.png" alt="Logo Tapes" />
    <nav>
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="contacto.php" class="active">Contacto</a></li>
        <li><a href="#">Productos</a></li>
        <li><a href="#">Sell</a></li>
      </ul>
    </nav>

    <form class="search-bar" action="#" method="get">
      <input type="text" name="q" placeholder="Buscar..." />
      <button type="submit">Buscar</button>
    </form>
  </header>
  <main>
    <section class="contacto">
      <h1>Contáctanos</h1>
      <p>¿Tienes alguna duda o comentario? Envíanos un mensaje y te responderemos pronto.</p>

      <form action="contacto.php" method="post" class="form-contacto">
        <label for="nombre">Nombre completo:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" required />

        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" placeholder="tu@correo.com" required />

        <label for="asunto">Asunto:</label>
        <input type="text" id="asunto" name="asunto" placeholder="Motivo del mensaje" required />

        <label for="mensaje">Mensaje:</label>
        <textarea id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí..." required></textarea>
        <label for="validar">Validar por Servidor</label>
        <input type="checkbox" id="btn-validar" name="btn-validar" value="1">

        <button type="submit">Enviar</button>
      </form>
    </section>
  </main>
  <script src="./js/validacion.js"></script>

</body>

</html>