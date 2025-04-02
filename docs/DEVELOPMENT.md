# Development Guide

## Setup Development Environment

### Prerequisites

1. Install PHP 8.1+
2. Install Composer
3. Install SQLite
4. Configure PHP extensions:
   - pdo_sqlite
   - fileinfo
   - intl

### First Run

1. Install dependencies:
```bash
composer install
```

2. Create database:
```bash
touch storage/database.sqlite
```

3. Run migrations:
```bash
php artisan migrate
```

4. Seed initial data:
```bash
php artisan db:seed
```

## Code Style

Project follows PSR-12 coding standard. To check your code:

```bash
composer cs-check
```

To automatically fix style issues:

```bash
composer cs-fix
```

## Development Flow

1. Create feature branch from main
2. Write tests if applicable
3. Implement feature
4. Run tests and style checks
5. Create PR

## Testing

```bash
composer test
```

## Common Tasks

### Adding New Language

1. Add language code to `.env`:
```
AVAILABLE_LANGUAGES=en,sk,cs,de
```

2. Add language to database:
```sql
INSERT INTO languages (code, name, is_active) 
VALUES ('de', 'Deutsch', 1);
```

### Creating New Migration

```bash
php artisan make:migration create_new_table
```

### Adding Admin Section

1. Create controller in `app/Controllers/Admin`
2. Add routes in `routes/admin.php`
3. Create views in `resources/views/admin`

## Authentication & Authorization

### User Roles

The system supports following user roles:

1. **Admin**
   - Full system access
   - Can manage users and permissions
   - Access to system settings

2. **Editor**
   - Can manage content (articles, categories, tags)
   - Cannot access user management or system settings

3. **Author**
   - Can create and edit own articles
   - Cannot publish articles directly
   - Cannot modify categories or tags

### Permissions

Permissions are managed through middleware:

```php
use App\Middleware\CheckPermission;

// In routes:
$group->group('/articles', function ($group) {
    // ... routes
})->add(new CheckPermission('manage_articles'));
```

Available permissions:
- manage_articles
- manage_categories
- manage_tags
- manage_users
- manage_settings

### API Authentication

1. Generate API token:
```bash
php artisan generate:api-token --user=admin@example.com
```

2. Use token in requests:
```bash
curl -H "Authorization: Bearer your-token" https://api.example.com/admin/articles
```

## Security Best Practices

1. API Rate Limiting
   - Public API: 60 requests/minute
   - Admin API: 300 requests/minute

2. Token Management
   - Tokens are encrypted in database
   - Automatic token rotation every 30 days
   - Invalid tokens are immediately revoked

3. Session Security
   - HTTPS only cookies
   - Session timeout after 2 hours
   - Auto logout on browser close

## Troubleshooting

### Common Issues

1. **Storage permissions**
   ```bash
   chmod -R 777 storage/
   ```

2. **Cache issues**
   ```bash
   php artisan cache:clear
   ```

3. **Database errors**
   ```bash
   php artisan migrate:fresh
   ```

### Debug Tools

- Enable debug mode in `.env`:
  ```
  APP_DEBUG=true
  ```

- Log location:
  ```
  storage/logs/app.log
  ```

## Deployment

### Production Checklist

1. Set production environment:
   ```
   APP_ENV=production
   APP_DEBUG=false
   ```

2. Optimize autoloader:
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

3. Clear caches:
   ```bash
   php artisan cache:clear
   ```

4. Set proper permissions:
   ```bash
   chmod -R 755 storage/
   ```
