

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO sistema VALUES("1","Pagos","1");
INSERT INTO sistema VALUES("2","Reembolsos","1");
INSERT INTO sistema VALUES("3","Reparaciones","2");



CREATE TABLE `ticket` (
  `idTicket` int(6) NOT NULL AUTO_INCREMENT,
  `user_id` int(5) NOT NULL,
  `id_admin` int(5) DEFAULT NULL,
  `unique_key` varchar(90) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO ticket VALUES("1","1","","oztU9AvxbWsWy-LNxJSzGJKoaHH5CwTCCRBIhm77fkVKybG/Ql5QevMzNMl6z/0dQ1N1J6C1amL0YtYN2pYcPt_/zZ","2020-06-17 20:32:59","2","179.14.6.51","Chrome","Reembolso a cuenta ahorros 3205114512","Buenas.<br />
<br />
Requiero por favor que me hagan un reembolso a mi cuenta de ahorros puesto que adquirí un objeto en su tienda que yo ya había devuelto ya que no me gustó.<br />
<br />
Gracias. Juancho.","0","0","0");
INSERT INTO ticket VALUES("2","4","","","2020-06-17 20:38:56","3","179.14.6.51","Chrome","Se me dañó mi celular","Buenas<br />
<br />
Necesito que por favor revisen mi teléfono móvil, se me cayó y ya no prende. Lo envíe por coordinadora hacía sus instalaciones, el radicado es 1452639872","0","0","0");
INSERT INTO ticket VALUES("3","4","","","2020-06-17 20:42:13","1","179.14.6.51","Chrome","Pago en línea 5698","Ayer pagué por la tienda web y aún no me llega la confirmación de mi compra.<br />
<br />
¿Pueden ayudarme?","0","0","0");
INSERT INTO ticket VALUES("4","3","","","2020-06-17 22:45:08","3","179.14.6.51","Chrome","Buenas, se me quemó el celacho.","Buenas tardes.<br />
<br />
Es que dejé caer el celular por andar pegada viendo vídeos de recetas y hasta ahí llegó. ¿Podrían solucionarlo? Gracias.","0","0","0");
INSERT INTO ticket VALUES("5","1","","","2020-06-17 23:12:56","3","179.14.6.51","Chrome","Buenas, como están","Hola, necesito ayuda","0","0","0");
INSERT INTO ticket VALUES("6","1","","","2020-06-18 16:08:12","1","179.14.6.51","Chrome","No puedo solventar un error en mi teléfono","Prohibir solo lo hacen los que quieren controlar a la pareja porque en el fondo tienen miedo a que les dejen por otros. ??<br />
??<br />
Es un mecanismo de protección de una persona insegura y con un ego frágil que siente la necesidad de controlar todo lo que le rodea para mantener su relativo sentimiento de seguridad y confort.??<br />
??<br />
Todo aquello que se escape a su control le genera ansiedad, porque en el fondo sabe que lo que hagan otras personas con su libertad no depende de él y eso podría poner en peligro su seguridad y su relación y después lamentarse de que no hizo nada para prevenirlo o impedirlo. ??<br />
??<br />
Si quieren dejar de ser celosos, inseguros, dejar de temer de cualquier chico que se le acerca tienen que eliminar su ego. ??","0","0","0");
INSERT INTO ticket VALUES("7","1","","","2020-07-16 10:19:07","1","179.14.6.51","Chrome","No puedo realizar pago por Paypal","Buenas. Espero que estén bien.<br />
<br />
Lo que pasa es que tengo mi tarjeta de crédito mastercard y no puedo realizar el enlace de pagos. ¿Podrían ayudarme? Gracias!","0","0","0");
INSERT INTO ticket VALUES("9","6","","","2020-07-16 15:10:50","3","179.14.6.51","Chrome","No funciona mi touch","Buenas. El problema es que desde ayer dejó de funcionar el Touch ID de mi iPhone 6 y lo necesito para desbloquearlo, porque se desbloquea con la huella.<br />
<br />
¿Hay posibilidad de que efectuen el cambio hoy mismo?","0","0","0");
INSERT INTO ticket VALUES("10","6","","","2020-07-16 15:12:06","2","179.14.6.51","Chrome","Reembolsar dinero sobre compra","Buenas, necesito que me devuelvan mis 80 lukas pirobos hptas","0","0","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO usuario VALUES("1","Juan Andrés","Pérez","japerez972@misena.edu.co","$2y$10$IjGhLEBjv9da26ExT2PqVOfDUVguZdWkGa4QEFTTfVvAt2Lt5aOYG","3","2020-05-25 01:53:53","2");
INSERT INTO usuario VALUES("2","Laura","Pérez","lauraperez2911@uco.edu.co","$2y$10$Shfi12H.PB9aZ6VJau8P9.mUW7gWbAIoR5DT2eb1nMmLpRHNKOGjO","1","2020-05-25 01:55:34","1");
INSERT INTO usuario VALUES("3","Marcela","Trejos","marcela0771@hotmail.com","$2y$10$quUx5do.ZSQ8VC3aOMl0ROKOu2kM7GxCjWPQVKW3VTza9MHVHzAxa","1","2020-05-29 14:46:58","1");
INSERT INTO usuario VALUES("4","María José","Arango","majoarango@gmail.com","$2y$10$wjdW3OjiVXZN6FyBVxJ1F.QK2SBNY83/uSPH2BseRx5f69q.l7Yf2","1","2020-05-29 15:02:31","1");
INSERT INTO usuario VALUES("5","Sebastián","Flórez","sebastian.florezp@udea.edu.co","$2y$10$c2gujsHbyXNj1qpaubMI1u5EOXeyET7yBvArBpvkBZLHnZplT5mPe","1","2020-05-30 13:34:31","2");
INSERT INTO usuario VALUES("6","Erica","Osorio","ericaosorio@gmail.com","$2y$10$9ob6jrpMGJdF/Jy.II5SxOvBLH44WZeBmBqllXX8n55t/WUJ7Tn1G","1","2020-07-16 15:09:30","1");

