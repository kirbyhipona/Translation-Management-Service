Translation Management API

A Laravel-based API service for managing multi-language translations with tagging, search, and fast JSON export.

Setup Instructions

1. Clone project
git clone <repo-url>
cd project-folder
2. Install dependencies
composer install
3. Copy environment file
cp .env.example .env
4. Generate app key
php artisan key:generate
5. Configure database

Update .env:

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=translations
DB_USERNAME=laravel
DB_PASSWORD=secret

6. Run migrations
php artisan migrate
7. Seed test data (100K records)
php artisan db:seed --class=TranslationSeeder
8. Run server
php artisan serve

API will be available at:

http://localhost:8000

(Optional) Docker Setup
docker-compose up -d --build
Run tests

php artisan test

API Overview

Authentication

Uses Laravel Sanctum (token-based authentication)

Authorization: Bearer {token}
Endpoints
Translations
GET /api/translations
POST /api/translations
PUT /api/translations/{id}
GET /api/translations/search
Export
GET /api/translations/export

Returns grouped JSON per locale.

🧠 Design Choices
1. Service Layer Architecture

Business logic is separated from controllers to keep the code clean, reusable, and testable.

2. Scalable Database Structure
t_key + locale unique constraint ensures no duplicate translations
Indexed fields (t_key, locale) improve query performance
3. Tag System (Many-to-Many)

Translations can have multiple tags for flexible categorization (web, mobile, desktop).

4. Performance Optimization
Indexed queries
Selective data fetching
Cached export-ready structure (for large datasets)
Designed to handle 100K+ records efficiently
5. JSON Export Design

Grouped by locale to allow fast frontend consumption (Vue.js / SPA ready).