-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 25-02-2022 a las 10:39:23
-- Versión del servidor: 8.0.28-0ubuntu0.20.04.3
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_coches`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coches`
--

CREATE TABLE `coches` (
  `id` int NOT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `descripcion` text,
  `año` int DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `fecha_alta` datetime DEFAULT NULL,
  `fecha_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `marca_id` int DEFAULT NULL,
  `propietario` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `coches`
--

INSERT INTO `coches` (`id`, `modelo`, `descripcion`, `año`, `activo`, `fecha_alta`, `fecha_modificacion`, `marca_id`, `propietario`) VALUES
(1, '190E', 'esto es la descripcion', 1990, 1, NULL, '2022-02-24 12:14:52', 2, 'albert@gmail.com'),
(2, '911 Turbo II', 'esto es la descripcion', 1990, 1, NULL, '2022-02-25 09:35:38', 6, 'albert@gmail.com'),
(3, 'A3', 'esto es la descripcion', 1990, 1, NULL, '2022-02-24 12:14:33', 4, 'albert@gmail.com'),
(4, 'Boxster 718', 'Roadster', 1990, 1, NULL, '2022-02-24 12:15:51', 6, 'albert@gmail.com'),
(5, 'Cayman 718', 'esto es la descripcion', 1990, 1, NULL, '2022-02-24 12:16:21', 6, 'albert@gmail.com'),
(6, '318 E30', 'esto es la descripcion', 1990, 1, NULL, '2022-02-24 12:16:56', 3, 'albert@gmail.com'),
(7, 'Quattro', 'Coche de rally', 1987, 1, NULL, '2022-02-24 12:17:37', 4, 'albert@gmail.com'),
(12, 'Ibiza', 'esto es un seat', 19900, 1, NULL, '2022-02-24 12:19:19', 5, 'albert@gmail.com'),
(16, 'M3', 'bmw M3', 1998, 1, '2022-02-22 10:59:06', '2022-02-22 09:59:06', 3, ''),
(17, 'SLS-AMG', 'aaaaa', 123, 1, '2022-02-22 11:00:49', '2022-02-25 09:29:54', 2, 'albert@gmail.com'),
(18, 'SL-500', 'descripcion cambiada', 1990, 1, '2022-02-22 12:15:10', '2022-02-25 09:30:36', 2, 'albert@gmail.com'),
(19, 'M-135 I', 'probando', 2018, 1, '2022-02-22 12:32:03', '2022-02-25 09:33:11', 3, 'albert@gmail.com'),
(23, 'ML-500', 'hola', 1900, 1, '2022-02-22 12:50:17', '2022-02-25 09:32:03', 2, 'albert@gmail.com'),
(24, 'Taycan Turbo', 'esto es un seat', 9000, 1, '2022-02-23 10:48:12', '2022-02-25 09:32:29', 6, 'albert@gmail.com'),
(26, 'A4', 'descripcion', 1990, 0, '2022-02-23 11:17:09', '2022-02-25 09:29:18', 4, 'albert@gmail.com'),
(27, 'Golf', 'WV Golf 1.9 Turbo', 2002, 1, '2022-02-24 13:13:10', '2022-02-24 12:13:10', 5, 'albert@gmail.com'),
(28, '2002 Turbo TII', 'BMW 2002', 1970, 1, '2022-02-25 10:34:14', '2022-02-25 09:34:14', 3, 'albert@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220222091052', '2022-02-22 10:11:49', 53),
('DoctrineMigrations\\Version20220222091329', '2022-02-22 10:13:41', 73),
('DoctrineMigrations\\Version20220222093744', '2022-02-22 10:40:23', 10),
('DoctrineMigrations\\Version20220222094010', '2022-02-22 10:40:23', 0),
('DoctrineMigrations\\Version20220222094806', '2022-02-22 10:48:14', 132),
('DoctrineMigrations\\Version20220222101335', '2022-02-22 11:13:46', 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` text,
  `activo` tinyint(1) DEFAULT NULL,
  `fecha_alta` datetime DEFAULT NULL,
  `fecha_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre`, `descripcion`, `activo`, `fecha_alta`, `fecha_modificacion`) VALUES
(1, 'Nueva marca', 'esta es la descripcion', 1, '2022-02-22 09:44:02', '2022-02-22 08:44:02'),
(2, 'Mercedes-Benz', 'mercedes.', 1, '2022-02-22 10:49:23', '2022-02-22 09:49:23'),
(3, 'BMW', 'marca bmw', 1, '2022-02-22 10:49:38', '2022-02-22 09:49:38'),
(4, 'Audi', 'audi', 1, '2022-02-22 10:49:47', '2022-02-22 09:49:47'),
(5, 'Volkswagen', 'marca alemana', 1, '2022-02-24 13:11:52', '2022-02-24 12:11:52'),
(6, 'Porsche', 'marca alemana', 1, '2022-02-24 13:14:06', '2022-02-24 12:14:06'),
(7, 'nosale', 'no debe salir', 0, '2022-02-25 10:27:46', '2022-02-25 09:27:46');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `coches`
--
ALTER TABLE `coches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9A1141DA81EF0041` (`marca_id`);

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `coches`
--
ALTER TABLE `coches`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `coches`
--
ALTER TABLE `coches`
  ADD CONSTRAINT `FK_9A1141DA81EF0041` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
