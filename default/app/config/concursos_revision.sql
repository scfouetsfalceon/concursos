-- phpMyAdmin SQL Dump
-- version 3.2.5deb2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tiempo de generación: 02-06-2013 a las 23:47:14
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.12-2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `scouts_concursos`
--
CREATE DATABASE `scouts_concursos` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `scouts_concursos`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE IF NOT EXISTS `actividades` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `fecha` date NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `lugar` varchar(45) NOT NULL,
  `duracion` int(2) NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `pcp` int(1) NOT NULL COMMENT 'Conceptos Programaticos',
  `ba` int(1) NOT NULL COMMENT 'Bono de  Asistencia',
  `bgi` int(1) NOT NULL COMMENT 'Bono por independencia',
  `ramas_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_actividades_ramas1_idx` (`ramas_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `actividades`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distrito`
--

CREATE TABLE IF NOT EXISTS `distrito` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  `region_id` int(11) unsigned NOT NULL,
  `creado_at` datetime NOT NULL,
  `modificado_in` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_distrito_region_idx` (`region_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `distrito`
--

INSERT INTO `distrito` (`id`, `nombre`, `region_id`, `creado_at`, `modificado_in`) VALUES
(1, 'Paraguaná', 1, '2013-06-02 14:16:11', NULL),
(2, 'Manaure', 1, '2013-06-02 14:16:23', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE IF NOT EXISTS `equipos` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  `ramas_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_equipos_ramas1_idx` (`ramas_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `equipos`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE IF NOT EXISTS `grupos` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  `distrito_id` int(11) unsigned NOT NULL,
  `creado_at` datetime NOT NULL,
  `modificado_in` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_grupos_distrito1_idx` (`distrito_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id`, `nombre`, `distrito_id`, `creado_at`, `modificado_in`) VALUES
(1, 'Nazaret', 1, '2013-06-02 14:48:41', NULL),
(2, 'Matacán', 1, '2013-06-02 14:48:54', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jovenes`
--

CREATE TABLE IF NOT EXISTS `jovenes` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `credencial` int(10) default NULL,
  `primer_nombre` varchar(20) NOT NULL,
  `segundo_nombre` varchar(20) default NULL,
  `primer_apellido` varchar(20) NOT NULL,
  `segundo_apellido` varchar(20) default NULL,
  `nacionalidad` varchar(1) NOT NULL,
  `cedula` varchar(45) default NULL,
  `creado_at` varchar(45) NOT NULL,
  `actualizado_in` varchar(45) default NULL,
  `ramas_id` int(11) unsigned NOT NULL,
  `estado` int(1) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `credencial` (`credencial`),
  UNIQUE KEY `credencial_2` (`credencial`),
  KEY `fk_jovenes_ramas1_idx` (`ramas_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `jovenes`
--

INSERT INTO `jovenes` (`id`, `credencial`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `nacionalidad`, `cedula`, `creado_at`, `actualizado_in`, `ramas_id`, `estado`) VALUES
(1, 123456, 'Jaro', 'Andrei', 'Marval', 'Pereira', 'V', '16756365', '2013-06-02 15:41:58', NULL, 1, 1),
(2, NULL, 'Pepito', NULL, 'Fulano', NULL, 'V', '123456', '2013-06-02 16:03:04', NULL, 1, 1),
(3, NULL, 'Fernando', NULL, 'Ferreira', NULL, 'V', '16756365', '2013-06-02 16:06:15', NULL, 1, 1),
(4, NULL, 'Daniel', NULL, 'Ferreira', NULL, 'V', NULL, '2013-06-02 16:08:54', NULL, 1, 1),
(5, NULL, 'Mafer', NULL, 'Ferreira', NULL, 'V', NULL, '2013-06-02 16:09:08', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jovenes_actividades`
--

CREATE TABLE IF NOT EXISTS `jovenes_actividades` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `jovenes_id` int(11) unsigned NOT NULL,
  `actividades_id` int(11) unsigned NOT NULL,
  `usuarios_id` int(11) unsigned NOT NULL,
  `creado_at` date NOT NULL,
  `actualizado_in` date default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_jovenes_actividades_jovenes1_idx` (`jovenes_id`),
  KEY `fk_jovenes_actividades_actividades1_idx` (`actividades_id`),
  KEY `fk_jovenes_actividades_usuarios1_idx` (`usuarios_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `jovenes_actividades`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `ip` varchar(39) NOT NULL,
  `accion` int(1) NOT NULL,
  `usuario_id` int(11) default NULL,
  `creado_at` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Volcar la base de datos para la tabla `log`
--

INSERT INTO `log` (`id`, `ip`, `accion`, `usuario_id`, `creado_at`) VALUES
(1, '::1', 0, NULL, '2013-06-01 18:19:49'),
(2, '::1', 0, NULL, '2013-06-01 18:20:27'),
(3, '::1', 1, 1, '2013-06-01 18:22:29'),
(4, '::1', 0, NULL, '2013-06-01 20:01:51'),
(5, '::1', 1, 1, '2013-06-01 20:02:07'),
(6, '::1', 1, 1, '2013-06-01 20:54:09'),
(7, '::1', 1, 1, '2013-06-01 23:53:21'),
(8, '::1', 1, 1, '2013-06-02 00:43:45'),
(9, '::1', 1, 1, '2013-06-02 13:46:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ramas`
--

CREATE TABLE IF NOT EXISTS `ramas` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `tipo_id` int(11) unsigned NOT NULL,
  `grupos_id` int(11) unsigned NOT NULL,
  `creado_at` datetime NOT NULL,
  `modificado_in` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_ramas_grupos1_idx` (`grupos_id`),
  KEY `fk_ramas_tipo1_idx` (`tipo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcar la base de datos para la tabla `ramas`
--

INSERT INTO `ramas` (`id`, `tipo_id`, `grupos_id`, `creado_at`, `modificado_in`) VALUES
(1, 1, 1, '2013-06-02 15:11:33', NULL),
(2, 2, 1, '2013-06-02 15:11:45', NULL),
(3, 3, 1, '2013-06-02 15:12:03', NULL),
(4, 4, 1, '2013-06-02 15:12:13', NULL),
(5, 5, 1, '2013-06-02 15:18:54', NULL),
(6, 6, 1, '2013-06-02 15:19:06', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `region`
--

CREATE TABLE IF NOT EXISTS `region` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  `creado_at` datetime NOT NULL,
  `modificado_in` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `region`
--

INSERT INTO `region` (`id`, `nombre`, `creado_at`, `modificado_in`) VALUES
(1, 'Falcón', '2013-06-02 13:57:28', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE IF NOT EXISTS `tipo` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `nombre` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcar la base de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`id`, `nombre`) VALUES
(1, 'Manada Femenina'),
(2, 'Manada Masculina'),
(3, 'Tropa Femenina'),
(4, 'Tropa Masculina'),
(5, 'Clan Femenino'),
(6, 'Clan Masculino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `primer_nombre` varchar(20) NOT NULL,
  `segundo_nombre` varchar(20) default NULL,
  `primer_apellido` varchar(20) NOT NULL,
  `segundo_apellido` varchar(20) default NULL,
  `email` varchar(20) NOT NULL,
  `clave` varchar(52) NOT NULL,
  `creado_at` date NOT NULL,
  `actualizado_in` date default NULL,
  `tipo` varchar(45) NOT NULL,
  `nivel` int(1) default '5',
  `estructura_id` int(11) unsigned NOT NULL,
  `estatus` int(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `email`, `clave`, `creado_at`, `actualizado_in`, `tipo`, `nivel`, `estructura_id`, `estatus`) VALUES
(1, 'Jaro', 'Andrei', 'Marval', 'Pereira', 'jampgold@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2013-05-22', NULL, '0', 1, 1, 1);

--
-- Filtros para las tablas descargadas (dump)
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
