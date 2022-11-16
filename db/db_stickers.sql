-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-11-2022 a las 02:29:27
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_stickers`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `figuritas`
--

CREATE TABLE `figuritas` (
  `numero` int(2) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `fk_pais` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `figuritas`
--

INSERT INTO `figuritas` (`numero`, `nombre`, `apellido`, `fk_pais`) VALUES
(1, 'hola', 'argentina', 1),
(2, 'emiliano', 'martinez', 1),
(7, 'nicolas', 'otamendi', 1),
(8, 'cristian', 'romero', 1),
(12, 'leandro', 'paredes', 1),
(14, 'eden', 'hazard', 2),
(18, 'lionel', 'messi', 1),
(21, 'thibaut', 'courtois', 2),
(22, 'thorgan', 'hazard', 2),
(31, 'gabriel', 'jesus', 7),
(32, 'neymar', 'jr', 7),
(33, 'vinicius', 'jr', 7),
(34, 'philippe', 'coutinho', 7),
(35, 'thiago', 'silva', 7),
(36, 'lucas', 'paqueta', 7),
(40, 'justin', 'bijlow', 8),
(41, 'virgil', 'van dijk', 8),
(42, 'cody', 'gakpo', 8),
(43, 'denzel', 'dumfries', 8),
(44, 'arnaut', 'danjuma', 8),
(45, 'steven', 'berhuis', 8),
(56, 'cosme', 'fulanito', 2),
(57, 'cosme', 'messi', 2),
(58, 'cosme', 'rumbita', 2),
(99, 'fulanito', 'hazard', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `selecciones`
--

CREATE TABLE `selecciones` (
  `id_pais` int(2) NOT NULL,
  `pais` varchar(20) NOT NULL,
  `dt` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `selecciones`
--

INSERT INTO `selecciones` (`id_pais`, `pais`, `dt`) VALUES
(1, 'argentina', 'scaloni'),
(2, 'belgica', 'martinez'),
(7, 'brasil', 'tite'),
(8, 'holanda', 'vanGaal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `repetida` tinyint(1) NOT NULL,
  `faltante` tinyint(1) NOT NULL,
  `fk_figurita` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`id`, `repetida`, `faltante`, `fk_figurita`, `fk_user`) VALUES
(7, 1, 0, 18, 4),
(8, 1, 0, 14, 4),
(9, 1, 0, 42, 4),
(10, 1, 0, 35, 4),
(11, 1, 0, 34, 4),
(12, 1, 0, 8, 4),
(13, 0, 1, 21, 4),
(14, 0, 1, 32, 4),
(15, 0, 1, 33, 4),
(16, 0, 1, 40, 4),
(17, 0, 1, 44, 4),
(18, 0, 1, 36, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `user`, `password`) VALUES
(2, 'buenastardes', '$2a$12$Uk1wI./HSgqBgWM.4ZjFC.puvNXEYHygUHo2DlRgEcD9kc4pGj2QO'),
(4, 'user1', '$2a$12$fNvx/3BIw7IfHAvxDvtvHeizxudByC6lhHLywqWUSY8jVrSRkVkGy'),
(5, 'user2', '$2a$12$T7yjBTFJnEIHXxsRVcQIs.T8eD0uFAkS5OdbiDqJnwKcaBF3NAGM2'),
(6, 'user3', '$2a$12$h1NmNEa7KVsODWpYnm7.X.MG5RYt5AlZCgdg0VEmWHfPJNeFpmFeG'),
(7, 'user4', '$2a$12$hH76nbk8XGbU2tKIqGB2peL9FSjIVX4T30ZeWa1PhoxYXOa8gVXqW'),
(8, 'user5', '$2a$12$3x9RZLCxcUMgNoBMJisq1eXL1lCgy8cQTrU8P4hvb9RSyT27.oxeC');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `figuritas`
--
ALTER TABLE `figuritas`
  ADD PRIMARY KEY (`numero`),
  ADD KEY `id_pais` (`fk_pais`);

--
-- Indices de la tabla `selecciones`
--
ALTER TABLE `selecciones`
  ADD PRIMARY KEY (`id_pais`);

--
-- Indices de la tabla `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_figurita` (`fk_figurita`),
  ADD KEY `fk_user` (`fk_user`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `selecciones`
--
ALTER TABLE `selecciones`
  MODIFY `id_pais` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `figuritas`
--
ALTER TABLE `figuritas`
  ADD CONSTRAINT `figuritas_ibfk_1` FOREIGN KEY (`fk_pais`) REFERENCES `selecciones` (`id_pais`);

--
-- Filtros para la tabla `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `status_ibfk_1` FOREIGN KEY (`fk_figurita`) REFERENCES `figuritas` (`numero`),
  ADD CONSTRAINT `status_ibfk_2` FOREIGN KEY (`fk_user`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
