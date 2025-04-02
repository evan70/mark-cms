# Language Routing Documentation

## Overview

The application implements multilingual support through URL-based language routing. The system automatically handles language detection, validation, and fallback mechanisms.

## URL Structure

- Root URL: `http://localhost:8000` -> redirects to default language
- Language-specific URLs: `/{lang}/[path]`
- Static URLs (no language): `/hello`

Examples:
```
/           -> redirects to /sk
/sk         -> Slovak home page
/sk/test    -> Slovak test page
/en/test    -> English test page
/hello      -> Language-independent page
```

## Configuration

Language settings are managed in `.env`:

```env
DEFAULT_LANGUAGE=sk
AVAILABLE_LANGUAGES=en,sk,cs
```

## Components

### 1. Language Middleware

Location: `app/Middleware/LanguageMiddleware.php`

Responsibilities:
- Extracts language code from URL
- Validates language against available languages
- Redirects to default language if invalid
- Adds language to request attributes

### 2. Route Configuration

Location: `routes/web.php`

Key features:
- Static routes must be defined first
- Language routes use pattern `{lang:[a-z]{2}}`
- Root URL redirects to default language

## Usage

### Adding New Language

1. Update `.env`:
```env
AVAILABLE_LANGUAGES=en,sk,cs,de
```

2. Add language to database:
```sql
INSERT INTO languages (code, name, is_active) 
VALUES ('de', 'Deutsch', 1);
```

### Creating Language-Specific Routes

```php
$app->group('/{lang:[a-z]{2}}', function (RouteCollectorProxy $group) {
    $group->get('/your-path', function (Request $request, Response $response) {
        $lang = $request->getAttribute('language');
        // Your language-specific logic here
    });
});
```

### Creating Language-Independent Routes

```php
// Must be defined before language routes
$app->get('/static-path', function (Request $request, Response $response) {
    // Your language-independent logic here
});
```

## Behavior

1. **Valid Language Code**
   - URL: `/sk/test`
   - Result: Displays Slovak version

2. **Invalid Language Code**
   - URL: `/xx/test`
   - Result: Redirects to `/sk/test`

3. **Root URL**
   - URL: `/`
   - Result: Redirects to default language (`/sk`)

4. **Static Routes**
   - URL: `/hello`
   - Result: Bypasses language handling

## Error Handling

- Invalid language codes trigger automatic redirect to default language
- Static routes are protected from language middleware processing
- 404 errors maintain language context

## Best Practices

1. Always define static routes before language routes
2. Use language attribute from request for content selection
3. Include language code validation in middleware
4. Maintain consistent URL structure across languages
5. Use language-specific redirects for moved content

## Testing

Test different scenarios:
```bash
# Test default redirect
curl -I http://localhost:8000

# Test valid language
curl http://localhost:8000/sk/test

# Test invalid language (should redirect)
curl -I http://localhost:8000/xx/test

# Test static route
curl http://localhost:8000/hello
```