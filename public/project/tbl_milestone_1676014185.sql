-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 10, 2023 at 06:10 AM
-- Server version: 10.5.11-MariaDB-1:10.5.11+maria~focal
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_ema`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cf_milestone`
--

CREATE TABLE `tbl_cf_milestone` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `project_id` int(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `responsible_id` int(100) NOT NULL,
  `description` varchar(210) DEFAULT NULL,
  `added_by` int(100) NOT NULL,
  `client_visible` varchar(200) DEFAULT NULL,
  `disabled` int(200) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_milestone`
--

INSERT INTO `tbl_milestone` (`id`, `name`, `project_id`, `start_date`, `end_date`, `responsible_id`, `description`, `added_by`, `client_visible`, `disabled`, `created_at`, `updated_at`) VALUES
(2, 'Northern Zone', 2, '2023-01-26', '2023-01-26', 1, NULL, 1, NULL, 0, '2023-01-27 00:10:09', '2023-01-27 00:10:09'),
(3, 'Finding client', 2, '2023-01-01', '2023-01-27', 1, NULL, 1, NULL, 0, '2023-01-27 09:42:18', '2023-01-27 17:42:18'),
(4, 'Loading Activities', 3, '2023-02-06', '2023-02-06', 115, NULL, 1, NULL, 0, '2023-02-06 23:05:57', '2023-02-06 23:05:57'),
(5, 'Monitor Sales', 5, '2023-02-07', '2023-02-28', 283, NULL, 283, NULL, 0, '2023-02-08 02:12:00', '2023-02-08 02:12:00'),
(6, 'Eastern Zone sales', 5, '2023-02-07', '2023-02-13', 286, NULL, 283, NULL, 0, '2023-02-08 02:13:06', '2023-02-08 02:13:06'),
(7, 'Northern Zone', 5, '2023-02-07', '2023-02-24', 283, NULL, 283, NULL, 0, '2023-02-08 02:37:24', '2023-02-08 02:37:24'),
(8, 'Northern Zone Road', 9, '2023-02-10', '2023-02-28', 13, NULL, 13, NULL, 0, '2023-02-10 13:36:15', '2023-02-10 13:36:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_milestone`
--
ALTER TABLE `tbl_milestone`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_milestone`
--
ALTER TABLE `tbl_milestone`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
