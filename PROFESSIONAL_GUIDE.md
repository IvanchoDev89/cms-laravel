# CMS Laravel - Guía Profesional Completa

Un **CMS moderno, profesional y empresarial** construido con Laravel 12, Livewire 3, Vue 3, Tiptap y Tailwind CSS.

## 🎯 Características Principales

### ✨ Funcionalidades Core
- **Editor Tiptap** con soporte para texto enriquecido, imágenes, links, código
- **Gestión de Posts** con estado de publicación, SEO, y categorización
- **Gestión de Páginas** estáticas para contenido especial
- **Media Manager** con subida de archivos e integración en editor
- **Taxonomies** (Categorías y Tags) para organización de contenido
- **RBAC completo** (Admin, Editor, Author, Subscriber)
- **API RESTful** con autenticación Sanctum
- **Frontend Público** totalmente personalizable
- **Dark Mode** en admin
- **Two-Factor Authentication** (2FA)
- **Multi-usuario** con permisos granulares

## 🔐 Sistema de Roles y Permisos

| Rol | Posts | Pages | Media | Taxonomies | Users | Settings |
|-----|-------|-------|-------|-----------|-------|----------|
| **Admin** | CRUD + Publish | CRUD | CRUD | CRUD | CRUD | CRUD |
| **Editor** | CRUD + Publish | CRUD | CRUD + Upload | CRUD | - | - |
| **Author** | Create Own, Edit Own | - | Upload | - | - | - |
| **Subscriber** | View Only | View Only | - | - | - | - |

## 🚀 Instalación Rápida

```bash
# 1. Clonar
git clone <repo> cms-laravel && cd cms-laravel

# 2. Dependencias
composer install && npm install

# 3. Configuración
cp .env.example .env && php artisan key:generate

# 4. BD y seeders
php artisan migrate
php artisan db:seed RolePermissionSeeder

# 5. Usuario admin
php artisan tinker
$user = App\Models\User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('password')]);
$user->assignRole('admin');
exit

# 6. Assets
npm run build

# 7. Servidor
php artisan serve
```

**Acceso**: http://localhost:8000  
**Admin**: admin@test.com / password

## 📚 API Endpoints

### Públicos
```
GET    /api/v1/posts              Listar posts
GET    /api/v1/posts/{slug}       Obtener post
GET    /api/v1/pages              Listar páginas
GET    /api/v1/taxonomies         Listar categorías
GET    /api/v1/media              Listar medios
```

### Autenticación
```
POST   /api/v1/auth/login         Login
POST   /api/v1/auth/logout        Logout
GET    /api/v1/auth/me            Usuario actual
```

### Protegidos (token requerido)
```
POST   /api/v1/images/upload      Subir imagen
GET    /api/v1/images             Listar imágenes
```

## 🔧 Uso de Permisos en Código

```php
// Verificar permiso
if (auth()->user()->hasPermission('posts.publish')) {
    // Publicar post
}

// Verificar rol
if (auth()->user()->hasRole('admin')) {
    // Admin only
}

// Asignar rol
$user->assignRole('editor');

// Crear rol personalizado
$role = Role::create(['name' => 'moderator']);
$role->grantPermission('posts.delete');
```

## 🌐 Rutas Web

```
GET    /                          Homepage
GET    /blog                       Blog listing
GET    /blog/{slug}               Post detail
GET    /page/{slug}               Page view
GET    /login                     Login
GET    /register                  Register
GET    /dashboard                 Admin dashboard (auth)
GET    /admin/posts               Posts CRUD (admin)
GET    /admin/pages               Pages CRUD (admin)
GET    /admin/media               Media manager (admin)
```

## 💾 Modelos & Relaciones

```
User
├── roles() [BelongsToMany]
├── posts() [HasMany]
├── pages() [HasMany]
└── media() [HasMany]

Post
├── user() [BelongsTo]
├── taxonomies() [BelongsToMany]
└── media() [MorphMany]

Page
├── user() [BelongsTo]
└── media() [MorphMany]

Role
├── permissions() [BelongsToMany]
└── users() [BelongsToMany]

Permission
└── roles() [BelongsToMany]

Taxonomy
├── posts() [BelongsToMany]
└── pages() [BelongsToMany]

Media
└── mediaable() [MorphTo]
```

## 🎨 Componentes Principales

### TiptapEditor.vue
Rich text editor con:
- Toolbar completo (bold, italic, h1-h3, lists, etc.)
- Upload directo de imágenes
- Sintaxis highlighting en code blocks
- Full dark mode support

Uso:
```blade
<livewire:components.rich-text-editor wire:model="content" />
```

### Admin Components (Livewire)
- `PostsIndex.php` - Listado de posts con search/filter
- `PostForm.php` - Crear/editar con Tiptap
- `PagesIndex.php` - Listado de páginas
- `PageForm.php` - Crear/editar páginas
- `MediaManager.php` - Gestor multimedia

## 📊 Base de Datos

### Migraciones
```
users_table.php                    Usuarios
posts_table.php                    Posts (con soft deletes)
pages_table.php                    Páginas
media_table.php                    Archivos/Imágenes
taxonomies_table.php               Categorías/Tags
post_taxonomy_table.php            Relación posts-tags
roles_and_permissions_tables.php   RBAC (NEW)
```

### Columnas Destacadas (Posts)
- `title` - Título del post
- `slug` - URL-friendly
- `excerpt` - Resumen
- `content` - HTML enriquecido (Tiptap)
- `status` - draft/published/archived
- `published_at` - Fecha de publicación
- `view_count` - Contador de vistas
- `meta` - JSON (SEO datos)

## 🔄 Middleware Personalizado

### CheckPermission
```php
Route::post('/posts', [PostController::class, 'store'])
    ->middleware('permission:posts.create');
```

### CheckRole
```php
Route::get('/admin', function() {})
    ->middleware('role:admin|editor');
```

## 📱 Frontend Responsive

- **Homepage** - Hero, features, stats, blog preview
- **Blog Listing** - Sidebar con búsqueda y categorías
- **Post Detail** - Breadcrumbs, meta, sharing, related posts
- **Dark Mode** - Toggle automático + persistencia

## ⚙️ Configuración Avanzada

### Environment (.env)
```dotenv
APP_ENV=production
APP_DEBUG=false

DB_CONNECTION=pgsql
DB_HOST=localhost
DB_DATABASE=cms_laravel
DB_USERNAME=cms_user

CACHE_DRIVER=redis
SESSION_DRIVER=cookie

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
```

### Cache & Performance
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache
```

## 🧪 Testing

```bash
# Ejecutar tests
./vendor/bin/pest

# Coverage
./vendor/bin/pest --coverage

# Específico
./vendor/bin/pest tests/Feature/Auth/
```

**Estado actual**: 33 tests ✅ passing

## 🚢 Deployment en Producción

### Servidor (Ubuntu/Debian)

```bash
# 1. Dependencias del sistema
sudo apt-get update
sudo apt-get install -y php8.3 php8.3-fpm php8.3-pgsql \
  nginx postgresql node npm composer git

# 2. Clonar y setup
git clone <repo> /var/www/cms
cd /var/www/cms
composer install --no-dev --optimize-autoloader
npm ci && npm run build

# 3. Configurar BD
sudo -u postgres psql
CREATE DATABASE cms_laravel;
CREATE USER cms_user WITH PASSWORD 'secure_password';
GRANT ALL PRIVILEGES ON DATABASE cms_laravel TO cms_user;

# 4. Configurar Laravel
cp .env.production .env
php artisan key:generate
php artisan migrate --force
php artisan db:seed RolePermissionSeeder --force

# 5. Permisos
sudo chown -R www-data:www-data /var/www/cms
sudo chmod -R 755 /var/www/cms
sudo chmod -R 775 /var/www/cms/storage /var/www/cms/bootstrap/cache

# 6. Nginx vhost
sudo cp nginx-vhost.conf /etc/nginx/sites-available/cms
sudo ln -s /etc/nginx/sites-available/cms /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx

# 7. SSL (Let's Encrypt)
sudo certbot certonly --nginx -d example.com
```

### Nginx Config (ejemplo)
```nginx
server {
    listen 443 ssl http2;
    server_name example.com;

    ssl_certificate /etc/letsencrypt/live/example.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/example.com/privkey.pem;

    root /var/www/cms/public;
    index index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

## 🔒 Seguridad

- ✅ CSRF Protection en web
- ✅ XSS Prevention
- ✅ SQL Injection Protection (ORM)
- ✅ Rate Limiting en API
- ✅ 2FA Authentication
- ✅ API Token Encryption (Sanctum)
- ✅ Password Hashing (Bcrypt)
- ✅ Environment variables (no secrets en repo)

## 📦 Dependencias Principales

```json
{
  "php": ">=8.3",
  "laravel/framework": "^12.0",
  "livewire/livewire": "^3.0",
  "laravel/fortify": "^1.0",
  "laravel/sanctum": "^4.0",
  "tiptap": "^2.11"
}
```

## 🆘 Solución de Problemas

| Error | Solución |
|-------|----------|
| `SQLSTATE[HY000]` | Verificar credenciales BD en .env |
| `Permission denied` storage | `chmod -R 775 storage bootstrap/cache` |
| Tiptap no carga | `npm run build && php artisan cache:clear` |
| API 401 Unauthorized | Incluir token en header `Authorization: Bearer ...` |
| 403 Forbidden | Verificar permiso del usuario con `hasPermission()` |

## 📞 Recursos

- **Laravel**: https://laravel.com
- **Livewire**: https://livewire.laravel.com
- **Tiptap**: https://tiptap.dev
- **Tailwind**: https://tailwindcss.com
- **Docs**: https://github.com/yourusername/cms-laravel

## ✅ Checklist Pre-Producción

- [ ] Base de datos PostgreSQL configurada
- [ ] SSL Certificate (Let's Encrypt)
- [ ] .env con credenciales seguras
- [ ] `php artisan migrate --force` ejecutado
- [ ] `npm run build` completado
- [ ] `php artisan config:cache` ejecutado
- [ ] Permisos de archivos correctos
- [ ] Backups automáticos configurados
- [ ] Logs monitoreados
- [ ] Rate limiting activado

---

**CMS Laravel v1.0** | Construido con ❤️ en 2025

