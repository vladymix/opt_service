-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-05-2021 a las 18:06:19
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
-- Estructura de tabla para la tabla `courrier_req`
--

CREATE TABLE `courrier_req` (
  `Track_ID` varchar(12) NOT NULL,
  `Courrier_Request` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'TimeStamp generado en la puerta del receptor del paquete. ',
  `Courrier_ID` varchar(64) NOT NULL COMMENT 'Identificador del mensajero'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customer_req`
--

CREATE TABLE `customer_req` (
  `Track_ID` varchar(12) NOT NULL COMMENT 'Identificador del envío provisto por la empresa de mensajería',
  `Content` varchar(64) NOT NULL COMMENT 'SHA-256 del contenido',
  `Customer_ID` varchar(64) NOT NULL COMMENT 'ID del usuario.',
  `Status` bit(2) NOT NULL COMMENT 'Estado de la petición'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabal que recoje los datos lanzados por el cliente tras habe';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `courrier_req`
--
ALTER TABLE `courrier_req`
  ADD PRIMARY KEY (`Track_ID`);

--
-- Indices de la tabla `customer_req`
--
ALTER TABLE `customer_req`
  ADD PRIMARY KEY (`Track_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
