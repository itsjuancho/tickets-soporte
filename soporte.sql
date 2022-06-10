-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-07-2020 a las 01:04:07
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `soporte`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones`
--

CREATE TABLE `acciones` (
  `idTicket` int(6) NOT NULL,
  `user_id` int(5) NOT NULL,
  `accion` varchar(100) NOT NULL,
  `fechaAccion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `idDepartamento` int(2) NOT NULL,
  `departamento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `id_genero` int(2) NOT NULL,
  `genero` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`id_genero`, `genero`) VALUES
(1, 'Mujer'),
(2, 'Hombre'),
(3, 'Sin especificar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestasTicket`
--

CREATE TABLE `respuestasTicket` (
  `idRespuesta` int(7) NOT NULL,
  `idTicket` int(6) NOT NULL,
  `user_id` int(5) NOT NULL,
  `esAdmin` int(1) NOT NULL DEFAULT '0',
  `respuesta` varchar(1000) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `fechaRespuesta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRol` int(2) NOT NULL,
  `tipoCuenta` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idRol`, `tipoCuenta`) VALUES
(1, 'Usuario'),
(2, 'Equipo Soporte Técnico'),
(3, 'Supervisor'),
(4, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sistema`
--

CREATE TABLE `sistema` (
  `idSistema` int(2) NOT NULL,
  `sistema` varchar(40) NOT NULL,
  `idDepartamento` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket`
--

CREATE TABLE `ticket` (
  `idTicket` int(6) NOT NULL,
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
  `ultimaRespuestaId` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `user_id` int(5) NOT NULL,
  `nombres` varchar(40) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `correo` varchar(70) NOT NULL,
  `pw` varchar(255) NOT NULL,
  `tipoCuenta` int(2) NOT NULL DEFAULT '1',
  `fechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idGenero` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`user_id`, `nombres`, `apellidos`, `correo`, `pw`, `tipoCuenta`, `fechaRegistro`, `idGenero`) VALUES
(1, 'Juan Andrés', 'Pérez', 'contacto@juanchoo.com', '$2y$10$IjGhLEBjv9da26ExT2PqVOfDUVguZdWkGa4QEFTTfVvAt2Lt5aOYG', 4, '2020-05-25 06:53:53', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acciones`
--
ALTER TABLE `acciones`
  ADD KEY `FK_acciones_ticket` (`idTicket`),
  ADD KEY `FK_acciones_usuario` (`user_id`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`idDepartamento`);

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`id_genero`);

--
-- Indices de la tabla `respuestasTicket`
--
ALTER TABLE `respuestasTicket`
  ADD PRIMARY KEY (`idRespuesta`),
  ADD KEY `FK_respuestasTicket_ticket` (`idTicket`),
  ADD KEY `FK_respuestasTicket_usuario` (`user_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `sistema`
--
ALTER TABLE `sistema`
  ADD PRIMARY KEY (`idSistema`),
  ADD KEY `FK_sistema_departamento` (`idDepartamento`);

--
-- Indices de la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`idTicket`),
  ADD KEY `FK_ticket_usuario` (`user_id`),
  ADD KEY `FK1_ticket_usuario` (`id_admin`),
  ADD KEY `FK_ticket_sistema` (`sistema`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `FK_usuario_roles` (`tipoCuenta`),
  ADD KEY `FK_usuario_genero` (`idGenero`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `idDepartamento` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `id_genero` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `respuestasTicket`
--
ALTER TABLE `respuestasTicket`
  MODIFY `idRespuesta` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idRol` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `sistema`
--
ALTER TABLE `sistema`
  MODIFY `idSistema` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `ticket`
--
ALTER TABLE `ticket`
  MODIFY `idTicket` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acciones`
--
ALTER TABLE `acciones`
  ADD CONSTRAINT `FK_acciones_ticket` FOREIGN KEY (`idTicket`) REFERENCES `ticket` (`idTicket`),
  ADD CONSTRAINT `FK_acciones_usuario` FOREIGN KEY (`user_id`) REFERENCES `usuario` (`user_id`);

--
-- Filtros para la tabla `respuestasTicket`
--
ALTER TABLE `respuestasTicket`
  ADD CONSTRAINT `FK_respuestasTicket_ticket` FOREIGN KEY (`idTicket`) REFERENCES `ticket` (`idTicket`),
  ADD CONSTRAINT `FK_respuestasTicket_usuario` FOREIGN KEY (`user_id`) REFERENCES `usuario` (`user_id`);

--
-- Filtros para la tabla `sistema`
--
ALTER TABLE `sistema`
  ADD CONSTRAINT `FK_sistema_departamento` FOREIGN KEY (`idDepartamento`) REFERENCES `departamento` (`idDepartamento`);

--
-- Filtros para la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `FK1_ticket_usuario` FOREIGN KEY (`id_admin`) REFERENCES `usuario` (`user_id`),
  ADD CONSTRAINT `FK_ticket_sistema` FOREIGN KEY (`sistema`) REFERENCES `sistema` (`idSistema`),
  ADD CONSTRAINT `FK_ticket_usuario` FOREIGN KEY (`user_id`) REFERENCES `usuario` (`user_id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_usuario_genero` FOREIGN KEY (`idGenero`) REFERENCES `genero` (`id_genero`),
  ADD CONSTRAINT `FK_usuario_roles` FOREIGN KEY (`tipoCuenta`) REFERENCES `roles` (`idRol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
