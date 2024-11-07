# Inventory Management System

A simple Laravel 11.x Inventory Management System that demonstrates MVC architecture, routing, middleware, and Podman deployment.

## Features

-   Add, update, and delete inventory items (name, category, quantity, price)
-   View items in an organized format

## Requirements

-   PHP >= 8.0
-   Composer
-   MySQL
-   Podman

## Setup

### 1. Clone and Install

```bash
git clone https://github.com/yourusername/inventory-management.git
cd inventory-management
composer install
```

### 2. Configure Environment

Copy and update `.env`:

```bash
cp .env.example .env
```

Set up your database credentials:

```plaintext
DB_CONNECTION=mysql
DB_DATABASE=inventory_management
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Generate an application key:

```bash
php artisan key:generate
```

### 3. Migrate Database

Run migrations to set up tables:

```bash
php artisan migrate
```

### 4. Run the Application

Start the server locally:

```bash
php artisan serve
```

Or deploy with Podman:

1. Create a `Dockerfile` and `podman-compose.yml`.
2. Build and run containers:

    ```bash
    podman-compose up -d
    ```

Access the app at `http://localhost:8000`.

## Folder Structure

-   `app/Models/Inventory.php` - Inventory model
-   `app/Http/Controllers/InventoryController.php` - CRUD operations
-   `resources/views/inventory` - Blade templates
-   `routes/web.php` - Routes

## License

Licensed under the MIT License.
