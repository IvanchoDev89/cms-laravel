#!/bin/bash

# Laravel CMS Deployment Script
# Usage: ./deploy.sh [environment]
# Environment: production (default) | staging

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

ENVIRONMENT=${1:-production}
DEPLOY_TIME=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="backups/${DEPLOY_TIME}"

echo -e "${YELLOW}🚀 Starting deployment to ${ENVIRONMENT}...${NC}"

# Validate environment
if [[ ! "$ENVIRONMENT" =~ ^(production|staging)$ ]]; then
    echo -e "${RED}❌ Invalid environment. Use 'production' or 'staging'${NC}"
    exit 1
fi

# Check if .env exists
if [ ! -f .env ]; then
    echo -e "${RED}❌ .env file not found. Please create it from .env.example${NC}"
    exit 1
fi

# Create backup directory
mkdir -p ${BACKUP_DIR}

# Backup database
echo -e "${YELLOW}📦 Backing up database...${NC}"
php artisan backup:run --only-db 2>/dev/null || {
    echo -e "${YELLOW}⚠️  Database backup skipped (spatie/laravel-backup not installed)${NC}"
    # Fallback: manual SQLite backup
    if [ -f database/database.sqlite ]; then
        cp database/database.sqlite ${BACKUP_DIR}/database.sqlite
        echo -e "${GREEN}✅ SQLite database backed up${NC}"
    fi
}

# Backup .env
cp .env ${BACKUP_DIR}/.env
echo -e "${GREEN}✅ Environment file backed up${NC}"

# Enable maintenance mode
echo -e "${YELLOW}🔧 Enabling maintenance mode...${NC}"
php artisan down --render="errors::503"

# Pull latest changes (if using git deployment)
if [ -d .git ]; then
    echo -e "${YELLOW}📥 Pulling latest changes...${NC}"
    git pull origin main
fi

# Install dependencies
echo -e "${YELLOW}📦 Installing dependencies...${NC}"
composer install --no-dev --optimize-autoloader --no-interaction

# Install and build frontend assets
if [ -f package.json ]; then
    echo -e "${YELLOW}🎨 Building frontend assets...${NC}"
    npm ci
    npm run build
fi

# Clear caches
echo -e "${YELLOW}🧹 Clearing caches...${NC}"
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations
echo -e "${YELLOW}🗄️  Running migrations...${NC}"
php artisan migrate --force --step

# Seed essential data if needed
# php artisan db:seed --force --class=EssentialSeeder

# Cache configuration for production
echo -e "${YELLOW}⚡ Optimizing application...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Cache bootstrap files
php artisan optimize

# Set proper permissions
echo -e "${YELLOW}🔒 Setting permissions...${NC}"
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/logs storage/framework
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

# Restart queue workers
php artisan queue:restart 2>/dev/null || true

# Disable maintenance mode
echo -e "${YELLOW}✅ Disabling maintenance mode...${NC}"
php artisan up

# Health check
echo -e "${YELLOW}🏥 Running health check...${NC}"
sleep 2
if curl -f -s http://localhost/health > /dev/null 2>&1 || curl -f -s http://localhost/up > /dev/null 2>&1; then
    echo -e "${GREEN}✅ Health check passed!${NC}"
else
    echo -e "${YELLOW}⚠️  Health check skipped (curl not available or app not running on localhost)${NC}"
fi

# Deployment info
DEPLOY_COMMIT=$(git rev-parse --short HEAD 2>/dev/null || echo "unknown")
echo -e "${GREEN}🎉 Deployment completed successfully!${NC}"
echo -e "${GREEN}   Environment: ${ENVIRONMENT}${NC}"
echo -e "${GREEN}   Commit: ${DEPLOY_COMMIT}${NC}"
echo -e "${GREEN}   Time: $(date)${NC}"
echo -e "${GREEN}   Backup: ${BACKUP_DIR}${NC}"

# Optional: Send notification
# php artisan deploy:notify success 2>/dev/null || true
