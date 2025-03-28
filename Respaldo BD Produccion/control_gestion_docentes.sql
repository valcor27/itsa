-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 28-03-2025 a las 18:18:06
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
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`id_docentes`, `empleados_expediente`, `clave`, `nombre_docente`, `estatus`, `fecha_movimiento`, `ultimo_movimiento`, `usuario_movimiento`) VALUES
(1, '100006', '5099', 'Elizabeth García Garcés', 0, '2024-02-07', 'Eliminar', '200148'),
(2, '100118', '5303', 'Jesús Rosas Vaquero', 0, '2024-02-07', 'Eliminar', '200148'),
(3, '100074', '5262', 'Paola Mello Ariza', 0, '2024-02-07', 'Eliminar', '200148'),
(4, '100038', '5194', 'Jorge Ramírez Escobedo', 0, '2024-02-07', 'Eliminar', '200148'),
(5, '100100', '5282', 'Mariana De La Luz Meléndez', 0, '2024-02-07', 'Eliminar', '200148'),
(6, '100030', '1', 'Julieta Santander Castillo', 0, '2023-12-19', 'Eliminar', '200071'),
(7, '100030', '1234', 'Julieta Santander Castillo', 0, '2024-02-07', 'Eliminar', '200148'),
(8, '100025', '5115', 'Carlos Betancourt Peralta', 1, '2024-02-07', 'Registro', '200148'),
(9, '100006', '5099', 'Elizabeth García Garcés', 1, '2024-02-07', 'Registro', '200148'),
(10, '100040', '2021', 'Martha Michaca Leano', 1, '2024-02-07', 'Registro', '200148'),
(11, '100032', '5020', 'Mariela Juana Alonso Calpeño', 1, '2024-02-07', 'Registro', '200148'),
(12, '100007', '5107', 'Yuridia Ramirez Chocolatl', 1, '2024-02-07', 'Registro', '200148'),
(13, '100030', '5009', 'Julieta Santander Castillo', 1, '2024-02-07', 'Registro', '200148'),
(14, '100020', '5171', 'Raúl Alanís Teutle', 1, '2024-02-07', 'Registro', '200148'),
(15, '100062', '5158', 'Miguel Angel Tobon Alvarez', 1, '2024-02-07', 'Registro', '200148'),
(16, '100046', '5224', 'Oscar Valerio Pastrana', 1, '2024-02-07', 'Registro', '200148'),
(17, '100003', '5074', 'Claudia Elena Portillo Zepeda', 1, '2024-02-07', 'Registro', '200148'),
(18, '100053', '5106', 'Margarita Perez Atenco', 1, '2024-02-07', 'Registro', '200148'),
(19, '100057', '5236', 'Johana Ramírez Hernández', 1, '2024-02-09', 'Registro', '200148'),
(20, '100022', '5165', 'Guadalupe Gabriela Bárcena Vicuña', 1, '2024-02-09', 'Registro', '200148'),
(21, '100019', '2026', 'Oscar Trujillo Acevedo', 1, '2024-02-13', 'Registro', '200148'),
(22, '100038', '5194', 'Jorge Ramírez Escobedo', 1, '2024-02-13', 'Registro', '200154'),
(23, '100122', '5302', 'Juan Maldonado Montalvo', 1, '2024-02-13', 'Registro', '200148'),
(24, '200100', '5305', 'Carolina Gallegos López', 1, '2024-02-13', 'Registro', '200148'),
(25, '100013', '5133', 'Edgar Hernández Páez', 1, '2024-02-13', 'Registro', '200154'),
(26, '100147', '5327', 'Madai López Silva', 1, '2024-02-13', 'Registro', '200148'),
(27, '100063', '5032', 'María Candelaria Poblano Gallo', 1, '2024-02-14', 'Registro', '200148'),
(28, '100051', '5229', 'Gema Minutti Robles', 1, '2024-02-14', 'Registro', '200148'),
(29, '100041', '5208', 'Noel Morales Rosales', 1, '2024-02-14', 'Registro', '200148'),
(30, '100076', '2002', 'Rubén Vázquez Velasco', 1, '2024-02-14', 'Registro', '200154'),
(31, '100001', '2011', 'Esperanza Rosas López', 1, '2024-02-14', 'Registro', '200154'),
(32, '100061', '5239', 'Lizzeth Hernández Carnalla', 1, '2024-02-15', 'Registro', '200148'),
(33, '100102', '5281', 'Valdemar Tirado Cruz', 1, '2024-02-15', 'Registro', '200148'),
(34, '100069', '5257', 'Leobardo Enrique Teliz Ramirez', 1, '2024-02-15', 'Registro', '200148'),
(35, '100074', '5262', 'Paola Mello Ariza', 1, '2024-02-15', 'Registro', '200148'),
(36, '200063', '5298', 'Jonathan  Enrique Cabrera Marín', 1, '2024-02-15', 'Registro', '200148'),
(37, '100043', '5220', 'Rigoberto Hernández Antemate', 1, '2024-02-15', 'Registro', '200154'),
(38, '100139', '5318', 'Eduardo Juarez Rascon', 1, '2024-02-15', 'Registro', '200148'),
(39, '100091', '5274', 'Ramiro Amando Gómez Puerto', 1, '2024-02-15', 'Registro', '200154'),
(40, '100081', '5271', 'Hector Daniel Flores Martinez', 1, '2024-02-16', 'Registro', '200148'),
(41, '100064', '5241', 'Adriana Rodriguez Bobadilla', 1, '2024-02-16', 'Registro', '200148'),
(42, '100049', '3020', 'Viridiana Martinez Rios', 1, '2024-02-16', 'Registro', '200148'),
(43, '100089', '5272', 'Jorge Alberto Muñoz Juarez', 1, '2024-02-16', 'Registro', '200148'),
(44, '100124', '5311', 'Edgar Isaí Osorio García', 1, '2024-02-16', 'Registro', '200154'),
(45, '100005', '2034', 'Ricardo Quintero Caballero', 0, '2025-02-12', 'Eliminar', '200148'),
(46, '100042', '5214', 'Fabiola Olvera Torres', 1, '2024-02-16', 'Registro', '200154'),
(47, '100009', '5138', 'Fernando Sanchez Texis', 1, '2024-02-16', 'Registro', '200148'),
(48, '100136', '5320', 'Abril Rubi Lezama Mayorga', 1, '2024-02-19', 'Registro', '200148'),
(49, '100014', '5072', 'Rosalba Isabel Ojeda Perez', 1, '2024-02-19', 'Registro', '200148'),
(50, '100071', '5255', 'Raul Eusebio Grande', 1, '2024-02-19', 'Registro', '200148'),
(51, '100035', '5221', 'Ivan Reyes Castillo', 1, '2024-02-19', 'Registro', '200148'),
(52, '100100', '5282', 'Mariana De La Luz Meléndez', 1, '2024-02-19', 'Registro', '200154'),
(53, '100021', '5167', 'Mariana Natalia Ibarra Bonilla', 1, '2024-02-19', 'Registro', '200148'),
(54, '100080', '5267', 'Jovanni Amaro Balanzar', 1, '2024-02-19', 'Registro', '200148'),
(55, '100084', '5182', 'Magdalena Torres Rosas', 1, '2024-02-19', 'Registro', '200154'),
(56, '100070', '5254', 'Rosario Arellano Ocotecatl', 1, '2024-02-19', 'Registro', '200148'),
(57, '100002', '5022', 'Marco Sánchez Cantú', 1, '2024-02-19', 'Registro', '200154'),
(58, '100037', '5193', 'Fredi Dominguez Cuellar', 1, '2024-02-19', 'Registro', '200148'),
(59, '100044', '5201', 'José Reyes Rosales', 1, '2024-02-19', 'Registro', '200148'),
(60, '100121', '5297', 'Carlos Alberto Gonzalez Jimenez', 1, '2024-02-19', 'Registro', '200154'),
(61, '200113', '5310', 'Ivonne Perez Vazquez', 1, '2024-02-20', 'Registro', '200154'),
(62, '100024', '5014', 'Maria De Los Angeles Balderas Cid', 1, '2024-02-20', 'Registro', '200154'),
(63, '100085', '5269', 'Mario Jair Martinez Navarro', 1, '2024-02-20', 'Registro', '200148'),
(64, '100004', '4003', 'Anselmo Charros Tlapalcoyoa', 1, '2024-02-20', 'Registro', '200148'),
(65, '100120', '5299', 'Lorena Martinez Zacatenco', 1, '2024-02-20', 'Registro', '200154'),
(66, '100016', '5046', 'Dalila Sanchez Texis', 1, '2024-02-20', 'Registro', '200148'),
(67, '100067', '5253', 'Edith Dalile Aguilar Rojano', 1, '2024-02-20', 'Registro', '200154'),
(68, '100093', '5278', 'Juan Sabino Martinez Romero', 1, '2024-02-20', 'Registro', '200148'),
(69, '100026', '5180', 'Enrique Estrada Zecua', 1, '2024-02-20', 'Registro', '200148'),
(70, '100162', '9876', 'Miguel Arturo Guerrero Teolotitla', 1, '2024-10-04', 'Registro', '200071'),
(71, '200077', '0001', 'Juan Carlos Garate Norato', 1, '2024-10-16', 'Registro', '200148'),
(72, '100083', '0002', 'Amado Merced Andrade Galicia', 1, '2024-10-16', 'Registro', '200148'),
(73, '100015', '5244', 'Ricardo Pérez Solís', 1, '2025-02-12', 'Registro', '200148'),
(74, '200124', '5326', 'Sergio Enrique Hoyos González', 1, '2025-02-12', 'Registro', '200148'),
(75, '100023', '9991', 'Marco Fabio Rojas Lopez', 1, '2025-02-12', 'Registro', '200148'),
(76, '100079', '9992', 'Daniel Alejandro Ollivier Moreno', 1, '2025-02-13', 'Registro', '200148'),
(77, '100056', '9993', 'Edgar Muñoz López', 1, '2025-02-13', 'Registro', '200148'),
(78, '100143', '9994', 'Sergio Lezama Rojas', 1, '2025-02-13', 'Registro', '200148'),
(79, '100047', '9995', 'Edgar Cabrales Garcia', 1, '2025-02-13', 'Registro', '200148'),
(80, '200064', '5322', 'Viridiana Zamorano Tamayo', 1, '2025-02-14', 'Registro', '200148'),
(81, '100090', '5277', 'Armando Zamorano Tamayo', 1, '2025-02-18', 'Registro', '200148'),
(82, '100164', '5333', 'Ana Paulina Zeleny Cuevas', 1, '2025-03-19', 'Registro', '200148'),
(83, '100173', '5259', 'Juan Carlos Guevara Contreras', 1, '2025-03-19', 'Registro', '200148');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
