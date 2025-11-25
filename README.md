# CMS Laravel - Professional Content Management System

Un CMS moderno y profesional basado en Laravel 12 con Livewire 3, Volt, Tailwind CSS y una API REST completa. Diseñado para ser flexible, extensible, seguro y fácil de usar.

**[Documentación API](./API_DOCUMENTATION.md)** | **[Implementación](./IMPLEMENTATION_SUMMARY.md)** | **[Guía Profesional](./PROFESSIONAL_GUIDE.md)**

---

## 🎯 Características Principales

### ✅ Panel de Administración Completo
- **Dashboard Avanzado** - Métricas en tiempo real con gráficos Chart.js
- **Gestor de Posts** - CRUD completo con editor de contenido enriquecido (Tiptap)
- **Gestor de Páginas** - Páginas estáticas con SEO integrado
- **Gestor de Media** - Subida de archivos, organización y gestión
- **Gestor de Usuarios** - Sistema completo de usuarios con roles y permisos
- **Gestor de Taxonomías** - Categorías y tags personalizables
- **Configuración** - Ajustes globales del CMS

### 📊 Dashboard Profesional
- Tarjetas de overview con indicadores de tendencia
- Gráficos de posts publicados (últimos 7 días)
- Gráficos de nuevos usuarios (últimos 30 días)
- Posts recientes con estado y fecha
- Top autores por cantidad de posts
- Top posts por vistas (últimos 30 días)
- Métricas de almacenamiento usado
- Visitantes únicos (últimos 30 días)
- Indicadores de crecimiento (vs semana/mes anterior)

### 🔐 Sistema de Seguridad
- Autenticación con Fortify (login, register, 2FA)
- Autorización con roles y permisos
- API tokens con Sanctum
- CSRF protection en todos los formularios
- Validación server-side de inputs
- Protección contra XSS y SQL injection
- Hash seguro de contraseñas (bcrypt)
- Soft deletes para datos sensibles
- Logs de auditoría de cambios

### 📝 Gestión de Contenido
- **Campos SEO** - Meta title, description, keywords, og_image
- **Scheduling** - Programar publicación de posts (preparado)
- **Versioning** - Control de versiones de contenido
- **Rich Text Editor** - Editor Tiptap con soporte completo
- **Featured Images** - Imágenes destacadas con preview
- **Taxonomías** - Categorías y tags sin limite
- **Estadísticas** - Contador de vistas y engagement

### 🌐 API REST Completa
- Endpoints públicos para posts, páginas, taxonomías y media
- Búsqueda y filtrado avanzado
- Paginación configurable
- Sorting por relevancia o popularidad
- Autenticación con Sanctum para escribir
- Resources para respuestas consistentes
- Rate limiting integrado
- [Documentación completa](./API_DOCUMENTATION.md)

### 🎨 Frontend Público (Preparado)
- Blog público con posts publicados
- Páginas estáticas
- Búsqueda de contenido
- Filtro por categorías
- Responsive design
- Dark mode
- SEO optimizado

---

## 📦 Stack Tecnológico

| Componente | Tecnología | Versión |
|---|---|---|
| **Backend** | Laravel | 12 |
| **PHP** | PHP | 8.2+ |
| **Frontend** | Livewire + Volt | 3 |
| **Estilos** | Tailwind CSS | 4 |
| **Base de Datos** | SQLite/PostgreSQL | Ambas |
| **Cache** | Redis | - |
| **Autenticación** | Sanctum | - |
| **Testing** | Pest | 4.1 |
| **Asset Bundler** | Vite | - |

---

## 🚀 Instalación Rápida

### Requisitos Previos
- PHP 8.2 o superior
- Composer
- Node.js 18+ (para assets)
- Git

### Instalación Local (SQLite)

```bash
# 1. Clonar repositorio
git clone https://github.com/IvanchoDev89/cms-laravel.git
cd cms-laravel

# 2. Instalar dependencias
composer install
npm install

# 3. Configurar archivo .env
cp .env.example .env
php artisan key:generate

# 4. Crear y configurar base de datos
touch database/database.sqlite

# 5. Ejecutar migraciones y seeders
php artisan migrate
php artisan db:seed

# 6. Crear enlace simbólico para storage
php artisan storage:link

# 7. Compilar assets
npm run build
# O en desarrollo (con hot reload)
npm run dev

# 8. Iniciar servidor de desarrollo
php artisan serve
```

**Acceso a la aplicación:**
- URL: http://localhost:8000
- Admin: http://localhost:8000/admin

**Credenciales de prueba:**
```
Email: admin@example.com
Contraseña: Secret123!
```

### Instalación con Docker

```bash
# 1. Construir y levantar contenedores
docker-compose up -d

# 2. Instalar dependencias
docker-compose exec app composer install
docker-compose exec app npm install

# 3. Configurar .env
docker-compose exec app cp .env.example .env
docker-compose exec app php artisan key:generate

# 4. Ejecutar migraciones
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed

# 5. Compilar assets
docker-compose exec app npm run build

# 6. Crear enlace de storage
docker-compose exec app php artisan storage:link
```

**Servicios disponibles:**
- **App:** http://localhost:8000
- **Mailhog (Emails):** http://localhost:8025
- **PostgreSQL:** localhost:5432
- **Redis:** localhost:6379

---

## 📋 Rutas Principales

### Panel de Administración (Requiere autenticación)
```
/admin                      Dashboard principal
/admin/posts                Gestor de posts
/admin/posts/create         Crear nuevo post
/admin/posts/{id}/edit      Editar post
/admin/pages                Gestor de páginas
/admin/pages/create         Crear nueva página
/admin/pages/{id}/edit      Editar página
/admin/media                Gestor de media
/admin/users                Gestor de usuarios
/admin/users/create         Crear nuevo usuario
/admin/users/{id}/edit      Editar usuario
/admin/taxonomies           Gestor de categorías/tags
```

### Frontend Público
```
/                           Página de inicio
/blog                       Blog - Listado de posts
/blog/{slug}                Detalle de post
/page/{slug}                Página estática
/login                      Login de usuario
/register                   Registro de usuario
/forgot-password            Recuperar contraseña
```

### API REST v1 (Público)
```
GET /api/v1/posts                    Listar posts publicados
GET /api/v1/posts/{slug}             Obtener post por slug
GET /api/v1/pages                    Listar páginas
GET /api/v1/pages/{slug}             Obtener página por slug
GET /api/v1/taxonomies               Listar categorías/tags
GET /api/v1/taxonomies/{slug}        Obtener taxonomía por slug
GET /api/v1/media                    Listar archivos media
GET /api/v1/media/{id}               Obtener archivo media

POST /api/v1/media                   Subir archivo (auth requerida)
DELETE /api/v1/media/{id}            Eliminar archivo (auth requerida)
```

Ver [Documentación API Completa](./API_DOCUMENTATION.md) para detalles y ejemplos.

---

## 🏗️ Estructura del Proyecto

```
cms-laravel/
│
├── app/
│   ├── Models/                      # Modelos Eloquent
│   │   ├── User.php
│   │   ├── Post.php
│   │   ├── Page.php
│   │   ├── Media.php
│   │   ├── Role.php
│   │   ├── Permission.php
│   │   ├── Taxonomy.php
│   │   └── PostView.php
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/                 # Controladores API
│   │   │   │   ├── PostController.php
│   │   │   │   ├── PageController.php
│   │   │   │   ├── MediaController.php
│   │   │   │   └── TaxonomyController.php
│   │   │   └── Frontend/            # Controladores frontend
│   │   ├── Resources/               # API Resources
│   │   │   ├── PostResource.php
│   │   │   └── PageResource.php
│   │   └── Middleware/              # Middlewares customizados
│   │
│   ├── Livewire/
│   │   ├── Admin/                   # Componentes admin
│   │   │   ├── DashboardAnalytics.php
│   │   │   ├── PostForm.php
│   │   │   ├── PostsIndex.php
│   │   │   ├── PageForm.php
│   │   │   ├── PagesIndex.php
│   │   │   ├── UserForm.php
│   │   │   ├── UsersIndex.php
│   │   │   └── (más...)
│   │   └── Components/              # Componentes reutilizables
│   │
│   └── Console/
│       └── Commands/                # Comandos Artisan customizados
│
├── resources/
│   ├── views/
│   │   ├── livewire/
│   │   │   ├── admin/               # Vistas admin
│   │   │   │   ├── posts/
│   │   │   │   ├── pages/
│   │   │   │   ├── users/
│   │   │   │   ├── media/
│   │   │   │   └── dashboard-analytics-enhanced.blade.php
│   │   │   └── components/
│   │   ├── frontend/                # Vistas públicas
│   │   └── layouts/
│   ├── css/
│   │   └── app.css                  # Tailwind CSS
│   └── js/
│       └── app.js                   # JavaScript principal
│
├── routes/
│   ├── api.php                      # Rutas API
│   ├── web.php                      # Rutas web
│   └── console.php
│
├── database/
│   ├── migrations/                  # Migraciones
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   ├── RoleSeeder.php
│   │   └── (más seeders)
│   └── factories/
│
├── tests/
│   ├── Feature/                     # Tests de funcionalidad
│   ├── Unit/                        # Tests unitarios
│   └── Pest.php
│
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── database.php
│   ├── filesystems.php
│   └── (más configuraciones)
│
├── .env.example                     # Plantilla de variables de entorno
├── .env.production                  # Configuración producción (ejemplo)
├── docker-compose.yml               # Configuración Docker
├── Dockerfile
├── phpunit.xml                      # Configuración Pest
├── vite.config.js                   # Configuración Vite
├── package.json
├── composer.json
│
├── API_DOCUMENTATION.md             # Documentación API
├── IMPLEMENTATION_SUMMARY.md        # Resumen de implementación
├── PROFESSIONAL_GUIDE.md            # Guía profesional
└── README.md                        # Este archivo
```

---

## 🗄️ Modelo de Datos

### Post
```php
- id (PK)
- user_id (FK) → User (Autor)
- title (string)
- slug (string, unique)
- excerpt (text)
- content (longtext)
- featured_image_path (string)
- status (enum: draft, published, archived)
- published_at (timestamp)
- scheduled_at (timestamp)
- view_count (integer)
- meta_title (string)
- meta_description (text)
- meta_keywords (text)
- og_image (string)
- created_at, updated_at

Relaciones:
- belongsTo(User) → author
- belongsToMany(Taxonomy)
- hasMany(PostView)
- morphMany(Media)
```

### Page
```php
- id (PK)
- user_id (FK) → User (Autor)
- title (string)
- slug (string, unique)
- excerpt (text)
- content (longtext)
- featured_image_path (string)
- meta_title (string)
- meta_description (text)
- meta_keywords (text)
- og_image (string)
- created_at, updated_at

Relaciones:
- belongsTo(User) → author
- morphMany(Media)
```

### Media
```php
- id (PK)
- name (string)
- path (string)
- mime_type (string)
- size (integer)
- mediable_id (FK)
- mediable_type (string)
- created_at, updated_at

Relaciones:
- morphTo() → mediable (Post/Page/User)
```

### User
```php
- id (PK)
- name (string)
- email (string, unique)
- email_verified_at (timestamp)
- password (string)
- two_factor_secret (text)
- two_factor_recovery_codes (text)
- created_at, updated_at

Relaciones:
- belongsToMany(Role)
- hasMany(Post)
- hasMany(Page)
- hasMany(Media)
```

### Role & Permission
```php
Role:
- id (PK)
- name (string, unique)
- created_at, updated_at
- belongsToMany(Permission)
- belongsToMany(User)

Permission:
- id (PK)
- name (string, unique)
- description (text)
- created_at, updated_at
- belongsToMany(Role)
```

### Taxonomy
```php
- id (PK)
- name (string)
- slug (string, unique)
- type (enum: category, tag, custom)
- created_at, updated_at

Relaciones:
- belongsToMany(Post)
```

---

## 🔐 Sistema de Roles y Permisos

### Roles Disponibles
- **Admin** - Acceso completo a todas las funciones
- **Editor** - Gestión completa de posts, páginas y media
- **Author** - Crear y editar sus propios posts
- **Subscriber** - Solo lectura de posts publicados

### Permisos
```php
posts.view       - Ver posts
posts.create     - Crear posts
posts.edit       - Editar posts
posts.delete     - Eliminar posts

pages.view       - Ver páginas
pages.create     - Crear páginas
pages.edit       - Editar páginas
pages.delete     - Eliminar páginas

media.view       - Ver archivos media
media.upload     - Subir archivos
media.delete     - Eliminar archivos

users.view       - Ver usuarios
users.create     - Crear usuarios
users.edit       - Editar usuarios
users.delete     - Eliminar usuarios
```

---

## 🧪 Testing

El proyecto incluye suite de tests con Pest:

```bash
# Ejecutar todos los tests
./vendor/bin/pest

# Ejecutar tests específicos
./vendor/bin/pest tests/Feature

# Ejecutar con cobertura
./vendor/bin/pest --coverage

# Ver reporte HTML
./vendor/bin/pest --coverage --coverage-html=coverage
```

**Estado Actual:** 33 tests pasando ✅

---

## 🚀 Despliegue

### En Producción (Recomendaciones)

```bash
# 1. Usar PostgreSQL en lugar de SQLite
# 2. Configurar Redis para cache
# 3. Usar HTTPS (SSL/TLS)
# 4. Configurar email (SendGrid, Mailgun, etc.)
# 5. Ejecutar en PHP-FPM con Nginx
# 6. Usar supervisor para queue workers
# 7. Ejecutar migrations con --force
# 8. Compilar assets optimizados (npm run build)
```

### Heroku

```bash
# Agregar Procfile
echo "web: vendor/bin/heroku-php-apache2 public/" > Procfile

# Deploying
git push heroku main
```

### DigitalOcean App Platform

```yaml
# Configuración .do/app.yaml
name: cms-laravel
services:
  - name: app
    github:
      repo: tu-usuario/cms-laravel
      branch: main
    buildpack_slug: php
    envs:
      - key: APP_ENV
        value: production
      - key: DATABASE_URL
        value: ${db.connection_string}
```

### Docker Deployment

```bash
docker build -t cms-laravel:latest .
docker run -d -p 8000:8000 \
  -e DB_HOST=db \
  -e REDIS_HOST=redis \
  cms-laravel:latest
```

---

## 🐛 Troubleshooting

### Error: "No Application Encryption Key has been specified"
```bash
php artisan key:generate
```

### Error: "Unable to locate factory with name"
```bash
# Ejecutar factories
php artisan tinker
User::factory(10)->create();
```

### Assets no se actualizan
```bash
# Limpiar cache de Vite
rm -rf bootstrap/cache/vite.json
npm run build
```

### Permisos de archivos
```bash
# Dar permisos a directorios
chmod -R 775 storage bootstrap/cache
chmod -R 775 public/storage
```

### Base de datos vacía
```bash
php artisan migrate:fresh --seed
```

---

## 📚 Documentación Adicional

- **[API Documentation](./API_DOCUMENTATION.md)** - Documentación completa de endpoints
- **[Implementation Summary](./IMPLEMENTATION_SUMMARY.md)** - Resumen técnico de implementación
- **[Professional Guide](./PROFESSIONAL_GUIDE.md)** - Guía profesional de desarrollo
- [Laravel Docs](https://laravel.com/docs) - Documentación oficial Laravel
- [Livewire Docs](https://livewire.laravel.com) - Documentación Livewire
- [Tailwind CSS](https://tailwindcss.com) - Documentación Tailwind

---

## 🤝 Contribuir

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

---

## 📝 Changelog

### v1.0.0 (Actual)
- ✅ Dashboard con gráficos y métricas
- ✅ Gestor completo de posts con SEO
- ✅ Gestor de páginas estáticas
- ✅ Gestor de usuarios con roles
- ✅ API REST con recursos
- ✅ Sistema de permisos y autenticación
- ✅ 33 tests pasando
- ✅ Documentación completa

---

## 📄 Licencia

MIT License - Libre para uso personal y comercial.

---

## 👨‍💻 Autor

**Ivanchdev89** - Desarrollador Full Stack

Email: ivan.bermudez89@gmail.com
GitHub: [@IvanchoDev89](https://github.com/IvanchoDev89)

---

## 🙏 Agradecimientos

- Comunidad Laravel
- Autores de Livewire y Volt
- Comunidad Tailwind CSS
- Contributors del proyecto

---

**¿Preguntas?** Consulta la documentación o abre un issue en el repositorio.

**¿Quieres colaborar?** ¡Las PRs son bienvenidas!

---

**Última actualización:** Enero 2025
