# Multilingual CMS Project

Simple CMS built with Slim 4 framework, supporting multiple languages and Markdown content.

## Security Features

### Authentication
- Session-based authentication for web interface
- Token-based authentication for API
- Automatic session/token expiration
- Brute force protection

### Authorization
- Role-based access control
- Granular permissions system
- Resource-level access control
- API endpoint protection

### User Roles
- Admin: Full system access
- Editor: Content management
- Author: Article creation and editing

## Documentation

- [Installation Guide](DEVELOPMENT.md)
- [API Documentation](API.md)
- [Language Routing](LANGUAGE_ROUTING.md)
- [Accessibility](ACCESSIBILITY.md)

## Requirements

- PHP 8.1 or newer
- Composer
- SQLite 3
- Node.js & npm (for admin assets)

## Installation

1. Clone the repository
```bash
git clone <repository-url>
cd project-name
```

2. Install PHP dependencies
```bash
composer install
```

3. Environment setup
```bash
cp .env.example .env
```

4. Create SQLite database
```bash
touch storage/database.sqlite
php artisan migrate
```

## Project Structure

```
├── app/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   └── ArticleController.php
│   │   └── ArticleController.php
│   ├── Models/
│   │   ├── Article.php
│   │   ├── ArticleTranslation.php
│   │   └── Language.php
│   └── Middleware/
│       └── LanguageMiddleware.php
├── config/
├── database/
│   └── migrations/
├── public/
│   └── index.php
├── resources/
│   └── views/
├── routes/
│   ├── admin.php
│   ├── api.php
│   └── web.php
└── storage/
```

## Features

### Multi-language Support

- Default language: `en`
- Available languages: `en`, `sk`, `cs`
- URL structure: `/{lang}/articles/{slug}`
- Language detection via URL/browser
- Fallback to default language

### Article Management

- Markdown content
- Multi-language versions
- SEO metadata
- Featured images
- Draft/Published status
- Publishing schedule

### Admin Interface

- Article CRUD operations
- Markdown editor with preview
- Image upload
- Language version management
- SEO fields
- Article status control

## Database Schema

### articles
```sql
CREATE TABLE articles (
    id INTEGER PRIMARY KEY,
    slug VARCHAR UNIQUE,
    featured_image VARCHAR NULL,
    is_published BOOLEAN DEFAULT 0,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### article_translations
```sql
CREATE TABLE article_translations (
    id INTEGER PRIMARY KEY,
    article_id INTEGER,
    locale VARCHAR(2),
    title VARCHAR,
    perex TEXT NULL,
    content TEXT,
    meta_title VARCHAR NULL,
    meta_description VARCHAR NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE(article_id, locale)
);
```

### languages
```sql
CREATE TABLE languages (
    id INTEGER PRIMARY KEY,
    code VARCHAR(2) UNIQUE,
    name VARCHAR,
    is_active BOOLEAN DEFAULT 1
);
```

## API Routes

### Public API

```
GET /{lang}/articles
GET /{lang}/articles/{slug}
```

### Admin API

```
GET    /admin/articles
POST   /admin/articles
GET    /admin/articles/create
GET    /admin/articles/{id}/edit
PUT    /admin/articles/{id}
DELETE /admin/articles/{id}
```

## API Security

### Rate Limiting
- Public API: 60 requests per minute
- Admin API: 300 requests per minute
- Rate limits per IP and token

### Authentication Methods
- Web Interface: Session-based
- API: Bearer token
- OAuth2 support (coming soon)

## Configuration

### Environment Variables

```env
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8080

DB_CONNECTION=sqlite
DB_DATABASE=storage/database.sqlite

DEFAULT_LANGUAGE=en
AVAILABLE_LANGUAGES=en,sk,cs

# Admin API authentication token (generate using: php -r "echo bin2hex(random_bytes(32));" )
ADMIN_API_TOKEN=your-secure-token-here
```

### Generating Admin API Token

To generate a secure token for admin API authentication:

```bash
# Option 1: Using PHP
php -r "echo bin2hex(random_bytes(32));"

# Option 2: Using OpenSSL
openssl rand -hex 32
```

Copy the generated token and set it as `ADMIN_API_TOKEN` in your `.env` file.

## Development

### Local Development Server

```bash
php -S localhost:8080 -t public
```

### Database Migrations

```bash
php artisan migrate
php artisan db:seed
```

### Testing

```bash
composer test
```

## Contributing

1. Fork the repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

## License

MIT License
