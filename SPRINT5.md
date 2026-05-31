# Sprint 5 — Cambios realizados

Documentación de todos los cambios aplicados en la rama `rama-sprint5` de ambos repositorios.

---

## Frontend (`ManelDAW/Lost-Tapes`)

### Conexión con la API Laravel

**Archivos:** `src/services/api.js`, `src/stores/movieStore.js`, `src/App.vue`

- `api.js` — rutas corregidas (`/products` en vez de `/peliculas`), interceptor Axios que adjunta el token Sanctum en cada petición (`Authorization: Bearer <token>`).
- `movieStore.js` — `fetchMovies()` llama a la API real y mapea campos del backend (`name`→`title`, `description`→`desc`, etc.). `loginUser()` usa la API de Sanctum. `restoreSession()` recupera la sesión desde el token guardado en `localStorage`.
- `App.vue` — al montar la app llama a `restoreSession()` y `fetchMovies()` automáticamente.
- `.env` — variable `VITE_API_URL=http://localhost:8000/api`.

### Validación de formularios con VeeValidate + Yup

**Archivos:** `src/views/LoginView.vue`, `src/views/ContactForm.vue`, `src/views/VenderView.vue`

**Paquetes instalados:** `vee-validate`, `@vee-validate/rules`, `yup`

Cada formulario usa `useForm({ validationSchema })` con un esquema Yup. Los errores aparecen debajo de cada campo en tiempo real con la clase Bootstrap `is-invalid`.

| Formulario | Campos validados |
|------------|-----------------|
| Login | email (formato), password (mín. 4 caracteres) |
| Contacto | nombre (mín. 2), email (formato), asunto (obligatorio), mensaje (mín. 10) |
| Vender | título, duración, precio (número ≥ 0), descripción (mín. 10) |

Los `alert()` del formulario de contacto han sido eliminados y reemplazados por validación inline.

### Paginación y filtros en el catálogo

**Archivo:** `src/views/ProductsView.vue`

- 6 películas por página con navegación numérica Bootstrap.
- Filtro por categoría (desplegable generado dinámicamente desde los datos).
- Botón "Limpiar filtros" cuando hay filtros activos.
- Spinner de carga mientras `movieStore.loading` es `true`.
- Contador de resultados actualizado en tiempo real.
- Al cambiar filtros la página vuelve a 1 automáticamente (watcher).

### OAuth2 — Login con Google

**Archivos:** `src/views/AuthCallback.vue`, `src/views/LoginView.vue`, `src/router/index.js`

- Botón "Continuar con Google" en el formulario de login redirige a `GET /auth/google` del backend.
- Nueva vista `/auth/callback` recibe el token en los parámetros de la URL, lo guarda en `localStorage` y establece la sesión en el store.
- El logo SVG de Google se incluye inline (sin dependencias externas).

### Docker Compose (desarrollo)

**Archivo:** `docker-compose.yml`

```bash
# Levantar el frontend en Docker
docker compose up
# Disponible en http://localhost:5173
```

Monta el código fuente como volumen para hot-reload.

---

## Backend (`AlexAlberoRibera/Lost-Tapes`, rama `rama-sprint5`)

### Bugs críticos corregidos (sesión anterior)

| Archivo | Problema | Solución |
|---------|----------|----------|
| `StoreProductRequest.php` | No existía → ReflectionException fatal | Creado desde cero |
| `UpdateProductRequest.php` | Regla `unique` incorrecta, `in:pelicula` bloqueaba categorías | Corregido |
| `ProductController.php` | `->validated()` sobre `Request` base → BadMethodCallException | Usa FormRequest |
| `User.php` | `role` no estaba en `$fillable` | Añadido |
| `ProductsImport.php` | Sin validación de filas vacías | Añadido null check |
| `routes/api.php` | Ruta duplicada, sin separación público/protegido | Rutas explícitas |
| `Dockerfile` | Era de Node.js copiado del frontend | Reescrito para PHP 8.2-fpm |
| `ProductSeeder.php` | Imagen con espacio en nombre, 12 imágenes inexistentes | Corregidas |

### OAuth2 — Login con Google

**Archivos:** `app/Http/Controllers/Auth/SocialAuthController.php`, `config/services.php`, `routes/web.php`, `database/migrations/..._add_google_id_to_users_table.php`

**Paquete instalado:** `laravel/socialite`

Flujo:
1. Frontend redirige a `GET /auth/google`.
2. Laravel Socialite redirige a Google con `client_id`, `redirect_uri`, `scope`.
3. Google devuelve al callback `/auth/google/callback`.
4. Se crea o actualiza el usuario en BD (`updateOrCreate` por email).
5. Se genera un token Sanctum y se redirige al frontend con el token en la URL.

**Variables de entorno necesarias en `.env`:**
```
GOOGLE_CLIENT_ID=tu_client_id
GOOGLE_CLIENT_SECRET=tu_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
FRONTEND_URL=http://localhost:5173
```

Las credenciales se obtienen en [Google Cloud Console](https://console.cloud.google.com/) → APIs y servicios → Credenciales → Crear credencial OAuth 2.0.

### Migración `google_id`

```bash
php artisan migrate
```

Añade columna `google_id` nullable a la tabla `users`.

### Docker Compose (desarrollo)

**Archivos:** `docker-compose.yml`, `docker/nginx.conf`

Incluye tres servicios:

| Servicio | Imagen | Puerto |
|----------|--------|--------|
| `app` | PHP 8.2-fpm (Dockerfile) | — |
| `webserver` | nginx:alpine | 8000 |
| `db` | mysql:8.0 | 3306 |

```bash
# Levantar todo el backend
docker compose up -d

# Primera vez: migraciones y seed
docker compose exec app php artisan migrate --seed
```

---

## Pendiente (depende del servidor de producción del equipo)

| Tarea | Motivo |
|-------|--------|
| CI/CD automatizado | Requiere acceso al servidor EC2 |
| HTTPS / Let's Encrypt | Requiere servidor en producción |
| DNS `pigrupox.ddaw.es` | Requiere instancia AWS |
| Arquitectura AWS documentada | La monta el compañero con acceso |

---

## Usuarios de prueba

| Email | Contraseña | Rol |
|-------|-----------|-----|
| `admin@example.com` | `1234` | admin |
| `user@example.com` | `1234` | user |

Para login con Google se necesita activar las credenciales OAuth en Google Console y configurar el `.env` del backend.
