-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 28-05-2025 a las 16:05:07
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
-- Base de datos: `inter2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

DROP TABLE IF EXISTS `administradores`;
CREATE TABLE IF NOT EXISTS `administradores` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id_admin`, `nombre_completo`, `usuario`, `contrasena`) VALUES
(1, 'Leonel Bautista Hernandez', 'admin', '$2b$12$QdD4.XmiahzXyoP9wXZaGOBZk5iU5dQy2wECFZpSRCd.mfARQWX72');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
CREATE TABLE IF NOT EXISTS `alumnos` (
  `id_alumno` int NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(100) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `id_grupo` int NOT NULL,
  PRIMARY KEY (`id_alumno`),
  UNIQUE KEY `usuario` (`usuario`),
  KEY `id_grupo` (`id_grupo`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id_alumno`, `nombre_completo`, `usuario`, `contrasena`, `id_grupo`) VALUES
(1, 'ALVAREZ HERNANDEZ KATHIA GUADALUPE', 'AHKIA01', '$2y$10$eImG9zX8ZZFtFxGdXPSqne2cb.0ZJH9K6GGGYmN3ArEdjLs69ku1C', 1),
(2, 'BARCENAS AGUILLON AARON', 'BAAIA02', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(3, 'CARDENAS HERNANDEZ BRANDON', 'CHBIA03', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(4, 'CASTELLANOS INFANTE JEITZEL YOSSELIN', 'CIJIA04', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(5, 'CASTRO PAZ MA. ISABEL', 'CPMIA05', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(6, 'CERVANTES LARRAGA PEDRO URIEL', 'CLPIA06', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(7, 'CRUZ MARTINEZ DAMARIS FERNANDA', 'CMDIA07', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(8, 'DEL ROSAL VAZQUEZ EDNA CAROLINA', 'DRVIA08', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(9, 'DELGADO MELGAREJO ABEL', 'DMAIA09', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(10, 'DIAZ GUERRERO LAURA IVON', 'DGLIA10', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(11, 'DIAZ PEREZ JOSE ALBERTO', 'DPJIA11', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(12, 'DOMINGUEZ TREJO BEATRIZ', 'DTBIA12', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(13, 'GALICIA ALVAREZ ANETTE MICHELLE', 'GAAIA13', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(14, 'GONZALEZ SANTIAGO ROSA ELIA', 'GSRIA14', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(15, 'HERNANDEZ MARTINEZ SAUL', 'HMSIA15', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(16, 'HERNANDEZ ZARATE ALBERTO BEGNE', 'HZAIA16', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(17, 'LOPEZ ZAPATA RAYBE', 'LZRIA17', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(18, 'MARTINEZ RIVAS ERICK ALFONSO', 'MREIA18', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(19, 'NUÑEZ RIVERA HASLEY MICHELL', 'NRHIA19', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(20, 'PALACIOS HERNANDEZ AYDE', 'PHAIA20', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(21, 'PLACENCIA GARCIA JORGE', 'PGJIA21', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(22, 'RIVERA MEZA DERIAN ALEJANDRO', 'RMDIA22', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(23, 'RODRIGUEZ BUSTOS JORGE', 'RBJIA23', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(24, 'ROSALES MARTINEZ BRENDA LIZETH', 'RMBIA24', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(25, 'SANTIAGO ORDUÑA ARLETTE KARELLY', 'SOAIA25', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(26, 'SANTOS CRUZ ZULMA YULIANA', 'SCZIA26', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(27, 'VALDEZ MARTINEZ ERICK RAUL', 'VMEIA27', '$2b$12$dpysbnUG5QG5CCzIgZrG6eFdTAl8db/l2/GZ8HrbvPwQJ8OjVkgmm', 1),
(28, 'ALVAREZ PEREZ VICTOR ANTONIO', 'APVIA01', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(29, 'ALVAREZ SANTIAGO GRISELDA', 'ASGIA02', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(30, 'BARBOSA VILLANUEVA LAZARO', 'BVLIA03', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(31, 'BAUTISTA HERNANDEZ LEONEL', 'BHLIA04', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(32, 'CONTRERAS ENCARNACION LUZ VIANEY', 'CELIA05', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(33, 'DEL ANGEL MELO JUDIT', 'DAMIA06', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(34, 'ESCOBAR MORADO LESLYE MARGARITA', 'EMLIA07', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(35, 'GARCIA HERNANDEZ ALEJANDRA', 'GHAIA08', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(36, 'GONZALEZ PINEDA MARIA FERNANDA', 'GPMIA09', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(37, 'GUTIERREZ REYES BRAYAN', 'GRBIA10', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(38, 'HERNANDEZ FRANCO BRYAN', 'HFBIA11', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(39, 'LOPEZ MOREIRA MILTON EMILIANO', 'LMMIA12', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(40, 'LOREDO HERNANDEZ HANIA PAOLA', 'LHHIA13', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(41, 'MENDEZ RODRIGUEZ CINDY ABIGAHIL', 'MRCIA14', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(42, 'MENDEZ RODRIGUEZ JEHIMMY KATALINA', 'MRJIA15', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(43, 'NARVAEZ NEPOMUCENO MARIA GUADALUPE', 'NNMIA16', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(44, 'RAMOS GONZALEZ KENIA ANAHI', 'RGKIA17', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(45, 'RESENDIZ GUZMAN SOLEDAD', 'RGSIA18', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(46, 'RODRIGUEZ BARBOSA ARIANNA', 'RBAIA19', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(47, 'RODRIGUEZ MARTINEZ ALAN MARIN', 'RMAIA20', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(48, 'ROMERO LOPEZ NUBIA AZUCENA', 'RLNIA21', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(49, 'SANTIAGO SANTIAGO ANA GRICELDA', 'SSAIA22', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(50, 'SIERRA HERNANDEZ ROCIO', 'SHRIA23', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(51, 'SOLIS BARRON ARTURO', 'SBAIA24', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(52, 'TORRES FLORES ALAIN', 'TFAIA25', '$2b$12$DY.QaUtyBHA87qHrYvP8.Of8I/UB2MhdO33jMESaEkxCPwxxEs9Dm', 2),
(53, 'BASILIO HERNANDEZ ALMA BERENICE', 'BHAIA01', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(54, 'CASTILLO FLORES JOSE MANUEL', 'CFJIA02', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(55, 'CRUZ LARA OSCAR', 'CLOIA03', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(56, 'FLORES ZAMUDIO JOSE ANGEL', 'FZJIA04', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(57, 'FRANCO HERNANDEZ EDGARDO', 'FHEIA05', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(58, 'GALLEGOS RAMOS BRANDON', 'GRBIA06', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(59, 'GALVAN RIVERA HEIDY', 'GRHIA07', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(60, 'GONZALEZ NARVAEZ MARIA FERNANDA', 'GNMIA08', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(61, 'HERNANDEZ GOODY JESUS', 'HGJIA09', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(62, 'HERNANDEZ GONZALEZ OBED', 'HGOIA10', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(63, 'HERNANDEZ NAVA VANESSA', 'HNVIA11', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(64, 'HERNANDEZ PEREZ MA. FERNANDA', 'HPMIA12', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(65, 'INFANTE PECINA SAYDI YEDANI', 'IPSIA13', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(66, 'JIMENEZ CASTILLO LUIS ANGEL', 'JCLIA14', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(67, 'MARQUEZ HERNANDEZ JUANA IVETT', 'MHJIA15', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(68, 'MARTINEZ NIMMERFALL BRAYAN RONALDO', 'MNBIA16', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(69, 'MARTINEZ REYES CLAUDIA', 'MRCIA17', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(70, 'MARTINEZ SALVADOR CARLOS EDUARDO', 'MSCIA18', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(71, 'MATA ZAVALA ABIGAIL', 'MZAIA19', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(72, 'MERAZ CARRANZA AGUSTIN DE JESUS', 'MCAIA20', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(73, 'MOLINA ANGELES BRAYAN UZIEL', 'MABIA21', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(74, 'NICOLAS GUDIÑO YARA VIANEY', 'NGYIA22', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(75, 'OLMOS HERNANDEZ HEROMI MONSERRATH', 'OHHIA23', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(76, 'PULIDO GUERRERO LUIS MANUEL', 'PGLIA24', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(77, 'REYES FELICIANO JORGE DANIEL', 'RFJIA25', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(78, 'REYES TINAJERO RUBEN MARTIN', 'RTRIA26', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(79, 'RODRIGUEZ GONZALEZ RENATA ITZEL', 'RGRIA27', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(80, 'RODRIGUEZ PONCE CAROLINA', 'RPCIA28', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(81, 'SALDAÑA CASTRO YAHIR', 'SCYIA29', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(82, 'TORRES LARA ALEXA MONSERRAT', 'TLAIA30', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(83, 'VALDEZ SANTIAGO ZULEMA', 'VSZIA31', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(84, 'VAZQUEZ OLGUIN ONEY', 'VOOIA32', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(85, 'VILLEGAS CARVAJAL DIEGO ARMANDO', 'VCDIA33', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(86, 'ZAPATA CASTILLO ROCIO DEL CARMEN', 'ZCRIA34', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(87, 'ZARATE MENDOZA GUSTAVO ANGEL', 'ZMGIA35', '$2b$12$Nd7SVngq/RM6p/ZmRArGuO93MUlQT05Pth1Kbe5oc0nkycShHbGjO', 3),
(88, 'ALONSO CAMARGO IRENE', 'ACIIA01', '$2b$12$QdD4.XmiahzXyoP9wXZaGOBZk5iU5dQy2wECFZpSRCd.mfARQWX72', 4),
(89, 'ARADILLAS BALDERAS AMERICA YUNUEN', 'ABAIA02', '$2b$12$QdD4.XmiahzXyoP9wXZaGOBZk5iU5dQy2wECFZpSRCd.mfARQWX72', 4),
(90, 'CARRANZA CHIQUITO JORGE LUIS', 'CCJIA03', '$2b$12$QdD4.XmiahzXyoP9wXZaGOBZk5iU5dQy2wECFZpSRCd.mfARQWX72', 4),
(91, 'CHAVEZ PEREZ MARIBEL', 'CPMIA04', '$2b$12$QdD4.XmiahzXyoP9wXZaGOBZk5iU5dQy2wECFZpSRCd.mfARQWX72', 4),
(92, 'EZQUIVEL POZOS LEYLI YOLOTZIN', 'EPLIA05', '$2b$12$QdD4.XmiahzXyoP9wXZaGOBZk5iU5dQy2wECFZpSRCd.mfARQWX72', 4),
(93, 'HERNANDEZ CRUZ ALICIA', 'HCAIA06', '$2b$12$QdD4.XmiahzXyoP9wXZaGOBZk5iU5dQy2wECFZpSRCd.mfARQWX72', 4),
(94, 'HERNANDEZ PEREZ MAR LIZETH', 'HPMIA07', '$2b$12$QdD4.XmiahzXyoP9wXZaGOBZk5iU5dQy2wECFZpSRCd.mfARQWX72', 4),
(95, 'HERNANDEZ PEREZ MIRIAM ROXANA', 'HPMIA08', '$2b$12$QdD4.XmiahzXyoP9wXZaGOBZk5iU5dQy2wECFZpSRCd.mfARQWX72', 4),
(96, 'LOPEZ ALVARADO JORGE EDUARDO', 'LAJIA09', '$2b$12$QdD4.XmiahzXyoP9wXZaGOBZk5iU5dQy2wECFZpSRCd.mfARQWX72', 4),
(97, 'LOPEZ PEREZ CASSANDRA', 'LPCIA10', '$2b$12$QdD4.XmiahzXyoP9wXZaGOBZk5iU5dQy2wECFZpSRCd.mfARQWX72', 4),
(98, 'MARQUEZ HERNANDEZ NATHALI', 'MHNIA11', '$2b$12$QdD4.XmiahzXyoP9wXZaGOBZk5iU5dQy2wECFZpSRCd.mfARQWX72', 4),
(99, 'MARTINEZ FRANCO ANAHI', 'MFAIA12', '$2b$12$QdD4.XmiahzXyoP9wXZaGOBZk5iU5dQy2wECFZpSRCd.mfARQWX72', 4),
(100, 'MENDOZA BAEZ DULCE ELENA', 'MBDIA13', '$2b$12$QdD4.XmiahzXyoP9wXZaGOBZk5iU5dQy2wECFZpSRCd.mfARQWX72', 4),
(101, 'MERAZ SALVADOR HEIDI NATALI', 'MSHNIA98', '$2b$12$82fM0WFl/FFvNSfXB5W4HeUCy5NcM4.6K9586yY4DyTWLat5ZfAg2', 4),
(102, 'MUÑOZ HERNANDEZ JOSE LUIS', 'MHJLIA99', '$2b$12$FKsIFRFGbUKTHuLkWsvjnuNRelLAE.wsmClfZ9PG9ICWo0lo1m99O', 4),
(103, 'ORTIZ SANCHEZ MANUEL', 'OSMIA16', '$2b$12$FKsIFRFGbUKTHuLkWsvjnuNRelLAE.wsmClfZ9PG9ICWo0lo1m99O', 4),
(104, 'RANGEL MANUEL SABAS ANDRES', 'RMSIA17', '$2b$12$FKsIFRFGbUKTHuLkWsvjnuNRelLAE.wsmClfZ9PG9ICWo0lo1m99O', 4),
(105, 'RODRIGUEZ MENDEZ BRYAN HORACIO', 'RMBIA18', '$2b$12$FKsIFRFGbUKTHuLkWsvjnuNRelLAE.wsmClfZ9PG9ICWo0lo1m99O', 4),
(106, 'SANTIAGO MARTINEZ RUTH', 'SMRIA19', '$2b$12$FKsIFRFGbUKTHuLkWsvjnuNRelLAE.wsmClfZ9PG9ICWo0lo1m99O', 4),
(107, 'SANTIAGO SANTIAGO NORMA LIZETH', 'SSNIA20', '$2b$12$FKsIFRFGbUKTHuLkWsvjnuNRelLAE.wsmClfZ9PG9ICWo0lo1m99O', 4),
(108, 'SAUCEDO HERRERA IRVING ISRAEL', 'SHIIA21', '$2b$12$FKsIFRFGbUKTHuLkWsvjnuNRelLAE.wsmClfZ9PG9ICWo0lo1m99O', 4),
(109, 'SEGOVIA GONZALEZ KEVIN ALBERTO', 'SGKIA22', '$2b$12$FKsIFRFGbUKTHuLkWsvjnuNRelLAE.wsmClfZ9PG9ICWo0lo1m99O', 4),
(110, 'SEGURA BORJAS JIMENA', 'SBJIA23', '$2b$12$FKsIFRFGbUKTHuLkWsvjnuNRelLAE.wsmClfZ9PG9ICWo0lo1m99O', 4),
(111, 'VILLEGAS AZUARA ABEL', 'VAAIA24', '$2b$12$FKsIFRFGbUKTHuLkWsvjnuNRelLAE.wsmClfZ9PG9ICWo0lo1m99O', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos_calificaciones`
--

DROP TABLE IF EXISTS `archivos_calificaciones`;
CREATE TABLE IF NOT EXISTS `archivos_calificaciones` (
  `id_archivo` int NOT NULL AUTO_INCREMENT,
  `id_maestro` int NOT NULL,
  `id_grupo` int NOT NULL,
  `id_materia` int NOT NULL,
  `parcial` int NOT NULL,
  `nombre_excel` varchar(255) DEFAULT NULL,
  `nombre_pdf` varchar(255) DEFAULT NULL,
  `fecha_subida` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_archivo`),
  KEY `id_maestro` (`id_maestro`),
  KEY `id_grupo` (`id_grupo`),
  KEY `id_materia` (`id_materia`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `archivos_calificaciones`
--

INSERT INTO `archivos_calificaciones` (`id_archivo`, `id_maestro`, `id_grupo`, `id_materia`, `parcial`, `nombre_excel`, `nombre_pdf`, `fecha_subida`) VALUES
(33, 3, 2, 11, 1, '1P-FUNDAMENTOSDE-LMCRS.xlsx', NULL, '2025-05-13 16:15:39'),
(34, 2, 2, 10, 1, '1P-FINANZAS-LEMH.xlsx', NULL, '2025-05-16 00:01:30'),
(35, 1, 2, 9, 2, '2P-PHP-IAPVZ.xlsx', NULL, '2025-05-20 19:33:05'),
(36, 1, 2, 12, 1, '1P-ADMINISTRACIÓN-IAPVZ.xlsx', NULL, '2025-05-26 00:53:11'),
(38, 1, 2, 12, 2, '2P-ADMINISTRACIÓN-IAPVZ.xlsx', NULL, '2025-05-26 00:59:27'),
(39, 1, 2, 9, 1, '1P-PHP-LBH.xlsx', NULL, '2025-05-26 01:02:26');

--
-- Disparadores `archivos_calificaciones`
--
DROP TRIGGER IF EXISTS `borrar_calificaciones_al_eliminar_archivo`;
DELIMITER $$
CREATE TRIGGER `borrar_calificaciones_al_eliminar_archivo` AFTER DELETE ON `archivos_calificaciones` FOR EACH ROW BEGIN
    DELETE FROM calificaciones
    WHERE id_maestro = OLD.id_maestro
      AND id_grupo = OLD.id_grupo
      AND id_materia = OLD.id_materia
      AND parcial = OLD.parcial;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

DROP TABLE IF EXISTS `calificaciones`;
CREATE TABLE IF NOT EXISTS `calificaciones` (
  `id_calificacion` int NOT NULL AUTO_INCREMENT,
  `id_alumno` int NOT NULL,
  `id_maestro` int NOT NULL,
  `id_materia` int NOT NULL,
  `id_grupo` int NOT NULL,
  `parcial` int NOT NULL,
  `calificacion` decimal(5,2) DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_calificacion`),
  KEY `id_alumno` (`id_alumno`),
  KEY `id_materia` (`id_materia`),
  KEY `idx_consulta` (`id_grupo`,`id_materia`,`id_alumno`,`parcial`)
) ENGINE=InnoDB AUTO_INCREMENT=930 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `calificaciones`
--

INSERT INTO `calificaciones` (`id_calificacion`, `id_alumno`, `id_maestro`, `id_materia`, `id_grupo`, `parcial`, `calificacion`, `fecha_registro`) VALUES
(795, 28, 3, 11, 2, 1, 4.00, '2025-05-13 16:15:39'),
(796, 29, 3, 11, 2, 1, 5.00, '2025-05-13 16:15:39'),
(797, 30, 3, 11, 2, 1, 6.00, '2025-05-13 16:15:39'),
(798, 31, 3, 11, 2, 1, 7.00, '2025-05-13 16:15:39'),
(799, 32, 3, 11, 2, 1, 2.00, '2025-05-13 16:15:39'),
(800, 28, 2, 10, 2, 1, 4.00, '2025-05-16 00:01:30'),
(801, 29, 2, 10, 2, 1, 5.00, '2025-05-16 00:01:30'),
(802, 30, 2, 10, 2, 1, 6.00, '2025-05-16 00:01:30'),
(803, 31, 2, 10, 2, 1, 7.00, '2025-05-16 00:01:30'),
(804, 32, 2, 10, 2, 1, 2.00, '2025-05-16 00:01:30'),
(805, 28, 1, 9, 2, 2, 9.40, '2025-05-20 19:33:05'),
(806, 29, 1, 9, 2, 2, 5.80, '2025-05-20 19:33:05'),
(807, 30, 1, 9, 2, 2, 9.80, '2025-05-20 19:33:05'),
(808, 31, 1, 9, 2, 2, 9.90, '2025-05-20 19:33:05'),
(809, 32, 1, 9, 2, 2, 9.70, '2025-05-20 19:33:05'),
(810, 33, 1, 9, 2, 2, 9.40, '2025-05-20 19:33:05'),
(811, 34, 1, 9, 2, 2, 8.20, '2025-05-20 19:33:05'),
(812, 35, 1, 9, 2, 2, 9.80, '2025-05-20 19:33:05'),
(813, 36, 1, 9, 2, 2, 7.40, '2025-05-20 19:33:05'),
(814, 37, 1, 9, 2, 2, 8.60, '2025-05-20 19:33:05'),
(815, 38, 1, 9, 2, 2, 6.30, '2025-05-20 19:33:05'),
(816, 39, 1, 9, 2, 2, 6.50, '2025-05-20 19:33:05'),
(817, 40, 1, 9, 2, 2, 7.70, '2025-05-20 19:33:05'),
(818, 41, 1, 9, 2, 2, 8.90, '2025-05-20 19:33:05'),
(819, 42, 1, 9, 2, 2, 0.00, '2025-05-20 19:33:05'),
(820, 43, 1, 9, 2, 2, 7.80, '2025-05-20 19:33:05'),
(821, 44, 1, 9, 2, 2, 10.00, '2025-05-20 19:33:05'),
(822, 45, 1, 9, 2, 2, 10.00, '2025-05-20 19:33:05'),
(823, 46, 1, 9, 2, 2, 7.30, '2025-05-20 19:33:05'),
(824, 47, 1, 9, 2, 2, 9.20, '2025-05-20 19:33:05'),
(825, 48, 1, 9, 2, 2, 7.70, '2025-05-20 19:33:05'),
(826, 49, 1, 9, 2, 2, 9.70, '2025-05-20 19:33:05'),
(827, 50, 1, 9, 2, 2, 7.00, '2025-05-20 19:33:05'),
(828, 51, 1, 9, 2, 2, 9.50, '2025-05-20 19:33:05'),
(829, 52, 1, 9, 2, 2, 7.00, '2025-05-20 19:33:05'),
(830, 28, 1, 12, 2, 1, 9.80, '2025-05-26 00:53:11'),
(831, 29, 1, 12, 2, 1, 7.40, '2025-05-26 00:53:11'),
(832, 30, 1, 12, 2, 1, 9.10, '2025-05-26 00:53:11'),
(833, 31, 1, 12, 2, 1, 9.90, '2025-05-26 00:53:11'),
(834, 32, 1, 12, 2, 1, 9.80, '2025-05-26 00:53:11'),
(835, 33, 1, 12, 2, 1, 7.20, '2025-05-26 00:53:11'),
(836, 34, 1, 12, 2, 1, 7.80, '2025-05-26 00:53:11'),
(837, 35, 1, 12, 2, 1, 9.80, '2025-05-26 00:53:11'),
(838, 36, 1, 12, 2, 1, 8.50, '2025-05-26 00:53:11'),
(839, 37, 1, 12, 2, 1, 7.00, '2025-05-26 00:53:11'),
(840, 38, 1, 12, 2, 1, 8.10, '2025-05-26 00:53:11'),
(841, 39, 1, 12, 2, 1, 7.00, '2025-05-26 00:53:11'),
(842, 40, 1, 12, 2, 1, 9.10, '2025-05-26 00:53:11'),
(843, 41, 1, 12, 2, 1, 9.30, '2025-05-26 00:53:11'),
(844, 42, 1, 12, 2, 1, 1.10, '2025-05-26 00:53:11'),
(845, 43, 1, 12, 2, 1, 9.70, '2025-05-26 00:53:11'),
(846, 44, 1, 12, 2, 1, 9.70, '2025-05-26 00:53:11'),
(847, 45, 1, 12, 2, 1, 9.70, '2025-05-26 00:53:11'),
(848, 46, 1, 12, 2, 1, 7.20, '2025-05-26 00:53:11'),
(849, 47, 1, 12, 2, 1, 9.40, '2025-05-26 00:53:11'),
(850, 48, 1, 12, 2, 1, 8.30, '2025-05-26 00:53:11'),
(851, 49, 1, 12, 2, 1, 8.30, '2025-05-26 00:53:11'),
(852, 50, 1, 12, 2, 1, 7.00, '2025-05-26 00:53:11'),
(853, 51, 1, 12, 2, 1, 9.00, '2025-05-26 00:53:11'),
(854, 52, 1, 12, 2, 1, 8.50, '2025-05-26 00:53:11'),
(880, 28, 1, 12, 2, 2, 9.30, '2025-05-26 00:59:27'),
(881, 29, 1, 12, 2, 2, 6.80, '2025-05-26 00:59:27'),
(882, 30, 1, 12, 2, 2, 10.00, '2025-05-26 00:59:27'),
(883, 31, 1, 12, 2, 2, 9.70, '2025-05-26 00:59:27'),
(884, 32, 1, 12, 2, 2, 9.70, '2025-05-26 00:59:27'),
(885, 33, 1, 12, 2, 2, 10.00, '2025-05-26 00:59:27'),
(886, 34, 1, 12, 2, 2, 9.60, '2025-05-26 00:59:27'),
(887, 35, 1, 12, 2, 2, 9.40, '2025-05-26 00:59:27'),
(888, 36, 1, 12, 2, 2, 7.00, '2025-05-26 00:59:27'),
(889, 37, 1, 12, 2, 2, 7.30, '2025-05-26 00:59:27'),
(890, 38, 1, 12, 2, 2, 7.40, '2025-05-26 00:59:27'),
(891, 39, 1, 12, 2, 2, 5.90, '2025-05-26 00:59:27'),
(892, 40, 1, 12, 2, 2, 7.30, '2025-05-26 00:59:27'),
(893, 41, 1, 12, 2, 2, 8.20, '2025-05-26 00:59:27'),
(894, 42, 1, 12, 2, 2, 0.00, '2025-05-26 00:59:27'),
(895, 43, 1, 12, 2, 2, 9.90, '2025-05-26 00:59:27'),
(896, 44, 1, 12, 2, 2, 10.00, '2025-05-26 00:59:27'),
(897, 45, 1, 12, 2, 2, 10.00, '2025-05-26 00:59:27'),
(898, 46, 1, 12, 2, 2, 8.80, '2025-05-26 00:59:27'),
(899, 47, 1, 12, 2, 2, 9.20, '2025-05-26 00:59:27'),
(900, 48, 1, 12, 2, 2, 7.60, '2025-05-26 00:59:27'),
(901, 49, 1, 12, 2, 2, 8.10, '2025-05-26 00:59:27'),
(902, 50, 1, 12, 2, 2, 7.20, '2025-05-26 00:59:27'),
(903, 51, 1, 12, 2, 2, 9.50, '2025-05-26 00:59:27'),
(904, 52, 1, 12, 2, 2, 8.70, '2025-05-26 00:59:27'),
(905, 28, 1, 9, 2, 1, 9.60, '2025-05-26 01:02:26'),
(906, 29, 1, 9, 2, 1, 7.40, '2025-05-26 01:02:26'),
(907, 30, 1, 9, 2, 1, 9.00, '2025-05-26 01:02:26'),
(908, 31, 1, 9, 2, 1, 9.50, '2025-05-26 01:02:26'),
(909, 32, 1, 9, 2, 1, 8.10, '2025-05-26 01:02:26'),
(910, 33, 1, 9, 2, 1, 7.40, '2025-05-26 01:02:26'),
(911, 34, 1, 9, 2, 1, 7.20, '2025-05-26 01:02:26'),
(912, 35, 1, 9, 2, 1, 9.50, '2025-05-26 01:02:26'),
(913, 36, 1, 9, 2, 1, 7.50, '2025-05-26 01:02:26'),
(914, 37, 1, 9, 2, 1, 8.10, '2025-05-26 01:02:26'),
(915, 38, 1, 9, 2, 1, 7.80, '2025-05-26 01:02:26'),
(916, 39, 1, 9, 2, 1, 7.00, '2025-05-26 01:02:26'),
(917, 40, 1, 9, 2, 1, 8.80, '2025-05-26 01:02:26'),
(918, 41, 1, 9, 2, 1, 8.10, '2025-05-26 01:02:26'),
(919, 42, 1, 9, 2, 1, 1.00, '2025-05-26 01:02:26'),
(920, 43, 1, 9, 2, 1, 9.20, '2025-05-26 01:02:26'),
(921, 44, 1, 9, 2, 1, 8.40, '2025-05-26 01:02:26'),
(922, 45, 1, 9, 2, 1, 8.60, '2025-05-26 01:02:26'),
(923, 46, 1, 9, 2, 1, 9.90, '2025-05-26 01:02:26'),
(924, 47, 1, 9, 2, 1, 9.50, '2025-05-26 01:02:26'),
(925, 48, 1, 9, 2, 1, 8.10, '2025-05-26 01:02:26'),
(926, 49, 1, 9, 2, 1, 8.20, '2025-05-26 01:02:26'),
(927, 50, 1, 9, 2, 1, 7.60, '2025-05-26 01:02:26'),
(928, 51, 1, 9, 2, 1, 8.80, '2025-05-26 01:02:26'),
(929, 52, 1, 9, 2, 1, 9.00, '2025-05-26 01:02:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

DROP TABLE IF EXISTS `carreras`;
CREATE TABLE IF NOT EXISTS `carreras` (
  `id_carrera` int NOT NULL AUTO_INCREMENT,
  `nombre_carrera` varchar(100) NOT NULL,
  PRIMARY KEY (`id_carrera`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id_carrera`, `nombre_carrera`) VALUES
(1, 'LICENCIATURA EN INFORMATICA ADMINISTRATIVA'),
(2, 'LICENCIATURA EN DERECHO\r\n'),
(3, 'INGENIERIA INDUSTRIAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_alumno`
--

DROP TABLE IF EXISTS `datos_alumno`;
CREATE TABLE IF NOT EXISTS `datos_alumno` (
  `id_datos` int NOT NULL AUTO_INCREMENT,
  `id_alumno` int NOT NULL,
  `nacimiento` date DEFAULT NULL,
  `estado_civil` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `control` varchar(20) DEFAULT NULL,
  `estatus` varchar(20) DEFAULT NULL,
  `carrera` varchar(100) DEFAULT NULL,
  `especialidad` varchar(100) DEFAULT NULL,
  `plan_estudios` varchar(100) DEFAULT NULL,
  `calle` varchar(100) DEFAULT NULL,
  `colonia` varchar(100) DEFAULT NULL,
  `municipio` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_datos`),
  KEY `id_alumno` (`id_alumno`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `datos_alumno`
--

INSERT INTO `datos_alumno` (`id_datos`, `id_alumno`, `nacimiento`, `estado_civil`, `telefono`, `correo`, `control`, `estatus`, `carrera`, `especialidad`, `plan_estudios`, `calle`, `colonia`, `municipio`, `estado`) VALUES
(1, 31, '2002-09-24', 'Casado', '4891229460', 'bautistaleonel7@gmail.com', NULL, NULL, NULL, NULL, NULL, '', '', '', ''),
(2, 2, '2002-09-24', 'Soltero', '777', 'bua@gmail.com', NULL, NULL, NULL, NULL, NULL, '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disponibilidad_maestros`
--

DROP TABLE IF EXISTS `disponibilidad_maestros`;
CREATE TABLE IF NOT EXISTS `disponibilidad_maestros` (
  `id_disponibilidad` int NOT NULL AUTO_INCREMENT,
  `id_maestro` int NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `fecha_subida` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_expiracion` datetime DEFAULT NULL,
  PRIMARY KEY (`id_disponibilidad`),
  KEY `id_maestro` (`id_maestro`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `disponibilidad_maestros`
--

INSERT INTO `disponibilidad_maestros` (`id_disponibilidad`, `id_maestro`, `hora_inicio`, `hora_fin`, `fecha_subida`, `fecha_expiracion`) VALUES
(1, 1, '07:00:00', '17:30:00', '2025-05-23 20:41:23', '2025-11-23 20:41:23'),
(5, 1, '07:00:00', '17:30:00', '2025-05-23 20:41:23', '2025-11-23 20:41:23'),
(6, 1, '04:55:00', '17:55:00', '2025-05-23 20:41:23', '2025-11-23 20:41:23'),
(7, 1, '11:13:00', '23:13:00', '2025-05-23 20:41:23', '2025-11-23 20:41:23'),
(8, 1, '11:13:00', '23:13:00', '2025-05-23 20:41:23', '2025-11-23 20:41:23'),
(9, 1, '01:21:00', '01:21:00', '2025-05-23 20:41:23', '2025-11-23 20:41:23'),
(10, 1, '08:40:00', '16:20:00', '2025-05-26 11:53:47', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

DROP TABLE IF EXISTS `grupos`;
CREATE TABLE IF NOT EXISTS `grupos` (
  `id_grupo` int NOT NULL AUTO_INCREMENT,
  `nombre_grupo` varchar(100) NOT NULL,
  `id_carrera` int NOT NULL,
  `id_semestre` int DEFAULT NULL,
  PRIMARY KEY (`id_grupo`),
  KEY `id_carrera` (`id_carrera`),
  KEY `id_semestre` (`id_semestre`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id_grupo`, `nombre_grupo`, `id_carrera`, `id_semestre`) VALUES
(1, 'LIA 2° VESPERTINO', 1, 1),
(2, 'LIA 4° MATUTINO', 1, 2),
(3, 'LIA 6° MATUTINO', 1, 3),
(4, 'LIA 8° MATUTINO', 1, 4),
(5, 'LIA 1° MATUTINO', 1, 5),
(6, 'LIA 3° VESPERTINO', 1, 6),
(7, 'LIA 5° MATUTINO', 1, 7),
(8, 'LIA 7° VESPERTINO', 1, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maestros`
--

DROP TABLE IF EXISTS `maestros`;
CREATE TABLE IF NOT EXISTS `maestros` (
  `id_maestro` int NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(100) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  PRIMARY KEY (`id_maestro`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `maestros`
--

INSERT INTO `maestros` (`id_maestro`, `nombre_completo`, `usuario`, `contrasena`) VALUES
(1, 'ING. ARLETTE PAULINA VARGAS ZARAGOZA', 'apvz1', '$2y$10$JNLTSdcj3IcR3fmRDoOrT.ktIbyP6asL5SSRPdpIyXzHSSpNONiSy'),
(2, 'LIC. ELIZABETH MAR HERNANDEZ', 'emh2', '$2b$12$ml.yXaSmP0s9W0kmkQRcVOiSVf1Q1JJDRvOgy8/IiaxaH5SPbzH0C'),
(3, 'LIC. MA. CONCEPCION RODRIGUEZ SALVADOR', 'crs3', '$2b$12$T141SMzQrClnZNBRIVr7rO3be1C0l.JXx11Y9pnqczyqYkldKMBCe'),
(4, 'ING. GILBERTO VAZQUEZ SALGADO', 'gvs4', '$2b$12$AAP6dmpWTaaIB5NnwXB8XuXBKnXxzD2/wAf.4bEJRF7DzjYu5f.Ny'),
(5, 'LIC. IVON RODRIGUEZ CRUZ', 'irc5', '$2b$12$DaP5f7FM62/kgbBX82RGa.O5ZQjQweqNODBFgTeMnWRQ/SaGCqf1y'),
(6, 'LIC. VANESSA MENDOZA FRIAS', 'vmf6', '$2b$12$2zadAOi3bQECWSaTsW88huc4xcoKwcfl/a2DUOMfARnInvGrVDs3y'),
(7, 'LIC. ALVARO GONZALEZ MEDINA', 'agm7', '$2b$12$/o2X5ut99RwEv4hsKyXBge.X75/gXNMXA2Okf2JdDl2qmtVh1vkRW'),
(8, 'LIC. MARIA JUANA MARTINEZ CASTILLO', 'mjmc8', '$2b$12$sWilx58bVW/D7sDZ8dVPius2hwB8B74Nw9sSK/VgsbGBruvMfLONq'),
(9, 'LIC. SAYRA LORENA PLASENCIA CERVANTES', 'slpc9', '$2b$12$VGlF6uTc1apmJIAhozEVx.3WzFTeWNBLwlQva1Zp./.PQ7x7eSA7m'),
(10, 'ING. EUSEBIO GUZMAN ANDRES', 'ega10', '$2b$12$rqgbbD5yczBCAO/frLGmKeVqek1bVcB4bC5NzmRppv2ea0Ey/G50e'),
(11, 'LIC. FRANCISCO ALEXANDER GERMAN LEDEZMA', 'fagl11', '$2b$12$pYJCj9/DpzCMfFvErasZOOe/qAtMgiPeR6fWfzfm6aaXJDJWQRrKm'),
(12, 'ING. ENEIDA DEL CARMEN SERRANO NAVA', 'edcsn12', '$2b$12$VDvUdhjZSTqTlE3lgWbQ1.FMy3prlj5.5IvxIQmO0Dbz//U/LjV6W');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maestros_datos`
--

DROP TABLE IF EXISTS `maestros_datos`;
CREATE TABLE IF NOT EXISTS `maestros_datos` (
  `id_datos` int NOT NULL AUTO_INCREMENT,
  `id_maestro` int NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `estado_civil` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `calle` varchar(100) DEFAULT NULL,
  `colonia` varchar(100) DEFAULT NULL,
  `municipio` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_datos`),
  KEY `id_maestro` (`id_maestro`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `maestros_datos`
--

INSERT INTO `maestros_datos` (`id_datos`, `id_maestro`, `fecha_nacimiento`, `estado_civil`, `telefono`, `correo`, `calle`, `colonia`, `municipio`, `estado`) VALUES
(1, 1, '1993-10-10', 'Soltero', '4811430563', 'ap.vz@gmail.com', '', 'estacion', 'cuidad valles', 'san luis potosi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maestros_materias_grupos`
--

DROP TABLE IF EXISTS `maestros_materias_grupos`;
CREATE TABLE IF NOT EXISTS `maestros_materias_grupos` (
  `id_maestro` int NOT NULL,
  `id_materia` int NOT NULL,
  `id_grupo` int NOT NULL,
  PRIMARY KEY (`id_maestro`,`id_materia`,`id_grupo`),
  KEY `id_materia` (`id_materia`),
  KEY `id_grupo` (`id_grupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `maestros_materias_grupos`
--

INSERT INTO `maestros_materias_grupos` (`id_maestro`, `id_materia`, `id_grupo`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(4, 5, 1),
(5, 6, 1),
(6, 7, 1),
(7, 8, 1),
(1, 9, 2),
(2, 10, 2),
(3, 11, 2),
(1, 12, 2),
(5, 13, 2),
(3, 14, 2),
(6, 15, 2),
(2, 16, 2),
(9, 17, 2),
(1, 18, 3),
(2, 19, 3),
(4, 20, 3),
(2, 21, 3),
(8, 22, 3),
(1, 23, 3),
(6, 24, 3),
(5, 25, 3),
(5, 26, 4),
(5, 27, 4),
(11, 28, 4),
(1, 29, 4),
(12, 30, 4),
(7, 31, 4),
(10, 32, 4),
(11, 33, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maestros_materias_perfil`
--

DROP TABLE IF EXISTS `maestros_materias_perfil`;
CREATE TABLE IF NOT EXISTS `maestros_materias_perfil` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_maestro` int NOT NULL,
  `id_materia` int NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_perfil` (`id_maestro`,`id_materia`),
  KEY `id_materia` (`id_materia`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `maestros_materias_perfil`
--

INSERT INTO `maestros_materias_perfil` (`id`, `id_maestro`, `id_materia`, `fecha_registro`) VALUES
(53, 1, 34, '2025-05-23 22:57:01'),
(54, 1, 35, '2025-05-23 22:57:01'),
(55, 1, 37, '2025-05-23 22:57:01'),
(56, 1, 42, '2025-05-23 22:57:35'),
(57, 1, 46, '2025-05-23 22:57:35'),
(58, 1, 50, '2025-05-23 22:57:35'),
(59, 1, 51, '2025-05-23 22:58:02'),
(60, 1, 52, '2025-05-23 22:58:02'),
(61, 1, 54, '2025-05-23 22:58:02'),
(62, 1, 55, '2025-05-23 22:58:02'),
(63, 1, 60, '2025-05-23 22:58:29'),
(68, 1, 1, '2025-05-25 11:37:53'),
(70, 1, 5, '2025-05-25 11:37:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

DROP TABLE IF EXISTS `materias`;
CREATE TABLE IF NOT EXISTS `materias` (
  `id_materia` int NOT NULL AUTO_INCREMENT,
  `nombre_materia` varchar(100) NOT NULL,
  PRIMARY KEY (`id_materia`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id_materia`, `nombre_materia`) VALUES
(1, 'HTML5 Y CSS'),
(2, 'ALGEBRA LINEAL'),
(3, 'ANÁLISIS Y DISEÑO DE SISTEMAS DE INFORMACIÓN I'),
(4, 'ARQUITECTURA COMPUTACIONAL'),
(5, 'PROGRAMACIÓN DE ALGORITMOS'),
(6, 'CONTABILIDAD GENERAL'),
(7, 'INGLÉS II'),
(8, 'DIVERSIDAD BIOCULTURAL'),
(9, 'PHP'),
(10, 'FINANZAS'),
(11, 'FUNDAMENTOS DE REDES'),
(12, 'ADMINISTRACIÓN DE BASE DE DATOS'),
(13, 'ECONOMÍA'),
(14, 'SISTEMAS OPERATIVOS'),
(15, 'INGLÉS IV'),
(16, 'ADMINISTRACIÓN DE RECURSOS HUMANOS'),
(17, 'ÉTICA PROFESIONAL'),
(18, 'DISEÑO GRÁFICO'),
(19, 'MERCADOTECNIA Y COMERCIO ELECTRÓNICO'),
(20, 'AUDITORÍA DE SISTEMAS DE INFORMACIÓN'),
(21, 'ADMINISTRACIÓN PARA LA CALIDAD'),
(22, 'DIVERSIDAD CULTURAL E INTERCULTURAL'),
(23, 'ROBÓTICA EDUCATIVA'),
(24, 'INGLÉS VI'),
(25, 'MÉTODOS Y TÉCNICAS DE VINCULACIÓN COMUNITARIA'),
(26, 'DESARROLLO Y GESTIÓN DE PROYECTOS INFORMÁTICOS'),
(27, 'SISTEMA DE APOYO A LA ADMINISTRACIÓN Y PLANEACIÓN'),
(28, 'SEMINARIO DE TESIS II'),
(29, 'DESARROLLO DE SITIOS WEB'),
(30, 'SEGURIDAD INFORMÁTICA'),
(31, 'DERECHO INFORMÁTICO'),
(32, 'INTRODUCCIÓN A LA INTELIGENCIA ARTIFICIAL'),
(33, 'PROYECTO COMUNITARIO'),
(34, 'INTRODUCCIÓN A LA PAQUETERÍA DE OFFICE'),
(35, 'INFORMATICA'),
(36, 'PROYECTO INTEGRADOR DE MATEMATICAS'),
(37, 'ALGORITMOS'),
(38, 'ADMINISTRACION GENERAL'),
(39, 'PENSAMIENTO CRITICO:ANALISIS Y REDACCION DE INFORMACION'),
(40, 'INGLES I'),
(41, 'DIVERSIDAD LINGÜÍSTICA EN LA REGION Y EN MEXICO'),
(42, 'JAVASCRIPT'),
(43, 'CÁLCULO DIFERENCIAL E INTEGRAL'),
(44, 'ANÁLISIS Y DISEÑO DE SISTEMAS DE INFORMACIÓN II'),
(45, 'CONTABILIDAD DE COSTOS'),
(46, 'PROGRAMACIÓN ORIENTADA A OBJETOS'),
(47, 'MATEMÁTICAS FINANCIERAS'),
(48, 'INGLÉS III'),
(49, 'IDENTIDAD CULTURAL'),
(50, 'FUNDAMENTOS DE BASE DE DATOS'),
(51, 'CMS'),
(52, 'INGENIERÍA DE SOFTWARE'),
(53, 'PROBABILIDAD Y ESTADÍSTICA'),
(54, 'GESTIÓN DE TIC'),
(55, 'ADMINISTRACIÓN DE REDES'),
(56, 'DESARROLLO ORGANIZACIONAL'),
(57, 'INGLÉS V'),
(58, 'SENSIBILIZACIÓN A LA VINCULACIÓN COMUNITARIA'),
(59, 'DESARROLLO DE APLICACIONES ORIENTADAS A EVENTOS'),
(60, 'LENGUAJE VISUAL'),
(61, 'SEMINARIO DE TESIS I'),
(62, 'INTEGRACIÓN DE SISTEMAS DE INFORMACIÓN'),
(63, 'FORMACIÓN DE EMPRENDEDORES'),
(64, 'OPTATIVA: LABORATORIO DE DESARROLLO DE APLICACIONES MULTIMEDIA Y MULTIMODALES'),
(65, 'OPTATIVA:  INGLÉS TÉCNICO PARA INFORMÁTICA'),
(66, 'DIAGNÓSTICO COMUNITARIO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias_semestre`
--

DROP TABLE IF EXISTS `materias_semestre`;
CREATE TABLE IF NOT EXISTS `materias_semestre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_semestre` int NOT NULL,
  `id_materia` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_semestre` (`id_semestre`),
  KEY `id_materia` (`id_materia`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `materias_semestre`
--

INSERT INTO `materias_semestre` (`id`, `id_semestre`, `id_materia`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 2, 9),
(10, 2, 10),
(11, 2, 11),
(12, 2, 12),
(13, 2, 13),
(14, 2, 14),
(15, 2, 15),
(16, 2, 16),
(17, 2, 17),
(18, 3, 18),
(19, 3, 19),
(20, 3, 20),
(21, 3, 21),
(22, 3, 22),
(23, 3, 23),
(24, 3, 24),
(25, 3, 25),
(26, 4, 26),
(27, 4, 27),
(28, 4, 28),
(29, 4, 29),
(30, 4, 30),
(31, 4, 31),
(32, 4, 32),
(33, 4, 33),
(34, 5, 34),
(35, 5, 35),
(36, 5, 36),
(37, 5, 37),
(38, 5, 38),
(39, 5, 39),
(40, 5, 40),
(41, 5, 41),
(42, 6, 42),
(43, 6, 43),
(44, 6, 44),
(45, 6, 45),
(46, 6, 46),
(47, 6, 47),
(48, 6, 7),
(49, 6, 49),
(50, 6, 50),
(51, 7, 51),
(52, 7, 52),
(53, 7, 53),
(54, 7, 54),
(55, 7, 55),
(56, 7, 56),
(57, 7, 57),
(58, 7, 58),
(59, 8, 59),
(60, 8, 60),
(61, 8, 61),
(62, 8, 62),
(63, 8, 63),
(64, 8, 64),
(65, 8, 65),
(66, 8, 66);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo_semestral`
--

DROP TABLE IF EXISTS `periodo_semestral`;
CREATE TABLE IF NOT EXISTS `periodo_semestral` (
  `id_periodo` int NOT NULL AUTO_INCREMENT,
  `periodo` varchar(250) NOT NULL,
  PRIMARY KEY (`id_periodo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `periodo_semestral`
--

INSERT INTO `periodo_semestral` (`id_periodo`, `periodo`) VALUES
(1, 'ENERO-JUNIO'),
(2, 'AGOSTO-DICIEMBRE');

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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `reservacion`
--

INSERT INTO `reservacion` (`id`, `nombre`, `motivo`, `fecha`, `hora`) VALUES
(1, 'Arlette Paulina Vargas zaragoza', 'Practicas PHP', '0000-00-00', '00:00:00'),
(2, 'gilberto vazquez', 'examen', '0000-00-00', '00:00:00'),
(3, 'Arlette', 'Practicas PHP', '0000-00-00', '07:00:00'),
(5, 'Alan Marín', 'Practicas', '0000-00-00', '12:00:00'),
(6, 'Arlette', 'Practicas PHP', '2025-05-20', '08:00:00'),
(13, 'ING. PAULINA', 'CLASES', '2025-05-26', '14:00:00'),
(12, 'Gilberto', 'Examen JS', '2025-05-22', '08:00:00'),
(10, 'Arlette', 'Practicas PHP', '2025-05-21', '12:00:00'),
(14, 'Paulina', 'clases', '2025-05-26', '08:40:00'),
(15, 'paulina', 'clses', '2025-05-27', '16:40:00'),
(16, 'paulona', 'clases', '2025-05-27', '17:30:00'),
(17, 'Paulina', 'Clases', '2025-05-28', '09:50:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

DROP TABLE IF EXISTS `reservas`;
CREATE TABLE IF NOT EXISTS `reservas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `id_admin` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_admin` (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `fecha`, `hora`, `descripcion`, `id_admin`) VALUES
(1, '2025-05-28', '13:38:00', 'SIN CLASES', 1),
(2, '2025-05-29', '13:46:00', 'dia del estudiante', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `semestres`
--

DROP TABLE IF EXISTS `semestres`;
CREATE TABLE IF NOT EXISTS `semestres` (
  `id_semestre` int NOT NULL AUTO_INCREMENT,
  `numero` tinyint NOT NULL,
  `id_carrera` int NOT NULL,
  `id_periodo` int NOT NULL,
  PRIMARY KEY (`id_semestre`),
  KEY `id_carrera` (`id_carrera`),
  KEY `id_periodo` (`id_periodo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `semestres`
--

INSERT INTO `semestres` (`id_semestre`, `numero`, `id_carrera`, `id_periodo`) VALUES
(1, 2, 1, 1),
(2, 4, 1, 1),
(3, 6, 1, 1),
(4, 8, 1, 1),
(5, 1, 1, 2),
(6, 3, 1, 2),
(7, 5, 1, 2),
(8, 7, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `semestres_materias_grupo`
--

DROP TABLE IF EXISTS `semestres_materias_grupo`;
CREATE TABLE IF NOT EXISTS `semestres_materias_grupo` (
  `id_semestre` int NOT NULL,
  `id_materias` int NOT NULL,
  `id_grupos` int NOT NULL,
  KEY `id_semestre` (`id_semestre`),
  KEY `id_grupos` (`id_grupos`),
  KEY `id_materias` (`id_materias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `semestres_materias_grupo`
--

INSERT INTO `semestres_materias_grupo` (`id_semestre`, `id_materias`, `id_grupos`) VALUES
(5, 34, 5),
(5, 35, 5),
(5, 36, 5),
(5, 37, 5),
(5, 38, 5),
(5, 39, 5),
(5, 40, 5),
(5, 41, 5);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`);

--
-- Filtros para la tabla `archivos_calificaciones`
--
ALTER TABLE `archivos_calificaciones`
  ADD CONSTRAINT `archivos_calificaciones_ibfk_1` FOREIGN KEY (`id_maestro`) REFERENCES `maestros` (`id_maestro`),
  ADD CONSTRAINT `archivos_calificaciones_ibfk_2` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`),
  ADD CONSTRAINT `archivos_calificaciones_ibfk_3` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`);

--
-- Filtros para la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD CONSTRAINT `calificaciones_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`),
  ADD CONSTRAINT `calificaciones_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`),
  ADD CONSTRAINT `calificaciones_ibfk_3` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`);

--
-- Filtros para la tabla `datos_alumno`
--
ALTER TABLE `datos_alumno`
  ADD CONSTRAINT `datos_alumno_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `disponibilidad_maestros`
--
ALTER TABLE `disponibilidad_maestros`
  ADD CONSTRAINT `disponibilidad_maestros_ibfk_1` FOREIGN KEY (`id_maestro`) REFERENCES `maestros` (`id_maestro`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `grupos_ibfk_1` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id_carrera`),
  ADD CONSTRAINT `grupos_ibfk_2` FOREIGN KEY (`id_semestre`) REFERENCES `semestres` (`id_semestre`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `maestros_materias_grupos`
--
ALTER TABLE `maestros_materias_grupos`
  ADD CONSTRAINT `maestros_materias_grupos_ibfk_1` FOREIGN KEY (`id_maestro`) REFERENCES `maestros` (`id_maestro`),
  ADD CONSTRAINT `maestros_materias_grupos_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`),
  ADD CONSTRAINT `maestros_materias_grupos_ibfk_3` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`);

--
-- Filtros para la tabla `maestros_materias_perfil`
--
ALTER TABLE `maestros_materias_perfil`
  ADD CONSTRAINT `maestros_materias_perfil_ibfk_1` FOREIGN KEY (`id_maestro`) REFERENCES `maestros` (`id_maestro`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `maestros_materias_perfil_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `materias_semestre`
--
ALTER TABLE `materias_semestre`
  ADD CONSTRAINT `materias_semestre_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `materias_semestre_ibfk_2` FOREIGN KEY (`id_semestre`) REFERENCES `semestres` (`id_semestre`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `administradores` (`id_admin`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `semestres`
--
ALTER TABLE `semestres`
  ADD CONSTRAINT `semestres_ibfk_1` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id_carrera`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `semestres_ibfk_2` FOREIGN KEY (`id_periodo`) REFERENCES `periodo_semestral` (`id_periodo`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `semestres_materias_grupo`
--
ALTER TABLE `semestres_materias_grupo`
  ADD CONSTRAINT `semestres_materias_grupo_ibfk_1` FOREIGN KEY (`id_semestre`) REFERENCES `semestres` (`id_semestre`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `semestres_materias_grupo_ibfk_2` FOREIGN KEY (`id_grupos`) REFERENCES `grupos` (`id_grupo`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `semestres_materias_grupo_ibfk_3` FOREIGN KEY (`id_materias`) REFERENCES `materias` (`id_materia`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
