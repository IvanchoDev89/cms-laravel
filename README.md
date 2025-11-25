# CMS Laravel - WordPress-like Content Management System

Un CMS moderno basado en Laravel 12 con Livewire, Volt, Tailwind CSS y una API REST completa. Diseñado para ser flexible, extensible y fácil de usar.

## 🎯 Características

### ✅ Implementadas
- **Panel de Administración Completo** - CRUD para posts, páginas y media con Livewire
- **Gestor de Media** - Subida de archivos (imágenes, videos, documentos) con previsualización
- **Blog Público** - Página de blog con posts publicados, categorías y búsqueda
- **API REST** - Endpoints públicos para posts, páginas, taxonomías y media
- **Autenticación** - Login/registro con verificación de email
- **Taxonomías** - Categorías y tags para organizar contenido
- **Permisos Básicos** - Sistema de roles (admin/editor/author)
- **Responsive Design** - Interfaz moderna con Tailwind CSS y soporte dark mode

### 🚀 Por Implementar
- Editor de contenido enriquecido (Tiptap/CKEditor)
- Sistema de plugins/hooks
- Autenticación API con Sanctum
- Tests automatizados
- CI/CD con GitHub Actions

## 📦 Stack Tecnológico

- **Backend:** Laravel 12, PHP 8.3
- **Frontend:** Livewire, Volt, Tailwind CSS, Alpine.js
- **Base de Datos:** SQLite (desarrollo) / PostgreSQL (producción)
- **Cache:** Redis
- **Email:** Mailhog (desarrollo)
- **Contenedorización:** Docker & Docker Compose

## 🚀 Instalación Rápida

### Opción 1: Local (SQLite)

```bash
# Clonar repositorio
git clone <tu-repo>
cd cms-laravel

# Instalar dependencias
composer install
npm install

# Configurar ambiente
cp .env.example .env
php artisan key:generate

# Crear base de datos y ejecutar migraciones
touch database/database.sqlite
php artisan migrate
php artisan cms:seed

# Compilar assets
npm run build

# Iniciar servidor
php artisan serve
```

Accede a `http://localhost:8000`

**Credenciales de prueba:**
- Email: `ivan.bermudez89@gmail.com`
- Contraseña: `admin123`

### Opción 2: Docker (Postgres + Redis + Mailhog)

```bash
# Construir y levantar contenedores
docker-compose up -d

# Ejecutar migraciones dentro del contenedor
docker-compose exec app php artisan migrate
docker-compose exec app php artisan cms:seed

# Instalar dependencias Node
docker-compose exec app npm install
docker-compose exec app npm run build
```

**Acceso a servicios:**
- **App:** `http://localhost:8000`
- **Mailhog:** `http://localhost:8025` (para revisar emails)
- **PostgreSQL:** `localhost:5432`
- **Redis:** `localhost:6379`

## 📖 Rutas Principales

### Frontend Público
- `/` - Página de inicio
- `/blog` - Listado de posts publicados
- `/blog/{slug}` - Detalle de post
- `/page/{slug}` - Página estática

### Panel de Administración (requiere login)
- `/admin/posts` - Gestor de posts
- `/admin/posts/create` - Crear post
- `/admin/posts/{id}/edit` - Editar post
- `/admin/pages` - Gestor de páginas
- `/admin/media` - Gestor de media

### API REST (público)
```bash
# Listar posts publicados
GET /api/v1/posts

# Detalle de post
GET /api/v1/posts/{slug}

# Listar páginas
GET /api/v1/pages

# Listar categorías/tags
GET /api/v1/taxonomies

# Listar media
GET /api/v1/media
```

## 📊 Modelos y Relaciones

### Post
- `belongsTo(User)` - Autor
- `belongsToMany(Taxonomy)` - Categorías/Tags
- `morphMany(Media)` - Imágenes/attachments
- Estados: `draft|published|archived`

### Page
- `belongsTo(User)` - Autor
- `morphMany(Media)` - Imágenes/attachments

### Media
- `morphTo()` - Relación polymórfica (Post/Page)
- `belongsTo(User)` - Quien subió

### Taxonomy
- `belongsToMany(Post)` - Posts asociados
- Tipos: `category|tag|custom`

## 🎨 Personalización

### Crear un Componente Livewire

```bash
php artisan livewire:make MyComponent
```

### Crear una Página Volt

```bash
php artisan volt:create pages/my-page
```

### Agregar una Migración

```bash
php artisan make:migration create_my_table
php artisan migrate
```

## 🧪 Testing

```bash
# Ejecutar tests
./vendor/bin/pest

# Con cobertura
./vendor/bin/pest --coverage
```

## 📝 Estructura del Proyecto

```
cms-laravel/
├── app/
│   ├── Models/                 # Eloquent models
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/           # Controladores API
│   │   │   └── Frontend/      # Controladores frontend
│   ├── Livewire/
│   │   ├── Admin/             # Componentes admin
│   │   └── Components/        # Componentes reutilizables
│   └── Console/Commands/      # Comandos Artisan
├── resources/
│   ├── views/
│   │   ├── livewire/          # Vistas Livewire
│   │   ├── frontend/          # Vistas públicas
│   │   └── layouts/           # Layouts
│   ├── css/
│   └── js/
├── routes/
│   ├── api.php               # Rutas API
│   └── web.php               # Rutas web
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── docker-compose.yml        # Configuración Docker
└── README.md
```

## 🔐 Seguridad

- CSRF protection en todos los formularios
- Validación de inputs en cliente y servidor
- Hash seguro de contraseñas (bcrypt)
- Email verification para nuevos usuarios
- Soft deletes para datos sensibles

## 🚀 Despliegue

### En Heroku

```bash
# Agregar Procfile
echo "web: vendor/bin/heroku-php-apache2 public/" > Procfile

# Deploy
git push heroku main
```

### En DigitalOcean App Platform

1. Conecta tu repositorio
2. Configura variables de entorno en `.env`
3. Deploy automático

### En AWS/GCP

Usa Docker Compose o Kubernetes manifests para desplegar en producción.

## 🐛 Troubleshooting

### Error: "Unsupported operand types"
```bash
php artisan config:clear
php artisan cache:clear
```

### Base de datos no migrada
```bash
php artisan migrate --force
php artisan cms:seed
```

### Assets no compilados
```bash
npm run build
# o en desarrollo
npm run dev
```

### Permisos de almacenamiento
```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

## 📚 Documentación Adicional

- [Laravel Docs](https://laravel.com/docs)
- [Livewire Docs](https://livewire.laravel.com)
- [Volt Docs](https://github.com/livewire/volt)
- [Tailwind CSS Docs](https://tailwindcss.com)

## 🤝 Contribuir

1. Fork el proyecto
2. Crea una rama (`git checkout -b feature/AmazingFeature`)
3. Commit cambios (`git commit -m 'Add AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 Licencia

MIT License - libre para uso personal y comercial

## 👨‍💻 Autor

Desarrollado como un CMS moderno y flexible basado en Laravel.

---

**¿Preguntas?** Consulta la documentación o abre un issue en el repositorio.
