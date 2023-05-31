/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.24-MariaDB : Database - servicio_hotel
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`servicio_hotel` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `servicio_hotel`;

/*Table structure for table `alquiler` */

DROP TABLE IF EXISTS `alquiler`;

CREATE TABLE `alquiler` (
  `idalquiler` INT(11) NOT NULL AUTO_INCREMENT,
  `idhabitacion` INT(11) NOT NULL,
  `idcliente` INT(11) NOT NULL,
  `idusuario` INT(11) NOT NULL,
  `horaentrada` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `horasalida` DATETIME DEFAULT NULL,
  `observaciones` VARCHAR(150) DEFAULT NULL,
  `pago` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`idalquiler`),
  KEY `fk_alq_hab` (`idhabitacion`),
  KEY `fk_alq_cli` (`idcliente`),
  KEY `fk_alq_usu` (`idusuario`),
  CONSTRAINT `fk_alq_cli` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`),
  CONSTRAINT `fk_alq_hab` FOREIGN KEY (`idhabitacion`) REFERENCES `habitacion` (`idhabitacion`),
  CONSTRAINT `fk_alq_usu` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`)
) ENGINE=INNODB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `alquiler` */

INSERT  INTO `alquiler`(`idalquiler`,`idhabitacion`,`idcliente`,`idusuario`,`horaentrada`,`horasalida`,`observaciones`,`pago`) VALUES 
(4,1,1,1,'2023-05-29 11:31:33',NULL,'.......','efectivo'),
(5,2,3,1,'2023-05-29 11:31:33',NULL,'','efectivo'),
(6,1,3,1,'2023-05-29 11:31:33',NULL,'.......','transferencia'),
(7,1,3,0,'2023-05-29 11:32:43',NULL,NULL,'efectivo');

/*Table structure for table `clientes` */

DROP TABLE IF EXISTS `clientes`;

CREATE TABLE `clientes` (
  `idcliente` INT(11) NOT NULL AUTO_INCREMENT,
  `apellidos` VARCHAR(100) NOT NULL,
  `nombres` VARCHAR(100) NOT NULL,
  `tipo_documento` VARCHAR(20) NOT NULL,
  `num_documento` VARCHAR(15) NOT NULL,
  `telefono` CHAR(9) NOT NULL,
  PRIMARY KEY (`idcliente`),
  UNIQUE KEY `uk_num_doc_cli` (`tipo_documento`,`num_documento`),
  UNIQUE KEY `uk_telefono_cli` (`telefono`)
) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `clientes` */

INSERT  INTO `clientes`(`idcliente`,`apellidos`,`nombres`,`tipo_documento`,`num_documento`,`telefono`) VALUES 
(1,'Quiroz Ccaulla','Alex Edú','DNI','72680725','959282307'),
(2,'Gonzales Perez','Stuart','DNI','652365415','965346587'),
(3,'Garcia Lopez','Edison','CE','000215365','959264541');

/*Table structure for table `habitacion` */

DROP TABLE IF EXISTS `habitacion`;

CREATE TABLE `habitacion` (
  `idhabitacion` INT(11) NOT NULL AUTO_INCREMENT,
  `numhabitacion` VARCHAR(3) NOT NULL,
  `costo` DECIMAL(5,2) NOT NULL,
  `idtipo` INT(11) NOT NULL,
  `estado` CHAR(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idhabitacion`),
  UNIQUE KEY `uk_num_hab` (`numhabitacion`),
  KEY `fk_tip_hab` (`idtipo`),
  CONSTRAINT `fk_tip_hab` FOREIGN KEY (`idtipo`) REFERENCES `tipohabitacion` (`idtipo`)
) ENGINE=INNODB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `habitacion` */

INSERT  INTO `habitacion`(`idhabitacion`,`numhabitacion`,`costo`,`idtipo`,`estado`) VALUES 
(1,'001',30.00,1,'1'),
(2,'002',50.00,3,'1'),
(3,'003',40.00,2,'1'),
(4,'004',30.00,1,'1');

/*Table structure for table `tipohabitacion` */

DROP TABLE IF EXISTS `tipohabitacion`;

CREATE TABLE `tipohabitacion` (
  `idtipo` INT(11) NOT NULL AUTO_INCREMENT,
  `tipohabitacion` VARCHAR(30) NOT NULL,
  `descripcion` VARCHAR(200) DEFAULT NULL,
  PRIMARY KEY (`idtipo`),
  UNIQUE KEY `uk_tipo_habi` (`tipohabitacion`)
) ENGINE=INNODB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tipohabitacion` */

INSERT  INTO `tipohabitacion`(`idtipo`,`tipohabitacion`,`descripcion`) VALUES 
(1,'Individual','Una habitación asignada a una persona'),
(2,'Doble','Una habitación asignada a dos personas'),
(3,'Triple','Una habitación asignada a tres personas'),
(4,'Quad','Una sala asignada a cuatro personas'),
(5,'Queen','Una habitación con una cama de matrimonio'),
(6,'King','Una habitación con una cama king-size');

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `idusuario` INT(11) NOT NULL AUTO_INCREMENT,
	nombre VARCHAR(50) NOT NULL,
	apellidos VARCHAR(30) NOT NULL,
	correo VARCHAR(50) NOT NULL,
	clave VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idusuario`)
  
) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `usuario` */

INSERT  INTO `usuario`(nombre, apellidos, correo, clave) VALUES 
('Edu','Quiroz','eduqcc08@gmail.com', '123456');

SELECT * FROM usuario
/* Procedure structure for procedure `activarpago` */

/*!50003 DROP PROCEDURE IF EXISTS  `activarpago` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `activarpago`(_idalquiler int)
begin
update alquiler set
horasalida = now(),
pago = 'SI'
where alquiler = _idalquiler;
end */$$
DELIMITER ;

/* Procedure structure for procedure `listarhabitacion` */

/*!50003 DROP PROCEDURE IF EXISTS  `listarhabitacion` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `listarhabitacion`()
begin
select habitacion.idhabitacion, habitacion.numhabitacion
from habitacion;
end */$$
DELIMITER ;

/* Procedure structure for procedure `pagoactivar` */

/*!50003 DROP PROCEDURE IF EXISTS  `pagoactivar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `pagoactivar`(_idalquiler INT)
BEGIN
UPDATE alquiler SET
	horasalida = NOW(),
	pago = 'SI'
	
	WHERE	idalquiler = _idalquiler;
	END */$$
DELIMITER ;

/* Procedure structure for procedure `spu_alquiler_buscar` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_alquiler_buscar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_alquiler_buscar`(IN _numhabitacion varchar(3))
BEGIN
SELECT habitacion.idhabitacion, habitacion.numhabitacion,
			 clientes.`apellidos`, clientes.`nombres`,
			 alquiler.`horaentrada`, alquiler.`horasalida`, habitacion.costo, alquiler.pago
			 FROM alquiler
				inner JOIN habitacion ON habitacion.idhabitacion= alquiler.idhabitacion
			 inner JOIN clientes	ON clientes.`idcliente` = alquiler.`idcliente`
			 WHERE alquiler.idhabitacion= _numhabitacion
			 ORDER BY alquiler.idhabitacion DESC;
END */$$
DELIMITER ;

/* Procedure structure for procedure `spu_alquiler_listar` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_alquiler_listar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_alquiler_listar`()
begin
	select  alquiler.idalquiler, habitacion.numhabitacion,
			 clientes.`apellidos`, clientes.`nombres`,
			 alquiler.`horaentrada`, alquiler.`horasalida`, habitacion.costo, alquiler.`pago`
			 from alquiler
			 inner join habitacion on habitacion.idhabitacion = alquiler.idhabitacion
			 inner join clientes		on clientes.`idcliente` = alquiler.`idcliente`
			 order by alquiler.idalquiler desc;
end */$$
DELIMITER ;

/* Procedure structure for procedure `spu_alquiler_registrar` */

/*!50003 DROP PROCEDURE IF EXISTS  `spu_alquiler_registrar` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `spu_alquiler_registrar`(
in _idhabitacion int,
in _idcliente int,
in _idusuario int,
in _pago varchar(15)

)
begin

insert into alquiler(idhabitacion, idcliente, idusuario, pago) values
(_idhabitacion, _idcliente, idusuario, _pago );
end */$$


DELIMITER $$
CREATE PROCEDURE  spu_user_login(IN _correo VARCHAR(50))
BEGIN
	SELECT correo, nombre, apellidos, clave
	FROM usuario
	WHERE correo = _correo;
END $$
	
	CALL spu_user_login('eduqcc08@gmail.com')

SELECT * FROM usuario


