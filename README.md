# Helios - Sistema de Gestión de Empleados y Departamentos

Sistema web completo para la gestión de empleados y departamentos con funcionalidades de CRUD, búsqueda avanzada, filtros y paginación.

## Requisitos Previos

- PHP 8.2 o superior
- Composer
- Node.js 18 o superior
- MySQL 8.0 o superior
- Git

## Instalación

### Backend (API Laravel)

1. Clonar el repositorio del backend
2. Navegar a la carpeta del proyecto
3. Copiar el archivo .env.example a .env
4. Configurar las credenciales de la base de datos en el archivo .env
5. Instalar las dependencias de PHP con: composer install
6. Generar la clave de la aplicación con: php artisan key:generate
7. Ejecutar las migraciones con: php artisan migrate
8. Cargar datos de prueba con: php artisan db:seed
9. Iniciar el servidor con: php artisan serve
