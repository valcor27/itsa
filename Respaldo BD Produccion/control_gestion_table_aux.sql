-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 28-03-2025 a las 18:44:44
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `control_gestion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aux`
--

DROP TABLE IF EXISTS `aux`;
CREATE TABLE IF NOT EXISTS `aux` (
  `idaux` int UNSIGNED NOT NULL,
  `carga_aux` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `dia_aux` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `hora_entrada_aux` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `punto_aux` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `etiqueta_aux` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `columna_aux` varchar(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus_aux` int DEFAULT NULL,
  KEY `idx_aux_hora_punto` (`hora_entrada_aux`,`punto_aux`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `aux`
--

INSERT INTO `aux` (`idaux`, `carga_aux`, `dia_aux`, `hora_entrada_aux`, `punto_aux`, `etiqueta_aux`, `columna_aux`, `estatus_aux`) VALUES
(1, '0', 'lunes', '07:00', 'lu_f1_c1', '', '1', 0),
(2, '0', 'martes', '07:00', 'ma_f1_c2', '', '2', 0),
(3, '0', 'miercoles', '07:00', 'mi_f1_c3', '', '3', 0),
(4, '0', 'jueves', '07:00', 'ju_f1_c4', '', '4', 0),
(5, '0', 'viernes', '07:00', 'vi_f1_c5', '', '5', 0),
(6, '0', 'sabado', '07:00', 'sa_f1_c6', '', '6', 0),
(7, '0', 'lunes', '08:00', 'lu_f2_c1', '', '1', 0),
(8, '0', 'martes', '08:00', 'ma_f2_c2', '', '2', 0),
(9, '0', 'miercoles', '08:00', 'mi_f2_c3', '', '3', 0),
(10, '0', 'jueves', '08:00', 'ju_f2_c4', '', '4', 0),
(11, '0', 'viernes', '08:00', 'vi_f2_c5', '', '5', 0),
(12, '0', 'sabado', '08:00', 'sa_f2_c6', '', '6', 0),
(13, '0', 'lunes', '09:00', 'lu_f3_c1', '', '1', 0),
(14, '0', 'martes', '09:00', 'ma_f3_c2', '', '2', 0),
(15, '0', 'miercoles', '09:00', 'mi_f3_c3', '', '3', 0),
(16, '0', 'jueves', '09:00', 'ju_f3_c4', '', '4', 0),
(17, '0', 'viernes', '09:00', 'vi_f3_c5', '', '5', 0),
(18, '0', 'sabado', '09:00', 'sa_f3_c6', '', '6', 0),
(19, '0', 'lunes', '10:00', 'lu_f4_c1', '', '1', 0),
(20, '0', 'martes', '10:00', 'ma_f4_c2', '', '2', 0),
(21, '0', 'miercoles', '10:00', 'mi_f4_c3', '', '3', 0),
(22, '0', 'jueves', '10:00', 'ju_f4_c4', '', '4', 0),
(23, '0', 'viernes', '10:00', 'vi_f4_c5', '', '5', 0),
(24, '0', 'sabado', '10:00', 'sa_f4_c6', '', '6', 0),
(25, '0', 'lunes', '11:00', 'lu_f5_c1', '', '1', 0),
(26, '0', 'martes', '11:00', 'ma_f5_c2', '', '2', 0),
(27, '0', 'miercoles', '11:00', 'mi_f5_c3', '', '3', 0),
(28, '0', 'jueves', '11:00', 'ju_f5_c4', '', '4', 0),
(29, '0', 'viernes', '11:00', 'vi_f5_c5', '', '5', 0),
(30, '0', 'sabado', '11:00', 'sa_f5_c6', '', '6', 0),
(31, '0', 'lunes', '12:00', 'lu_f6_c1', '', '1', 0),
(32, '0', 'martes', '12:00', 'ma_f6_c2', '', '2', 0),
(33, '0', 'miercoles', '12:00', 'mi_f6_c3', '', '3', 0),
(34, '0', 'jueves', '12:00', 'ju_f6_c4', '', '4', 0),
(35, '0', 'viernes', '12:00', 'vi_f6_c5', '', '5', 0),
(36, '0', 'sabado', '12:00', 'sa_f6_c6', '', '6', 0),
(37, '0', 'lunes', '13:00', 'lu_f7_c1', '', '1', 0),
(38, '0', 'martes', '13:00', 'ma_f7_c2', '', '2', 0),
(39, '0', 'miercoles', '13:00', 'mi_f7_c3', '', '3', 0),
(40, '0', 'jueves', '13:00', 'ju_f7_c4', '', '4', 0),
(41, '0', 'viernes', '13:00', 'vi_f7_c5', '', '5', 0),
(42, '0', 'sabado', '13:00', 'sa_f7_c6', '', '6', 0),
(43, '0', 'lunes', '14:00', 'lu_f8_c1', '', '1', 0),
(44, '0', 'martes', '14:00', 'ma_f8_c2', '', '2', 0),
(45, '0', 'miercoles', '14:00', 'mi_f8_c3', '', '3', 0),
(46, '0', 'jueves', '14:00', 'ju_f8_c4', '', '4', 0),
(47, '0', 'viernes', '14:00', 'vi_f8_c5', '', '5', 0),
(48, '0', 'sabado', '14:00', 'sa_f8_c6', '', '6', 0),
(49, '0', 'lunes', '15:00', 'lu_f9_c1', '', '1', 0),
(50, '0', 'martes', '15:00', 'ma_f9_c2', '', '2', 0),
(51, '0', 'miercoles', '15:00', 'mi_f9_c3', '', '3', 0),
(52, '0', 'jueves', '15:00', 'ju_f9_c4', '', '4', 0),
(53, '0', 'viernes', '15:00', 'vi_f9_c5', '', '5', 0),
(54, '0', 'sabado', '15:00', 'sa_f9_c6', '', '6', 0),
(55, '0', 'lunes', '16:00', 'lu_f10_c1', '', '1', 0),
(56, '0', 'martes', '16:00', 'ma_f10_c2', '', '2', 0),
(57, '0', 'miercoles', '16:00', 'mi_f10_c3', '', '3', 0),
(58, '0', 'jueves', '16:00', 'ju_f10_c4', '', '4', 0),
(59, '0', 'viernes', '16:00', 'vi_f10_c5', '', '5', 0),
(60, '0', 'sabado', '16:00', 'sa_f10_c6', '', '6', 0),
(61, '0', 'lunes', '17:00', 'lu_f11_c1', '', '1', 0),
(62, '0', 'martes', '17:00', 'ma_f11_c2', '', '2', 0),
(63, '0', 'miercoles', '17:00', 'mi_f11_c3', '', '3', 0),
(64, '0', 'jueves', '17:00', 'ju_f11_c4', '', '4', 0),
(65, '0', 'viernes', '17:00', 'vi_f11_c5', '', '5', 0),
(66, '0', 'sabado', '17:00', 'sa_f11_c6', '', '6', 0),
(67, '0', 'lunes', '18:00', 'lu_f12_c1', '', '1', 0),
(68, '0', 'martes', '18:00', 'ma_f12_c2', '', '2', 0),
(69, '0', 'miercoles', '18:00', 'mi_f12_c3', '', '3', 0),
(70, '0', 'jueves', '18:00', 'ju_f12_c4', '', '4', 0),
(71, '0', 'viernes', '18:00', 'vi_f12_c5', '', '5', 0),
(72, '0', 'sabado', '18:00', 'sa_f12_c6', '', '6', 0),
(73, '0', 'lunes', '19:00', 'lu_f13_c1', '', '1', 0),
(74, '0', 'martes', '19:00', 'ma_f13_c2', '', '2', 0),
(75, '0', 'miercoles', '19:00', 'mi_f13_c3', '', '3', 0),
(76, '0', 'jueves', '19:00', 'ju_f13_c4', '', '4', 0),
(77, '0', 'viernes', '19:00', 'vi_f13_c5', '', '5', 0),
(78, '0', 'sabado', '19:00', 'sa_f13_c6', '', '6', 0),
(79, '0', 'lunes', '20:00', 'lu_f14_c1', '', '1', 0),
(80, '0', 'martes', '20:00', 'ma_f14_c2', '', '2', 0),
(81, '0', 'miercoles', '20:00', 'mi_f14_c3', '', '3', 0),
(82, '0', 'jueves', '20:00', 'ju_f14_c4', '', '4', 0),
(83, '0', 'viernes', '20:00', 'vi_f14_c5', '', '5', 0),
(84, '0', 'sabado', '20:00', 'sa_f14_c6', '', '6', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
