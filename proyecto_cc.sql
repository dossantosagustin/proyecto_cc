-- --------------------------------------------------------
-- Base de datos: proyecto_cc
-- --------------------------------------------------------

DROP DATABASE IF EXISTS `proyecto_cc`;

CREATE DATABASE `proyecto_cc`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `proyecto_cc`;

-- --------------------------------------------------------
-- Tabla: banda_proyecto
-- --------------------------------------------------------

DROP TABLE IF EXISTS `banda_proyecto`;

CREATE TABLE `banda_proyecto` (
  `id_banda` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `genero_estilo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `redes_sociales` varchar(255) DEFAULT NULL,
  `link_musica` varchar(500) NOT NULL,
  `link_presentacion` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_banda`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------
-- Tabla: contacto
-- --------------------------------------------------------

DROP TABLE IF EXISTS `contacto`;

CREATE TABLE `contacto` (
  `id_contacto` int NOT NULL AUTO_INCREMENT,
  `id_banda` int NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefono_whatsapp` varchar(50) NOT NULL,
  PRIMARY KEY (`id_contacto`),
  KEY `id_banda` (`id_banda`),
  CONSTRAINT `contacto_ibfk_1`
    FOREIGN KEY (`id_banda`)
    REFERENCES `banda_proyecto` (`id_banda`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------
-- Tabla: disponibilidad
-- --------------------------------------------------------

DROP TABLE IF EXISTS `disponibilidad`;

CREATE TABLE `disponibilidad` (
  `id_disponibilidad` int NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `estado` varchar(30) NOT NULL,
  `observaciones` text,
  PRIMARY KEY (`id_disponibilidad`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

INSERT INTO disponibilidad
(fecha, hora_inicio, hora_fin, estado, observaciones)
VALUES
('2026-09-20', '18:00:00', '22:00:00', 'DISPONIBLE', 'Fecha disponible para pruebas');

-- --------------------------------------------------------
-- Tabla: propuesta
-- --------------------------------------------------------

DROP TABLE IF EXISTS `propuesta`;

CREATE TABLE `propuesta` (
  `id_propuesta` int NOT NULL AUTO_INCREMENT,
  `id_banda` int NOT NULL,
  `id_contacto` int NOT NULL,
  `id_disponibilidad` int NOT NULL,
  `descripcion_propuesta` text NOT NULL,
  `rider_tecnico` varchar(500) DEFAULT NULL,
  `fecha_envio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` varchar(30) NOT NULL DEFAULT 'PENDIENTE',

  PRIMARY KEY (`id_propuesta`),

  KEY `id_banda` (`id_banda`),
  KEY `id_contacto` (`id_contacto`),
  KEY `id_disponibilidad` (`id_disponibilidad`),

  CONSTRAINT `propuesta_ibfk_1`
    FOREIGN KEY (`id_banda`)
    REFERENCES `banda_proyecto` (`id_banda`),

  CONSTRAINT `propuesta_ibfk_2`
    FOREIGN KEY (`id_contacto`)
    REFERENCES `contacto` (`id_contacto`),

  CONSTRAINT `propuesta_ibfk_3`
    FOREIGN KEY (`id_disponibilidad`)
    REFERENCES `disponibilidad` (`id_disponibilidad`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------
-- Tabla: evento
-- --------------------------------------------------------

DROP TABLE IF EXISTS `evento`;

CREATE TABLE `evento` (
  `id_evento` int NOT NULL AUTO_INCREMENT,
  `id_propuesta` int NOT NULL,
  `estado` varchar(30) NOT NULL DEFAULT 'PROGRAMADO',

  PRIMARY KEY (`id_evento`),

  KEY `id_propuesta` (`id_propuesta`),

  CONSTRAINT `evento_ibfk_1`
    FOREIGN KEY (`id_propuesta`)
    REFERENCES `propuesta` (`id_propuesta`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;