-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 19-05-2025 a las 18:21:05
-- Versión del servidor: 8.2.0
-- Versión de PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sala de computo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservacion`
--

DROP TABLE IF EXISTS `reservacion`;
CREATE TABLE IF NOT EXISTS `reservacion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `motivo` varchar(250) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `reservacion`
--

INSERT INTO `reservacion` (`id`, `nombre`, `motivo`, `fecha`, `hora`) VALUES
(1, 'Arlette Paulina Vargas zaragoza', 'Practicas PHP', '0000-00-00', '00:00:00'),
(2, 'gilberto vazquez', 'examen', '0000-00-00', '00:00:00'),
(3, 'Arlette', 'Practicas PHP', '0000-00-00', '07:00:00'),
(4, 'Gilberton', 'Examen JS', '0000-00-00', '12:00:00'),
(5, 'Alan Marín', 'Practicas', '0000-00-00', '12:00:00'),
(6, 'Arlette', 'Practicas PHP', '2025-05-20', '08:00:00'),
(7, 'arlette', 'php', '2025-05-20', '08:00:00'),
(8, 'Concha Maria', 'peliculeada', '2025-05-21', '12:00:00'),
(9, 'arlette', 'practicas', '2025-05-21', '12:00:00'),
(10, 'Arlette', 'Practicas PHP', '2025-05-21', '12:00:00'),
(11, 'Gilberton', 'Examen de java', '2025-05-19', '07:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
