-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2025 a las 22:28:25
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `portivoo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ajedrez_jugadores`
--

CREATE TABLE `ajedrez_jugadores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `curso` varchar(20) NOT NULL,
  `club` varchar(50) DEFAULT NULL,
  `fecha_inscripcion` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_id` int(11) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `estado` enum('pendiente','aprobado','rechazado') DEFAULT 'pendiente',
  `fecha_actualizacion` timestamp NULL DEFAULT NULL,
  `notificado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ajedrez_jugadores`
--

INSERT INTO `ajedrez_jugadores` (`id`, `nombre`, `curso`, `club`, `fecha_inscripcion`, `admin_id`, `observaciones`, `estado`, `fecha_actualizacion`, `notificado`) VALUES
(1, 'Juan Pérez', '10-01', 'Club Ajedrez Escolar', '2025-10-29 12:20:51', 1, NULL, 'aprobado', '2025-10-29 12:20:51', 1),
(2, 'Ana Torres', '11-02', 'Estrategas Elite', '2025-10-29 12:20:51', NULL, NULL, 'pendiente', NULL, 0),
(3, 'juan jose gallo', '11B', 'Real', '2025-11-04 20:58:52', NULL, 'solo', 'pendiente', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `basquetbol_jugadores`
--

CREATE TABLE `basquetbol_jugadores` (
  `id` int(11) NOT NULL,
  `nombre_equipo` varchar(50) NOT NULL,
  `curso` varchar(10) NOT NULL,
  `jugador1` varchar(50) NOT NULL,
  `jugador2` varchar(50) NOT NULL,
  `jugador3` varchar(50) NOT NULL,
  `jugador4` varchar(50) NOT NULL,
  `jugador5` varchar(50) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `estado` enum('pendiente','aprobado','rechazado') DEFAULT 'pendiente',
  `puntos` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `basquetbol_jugadores`
--

INSERT INTO `basquetbol_jugadores` (`id`, `nombre_equipo`, `curso`, `jugador1`, `jugador2`, `jugador3`, `jugador4`, `jugador5`, `fecha_registro`, `estado`, `puntos`) VALUES
(3, 'Tiburones', '10A', 'Andrés Pérez', 'María Gómez', 'Juan Rodríguez', 'Valentina Torres', 'Camilo Rojas', '0000-00-00 00:00:00', 'pendiente', 120),
(4, 'Leones', '11B', 'David Jiménez', 'Sofía Martínez', 'Laura Sánchez', 'Diego Ramírez', 'Natalia López', '0000-00-00 00:00:00', 'aprobado', 98),
(5, 'Águilas', '10C', 'Carlos Fernández', 'Ana Torres', 'Daniel Rojas', 'Isabela Gutiérrez', 'Camila Pérez', '0000-00-00 00:00:00', 'rechazado', 87),
(6, 'Halcones', '11A', 'Sebastián Gómez', 'Lucía Jiménez', 'Mateo Ramírez', 'Sara Morales', 'Fernando Díaz', '0000-00-00 00:00:00', 'pendiente', 105),
(7, 'Panteras', '10B', 'Andrés Martínez', 'Laura Jiménez', 'Juan Rojas', 'Valeria Sánchez', 'Camilo Torres', '0000-00-00 00:00:00', 'aprobado', 112);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp(),
  `respuesta` text DEFAULT NULL,
  `estado` enum('pendiente','respondido') DEFAULT 'pendiente',
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`id`, `nombre`, `email`, `mensaje`, `fecha_envio`, `respuesta`, `estado`, `admin_id`) VALUES
(1, 'cindy', 'cindy@example.com', 'como me inscribo  para los deportes', '2025-10-28 13:44:34', 'hola', 'pendiente', NULL),
(2, 'cindy', 'cindy@gmail.com', 'me parece muy interesante la pagina ', '2025-11-04 20:54:37', NULL, 'pendiente', NULL),
(3, 'cindy', 'cindy@gmail.com', 'me parece muy interesante la pagina ', '2025-11-04 20:55:59', NULL, 'pendiente', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deportes`
--

CREATE TABLE `deportes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `deportes`
--

INSERT INTO `deportes` (`id`, `nombre`, `imagen`, `descripcion`, `fecha_creacion`) VALUES
(1, 'Baloncesto', 'img/Baloncesto1.jpg', 'Deporte de equipo con balón.', '2025-10-28 22:20:19'),
(2, 'Fútbol FIFA', 'img/Futbol.jpg', 'El fútbol tradicional', '2025-10-28 22:20:19'),
(3, 'Voleibol', 'img/Voleibol.jpg', 'Juego de red con balón', '2025-10-28 22:20:19'),
(4, 'Tenis de mesa', 'img/Tenis_de_mesa.jpg', 'Tenis en miniatura', '2025-10-28 22:20:19'),
(5, 'Ajedrez', 'img/Ajedrez.jpg', 'Juego de estrategia de mesa', '2025-10-28 22:20:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `futbol_jugadores`
--

CREATE TABLE `futbol_jugadores` (
  `id` int(11) NOT NULL,
  `nombre_equipo` varchar(50) NOT NULL,
  `curso` varchar(10) NOT NULL,
  `jugador1` varchar(50) NOT NULL,
  `jugador2` varchar(50) NOT NULL,
  `jugador3` varchar(50) NOT NULL,
  `jugador4` varchar(50) NOT NULL,
  `jugador5` varchar(50) NOT NULL,
  `jugador6` varchar(50) NOT NULL,
  `jugador7` varchar(50) NOT NULL,
  `jugador8` varchar(50) NOT NULL,
  `jugador9` varchar(50) NOT NULL,
  `jugador10` varchar(50) NOT NULL,
  `jugador11` varchar(50) NOT NULL,
  `goles` int(11) DEFAULT 0,
  `fecha_registro` datetime NOT NULL,
  `estado` enum('pendiente','aprobado','rechazado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `futbol_jugadores`
--

INSERT INTO `futbol_jugadores` (`id`, `nombre_equipo`, `curso`, `jugador1`, `jugador2`, `jugador3`, `jugador4`, `jugador5`, `jugador6`, `jugador7`, `jugador8`, `jugador9`, `jugador10`, `jugador11`, `goles`, `fecha_registro`, `estado`) VALUES
(2, 'Tigres', '10A', 'Andrés Pérez', 'María Gómez', 'Juan Rodríguez', 'Valentina Torres', 'Camilo Rojas', 'David Jiménez', 'Sofía Martínez', 'Laura Sánchez', 'Diego Ramírez', 'Natalia López', 'Carlos Fernández', 3, '2025-10-01 10:00:00', 'pendiente'),
(3, 'Leones', '11B', 'Sebastián Gómez', 'Lucía Jiménez', 'Mateo Ramírez', 'Sara Morales', 'Fernando Díaz', 'Andrés Martínez', 'Laura Jiménez', 'Juan Rojas', 'Valeria Sánchez', 'Camilo Torres', 'Ana Torres', 5, '2025-10-02 11:30:00', 'aprobado'),
(4, 'Águilas', '10C', 'Daniel Rojas', 'Isabela Gutiérrez', 'Camila Pérez', 'Diego Ramírez', 'Natalia López', 'Carlos Fernández', 'Sofía Martínez', 'Laura Sánchez', 'Mateo Ramírez', 'Sara Morales', 'Fernando Díaz', 2, '2025-10-03 14:15:00', 'rechazado'),
(5, 'Panteras', '11A', 'Andrés Pérez', 'María Gómez', 'Juan Rodríguez', 'Valentina Torres', 'Camilo Rojas', 'David Jiménez', 'Sofía Martínez', 'Laura Sánchez', 'Diego Ramírez', 'Natalia López', 'Carlos Fernández', 4, '2025-10-04 09:45:00', 'pendiente'),
(6, 'Halcones', '10B', 'Sebastián Gómez', 'Lucía Jiménez', 'Mateo Ramírez', 'Sara Morales', 'Fernando Díaz', 'Andrés Martínez', 'Laura Jiménez', 'Juan Rojas', 'Valeria Sánchez', 'Camilo Torres', 'Ana Torres', 6, '2025-10-05 12:20:00', 'aprobado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tenis_jugadores`
--

CREATE TABLE `tenis_jugadores` (
  `id` int(10) UNSIGNED NOT NULL,
  `equipo` varchar(50) NOT NULL,
  `curso` varchar(10) NOT NULL,
  `jugador1` varchar(100) NOT NULL,
  `jugador2` varchar(100) DEFAULT NULL,
  `puntos` int(10) UNSIGNED DEFAULT 0,
  `estado` enum('pendiente','aprobado','rechazado') DEFAULT 'pendiente',
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `admin_id` int(11) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `notificado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tenis_jugadores`
--

INSERT INTO `tenis_jugadores` (`id`, `equipo`, `curso`, `jugador1`, `jugador2`, `puntos`, `estado`, `fecha_registro`, `admin_id`, `observaciones`, `fecha_actualizacion`, `notificado`) VALUES
(1, 'Raquetas Rápidas', '11-01', 'Laura Sánchez', 'María López', 12, 'pendiente', '2025-10-29 07:20:51', 1, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','student') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`, `created_at`) VALUES
(1, 'cindy', 'cindy@example.com', 'e10adc3949ba59abbe56e057f20f883e', 'admin', '2025-10-28 15:35:12'),
(2, 'barrera', 'barrera@example.com', 'e10adc3949ba59abbe56e057f20f883e', 'student', '2025-10-29 12:22:35'),
(3, 'juan jose gallo', 'juangallov@iesanjuanbautista.edu.co', 'f5737d25829e95b9c234b7fa06af8736', 'student', '2025-11-04 20:56:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voleibol_jugadores`
--

CREATE TABLE `voleibol_jugadores` (
  `id` int(11) NOT NULL,
  `equipo` varchar(100) NOT NULL,
  `curso` varchar(50) NOT NULL,
  `jugador1` varchar(100) NOT NULL,
  `jugador2` varchar(100) DEFAULT NULL,
  `jugador3` varchar(100) DEFAULT NULL,
  `jugador4` varchar(100) DEFAULT NULL,
  `jugador5` varchar(100) DEFAULT NULL,
  `jugador6` varchar(100) DEFAULT NULL,
  `jugador7` varchar(100) DEFAULT NULL,
  `jugador8` varchar(100) DEFAULT NULL,
  `jugador9` varchar(100) DEFAULT NULL,
  `jugador10` varchar(100) DEFAULT NULL,
  `jugador11` varchar(100) DEFAULT NULL,
  `puntos` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','aprobado','rechazado') DEFAULT 'pendiente',
  `admin_id` int(11) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `notificado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `voleibol_jugadores`
--

INSERT INTO `voleibol_jugadores` (`id`, `equipo`, `curso`, `jugador1`, `jugador2`, `jugador3`, `jugador4`, `jugador5`, `jugador6`, `jugador7`, `jugador8`, `jugador9`, `jugador10`, `jugador11`, `puntos`, `created_at`, `estado`, `admin_id`, `observaciones`, `fecha_actualizacion`, `notificado`) VALUES
(1, 'Las Panteras', '10-01', 'Valentina Mora', 'Sofía Ruiz', 'Manuela Díaz', 'Camila Torres', 'Isabella Gómez', 'Sara López', NULL, NULL, NULL, NULL, NULL, 8, '2025-10-29 12:20:51', 'pendiente', NULL, NULL, NULL, 0),
(2, 'Los Lobos', '11-02', 'Miguel Ramos', 'David Pérez', 'Tomás Vega', 'Lucas Torres', 'Cristian Mora', 'Daniel Ruiz', NULL, NULL, NULL, NULL, NULL, 12, '2025-10-29 12:20:51', 'aprobado', 1, NULL, '2025-10-29 07:20:51', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ajedrez_jugadores`
--
ALTER TABLE `ajedrez_jugadores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estado` (`estado`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indices de la tabla `basquetbol_jugadores`
--
ALTER TABLE `basquetbol_jugadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contactos_admin` (`admin_id`);

--
-- Indices de la tabla `deportes`
--
ALTER TABLE `deportes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `futbol_jugadores`
--
ALTER TABLE `futbol_jugadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tenis_jugadores`
--
ALTER TABLE `tenis_jugadores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tenis_admin` (`admin_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `voleibol_jugadores`
--
ALTER TABLE `voleibol_jugadores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_voley_admin` (`admin_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ajedrez_jugadores`
--
ALTER TABLE `ajedrez_jugadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `basquetbol_jugadores`
--
ALTER TABLE `basquetbol_jugadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `deportes`
--
ALTER TABLE `deportes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `futbol_jugadores`
--
ALTER TABLE `futbol_jugadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tenis_jugadores`
--
ALTER TABLE `tenis_jugadores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `voleibol_jugadores`
--
ALTER TABLE `voleibol_jugadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ajedrez_jugadores`
--
ALTER TABLE `ajedrez_jugadores`
  ADD CONSTRAINT `fk_insc_ajedrez_admin` FOREIGN KEY (`admin_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD CONSTRAINT `fk_contactos_admin` FOREIGN KEY (`admin_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `tenis_jugadores`
--
ALTER TABLE `tenis_jugadores`
  ADD CONSTRAINT `fk_tenis_admin` FOREIGN KEY (`admin_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `voleibol_jugadores`
--
ALTER TABLE `voleibol_jugadores`
  ADD CONSTRAINT `fk_voley_admin` FOREIGN KEY (`admin_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
