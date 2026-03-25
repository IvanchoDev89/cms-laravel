# Deployment Guide

This guide explains how to deploy the Laravel CMS to various hosting platforms.

## Prerequisites

- PHP 8.4+
- Composer 2.x
- Node.js 22+
- Database (SQLite, MySQL, or PostgreSQL)
- Web server (Nginx or Apache)

## Quick Deployment Options

### Option 1: VPS/Server Deployment (Manual)

```bash
# 1. Clone repository
git clone https://github.com/IvanchoDev89/cms-laravel.git
cd cms-laravel

# 2. Install dependencies
composer install --no-dev --optimize-autoloader
npm ci
npm run build

# 3. Configure environment
cp .env.example .env
php artisan key:generate

# Edit .env with your production settings:
# - APP_URL
# - Database credentials
# - Mail settings
# - etc.

# 4. Run migrations
php artisan migrate --force

# 5. Optimize for production
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Set permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Option 2: Automated Deployment (deploy.sh)

```bash
# Make script executable (already done)
chmod +x deploy.sh

# Deploy to production
./deploy.sh production

# Deploy to staging
./deploy.sh staging
```

### Option 3: GitHub Actions (CI/CD)

The repository includes a GitHub Actions workflow for automated deployment:

1. **Go to GitHub** → **Actions** → **Deploy**
2. Click **Run workflow**
3. Select environment: `production` or `staging`
4. Click **Run workflow**

#### Required GitHub Secrets

Configure these in your repository settings:

| Secret | Description | Required |
|--------|-------------|----------|
| `SSH_HOST` | Server IP or hostname | For VPS deploy |
| `SSH_USER` | SSH username | For VPS deploy |
| `SSH_PRIVATE_KEY` | SSH private key | For VPS deploy |
| `APP_URL` | Application URL | For health checks |

## Platform-Specific Deployment

### Laravel Forge

1. Connect your server to Forge
2. Add the deployment hook URL as a GitHub secret: `FORGE_DEPLOY_HOOK`
3. Uncomment the Forge step in `.github/workflows/deploy.yml`

### Railway

1. Install Railway CLI: `npm install -g @railway/cli`
2. Add `RAILWAY_TOKEN` to GitHub secrets
3. Uncomment the Railway step in `.github/workflows/deploy.yml`

### Netlify (Frontend Only)

1. Add `NETLIFY_AUTH_TOKEN` to GitHub secrets
2. Add `NETLIFY_SITE_ID` to GitHub secrets
3. Uncomment the Netlify step in `.github/workflows/deploy.yml`

### Docker Deployment

```bash
# Build image
docker build -t laravel-cms .

# Run container
docker run -d \
  --name laravel-cms \
  -p 80:80 \
  -v $(pwd)/.env:/var/www/html/.env \
  laravel-cms
```

## Production Checklist

Before deploying to production, verify:

- [ ] `APP_ENV=production` in `.env`
- [ ] `APP_DEBUG=false` in `.env`
- [ ] `APP_KEY` is generated (`php artisan key:generate`)
- [ ] Database is configured and migrations run
- [ ] File permissions are set correctly
- [ ] SSL certificate is installed (HTTPS)
- [ ] Queue workers configured (if using queues)
- [ ] Scheduler configured (crontab for `php artisan schedule:run`)
- [ ] Backups configured

## Environment Configuration

### Minimum Required `.env` Variables

```env
APP_NAME="Laravel CMS"
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=sqlite
# Or MySQL:
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel_cms
# DB_USERNAME=laravel
# DB_PASSWORD=secure_password

# Mail (configure for your provider)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=postmaster@your-domain.com
MAIL_PASSWORD=your-mailgun-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Post-Deployment

### Health Checks

Verify deployment success:

```bash
# Check application status
curl https://your-domain.com/health
curl https://your-domain.com/up

# Check routes
php artisan route:list

# Check logs
tail -f storage/logs/laravel.log
```

### Monitoring

Enable these for production monitoring:

1. **Application Health**: `/health` or `/up` endpoints
2. **Logs**: `storage/logs/laravel.log`
3. **Queue Status**: `php artisan queue:monitor`
4. **Schedule**: Verify crontab is running

### Security

1. **Hide `.env`**: Ensure it's not accessible via web
2. **Protect sensitive directories**:
   - `storage/`
   - `vendor/`
   - `.git/`
3. **Enable HTTPS**: Force SSL in production
4. **Security headers**: Configure in web server

## Rollback

If deployment fails:

```bash
# Using deploy.sh backup
# 1. Find backup directory
cd backups/[timestamp]

# 2. Restore database
# For SQLite:
cp database.sqlite ../../database/

# 3. Restore .env
cp .env ../../

# 4. Clear caches
php artisan optimize:clear
```

Or use Git rollback:

```bash
git log --oneline -5  # Find last working commit
git revert [commit-hash]
./deploy.sh production
```

## Troubleshooting

### Common Issues

**Permission Denied**
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**500 Error After Deploy**
```bash
php artisan optimize:clear
php artisan cache:clear
# Check logs: tail -f storage/logs/laravel.log
```

**Queue Not Processing**
```bash
php artisan queue:restart
# Check supervisor configuration
```

## Support

For deployment issues:
1. Check logs: `storage/logs/`
2. Enable debug temporarily: `APP_DEBUG=true` (⚠️ Don't leave enabled!)
3. Check system requirements
4. Review Laravel deployment documentation
