-- phpMyAdmin SQL Dump
-- version 4.0.0
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 12-07-2013 a las 18:12:29
-- Versión del servidor: 5.1.49-3
-- Versión de PHP: 5.3.3-7+squeeze14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `demo_concursos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE IF NOT EXISTS `actividades` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `lugar` varchar(50) NOT NULL,
  `duracion` int(2) NOT NULL,
  `cval` int(1) unsigned NOT NULL,
  `cac` int(1) unsigned NOT NULL,
  `bcp` int(1) unsigned NOT NULL COMMENT 'Conceptos Programaticos',
  `ba` int(1) unsigned NOT NULL COMMENT 'Bono de  Asistencia',
  `bgi` int(1) unsigned NOT NULL COMMENT 'Bono por independencia',
  `ramas_id` int(11) unsigned NOT NULL,
  `creado_at` datetime NOT NULL,
  `modificado_in` datetime DEFAULT NULL,
  `tipo` int(1) unsigned DEFAULT NULL COMMENT 'Tipo de Actividad',
  PRIMARY KEY (`id`),
  KEY `fk_actividades_ramas1_idx` (`ramas_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distrito`
--

CREATE TABLE IF NOT EXISTS `distrito` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `region_id` int(11) unsigned NOT NULL,
  `estado` int(1) NOT NULL,
  `creado_at` datetime NOT NULL,
  `modificado_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_distrito_region_idx` (`region_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE IF NOT EXISTS `equipos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `ramas_id` int(11) unsigned NOT NULL,
  `estado` int(1) NOT NULL,
  `creado_at` datetime NOT NULL,
  `modificado_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_equipos_ramas1_idx` (`ramas_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE IF NOT EXISTS `grupos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `distrito_id` int(11) unsigned NOT NULL,
  `estado` int(1) NOT NULL,
  `creado_at` datetime NOT NULL,
  `modificado_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_grupos_distrito1_idx` (`distrito_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jovenes`
--

CREATE TABLE IF NOT EXISTS `jovenes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `credencial` int(10) DEFAULT NULL,
  `primer_nombre` varchar(20) NOT NULL,
  `segundo_nombre` varchar(20) DEFAULT NULL,
  `primer_apellido` varchar(20) NOT NULL,
  `segundo_apellido` varchar(20) DEFAULT NULL,
  `nacionalidad` varchar(1) NOT NULL,
  `cedula` varchar(45) DEFAULT NULL,
  `estado` int(1) NOT NULL,
  `creado_at` datetime NOT NULL,
  `modificado_in` datetime DEFAULT NULL,
  `ramas_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `credencial` (`credencial`),
  KEY `fk_jovenes_ramas1_idx` (`ramas_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jovenes_actividades`
--

CREATE TABLE IF NOT EXISTS `jovenes_actividades` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `jovenes_id` int(11) unsigned NOT NULL,
  `actividades_id` int(11) unsigned NOT NULL,
  `usuarios_id` int(11) unsigned NOT NULL,
  `estado` int(1) NOT NULL,
  `creditos` int(2) unsigned NOT NULL,
  `creado_at` date NOT NULL,
  `modificado_in` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_jovenes_actividades_jovenes1_idx` (`jovenes_id`),
  KEY `fk_jovenes_actividades_actividades1_idx` (`actividades_id`),
  KEY `fk_jovenes_actividades_usuarios1_idx` (`usuarios_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(39) NOT NULL,
  `accion` int(1) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `creado_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ramas`
--

CREATE TABLE IF NOT EXISTS `ramas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_id` int(11) unsigned NOT NULL,
  `grupos_id` int(11) unsigned NOT NULL,
  `creado_at` datetime NOT NULL,
  `modificado_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ramas_grupos1_idx` (`grupos_id`),
  KEY `fk_ramas_tipo1_idx` (`tipo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `region`
--

CREATE TABLE IF NOT EXISTS `region` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `estado` int(1) NOT NULL,
  `creado_at` datetime NOT NULL,
  `modificado_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE IF NOT EXISTS `tipo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nac` varchar(1) DEFAULT NULL,
  `cedula` int(10) DEFAULT NULL,
  `credencial` int(6) DEFAULT NULL,
  `primer_nombre` varchar(20) NOT NULL,
  `segundo_nombre` varchar(20) DEFAULT NULL,
  `primer_apellido` varchar(20) NOT NULL,
  `segundo_apellido` varchar(20) DEFAULT NULL,
  `email` varchar(20) NOT NULL,
  `clave` varchar(52) NOT NULL,
  `estado` int(1) NOT NULL,
  `creado_at` datetime NOT NULL,
  `modificado_in` datetime DEFAULT NULL,
  `tipo` varchar(45) NOT NULL,
  `nivel` int(1) DEFAULT '5',
  `estructura_id` int(11) unsigned NOT NULL,
  `region_id` int(10) unsigned DEFAULT NULL,
  `distrito_id` int(10) unsigned DEFAULT NULL,
  `grupos_id` int(11) unsigned DEFAULT NULL,
  `ramas_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `fk_actividades_ramas1` FOREIGN KEY (`ramas_id`) REFERENCES `ramas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `distrito`
--
ALTER TABLE `distrito`
  ADD CONSTRAINT `fk_distrito_region` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD CONSTRAINT `fk_equipos_ramas1` FOREIGN KEY (`ramas_id`) REFERENCES `ramas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `fk_grupos_distrito1` FOREIGN KEY (`distrito_id`) REFERENCES `distrito` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `jovenes`
--
ALTER TABLE `jovenes`
  ADD CONSTRAINT `fk_jovenes_ramas1` FOREIGN KEY (`ramas_id`) REFERENCES `ramas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `jovenes_actividades`
--
ALTER TABLE `jovenes_actividades`
  ADD CONSTRAINT `fk_jovenes_actividades_actividades1` FOREIGN KEY (`actividades_id`) REFERENCES `actividades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jovenes_actividades_jovenes1` FOREIGN KEY (`jovenes_id`) REFERENCES `jovenes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jovenes_actividades_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ramas`
--
ALTER TABLE `ramas`
  ADD CONSTRAINT `fk_ramas_grupos1` FOREIGN KEY (`grupos_id`) REFERENCES `grupos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ramas_tipo1` FOREIGN KEY (`tipo_id`) REFERENCES `tipo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
