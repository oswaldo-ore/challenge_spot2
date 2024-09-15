
# URL Shortener API - Guía de Inicio Rápido

Este es un acortador de URLs simple construido con Laravel. A continuación se presenta una guía de inicio rápido para instalar, configurar y ejecutar la aplicación tanto localmente como en la nube.

## Requisitos

- **PHP 8.x**
- **Laravel 10.x**
- **Composer**
- **MariaDb MySQL 10.4.25**
- **Node.js** (opcional, solo si necesitas compilar assets)

## Instalación Local

### 1. Clona el repositorio

   ```bash
   git clone https://github.com/oswaldo-ore/challenge_spot2.git
   cd challenge_spot2
   ```

### 2. Instala las dependencias

   ```bash
   composer install
   ```

### 3. Configura los archivos de entorno

- Copia el archivo `.env.example` a `.env`:

   ```bash
   cp .env.example .env
   ```

- Copia el archivo `.env.testing.example` para pruebas:

   ```bash
   cp .env.testing.example .env.testing
   ```

- Configura la conexión a las bases de datos:
  - **Base de datos de desarrollo** en `.env`:

     ```bash
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=challenge_prod
     DB_USERNAME=root
     DB_PASSWORD=
     ```

  - **Base de datos de pruebas** en `.env.testing`:

     ```bash
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=challenge_test
     DB_USERNAME=root
     DB_PASSWORD=
     ```

### 4. Genera las claves para ambos entornos

- **Clave para el entorno de desarrollo**:

   ```bash
   php artisan key:generate
   ```

- **Clave para el entorno de pruebas**:

   ```bash
   php artisan key:generate --env=testing
   ```

### 5. Ejecuta las migraciones

- **Migraciones para el entorno de desarrollo**:

   ```bash
   php artisan migrate
   ```

- **Migraciones para el entorno de pruebas**:

   ```bash
   php artisan migrate --env=testing
   ```

### 6. (Opcional) Rellena la base de datos con datos de prueba

- **Para desarrollo**:

   ```bash
   php artisan db:seed
   ```

- **Para pruebas**:

   ```bash
   php artisan db:seed --env=testing
   ```

### 7. Inicia el servidor de desarrollo

   ```bash
   php artisan serve
   ```

La aplicación estará disponible en `http://localhost:8000`.

## Documentación de las Decisiones de Diseño

### Decisión 1: Uso de Laravel para la API

Laravel fue elegido por su arquitectura robusta y por ser un framework bien soportado en la comunidad PHP. Proporciona controladores RESTful, un ORM (Eloquent), y soporte para la validación, middleware, y autenticación, lo cual encaja perfectamente en los requisitos del negocio.

### Decisión 2: Separación de Responsabilidades con Servicios y Repositorios

El diseño sigue el patrón de servicios y repositorios para garantizar que la lógica de negocio esté separada de la lógica de acceso a la base de datos. Esto facilita el mantenimiento del código y permite realizar pruebas unitarias y de integración de forma independiente.

- **Servicios**: Gestionan la lógica de negocio, como la validación de URLs y la generación de códigos únicos.
- **Repositorios**: Encapsulan el acceso a la base de datos, facilitando la interacción con el modelo `UrlShortener` sin exponer la lógica SQL directamente en los controladores.

### Decisión 3: Pruebas y Calidad del Código

Se implementaron pruebas unitarias y de características (feature tests) utilizando **PHPUnit**. La metodología **TDD (Test-Driven Development)** fue utilizada para asegurar que el código cumple con los requisitos funcionales antes de ser implementado.

### Objetivo Técnico: Escalabilidad

El diseño modular, junto con el uso de repositorios y servicios, facilita la escalabilidad. Si se necesitan agregar más funcionalidades, estas se pueden integrar sin afectar el código existente, manteniendo una arquitectura limpia.

---

## Pruebas

### Para ejecutar todas las pruebas

```bash
php artisan test
```

### Para ejecutar solo las pruebas unitarias

```bash
php artisan test --testsuite=Unit
```

### Para ejecutar solo las pruebas de características

```bash
php artisan test --testsuite=Feature
```
