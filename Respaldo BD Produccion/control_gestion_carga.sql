-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 28-03-2025 a las 18:22:05
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

--
-- Volcado de datos para la tabla `carga`
--

INSERT INTO `carga` (`idcarga`, `docente_iddocente`, `fecha_movimiento`, `ultimo_movimiento`, `usuario_movimiento`, `nombre_docente`, `estatus`) VALUES
(1, 1, '2023-12-19', 'Registro', '200071', 'Elizabeth García Garcés', 1),
(2, 2, '2023-12-19', 'Registro', '200071', 'Jesús Rosas Vaquero', 1),
(3, 3, '2023-12-19', 'Registro', '200071', 'Paola Mello Ariza', 1),
(4, 4, '2023-12-19', 'Registro', '200071', 'Jorge Ramírez Escobedo', 1),
(5, 5, '2023-12-19', 'Registro', '200071', 'Mariana De La Luz Meléndez', 1),
(6, 7, '2023-12-29', 'Registro', '200148', 'Julieta Santander Castillo', 1),
(7, 8, '2024-02-07', 'Registro', '200148', 'Carlos Betancourt Peralta', 1),
(8, 9, '2024-02-07', 'Registro', '200148', 'Elizabeth García Garcés', 1),
(9, 10, '2024-02-07', 'Registro', '200148', 'Martha Michaca Leano', 1),
(10, 11, '2024-02-07', 'Registro', '200148', 'Mariela Juana Alonso Calpeño', 1),
(11, 12, '2024-02-07', 'Registro', '200148', 'Yuridia Ramirez Chocolatl', 1),
(12, 13, '2024-02-08', 'Registro', '200148', 'Julieta Santander Castillo', 1),
(13, 14, '2024-02-08', 'Registro', '200148', 'Raúl Alanís Teutle', 1),
(14, 15, '2024-02-08', 'Registro', '200148', 'Miguel Angel Tobon Alvarez', 1),
(15, 16, '2024-02-08', 'Registro', '200148', 'Oscar Valerio Pastrana', 1),
(16, 17, '2024-02-09', 'Registro', '200148', 'Claudia Elena Portillo Zepeda', 1),
(17, 18, '2024-02-09', 'Registro', '200148', 'Margarita Perez Atenco', 1),
(18, 19, '2024-02-09', 'Registro', '200148', 'Johana Ramírez Hernández', 1),
(19, 20, '2024-02-09', 'Registro', '200148', 'Guadalupe Gabriela Bárcena Vicuña', 1),
(20, 21, '2024-02-13', 'Registro', '200148', 'Oscar Trujillo Acevedo', 1),
(21, 22, '2024-02-13', 'Registro', '200154', 'Jorge Ramírez Escobedo', 1),
(22, 23, '2024-02-13', 'Registro', '200148', 'Juan Maldonado Montalvo', 1),
(23, 24, '2024-02-13', 'Registro', '200148', 'Carolina Gallegos López', 1),
(24, 25, '2024-02-13', 'Registro', '200154', 'Edgar Hernández Páez', 1),
(25, 26, '2024-02-13', 'Registro', '200148', 'Madai López Silva', 1),
(26, 27, '2024-02-14', 'Registro', '200148', 'María Candelaria Poblano Gallo', 1),
(27, 28, '2024-02-14', 'Registro', '200148', 'Gema Minutti Robles', 1),
(28, 29, '2024-02-14', 'Registro', '200148', 'Noel Morales Rosales', 1),
(29, 30, '2024-02-14', 'Registro', '200154', 'Rubén Vázquez Velasco', 1),
(30, 32, '2024-02-15', 'Registro', '200148', 'Lizzeth Hernández Carnalla', 1),
(31, 33, '2024-02-15', 'Registro', '200148', 'Valdemar Tirado Cruz', 1),
(32, 31, '2024-02-15', 'Registro', '200154', 'Esperanza Rosas López', 1),
(33, 34, '2024-02-15', 'Registro', '200148', 'Leobardo Enrique Teliz Ramirez', 1),
(34, 35, '2024-02-15', 'Registro', '200148', 'Paola Mello Ariza', 1),
(35, 36, '2024-02-15', 'Registro', '200148', 'Jonathan  Enrique Cabrera Marín', 1),
(36, 37, '2024-02-15', 'Registro', '200154', 'Rigoberto Hernández Antemate', 1),
(37, 38, '2024-02-15', 'Registro', '200148', 'Eduardo Juarez Rascon', 1),
(38, 39, '2024-02-15', 'Registro', '200154', 'Ramiro Amando Gómez Puerto', 1),
(39, 40, '2024-02-16', 'Registro', '200148', 'Hector Daniel Flores Martinez', 1),
(40, 41, '2024-02-16', 'Registro', '200148', 'Adriana Rodriguez Bobadilla', 1),
(41, 42, '2024-02-16', 'Registro', '200148', 'Viridiana Martinez Rios', 1),
(42, 43, '2024-02-16', 'Registro', '200148', 'Jorge Alberto Muñoz Juarez', 1),
(43, 44, '2024-02-16', 'Registro', '200154', 'Edgar Isaí Osorio García', 1),
(44, 45, '2024-02-16', 'Registro', '200154', 'Ricardo Quintero Caballero', 1),
(45, 46, '2024-02-16', 'Registro', '200154', 'Fabiola Olvera Torres', 1),
(46, 47, '2024-02-16', 'Registro', '200148', 'Fernando Sanchez Texis', 1),
(47, 48, '2024-02-19', 'Registro', '200148', 'Abril Rubi Lezama Mayorga', 1),
(48, 49, '2024-02-19', 'Registro', '200148', 'Rosalba Isabel Ojeda Perez', 1),
(49, 50, '2024-02-19', 'Registro', '200148', 'Raul Eusebio Grande', 1),
(50, 51, '2024-02-19', 'Registro', '200148', 'Ivan Reyes Castillo', 1),
(51, 52, '2024-02-19', 'Registro', '200154', 'Mariana De La Luz Meléndez', 1),
(52, 53, '2024-02-19', 'Registro', '200148', 'Mariana Natalia Ibarra Bonilla', 1),
(53, 54, '2024-02-19', 'Registro', '200148', 'Jovanni Amaro Balanzar', 1),
(54, 55, '2024-02-19', 'Registro', '200154', 'Magdalena Torres Rosas', 1),
(55, 56, '2024-02-19', 'Registro', '200148', 'Rosario Arellano Ocotecatl', 1),
(56, 57, '2024-02-19', 'Registro', '200154', 'Marco Sánchez Cantú', 1),
(57, 58, '2024-02-19', 'Registro', '200148', 'Fredi Dominguez Cuellar', 1),
(58, 59, '2024-02-19', 'Registro', '200148', 'José Reyes Rosales', 1),
(59, 60, '2024-02-19', 'Registro', '200154', 'Carlos Alberto Gonzalez Jimenez', 1),
(60, 61, '2024-02-20', 'Registro', '200154', 'Ivonne Perez Vazquez', 1),
(61, 62, '2024-02-20', 'Registro', '200154', 'Maria De Los Angeles Balderas Cid', 1),
(62, 63, '2024-02-20', 'Registro', '200148', 'Mario Jair Martinez Navarro', 1),
(63, 64, '2024-02-20', 'Registro', '200148', 'Anselmo Charros Tlapalcoyoa', 1),
(64, 65, '2024-02-20', 'Registro', '200154', 'Lorena Martinez Zacatenco', 1),
(65, 66, '2024-02-20', 'Registro', '200148', 'Dalila Sanchez Texis', 1),
(66, 67, '2024-02-20', 'Registro', '200154', 'Edith Dalile Aguilar Rojano', 1),
(67, 68, '2024-02-20', 'Registro', '200148', 'Juan Sabino Martinez Romero', 1),
(68, 69, '2024-02-20', 'Registro', '200148', 'Enrique Estrada Zecua', 1),
(69, 70, '2024-10-04', 'Registro', '200071', 'Miguel Arturo Guerrero Teolotitla', 1),
(70, 71, '2024-10-16', 'Registro', '200148', 'Juan Carlos Garate Norato', 1),
(71, 72, '2024-10-16', 'Registro', '200148', 'Amado Merced Andrade Galicia', 1),
(72, 73, '2025-02-12', 'Registro', '200148', 'Ricardo Pérez Solís', 1),
(73, 74, '2025-02-12', 'Registro', '200148', 'Sergio Enrique Hoyos González', 1),
(74, 75, '2025-02-12', 'Registro', '200148', 'Marco Fabio Rojas Lopez', 1),
(75, 76, '2025-02-13', 'Registro', '200148', 'Daniel Alejandro Ollivier Moreno', 1),
(76, 77, '2025-02-13', 'Registro', '200148', 'Edgar Muñoz López', 1),
(77, 78, '2025-02-13', 'Registro', '200148', 'Sergio Lezama Rojas', 1),
(78, 79, '2025-02-13', 'Registro', '200148', 'Edgar Cabrales Garcia', 1),
(79, 80, '2025-02-14', 'Registro', '200148', 'Viridiana Zamorano Tamayo', 1),
(80, 81, '2025-02-18', 'Registro', '200148', 'Armando Zamorano Tamayo', 1),
(81, 82, '2025-03-19', 'Registro', '200148', 'Ana Paulina Zeleny Cuevas', 1),
(82, 83, '2025-03-19', 'Registro', '200148', 'Juan Carlos Guevara Contreras', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
