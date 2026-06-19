Translation Management API

A high-performance Laravel-based API service for managing multi-language translations with tagging, search capabilities, and optimized JSON export for frontend applications.

🚀 Key Features
Multi-language translation support (e.g., EN, FR, ES)
Dynamic language expansion (no schema changes required)
Tag-based categorization (web, mobile, desktop)
Fast search by key, content, or tags
Optimized JSON export for SPA applications (Vue.js / React)
Token-based authentication using Laravel Sanctum
Designed for large-scale datasets (100K+ records)

⚙️ Setup Instructions
1. Clone Repository
git clone <repo-url>
cd project-folder
2. Install Dependencies
composer install
3. Environment Setup
cp .env.example .env
php artisan key:generate
4. Configure Database

Update .env:

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=translationsdb
DB_USERNAME=laravel
DB_PASSWORD=

5. Run Migrations
php artisan migrate
6. Seed Large Dataset (100K records)
php artisan db:seed --class=TranslationSeeder
7. Run Application
php artisan serve

Application URL:

http://localhost:8000

Docker Setup (Optional)

docker-compose up -d --build

Testing

Run all tests:

php artisan test

Includes:

Feature tests (API endpoints)
Authentication tests
Performance validation
📡 API Overview
🔐 Authentication

Uses Laravel Sanctum (token-based authentication)

Authorization: Bearer {token}
📍 Endpoints
Translations
GET    /api/translations
POST   /api/translations
PUT    /api/translations/{id}
GET    /api/translations/search
Export
GET /api/translations/export

Response:

{
  "en": {
    "hello": "Hello World"
  },
  "fr": {
    "hello": "Bonjour"
  }
}