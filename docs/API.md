# API Documentation

## Authentication

### API Authentication
All API endpoints under `/api/*` require Bearer token authentication:

```http
Authorization: Bearer your-api-token
```

Invalid or missing token will result in 401 Unauthorized response.

### Web Form Authentication
All web form submissions require valid CSRF token. See [API_AUTHENTICATION.md](API_AUTHENTICATION.md) for details.

## Permissions

Admin API endpoints require specific permissions:

| Permission | Description | Endpoints |
|------------|-------------|-----------|
| manage_articles | Manage articles | POST, PUT, DELETE /api/admin/articles/* |
| manage_categories | Manage categories | POST, PUT, DELETE /api/admin/categories/* |
| manage_tags | Manage tags | POST, PUT, DELETE /api/admin/tags/* |
| manage_users | Manage users | All /api/admin/users/* endpoints |
| manage_settings | Manage system settings | All /api/admin/settings/* endpoints |

### Public API

No authentication required. Rate limited to 60 requests per minute.

#### Get Articles
```http
GET /api/{lang}/articles
```

Query parameters:
- `page` (int) - Page number
- `per_page` (int) - Items per page
- `category` (string) - Filter by category
- `tag` (string) - Filter by tag

Response:
```json
{
  "data": [
    {
      "id": 1,
      "slug": "article-slug",
      "title": "Article Title",
      "perex": "Short description",
      "published_at": "2024-01-20T12:00:00Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 50,
    "per_page": 20
  }
}
```

#### Get Article

```
GET /{lang}/articles/{slug}
```

Response:
```json
{
  "data": {
    "id": 1,
    "slug": "article-slug",
    "title": "Article Title",
    "content": "Markdown content...",
    "featured_image": "/uploads/image.jpg",
    "published_at": "2024-01-20T12:00:00Z",
    "meta": {
      "title": "SEO Title",
      "description": "SEO Description"
    }
  }
}
```

### Categories API

#### List Categories
```
GET /{lang}/categories
```

Response:
```json
{
  "data": [
    {
      "id": 1,
      "slug": "technology",
      "name": "Technology",
      "description": "Tech related articles",
      "meta": {
        "title": "Technology Articles",
        "description": "Latest tech news and updates"
      }
    }
  ]
}
```

#### Get Category with Articles
```
GET /{lang}/categories/{slug}
```

Response:
```json
{
  "data": {
    "id": 1,
    "slug": "technology",
    "name": "Technology",
    "description": "Tech related articles",
    "meta": {
      "title": "Technology Articles",
      "description": "Latest tech news and updates"
    },
    "articles": [
      {
        "id": 1,
        "slug": "article-slug",
        "title": "Article Title",
        "perex": "Short description",
        "published_at": "2024-01-20T12:00:00Z"
      }
    ]
  }
}
```

### Tags API

#### List Tags
```
GET /{lang}/tags
```

Response:
```json
{
  "data": [
    {
      "id": 1,
      "slug": "php",
      "name": "PHP"
    }
  ]
}
```

#### Get Tag with Articles
```
GET /{lang}/tags/{slug}
```

Response:
```json
{
  "data": {
    "id": 1,
    "slug": "php",
    "name": "PHP",
    "articles": [
      {
        "id": 1,
        "slug": "article-slug",
        "title": "Article Title",
        "perex": "Short description",
        "published_at": "2024-01-20T12:00:00Z"
      }
    ]
  }
}
```

### Admin API

#### Create Article

```
POST /admin/articles
```

Request body:
```json
{
  "translations": {
    "en": {
      "title": "English Title",
      "perex": "English perex",
      "content": "English content",
      "meta_title": "SEO Title",
      "meta_description": "SEO Description"
    },
    "sk": {
      "title": "Slovak Title",
      "perex": "Slovak perex",
      "content": "Slovak content"
    }
  },
  "is_published": false,
  "published_at": null
}
```

#### Update Article

```
PUT /admin/articles/{id}
```

Request body: Same as CREATE

#### Delete Article

```
DELETE /admin/articles/{id}
```

#### Categories Management

```
GET    /admin/categories
POST   /admin/categories
GET    /admin/categories/{id}
PUT    /admin/categories/{id}
DELETE /admin/categories/{id}
```

Request body for POST/PUT:
```json
{
  "slug": "technology",
  "translations": {
    "en": {
      "name": "Technology",
      "description": "Tech related articles",
      "meta_title": "Technology Articles",
      "meta_description": "Latest tech news and updates"
    },
    "sk": {
      "name": "Technológie",
      "description": "Články o technológiách"
    }
  }
}
```

#### Tags Management

```
GET    /admin/tags
POST   /admin/tags
GET    /admin/tags/{id}
PUT    /admin/tags/{id}
DELETE /admin/tags/{id}
```

Request body for POST/PUT:
```json
{
  "slug": "php",
  "translations": {
    "en": {
      "name": "PHP"
    },
    "sk": {
      "name": "PHP"
    }
  }
}
```

## Error Responses

```json
{
  "error": {
    "code": "validation_error",
    "message": "The given data was invalid",
    "details": {
      "title": ["The title field is required"]
    }
  }
}
```

## Rate Limiting

Public API: 60 requests per minute
Admin API: 300 requests per minute
