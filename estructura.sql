-- ============================================================
--  TP N°1 - Auditoría de Sistemas
--  Base de datos: auditoria
-- ============================================================

CREATE DATABASE IF NOT EXISTS auditoria CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE auditoria;

-- ------------------------------------------------------------
-- Tabla: clientes
-- ------------------------------------------------------------

CREATE TABLE clientes (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    denominacion    VARCHAR(150) NOT NULL,
    telefono        VARCHAR(30),
    email           VARCHAR(150),
    fecha_registro  DATETIME NOT NULL,
    fecha_borrado   DATETIME NULL DEFAULT NULL,
    hash            VARCHAR(64) NOT NULL
);

-- ------------------------------------------------------------
-- Tabla: auditoria_cliente
-- ------------------------------------------------------------
CREATE TABLE auditoria_cliente (
    id_auditoria      INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente        INT NOT NULL,
    accion            VARCHAR(30) NOT NULL,   -- alta, modificacion, baja, fraude!
    detalles          VARCHAR(255),
    fecha_modificacion DATETIME NOT NULL
);

-- ------------------------------------------------------------
-- Datos de prueba
-- ------------------------------------------------------------
INSERT INTO clientes (denominacion, telefono, email, fecha_registro, hash) VALUES
('Juan Perez', '3434000001', 'juan@mail.com', NOW(),
 SHA2(CONCAT('Juan Perez','3434000001','juan@mail.com','activo','trampita'), 256)),
('Maria Lopez', '3434000002', 'maria@mail.com', NOW(),
 SHA2(CONCAT('Maria Lopez','3434000002','maria@mail.com','activo','trampita'), 256));