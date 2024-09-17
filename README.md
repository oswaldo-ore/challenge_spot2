
# URL Shortener API - Quick Start Guide

This is a simple URL shortener built with Laravel. Below is a quick start guide to install, configure, and run the application both locally and in the cloud.

## Requirements

- **PHP 8.x**
- **Laravel 10.x**
- **Composer 2.4.1**
- **MariaDb MySQL 10.4.25**

## Local Development

### 1. Clone the repository

   ```bash
   git clone https://github.com/oswaldo-ore/challenge_spot2.git
   cd challenge_spot2
   ```

### 2. Install dependencies

   ```bash
   composer install
   ```

### 3. Set up environment files

- Copy the `.env.example` file to `.env`:

   ```bash
   cp .env.example .env
   ```

- Copy the `.env.testing.example` file for testing:

   ```bash
   cp .env.testing.example .env.testing
   ```

- Set up the database connections:
  - **Development database** in `.env`:

     ```bash
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=challenge_prod
     DB_USERNAME=root
     DB_PASSWORD=
     ```

  - **Testing database** in `.env.testing`:

     ```bash
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=challenge_test
     DB_USERNAME=root
     DB_PASSWORD=
     ```

### 4. Create databases via command

Run the following commands to create production and testing databases. This is optional; you can also create them manually.

```bash
php artisan db:create  # Creates the database for the production environment
php artisan db:create --env=testing  # Creates the database for the testing environment
```

---

### 5. Generate application keys for both environments

- **Key for the development environment**:

   ```bash
   php artisan key:generate
   ```

- **Key for the testing environment**:

   ```bash
   php artisan key:generate --env=testing
   ```

### 6. Run migrations

- **Migrations for the development environment**:

   ```bash
   php artisan migrate
   ```

- **Migrations for the testing environment**:

   ```bash
   php artisan migrate --env=testing
   ```

### 7. (Optional) Seed the database with test data

- **For development**:

   ```bash
   php artisan db:seed
   ```

- **For testing**:

   ```bash
   php artisan db:seed --env=testing
   ```

### 8. Start the development server

   ```bash
   php artisan serve
   ```

The application will be available at `http://localhost:8000`.

---

## Production Deployment on Oracle with aaPanel

We deployed this application on an Oracle instance using **aaPanel** and linked the domain through **Zone Record in Namecheap**. Here’s how we set it up:

### 1. Install aaPanel on the Oracle instance

- Set up the server and install the necessary packages (PHP, MariaDB, Composer).
- Access the aaPanel admin interface to configure the server and manage domains.

### 2. Clone the project

```bash
git clone https://github.com/oswaldo-ore/challenge_spot2.git
cd challenge_spot2
```

### 3. Set up environment files

- Follow the same steps as in the local setup to configure `.env` and `.env.testing` for both environments.

### 4. Install project dependencies

```bash
composer install
```

### 5. Configure the web server (Nginx)

In the domain configuration, add the following rule to handle API requests correctly:

```nginx
if (!-e $request_filename) {
    rewrite ^.*$ /index.php last;
}
```

This rule ensures that all non-existent file requests are routed to the `index.php` file, allowing the Laravel application to handle routing.

### 6. Set up the domain on Namecheap

- The domain was purchased on **Namecheap** and linked to the Oracle instance via **Zone Record**.
- Configure the DNS settings to point to the public IP address of the Oracle instance.

### 7. Run migrations and seed the database

- **For production**:

   ```bash
   php artisan migrate
   php artisan db:seed
   ```

- **For testing**:

   ```bash
   php artisan migrate --env=testing
   php artisan db:seed --env=testing
   ```

### 8. Finalize the server setup

Once everything is configured, ensure Nginx is properly set up to serve the Laravel application.

Your application is now running on the cloud, accessible via the domain linked from Namecheap.

---

## Design Decisions Documentation

### Decision 1: Separation of Responsibilities with Services and Repositories

The design follows the service and repository pattern to ensure that business logic is separated from database access logic. This makes the code easier to maintain and allows for independent unit and integration tests.

- **Services**: Manage business logic, like URL validation and unique code generation.
- **Repositories**: Encapsulate database access, making it easier to interact with the `UrlShortener` model without exposing SQL logic directly in controllers.

### Decision 2: Testing and Code Quality

Unit and feature tests were implemented using **PHPUnit**. The **TDD (Test-Driven Development)** methodology was used to ensure that the code meets the functional requirements before implementation.

### Technical Goal: Scalability

the partially modular design, along with the use of repositories and services, helps the system scale. If more features are needed, they can be added without affecting the existing code, keeping a clean architecture.

---

## Testing

### Run all tests

```bash
php artisan test
```

### Run only unit tests

```bash
php artisan test --testsuite=Unit
```

### Run only feature tests

```bash
php artisan test --testsuite=Feature
```

This guide should help you get up and running quickly both locally and in a cloud environment.
