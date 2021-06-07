-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2021 at 10:09 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `otp_service`
--

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `delivery_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `track_ID` varchar(100) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`delivery_ID`, `User_ID`, `track_ID`, `status`) VALUES
(39, 1, '123HH4563', 2),
(40, 1, '253F4SDKJ', 1),
(41, 1, '33KJ32K2J', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ipcontrol`
--

CREATE TABLE `ipcontrol` (
  `id` int(11) NOT NULL,
  `cliente_ip` varchar(20) NOT NULL,
  `retry_times` int(1) NOT NULL DEFAULT 0,
  `locked_up` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ipcontrol`
--

INSERT INTO `ipcontrol` (`id`, `cliente_ip`, `retry_times`, `locked_up`) VALUES
(0, '::1', 2, 1623091014),
(0, '192.168.1.130', 1, 1623092657);

-- --------------------------------------------------------

--
-- Table structure for table `otp_data`
--

CREATE TABLE `otp_data` (
  `code_ID` int(11) NOT NULL,
  `jwt_otp` varchar(1024) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `status` int(11) NOT NULL,
  `delivery_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `otp_data`
--

INSERT INTO `otp_data` (`code_ID`, `jwt_otp`, `otp`, `status`, `delivery_ID`) VALUES
(39, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiMSIsInRva2VuIjoiZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6STFOaUo5LmV5SmxiV0ZwYkNJNkltVjRZVzF3YkdWMWMyVnlRR0Z0WVhwdmJpNWpiMjBpTENKallXUjFZMmwwZVNJNk1UWXlNekExTkRZNU9Td2lWWE5sY2w5SlJDSTZJakVpZlEuWXV6d0hOSkkwSUJQMVdGSGg4bGVkbUtuaUFwbWlzaGRFbnZwUTZhYkFFVSIsInRyYWNrX2lkIjoiMTIzSEg0NTYzIiwiZW1haWxfY2xpZW50ZSI6ImNsaWVudGVAY29ycmVvLmNvbSIsImNhZHVjaWRhZCI6MTYyMzA1NDY5OX0.noYwT7W2HsPKR4QpasTkJI0fL77CdO0sT5JUe0uKIO8', 'Yi7E9D', 2, 39),
(40, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiMSIsInRva2VuIjoiZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6STFOaUo5LmV5SmxiV0ZwYkNJNkltVjRZVzF3YkdWMWMyVnlRR0Z0WVhwdmJpNWpiMjBpTENKallXUjFZMmwwZVNJNk1UWXlNekExTlRNd01Dd2lWWE5sY2w5SlJDSTZJakVpZlEuLW5iN05QQnJUQlplRnEzZHJ3MkpHNnpwdHkzamkyeDRJNzd6SWkxWWNOVSIsInRyYWNrX2lkIjoiMjUzRjRTREtKIiwiZW1haWxfY2xpZW50ZSI6ImNsaWVudGVAY29ycmVvLmNvbSIsImNhZHVjaWRhZCI6MTYyMzA1NTMwMH0.l-8_w_8hwqhxz01zxvjm5jSlLNiqi3NsXhZHVr596jA', 'H3rrYZ', 1, 40),
(41, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiMSIsInRva2VuIjoiZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6STFOaUo5LmV5SmxiV0ZwYkNJNkltVjRZVzF3YkdWMWMyVnlRR0Z0WVhwdmJpNWpiMjBpTENKallXUjFZMmwwZVNJNk1UWXlNekExTlRRME55d2lWWE5sY2w5SlJDSTZJakVpZlEuaFNMbHFjd21MRkZDSG5ZQ3ZMbkVXY0EyRGdRdWRkTnM4a0JVZ1ViSUdKbyIsInRyYWNrX2lkIjoiMzNLSjMySzJKIiwiZW1haWxfY2xpZW50ZSI6ImNsaWVudGVAY29ycmVvLmNvbSIsImNhZHVjaWRhZCI6MTYyMzA1NTQ0N30.86XAuwD98BGmRo2K-uBDM9BbVL7iBugS66f-jwhW4zQ', 'uNBugz', 1, 41);

-- --------------------------------------------------------

--
-- Table structure for table `userpush`
--

CREATE TABLE `userpush` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token_push` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userpush`
--

INSERT INTO `userpush` (`id`, `email`, `token_push`) VALUES
(4, 'cliente@correo.com', 'd6Hl1PQSRuy14XHRKLWV_d:APA91bHM1xCJ5Ae42iLoRWVPf5o2p3v2S8W7gh8eZmbsaXf2I34ilG4lhYf9AHpobxEDEV2jTuBjI1phzo9soZ55vmSW21-ZzpKbjROHimBaldVMLRmPp2y5m8_KEPheeC75o3vcbrh9');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `User_ID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passHash` varchar(64) NOT NULL,
  `createAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`User_ID`, `email`, `passHash`, `createAt`) VALUES
(1, 'exampleuser@amazon.com', 'd93b2c6007d15f89b21ef9569347d44632714b25912f2a419017a0f46cb7e123', '2021-05-13 00:01:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`delivery_ID`);

--
-- Indexes for table `otp_data`
--
ALTER TABLE `otp_data`
  ADD PRIMARY KEY (`code_ID`);

--
-- Indexes for table `userpush`
--
ALTER TABLE `userpush`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `delivery_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `otp_data`
--
ALTER TABLE `otp_data`
  MODIFY `code_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `userpush`
--
ALTER TABLE `userpush`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
