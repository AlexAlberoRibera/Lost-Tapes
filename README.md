# COMO ARRANCAR EL SERVIDOR:
Colocamos en la terminal en la raíz del servidor el siguiente comando:

```bash
docker compose up -d
```

Para inicializar el json-server pondremos el siguiente comando
```bash
json-server --watch data/peliculas.json --port 3000
```
# DIRECCIONES WEB:
Para poder ver la pagina principal una vez que el servidor compose se haya iniciado será la siguiente URL:
```bash
http://localhost/index.html
```

Y el formulario de contacto podemos si ya entramos por la URL anterior clickear el apartado "Contacto" pero si quieres ver la URL aqui esta:
```bash
http://localhost/contacto.html
```

# Estructura:

```bash
.
├── docker-compose.yaml
├── docs
│   ├── GantBasic.png
│   ├── img.png
│   ├── Kanban.png
│   ├── recursos.md
│   ├── RISKS.md
│   └── roles.md
├── Ecommerce-PI.iml
├── php
│   ├── php
│   │   └── src
│   └── src
│       ├── contacto.php
│       ├── index.php
│       ├── js
│       │   ├── carousel.js
│       │   ├── main.js
│       │   ├── rotador_peliculas.js
│       │   └── validacion.js
│       ├── public
│       │   ├── css
│       │   │   ├── estilo_Contacto.css
│       │   │   ├── estilo_footer.css
│       │   │   ├── estilos_carrusel.css
│       │   │   ├── estilos.css
│       │   │   ├── estilos.css.map
│       │   │   └── estilos_peliculas.css
│       │   ├── data
│       │   │   └── peliculas.json
│       │   ├── img
│       │   │   ├── bkgdHQ.jpg
│       │   │   ├── bkgdLQ.jpg
│       │   │   ├── Dictador.jpg
│       │   │   ├── harakiri.png
│       │   │   ├── kigbutter.png
│       │   │   ├── ladron.png
│       │   │   ├── Logo_Tapes.png
│       │   │   ├── Looney_Tunes.png
│       │   │   ├── peliculas
│       │   │   │   ├── andreiRublev
│       │   │   │   ├── brandedToKill
│       │   │   │   └── harakiri
│       │   │   ├── Trap_Story.png
│       │   │   └── Woppenheimer.png
│       │   ├── scss
│       │   │   ├── estilos.scss
│       │   │   ├── _footer.scss
│       │   │   ├── _header.scss
│       │   │   ├── _main.scss
│       │   │   ├── _peliculas.scss
│       │   │   └── _variables.scss
│       │   └── videos
│       │       ├── fondo.mp4
│       │       └── whiteMare.mp4
│       ├── upload_handler.php
│       ├── upload.html
│       └── uploads
│           ├── file_692c86d09fcf3_ejemplo.csv
│           ├── file_692c87bf67072_ejemplo.csv
│           └── file_692c8993c2d61_ejemplo.csv
└── README.md
```


# KANBAN

![Kanban](docs/Kanban.png)

# RIESGOS
Aqui tienes una redireccion al fichero que contiene la informacion sobre los riesgos
[Documentación de los riesgos](/docs/RISKS.md)


# GANT BASIC
![Kanban](/docs/GantBasic.png)

# ROLES
Aqui hay un documento md con los roles que hay en el equipo
[Documentación de los roles](/docs/roles.md)

# Recursos
Aqui mostraremos los recursos utilizados en nuestro proyecto
[Documentación de los recursos](/docs/recursos.md)


