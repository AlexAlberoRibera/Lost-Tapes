# Lost Tapes — Backend

API REST para la tienda de cine de culto Lost Tapes. Proyecto intermodular 2DAW.  
**Repo frontend:** [ManelDAW/Lost-Tapes](https://github.com/ManelDAW/Lost-Tapes) (rama `rama-sprint5`)

---

## Índice

1. [Tecnologías](#tecnologías)
2. [Instalación y arranque](#instalación-y-arranque)
3. [Variables de entorno](#variables-de-entorno)
4. [Rutas API](#rutas-api)
5. [Rutas OAuth2](#rutas-oauth2)
6. [Roles y permisos](#roles-y-permisos)
7. [Importación CSV](#importación-csv)
8. [Documentación Swagger](#documentación-swagger)
9. [Iteración 4 — Autenticación con Sanctum](#iteración-4--autenticación-con-sanctum)
10. [Iteración 5/6 — OAuth2, Docker y correcciones](#iteración-56--oauth2-docker-y-correcciones)
11. [Docker](#docker)
12. [Comandos útiles](#comandos-útiles)
13. [Usuarios de prueba](#usuarios-de-prueba)
14. [Pendiente](#pendiente)

---

## Tecnologías

| Capa | Tecnología |
|------|-----------|
| Framework | Laravel 11 |
| Autenticación | Laravel Sanctum (tokens Bearer) |
| OAuth2 | Laravel Socialite |
| Base de datos | MySQL |
| Importación CSV | maatwebsite/excel |
| Documentación API | Swagger (L5-Swagger) |

---

## Instalación y arranque

```bash
git clone https://github.com/AlexAlberoRibera/Lost-Tapes.git
cd Lost-Tapes
git checkout rama-sprint5
composer install
cp .env.example .env
php artisan key:generate
```

Editar `.env` con los datos de la base de datos (ver sección siguiente), luego:

```bash
php artisan migrate --seed
php artisan serve     # http://localhost:8000
```

MySQL debe estar corriendo antes de arrancar: `sudo systemctl start mysql`

Para crear la base de datos y el usuario en MySQL:

```sql
CREATE DATABASE losttapes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'losttapes'@'localhost' IDENTIFIED BY 'losttapes123';
GRANT ALL PRIVILEGES ON losttapes.* TO 'losttapes'@'localhost';
```

---

## Variables de entorno

```env
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=losttapes
DB_USERNAME=losttapes
DB_PASSWORD=losttapes123

FRONTEND_URL=http://localhost:5173

GOOGLE_CLIENT_ID=tu_client_id
GOOGLE_CLIENT_SECRET=tu_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

Las credenciales de Google se obtienen en Google Cloud Console → APIs y servicios → Credenciales → Crear credencial OAuth 2.0.

---

## Rutas API

| Método | Ruta | Auth | Descripción |
|--------|------|------|-------------|
| POST | `/api/login` | No | Login con email+password → devuelve token Sanctum |
| POST | `/api/logout` | Sanctum | Cierra sesión y elimina el token actual |
| GET | `/api/user` | Sanctum | Datos del usuario autenticado |
| GET | `/api/products` | No | Lista paginada (filtros: `q`, `category`) |
| GET | `/api/products/{id}` | No | Detalle de un producto |
| POST | `/api/products` | Sanctum | Crear producto |
| PUT/PATCH | `/api/products/{id}` | Sanctum | Actualizar producto |
| DELETE | `/api/products/{id}` | Sanctum | Eliminar producto |

---

## Rutas OAuth2

| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/auth/google` | Redirige al usuario a Google para autenticación |
| GET | `/auth/google/callback` | Callback de Google: crea/actualiza usuario, genera token y redirige al frontend |

---

## Roles y permisos

| Rol | Permisos en la API |
|-----|--------------------|
| user / editor | Solo lectura (GET) |
| vendedor | Lectura + crear y editar productos |
| admin | Acceso completo incluyendo eliminar |

Las rutas de escritura están protegidas con el middleware `auth:sanctum`. El frontend también aplica guards por rol, pero la protección real está en el backend.

---

## Importación CSV

El archivo debe tener una fila de cabecera con estos nombres exactos:

```
sku,name,description,price,stock,image,category
```

- `sku`, `name`, `price` y `stock` son obligatorios. Las filas que los tengan vacíos se ignoran.
- `price` acepta tanto punto como coma decimal (`12.99` o `12,99`).
- `image` debe ser el nombre del archivo (ej: `harakiri.jpg`), que tiene que estar en `public/images/`.

---

## Documentación Swagger

La documentación interactiva de la API está disponible en:

```
http://localhost:8000/api/documentation
```

Generada automáticamente con L5-Swagger a partir de anotaciones en los controladores. Permite consultar y probar todos los endpoints sin necesidad de un cliente externo.

---

## Iteración 4 — Autenticación con Sanctum

### Rutas de login/logout (`routes/api.php`)

Se añadieron las rutas de autenticación que faltaban:

- `POST /api/login` — valida credenciales, crea token Sanctum, devuelve `{ token, user }`
- `POST /api/logout` — elimina el token actual (requiere `auth:sanctum`)
- `GET /api/user` — devuelve los datos del usuario autenticado (requiere `auth:sanctum`)

### Trait `HasApiTokens` en User (`app/Models/User.php`)

`createToken()` fallaba porque el modelo no tenía el trait de Sanctum:

```php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['name', 'email', 'password', 'role', 'google_id'];
}
```

---

## Iteración 5/6 — OAuth2, Docker y correcciones

### OAuth2 con Google (Socialite)

**Archivos:** `app/Http/Controllers/Auth/SocialAuthController.php`, `config/services.php`, `routes/web.php`, migración `add_google_id_to_users_table`

**Paquete:** `laravel/socialite`

Flujo:
1. Frontend redirige a `GET /auth/google`
2. Socialite redirige a Google con `client_id`, `redirect_uri` y `scope`
3. Google devuelve al callback con un código
4. Backend canjea el código por los datos del usuario (email, nombre)
5. `updateOrCreate` del usuario en la base de datos
6. Genera token Sanctum y redirige al frontend: `/auth/callback?token=X&name=Y&role=Z`

### Correcciones críticas aplicadas

| Archivo | Problema | Solución |
|---------|----------|----------|
| `StoreProductRequest.php` | No existía → `ReflectionException` fatal | Creado desde cero |
| `UpdateProductRequest.php` | Regla `unique` incorrecta, `in:pelicula` bloqueaba categorías | Corregido |
| `ProductController.php` | `->validated()` sobre `Request` base → `BadMethodCallException` | Usa FormRequest |
| `User.php` | `role` no estaba en `$fillable` | Añadido |
| `ProductsImport.php` | Sin validación de filas vacías | Añadido null check |
| `routes/api.php` | Ruta duplicada, sin separación público/protegido | Rutas explícitas |
| `Dockerfile` | Era de Node.js copiado del frontend | Reescrito para PHP 8.2-fpm |
| `ProductSeeder.php` | Imagen con espacio en nombre, 12 imágenes inexistentes | Corregidas |

---

## Docker

Tres servicios definidos en `docker-compose.yml`:

| Servicio | Imagen | Puerto |
|----------|--------|--------|
| `app` | PHP 8.2-fpm (Dockerfile propio) | — |
| `webserver` | nginx:alpine | 8000 |
| `db` | mysql:8.0 | 3306 |

```bash
# Levantar todo
docker compose up -d

# Primera vez: migraciones y seed
docker compose exec app php artisan migrate --seed

# Ver logs
docker compose logs -f
```

La configuración de nginx está en `docker/nginx.conf`.

---

## Comandos útiles

| Comando | Descripción |
|---------|-------------|
| `php artisan migrate:fresh --seed` | Resetear BD y poblar de cero |
| `php artisan cache:clear` | Limpiar caché de la app |
| `php artisan config:clear` | Limpiar caché de configuración |
| `php artisan route:list` | Ver todas las rutas registradas |
| `php artisan serve` | Servidor de desarrollo en localhost:8000 |

---

## Usuarios de prueba

| Email | Contraseña | Rol |
|-------|-----------|-----|
| `admin@example.com` | `1234` | admin |
| `user@example.com` | `1234` | user |

Para login con Google: configurar `GOOGLE_CLIENT_ID` y `GOOGLE_CLIENT_SECRET` en `.env` con credenciales reales de Google Cloud Console.

---

## Pendiente

| Tarea | Motivo |
|-------|--------|
| OAuth2 Google en producción | Código listo — faltan credenciales del dominio real en Google Console |
| DNS `pigrupox.ddaw.es` | Lo configura el compañero en AWS |
| CI/CD automatizado | Requiere acceso al servidor EC2 |
| HTTPS / Let's Encrypt | Requiere servidor en producción |
