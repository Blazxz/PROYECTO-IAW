-- Creación de la base de datos y tablas básicas
CREATE DATABASE IF NOT EXISTS mini_proyecto DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mini_proyecto;

-- Tabla principal de usuarios para login
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- Tabla principal del recurso (ejemplo: clientes / inventario / tickets)
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    observaciones TEXT
) ENGINE=InnoDB;

-- Tabla de auditoría para transacciones de borrado
CREATE TABLE IF NOT EXISTS auditoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    detalle VARCHAR(255) NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de productos de 3D Spectrum 
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT,
    nombre VARCHAR(200) NOT NULL,
    numero_serie VARCHAR(200) NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT productos_id_KEY PRIMARY KEY (id)
)ENGINE=InnoDB;

-- Tabla de copias de seguridad de 3D Spectrum
CREATE TABLE IF NOT EXISTS copias_seguridad (
    id INT AUTO_INCREMENT,
    nombre VARCHAR(200) NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT cop_seg_id_KEY PRIMARY KEY (id)
)ENGINE=InnoDB;