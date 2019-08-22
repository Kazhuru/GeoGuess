-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 05-12-2017 a las 03:55:21
-- Versión del servidor: 5.7.19
-- Versión de PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tecweb2017`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
CREATE TABLE IF NOT EXISTS `comentarios` (
  `idRecibidor` int(11) NOT NULL,
  `Texto` varchar(200) NOT NULL,
  `Enviador` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`idRecibidor`, `Texto`, `Enviador`) VALUES
(28, 'jaja Hiciste trampa', 'Kazh'),
(28, 'la neta si', 'Bigthor'),
(28, 'la neta si', 'Bigthor  '),
(28, 'nel prros', 'Bigthor  '),
(28, 'c mamo', 'Bigthor  '),
(28, 'jajaja no manchen', 'Dovakin'),
(28, 'asdasd', 'Dovakin'),
(16, 'asdasd', 'Dovakin'),
(14, 'asdasdadsd', 'Dovakin'),
(16, 'jejeje hola mama', 'Dovakin'),
(14, 'que traes prro\r\n', 'Dovakin'),
(16, 'hola, te fue bien', 'funa'),
(30, 'hackeaste , despidete de tu cuenta lince', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(20) NOT NULL,
  `Alias` varchar(200) NOT NULL,
  `Pwd` varchar(30) NOT NULL,
  `Rol` varchar(20) NOT NULL,
  `Score` int(11) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `Nombre` (`Nombre`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `Nombre`, `Alias`, `Pwd`, `Rol`, `Score`) VALUES
(3, 'Victor Suarez', 'Bigthor  ', 'victor', 'General', 176),
(8, 'Carlos S', 'Jerath', '123', 'General', 0),
(14, 'Osvaldo', 'Dovakin', 'noo', 'General', 355),
(16, 'Charly ', 'Kazh     ', '123', 'General', 260),
(30, 'funalito', 'funa ', '123', 'General', 181),
(31, 'admin', 'admin ', 'admin', 'Administrador', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
