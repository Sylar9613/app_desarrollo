-- Por Arian 1.1b
-- Generado el 31-10-2022 a las 12:10:07 por el usuario 'root'
-- Servidor: 127.0.0.1:8000
-- MySQL Version: 5.5.5-10.3.15-MariaDB
-- PHP Version: 7.2.19
-- Base de datos: 'sostenible'
-- Tablas: '12'
     
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
-- Vaciado de tabla 'accion_pam'
-- 
DROP TABLE IF EXISTS `accion_pam`;
                        
--
-- Estructura de tabla para la tabla 'accion_pam'
--

CREATE TABLE `accion_pam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lineas_id` int(11) NOT NULL,
  `nombre` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `responsables` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AFD1503354923972` (`lineas_id`),
  CONSTRAINT `FK_AFD1503354923972` FOREIGN KEY (`lineas_id`) REFERENCES `linea_estrategica` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
-- 
-- Vaciado de tabla 'datos'
-- 
DROP TABLE IF EXISTS `datos`;
                        
--
-- Estructura de tabla para la tabla 'datos'
--

CREATE TABLE `datos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `database_filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                
--
-- Volcado de datos para la tabla 'datos'
--

INSERT INTO `datos` (`id`, `database_filename`, `date`) VALUES 
('5', 'database20220218025606.sql', '2022-02-18 02:56:06'),
('6', 'database-sostenible20220426113950.sql', '2022-04-26 11:39:50'),
('7', 'database-sostenible20220426114247.sql', '2022-04-26 11:42:47');

            
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
-- Vaciado de tabla 'linea_estrategica'
-- 
DROP TABLE IF EXISTS `linea_estrategica`;
                        
--
-- Estructura de tabla para la tabla 'linea_estrategica'
--

CREATE TABLE `linea_estrategica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pam_id` int(11) NOT NULL,
  `nombre` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `indicadores` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F764911E3A909126` (`nombre`),
  KEY `IDX_F764911E4EFEC163` (`pam_id`),
  CONSTRAINT `FK_F764911E4EFEC163` FOREIGN KEY (`pam_id`) REFERENCES `pam` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
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
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                
--
-- Volcado de datos para la tabla 'log'
--

INSERT INTO `log` (`id`, `usuario_id`, `fecha`, `ip`, `accion`) VALUES 
('1', '1', '2022-01-11 11:25:20', '::1', 'Login'),
('2', '1', '2022-01-11 17:40:24', '::1', 'Insertar tipo de acci?n'),
('3', '1', '2022-01-11 17:40:50', '::1', 'Insertar tipo de acci?n'),
('4', '1', '2022-01-11 17:41:07', '::1', 'Insertar tipo de acci?n'),
('5', '1', '2022-01-11 17:41:29', '::1', 'Insertar tipo de acci?n'),
('6', '1', '2022-01-13 16:05:18', '::1', 'Insertar entidad'),
('7', '1', '2022-01-26 17:13:51', '::1', 'Login'),
('8', '1', '2022-02-07 12:35:32', '::1', 'Login'),
('9', '1', '2022-02-09 14:36:36', '::1', 'Login'),
('10', '1', '2022-02-10 16:22:40', '::1', 'Insertar entidad'),
('11', '1', '2022-02-10 17:23:42', '::1', 'Insertar acci?n'),
('12', '1', '2022-02-10 17:27:44', '::1', 'Insertar acci?n'),
('13', '1', '2022-02-11 12:48:17', '::1', 'Insertar acci?n'),
('14', '1', '2022-02-11 12:50:10', '::1', 'Insertar acci?n'),
('15', '1', '2022-02-11 12:53:09', '::1', 'Insertar acci?n'),
('16', '1', '2022-02-11 16:14:41', '::1', 'Insertar objetivo entidad'),
('17', '1', '2022-02-11 16:16:29', '::1', 'Insertar objetivo entidad'),
('18', '1', '2022-02-17 16:56:01', '::1', 'Login'),
('19', '1', '2022-02-17 22:59:46', '::1', 'Modificar entidad: 2'),
('20', '1', '2022-02-17 20:46:07', '127.0.0.1', 'Login'),
('21', '1', '2022-02-18 02:56:06', '127.0.0.1', 'Salvar Database'),
('22', '1', '2022-02-28 10:39:45', '::1', 'Login'),
('23', '1', '2022-02-28 11:10:49', '::1', 'Crear reporte'),
('24', '1', '2022-02-28 11:11:03', '::1', 'Crear reporte'),
('25', '1', '2022-02-28 11:12:57', '::1', 'Crear reporte'),
('26', '1', '2022-02-28 11:13:58', '::1', 'Crear reporte'),
('27', '1', '2022-02-28 11:17:02', '::1', 'Crear reporte'),
('28', '1', '2022-02-28 11:17:11', '::1', 'Crear reporte'),
('29', '1', '2022-02-28 11:17:45', '::1', 'Crear reporte'),
('30', '1', '2022-02-28 11:27:39', '::1', 'Crear reporte'),
('31', '1', '2022-02-28 11:27:52', '::1', 'Crear reporte'),
('32', '1', '2022-02-28 11:28:26', '::1', 'Crear reporte'),
('33', '1', '2022-02-28 11:45:04', '::1', 'Crear reporte'),
('34', '1', '2022-02-28 11:50:34', '::1', 'Crear reporte'),
('35', '1', '2022-02-28 12:02:37', '::1', 'Crear reporte'),
('36', '1', '2022-02-28 12:07:40', '::1', 'Crear reporte'),
('37', '1', '2022-02-28 12:11:39', '::1', 'Crear reporte'),
('38', '1', '2022-02-28 12:14:20', '::1', 'Crear reporte'),
('39', '1', '2022-02-28 12:15:55', '::1', 'Crear reporte'),
('40', '1', '2022-02-28 12:17:24', '::1', 'Crear reporte'),
('41', '1', '2022-03-01 09:15:27', '::1', 'Crear reporte'),
('42', '1', '2022-03-01 09:16:23', '::1', 'Crear reporte'),
('43', '1', '2022-03-01 09:19:20', '::1', 'Crear reporte'),
('44', '1', '2022-03-01 09:30:08', '::1', 'Crear reporte'),
('45', '1', '2022-03-01 09:38:15', '::1', 'Crear reporte'),
('46', '1', '2022-03-01 09:48:42', '::1', 'Crear reporte'),
('47', '1', '2022-03-01 09:51:10', '::1', 'Crear reporte'),
('48', '1', '2022-03-01 09:52:51', '::1', 'Crear reporte'),
('49', '1', '2022-03-01 09:59:28', '::1', 'Crear reporte'),
('50', '1', '2022-03-01 10:02:44', '::1', 'Crear reporte'),
('51', '1', '2022-03-02 15:19:01', '192.168.43.1', 'Login'),
('52', '1', '2022-03-02 15:20:07', '192.168.43.1', 'Crear reporte'),
('53', '1', '2022-03-17 09:54:05', '127.0.0.1', 'Login'),
('54', '1', '2022-03-17 10:03:37', '192.168.137.246', 'Login'),
('55', '1', '2022-03-17 10:03:41', '192.168.137.145', 'Login'),
('56', '1', '2022-03-17 10:04:35', '192.168.137.128', 'Login'),
('57', '1', '2022-03-17 10:04:49', '192.168.137.61', 'Login'),
('58', '1', '2022-03-17 10:06:19', '192.168.137.52', 'Login'),
('59', '1', '2022-03-31 13:27:40', '::1', 'Login'),
('60', '1', '2022-03-31 13:47:02', '::1', 'Crear reporte'),
('61', '1', '2022-03-31 13:49:42', '::1', 'Insertar tipo de acción'),
('62', '1', '2022-03-31 13:52:13', '::1', 'Insertar objetivo entidad'),
('63', '1', '2022-03-31 13:52:23', '::1', 'Crear reporte'),
('64', '1', '2022-03-31 13:54:06', '::1', 'Insertar objetivo entidad'),
('65', '1', '2022-03-31 13:54:16', '::1', 'Crear reporte'),
('66', '1', '2022-04-26 11:32:15', '::1', 'Login'),
('67', '1', '2022-04-26 11:39:50', '::1', 'Salvar Database'),
('68', '1', '2022-04-26 11:42:47', '::1', 'Salvar Database'),
('69', '1', '2022-10-31 12:04:34', '127.0.0.1', 'Login');

            
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
('20220210192915', '2022-02-10 19:29:39'),
('20221028142111', '2022-10-28 14:21:57');

            
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                
--
-- Volcado de datos para la tabla 'objetivo_entidad'
--

INSERT INTO `objetivo_entidad` (`id`, `entidad_id`, `objetivo_id`, `acciones_id`, `deficiencias`, `recomendaciones`, `seguimiento`, `activo`) VALUES 
('1', '2', '17', '5', '-', '-', '-', '1'),
('2', '2', '16', '5', '-', '-', '-', '1'),
('3', '1', '9', '5', 'No se evidenció ....', 'Nada realizado', 'no', '1'),
('4', '2', '14', '4', 'No se cuida la vida submarina', 'No botar desperdicios al mar', 'No hay seguimiento', '1');

            
-- 
-- Vaciado de tabla 'pam'
-- 
DROP TABLE IF EXISTS `pam`;
                        
--
-- Estructura de tabla para la tabla 'pam'
--

CREATE TABLE `pam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resultados_esperados` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                
--
-- Volcado de datos para la tabla 'tipo_accion'
--

INSERT INTO `tipo_accion` (`id`, `nombre`, `activo`) VALUES 
('1', 'Auditoría Financiera', '1'),
('2', 'Auditoría de Cumplimiento', '1'),
('3', 'Auditoría Forense', '1'),
('4', 'Auditoría de Desempeño', '1'),
('5', 'Auditoría Fiscal', '1');

            
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