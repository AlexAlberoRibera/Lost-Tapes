<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lost Tapes — API</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Inter:wght@300;400;600&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --red:  #c0392b;
      --gold: #e8a020;
      --dark: #0d0d0d;
      --text: #e2e2e2;
      --muted: #666;
    }

    body {
      background: var(--dark);
      color: var(--text);
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px 24px;
    }

    .label {
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px;
      letter-spacing: 4px;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: 20px;
    }

    h1 {
      font-family: 'Playfair Display', serif;
      font-size: clamp(56px, 10vw, 96px);
      font-weight: 900;
      letter-spacing: 6px;
      text-transform: uppercase;
      color: #fff;
      line-height: 1;
    }

    h1 span { color: var(--red); }

    .rule {
      width: 50px;
      height: 2px;
      background: var(--red);
      margin: 24px auto;
    }

    .subtitle {
      font-family: 'JetBrains Mono', monospace;
      font-size: 12px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: 48px;
    }

    .btn {
      display: inline-block;
      font-family: 'Inter', sans-serif;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: 2px;
      text-transform: uppercase;
      text-decoration: none;
      color: #fff;
      background: var(--red);
      padding: 14px 36px;
      border-radius: 3px;
      transition: background 0.2s;
    }

    .btn:hover { background: #a93226; }

    .endpoints {
      margin-top: 64px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 12px;
      width: 100%;
      max-width: 680px;
    }

    .endpoint {
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.07);
      border-radius: 6px;
      padding: 14px 16px;
    }

    .endpoint-tag {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 8px;
    }

    .endpoint ul {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    .endpoint li {
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px;
      color: var(--muted);
    }

    .endpoint li span {
      display: inline-block;
      width: 38px;
      font-weight: 600;
      color: var(--red);
    }

    footer {
      margin-top: 64px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      letter-spacing: 2px;
      color: #333;
      text-transform: uppercase;
    }
  </style>
</head>
<body>

  <p class="label">API REST · Proyecto Intermodular 2DAW</p>
  <h1>Lost <span>Tapes</span></h1>
  <div class="rule"></div>
  <p class="subtitle">Laravel 11 · Sanctum · OpenAPI 3.0</p>

  <a href="/api/documentation" class="btn">Ver documentación Swagger</a>

  <div class="endpoints">
    <div class="endpoint">
      <p class="endpoint-tag">Auth</p>
      <ul>
        <li><span>POST</span> /api/login</li>
        <li><span>POST</span> /api/logout</li>
        <li><span>GET</span> /api/user</li>
        <li><span>GET</span> /auth/google</li>
      </ul>
    </div>
    <div class="endpoint">
      <p class="endpoint-tag">Products</p>
      <ul>
        <li><span>GET</span> /api/products</li>
        <li><span>GET</span> /api/products/{id}</li>
        <li><span>POST</span> /api/products</li>
        <li><span>PUT</span> /api/products/{id}</li>
        <li><span>DELETE</span> /api/products/{id}</li>
      </ul>
    </div>
    <div class="endpoint">
      <p class="endpoint-tag">Interacción</p>
      <ul>
        <li><span>POST</span> /api/products/{id}/like</li>
        <li><span>POST</span> /api/products/{id}/comments</li>
      </ul>
    </div>
  </div>

  <footer>Manel · Alex · Maxi · 2025–2026</footer>

</body>
</html>
