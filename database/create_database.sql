-- Script para crear la base de datos Helios
-- Ejecutar con: mysql -u root -p < database/create_database.sql

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS helios_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- Usar la base de datos
USE helios_db;

-- Mensaje de confirmación
SELECT 'Base de datos helios_db creada exitosamente' AS status;
