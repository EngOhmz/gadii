-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 10, 2023 at 06:12 AM
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
-- Table structure for table `tbl_cf_task`
--

CREATE TABLE `tbl_cf_task` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `milestones_id` int(11) DEFAULT NULL,
  `task_id` int(255) DEFAULT NULL,
  `opportunities_id` int(11) DEFAULT NULL,
  `goal_tracking_id` varchar(115) DEFAULT NULL,
  `sub_task_id` int(11) DEFAULT NULL,
  `transactions_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `task_name` varchar(200) NOT NULL,
  `task_description` text DEFAULT NULL,
  `task_start_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `task_status` varchar(30) DEFAULT NULL,
  `task_progress` int(11) DEFAULT NULL,
  `calculate_progress` varchar(200) DEFAULT NULL,
  `task_hour` varchar(10) DEFAULT NULL,
  `tasks_notes` text DEFAULT NULL,
  `timer_status` enum('on','off') DEFAULT 'off',
  `timer_started_by` int(11) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `logged_time` int(11) DEFAULT 0,
  `leads_id` int(11) DEFAULT NULL,
  `bug_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `assigned_to` varchar(255) DEFAULT NULL,
  `permission` text DEFAULT NULL,
  `client_visible` varchar(5) DEFAULT NULL,
  `custom_date` text DEFAULT NULL,
  `hourly_rate` decimal(18,2) DEFAULT 0.00,
  `billable` varchar(20) DEFAULT NULL,
  `index_no` int(11) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `disabled` int(200) DEFAULT 0,
  `added_by` int(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_task`
--

INSERT INTO `tbl_task` (`id`, `project_id`, `milestones_id`, `task_id`, `opportunities_id`, `goal_tracking_id`, `sub_task_id`, `transactions_id`, `category_id`, `task_name`, `task_description`, `task_start_date`, `due_date`, `task_status`, `task_progress`, `calculate_progress`, `task_hour`, `tasks_notes`, `timer_status`, `timer_started_by`, `start_time`, `logged_time`, `leads_id`, `bug_id`, `created_by`, `assigned_to`, `permission`, `client_visible`, `custom_date`, `hourly_rate`, `billable`, `index_no`, `tags`, `disabled`, `added_by`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, 'Leads', NULL, NULL, 1, 'test 1', 'annooww', '2023-01-13', '2023-02-03', 'Started', NULL, NULL, NULL, NULL, 'off', NULL, NULL, 0, NULL, NULL, NULL, '115', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, 0, 1, '2023-01-13 21:07:00', '2023-01-13 21:07:00'),
(2, 2, NULL, NULL, NULL, 'Projects', NULL, NULL, 2, 'Finding Investor', NULL, '2023-01-18', '2023-01-31', 'In Progress', NULL, NULL, NULL, NULL, 'off', NULL, NULL, 0, NULL, NULL, NULL, '158,198', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, 0, 1, '2023-01-18 15:50:53', '2023-02-06 22:10:12'),
(3, NULL, NULL, 2, NULL, 'Projects', NULL, NULL, 3, 'sub task 1', 'yah now', '2023-01-30', '2023-02-10', 'Started', NULL, NULL, NULL, NULL, 'off', NULL, NULL, 0, NULL, NULL, NULL, '118', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, 0, 1, '2023-01-27 23:31:28', '2023-01-27 23:31:28'),
(4, NULL, NULL, 2, NULL, 'Projects', NULL, NULL, 1, 'Hello', 'test Description', '2023-02-03', '2023-02-03', 'Waiting For Someone', NULL, NULL, NULL, NULL, 'off', NULL, NULL, 0, NULL, NULL, NULL, '198', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, 0, 1, '2023-02-03 19:37:35', '2023-02-03 19:37:35'),
(5, 5, NULL, NULL, NULL, 'Projects', NULL, NULL, 4, 'Hello', 'sd', '2023-02-07', '2023-02-07', 'Deferred', NULL, NULL, NULL, NULL, 'off', NULL, NULL, 0, NULL, NULL, NULL, '283', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, 0, 283, '2023-02-08 03:20:25', '2023-02-08 03:20:25'),
(6, NULL, NULL, 5, NULL, 'Projects', NULL, NULL, 4, 'Hello', 'Test Testdf', '2023-02-07', '2023-03-22', 'In Progress', NULL, NULL, NULL, NULL, 'off', NULL, NULL, 0, NULL, NULL, NULL, '283', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, 0, 283, '2023-02-08 03:23:03', '2023-02-08 03:23:03'),
(7, 3, NULL, NULL, NULL, 'Projects', NULL, NULL, 1, 'sub task 43', 'daaaaa', '2023-01-29', '2023-02-08', 'In Progress', NULL, NULL, NULL, NULL, 'off', NULL, NULL, 0, NULL, NULL, NULL, '115,118', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, 0, 1, '2023-02-08 17:22:35', '2023-02-08 17:22:35'),
(8, 5, NULL, NULL, NULL, 'Projects', NULL, NULL, 4, 'Test Task', 'Hello', '2023-02-08', '2023-02-08', 'Started', NULL, NULL, NULL, NULL, 'off', NULL, NULL, 0, NULL, NULL, NULL, '283', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, 0, 283, '2023-02-08 18:49:09', '2023-02-08 18:49:09'),
(9, NULL, NULL, 8, NULL, 'Projects', NULL, NULL, 4, 'Sub sub Test', 'Test me', '2023-02-08', '2023-02-24', 'Started', NULL, NULL, NULL, NULL, 'off', NULL, NULL, 0, NULL, NULL, NULL, '283', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, 0, 283, '2023-02-08 18:50:55', '2023-02-08 18:50:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_task`
--
ALTER TABLE `tbl_task`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_task`
--
ALTER TABLE `tbl_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
