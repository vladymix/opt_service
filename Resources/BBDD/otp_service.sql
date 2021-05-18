-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2021 at 03:38 PM
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
(9, '::1', 1, 1620993581);

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
(1, 'exampleuser@amazon.com', 'a7574a42198b7d7eee2c037703a0b95558f195457908d6975e681e2055fd5eb9', '2021-05-13 00:01:38');

-----------------------------------------------------------------------------------------

CREATE TABLE 'courrier'(
  'company_ID' varchar(64) NOT NULL,
  'passHash' varchar(64) NOT NULL,
  'courrier_ID' int (11) NOT NULL,
  'createAt'  datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `courrier` (`company_ID`, `passHash`, `createAt`) VALUES
(1, 'exampleuser@amazon.com', 'a7574a42198b7d7eee2c037703a0b95558f195457908d6975e681e2055fd5eb9');



-- Indexes for dumped tables
--

--
-- Indexes for table `ipcontrol`
--
ALTER TABLE `ipcontrol`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`User_ID`);

--
-- Index for courrier
ALTER TABLE `courrier`
  ADD PRIMARY KEY (`courrier_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ipcontrol`
--
ALTER TABLE `ipcontrol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;


ALTER TABLE `courrier`
  MODIFY `courrier_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
