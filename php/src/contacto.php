<?php
session_start();

// Inicializar variables
$nombre = $email = $asunto = $mensaje = '';
$errores = [
    "nombre" => "",
    "email" => "",
    "asunto" => "",
    "mensaje" => ""
];
$erroresHtml = ''; // Para mostrar errores generales arriba del formulario

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recoger valores del formulario
    $nombre = trim($_POST["nombre"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $asunto = trim($_POST["asunto"] ?? '');
    $mensaje = trim($_POST["mensaje"] ?? '');
    //$validarPHP = !isset($_POST["btn-validar"]); // Validar PHP solo si checkbox NO marcado

    //if ($validarPHP) {
        // Validaciones por campo
        if (empty($nombre)) $errores["nombre"] = "Por favor, ingresa tu nombre completo.";
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores["email"] = "Por favor, ingresa un correo electrónico válido.";
        if (empty($asunto)) $errores["asunto"] = "Por favor, ingresa el asunto.";
        if (empty($mensaje)) $errores["mensaje"] = "Por favor, escribe tu mensaje.";

        // Si no hay errores, redirigir con mensaje de éxito
        if (!array_filter($errores)) {
            $_SESSION['estado_envio'] = "Mensaje enviado con éxito.";
            header("Location: index.php");
            exit;
        }
    //}
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PI Lost Tapes - Contacto</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Global site styles (ensure consistent header/footer) -->
  <link rel="stylesheet" href="./public/css/estilos.css">
  <link rel="stylesheet" href="./public/css/estilo_Contacto.css" />
  <link rel="stylesheet" href="./public/css/estilo_footer.css">
  <link rel="stylesheet" href="./public/css/estilos_accesibilidad.css">

</head>
<body>
  <?php $show_search = false; include __DIR__ . '/includes/header.php'; ?>

    <!-- Mensajes generales de errores o éxito -->
    <div class="errores-php text-center mt-3">
        <?php echo $erroresHtml; ?>
        <?php
        if (isset($_SESSION['estado_envio'])) {
            echo "<p style='color:green;'>" . $_SESSION['estado_envio'] . "</p>";
            unset($_SESSION['estado_envio']);
        }
        ?>
    </div>

    <main class="container mt-5 pt-5">
        <section class="contacto">
            <h1>Contáctanos</h1>
            <p>¿Tienes alguna duda o comentario? Envíanos un mensaje y te responderemos pronto.</p>

            <form action="contacto.php" method="post" class="form-contacto">
                <label for="nombre">Nombre completo:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" value="<?php echo htmlspecialchars($nombre); ?>" />
                <span class="error"><?php echo $errores['nombre']; ?></span>

                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" placeholder="tu@correo.com" value="<?php echo htmlspecialchars($email); ?>" />
                <span class="error"><?php echo $errores['email']; ?></span>

                <label for="asunto">Asunto:</label>
                <input type="text" id="asunto" name="asunto" placeholder="Motivo del mensaje" value="<?php echo htmlspecialchars($asunto); ?>" />
                <span class="error"><?php echo $errores['asunto']; ?></span>

                <label for="mensaje">Mensaje:</label>
                <textarea id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí..."><?php echo htmlspecialchars($mensaje); ?></textarea>
                <span class="error"><?php echo $errores['mensaje']; ?></span>

                <label for="validar">Validar por JavaScript</label>
                <input type="checkbox" id="btn-validar" name="btn-validar" value="1" <?php echo isset($_POST['btn-validar']) ? 'checked' : ''; ?>>

                <button type="submit">Enviar</button>
            </form>
        </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <script src="./js/validacion.js"></script>
    
    <?php include __DIR__ . '/includes/accesibilidad.php'; ?>

    <script src="./js/accesibilidad.js"></script>
</body>
</html>
