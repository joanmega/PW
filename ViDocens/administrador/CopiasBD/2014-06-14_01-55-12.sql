DROP DATABASE IF EXISTS vidocens;
CREATE DATABASE vidocens;
USE vidocens;

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS copia;

CREATE TABLE `copia` (
  `cod_copia` int(11) NOT NULL AUTO_INCREMENT,
  `FechaCopia` datetime NOT NULL,
  `RutaCopia` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `Actual` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`cod_copia`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

INSERT INTO copia VALUES("1","2014-06-14 01:55:11","../CopiasBD/2014-06-14 01:55:11.sql","0");
INSERT INTO copia VALUES("2","2014-06-14 01:55:12","../CopiasBD/2014-06-14 01:55:12.sql","0");



DROP TABLE IF EXISTS curso;

CREATE TABLE `curso` (
  `Cod_Curso` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` varchar(100) NOT NULL,
  `Creditos` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`Cod_Curso`),
  UNIQUE KEY `Nombre` (`Nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO curso VALUES("1","ABD","Administración de Base de Datos","6.00");
INSERT INTO curso VALUES("2","PW","Programación Web","6.00");
INSERT INTO curso VALUES("3","ALEM","Álgebra lineal y estructuras matemáticas","6.00");
INSERT INTO curso VALUES("4","LMD","Lógicos y métodos discretos","6.00");



DROP TABLE IF EXISTS imparte;

CREATE TABLE `imparte` (
  `Cod_Profesor` int(11) NOT NULL,
  `Cod_curso` int(11) NOT NULL,
  PRIMARY KEY (`Cod_Profesor`,`Cod_curso`),
  KEY `Cod_curso` (`Cod_curso`),
  KEY `Cod_Profesor` (`Cod_Profesor`),
  CONSTRAINT `FK_Imparte_Curso` FOREIGN KEY (`Cod_curso`) REFERENCES `curso` (`Cod_Curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Imparte_Profesor` FOREIGN KEY (`Cod_Profesor`) REFERENCES `profesor` (`Cod_profesor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO imparte VALUES("10","1");
INSERT INTO imparte VALUES("9","2");
INSERT INTO imparte VALUES("11","3");
INSERT INTO imparte VALUES("11","4");
INSERT INTO imparte VALUES("12","4");



DROP TABLE IF EXISTS inscrito;

CREATE TABLE `inscrito` (
  `Cod_Alumno` int(11) NOT NULL,
  `Cod_Curso` int(11) NOT NULL,
  PRIMARY KEY (`Cod_Alumno`,`Cod_Curso`),
  KEY `Cod_Curso` (`Cod_Curso`),
  KEY `Cod_Alumno` (`Cod_Alumno`),
  CONSTRAINT `FK_Inscrito_Curso` FOREIGN KEY (`Cod_Curso`) REFERENCES `curso` (`Cod_Curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Inscrito_Usuario` FOREIGN KEY (`Cod_Alumno`) REFERENCES `usuario` (`Cod_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO inscrito VALUES("14","1");
INSERT INTO inscrito VALUES("15","1");
INSERT INTO inscrito VALUES("16","1");
INSERT INTO inscrito VALUES("13","2");
INSERT INTO inscrito VALUES("15","2");
INSERT INTO inscrito VALUES("16","2");
INSERT INTO inscrito VALUES("13","3");
INSERT INTO inscrito VALUES("14","3");
INSERT INTO inscrito VALUES("16","3");
INSERT INTO inscrito VALUES("13","4");
INSERT INTO inscrito VALUES("14","4");
INSERT INTO inscrito VALUES("16","4");



DROP TABLE IF EXISTS material;

CREATE TABLE `material` (
  `Cod_Material` int(11) NOT NULL AUTO_INCREMENT,
  `Cod_Curso` int(11) NOT NULL,
  `Descripcion` varchar(100) NOT NULL,
  `FechaSubida` datetime NOT NULL,
  `RutaFichero` varchar(255) NOT NULL,
  PRIMARY KEY (`Cod_Material`),
  KEY `Cod_Curso` (`Cod_Curso`),
  CONSTRAINT `FK_Material_Curso` FOREIGN KEY (`Cod_Curso`) REFERENCES `curso` (`Cod_Curso`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

INSERT INTO material VALUES("7","1","Tema 1","2014-06-14 00:00:00","../../material/1/Tema 1.mp4");
INSERT INTO material VALUES("8","1","Tema 2","2014-06-14 00:00:00","../../material/1/Tema 2.mp4");
INSERT INTO material VALUES("9","1","Tema 3","2014-06-14 00:00:00","../../material/1/Tema 3.mp4");
INSERT INTO material VALUES("10","3","Tema 1","2014-06-14 00:00:00","../../material/3/Tema 1.mp4");
INSERT INTO material VALUES("11","3","Tema 2","2014-06-14 00:00:00","../../material/3/Tema 2.mp4");
INSERT INTO material VALUES("12","3","Tema 3","2014-06-14 00:00:00","../../material/3/Tema 3.mp4");
INSERT INTO material VALUES("13","4","Leccion 1","2014-06-14 00:00:00","../../material/4/Leccion 1.mp4");
INSERT INTO material VALUES("14","4","Leccion 2","2014-06-14 00:00:00","../../material/4/Leccion 2.mp4");
INSERT INTO material VALUES("15","2","PHP","2014-06-14 00:00:00","../../material/2/PHP.mp4");
INSERT INTO material VALUES("16","2","HTML","2014-06-14 00:00:00","../../material/2/HTML.mp4");
INSERT INTO material VALUES("17","2","Javascript","2014-06-14 00:00:00","../../material/2/Javascript.mp4");



DROP TABLE IF EXISTS profesor;

CREATE TABLE `profesor` (
  `Cod_profesor` int(11) NOT NULL,
  `extension` varchar(3) DEFAULT NULL,
  `departamento` varchar(50) NOT NULL,
  PRIMARY KEY (`Cod_profesor`),
  KEY `Cod_profesor` (`Cod_profesor`),
  CONSTRAINT `FK_Profesor_Usuario` FOREIGN KEY (`Cod_profesor`) REFERENCES `usuario` (`Cod_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO profesor VALUES("9","0","DECSAI");
INSERT INTO profesor VALUES("10","0","DECSAI");
INSERT INTO profesor VALUES("11","0","evanegelina@ugr.es");
INSERT INTO profesor VALUES("12","0","Algebra");



DROP TABLE IF EXISTS usuario;

CREATE TABLE `usuario` (
  `Cod_Usuario` int(11) NOT NULL AUTO_INCREMENT,
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
  `tipoUsuario` int(11) NOT NULL,
  PRIMARY KEY (`Cod_Usuario`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

INSERT INTO usuario VALUES("1","00000000X","admin","admin","admin","1","","","","0000-00-00","","admin","21232f297a57a5a743894a0e4a801fc3","0");
INSERT INTO usuario VALUES("9","11111111H","Waldo","Fajardo","Contreras","1","0","0","aragorn@ugr.es","1968-12-12","Calle 1","waldo","bafc2467d6f7a6855d58279a2d971151","1");
INSERT INTO usuario VALUES("10","22222222J","Ignacio J.","Blanco","Medina","1","0","0","iblanco@ugr.es","1977-04-17","Calle 2","ignacio","5e612fbcf98d8452ce474c972941439d","1");
INSERT INTO usuario VALUES("11","33333333P","Evangelina","Santos","Aláez","1","0","0","","1967-08-14","Calle 3","evangelina","6d8f6f85712357ed6097a6b3e903bcd1","1");
INSERT INTO usuario VALUES("12","44444444A","Juan Manuel","Urbano","Blanco","1","0","0","jurbano@ugr.es","1947-09-21","Calle 5","juan","a94652aa97c7211ba8954dd15a3cf838","1");
INSERT INTO usuario VALUES("13","75482863Z","José Antonio","Medina","García","1","0","0","josemed@correo.ugr.es","1986-11-04","Mi calle","jose","662eaa47199461d01a623884080934ab","2");
INSERT INTO usuario VALUES("14","55555555K","Lucía","López","Moliné","1","0","0","lucia@correo.ugr.es","1989-07-07","Calle 6","lucia","3ba430337eb30f5fd7569451b5dfdf32","2");
INSERT INTO usuario VALUES("15","66666666Q","Agustín","Ruíz","Pérez","1","0","0","agustin_1203@corrreo.ugr.es","1987-06-12","Calle 7","agustin","4ff413b71217b7b2c3e845c71fc834a9","2");
INSERT INTO usuario VALUES("16","77777777B","Marta","López","Ávila","1","0","0","martita@correo.ugr.es","1991-04-01","Calle 8","marta","a763a66f984948ca463b081bf0f0e6d0","2");



SET FOREIGN_KEY_CHECKS=1;

