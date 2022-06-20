-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2021 at 01:36 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u1469889_work_report_deedokus`
--

-- --------------------------------------------------------

--
-- Table structure for table `new_content_count`
--

CREATE TABLE `new_content_count` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `content_id` int(10) NOT NULL,
  `count` int(10) NOT NULL,
  `total_time` varchar(50) DEFAULT NULL,
  `status` tinyint(5) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `new_content_count`
--

INSERT INTO `new_content_count` (`id`, `user_id`, `content_id`, `count`, `total_time`, `status`, `date`) VALUES
(1, 6, 18, 1623, '0h 10m 2s', NULL, '2021-12-04'),
(2, 6, 11, 5, NULL, NULL, '2021-12-08'),
(5, 6, 18, 1646, '0h 0m 2s', 4, '2021-12-04'),
(6, 6, 18, 1623, NULL, 4, '2021-12-08'),
(8, 6, 11, 23, NULL, 4, '2021-12-02'),
(9, 6, 11, 22, NULL, NULL, '2021-12-02'),
(10, 6, 11, 24, '0h 10m 2s', NULL, '2021-12-07'),
(11, 6, 18, 1623, '4h 1m 59s', NULL, '2021-12-02'),
(12, 6, 11, 24, '0h 11m 54s', NULL, '2021-12-02'),
(13, 6, 11, 25, '0h 12m 4s', NULL, '2021-12-02'),
(14, 6, 11, 26, '0h 12m 9s', NULL, '2021-12-03'),
(15, 6, 18, 1650, NULL, 4, '2021-12-04'),
(16, 6, 18, 1650, NULL, NULL, '2021-12-04'),
(17, 6, 18, 1667, NULL, NULL, '2021-12-04'),
(18, 6, 18, 1670, NULL, 4, '2021-12-04'),
(19, 6, 18, 1672, NULL, 4, '2021-12-04'),
(20, 6, 18, 1672, NULL, NULL, '2021-12-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `new_content_count`
--
ALTER TABLE `new_content_count`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `new_content_count`
--
ALTER TABLE `new_content_count`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
