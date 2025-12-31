# MangaVerse API Documentation

## Base URL
```
/api/v1
```

## Authentication

The API uses Laravel Sanctum for authentication. Include the token in the Authorization header:

```
Authorization: Bearer {token}
```

### Register
```http
POST /api/v1/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password",
  "password_confirmation": "password",
  "username": "johndoe",
  "birthday": "1990-01-01",
  "about_me": "Manga enthusiast"
}
```

**Response:**
```json
{
  "message": "User registered successfully",
  "user": { ... },
  "token": "1|..."
}
```

### Login
```http
POST /api/v1/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password"
}
```

**Response:**
```json
{
  "message": "Login successful",
  "user": { ... },
  "token": "1|..."
}
```

### Logout
```http
POST /api/v1/logout
Authorization: Bearer {token}
```

## Public Endpoints

### Manga

#### List Mangas
```http
GET /api/v1/mangas?page=1&per_page=15&genre=Action&search=one&sort=popular
```

**Query Parameters:**
- `page` - Page number (default: 1)
- `per_page` - Items per page (default: 15)
- `genre` - Filter by genre
- `search` - Search in title/description
- `sort` - Sort by: `latest`, `popular`, `title`

#### Get Manga
```http
GET /api/v1/mangas/{manga}
```

### News

#### List News
```http
GET /api/v1/news?page=1&per_page=15
```

#### Get News
```http
GET /api/v1/news/{news}
```

### Chapters

#### List Chapters
```http
GET /api/v1/mangas/{manga}/chapters
```

#### Get Chapter
```http
GET /api/v1/mangas/{manga}/chapters/{chapter}
```

### FAQ

#### Get FAQ
```http
GET /api/v1/faq
```

### Users

#### Get User Profile
```http
GET /api/v1/users/{username}
```

### Contact

#### Submit Contact Form
```http
POST /api/v1/contact
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "subject": "Question",
  "message": "My question..."
}
```

### Newsletter

#### Subscribe
```http
POST /api/v1/newsletter/subscribe
Content-Type: application/json

{
  "email": "john@example.com"
}
```

## Authenticated Endpoints

### User Profile

#### Get Current User
```http
GET /api/v1/user
Authorization: Bearer {token}
```

#### Update Profile
```http
PUT /api/v1/user
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "John Doe",
  "username": "johndoe",
  "birthday": "1990-01-01",
  "about_me": "Updated bio"
}
```

#### Update Password
```http
PUT /api/v1/user/password
Authorization: Bearer {token}
Content-Type: application/json

{
  "current_password": "oldpassword",
  "password": "newpassword",
  "password_confirmation": "newpassword"
}
```

#### Get Favorites
```http
GET /api/v1/user/favorites?page=1
Authorization: Bearer {token}
```

### Favorites

#### Add to Favorites
```http
POST /api/v1/mangas/{manga}/favorite
Authorization: Bearer {token}
```

#### Remove from Favorites
```http
DELETE /api/v1/mangas/{manga}/favorite
Authorization: Bearer {token}
```

### News Comments

#### Add Comment
```http
POST /api/v1/news/{news}/comments
Authorization: Bearer {token}
Content-Type: application/json

{
  "content": "Great article!"
}
```

#### Delete Comment
```http
DELETE /api/v1/news/comments/{comment}
Authorization: Bearer {token}
```

### FAQ Requests

#### Submit FAQ Request
```http
POST /api/v1/faq/requests
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "question": "How do I...?"
}
```

## Admin Endpoints

All admin endpoints require authentication and admin privileges.

### Manga Management

```http
GET    /api/v1/admin/mangas
POST   /api/v1/admin/mangas
GET    /api/v1/admin/mangas/{manga}
PUT    /api/v1/admin/mangas/{manga}
PATCH  /api/v1/admin/mangas/{manga}
DELETE /api/v1/admin/mangas/{manga}
```

### News Management

```http
GET    /api/v1/admin/news
POST   /api/v1/admin/news
GET    /api/v1/admin/news/{news}
PUT    /api/v1/admin/news/{news}
PATCH  /api/v1/admin/news/{news}
DELETE /api/v1/admin/news/{news}
```

### FAQ Management

#### Categories
```http
GET    /api/v1/admin/faq-categories
POST   /api/v1/admin/faq-categories
GET    /api/v1/admin/faq-categories/{faq_category}
PUT    /api/v1/admin/faq-categories/{faq_category}
PATCH  /api/v1/admin/faq-categories/{faq_category}
DELETE /api/v1/admin/faq-categories/{faq_category}
```

#### Items
```http
GET    /api/v1/admin/faq-items
POST   /api/v1/admin/faq-items
GET    /api/v1/admin/faq-items/{faq_item}
PUT    /api/v1/admin/faq-items/{faq_item}
PATCH  /api/v1/admin/faq-items/{faq_item}
DELETE /api/v1/admin/faq-items/{faq_item}
```

#### Requests
```http
GET  /api/v1/admin/faq-requests
POST /api/v1/admin/faq-requests/{faqRequest}/approve
```

### User Management

```http
GET    /api/v1/admin/users
POST   /api/v1/admin/users
GET    /api/v1/admin/users/{user}
PUT    /api/v1/admin/users/{user}
PATCH  /api/v1/admin/users/{user}
DELETE /api/v1/admin/users/{user}
POST   /api/v1/admin/users/{user}/toggle-admin
```

### Contact Management

```http
GET  /api/v1/admin/contacts
GET  /api/v1/admin/contacts/{contact}
POST /api/v1/admin/contacts/{contact}/reply
```

## Response Format

All responses follow a consistent format:

### Success Response
```json
{
  "data": { ... },
  "message": "Success message"
}
```

### Paginated Response
```json
{
  "data": [ ... ],
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 15,
    "total": 75
  },
  "links": { ... }
}
```

### Error Response
```json
{
  "message": "Error message",
  "errors": {
    "field": ["Error message"]
  }
}
```

## Status Codes

- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Server Error

## Rate Limiting

API requests are rate-limited. Check response headers for rate limit information:
- `X-RateLimit-Limit` - Maximum requests
- `X-RateLimit-Remaining` - Remaining requests

## CORS

CORS is configured for API endpoints. Adjust in `config/cors.php` if needed.






