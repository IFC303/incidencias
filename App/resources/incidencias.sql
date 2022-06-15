-- ALTER USER 'root'@'%' IDENTIFIED WITH mysql_native_password BY 'toor';  

DROP SCHEMA IF EXISTS incidencias;
CREATE SCHEMA incidencias;
use incidencias;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_borrar_usuario` (IN `xusu_id` INT)  BEGIN
	UPDATE usuarios 
	SET 
		est='0',
		fech_elim = now() 
	where usu_id=xusu_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cerrar_incidencia` (IN `xincidencia_id` INT, IN `xusu_id` INT)  BEGIN
	INSERT INTO incidenciasdetalle 
    (incid_id,incidencia_id,usu_id,incid_descrip,fech_crea,est) 
    VALUES 
    (NULL,xincidencia_id,xusu_id,'incidencia cerrada...',now(),'1');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_obtener_usuarios` ()  BEGIN
	SELECT * FROM usuarios where est='1';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_obtener_usuario` (IN `xusu_id` INT)  BEGIN
	SELECT * FROM usuarios where usu_id=xusu_id;
END$$

DELIMITER ;


CREATE TABLE `documentos` (
  `doc_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `incidencia_id` int(11) NOT NULL,
  `doc_nom` varchar(400) COLLATE utf8_spanish_ci NOT NULL,
  `fech_crea` datetime NOT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `incidenciasdetalle` (
  `incid_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `incidencia_id` int(11) NOT NULL,
  `usu_id` int(11) NOT NULL,
  `incid_descrip` mediumtext COLLATE utf8_spanish_ci NOT NULL,
  `fech_crea` datetime NOT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `departamentos` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cat_nom` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `departamentos` (`cat_id`, `cat_nom`, `est`) VALUES
(1, 'Informática', 1),
(2, 'Electrónica', 1),
(3, 'Enfermería', 1),
(4, 'Mecánica', 1);

CREATE TABLE `incidencias` (
  `incidencia_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `usu_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `incidencia_titulo` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `incidencia_descrip` mediumtext COLLATE utf8_spanish_ci NOT NULL,
  `incidencia_estado` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fech_crea` datetime DEFAULT NULL,
  `usu_asig` int(11) DEFAULT NULL,
  `fech_asig` datetime DEFAULT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `usuarios` (
  `usu_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `usu_nom` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usu_ape` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usu_correo` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `usu_pass` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `fech_crea` datetime DEFAULT NULL,
  `fech_modi` datetime DEFAULT NULL,
  `fech_elim` datetime DEFAULT NULL,
  `est` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `usuarios` (`usu_id`, `usu_nom`, `usu_ape`, `usu_correo`, `usu_pass`, `rol_id`, `fech_crea`, `fech_modi`, `fech_elim`, `est`) VALUES
(1, 'Jonathan', 'Profesor', 'jonathanprofesor@gmail.com', '202cb962ac59075b964b07152d234b70', 1, '2022-05-01 10:00:00', NULL, NULL, 1),
(2, 'Borja', ' Técnico', 'borjatecnico@gmail.com', '202cb962ac59075b964b07152d234b70', 2, '2022-05-01 10:00:00', NULL, NULL, 1);

COMMIT;