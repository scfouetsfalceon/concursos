-- phpMyAdmin SQL Dump
-- version 4.0.0
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 22-05-2013 a las 19:44:39
-- Versión del servidor: 5.1.49-3
-- Versión de PHP: 5.3.3-7+squeeze14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `scouts_concursos`
--
CREATE DATABASE IF NOT EXISTS `scouts_concursos`;
use `scouts_concursos`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE IF NOT EXISTS `actividades` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `lugar` varchar(50) NOT NULL,
  `duracion` int(2) NOT NULL,
  `tipo` int(1) UNSIGNED NOT NULL COMMENT 'Tipo de Actividades CVAL(1), CAC(2)',
  `bcp` int(1) UNSIGNED NOT NULL COMMENT 'Conceptos Programaticos',
  `ba` int(1) UNSIGNED NOT NULL COMMENT 'Bono de  Asistencia',
  `bgi` int(1) UNSIGNED NOT NULL COMMENT 'Bono por independencia',
  `creditos` int(2) UNSIGNED NOT NULL COMMENT 'Bono por independencia',
  `ramas_id` int(11) UNSIGNED NOT NULL,
  `creado_at` datetime UNSIGNED NOT NULL,
  `modificado_in` datetime UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_actividades_ramas1_idx` (`ramas_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distrito`
--

CREATE TABLE IF NOT EXISTS `distrito` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `region_id` int(11) UNSIGNED NOT NULL,
  `estado` int(1) NOT NULL,
  `creado_at` datetime NOT NULL,
  `modificado_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_distrito_region_idx` (`region_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE IF NOT EXISTS `equipos` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `ramas_id` int(11) UNSIGNED NOT NULL,
  `estado` int(1) NOT NULL,
  `creado_at` datetime NOT NULL,
  `modificado_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_equipos_ramas1_idx` (`ramas_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE IF NOT EXISTS `grupos` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `distrito_id` int(11) UNSIGNED NOT NULL,
  `estado` int(1) NOT NULL,
  `creado_at` datetime NOT NULL,
  `modificado_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_grupos_distrito1_idx` (`distrito_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jovenes`
--

CREATE TABLE IF NOT EXISTS `jovenes` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `credencial` int(10) NOT NULL,
  `primer_nombre` varchar(20) NOT NULL,
  `segundo_nombre` varchar(20) DEFAULT NULL,
  `primer_apellido` varchar(20) NOT NULL,
  `segundo_apellido` varchar(20) DEFAULT NULL,
  `nacionalidad` varchar(1) NOT NULL,
  `cedula` varchar(45) DEFAULT NULL,
  `estado` int(1) NOT NULL,
  `creado_at` datetime NOT NULL,
  `modificado_in` datetime DEFAULT NULL,
  `ramas_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `credencial` (`credencial`),
  KEY `fk_jovenes_ramas1_idx` (`ramas_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jovenes_actividades`
--

CREATE TABLE IF NOT EXISTS `jovenes_actividades` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `jovenes_id` int(11) UNSIGNED unsigned NOT NULL,
  `actividades_id` int(11) UNSIGNED NOT NULL,
  `usuarios_id` int(11) UNSIGNED unsigned NOT NULL,
  `estado` int(1) NOT NULL,
  `creado_at` date NOT NULL,
  `modificado_in` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_jovenes_actividades_jovenes1_idx` (`jovenes_id`),
  KEY `fk_jovenes_actividades_actividades1_idx` (`actividades_id`),
  KEY `fk_jovenes_actividades_usuarios1_idx` (`usuarios_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ramas`
--

CREATE TABLE IF NOT EXISTS `ramas` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo_id` int(11) UNSIGNED  NOT NULL,
  `grupos_id` int(11) UNSIGNED NOT NULL,
  `creado_at` datetime NOT NULL,
  `modificado_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ramas_grupos1_idx` (`grupos_id`),
  KEY `fk_ramas_tipo1_idx` ( `tipo_id` )
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `region`
--

CREATE TABLE IF NOT EXISTS `region` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `estado` int(1) NOT NULL,
  `creado_at` datetime NOT NULL,
  `modificado_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
  `estructura_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;


--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `email`, `clave`, `estado`, `creado_at`, `modificado_in`, `tipo`, `nivel`, `estructura_id`) VALUES
(1, 'Jaro', 'Andrei', 'Marval', 'Pereira', 'jampgold@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, '0000-00-00 00:00:00', NULL, '0', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE IF NOT EXISTS `tipo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR( 20 ) NOT NULL,
  PRIMARY KEY (`id`)
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

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(39) NOT NULL,
  `accion` int(1) NOT NULL,
  `usuario_id` int(11) NULL,
  `creado_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

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
  ADD CONSTRAINT `fk_jovenes_actividades_jovenes1` FOREIGN KEY (`jovenes_id`) REFERENCES `jovenes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jovenes_actividades_actividades1` FOREIGN KEY (`actividades_id`) REFERENCES `actividades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jovenes_actividades_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ramas`
--
ALTER TABLE `ramas`
  ADD CONSTRAINT `fk_ramas_grupos1` FOREIGN KEY (`grupos_id`) REFERENCES `grupos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ramas_tipo1` FOREIGN KEY ( `tipo_id` ) REFERENCES `tipo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
