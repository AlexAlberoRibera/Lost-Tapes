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

      <form action="/enviar-contacto" method="post" class="form-contacto">
        <label for="nombre">Nombre completo:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" required />

        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" placeholder="tu@correo.com" required />

        <label for="asunto">Asunto:</label>
        <input type="text" id="asunto" name="asunto" placeholder="Motivo del mensaje" required />

        <label for="mensaje">Mensaje:</label>
        <textarea id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí..." required></textarea>

        <button type="submit">Enviar</button>
      </form>
    </section>
  </main>
</body>
</html>
