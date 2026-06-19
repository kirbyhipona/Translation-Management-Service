# Translation Management API

A high-performance Laravel-based API service for managing multi-language translations with tagging, search capabilities, and optimized JSON export for frontend applications.

## Key Features

- Multi-language translation support (e.g., EN, FR, ES)
- Dynamic language expansion (no schema changes required)
- Tag-based categorization (web, mobile, desktop)
- Fast search by key, content, or tags
- Optimized JSON export for SPA applications (Vue.js / React)
- Token-based authentication using Laravel Sanctum
- Designed for large-scale datasets (100K+ records)

## ⚙️ Setup Instructions

### 1. Clone Repository

```bash
git clone <repo-url>
cd project-folder
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database

Update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=translationsdb
DB_USERNAME=laravel
DB_PASSWORD=
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Seed Large Dataset (100K records)

```bash
php artisan db:seed --class=TranslationSeeder
```

### 7. Run Application

```bash
php artisan serve
```

Application URL: [http://localhost:8000](http://localhost:8000)

## 🐳 Docker Setup (Optional)

```bash
docker-compose up -d --build
```

## 🧪 Testing

Run all tests:

```bash
php artisan test
```

Includes:

- Feature tests (API endpoints)
- Authentication tests
- Performance validation

## 📡 API Overview

### 🔐 Authentication

This API uses Laravel Sanctum (token-based authentication).

Include the token on every protected request:

Authorization: Bearer {token}

### 📍 Endpoints

| Method | Endpoint                     | Description                  | Auth Required |
|--------|-------------------------------|-------------------------------|----------------|
| GET    | `/api/translations`           | List all translations         | ✅ |
| POST   | `/api/translations`           | Create a new translation      | ✅ |
| PUT    | `/api/translations/{id}`      | Update an existing translation| ✅ |
| GET    | `/api/translations/search`    | Search translations by key, content, or tag | — |
| GET    | `/api/translations/export`    | Export all translations as JSON | — |

> Mark the Auth Required column based on your actual middleware setup — update once you've decided whether `search` and `export` are public or protected.

### Export Response Example

```json
{
  "en": {
    "hello": "Hello World"
  },
  "fr": {
    "hello": "Bonjour"
  }
}
```