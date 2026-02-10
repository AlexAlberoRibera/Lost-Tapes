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
