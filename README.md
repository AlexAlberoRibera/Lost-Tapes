## Comparació autenticació manual vs Laravel Breeze
En el sprint2 la autenticacion se hacia manualmente con sessions y cookies gestionandolo en php junto con comprobaciones 
de credencial y control de acceso

Ahora en Sprint3(Laravel Breeze) usa autenticacion que queda dentro del framework usando middleware para la autenticacion, eloquent para el usuario, hashing automatico de contraseñas y rutas predefinidas como login y register, reduciendo codigo repetido separando mejor las responsabilidades y mejorando la seguridad




# API de Productes (Sprint 4)

La SPA consumirà aquesta API per mostrar productes.

Rutes disponibles:

- GET /api/products → Llista paginada de productes
  - Paràmetres opcionals: category, q, per_page
- GET /api/products/{id} → Detall d’un producte

- /admin/products → Ver productos
- /products/import → Importar csv



# Como arrancar el proyecto

./vendor/bin/sail up -d

npm run build(esto no lo se)




# Lost Tapes - BackEnd(Laravel)

Breve descripción de qué hace la aplicación.

---

## Requisitos previos

Asegúrate de tener instalado en tu máquina:

- PHP >= 8.1
- Composer
- Node.js >= 18.x y npm
- MySQL (u otro gestor de base de datos compatible)
- Git

---

## Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/AlexAlberoRibera/Lost-Tapes.git
cd tu-repo
```

### 2. Instalar dependencias PHP
```bash
composer install
```

### 3. Instalar dependencias JavaScript
```bash
npm install
```

### 4. Configurar el entorno
```bash
cp .env.example .env
php artisan key:generate
```

Edita el archivo `.env` y configura al menos lo siguiente:
```env
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

### 5. Crear la base de datos y ejecutar migraciones
```bash
php artisan migrate
```

Si el proyecto incluye datos de prueba:
```bash
php artisan db:seed
```

### 6. Enlazar el storage
```bash
php artisan storage:link
```

### 7. Compilar los assets
```bash
npm run dev
# o en producción:
npm run build
```

### 8. Arrancar el servidor local
```bash
php artisan serve
```

La aplicación estará disponible en [http://localhost:8000](http://localhost:8000).

---

## Comandos útiles

| Comando | Descripción |
|---|---|
| `php artisan migrate:fresh --seed` | Resetea la BD y vuelve a poblarla |
| `php artisan cache:clear` | Limpia la caché de la app |
| `php artisan config:clear` | Limpia la caché de configuración |
| `php artisan route:clear` | Limpia la caché de rutas |
| `php artisan queue:work` | Arranca el worker de colas (si aplica) |