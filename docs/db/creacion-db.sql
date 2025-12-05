-- ============================================
-- CREAR BASE DE DATOS
-- ============================================
CREATE DATABASE IF NOT EXISTS messages_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE messages_db;

-- ============================================
-- CREAR TABLA messages
-- ============================================
CREATE TABLE IF NOT EXISTS messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    text TEXT NOT NULL,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- INSERTAR DATOS DE PRUEBA
-- ============================================
INSERT INTO messages (text, created_at) VALUES
('Hola desde XAMPP', NOW()),
('Mensaje de prueba 1', NOW()),
('Mensaje de prueba 2', NOW());

select * from messages;