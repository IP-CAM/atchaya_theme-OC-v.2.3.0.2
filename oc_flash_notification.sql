-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2018 at 09:36 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `opc_atchaya_theme`
--

-- --------------------------------------------------------

--
-- Table structure for table `oc_flash_notification`
--

CREATE TABLE `oc_flash_notification` (
  `flash_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `flash_status` int(10) NOT NULL,
  `flash_text` varchar(250) NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oc_flash_notification`
--

INSERT INTO `oc_flash_notification` (`flash_id`, `product_id`, `flash_status`, `flash_text`, `date_modified`) VALUES
(1, 47, 1, 'AAthiiiiii', '2018-05-04 00:02:11'),
(2, 42, 1, 'AATHI', '2018-05-04 00:02:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `oc_flash_notification`
--
ALTER TABLE `oc_flash_notification`
  ADD PRIMARY KEY (`flash_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `oc_flash_notification`
--
ALTER TABLE `oc_flash_notification`
  MODIFY `flash_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
