# URL Shortener

Este es un proyecto de acortador de URLs construido con **Laravel** en el backend y **React.js** en el frontend. El sistema permite acortar URLs, listar las URLs acortadas y realizar otras operaciones CRUD sobre las URLs.

## Características

- Acortar URLs largas a códigos únicos de hasta 8 caracteres.
- Listar todas las URLs acortadas.
- Actualizar y eliminar URLs.
- APIs RESTful con respuestas JSON para operaciones CRUD.
- Pruebas unitarias y de características implementadas usando **Pest**.
- Arquitectura limpia con separación de responsabilidades entre frontend y backend.

## Tecnologías Utilizadas

- **Laravel** (Backend)
- **React.js** (Frontend)
- **MySQL** (Base de datos)
- **Pest PHP** (Framework de pruebas)
- **Factories** y **Seeders** para generar datos de prueba

## Requisitos del Sistema

- PHP >= 8.1
- Composer >= 2.4.1
- Node.js >= v16.16.0
- MySQL (Mariadb) = 10.4.25
- Laravel >= 10.10
- React.js

## Instalación

### Clonar el Repositorio

```bash
git clone https://github.com/usuario/url-shortener.git
cd url-shortener
```

### Backend (Laravel)

1. Instalar dependencias de PHP:

    ```bash
    composer install
    ```

2. Crear el archivo `.env`:

    ```bash
    cp .env.example .env
    ```

3. Configurar el archivo `.env` con los detalles de la base de datos y otros parámetros del entorno (como `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, etc.).

4. Generar la clave de la aplicación:

    ```bash
    php artisan key:generate
    ```

5. Crear la base de datos:

    ```bash
    php artisan db:create
    ```

6. Migrar las tablas de la base de datos:

    ```bash
    php artisan migrate
    ```

7. (Opcional) Ejecutar los seeders para generar datos de prueba:

    ```bash
    php artisan db:seed
    ```

### Frontend (React.js)

1. Ir al directorio del frontend:

    ```bash
    cd frontend
    ```

2. Instalar las dependencias de Node.js:

    ```bash
    npm install
    ```

3. Iniciar el servidor de desarrollo:

    ```bash
    npm run dev
    ```

## Uso

### Iniciar el Servidor

Inicia el servidor de desarrollo de Laravel:

```bash
php artisan serve
```

Ahora, puedes acceder a la aplicación en [http://localhost:8000](http://localhost:8000).

### Acortar una URL

Envía una solicitud `POST` a `/api/admin/url-shortener` con el siguiente formato de datos:

```json
{
    "url": "https://www.example.com"
}
```

### Listar URLs Acortadas

Envía una solicitud `GET` a `/api/admin/url-shortener` para obtener la lista de URLs acortadas.

## Pruebas

Este proyecto tiene pruebas unitarias y de características utilizando **Pest**.

### Ejecutar Pruebas

Para ejecutar todas las pruebas:

```bash
php artisan test
```

### Ejecutar Pruebas Unitarias

```bash
php artisan test --filter=Unit
```

### Ejecutar Pruebas de Características

```bash
php artisan test --filter=Feature
```

## Estructura del Proyecto

- **app/Models**: Modelos de base de datos.
- **app/Services**: Manejan la lógica de negocio, orquestando procesos y operaciones sin acceder directamente a la base de datos.
- **app/Repositories**: Repositorios que manejan la interacción con la base de datos y encapsulan las consultas para mayor flexibilidad.
- **app/Http/Controllers**: Controladores de las APIs y funcionalidades.
- **database/factories**: Factories para la generación de datos de prueba.
- **tests/Unit**: Pruebas unitarias.
- **tests/Feature**: Pruebas de características.
- **frontend/**: Carpeta del frontend desarrollado con React.js.

## Consideraciones

- Las URL acortadas tienen un máximo de 8 caracteres y son generadas de forma aleatoria.
- El proyecto está diseñado con separación de responsabilidades entre el frontend y backend, pero ambos están integrados mediante APIs RESTful.
- Las pruebas han sido implementadas siguiendo la metodología **TDD** (Test-Driven Development).

## Contribuciones

Las contribuciones son bienvenidas. Para colaborar:

1. Haz un fork del proyecto.
2. Crea una nueva rama (`git checkout -b feature/nueva-funcionalidad`).
3. Realiza los cambios y haz un commit (`git commit -am 'Añadir nueva funcionalidad'`).
4. Sube los cambios a tu fork (`git push origin feature/nueva-funcionalidad`).
5. Abre un Pull Request.

## Licencia

Este proyecto está bajo la licencia MIT.
