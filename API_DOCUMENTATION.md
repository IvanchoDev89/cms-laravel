# CMS REST API Documentation

## Base URL
```
https://your-domain.com/api/v1
```

## Authentication
The API uses Laravel Sanctum for token-based authentication. Only authenticated endpoints require a Bearer token.

```
Authorization: Bearer {token}
```

## Response Format
All responses are in JSON format. Successful responses include the requested data, while error responses include an error message and appropriate HTTP status code.

### Standard Pagination Response
```json
{
  "data": [...],
  "links": {
    "first": "...",
    "last": "...",
    "prev": null,
    "next": "..."
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 5,
    "path": "...",
    "per_page": 15,
    "to": 15,
    "total": 75
  }
}
```

---

## Endpoints

### Posts

#### List Posts
```
GET /posts
```

**Query Parameters:**
- `page` (integer): Page number for pagination (default: 1)
- `per_page` (integer): Items per page (default: 15, max: 100)
- `search` (string): Search posts by title or content
- `category` (string): Filter by category slug
- `sort` (string): Sort order - `published_at` (default) or `popular`

**Example:**
```bash
curl "https://your-domain.com/api/v1/posts?page=1&per_page=10&search=laravel&sort=popular"
```

**Response (200 OK):**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Getting Started with Laravel",
      "slug": "getting-started-with-laravel",
      "excerpt": "Learn the basics of Laravel framework...",
      "content": "...",
      "status": "published",
      "featured_image_path": "posts/featured-image.jpg",
      "published_at": "2025-01-20T10:00:00Z",
      "created_at": "2025-01-15T08:30:00Z",
      "updated_at": "2025-01-18T15:45:00Z",
      "author": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
      },
      "taxonomies": [
        {
          "id": 1,
          "name": "Laravel",
          "slug": "laravel",
          "type": "category"
        }
      ],
      "media": [
        {
          "id": 1,
          "name": "featured.jpg",
          "path": "posts/featured.jpg",
          "mime_type": "image/jpeg",
          "url": "https://your-domain.com/storage/posts/featured.jpg"
        }
      ],
      "views_count": 250,
      "seo": {
        "meta_title": "Getting Started with Laravel - Complete Guide",
        "meta_description": "Learn the basics of Laravel framework...",
        "meta_keywords": "laravel, php, web development",
        "og_image": "posts/og-image.jpg"
      }
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

#### Get Single Post
```
GET /posts/{slug}
```

**Parameters:**
- `slug` (string, required): The slug of the post

**Example:**
```bash
curl "https://your-domain.com/api/v1/posts/getting-started-with-laravel"
```

**Response (200 OK):**
Returns a single post object (same format as list endpoint)

**Response (404 Not Found):**
```json
{
  "message": "No query results found for model [App\\Models\\Post]."
}
```

**Note:** Viewing a post automatically increments its view count and records the viewer's IP address and user agent.

---

### Pages

#### List Pages
```
GET /pages
```

**Query Parameters:**
- `page` (integer): Page number for pagination (default: 1)
- `per_page` (integer): Items per page (default: 20, max: 100)
- `search` (string): Search pages by title or content

**Example:**
```bash
curl "https://your-domain.com/api/v1/pages?page=1&per_page=20"
```

**Response (200 OK):**
```json
{
  "data": [
    {
      "id": 1,
      "title": "About Us",
      "slug": "about-us",
      "excerpt": "Learn more about our company...",
      "content": "...",
      "featured_image_path": "pages/about.jpg",
      "created_at": "2025-01-10T12:00:00Z",
      "updated_at": "2025-01-15T08:30:00Z",
      "author": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
      },
      "media": [...],
      "seo": {
        "meta_title": "About Us - Our Story",
        "meta_description": "Learn more about our company...",
        "meta_keywords": "about, company, team",
        "og_image": "pages/og-about.jpg"
      }
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

#### Get Single Page
```
GET /pages/{slug}
```

**Parameters:**
- `slug` (string, required): The slug of the page

**Example:**
```bash
curl "https://your-domain.com/api/v1/pages/about-us"
```

**Response (200 OK):**
Returns a single page object (same format as list endpoint)

---

### Taxonomies (Categories & Tags)

#### List Taxonomies
```
GET /taxonomies
```

**Example:**
```bash
curl "https://your-domain.com/api/v1/taxonomies"
```

**Response (200 OK):**
```json
[
  {
    "id": 1,
    "name": "Laravel",
    "slug": "laravel",
    "type": "category",
    "posts_count": 15
  },
  {
    "id": 2,
    "name": "PHP",
    "slug": "php",
    "type": "category",
    "posts_count": 8
  }
]
```

---

#### Get Single Taxonomy
```
GET /taxonomies/{slug}
```

**Parameters:**
- `slug` (string, required): The slug of the taxonomy

**Example:**
```bash
curl "https://your-domain.com/api/v1/taxonomies/laravel"
```

**Response (200 OK):**
```json
{
  "id": 1,
  "name": "Laravel",
  "slug": "laravel",
  "type": "category",
  "posts_count": 15,
  "posts": [
    {
      "id": 1,
      "title": "Getting Started with Laravel",
      "slug": "getting-started-with-laravel",
      ...
    }
  ]
}
```

---

### Media

#### List Media Files
```
GET /media
```

**Response (200 OK):**
```json
[
  {
    "id": 1,
    "name": "featured-image.jpg",
    "path": "posts/featured-image.jpg",
    "mime_type": "image/jpeg",
    "size": 125000,
    "url": "https://your-domain.com/storage/posts/featured-image.jpg",
    "created_at": "2025-01-15T10:00:00Z"
  }
]
```

---

#### Get Single Media File
```
GET /media/{id}
```

**Parameters:**
- `id` (integer, required): The media file ID

---

#### Upload Media File
```
POST /media
```

**Authentication:** Required (Bearer token)

**Headers:**
```
Content-Type: multipart/form-data
Authorization: Bearer {token}
```

**Body:**
- `file` (file, required): The media file to upload

**Example:**
```bash
curl -X POST "https://your-domain.com/api/v1/media" \
  -H "Authorization: Bearer {token}" \
  -F "file=@/path/to/image.jpg"
```

**Response (201 Created):**
```json
{
  "id": 1,
  "name": "image.jpg",
  "path": "media/image.jpg",
  "mime_type": "image/jpeg",
  "size": 125000,
  "url": "https://your-domain.com/storage/media/image.jpg",
  "created_at": "2025-01-20T12:00:00Z"
}
```

---

#### Delete Media File
```
DELETE /media/{id}
```

**Authentication:** Required (Bearer token)

**Parameters:**
- `id` (integer, required): The media file ID

**Example:**
```bash
curl -X DELETE "https://your-domain.com/api/v1/media/1" \
  -H "Authorization: Bearer {token}"
```

**Response (204 No Content):**
No response body

---

## Error Responses

### 400 Bad Request
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "field_name": ["The field_name field is required."]
  }
}
```

### 401 Unauthorized
```json
{
  "message": "Unauthenticated."
}
```

### 403 Forbidden
```json
{
  "message": "User does not have permission to perform this action."
}
```

### 404 Not Found
```json
{
  "message": "Resource not found."
}
```

### 429 Too Many Requests
```json
{
  "message": "Too many requests. Please slow down."
}
```

### 500 Internal Server Error
```json
{
  "message": "Internal server error."
}
```

---

## Rate Limiting
The API uses Laravel's standard rate limiting. Default limits are:
- Unauthenticated requests: 60 requests per minute
- Authenticated requests: 120 requests per minute

---

## Examples

### JavaScript (Fetch)
```javascript
// Get posts
fetch('https://your-domain.com/api/v1/posts?page=1&per_page=10')
  .then(res => res.json())
  .then(data => console.log(data));

// Get single post
fetch('https://your-domain.com/api/v1/posts/my-post-slug')
  .then(res => res.json())
  .then(post => console.log(post));
```

### Python (Requests)
```python
import requests

# Get posts
response = requests.get(
    'https://your-domain.com/api/v1/posts',
    params={'page': 1, 'per_page': 10}
)
posts = response.json()
print(posts)

# Get single post
response = requests.get('https://your-domain.com/api/v1/posts/my-post-slug')
post = response.json()
print(post)
```

### cURL
```bash
# Get posts
curl "https://your-domain.com/api/v1/posts?page=1&per_page=10"

# Get single post
curl "https://your-domain.com/api/v1/posts/my-post-slug"

# Search posts
curl "https://your-domain.com/api/v1/posts?search=laravel"

# Filter by category
curl "https://your-domain.com/api/v1/posts?category=laravel"

# Sort by popularity
curl "https://your-domain.com/api/v1/posts?sort=popular"
```

---

## Versioning
The API uses URL-based versioning. Current version is `v1`. Future versions will be available at `/api/v2`, etc.

---

## Support
For API support and bug reports, please contact: api-support@your-domain.com
