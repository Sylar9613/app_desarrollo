-- Por Arian 1.1b
-- Generado el 14-02-2022 a las 02:02:26 por el usuario 'root'
-- Servidor: localhost:8000
-- MySQL Version: 5.5.5-10.3.15-MariaDB
-- PHP Version: 7.2.19
-- Base de datos: 'sostenible'
-- Tablas: '8'
     
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE="NO_AUTO_VALUE_ON_ZERO" */;

DELIMITER $$
--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `buscar_string` (`nombre_o_apellido` VARCHAR(120), `fuente` VARCHAR(120)) RETURNS INT(3) begin

RETURN if(locate(nombre_o_apellido,fuente)=0,0,1);

end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `devolver_anno` (`fecha_vence` VARCHAR(10)) RETURNS INT(2) BEGIN
return IF(EXTRACT(YEAR FROM curdate())-(LEFT(fecha_vence,4)+5)=0,1,0);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `edad` (`CI` VARCHAR(11)) RETURNS INT(11) BEGIN

return if(substr(curdate(),3,2) > left(CI,2), substr(curdate(),3,2) - left(CI,2),
left(curdate(),4)-1900-left(CI,2));

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `sexo` (`CI` VARCHAR(11)) RETURNS CHAR(1) CHARSET latin1 BEGIN

return if(substr(CI,10,1)%2=0,'M','F');

END$$

DELIMITER ;

            
-- 
-- Vaciado de tabla 'accion'
-- 
DROP TABLE IF EXISTS `accion`;
                        
--
-- Estructura de tabla para la tabla 'accion'
--

CREATE TABLE `accion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipoaccion_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `nombre` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8A02E3B43A909126` (`nombre`),
  KEY `IDX_8A02E3B4C74E4DDC` (`tipoaccion_id`),
  CONSTRAINT `FK_8A02E3B4C74E4DDC` FOREIGN KEY (`tipoaccion_id`) REFERENCES `tipo_accion` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                
--
-- Volcado de datos para la tabla 'accion'
--

INSERT INTO `accion` (`id`, `tipoaccion_id`, `fecha`, `activo`, `nombre`) VALUES 
('1', '2', '2022-02-11', '1', 'Gobierno 2022'),
('4', '4', '2022-02-12', '1', 'CPM 2022'),
('5', '4', '2022-02-18', '1', 'CPM 2021');

            
-- 
-- Vaciado de tabla 'objetivo'
-- 
DROP TABLE IF EXISTS `objetivo`;
                        
--
-- Estructura de tabla para la tabla 'objetivo'
--

CREATE TABLE `objetivo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8F4E816E3A909126` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                
--
-- Volcado de datos para la tabla 'objetivo'
--

INSERT INTO `objetivo` (`id`, `nombre`, `activo`) VALUES 
('1', 'Fin de la pobreza', '1'),
('2', 'Hambre cero', '1'),
('3', 'Salud y bienestar', '1'),
('4', 'Educación de calidad', '1'),
('5', 'Igualdad de género', '1'),
('6', 'Agua limpia y saneamiento', '1'),
('7', 'Energía asequible y no contaminante', '1'),
('8', 'Trabajo decente y crecimiento económico', '1'),
('9', 'Industria, innovación e infraestructura', '1'),
('10', 'Reducción de las desigualdades', '1'),
('11', 'Ciudades y comunidades sostenibles', '1'),
('12', 'Producción y consumos responsables', '1'),
('13', 'Acción por el clima', '1'),
('14', 'Vida submarina', '1'),
('15', 'Vida de ecosistemas terrestres', '1'),
('16', 'Paz, justicia e instituciones sólidas', '1'),
('17', 'Alianzas para lograr los objetivos', '1');

            
-- 
-- Vaciado de tabla 'objetivo_entidad'
-- 
DROP TABLE IF EXISTS `objetivo_entidad`;
                        
--
-- Estructura de tabla para la tabla 'objetivo_entidad'
--

CREATE TABLE `objetivo_entidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entidad_id` int(11) NOT NULL,
  `objetivo_id` int(11) NOT NULL,
  `acciones_id` int(11) NOT NULL,
  `deficiencias` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recomendaciones` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seguimiento` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DC2B4E266CA204EF` (`entidad_id`),
  KEY `IDX_DC2B4E2697F4E608` (`objetivo_id`),
  KEY `IDX_DC2B4E26941FF8DD` (`acciones_id`),
  CONSTRAINT `FK_DC2B4E266CA204EF` FOREIGN KEY (`entidad_id`) REFERENCES `entidad` (`id`),
  CONSTRAINT `FK_DC2B4E26941FF8DD` FOREIGN KEY (`acciones_id`) REFERENCES `accion` (`id`),
  CONSTRAINT `FK_DC2B4E2697F4E608` FOREIGN KEY (`objetivo_id`) REFERENCES `objetivo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                
--
-- Volcado de datos para la tabla 'objetivo_entidad'
--

INSERT INTO `objetivo_entidad` (`id`, `entidad_id`, `objetivo_id`, `acciones_id`, `deficiencias`, `recomendaciones`, `seguimiento`, `activo`) VALUES 
('1', '2', '17', '5', '-', '-', '-', '1'),
('2', '2', '17', '5', '-', '-', '-', '1');

            
-- 
-- Vaciado de tabla 'entidad'
-- 
DROP TABLE IF EXISTS `entidad`;
                        
--
-- Estructura de tabla para la tabla 'entidad'
--

CREATE TABLE `entidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4587B0CB3A909126` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                
--
-- Volcado de datos para la tabla 'entidad'
--

INSERT INTO `entidad` (`id`, `nombre`, `activo`) VALUES 
('1', 'Gobierno Provincial', '1'),
('2', 'Contraloría Provincial Matanzas', '1');

            
-- 
-- Vaciado de tabla 'log'
-- 
DROP TABLE IF EXISTS `log`;
                        
--
-- Estructura de tabla para la tabla 'log'
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `ip` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8F3F68C5DB38439E` (`usuario_id`),
  CONSTRAINT `FK_8F3F68C5DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                
--
-- Volcado de datos para la tabla 'log'
--

INSERT INTO `log` (`id`, `usuario_id`, `fecha`, `ip`, `accion`) VALUES 
('1', '1', '2022-01-11 11:25:20', '::1', 'Login'),
('2', '1', '2022-01-11 17:40:24', '::1', 'Insertar tipo de acción'),
('3', '1', '2022-01-11 17:40:50', '::1', 'Insertar tipo de acción'),
('4', '1', '2022-01-11 17:41:07', '::1', 'Insertar tipo de acción'),
('5', '1', '2022-01-11 17:41:29', '::1', 'Insertar tipo de acción'),
('6', '1', '2022-01-13 16:05:18', '::1', 'Insertar entidad'),
('7', '1', '2022-01-26 17:13:51', '::1', 'Login'),
('8', '1', '2022-02-07 12:35:32', '::1', 'Login'),
('9', '1', '2022-02-09 14:36:36', '::1', 'Login'),
('10', '1', '2022-02-10 16:22:40', '::1', 'Insertar entidad'),
('11', '1', '2022-02-10 17:23:42', '::1', 'Insertar acción'),
('12', '1', '2022-02-10 17:27:44', '::1', 'Insertar acción'),
('13', '1', '2022-02-11 12:48:17', '::1', 'Insertar acción'),
('14', '1', '2022-02-11 12:50:10', '::1', 'Insertar acción'),
('15', '1', '2022-02-11 12:53:09', '::1', 'Insertar acción'),
('16', '1', '2022-02-11 16:14:41', '::1', 'Insertar objetivo entidad'),
('17', '1', '2022-02-11 16:16:29', '::1', 'Insertar objetivo entidad');

            
-- 
-- Vaciado de tabla 'migration_versions'
-- 
DROP TABLE IF EXISTS `migration_versions`;
                        
--
-- Estructura de tabla para la tabla 'migration_versions'
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                
--
-- Volcado de datos para la tabla 'migration_versions'
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES 
('20220111155755', '2022-01-11 15:59:50'),
('20220111160407', '2022-01-11 16:04:13'),
('20220111215450', '2022-01-11 21:55:20'),
('20220210192915', '2022-02-10 19:29:39');

            
-- 
-- Vaciado de tabla 'tipo_accion'
-- 
DROP TABLE IF EXISTS `tipo_accion`;
                        
--
-- Estructura de tabla para la tabla 'tipo_accion'
--

CREATE TABLE `tipo_accion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1FBB15AC3A909126` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                
--
-- Volcado de datos para la tabla 'tipo_accion'
--

INSERT INTO `tipo_accion` (`id`, `nombre`, `activo`) VALUES 
('1', 'Auditoría Financiera', '1'),
('2', 'Auditoría de Cumplimiento', '1'),
('3', 'Auditoría Forense', '1'),
('4', 'Auditoría de Desempeño', '1');

            
-- 
-- Vaciado de tabla 'user'
-- 
DROP TABLE IF EXISTS `user`;
                        
--
-- Estructura de tabla para la tabla 'user'
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json_array)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                
--
-- Volcado de datos para la tabla 'user'
--

INSERT INTO `user` (`id`, `email`, `username`, `roles`, `password`, `is_active`, `avatar`) VALUES 
('1', 'admin@nauta.cu', 'admin', '[\"ROLE_SUPER_ADMIN\",\"ROLE_ADMIN\"]', '$2y$13$NUSdn/11bllrnbMc2cr54eUK8gaefAVlSrhYy6HS7N3pgjFhFLeye', '1', 'avatar2.png');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;