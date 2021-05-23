-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-05-2021 a las 23:13:00
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
-- Base de datos: `otp_service`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `delivery`
--

CREATE TABLE `delivery` (
  `delivery_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `track_ID` varchar(16) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipcontrol`
--

CREATE TABLE `ipcontrol` (
  `id` int(11) NOT NULL,
  `cliente_ip` varchar(20) NOT NULL,
  `retry_times` int(1) NOT NULL DEFAULT 0,
  `locked_up` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ipcontrol`
--

INSERT INTO `ipcontrol` (`id`, `cliente_ip`, `retry_times`, `locked_up`) VALUES
(0, '::1', 2, 1621851963);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `otp_data`
--

CREATE TABLE `otp_data` (
  `code_ID` int(11) NOT NULL,
  `jwt_otp` varchar(1024) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `status` int(11) NOT NULL,
  `delivery_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `User_ID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passHash` varchar(64) NOT NULL,
  `createAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`User_ID`, `email`, `passHash`, `createAt`) VALUES
(1, 'exampleuser@amazon.com', 'd93b2c6007d15f89b21ef9569347d44632714b25912f2a419017a0f46cb7e123', '2021-05-13 00:01:38');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`delivery_ID`);

--
-- Indices de la tabla `otp_data`
--
ALTER TABLE `otp_data`
  ADD PRIMARY KEY (`code_ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `delivery`
--
ALTER TABLE `delivery`
  MODIFY `delivery_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=889;

--
-- AUTO_INCREMENT de la tabla `otp_data`
--
ALTER TABLE `otp_data`
  MODIFY `code_ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
