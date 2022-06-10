

CREATE TABLE `acciones` (
  `idTicket` int(6) NOT NULL,
  `user_id` int(5) NOT NULL,
  `accion` varchar(100) NOT NULL,
  `fechaAccion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `FK_acciones_ticket` (`idTicket`),
  KEY `FK_acciones_usuario` (`user_id`),
  CONSTRAINT `FK_acciones_ticket` FOREIGN KEY (`idTicket`) REFERENCES `ticket` (`idTicket`),
  CONSTRAINT `FK_acciones_usuario` FOREIGN KEY (`user_id`) REFERENCES `usuario` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `departamento` (
  `idDepartamento` int(2) NOT NULL AUTO_INCREMENT,
  `departamento` varchar(50) NOT NULL,
  PRIMARY KEY (`idDepartamento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO departamento VALUES("1","Ventas");
INSERT INTO departamento VALUES("2","Técnico");



CREATE TABLE `genero` (
  `id_genero` int(2) NOT NULL AUTO_INCREMENT,
  `genero` varchar(20) NOT NULL,
  PRIMARY KEY (`id_genero`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO genero VALUES("1","Mujer");
INSERT INTO genero VALUES("2","Hombre");
INSERT INTO genero VALUES("3","Sin especificar");



CREATE TABLE `respuestasTicket` (
  `idRespuesta` int(7) NOT NULL AUTO_INCREMENT,
  `idTicket` int(6) NOT NULL,
  `user_id` int(5) NOT NULL,
  `esAdmin` int(1) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `fechaRespuesta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idRespuesta`),
  KEY `FK_respuestasTicket_ticket` (`idTicket`),
  KEY `FK_respuestasTicket_usuario` (`user_id`),
  CONSTRAINT `FK_respuestasTicket_ticket` FOREIGN KEY (`idTicket`) REFERENCES `ticket` (`idTicket`),
  CONSTRAINT `FK_respuestasTicket_usuario` FOREIGN KEY (`user_id`) REFERENCES `usuario` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `roles` (
  `idRol` int(2) NOT NULL AUTO_INCREMENT,
  `tipoCuenta` varchar(30) NOT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO roles VALUES("1","Usuario");
INSERT INTO roles VALUES("2","Equipo Soporte Técnico");
INSERT INTO roles VALUES("3","Administrador");



CREATE TABLE `sistema` (
  `idSistema` int(2) NOT NULL AUTO_INCREMENT,
  `sistema` varchar(40) NOT NULL,
  `idDepartamento` int(2) NOT NULL,
  PRIMARY KEY (`idSistema`),
  KEY `FK_sistema_departamento` (`idDepartamento`),
  CONSTRAINT `FK_sistema_departamento` FOREIGN KEY (`idDepartamento`) REFERENCES `departamento` (`idDepartamento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO sistema VALUES("1","Pagos","1");
INSERT INTO sistema VALUES("2","Reembolsos","1");



CREATE TABLE `ticket` (
  `idTicket` int(6) NOT NULL AUTO_INCREMENT,
  `user_id` int(5) NOT NULL,
  `id_admin` int(5) NOT NULL,
  `fechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sistema` int(2) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `navegador` varchar(30) NOT NULL,
  `asunto` varchar(70) NOT NULL,
  `descripcion` text NOT NULL,
  `prioridad` int(1) NOT NULL,
  `estadoTicket` int(1) NOT NULL,
  `ultimaRespuestaId` int(7) NOT NULL,
  PRIMARY KEY (`idTicket`),
  KEY `FK_ticket_usuario` (`user_id`),
  KEY `FK1_ticket_usuario` (`id_admin`),
  KEY `FK_ticket_sistema` (`sistema`),
  CONSTRAINT `FK1_ticket_usuario` FOREIGN KEY (`id_admin`) REFERENCES `usuario` (`user_id`),
  CONSTRAINT `FK_ticket_sistema` FOREIGN KEY (`sistema`) REFERENCES `sistema` (`idSistema`),
  CONSTRAINT `FK_ticket_usuario` FOREIGN KEY (`user_id`) REFERENCES `usuario` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `usuario` (
  `user_id` int(5) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(40) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `correo` varchar(70) NOT NULL,
  `pw` varchar(255) NOT NULL,
  `tipoCuenta` int(2) NOT NULL DEFAULT '1',
  `fechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idGenero` int(2) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `FK_usuario_roles` (`tipoCuenta`),
  KEY `FK_usuario_genero` (`idGenero`),
  CONSTRAINT `FK_usuario_genero` FOREIGN KEY (`idGenero`) REFERENCES `genero` (`id_genero`),
  CONSTRAINT `FK_usuario_roles` FOREIGN KEY (`tipoCuenta`) REFERENCES `roles` (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO usuario VALUES("1","Juan Andrés","Pérez","japerez972@misena.edu.co","$2y$10$IjGhLEBjv9da26ExT2PqVOfDUVguZdWkGa4QEFTTfVvAt2Lt5aOYG","1","2020-05-25 01:53:53","2");
INSERT INTO usuario VALUES("2","Laura","Pérez","lauraperez2911@uco.edu.co","$2y$10$Shfi12H.PB9aZ6VJau8P9.mUW7gWbAIoR5DT2eb1nMmLpRHNKOGjO","1","2020-05-25 01:55:34","1");

