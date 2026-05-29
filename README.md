# Lost Tapes — Backend (Laravel)

API REST para la tienda de cine de culto Lost Tapes. Proyecto intermodular DAW.

---

## Tecnologías

| | |
|---|---|
| Framework | Laravel 11 |
| Autenticación | Laravel Breeze + Sanctum |
| Base de datos | MySQL |
| Importación CSV | maatwebsite/excel |
| Documentación API | Swagger (L5-Swagger) |

---

## Requisitos previos

- PHP >= 8.2
- Composer
- MySQL
- Git

---

## Instalación

```bash
# 1. Clonar el repo
git clone https://github.com/AlexAlberoRibera/Lost-Tapes.git
cd Lost-Tapes

# 2. Instalar dependencias
composer install

# 3. Configurar entorno
cp .env.example .env
php artisan key:generate

# 4. Configurar .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# 5. Migrar y poblar la base de datos
php artisan migrate --seed

# 6. Arrancar el servidor
php artisan serve
```

---

## Rutas API

| Método | Ruta | Auth | Descripción |
|--------|------|------|-------------|
| GET | `/api/products` | No | Lista paginada (filtros: `q`, `category`) |
| GET | `/api/products/{id}` | No | Detalle de un producto |
| POST | `/api/products` | Sanctum | Crear producto |
| PUT/PATCH | `/api/products/{id}` | Sanctum | Actualizar producto |
| DELETE | `/api/products/{id}` | Sanctum | Eliminar producto |
| GET | `/api/user` | Sanctum | Usuario autenticado |

## Rutas Web (panel admin)

| Ruta | Descripción |
|------|-------------|
| `/admin/products` | Gestión CRUD de productos (requiere auth + rol admin) |
| `/products/import` | Importar productos desde CSV/Excel |

---

## Usuarios de prueba (seeder)

| Email | Contraseña | Rol |
|-------|-----------|-----|
| `admin@example.com` | `1234` | admin |
| `user@example.com` | `1234` | user |

---

## Importación CSV

El archivo debe tener una fila de cabecera con estos nombres exactos:

```
sku,name,description,price,stock,image,category
```

- `sku`, `name`, `price`, `stock` son obligatorios.
- Las filas con campos obligatorios vacíos se ignoran automáticamente.
- `price` acepta tanto punto como coma decimal (`12.99` o `12,99`).

---

## Docker

```bash
docker build -t lost-tapes-backend .
docker run -p 9000:9000 lost-tapes-backend
```

---

## Comandos útiles

| Comando | Descripción |
|---------|-------------|
| `php artisan migrate:fresh --seed` | Resetear BD y poblarla de cero |
| `php artisan cache:clear` | Limpiar caché de la app |
| `php artisan config:clear` | Limpiar caché de configuración |
| `php artisan route:list` | Ver todas las rutas registradas |

---

## Cambios rama `Proyecto_claudio`

Correcciones aplicadas sobre `documentacionApi` sin añadir funcionalidad nueva:

### `app/Http/Requests/StoreProductRequest.php` — **CREADO**
- Faltaba este archivo. `ProductAdminController::store()` lo requería como type-hint, causando un `ReflectionException` fatal al intentar crear cualquier producto desde el panel admin.

### `app/Http/Requests/UpdateProductRequest.php` — corregido
- Eliminado código muerto (bloque comentado con implementación anterior).
- Corregida la regla `unique` para que excluya correctamente el producto actual al editar.
- Quitada la restricción `in:pelicula` en `category` — bloqueaba la actualización de cualquier producto con otra categoría.
- Añadido `sometimes` a todos los campos para que los campos no enviados no fallen validación.

### `app/Http/Controllers/ProductController.php` — corregido
- `store()` y `update()` llamaban a `$request->validated()` sobre un `Illuminate\Http\Request` base. Ese método no existe en la clase base (solo en `FormRequest`), causando `BadMethodCallException`. Ahora usan `StoreProductRequest` y `UpdateProductRequest`.
- Eliminados comentarios de PHPDoc innecesarios.

### `app/Http/Controllers/Admin/ProductAdminController.php` — corregido
- Eliminado `use Illuminate\Support\Facades\Session` sin usar.
- Eliminado `Product::all()` en `create()` — cargaba todos los productos sin motivo al mostrar el formulario de creación.

### `app/Http/Resources/ProductResource.php` — corregido
- Añadido campo `id` a la respuesta. Sin él, el frontend no podía referenciar productos por ID desde la API.

### `app/Models/User.php` — corregido
- Añadido `role` a `$fillable`. Sin esto, `User::create(['role' => 'admin', ...])` ignoraba el rol silenciosamente (mass assignment protection), dejando a todos los usuarios con el rol por defecto de la BD.

### `app/Imports/ProductsImport.php` — corregido
- Eliminado el bloque de código comentado (implementación anterior).
- Añadida validación de campos obligatorios: si `sku`, `name`, `price` o `stock` están vacíos, la fila se ignora con `return null` en lugar de intentar insertar en BD y fallar con una excepción de constraint.

### `routes/api.php` — corregido
- Eliminada la ruta `Route::get('/products', ...)` duplicada (el `apiResource` ya la registraba).
- Eliminado el `use App\Models\Product` innecesario.
- Reemplazado `Route::apiResource(...)` por rutas explícitas: lectura pública, escritura protegida con `auth:sanctum`.

### `Dockerfile` — corregido
- Era un Dockerfile de Node.js 20 (`npm run dev`), copiado por error del frontend Vue. Reemplazado por uno correcto: PHP 8.2-fpm, extensiones necesarias (pdo_mysql, mbstring, gd, etc.) y Composer.

### `database/seeders/ProductSeeder.php` — corregido
- SKU018 tenía `'entrancedEarth.jpg '` con espacio al final, lo que causaría un 404 al servir la imagen.
- 12 productos (SKU019–SKU030) referenciaban imágenes que no existen en `public/images/`. Se han puesto a `null` para evitar 404s hasta que se suban las imágenes correspondientes.

### `.gitignore` — corregido
- Añadidas exclusiones para `storage/framework/sessions/`, `storage/framework/views/`, `storage/framework/cache/laravel-excel/` y `storage/framework/testing/`. Estos directorios contienen archivos generados en tiempo de ejecución que no deben versionarse.
- Los archivos ya trackeados de sesiones, vistas compiladas y caché de Excel han sido eliminados del índice de git.
