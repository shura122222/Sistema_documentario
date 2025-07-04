-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         9.3.0 - MySQL Community Server - GPL
-- SO del servidor:              Linux
-- HeidiSQL Versión:             12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para criminalistica_db
CREATE DATABASE IF NOT EXISTS `criminalistica_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `criminalistica_db`;

-- Volcando estructura para tabla criminalistica_db.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `direccion` text,
  `area` enum('mesa_de_partes','secretaria','inspeccion','identificacion','balistica','grafotecnia','antropologia','cerap') NOT NULL,
  `cargo` enum('jefe_de_unidad') NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dni` (`dni`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla criminalistica_db.usuarios: ~9 rows (aproximadamente)
REPLACE INTO `usuarios` (`id`, `nombres`, `apellidos`, `dni`, `telefono`, `email`, `direccion`, `area`, `cargo`, `usuario`, `password`, `estado`, `fecha_registro`, `fecha_actualizacion`) VALUES
	(1, 'Juan Carlos', 'Mamani Quispe', '12345678', NULL, 'prueva@gmail.com', NULL, 'mesa_de_partes', 'jefe_de_unidad', 'jefe', '$2y$10$GUSwPflOmFrKJnrpWq5myOdSyz7e9uUVqTWbjp0jMG6jsRVcu8.Zq', 'activo', '2025-06-09 22:25:02', '2025-06-23 03:12:36'),
	(2, 'lino', 'yupanqui', '32323232', '970809955', 'lino@gmail.com', 'jr.sigue buscando N123', 'mesa_de_partes', 'jefe_de_unidad', 'lino', '$2y$10$.r200pIxcwJH3gRFh0eAJO/V3pZh/oa.19.8M0dAuwrNe7ExkDhsi', 'activo', '2025-06-09 22:55:31', '2025-06-09 22:55:31'),
	(10, 'clever', 'Quispe', '32457821', '958745612', 'clever@gmail.com', 'cuadra 2', 'antropologia', 'jefe_de_unidad', 'clever', '$2y$10$im7Td08fMqR9ci0OveAOTeybuqRYFo6eidutE3J7K1h444k0WoHcC', 'activo', '2025-06-13 22:38:35', '2025-06-30 18:37:47'),
	(11, 'Rony', 'Valdez', '21548965', '985741233', 'rony@gmail.com', 'simon Bolivar', 'grafotecnia', 'jefe_de_unidad', 'Rony', '$2y$10$lG.JocDdTS6zKOr7siaPIuJ1U5SYfZ.TUqtDSRSk9CJj3jRIp1G/a', 'activo', '2025-06-13 22:48:54', '2025-06-13 22:48:54'),
	(12, 'Nelson', 'Choque', '87453298', '978562165', 'nelson@gmail.com', 'tupac amaru', 'identificacion', 'jefe_de_unidad', 'Nelson', '$2y$10$oyhxn0STpkH1CCr5bI/qLOPY3vSTmON0RWdxYFQDpfd.B1.Ud4XOa', 'activo', '2025-06-13 22:55:10', '2025-06-13 22:55:10'),
	(13, 'ronal', 'yupanqui', '45561278', '954782365', 'ronal@gmail.com', 'jr manco capac', 'secretaria', 'jefe_de_unidad', 'ronal', '$2y$10$0./o709JV2H7MefajVmX7OnZlchGS82vaJyAGzDaVAyE2EWR4k9p.', 'activo', '2025-06-13 22:57:18', '2025-06-13 22:57:18'),
	(14, 'yami', 'Quispe', '54785623', '978451236', 'yu@gmail.com', 'jr. perdidos', 'secretaria', 'jefe_de_unidad', 'yami', '$2y$10$GRShWVIIrQMwL9Xo9oYZCOtbv8yFYrG7wUU.UaEGh6bEo.ACX4XN2', 'activo', '2025-06-13 23:47:11', '2025-06-30 18:37:14'),
	(15, 'carol', 'Camaqui', '89543265', '978651254', 'carol@gmail.com', 'jr pandas gorditos', 'cerap', 'jefe_de_unidad', 'carol', '$2y$10$yPmak1gh5o9BzFmm/GFQC.tooFOCGUqUPbPHHfGRDOasx95BEyPUq', 'activo', '2025-06-13 23:53:26', '2025-06-13 23:53:26'),
	(16, 'Ruth', 'Chambi', '45892365', '956872345', 'ruth@gmail.com', 'Av. Valdez N 123', 'identificacion', 'jefe_de_unidad', 'Ruth', '$2y$10$5xKLT975ofxsQeKzoOhQJ.rXTXO4H3WahLLL/VNOKwxB9njBM4TiG', 'activo', '2025-06-14 19:29:04', '2025-06-14 19:29:04'),
	(17, 'royer', 'Mamani', '77334495', '987652354', 'royer@gmail.com', 'jr royer', 'identificacion', 'jefe_de_unidad', 'royer', '$2y$10$MSUSEEMHNuvqNmfeGp2COeHC7tEKWLOwpeILiLaqJw7xuWd7wyDHK', 'activo', '2025-06-16 19:16:43', '2025-06-16 19:16:43'),
	(18, 'jaimito', 'de los badyardigans', '88887777', '222224523', 'jaimico@gmail.com', 'Jr. los hablos mas na 45', 'cerap', 'jefe_de_unidad', 'dibujito10', '$2y$10$d0IXVnPQRQq20tKVckEDWe11DmFCD9KF7GtLli35iugk.eWGbjPlK', 'activo', '2025-06-20 22:04:42', '2025-06-20 22:04:42'),
	(19, 'Elsa', 'Suares', '87562345', '987653254', 'elsa@gmail.com', 'jr aeaaa', 'inspeccion', 'jefe_de_unidad', 'Elsa', '$2y$10$rabP06kYZi5E2zjqMrP6qOiT.4x6wnJ/war92ijMAWW/zi0GBIFsq', 'activo', '2025-06-23 04:32:49', '2025-06-23 04:32:49');

-- Volcando estructura para tabla criminalistica_db.usuarios_admin
CREATE TABLE IF NOT EXISTS `usuarios_admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `area` enum('jefatura') COLLATE utf8mb4_general_ci NOT NULL,
  `nombre_completo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `cargo` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` enum('activo','inactivo') COLLATE utf8mb4_general_ci DEFAULT 'activo',
  `ultimo_acceso` timestamp NULL DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla criminalistica_db.usuarios_admin: ~2 rows (aproximadamente)
REPLACE INTO `usuarios_admin` (`id`, `usuario`, `password`, `area`, `nombre_completo`, `cargo`, `estado`, `ultimo_acceso`, `fecha_creacion`, `fecha_modificacion`) VALUES
	(1, 'admin@gmail.com', '$2y$10$2PTbu/JNi1oEBrpkE.WzDul7cOUOABq6j0xS88xVqHSBIg/HY0zg.', 'jefatura', 'Juan Carlos Mamani', 'Jefe General', 'activo', '2025-06-30 18:52:02', '2025-05-30 01:24:36', '2025-06-30 18:52:02'),
	(9, 'usuario@gmail.com', '$2y$10$CcRsQhsaal.PC3XBPFPxC.lgvvIhTh/2gfOL66i06DjrlJhPv65Xe', 'jefatura', 'María Elena González', 'auxiliar', 'activo', '2025-06-14 19:00:26', '2025-05-30 03:14:49', '2025-06-14 19:00:26');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
