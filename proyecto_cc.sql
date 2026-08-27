-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para proyecto_cc
DROP DATABASE IF EXISTS `proyecto_cc`;
CREATE DATABASE IF NOT EXISTS `proyecto_cc` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `proyecto_cc`;

-- Volcando estructura para tabla proyecto_cc.banda_proyecto
DROP TABLE IF EXISTS `banda_proyecto`;
CREATE TABLE IF NOT EXISTS `banda_proyecto` (
  `id_banda` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `genero_estilo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `redes_sociales` varchar(255) DEFAULT NULL,
  `link_musica` varchar(500) NOT NULL,
  `link_presentacion` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_banda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proyecto_cc.contacto
DROP TABLE IF EXISTS `contacto`;
CREATE TABLE IF NOT EXISTS `contacto` (
  `id_contacto` int NOT NULL AUTO_INCREMENT,
  `id_banda` int NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefono_whatsapp` varchar(50) NOT NULL,
  PRIMARY KEY (`id_contacto`),
  KEY `id_banda` (`id_banda`),
  CONSTRAINT `contacto_ibfk_1` FOREIGN KEY (`id_banda`) REFERENCES `banda_proyecto` (`id_banda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proyecto_cc.disponibilidad
DROP TABLE IF EXISTS `disponibilidad`;
CREATE TABLE IF NOT EXISTS `disponibilidad` (
  `id_disponibilidad` int NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `estado` varchar(30) NOT NULL,
  `observaciones` text,
  PRIMARY KEY (`id_disponibilidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proyecto_cc.evento
DROP TABLE IF EXISTS `evento`;
CREATE TABLE IF NOT EXISTS `evento` (
  `id_evento` int NOT NULL AUTO_INCREMENT,
  `id_propuesta` int NOT NULL,
  `estado` varchar(30) NOT NULL DEFAULT 'PROGRAMADO',
  PRIMARY KEY (`id_evento`),
  KEY `id_propuesta` (`id_propuesta`),
  CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`id_propuesta`) REFERENCES `propuesta` (`id_propuesta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proyecto_cc.propuesta
DROP TABLE IF EXISTS `propuesta`;
CREATE TABLE IF NOT EXISTS `propuesta` (
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
  CONSTRAINT `propuesta_ibfk_1` FOREIGN KEY (`id_banda`) REFERENCES `banda_proyecto` (`id_banda`),
  CONSTRAINT `propuesta_ibfk_2` FOREIGN KEY (`id_contacto`) REFERENCES `contacto` (`id_contacto`),
  CONSTRAINT `propuesta_ibfk_3` FOREIGN KEY (`id_disponibilidad`) REFERENCES `disponibilidad` (`id_disponibilidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
