-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 07-10-2026 a las 15:52:04
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `saeIICP`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `idalumn` int(11) NOT NULL,
  `matricula_al` varchar(15) DEFAULT NULL,
  `nombre_al` varchar(15) DEFAULT NULL,
  `apaterno_al` varchar(15) DEFAULT NULL,
  `amaterno_al` varchar(15) DEFAULT NULL,
  `dom_al` varchar(80) DEFAULT NULL,
  `mail_al` varchar(50) DEFAULT NULL,
  `tel_al` varchar(35) DEFAULT NULL,
  `estatus_al` varchar(4) DEFAULT 'ALTA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`idalumn`, `matricula_al`, `nombre_al`, `apaterno_al`, `amaterno_al`, `dom_al`, `mail_al`, `tel_al`, `estatus_al`) VALUES
(5, '00002', 'erick', 'gonzalez', 'fuentes', 'su casa', 'fuentes@gmail.com', '5563829276', 'ALTA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `idgrupo` int(11) NOT NULL,
  `descripcion_grupo` varchar(25) DEFAULT NULL,
  `estatus_grupo` varchar(4) DEFAULT 'ALTA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`idgrupo`, `descripcion_grupo`, `estatus_grupo`) VALUES
(5, '3T1', 'ALTA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `idmateria` int(11) NOT NULL,
  `descripcion_mat` varchar(25) DEFAULT NULL,
  `estatus_mat` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`idmateria`, `descripcion_mat`, `estatus_mat`) VALUES
(4, 'Matemáticas II', 'ALTA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `idprof` int(11) NOT NULL,
  `nocontrol_prof` varchar(15) DEFAULT NULL,
  `nombre_prof` varchar(15) DEFAULT NULL,
  `apaterno_prof` varchar(15) DEFAULT NULL,
  `amaterno_prof` varchar(15) DEFAULT NULL,
  `dom_prof` varchar(80) DEFAULT NULL,
  `mail_prof` varchar(50) DEFAULT NULL,
  `tel_prof` varchar(35) DEFAULT NULL,
  `estatus_prof` varchar(4) DEFAULT 'ALTA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`idprof`, `nocontrol_prof`, `nombre_prof`, `apaterno_prof`, `amaterno_prof`, `dom_prof`, `mail_prof`, `tel_prof`, `estatus_prof`) VALUES
(5, '00002', 'isaac', 'cortes', 'perez', 'florecitas mz 43 lt 04 col la casilda', 'saac@gmail.com', '5537738393', 'ALTA'),
(6, 'cejas 007', 'martin', 'lopez', 'cornejo', 'perukistan', 'cejascontinuas@hotmail.com', '5189372839', 'ALTA');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`idalumn`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`idgrupo`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`idmateria`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`idprof`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `idalumn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `idgrupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `idmateria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `idprof` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
