-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-02-2020 a las 10:29:30
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `comprasweb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE IF NOT EXISTS `almacen` (
  `NUM_ALMACEN` int(11) NOT NULL DEFAULT '0',
  `LOCALIDAD` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`NUM_ALMACEN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`NUM_ALMACEN`, `LOCALIDAD`) VALUES
(10, 'MADRID'),
(20, 'BARCELONA'),
(30, 'MURCIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacena`
--

CREATE TABLE IF NOT EXISTS `almacena` (
  `NUM_ALMACEN` int(11) NOT NULL DEFAULT '0',
  `ID_PRODUCTO` varchar(5) NOT NULL DEFAULT '',
  `CANTIDAD` int(11) DEFAULT NULL,
  PRIMARY KEY (`NUM_ALMACEN`,`ID_PRODUCTO`),
  KEY `FK_ALM_PRO` (`ID_PRODUCTO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `almacena`
--

INSERT INTO `almacena` (`NUM_ALMACEN`, `ID_PRODUCTO`, `CANTIDAD`) VALUES
(10, 'P001', 2),
(10, 'P002', 9),
(20, 'P001', 1),
(30, 'P001', 99),
(30, 'P002', 103);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `ID_CATEGORIA` varchar(5) NOT NULL DEFAULT '',
  `NOMBRE` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`ID_CATEGORIA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`ID_CATEGORIA`, `NOMBRE`) VALUES
('C001', 'Mesas'),
('C002', 'Armarios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `NIF` varchar(9) NOT NULL DEFAULT '',
  `NOMBRE` varchar(40) DEFAULT NULL,
  `APELLIDO` varchar(40) DEFAULT NULL,
  `USUARIO` varchar(40) NOT NULL,
  `PASSWORD` varchar(40) NOT NULL,
  `CP` varchar(5) DEFAULT NULL,
  `DIRECCION` varchar(40) DEFAULT NULL,
  `CIUDAD` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`NIF`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`NIF`, `NOMBRE`, `APELLIDO`, `USUARIO`, `PASSWORD`, `CP`, `DIRECCION`, `CIUDAD`) VALUES
('10000000S', 'Ana', 'Lopez', 'ana', 'zepol', '28011', 'Calle Leo', 'Madrid'),
('22222222D', 'A', 'A', 'a', 'a', '28011', 'Calle Oso', 'Madrid'),
('50634314K', 'Gonzalo', 'Ruiz', 'gonzalo', 'ziur', '28044', 'Calle Pez', 'Madrid'),
('76700991P', 'David', 'Perez', 'david', 'zerep', '28041', 'Calle Gato', 'Madrid');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE IF NOT EXISTS `compra` (
  `NIF` varchar(9) NOT NULL DEFAULT '',
  `ID_PRODUCTO` varchar(5) NOT NULL DEFAULT '',
  `FECHA_COMPRA` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `UNIDADES` int(11) DEFAULT NULL,
  PRIMARY KEY (`NIF`,`ID_PRODUCTO`,`FECHA_COMPRA`),
  KEY `FK_COM_PRO` (`ID_PRODUCTO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`NIF`, `ID_PRODUCTO`, `FECHA_COMPRA`, `UNIDADES`) VALUES
('10000000S', 'P001', '2020-01-31 12:02:07', 1),
('10000000S', 'P001', '2020-01-31 12:06:01', 1),
('22222222D', 'P001', '2020-01-31 12:19:06', 1),
('22222222D', 'P001', '2020-01-31 13:14:14', 2),
('22222222D', 'P001', '2020-01-31 13:17:14', 4),
('22222222D', 'P001', '2020-01-31 13:17:57', 1),
('22222222D', 'P001', '2020-01-31 13:18:44', 1),
('22222222D', 'P002', '2020-01-31 13:17:14', 2),
('22222222D', 'P002', '2020-01-31 13:17:38', 40),
('50634314K', 'P001', '2020-01-28 10:20:31', 10),
('50634314K', 'P001', '2020-01-31 13:41:29', 2),
('50634314K', 'P001', '2020-01-31 13:45:04', 1),
('50634314K', 'P001', '2020-01-31 13:46:31', 2),
('50634314K', 'P001', '2020-01-31 13:46:52', 2),
('50634314K', 'P001', '2020-01-31 13:47:06', 3),
('50634314K', 'P001', '2020-01-31 13:57:38', 1),
('50634314K', 'P001', '2020-01-31 13:58:51', 1),
('50634314K', 'P001', '2020-01-31 14:00:05', 2),
('50634314K', 'P001', '2020-01-31 14:00:06', 1),
('50634314K', 'P001', '2020-01-31 14:03:39', 1),
('50634314K', 'P001', '2020-01-31 14:08:12', 1),
('50634314K', 'P001', '2020-01-31 14:08:15', 2),
('50634314K', 'P002', '2020-01-31 13:47:06', 4),
('50634314K', 'P002', '2020-01-31 14:03:39', 2),
('50634314K', 'P002', '2020-01-31 14:04:07', 1),
('50634314K', 'P002', '2020-01-31 14:05:40', 1),
('50634314K', 'P002', '2020-01-31 14:06:59', 1),
('50634314K', 'P002', '2020-01-31 14:07:29', 2),
('76700991P', 'P001', '2020-01-28 10:19:54', 5),
('76700991P', 'P001', '2020-01-28 10:20:13', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE IF NOT EXISTS `producto` (
  `ID_PRODUCTO` varchar(5) NOT NULL DEFAULT '',
  `NOMBRE` varchar(40) DEFAULT NULL,
  `PRECIO` double DEFAULT NULL,
  `ID_CATEGORIA` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`ID_PRODUCTO`),
  KEY `FK_PROD_CAT` (`ID_CATEGORIA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`ID_PRODUCTO`, `NOMBRE`, `PRECIO`, `ID_CATEGORIA`) VALUES
('P001', 'Armario roble', 30, 'C002'),
('P002', 'Mesa roble', 15, 'C002');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `almacena`
--
ALTER TABLE `almacena`
  ADD CONSTRAINT `FK_ALM_ALM` FOREIGN KEY (`NUM_ALMACEN`) REFERENCES `almacen` (`NUM_ALMACEN`),
  ADD CONSTRAINT `FK_ALM_PRO` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `producto` (`ID_PRODUCTO`);

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `FK_COM_CLI` FOREIGN KEY (`NIF`) REFERENCES `cliente` (`NIF`),
  ADD CONSTRAINT `FK_COM_PRO` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `producto` (`ID_PRODUCTO`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FK_PROD_CAT` FOREIGN KEY (`ID_CATEGORIA`) REFERENCES `categoria` (`ID_CATEGORIA`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
