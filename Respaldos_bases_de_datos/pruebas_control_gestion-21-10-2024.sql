-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 21-10-2024 a las 22:14:19
-- Versión del servidor: 8.2.0
-- Versión de PHP: 8.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pruebas_control_gestion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

DROP TABLE IF EXISTS `asistencia`;
CREATE TABLE IF NOT EXISTS `asistencia` (
  `id_asistencia` int NOT NULL AUTO_INCREMENT,
  `nombre_txt` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `ultimo_movimiento` varchar(15) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `usuario_movimiento` int NOT NULL,
  `estatus` int NOT NULL,
  PRIMARY KEY (`id_asistencia`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carga`
--

DROP TABLE IF EXISTS `carga`;
CREATE TABLE IF NOT EXISTS `carga` (
  `idcarga` int NOT NULL AUTO_INCREMENT,
  `docente_iddocente` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(15) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `nombre_docente` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  PRIMARY KEY (`idcarga`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chofer`
--

DROP TABLE IF EXISTS `chofer`;
CREATE TABLE IF NOT EXISTS `chofer` (
  `id_chofer` int NOT NULL AUTO_INCREMENT,
  `expediente_chofer` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `nombre_chofer` varchar(150) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `dep_ads` int NOT NULL,
  `nombre_dep` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(15) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_chofer`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clave_movimiento`
--

DROP TABLE IF EXISTS `clave_movimiento`;
CREATE TABLE IF NOT EXISTS `clave_movimiento` (
  `id_clave_movimiento` int NOT NULL AUTO_INCREMENT,
  `nombre_clave` varchar(60) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  PRIMARY KEY (`id_clave_movimiento`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `combustible`
--

DROP TABLE IF EXISTS `combustible`;
CREATE TABLE IF NOT EXISTS `combustible` (
  `id_combustible` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(49) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `precio` decimal(6,2) NOT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(8) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_combustible`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comision`
--

DROP TABLE IF EXISTS `comision`;
CREATE TABLE IF NOT EXISTS `comision` (
  `id_comision` int NOT NULL AUTO_INCREMENT,
  `fecha_comision` date NOT NULL,
  `folio_comision` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `id_empleado` varchar(7) COLLATE latin1_spanish_ci NOT NULL,
  `nombre_empleado` varchar(150) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `id_plaza` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `n_comi` int NOT NULL,
  `lugar` varchar(25) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `finalidad` varchar(250) COLLATE latin1_spanish_ci NOT NULL,
  `f_ini` date NOT NULL,
  `f_fin` date NOT NULL,
  `h_ini` time NOT NULL,
  `h_fin` time NOT NULL,
  `duracion` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `pais` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `nombre_estado` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `nombre_municipio` varchar(70) COLLATE latin1_spanish_ci NOT NULL,
  `lugar_comision` varchar(200) COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  `ultimo_movimiento` varchar(15) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `usuario_movimiento` varchar(7) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_comision`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos_externos`
--

DROP TABLE IF EXISTS `departamentos_externos`;
CREATE TABLE IF NOT EXISTS `departamentos_externos` (
  `id_departamento_doc_alta` int NOT NULL AUTO_INCREMENT,
  `nombre_departamento_doc_alta` varchar(200) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `tipo_doc` int NOT NULL,
  `estatus` int NOT NULL,
  PRIMARY KEY (`id_departamento_doc_alta`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_asistencia`
--

DROP TABLE IF EXISTS `detalle_asistencia`;
CREATE TABLE IF NOT EXISTS `detalle_asistencia` (
  `id_detalle_asistencia` int NOT NULL AUTO_INCREMENT,
  `id_asistencia` int NOT NULL,
  `expediente_empleado` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `fecha_asistencia` date NOT NULL,
  `hora_entrada` time DEFAULT NULL,
  `hora_salida` time DEFAULT NULL,
  `estatus` int NOT NULL,
  `ultimo_movimiento` varchar(15) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `usuario_movimiento` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_detalle_asistencia`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_carga`
--

DROP TABLE IF EXISTS `detalle_carga`;
CREATE TABLE IF NOT EXISTS `detalle_carga` (
  `iddetalle_carga` int NOT NULL AUTO_INCREMENT,
  `carga_idcarga` int NOT NULL,
  `salon_idsalon` int NOT NULL,
  `grupo_idgrupo` int NOT NULL,
  `materia_idmateria` int NOT NULL,
  `clave_docente` varchar(5) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `expediente_docente` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `nombre_salon` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `nombre_grupo` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `nombre_materia` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `dia` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `hora_entrada` time NOT NULL,
  `hora_salida` time NOT NULL,
  `etiqueta` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `columna` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `punto` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`iddetalle_carga`),
  KEY `idx_detalle_carga_hora_punto_carga` (`hora_entrada`,`punto`,`carga_idcarga`),
  KEY `idx_detalle_carga_punto_carga_hora` (`punto`,`carga_idcarga`,`hora_entrada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pagos`
--

DROP TABLE IF EXISTS `detalle_pagos`;
CREATE TABLE IF NOT EXISTS `detalle_pagos` (
  `id_detalle_pago` int NOT NULL AUTO_INCREMENT,
  `pagos_id_pago` int NOT NULL,
  `unidad_clave_unidad` int NOT NULL,
  `monto_detalle_pago` decimal(12,2) NOT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(15) COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_detalle_pago`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dia_inhabil`
--

DROP TABLE IF EXISTS `dia_inhabil`;
CREATE TABLE IF NOT EXISTS `dia_inhabil` (
  `id_dia_inhabil` int NOT NULL AUTO_INCREMENT,
  `fecha_dia_inhabil` date NOT NULL,
  `concepto` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(15) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_dia_inhabil`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `division`
--

DROP TABLE IF EXISTS `division`;
CREATE TABLE IF NOT EXISTS `division` (
  `id_division` int NOT NULL AUTO_INCREMENT,
  `nombre_division` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  PRIMARY KEY (`id_division`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

DROP TABLE IF EXISTS `docentes`;
CREATE TABLE IF NOT EXISTS `docentes` (
  `id_docentes` int NOT NULL AUTO_INCREMENT,
  `empleados_expediente` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `clave` varchar(5) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `nombre_docente` varchar(150) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(15) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_docentes`),
  KEY `expediente` (`empleados_expediente`),
  KEY `usuario_movimiento` (`usuario_movimiento`),
  KEY `idx_nombre_docente` (`nombre_docente`),
  KEY `idx_empleados_expediente` (`empleados_expediente`),
  KEY `idx_clave` (`clave`),
  KEY `idx_estatus` (`estatus`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente_nivel_estudio`
--

DROP TABLE IF EXISTS `docente_nivel_estudio`;
CREATE TABLE IF NOT EXISTS `docente_nivel_estudio` (
  `id_docente_nivel_estudio` int NOT NULL AUTO_INCREMENT,
  `docentes_id_docentes` int NOT NULL,
  `nivel_estudio_id_nivel_estudio` int NOT NULL,
  `titulo` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `cedula` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `escuela` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_docente_nivel_estudio`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

DROP TABLE IF EXISTS `documentos`;
CREATE TABLE IF NOT EXISTS `documentos` (
  `id_documento` int NOT NULL AUTO_INCREMENT,
  `folio` varchar(30) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `dep_origen` int NOT NULL,
  `fecha_creacion` date NOT NULL,
  `tipo_doc` int NOT NULL,
  `ff` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `partida_cd` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `partida_fed` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `partida_est` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `partida_ip` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `partida_pa` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `asunto` varchar(150) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `observacion` varchar(150) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `nombre_documento` varchar(90) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(15) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_documento`),
  KEY `idx_folio` (`folio`),
  KEY `idx_asunto` (`asunto`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `domicilio`
--

DROP TABLE IF EXISTS `domicilio`;
CREATE TABLE IF NOT EXISTS `domicilio` (
  `idDomicilio` int NOT NULL AUTO_INCREMENT,
  `calle` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `n_Ext` varchar(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `nInt` varchar(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `colonia` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `cp` int NOT NULL,
  `localidad` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `municipio_idMunicipio` int NOT NULL,
  `municipio_nombreMunicipio` varchar(70) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estado_idEstado` int NOT NULL,
  `estado_nombreEstado` varchar(30) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `empleado_expediente` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(15) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`idDomicilio`),
  KEY `expediente` (`empleado_expediente`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `edificio`
--

DROP TABLE IF EXISTS `edificio`;
CREATE TABLE IF NOT EXISTS `edificio` (
  `id_edificio` int NOT NULL AUTO_INCREMENT,
  `nombre_edificio` varchar(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(15) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_edificio`),
  KEY `expediente.empleados` (`usuario_movimiento`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

DROP TABLE IF EXISTS `empleados`;
CREATE TABLE IF NOT EXISTS `empleados` (
  `expediente` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `primerApellido` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `segundoApellido` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `nombres` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `sexo` char(2) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `fNaci` date NOT NULL,
  `rfc` varchar(14) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `curp` varchar(19) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `contrasena` varchar(30) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `celular` varchar(11) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `mailP` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `mailI` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `fAlta` date NOT NULL,
  `nivel_idNivelUsuario` int NOT NULL,
  `plaza_codigoPlaza` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `plaza_nombrePlaza` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estructuraReportada` int NOT NULL,
  `reportada_nombreUnidad` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estructuraReal` int NOT NULL,
  `real_nombreUnidad` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `domicilio_idDomicilio` int NOT NULL,
  `hora_entrada` time DEFAULT NULL,
  `hora_salida` time DEFAULT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(15) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`expediente`),
  KEY `idx_primer_apellido` (`primerApellido`),
  KEY `idx_segundo_apellido` (`segundoApellido`),
  KEY `idx_nombres` (`nombres`),
  KEY `idx_expediente` (`expediente`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

DROP TABLE IF EXISTS `estado`;
CREATE TABLE IF NOT EXISTS `estado` (
  `idEstado` int NOT NULL,
  `nombreEstado` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estructuraorganica`
--

DROP TABLE IF EXISTS `estructuraorganica`;
CREATE TABLE IF NOT EXISTS `estructuraorganica` (
  `claveUnidad` int NOT NULL,
  `nombreUnidad` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  PRIMARY KEY (`claveUnidad`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

DROP TABLE IF EXISTS `grupo`;
CREATE TABLE IF NOT EXISTS `grupo` (
  `id_grupo` int NOT NULL AUTO_INCREMENT,
  `division_id_division` int NOT NULL,
  `nombre_grupo` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `nombre_division` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(15) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_grupo`),
  KEY `id_division` (`division_id_division`),
  KEY `expediente` (`usuario_movimiento`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_movimientos`
--

DROP TABLE IF EXISTS `historial_movimientos`;
CREATE TABLE IF NOT EXISTS `historial_movimientos` (
  `id_historial` int NOT NULL AUTO_INCREMENT,
  `documento_id_documento` int NOT NULL,
  `departamento_anterior` int DEFAULT NULL,
  `departamento_actual` int NOT NULL,
  `fecha` date NOT NULL,
  `estatus_documento` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(15) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_historial`),
  KEY `id_documento` (`documento_id_documento`),
  KEY `idx_id_historial` (`id_historial`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_parque_comision`
--

DROP TABLE IF EXISTS `historial_parque_comision`;
CREATE TABLE IF NOT EXISTS `historial_parque_comision` (
  `id_historial_parque_comision` int NOT NULL AUTO_INCREMENT,
  `comisiones_id_comisiones` varchar(500) COLLATE latin1_spanish_ci NOT NULL,
  `vehiculo_id_vehiculo` int NOT NULL,
  `km_inicial` decimal(15,2) NOT NULL,
  `km_final` decimal(15,2) NOT NULL,
  `km_recorridos` decimal(15,2) NOT NULL,
  `viatico_casetas` decimal(10,2) NOT NULL,
  `viatico_combustible` decimal(10,2) NOT NULL,
  `id_combustible` int NOT NULL,
  `nombre_combustible` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `precio_combustible` decimal(10,2) NOT NULL,
  `departamento_id_departamento` varchar(500) COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(15) COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(8) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_historial_parque_comision`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencia`
--

DROP TABLE IF EXISTS `incidencia`;
CREATE TABLE IF NOT EXISTS `incidencia` (
  `id_incidencia` int NOT NULL AUTO_INCREMENT,
  `hora_incidencia` time NOT NULL,
  `folio_incidencia` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `expediente` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `nombre_empleado` varchar(150) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `fecha_elaboracion` date NOT NULL,
  `id_clave_mov` int NOT NULL,
  `observacion` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_incidencia`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencia`
--

DROP TABLE IF EXISTS `licencia`;
CREATE TABLE IF NOT EXISTS `licencia` (
  `id_licencia` int NOT NULL AUTO_INCREMENT,
  `hora_l` time NOT NULL,
  `folio_l` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `expediente_l` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `nombre_empleado_l` varchar(150) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `fecha_inicio_l` date NOT NULL,
  `fecha_fin_l` date NOT NULL,
  `fecha_elaboracion_l` date NOT NULL,
  `concepto` varchar(150) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_licencia`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia`
--

DROP TABLE IF EXISTS `materia`;
CREATE TABLE IF NOT EXISTS `materia` (
  `id_materia` int NOT NULL AUTO_INCREMENT,
  `division_id_division` int NOT NULL,
  `nombre_materia` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `nombre_division` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(15) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_materia`),
  KEY `id_division` (`division_id_division`),
  KEY `expediente` (`usuario_movimiento`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipio`
--

DROP TABLE IF EXISTS `municipio`;
CREATE TABLE IF NOT EXISTS `municipio` (
  `idMunicipio` int NOT NULL,
  `nombreMunicipio` varchar(70) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estado_idEstado` int NOT NULL,
  `estatus` int NOT NULL,
  PRIMARY KEY (`idMunicipio`),
  KEY `idEstado` (`estado_idEstado`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivelusuario`
--

DROP TABLE IF EXISTS `nivelusuario`;
CREATE TABLE IF NOT EXISTS `nivelusuario` (
  `idNivelUsuario` int NOT NULL AUTO_INCREMENT,
  `nombreNivelUsuario` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  PRIMARY KEY (`idNivelUsuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel_estudio`
--

DROP TABLE IF EXISTS `nivel_estudio`;
CREATE TABLE IF NOT EXISTS `nivel_estudio` (
  `id_nivel_estudio` int NOT NULL AUTO_INCREMENT,
  `nombre_nivel_estudio` varchar(30) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  PRIMARY KEY (`id_nivel_estudio`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

DROP TABLE IF EXISTS `pagos`;
CREATE TABLE IF NOT EXISTS `pagos` (
  `id_pago` int NOT NULL AUTO_INCREMENT,
  `poliza` varchar(7) COLLATE latin1_spanish_ci NOT NULL,
  `partida` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
  `capitulo` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_pago` date NOT NULL,
  `folio_fiscal` varchar(40) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `concepto` tinytext COLLATE latin1_spanish_ci NOT NULL,
  `monto_total` decimal(12,2) NOT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(15) COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_pago`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parque_comision`
--

DROP TABLE IF EXISTS `parque_comision`;
CREATE TABLE IF NOT EXISTS `parque_comision` (
  `id_parque_comision` int NOT NULL AUTO_INCREMENT,
  `comision_id_comision` int NOT NULL,
  `tipo_vehiculo` int NOT NULL,
  `especificar` varchar(150) COLLATE latin1_spanish_ci DEFAULT NULL,
  `vehiculo_id_vehiculo` int DEFAULT NULL,
  `km_inicial` decimal(10,2) DEFAULT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(15) COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(8) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_parque_comision`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plaza`
--

DROP TABLE IF EXISTS `plaza`;
CREATE TABLE IF NOT EXISTS `plaza` (
  `codigoPlaza` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `nombrePlaza` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  PRIMARY KEY (`codigoPlaza`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salon`
--

DROP TABLE IF EXISTS `salon`;
CREATE TABLE IF NOT EXISTS `salon` (
  `id_salon` int NOT NULL AUTO_INCREMENT,
  `nombre_salon` varchar(99) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `edificio_id_edificio` int NOT NULL,
  `nombre_edificio` varchar(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(15) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id_salon`),
  KEY `id_edificio` (`edificio_id_edificio`) USING BTREE,
  KEY `expediente` (`usuario_movimiento`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocontrato`
--

DROP TABLE IF EXISTS `tipocontrato`;
CREATE TABLE IF NOT EXISTS `tipocontrato` (
  `idTipoContrato` int NOT NULL AUTO_INCREMENT,
  `nombreTipoContrato` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  PRIMARY KEY (`idTipoContrato`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

DROP TABLE IF EXISTS `vehiculo`;
CREATE TABLE IF NOT EXISTS `vehiculo` (
  `idvehiculo` int NOT NULL AUTO_INCREMENT,
  `placas` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `noserie` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `kminicial` varchar(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `tipo` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `cilindro` varchar(4) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `kmporlitro` varchar(5) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `modelo` varchar(5) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `color` varchar(31) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `marca` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `submarca` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(15) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` varchar(7) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`idvehiculo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viaticos_comision`
--

DROP TABLE IF EXISTS `viaticos_comision`;
CREATE TABLE IF NOT EXISTS `viaticos_comision` (
  `id_viaticos_comision` int NOT NULL AUTO_INCREMENT,
  `comision_id_comision` int NOT NULL,
  `viatico` decimal(10,2) NOT NULL,
  `combustible` decimal(10,2) NOT NULL,
  `casetas` decimal(10,2) NOT NULL,
  `otros` decimal(10,2) NOT NULL,
  `especificar` varchar(100) COLLATE latin1_spanish_ci DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `estatus` int NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `ultimo_movimiento` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `usuario_movimiento` int NOT NULL,
  PRIMARY KEY (`id_viaticos_comision`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
