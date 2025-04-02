# API Authentication

## Overview

The API uses two different authentication mechanisms:
- Bearer Token authentication for API endpoints
- CSRF protection for web forms

## API Endpoints (/api/*)

### Authentication
All API endpoints require Bearer token authentication:

```http
Authorization: Bearer your-api-token
```

Example request:
```bash
curl -X POST \
  -H "Authorization: Bearer your-api-token" \
  -H "Content-Type: application/json" \
  http://localhost:8000/api/admin/articles
```

### Generating API Token
```bash
# Using PHP CLI
php -r "echo bin2hex(random_bytes(32));"

# Using OpenSSL
openssl rand -hex 32
```

Add the generated token to your `.env` file:
```env
ADMIN_API_TOKEN=your-generated-token
```

## Web Forms (non-API endpoints)

### CSRF Protection
All web forms require CSRF token. The token is automatically included using the `csrf_fields()` helper:

```php
<form method="POST" action="/articles">
    {!! csrf_fields() !!}
    <!-- form fields -->
</form>
```

### AJAX Requests
For AJAX requests, include the CSRF token in the headers:

```javascript
// Add CSRF token to all AJAX requests
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
```

Example fetch request:
```javascript
fetch('/articles', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify(data)
});
```

## Testing Authentication

### API Endpoints
```bash
# Should succeed with valid token
curl -X POST \
  -H "Authorization: Bearer your-api-token" \
  -H "Content-Type: application/json" \
  http://localhost:8000/api/admin/articles

# Should fail without token
curl -X POST \
  -H "Content-Type: application/json" \
  http://localhost:8000/api/admin/articles
```

### Web Forms
```bash
# Get CSRF token and cookies
curl -c cookies.txt -b cookies.txt http://localhost:8000/sk/articles

# POST request with cookies (will fail without proper CSRF token)
curl -X POST \
  -c cookies.txt \
  -b cookies.txt \
  -H "Content-Type: application/json" \
  http://localhost:8000/sk/articles
```

## Security Notes

1. API Tokens:
   - Store securely in `.env`
   - Rotate regularly
   - Never commit tokens to version control
   - Use environment-specific tokens

2. CSRF Protection:
   - Required for all web forms
   - Automatically handled for regular forms
   - Must be manually included for AJAX requests
   - Tokens are session-specific

3. Rate Limiting:
   - API: 300 requests per minute
   - Web forms: 60 requests per minute
   - Limits are per IP address