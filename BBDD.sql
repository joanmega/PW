-- phpMyAdmin SQL Dump
-- version 4.2.0-rc1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2014 a las 02:17:44
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `vidocens`
--



DROP DATABASE IF EXISTS `vidocens`;
CREATE DATABASE IF NOT EXISTS `vidocens` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;

GRANT ALL PRIVILEGES ON vidocens.* to ejercicio_pw;
GRANT ALL PRIVILEGES ON vidocens.* to 'ejercicio_pw'@'localhost';

USE `vidocens`;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `copia`
--

DROP TABLE IF EXISTS `copia`;
CREATE TABLE IF NOT EXISTS `copia` (
`cod_copia` int(11) NOT NULL,
  `FechaCopia` datetime NOT NULL,
  `RutaCopia` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `Actual` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `copia`
--

INSERT INTO `copia` (`cod_copia`, `FechaCopia`, `RutaCopia`, `Actual`) VALUES
(1, '2014-06-14 01:55:11', '../CopiasBD/2014-06-14 01:55:11.sql', 0),
(2, '2014-06-14 01:55:12', '../CopiasBD/2014-06-14 01:55:12.sql', 0),
(3, '2014-06-14 01:55:13', '../CopiasBD/2014-06-14 01:55:13.sql', 0),
(4, '2014-06-14 01:55:14', '../CopiasBD/2014-06-14 01:55:14.sql', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

DROP TABLE IF EXISTS `curso`;
CREATE TABLE IF NOT EXISTS `curso` (
`Cod_Curso` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` varchar(100) NOT NULL,
  `Creditos` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`Cod_Curso`, `Nombre`, `Descripcion`, `Creditos`) VALUES
(1, 'ABD', 'AdministraciÃ³n de Base de Datos', '6.00'),
(2, 'PW', 'ProgramaciÃ³n Web', '6.00'),
(3, 'ALEM', 'Ãlgebra lineal y estructuras matemÃ¡ticas', '6.00'),
(4, 'LMD', 'LÃ³gicos y mÃ©todos discretos', '6.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imparte`
--

DROP TABLE IF EXISTS `imparte`;
CREATE TABLE IF NOT EXISTS `imparte` (
  `Cod_Profesor` int(11) NOT NULL,
  `Cod_curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `imparte`
--

INSERT INTO `imparte` (`Cod_Profesor`, `Cod_curso`) VALUES
(10, 1),
(9, 2),
(11, 3),
(11, 4),
(12, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscrito`
--

DROP TABLE IF EXISTS `inscrito`;
CREATE TABLE IF NOT EXISTS `inscrito` (
  `Cod_Alumno` int(11) NOT NULL,
  `Cod_Curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `inscrito`
--

INSERT INTO `inscrito` (`Cod_Alumno`, `Cod_Curso`) VALUES
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(15, 2),
(16, 2),
(13, 3),
(14, 3),
(16, 3),
(13, 4),
(14, 4),
(16, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `material`
--

DROP TABLE IF EXISTS `material`;
CREATE TABLE IF NOT EXISTS `material` (
`Cod_Material` int(11) NOT NULL,
  `Cod_Curso` int(11) NOT NULL,
  `Descripcion` varchar(100) NOT NULL,
  `FechaSubida` datetime NOT NULL,
  `RutaFichero` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `material`
--

INSERT INTO `material` (`Cod_Material`, `Cod_Curso`, `Descripcion`, `FechaSubida`, `RutaFichero`) VALUES
(7, 1, 'Tema 1', '2014-06-14 00:00:00', '../../material/1/Tema 1.mp4'),
(8, 1, 'Tema 2', '2014-06-14 00:00:00', '../../material/1/Tema 2.mp4'),
(9, 1, 'Tema 3', '2014-06-14 00:00:00', '../../material/1/Tema 3.mp4'),
(10, 3, 'Tema 1', '2014-06-14 00:00:00', '../../material/3/Tema 1.mp4'),
(11, 3, 'Tema 2', '2014-06-14 00:00:00', '../../material/3/Tema 2.mp4'),
(12, 3, 'Tema 3', '2014-06-14 00:00:00', '../../material/3/Tema 3.mp4'),
(13, 4, 'Leccion 1', '2014-06-14 00:00:00', '../../material/4/Leccion 1.mp4'),
(14, 4, 'Leccion 2', '2014-06-14 00:00:00', '../../material/4/Leccion 2.mp4'),
(15, 2, 'PHP', '2014-06-14 00:00:00', '../../material/2/PHP.mp4'),
(16, 2, 'HTML', '2014-06-14 00:00:00', '../../material/2/HTML.mp4'),
(17, 2, 'Javascript', '2014-06-14 00:00:00', '../../material/2/Javascript.mp4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

DROP TABLE IF EXISTS `profesor`;
CREATE TABLE IF NOT EXISTS `profesor` (
  `Cod_profesor` int(11) NOT NULL,
  `extension` varchar(3) DEFAULT NULL,
  `departamento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`Cod_profesor`, `extension`, `departamento`) VALUES
(9, '0', 'DECSAI'),
(10, '0', 'DECSAI'),
(11, '0', 'evanegelina@ugr.es'),
(12, '0', 'Algebra');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
`Cod_Usuario` int(11) NOT NULL,
  `DNI` varchar(9) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido1` varchar(20) NOT NULL,
  `apellido2` varchar(20) NOT NULL,
  `pais` int(11) NOT NULL,
  `telefono` varchar(11) DEFAULT NULL,
  `movil` varchar(11) DEFAULT NULL,
  `correoElectronico` varchar(50) DEFAULT NULL,
  `fecNacimiento` date NOT NULL,
  `domicilio` varchar(50) DEFAULT NULL,
  `usuario` varchar(10) NOT NULL,
  `contrasena` varchar(50) NOT NULL,
  `tipoUsuario` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Cod_Usuario`, `DNI`, `nombre`, `apellido1`, `apellido2`, `pais`, `telefono`, `movil`, `correoElectronico`, `fecNacimiento`, `domicilio`, `usuario`, `contrasena`, `tipoUsuario`) VALUES
(1, '00000000X', 'admin', 'admin', 'admin', 1, '', '', '', '0000-00-00', '', 'admin', '21232f297a57a5a743894a0e4a801fc3', 0),
(9, '11111111H', 'Waldo', 'Fajardo', 'Contreras', 1, '0', '0', 'aragorn@ugr.es', '1968-12-12', 'Calle 1', 'waldo', 'bafc2467d6f7a6855d58279a2d971151', 1),
(10, '22222222J', 'Ignacio J.', 'Blanco', 'Medina', 1, '0', '0', 'iblanco@ugr.es', '1977-04-17', 'Calle 2', 'ignacio', '5e612fbcf98d8452ce474c972941439d', 1),
(11, '33333333P', 'Evangelina', 'Santos', 'AlÃ¡ez', 1, '0', '0', '', '1967-08-14', 'Calle 3', 'evangelina', '6d8f6f85712357ed6097a6b3e903bcd1', 1),
(12, '44444444A', 'Juan Manuel', 'Urbano', 'Blanco', 1, '0', '0', 'jurbano@ugr.es', '1947-09-21', 'Calle 5', 'juan', 'a94652aa97c7211ba8954dd15a3cf838', 1),
(13, '88888888Y', 'JosÃ© Antonio', 'Medina', 'GarcÃ­a', 1, '0', '0', 'josemed@correo.ugr.es', '1986-11-04', 'Mi calle', 'jose', '662eaa47199461d01a623884080934ab', 2),
(14, '55555555K', 'LucÃ­a', 'LÃ³pez', 'MolinÃ©', 1, '0', '0', 'lucia@correo.ugr.es', '1989-07-07', 'Calle 6', 'lucia', '3ba430337eb30f5fd7569451b5dfdf32', 2),
(15, '66666666Q', 'AgustÃ­n', 'RuÃ­z', 'PÃ©rez', 1, '0', '0', 'agustin_1203@corrreo.ugr.es', '1987-06-12', 'Calle 7', 'agustin', '4ff413b71217b7b2c3e845c71fc834a9', 2),
(16, '77777777B', 'Marta', 'LÃ³pez', 'Ãvila', 1, '0', '0', 'martita@correo.ugr.es', '1991-04-01', 'Calle 8', 'marta', 'a763a66f984948ca463b081bf0f0e6d0', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `copia`
--
ALTER TABLE `copia`
 ADD PRIMARY KEY (`cod_copia`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
 ADD PRIMARY KEY (`Cod_Curso`), ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indices de la tabla `imparte`
--
ALTER TABLE `imparte`
 ADD PRIMARY KEY (`Cod_Profesor`,`Cod_curso`), ADD KEY `Cod_curso` (`Cod_curso`), ADD KEY `Cod_Profesor` (`Cod_Profesor`);

--
-- Indices de la tabla `inscrito`
--
ALTER TABLE `inscrito`
 ADD PRIMARY KEY (`Cod_Alumno`,`Cod_Curso`), ADD KEY `Cod_Curso` (`Cod_Curso`), ADD KEY `Cod_Alumno` (`Cod_Alumno`);

--
-- Indices de la tabla `material`
--
ALTER TABLE `material`
 ADD PRIMARY KEY (`Cod_Material`), ADD KEY `Cod_Curso` (`Cod_Curso`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
 ADD PRIMARY KEY (`Cod_profesor`), ADD KEY `Cod_profesor` (`Cod_profesor`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
 ADD PRIMARY KEY (`Cod_Usuario`), ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `copia`
--
ALTER TABLE `copia`
MODIFY `cod_copia` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
MODIFY `Cod_Curso` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `material`
--
ALTER TABLE `material`
MODIFY `Cod_Material` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
MODIFY `Cod_Usuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `imparte`
--
ALTER TABLE `imparte`
ADD CONSTRAINT `FK_Imparte_Curso` FOREIGN KEY (`Cod_curso`) REFERENCES `curso` (`Cod_Curso`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Imparte_Profesor` FOREIGN KEY (`Cod_Profesor`) REFERENCES `profesor` (`Cod_profesor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inscrito`
--
ALTER TABLE `inscrito`
ADD CONSTRAINT `FK_Inscrito_Curso` FOREIGN KEY (`Cod_Curso`) REFERENCES `curso` (`Cod_Curso`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Inscrito_Usuario` FOREIGN KEY (`Cod_Alumno`) REFERENCES `usuario` (`Cod_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `material`
--
ALTER TABLE `material`
ADD CONSTRAINT `FK_Material_Curso` FOREIGN KEY (`Cod_Curso`) REFERENCES `curso` (`Cod_Curso`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `profesor`
--
ALTER TABLE `profesor`
ADD CONSTRAINT `FK_Profesor_Usuario` FOREIGN KEY (`Cod_profesor`) REFERENCES `usuario` (`Cod_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
