-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 30, 2022 at 01:02 PM
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
-- Database: `admin_emaerp`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `activity` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loading_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `module_id`, `module`, `date`, `activity`, `notes`, `loading_id`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', 'Cargo', '2022-04-23', 'Confirm Collection', 'to be covered properly', 1, 19, '2022-04-24 01:55:37', '2022-04-24 01:55:37'),
(3, '1', 'Cargo', '2022-04-23', 'Confirm Collection', 'to be covered properly', 3, 19, '2022-04-24 02:14:02', '2022-04-24 02:14:02'),
(4, '1', 'Cargo', '2022-04-24', 'Confirm Loading', 'half of cargo loaded', 1, 19, '2022-04-24 02:40:59', '2022-04-24 02:40:59'),
(5, '1', 'Cargo', '2022-04-24', 'Confirm Loading', 'remaining half of the cargo', 3, 19, '2022-04-24 02:42:50', '2022-04-24 02:42:50'),
(6, '1', 'Cargo', '2022-04-24', 'Confirm Offloading', 'arrived safely', 1, 19, '2022-04-24 02:43:18', '2022-04-24 02:43:18'),
(7, '1', 'Cargo', '2022-04-24', 'Confirm Offloading', 'arrived safely', 3, 19, '2022-04-24 02:43:44', '2022-04-24 02:43:44'),
(8, '1', 'Cargo', '2022-04-24', 'Confirm Delivery', 'delivered safe and on time', 1, 19, '2022-04-24 02:45:30', '2022-04-24 02:45:30'),
(9, '1', 'Cargo', '2022-04-24', 'Confirm Delivery', 'delivered safe and on time', 3, 19, '2022-04-24 02:45:30', '2022-04-24 02:45:30'),
(11, '2', 'Cargo', '2022-04-28', 'Confirm Collection', 'the cargo is collected by truck T621DGA', 4, 19, '2022-04-28 22:37:21', '2022-04-28 22:37:21'),
(12, '3', 'Cargo', '2022-04-28', 'Confirm Collection', '78', 5, 19, '2022-04-28 23:10:17', '2022-04-28 23:10:17'),
(13, '2', 'Cargo', '2022-04-29', 'Confirm Loading', 'the cargo is collected by truck T621DGA', 4, 19, '2022-04-28 23:17:04', '2022-04-28 23:17:04'),
(14, '2', 'Cargo', '2022-04-29', 'Confirm Offloading', 'the cargo is collected by truck T620DGA', 4, 19, '2022-04-28 23:17:33', '2022-04-28 23:17:33'),
(15, '2', 'Cargo', '2022-04-28', 'Confirm Delivery', 'the cargo is collected by truck T620DGA', 4, 19, '2022-04-28 23:27:07', '2022-04-28 23:27:07'),
(16, '4', 'Cargo', '2022-05-18', 'Confirm Collection', 'GHH', 6, 53, '2022-05-17 15:16:07', '2022-05-17 15:16:07'),
(17, '4', 'Cargo', '2022-05-19', 'Confirm Loading', 'HHJ', 6, 53, '2022-05-17 15:28:18', '2022-05-17 15:28:18'),
(18, '4', 'Cargo', '2022-05-17', 'Confirm Offloading', 'GHH', 6, 53, '2022-05-17 15:28:55', '2022-05-17 15:28:55'),
(19, '4', 'Cargo', '2022-05-17', 'Confirm Delivery', 'GHH', 6, 53, '2022-05-17 15:30:17', '2022-05-17 15:30:17'),
(20, '3', 'Cargo', '2022-05-18', 'Confirm Collection', 'gfgg', 7, 53, '2022-05-18 12:21:00', '2022-05-18 12:21:00'),
(21, '3', 'Cargo', '2022-05-19', 'Confirm Loading', 'to be covered properly', 5, 1, '2022-05-20 20:56:02', '2022-05-20 20:56:02'),
(22, '8', 'Cargo', '2022-05-20', 'Confirm Collection', 'test', 8, 1, '2022-05-20 21:30:48', '2022-05-20 21:30:48'),
(23, '8', 'Cargo', '2022-05-20', 'Confirm Collection', 'test', 9, 1, '2022-05-20 22:23:45', '2022-05-20 22:23:45'),
(24, '8', 'Cargo', '2022-05-20', 'Confirm Loading', 'loaded safe', 8, 1, '2022-05-20 22:57:56', '2022-05-20 22:57:56'),
(25, '8', 'Cargo', '2022-05-20', 'Confirm Loading', 'loaded safe', 9, 1, '2022-05-20 22:58:32', '2022-05-20 22:58:32'),
(26, '8', 'Cargo', '2022-05-20', 'Confirm Offloading', 'good dropped safe', 8, 1, '2022-05-20 22:59:21', '2022-05-20 22:59:21'),
(27, '8', 'Cargo', '2022-05-20', 'Confirm Offloading', 'good dropped safe', 9, 1, '2022-05-20 23:01:35', '2022-05-20 23:01:35'),
(28, '8', 'Cargo', '2022-05-21', 'Confirm Delivery', 'delivered safe and on time', 8, 1, '2022-05-20 23:03:18', '2022-05-20 23:03:18'),
(29, '8', 'Cargo', '2022-05-21', 'Confirm Delivery', 'delivered safe and on time', 9, 1, '2022-05-20 23:04:30', '2022-05-20 23:04:30');

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE `balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `purchase` int(11) NOT NULL,
  `sale` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `balances`
--

INSERT INTO `balances` (`id`, `user_id`, `product_id`, `purchase`, `sale`, `created_at`, `updated_at`) VALUES
(12, 1, 1, 72, -6, '2022-02-16 11:29:15', '2022-02-19 14:16:28'),
(13, 1, 3, 44, -3, '2022-02-16 11:33:55', '2022-02-19 14:29:27');

-- --------------------------------------------------------

--
-- Table structure for table `bank_details`
--

CREATE TABLE `bank_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `routing_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_details`
--

INSERT INTO `bank_details` (`id`, `account_name`, `routing_number`, `account_number`, `bank_name`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'MANYUNYU SC', '23738812', '12232378', 'NMB', 1, '2022-04-14 11:56:09', '2022-04-14 11:12:35');

-- --------------------------------------------------------

--
-- Table structure for table `bank_reconciliations`
--

CREATE TABLE `bank_reconciliations` (
  `id` int(10) UNSIGNED NOT NULL,
  `transaction_type` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `debit` decimal(20,2) DEFAULT NULL,
  `credit` decimal(20,2) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `currency_code` varchar(200) COLLATE utf8_unicode_ci DEFAULT '''''''TZS''''''',
  `payment_id` int(11) DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `basic_details`
--

CREATE TABLE `basic_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `join_date` date NOT NULL,
  `birth_date` date NOT NULL,
  `father_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marital_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mother_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `national_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `basic_details`
--

INSERT INTO `basic_details` (`id`, `emp_id`, `user_name`, `join_date`, `birth_date`, `father_name`, `email`, `full_name`, `gender`, `marital_status`, `mother_name`, `phone`, `mobile`, `national_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'CRDB', '37383', '2022-04-28', '2022-04-22', 'samwe', 'onasisvps85@gmail.com', 'manyunyus sc', '1028272992', 'single', 'fdrtg', '0715438485', '0715438485', '1111112j3', '1', '2022-04-13 23:36:44', '2022-04-14 11:54:31');

-- --------------------------------------------------------

--
-- Table structure for table `bill_of_materials`
--

CREATE TABLE `bill_of_materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manufactured_item` int(11) NOT NULL,
  `work_centre` int(20) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bill_of_materials`
--

INSERT INTO `bill_of_materials` (`id`, `reference_no`, `manufactured_item`, `work_centre`, `status`, `added_by`, `created_at`, `updated_at`) VALUES
(5, 'PUR_INV-5', 1, 1, NULL, 1, '2022-05-17 15:45:07', '2022-05-17 15:45:07');

-- --------------------------------------------------------

--
-- Table structure for table `bill_of_material_inventory`
--

CREATE TABLE `bill_of_material_inventory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_of_material_id` int(20) NOT NULL,
  `item_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` int(20) NOT NULL,
  `work_centre` int(20) NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `total_cost` decimal(8,2) DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bill_of_material_inventory`
--

INSERT INTO `bill_of_material_inventory` (`id`, `bill_of_material_id`, `item_name`, `description`, `location`, `work_centre`, `quantity`, `total_cost`, `price`, `unit`, `items_id`, `added_by`, `created_at`, `updated_at`) VALUES
(7, 5, '2', '', 0, 0, '23.00', NULL, NULL, 'pc', 2, 1, '2022-05-17 15:45:07', '2022-05-17 15:45:07');

-- --------------------------------------------------------

--
-- Table structure for table `cargo_collection`
--

CREATE TABLE `cargo_collection` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pacel_id` int(100) NOT NULL,
  `pacel_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pacel_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_id` int(11) NOT NULL,
  `receiver_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route_id` int(100) NOT NULL,
  `start_location` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_location` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` decimal(20,2) NOT NULL,
  `due_weight` decimal(20,2) NOT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cargo_collection`
--

INSERT INTO `cargo_collection` (`id`, `pacel_id`, `pacel_number`, `pacel_name`, `owner_id`, `receiver_name`, `route_id`, `start_location`, `end_location`, `weight`, `due_weight`, `amount`, `status`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'PCL-1', 'Construction Cargo', 4, 'Anna', 4, '3', '1', '200.00', '0.00', '81620.00', '3', 19, '2022-04-23 18:19:37', '2022-04-24 02:14:02'),
(2, 2, 'PCL-2', 'Transportation of Cargo- 2', 1, 'Hamis Lines Limited', 3, '2', '1', '60000.00', '30000.00', '5900000.00', '2', 1, '2022-04-24 15:26:41', '2022-04-28 22:37:21'),
(3, 3, 'PCL-3', 'Transport of CaCo3 from msata to Njombe', 4, 'Jefag LTD', 6, '18', '17', '120000.00', '0.00', '13794955.20', '3', 19, '2022-04-28 22:42:34', '2022-05-18 12:21:00'),
(4, 4, 'PCL-4', 'XTEW SHING TO SINGIDA', 1, '-', 7, '8', '18', '300000.00', '0.00', '3658000.00', '3', 53, '2022-05-17 14:25:10', '2022-05-17 15:16:07'),
(5, 5, 'PCL-5', 'test movements of cargo', 1, '-', 8, '1', '2', '300000.00', '300000.00', '1593000.00', '2', 53, '2022-05-19 13:06:34', '2022-05-19 13:06:34'),
(7, 8, 'PCL-8', 'test shipment', 3, 'john', 11, '3', '16', '5000.00', '0.00', '1416.00', '4', 1, '2022-05-20 21:16:27', '2022-05-20 23:04:30'),
(8, 9, 'PCL-9', 'mwanza shipment', 4, 'asha', 12, '16', '1', '200.00', '200.00', '271400.00', '2', 1, '2022-05-23 22:57:46', '2022-05-23 22:57:46');

-- --------------------------------------------------------

--
-- Table structure for table `cargo_loading`
--

CREATE TABLE `cargo_loading` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pacel_id` int(100) NOT NULL,
  `pacel_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pacel_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_id` int(11) NOT NULL,
  `receiver_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_location` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_id` int(100) NOT NULL,
  `end_location` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` int(11) NOT NULL,
  `total_weight` int(100) DEFAULT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `truck_id` int(200) NOT NULL,
  `driver_id` int(200) NOT NULL,
  `collection_date` date NOT NULL,
  `fuel` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cargo_loading`
--

INSERT INTO `cargo_loading` (`id`, `pacel_id`, `pacel_number`, `pacel_name`, `owner_id`, `receiver_name`, `start_location`, `route_id`, `end_location`, `weight`, `total_weight`, `amount`, `status`, `type`, `truck_id`, `driver_id`, `collection_date`, `fuel`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'PCL-1', 'Construction Cargo', 4, 'Anna', '3', 4, '1', 100, 200, '81620.00', '6', 'owned', 3, 2, '2022-04-23', '1', 19, '2022-04-24 01:55:37', '2022-04-24 02:45:30'),
(3, 1, 'PCL-1', 'Construction Cargo', 4, 'Anna', '3', 4, '1', 100, 200, '81620.00', '6', 'owned', 2, 1, '2022-04-23', '1', 19, '2022-04-24 02:14:02', '2022-04-24 02:45:46'),
(4, 2, 'PCL-2', 'Transportation of Cargo- 2', 1, 'Hamis Lines Limited', '2', 3, '1', 30000, 60000, '5900000.00', '6', 'owned', 6, 2, '2022-04-28', '1', 19, '2022-04-28 22:37:21', '2022-04-28 23:27:06'),
(5, 3, 'PCL-3', 'Transport of CaCo3 from msata to Njombe', 4, 'Jefag LTD', '18', 6, '17', 30000, 120000, '13794955.20', '4', 'owned', 7, 1, '2022-04-28', '1', 19, '2022-04-28 23:10:17', '2022-05-20 20:56:02'),
(6, 4, 'PCL-4', 'XTEW SHING TO SINGIDA', 1, '-', '8', 7, '18', 300000, 300000, '3658000.00', '6', 'owned', 9, 2, '2022-05-18', '1', 53, '2022-05-17 15:16:07', '2022-05-17 15:30:12'),
(7, 3, 'PCL-3', 'Transport of CaCo3 from msata to Njombe', 4, 'Jefag LTD', '18', 6, '17', 90000, 120000, '13794955.20', '3', 'owned', 9, 2, '2022-05-18', '0', 53, '2022-05-18 12:21:00', '2022-05-18 12:21:00'),
(8, 8, 'PCL-8', 'test shipment', 3, 'john', '3', 11, '16', 4000, 5000, '1416.00', '6', 'non_owned', 8, 3, '2022-05-20', '1', 1, '2022-05-20 21:30:48', '2022-05-20 23:03:18'),
(9, 8, 'PCL-8', 'test shipment', 3, 'john', '3', 11, '16', 1000, 5000, '1416.00', '6', 'non_owned', 5, 4, '2022-05-20', '1', 1, '2022-05-20 22:23:45', '2022-05-20 23:04:30');

-- --------------------------------------------------------

--
-- Table structure for table `chart_of_accounts`
--

CREATE TABLE `chart_of_accounts` (
  `chart_id` int(11) NOT NULL,
  `id` int(11) NOT NULL DEFAULT 0,
  `account_codes` int(200) NOT NULL,
  `account_name` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `gl_code` int(200) NOT NULL,
  `account_type` varchar(500) NOT NULL,
  `allow_manual` tinyint(4) NOT NULL DEFAULT 0,
  `active` varchar(200) NOT NULL,
  `operator_id` int(11) DEFAULT NULL,
  `collection_id` int(11) DEFAULT NULL,
  `added_by` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chart_of_accounts`
--

INSERT INTO `chart_of_accounts` (`chart_id`, `id`, `account_codes`, `account_name`, `name`, `gl_code`, `account_type`, `allow_manual`, `active`, `operator_id`, `collection_id`, `added_by`) VALUES
(1, 4, 1141, 'Receivable and Prepayments', 'Receivable and Prepayments', 1141, 'Assets', 0, 'Active', NULL, NULL, 0),
(2, 6, 1122, 'CRDB', 'CRDB', 1122, 'Assets', 0, 'Active', NULL, NULL, 0),
(3, 7, 1112, 'Petty Cash', 'Petty Cash', 1112, 'Assets', 0, 'Active', NULL, NULL, 0),
(4, 8, 1210, 'Furniture and Office Equipment', 'Furniture and Office Equipment', 1210, 'Assets', 0, 'Active', NULL, NULL, 0),
(5, 9, 1230, 'Land and Building', 'Land and Building', 1230, 'Assets', 0, 'Active', NULL, NULL, 0),
(6, 10, 2206, 'Deffered Tax', 'Deffered Tax', 2206, 'Liability', 0, 'Active', NULL, NULL, 0),
(7, 11, 3105, 'Retained Surplus/(Deficity)', 'Retained Surplus/(Deficity)', 3105, 'Equity', 0, 'Active', NULL, NULL, 0),
(8, 12, 3106, 'Annual Surplus/Deficity', 'Annual Surplus/Deficity', 3106, 'Equity', 0, 'Active', NULL, NULL, 0),
(9, 13, 5201, 'Salaries And Wages', 'Salaries And Wages', 5201, 'Expense', 0, 'Active', NULL, NULL, 0),
(10, 14, 5202, 'NSSF', 'NSSF', 5202, 'Expense', 0, 'Active', NULL, NULL, 0),
(11, 15, 5302, 'Medical Insurance', 'Medical Insurance', 5302, 'Expense', 0, 'Active', NULL, NULL, 0),
(12, 16, 2204, 'Payables', 'Payables', 2204, 'Liability', 0, 'Active', NULL, NULL, 0),
(13, 17, 4203, 'Parcel', 'Parcel', 4203, 'Income', 0, 'Active', NULL, NULL, 0),
(16, 19, 5000, 'Fuel', 'Fuel', 5000, 'Expense', 0, 'Active', NULL, NULL, 0),
(17, 20, 5100, 'Tire', 'Tire', 5100, 'Expense', 0, 'Active', NULL, NULL, 0),
(18, 21, 5200, 'Inventory', 'Inventory', 5200, 'Expense', 0, 'Active', NULL, NULL, 0),
(19, 24, 4111, 'Bank of Africa (BOA)=>USD', 'Bank of Africa (BOA)=>USD', 4111, 'Assets', 0, 'Active', NULL, NULL, 0),
(20, 25, 4112, 'NBC', 'NBC', 4112, 'Assets', 0, 'Active', NULL, NULL, 0),
(21, 26, 4113, 'TCB', 'TCB', 4113, 'Assets', 0, 'Active', NULL, NULL, 0),
(22, 27, 4114, 'MPESA', 'MPESA', 4114, 'Assets', 0, 'Active', NULL, NULL, 0),
(23, 28, 4115, 'TIGO PESA', 'TIGO PESA', 4115, 'Assets', 0, 'Active', NULL, NULL, 0),
(24, 29, 4116, 'AIRTEL MONEY', 'AIRTEL MONEY', 4116, 'Assets', 0, 'Active', NULL, NULL, 0),
(25, 30, 1512, 'Transport and Travelling', 'Transport and Travelling', 1512, 'Expense', 0, 'Active', NULL, NULL, 0),
(26, 31, 4118, 'NMB', 'NMB', 4118, 'Assets', 0, 'Active', NULL, NULL, 0),
(27, 32, 4119, 'Cash Account', 'Cash Account', 4119, 'Assets', 0, 'Active', NULL, NULL, 0),
(28, 33, 1510, 'Maintenance and Repair', 'Maintenance and Repair', 1510, 'Expense', 0, 'Active', NULL, NULL, 0),
(29, 34, 1518, 'Fuel Expenses', 'Fuel Expenses', 1518, 'Expense', 0, 'Active', NULL, NULL, 0),
(30, 35, 4122, 'Bank of Africa (BOA)=>TZS', 'Bank of Africa (BOA)=>TZS', 4122, 'Assets', 0, 'Active', NULL, NULL, 0),
(31, 36, 4123, 'Tanzania Commercial Bank=>TZS', 'Tanzania Commercial Bank=>TZS', 4123, 'Assets', 0, 'Active', NULL, NULL, 0),
(32, 37, 4124, 'Tanzania Commercial Bank=>USD', 'Tanzania Commercial Bank=>USD', 4124, 'Assets', 0, 'Active', NULL, NULL, 0),
(33, 38, 1625, 'Licence', 'Licence', 1625, 'Expense', 0, 'Active', NULL, NULL, 0),
(34, 39, 1626, 'Insurance', 'Insurance', 1626, 'Expense', 0, 'Active', NULL, NULL, 0),
(35, 22, 7400, 'VAT IN', 'VAT IN', 7400, '', 0, 'Active', NULL, NULL, 0),
(36, 23, 7500, 'VAT OUT', 'VAT OUT', 7500, '', 0, 'Active', NULL, NULL, 0),
(37, 40, 5300, 'Mileage', 'Mileage', 5300, 'Expense', 0, 'Active', NULL, NULL, 0),
(38, 41, 5402, 'Training', 'Training', 5402, 'Expense', 0, 'Active', NULL, NULL, 0),
(39, 42, 1525, 'PAYE', 'PAYE', 1525, 'Expense', 0, 'Active', NULL, NULL, 0),
(40, 43, 1524, 'NSSF', 'NSSF', 1524, 'Expense', 0, 'Active', NULL, NULL, 0),
(41, 44, 1524, 'NSSF (Employer Contribution)', 'NSSF (Employer Contribution)', 1524, 'Expense', 0, 'Active', NULL, NULL, 0),
(42, 45, 1524, 'NSSF (Employer Contribution)', 'NSSF (Employer Contribution)', 1524, 'Expense', 0, 'Active', NULL, NULL, 0),
(43, 46, 1527, 'WCF contribution', 'WCF contribution', 1527, 'Expense', 0, 'Active', NULL, NULL, 0),
(44, 47, 1529, 'WCF', 'WCF', 1529, 'Expense', 0, 'Active', NULL, NULL, 0),
(46, 49, 1517, 'NHIF (Heath Insurance Expense)', 'NHIF (Heath Insurance Expense)', 1517, 'Expense', 0, 'Active', NULL, NULL, 0),
(47, 50, 1520, 'NHIF', 'NHIF', 1520, 'Expense', 0, 'Active', NULL, NULL, 0),
(48, 51, 1530, 'Advance Salary', 'Advance Salary', 1530, 'Expense', 0, 'Active', NULL, NULL, 0),
(49, 52, 1531, 'Employee Loan', 'Employee Loan', 1531, 'Expense', 0, 'Active', NULL, NULL, 0),
(50, 53, 1532, 'Overtime', 'Overtime', 1532, 'Expense', 0, 'Active', NULL, NULL, 0),
(51, 54, 1533, 'Employee Award', 'Employee Award', 1533, 'Expense', 0, 'Active', NULL, NULL, 0),
(53, 56, 4204, 'Courier', 'Courier', 4204, 'Income', 0, 'Active', NULL, NULL, 0),
(61, 65, 5210, 'Cotton', 'Cotton', 5210, 'Expense', 0, 'Active', NULL, NULL, 0),
(62, 66, 4110, 'Purchasing Account', 'Purchasing Account', 4110, 'Expense', 0, 'Active', NULL, NULL, 0),
(64, 70, 5500, 'Operator Account', 'Operator Account', 5500, 'Assets', 0, 'Active', NULL, NULL, 0),
(65, 71, 5600, 'Collection Center Account', 'Collection Center Account', 5600, 'Assets', 0, 'Active', NULL, NULL, 0),
(66, 72, 3200, 'District Levy', 'District Levy', 3200, 'Expense', 0, 'Active', NULL, NULL, 0),
(67, 73, 3300, 'Community Level', 'Community Level', 3300, 'Expense', 0, 'Active', NULL, NULL, 0),
(68, 74, 3400, 'Levy Control', 'Levy Control', 3400, 'Liability', 0, 'Active', NULL, NULL, 0),
(69, 75, 3500, 'Transport Expenses Account', 'Transport Expenses Account', 3500, 'Expense', 0, 'Active', NULL, NULL, 0),
(70, 76, 3600, 'Transport Account', 'Transport Account', 3600, 'Liability', 0, 'Active', NULL, NULL, 0),
(71, 78, 3310, 'TDF', 'TDF', 3310, 'Expense', 0, 'Active', NULL, NULL, 0),
(72, 79, 3320, 'Union Levy', 'Union Levy', 3320, 'Expense', 0, 'Active', NULL, NULL, 0),
(73, 80, 5220, 'Seed', 'Seed', 5220, 'Expense', 0, 'Active', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TIN` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `user_id`, `name`, `address`, `phone`, `email`, `TIN`, `created_at`, `updated_at`) VALUES
(1, '1', 'Mohammed Enterprises', 'Tabata,Dar es Salaam', '+255655123456', 'janedoe@gmail.com', NULL, '2022-04-18 16:15:30', '2022-04-18 16:15:30'),
(2, '1', 'Obadia Cosmas', 'Ruvuma', '+255788016969', 'obadia@gmail.com', NULL, '2022-04-18 17:38:56', '2022-04-18 17:45:46'),
(3, '1', 'ABC Company', 'Mbauda,Arusha', '+255655000111', 'abccompany@gmail.com', NULL, '2022-04-18 17:53:00', '2022-04-19 10:30:33'),
(4, '1', 'Jefag Logistics Tanzania Limited', 'P.OBOX 70329 , Dar es Salaam', '+255784111111', 'jefag@gmail.com', '40013916C', '2022-04-19 13:50:10', '2022-04-19 13:50:10'),
(5, '1', 'Test Client', 'Kijitonyama', '-', 'test@adbox.africa', '152348234', '2022-04-22 20:08:49', '2022-04-22 20:08:49');

-- --------------------------------------------------------

--
-- Table structure for table `collection_centers`
--

CREATE TABLE `collection_centers` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `added_by` int(100) NOT NULL,
  `district_id` int(100) NOT NULL,
  `operator_id` int(200) NOT NULL,
  `quantity` decimal(20,2) DEFAULT 0.00,
  `head` varchar(200) NOT NULL,
  `account_codes` varchar(200) DEFAULT NULL,
  `updated_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `collection_centers`
--

INSERT INTO `collection_centers` (`id`, `name`, `added_by`, `district_id`, `operator_id`, `quantity`, `head`, `account_codes`, `updated_at`, `created_at`) VALUES
(1, 'mwakiponya', 1, 117, 1, '1000.00', '0', NULL, '2022-05-21 17:13:46.000000', '2022-05-16 16:47:31.000000'),
(2, 'mwakiponya A', 1, 118, 1, '-23.00', '0', NULL, '2022-05-25 12:00:27.000000', '2022-05-16 16:48:40.000000'),
(3, 'Main Center', 1, 118, 1, '63657.00', '1', NULL, '2022-05-25 12:05:08.000000', '2022-05-17 10:48:24.000000'),
(4, 'Solwa', 50, 118, 3, '13400.00', '0', NULL, '2022-05-24 22:35:32.000000', '2022-05-17 16:00:00.000000'),
(5, 'Mwamahasa', 50, 117, 2, '548000.00', '0', NULL, '2022-05-25 12:05:08.000000', '2022-05-18 19:01:30.000000'),
(6, 'MAGUNGA', 50, 122, 1, '0.00', '1', NULL, '2022-05-21 10:20:47.000000', '2022-05-21 10:20:47.000000');

-- --------------------------------------------------------

--
-- Table structure for table `cotton_clients`
--

CREATE TABLE `cotton_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TIN` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cotton_clients`
--

INSERT INTO `cotton_clients` (`id`, `user_id`, `name`, `address`, `phone`, `email`, `TIN`, `created_at`, `updated_at`) VALUES
(1, '50', 'XYZ Company', 'Shinyanga', '+255784111111', 'xyz@gmail.com', '4031111890', '2022-05-25 16:16:25', '2022-05-25 16:17:43');

-- --------------------------------------------------------

--
-- Table structure for table `cotton_history`
--

CREATE TABLE `cotton_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `due_quantity` decimal(20,2) NOT NULL,
  `supplier_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cotton_history`
--

INSERT INTO `cotton_history` (`id`, `purchase_id`, `items_id`, `quantity`, `due_quantity`, `supplier_id`, `purchase_date`, `price`, `location`, `reference`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', 1, '200.00', '0.00', '3', '2022-05-17', '2000.00', '4', '456', 50, '2022-05-17 16:15:57', '2022-05-18 17:37:03'),
(2, '2', 1, '3000.00', '0.00', '3', '2022-05-17', '2000.00', '4', '4566', 50, '2022-05-17 16:54:18', '2022-05-18 20:41:05'),
(3, '6', 1, '2500.00', '0.00', '3', '2022-05-18', '2000.00', '4', '5555', 50, '2022-05-18 06:25:59', '2022-05-18 20:41:05'),
(4, '7', 1, '150.00', '4.00', '1', '2022-05-18', '2000.00', '1', '12345', 50, '2022-05-18 06:35:36', '2022-05-20 13:57:09'),
(5, '8', 1, '10.00', '1.00', '1', '2022-05-17', '2000.00', '2', '56734', 50, '2022-05-18 06:39:59', '2022-05-25 12:00:27'),
(6, '9', 1, '20.00', '7.00', '1', '2022-05-18', '2000.00', '2', '345', 50, '2022-05-18 06:55:14', '2022-05-25 12:00:27'),
(7, '10', 1, '4500.00', '100.00', '3', '2022-05-18', '2100.00', '4', '45665', 50, '2022-05-18 09:01:07', '2022-05-24 22:35:32'),
(8, '11', 1, '10000.00', '400.00', '3', '2022-05-18', '2100.00', '4', '11579', 50, '2022-05-18 18:51:59', '2022-05-24 22:35:32'),
(9, '12', 1, '5000.00', '2000.00', '2', '2022-05-18', '1500.00', '5', '11157', 50, '2022-05-18 19:02:48', '2022-05-25 12:05:07'),
(10, '13', 1, '5854.00', '5854.00', '0', '2022-05-13', '2000.00', '1', 'AUTO-2022-05-13', 50, '2022-05-21 17:13:46', '2022-05-21 17:13:46'),
(11, '15', 1, '2000.00', '2000.00', '1', '2022-05-13', '2000.00', '5', 'AUTO-2022-05-13', 50, '2022-05-21 17:19:58', '2022-05-25 11:04:45'),
(12, '16', 1, '13000.00', '13000.00', '1', '2022-05-23', '2000.00', '5', 'AUTO-2022-05-23', 50, '2022-05-23 17:31:08', '2022-05-25 11:04:45'),
(13, '17', 1, '30000.00', '24800.00', '2', '2022-05-24', '2000.00', '5', '44w3345', 50, '2022-05-24 12:51:30', '2022-05-25 11:04:45'),
(14, '18', 1, '44800.00', '44800.00', '2', '2022-05-25', '2000.00', '5', '1200', 1, '2022-05-25 10:56:32', '2022-05-25 10:56:32'),
(15, '19', 1, '44000.00', '44000.00', '2', '2022-05-25', '2000.00', '5', '1112', 1, '2022-05-25 11:11:07', '2022-05-25 11:11:07'),
(16, '20', 1, '461000.00', '461000.00', '1', '2022-05-25', '2000.00', '5', 'AUTO-22-05-25', 1, '2022-05-25 11:25:41', '2022-05-25 11:25:41');

-- --------------------------------------------------------

--
-- Table structure for table `cotton_invoice`
--

CREATE TABLE `cotton_invoice` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT 'Cotton',
  `reference` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `due_date` date NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exchange_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` decimal(8,2) NOT NULL,
  `purchase_amount` decimal(20,2) NOT NULL,
  `due_amount` decimal(20,2) NOT NULL,
  `purchase_tax` decimal(20,2) NOT NULL,
  `status` int(11) NOT NULL,
  `good_receive` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cotton_invoice`
--

INSERT INTO `cotton_invoice` (`id`, `reference_no`, `type`, `reference`, `supplier_id`, `purchase_date`, `due_date`, `location`, `exchange_code`, `exchange_rate`, `purchase_amount`, `due_amount`, `purchase_tax`, `status`, `good_receive`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'INV_CTTN-1-2022-05-26', 'Cotton', '4445', '1', '2022-05-26', '2022-05-28', NULL, 'TZS', '1.00', '2440.00', '2440.00', '0.00', 1, '1', 50, '2022-05-26 15:37:14', '2022-05-26 15:37:14'),
(2, 'INV_CTTN-2-2022-05-26', 'Cotton', 'LINT 2022/06A', '1', '2022-05-26', '2022-05-31', NULL, 'USD', '2300.00', '933.00', '933.00', '0.00', 1, '1', 50, '2022-05-26 17:24:51', '2022-05-26 17:24:51');

-- --------------------------------------------------------

--
-- Table structure for table `cotton_invoice_history`
--

CREATE TABLE `cotton_invoice_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL,
  `bales` decimal(8,2) NOT NULL,
  `supplier_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cotton_invoice_history`
--

INSERT INTO `cotton_invoice_history` (`id`, `invoice_id`, `items_id`, `bales`, `supplier_id`, `purchase_date`, `location`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', 25, '2440.00', '1', '2022-05-26', NULL, 50, '2022-05-26 15:37:14', '2022-05-26 15:37:14'),
(2, '2', 26, '933.00', '1', '2022-05-26', NULL, 50, '2022-05-26 17:24:51', '2022-05-26 17:24:51');

-- --------------------------------------------------------

--
-- Table structure for table `cotton_invoice_item`
--

CREATE TABLE `cotton_invoice_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bales` decimal(20,2) NOT NULL,
  `gross` decimal(20,2) NOT NULL,
  `tare` decimal(20,2) DEFAULT NULL,
  `net` decimal(20,2) NOT NULL,
  `order_no` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cotton_invoice_item`
--

INSERT INTO `cotton_invoice_item` (`id`, `invoice_id`, `item_name`, `bales`, `gross`, `tare`, `net`, `order_no`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', '25', '2440.00', '2500.00', NULL, '2440.00', 0, 50, '2022-05-26 15:37:14', '2022-05-26 15:37:14'),
(2, '2', '26', '933.00', '1093.00', NULL, '933.00', 0, 50, '2022-05-26 17:24:51', '2022-05-26 17:24:51');

-- --------------------------------------------------------

--
-- Table structure for table `cotton_list`
--

CREATE TABLE `cotton_list` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `serial_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `truck_id` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cotton_list`
--

INSERT INTO `cotton_list` (`id`, `serial_no`, `brand_id`, `purchase_id`, `purchase_date`, `location`, `truck_id`, `status`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Cotton_1__2022', '1', '1', '2022-05-17', '4', NULL, 0, 50, '2022-05-17 16:15:57', '2022-05-17 16:15:57'),
(2, 'Cotton_2__2022', '1', '2', '2022-05-17', '4', NULL, 0, 50, '2022-05-17 16:54:18', '2022-05-17 16:54:18'),
(3, 'Cotton_6__2022', '1', '6', '2022-05-18', '4', NULL, 0, 50, '2022-05-18 06:25:59', '2022-05-18 06:25:59'),
(4, 'Cotton_7__2022', '1', '7', '2022-05-18', '1', NULL, 0, 50, '2022-05-18 06:35:36', '2022-05-18 06:35:36'),
(5, 'Cotton_8__2022', '1', '8', '2022-05-17', '2', NULL, 0, 50, '2022-05-18 06:39:59', '2022-05-18 06:39:59'),
(6, 'Cotton_9__2022', '1', '9', '2022-05-18', '2', NULL, 0, 50, '2022-05-18 06:55:14', '2022-05-18 06:55:14'),
(7, 'Cotton_10__2022', '1', '10', '2022-05-18', '4', NULL, 0, 50, '2022-05-18 09:01:07', '2022-05-18 09:01:07'),
(8, 'Cotton_11__2022', '1', '11', '2022-05-18', '4', NULL, 0, 50, '2022-05-18 18:51:59', '2022-05-18 18:51:59'),
(9, 'Cotton_12__2022', '1', '12', '2022-05-18', '5', NULL, 0, 50, '2022-05-18 19:02:48', '2022-05-18 19:02:48'),
(10, 'Cotton_13__2022', '1', '13', '2022-05-13', '1', NULL, 0, 50, '2022-05-21 17:13:46', '2022-05-21 17:13:46'),
(11, 'Cotton_15__2022', '1', '15', '2022-05-13', '5', NULL, 0, 50, '2022-05-21 17:19:58', '2022-05-21 17:19:58'),
(12, 'Cotton_16__2022', '1', '16', '2022-05-23', '5', NULL, 0, 50, '2022-05-23 17:31:08', '2022-05-23 17:31:08'),
(13, 'Cotton_17__2022', '1', '17', '2022-05-24', '5', NULL, 0, 50, '2022-05-24 12:51:30', '2022-05-24 12:51:30'),
(14, 'Cotton_18__2022', '1', '18', '2022-05-25', '5', NULL, 0, 1, '2022-05-25 10:56:32', '2022-05-25 10:56:32'),
(15, 'Cotton_19__2022', '1', '19', '2022-05-25', '5', NULL, 0, 1, '2022-05-25 11:11:07', '2022-05-25 11:11:07'),
(16, 'Cotton_20__2022', '1', '20', '2022-05-25', '5', NULL, 0, 1, '2022-05-25 11:25:41', '2022-05-25 11:25:41');

-- --------------------------------------------------------

--
-- Table structure for table `cotton_movement`
--

CREATE TABLE `cotton_movement` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `staff` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source_location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `destination_location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(20,2) NOT NULL,
  `quantity` decimal(20,2) NOT NULL,
  `rate` decimal(20,2) NOT NULL,
  `distance` decimal(20,2) NOT NULL,
  `transport` decimal(8,2) DEFAULT NULL,
  `status` int(200) DEFAULT 0,
  `added_by` int(11) NOT NULL,
  `approve_by` int(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cotton_movement`
--

INSERT INTO `cotton_movement` (`id`, `date`, `staff`, `source_location`, `destination_location`, `amount`, `quantity`, `rate`, `distance`, `transport`, `status`, `added_by`, `approve_by`, `created_at`, `updated_at`) VALUES
(1, '2022-05-17', NULL, '4', '3', '200000.00', '100.00', '0.00', '0.00', '234000.00', 1, 50, 50, '2022-05-17 17:38:07', '2022-05-17 17:40:07'),
(2, '2022-05-17', NULL, '4', '3', '200000.00', '100.00', '0.00', '0.00', '434000.00', 1, 50, 50, '2022-05-17 17:41:26', '2022-05-17 17:41:38'),
(7, '2022-05-18', NULL, '1', '3', '7500000.00', '5000.00', '0.00', '0.00', '145000.00', 1, 50, 50, '2022-05-18 19:06:55', '2022-05-18 19:07:06'),
(11, '2022-05-18', NULL, '4', '3', '12050000.00', '6000.00', '0.00', '0.00', '50000.00', 1, 50, 50, '2022-05-18 20:41:05', '2022-05-18 23:17:47'),
(12, '2022-05-17', NULL, '2', '3', '30000.00', '15.00', '0.00', '0.00', '50000.00', 1, 50, 50, '2022-05-18 20:49:33', '2022-05-18 23:41:36'),
(13, '2022-05-17', NULL, '2', '3', '4000.00', '2.00', '0.00', '0.00', '5000.00', 0, 50, NULL, '2022-05-18 20:56:24', '2022-05-18 20:56:24'),
(14, '2022-05-11', NULL, '2', '3', '4000.00', '2.00', '0.00', '0.00', '1000.00', 0, 50, NULL, '2022-05-18 21:05:41', '2022-05-18 21:05:41'),
(15, '2022-05-11', NULL, '2', '3', '4000.00', '2.00', '0.00', '0.00', '1000.00', 0, 50, NULL, '2022-05-18 21:13:27', '2022-05-18 21:13:27'),
(16, '2022-05-11', NULL, '2', '3', '4000.00', '2.00', '0.00', '0.00', '1000.00', 1, 50, 50, '2022-05-18 21:19:13', '2022-05-18 23:18:06'),
(17, '2022-05-20', NULL, '1', '3', '0.00', '100.00', '0.00', '0.00', '400.00', 0, 1, NULL, '2022-05-20 12:29:48', '2022-05-20 12:29:48'),
(18, '2022-05-20', NULL, '4', '3', '0.00', '100.00', '0.00', '0.00', '400.00', 0, 1, NULL, '2022-05-20 12:37:08', '2022-05-20 12:37:08'),
(19, '2022-05-25', NULL, '1', '3', '0.00', '4.00', '0.00', '0.00', '400.00', 0, 1, NULL, '2022-05-20 13:57:09', '2022-05-20 13:57:09'),
(20, '2022-05-21', NULL, '5', '3', '0.00', '5000.00', '360.00', '147.00', '52920.00', 0, 50, NULL, '2022-05-21 19:31:53', '2022-05-21 19:31:53'),
(21, '2022-05-24', NULL, '4', '3', '0.00', '500.00', '10000.00', '2.00', '20000.00', 0, 1, NULL, '2022-05-24 22:35:32', '2022-05-24 22:35:32'),
(24, '2022-05-25', NULL, '5', '3', '0.00', '44800.00', '5000.00', '10.00', '50000.00', 0, 1, NULL, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(25, '2022-05-25', NULL, '2', '3', '0.00', '10.00', '100.00', '50.00', '5000.00', 0, 50, NULL, '2022-05-25 11:47:08', '2022-05-25 11:47:08'),
(26, '2022-05-25', NULL, '2', '3', '0.00', '10.00', '100.00', '50.00', '5000.00', 0, 50, NULL, '2022-05-25 11:59:04', '2022-05-25 11:59:04'),
(27, '2022-05-25', NULL, '2', '3', '0.00', '10.00', '100.00', '50.00', '5000.00', 0, 50, NULL, '2022-05-25 12:00:27', '2022-05-25 12:00:27'),
(28, '2022-05-25', NULL, '5', '3', '0.00', '2000.00', '5000.00', '2.00', '10000.00', 0, 1, NULL, '2022-05-25 12:05:07', '2022-05-25 12:05:07');

-- --------------------------------------------------------

--
-- Table structure for table `cotton_movement_items`
--

CREATE TABLE `cotton_movement_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `movement_id` int(200) NOT NULL,
  `item_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `quantity` decimal(20,2) NOT NULL,
  `total_cost` decimal(20,2) NOT NULL,
  `added_by` int(11) NOT NULL,
  `order_no` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cotton_movement_items`
--

INSERT INTO `cotton_movement_items` (`id`, `movement_id`, `item_id`, `purchase_id`, `price`, `quantity`, `total_cost`, `added_by`, `order_no`, `created_at`, `updated_at`) VALUES
(1, 1, '1', 1, '2000.00', '100.00', '200000.00', 50, 0, '2022-05-17 17:38:07', '2022-05-17 17:38:07'),
(2, 2, '1', 1, '2000.00', '100.00', '200000.00', 50, 0, '2022-05-17 17:41:26', '2022-05-17 17:41:26'),
(12, 11, '1', 2, '2000.00', '3000.00', '0.00', 50, 0, '2022-05-18 20:41:05', '2022-05-18 20:41:05'),
(13, 11, '1', 6, '2000.00', '2500.00', '0.00', 50, 1, '2022-05-18 20:41:05', '2022-05-18 20:41:05'),
(14, 11, '1', 10, '2100.00', '500.00', '0.00', 50, 2, '2022-05-18 20:41:05', '2022-05-18 20:41:05'),
(15, 12, '1', 8, '2000.00', '5.00', '10.00', 50, 0, '2022-05-18 20:49:33', '2022-05-18 20:49:33'),
(16, 12, '1', 9, '2000.00', '10.00', '20.00', 50, 1, '2022-05-18 20:49:33', '2022-05-18 20:49:33'),
(17, 13, '1', 8, '2000.00', '1.00', '2.00', 50, 0, '2022-05-18 20:56:24', '2022-05-18 20:56:24'),
(18, 13, '1', 9, '2000.00', '1.00', '2.00', 50, 1, '2022-05-18 20:56:24', '2022-05-18 20:56:24'),
(19, 14, '1', 8, '2000.00', '1.00', '2000.00', 50, 0, '2022-05-18 21:05:41', '2022-05-18 21:05:41'),
(20, 15, '1', 8, '2000.00', '1.00', '2000.00', 50, 0, '2022-05-18 21:13:27', '2022-05-18 21:13:27'),
(21, 15, '1', 9, '2000.00', '1.00', '2000.00', 50, 1, '2022-05-18 21:13:27', '2022-05-18 21:13:27'),
(22, 16, '1', 8, '2000.00', '1.00', '2000.00', 50, 0, '2022-05-18 21:19:13', '2022-05-18 21:19:13'),
(23, 16, '1', 9, '2000.00', '1.00', '2000.00', 50, 1, '2022-05-18 21:19:13', '2022-05-18 21:19:13'),
(24, 18, '7', 10, '2100.00', '3900.00', '0.00', 1, 0, '2022-05-20 12:37:08', '2022-05-20 12:37:08'),
(25, 19, '4', 7, '2000.00', '146.00', '0.00', 1, 0, '2022-05-20 13:57:09', '2022-05-20 13:57:09'),
(26, 20, '9', 12, '1500.00', '0.00', '0.00', 50, 0, '2022-05-21 19:31:53', '2022-05-21 19:31:53'),
(27, 21, '7', 10, '2100.00', '0.00', '0.00', 1, 0, '2022-05-24 22:35:32', '2022-05-24 22:35:32'),
(28, 21, '8', 11, '2100.00', '9600.00', '0.00', 1, 1, '2022-05-24 22:35:32', '2022-05-24 22:35:32'),
(29, 22, '9', 12, '1500.00', '0.00', '0.00', 1, 0, '2022-05-25 11:00:06', '2022-05-25 11:00:06'),
(30, 22, '11', 15, '2000.00', '0.00', '0.00', 1, 1, '2022-05-25 11:00:06', '2022-05-25 11:00:06'),
(31, 22, '12', 16, '2000.00', '0.00', '0.00', 1, 2, '2022-05-25 11:00:06', '2022-05-25 11:00:06'),
(32, 22, '13', 17, '2000.00', '5200.00', '0.00', 1, 3, '2022-05-25 11:00:06', '2022-05-25 11:00:06'),
(33, 23, '9', 12, '1500.00', '0.00', '0.00', 1, 0, '2022-05-25 11:01:16', '2022-05-25 11:01:16'),
(34, 23, '11', 15, '2000.00', '0.00', '0.00', 1, 1, '2022-05-25 11:01:16', '2022-05-25 11:01:16'),
(35, 23, '12', 16, '2000.00', '0.00', '0.00', 1, 2, '2022-05-25 11:01:16', '2022-05-25 11:01:16'),
(36, 23, '13', 17, '2000.00', '0.00', '0.00', 1, 3, '2022-05-25 11:01:16', '2022-05-25 11:01:16'),
(37, 24, '9', 12, '1500.00', '0.00', '0.00', 1, 0, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(38, 24, '11', 15, '2000.00', '0.00', '0.00', 1, 1, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(39, 24, '12', 16, '2000.00', '0.00', '0.00', 1, 2, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(40, 24, '13', 17, '2000.00', '0.00', '0.00', 1, 3, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(41, 25, '5', 8, '2000.00', '0.00', '0.00', 50, 0, '2022-05-25 11:47:08', '2022-05-25 11:47:08'),
(42, 25, '6', 9, '2000.00', '0.00', '0.00', 50, 1, '2022-05-25 11:47:08', '2022-05-25 11:47:08'),
(43, 26, '5', 8, '2000.00', '0.00', '0.00', 50, 0, '2022-05-25 11:59:04', '2022-05-25 11:59:04'),
(44, 26, '6', 9, '2000.00', '0.00', '0.00', 50, 1, '2022-05-25 11:59:04', '2022-05-25 11:59:04'),
(45, 27, '5', 8, '2000.00', '0.00', '0.00', 50, 0, '2022-05-25 12:00:27', '2022-05-25 12:00:27'),
(46, 27, '6', 9, '2000.00', '0.00', '0.00', 50, 1, '2022-05-25 12:00:27', '2022-05-25 12:00:27'),
(47, 28, '9', 12, '1500.00', '3000.00', '0.00', 1, 0, '2022-05-25 12:05:07', '2022-05-25 12:05:07');

-- --------------------------------------------------------

--
-- Table structure for table `cotton_movement_levy`
--

CREATE TABLE `cotton_movement_levy` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `movement_id` int(200) DEFAULT NULL,
  `levy_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `levy_cost` decimal(20,2) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `order_no` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cotton_movement_levy`
--

INSERT INTO `cotton_movement_levy` (`id`, `movement_id`, `levy_id`, `account_id`, `purchase_id`, `levy_cost`, `added_by`, `order_no`, `created_at`, `updated_at`) VALUES
(1, 1, '72', '', 1, '12000.00', 50, 0, '2022-05-17 17:38:07', '2022-05-17 17:38:07'),
(2, 1, '73', '', 1, '0.00', 50, 1, '2022-05-17 17:38:07', '2022-05-17 17:38:07'),
(3, 2, '72', '', 1, '12000.00', 50, 0, '2022-05-17 17:41:26', '2022-05-17 17:41:26'),
(4, 2, '73', '', 1, '0.00', 50, 1, '2022-05-17 17:41:26', '2022-05-17 17:41:26'),
(15, 14, '72', '', 8, '708.00', 50, 0, '2022-05-18 21:05:41', '2022-05-18 21:05:41'),
(16, 14, '72', '', 8, '708.00', 50, 0, '2022-05-18 21:05:41', '2022-05-18 21:05:41'),
(17, 15, '72', '', 8, '708.00', 50, 0, '2022-05-18 21:13:27', '2022-05-18 21:13:27'),
(18, 15, '73', '', 9, '1000.00', 50, 1, '2022-05-18 21:13:27', '2022-05-18 21:13:27'),
(19, 16, '72', '', 8, '708.00', 50, 0, '2022-05-18 21:19:13', '2022-05-18 21:19:13'),
(20, 16, '73', '', 8, '500.00', 50, 1, '2022-05-18 21:19:13', '2022-05-18 21:19:13'),
(21, 16, '72', '', 9, '1416.00', 50, 0, '2022-05-18 21:19:13', '2022-05-18 21:19:13'),
(22, 16, '73', '', 9, '1000.00', 50, 1, '2022-05-18 21:19:13', '2022-05-18 21:19:13'),
(23, 20, '1', '72', 12, '225000.00', 50, 0, '2022-05-21 19:31:53', '2022-05-21 19:31:53'),
(24, 20, '2', '73', 12, '250000.00', 50, 1, '2022-05-21 19:31:53', '2022-05-21 19:31:53'),
(25, 20, '3', '78', 12, '75000.00', 50, 0, '2022-05-21 19:31:53', '2022-05-21 19:31:53'),
(26, 20, '4', '79', 12, '999999.99', 50, 1, '2022-05-21 19:31:53', '2022-05-21 19:31:53'),
(27, 21, '1', '72', 10, '283500.00', 1, 0, '2022-05-24 22:35:32', '2022-05-24 22:35:32'),
(28, 21, '2', '73', 10, '225000.00', 1, 1, '2022-05-24 22:35:32', '2022-05-24 22:35:32'),
(29, 21, '3', '78', 10, '94500.00', 1, 2, '2022-05-24 22:35:32', '2022-05-24 22:35:32'),
(30, 21, '1', '72', 11, '630000.00', 1, 0, '2022-05-24 22:35:32', '2022-05-24 22:35:32'),
(31, 21, '2', '73', 11, '500000.00', 1, 1, '2022-05-24 22:35:32', '2022-05-24 22:35:32'),
(32, 21, '3', '78', 11, '210000.00', 1, 2, '2022-05-24 22:35:32', '2022-05-24 22:35:32'),
(33, 22, '1', '72', 12, '225000.00', 1, 0, '2022-05-25 11:00:07', '2022-05-25 11:00:07'),
(34, 22, '2', '73', 12, '250000.00', 1, 1, '2022-05-25 11:00:07', '2022-05-25 11:00:07'),
(35, 22, '3', '78', 12, '75000.00', 1, 2, '2022-05-25 11:00:07', '2022-05-25 11:00:07'),
(36, 22, '1', '72', 15, '120000.00', 1, 0, '2022-05-25 11:00:07', '2022-05-25 11:00:07'),
(37, 22, '2', '73', 15, '100000.00', 1, 1, '2022-05-25 11:00:07', '2022-05-25 11:00:07'),
(38, 22, '3', '78', 15, '40000.00', 1, 2, '2022-05-25 11:00:07', '2022-05-25 11:00:07'),
(39, 22, '1', '72', 16, '780000.00', 1, 0, '2022-05-25 11:00:07', '2022-05-25 11:00:07'),
(40, 22, '2', '73', 16, '650000.00', 1, 1, '2022-05-25 11:00:07', '2022-05-25 11:00:07'),
(41, 22, '3', '78', 16, '260000.00', 1, 2, '2022-05-25 11:00:07', '2022-05-25 11:00:07'),
(42, 22, '1', '72', 17, '999999.99', 1, 0, '2022-05-25 11:00:07', '2022-05-25 11:00:07'),
(43, 22, '2', '73', 17, '999999.99', 1, 1, '2022-05-25 11:00:07', '2022-05-25 11:00:07'),
(44, 22, '3', '78', 17, '600000.00', 1, 2, '2022-05-25 11:00:07', '2022-05-25 11:00:07'),
(45, 23, '1', '72', 12, '225000.00', 1, 0, '2022-05-25 11:01:16', '2022-05-25 11:01:16'),
(46, 23, '2', '73', 12, '250000.00', 1, 1, '2022-05-25 11:01:16', '2022-05-25 11:01:16'),
(47, 23, '3', '78', 12, '75000.00', 1, 2, '2022-05-25 11:01:16', '2022-05-25 11:01:16'),
(48, 23, '1', '72', 15, '120000.00', 1, 0, '2022-05-25 11:01:16', '2022-05-25 11:01:16'),
(49, 23, '2', '73', 15, '100000.00', 1, 1, '2022-05-25 11:01:16', '2022-05-25 11:01:16'),
(50, 23, '3', '78', 15, '40000.00', 1, 2, '2022-05-25 11:01:16', '2022-05-25 11:01:16'),
(51, 23, '1', '72', 16, '780000.00', 1, 0, '2022-05-25 11:01:16', '2022-05-25 11:01:16'),
(52, 23, '2', '73', 16, '650000.00', 1, 1, '2022-05-25 11:01:16', '2022-05-25 11:01:16'),
(53, 23, '3', '78', 16, '260000.00', 1, 2, '2022-05-25 11:01:16', '2022-05-25 11:01:16'),
(54, 23, '1', '72', 17, '999999.99', 1, 0, '2022-05-25 11:01:16', '2022-05-25 11:01:16'),
(55, 23, '2', '73', 17, '999999.99', 1, 1, '2022-05-25 11:01:16', '2022-05-25 11:01:16'),
(56, 23, '3', '78', 17, '600000.00', 1, 2, '2022-05-25 11:01:16', '2022-05-25 11:01:16'),
(57, 24, '1', '72', 12, '225000.00', 1, 0, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(58, 24, '2', '73', 12, '250000.00', 1, 1, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(59, 24, '3', '78', 12, '75000.00', 1, 2, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(60, 24, '1', '72', 15, '120000.00', 1, 0, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(61, 24, '2', '73', 15, '100000.00', 1, 1, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(62, 24, '3', '78', 15, '40000.00', 1, 2, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(63, 24, '1', '72', 16, '780000.00', 1, 0, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(64, 24, '2', '73', 16, '650000.00', 1, 1, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(65, 24, '3', '78', 16, '260000.00', 1, 2, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(66, 24, '1', '72', 17, '999999.99', 1, 0, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(67, 24, '2', '73', 17, '999999.99', 1, 1, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(68, 24, '3', '78', 17, '600000.00', 1, 2, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(69, 24, '4', '79', 12, '999999.99', 1, 3, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(70, 24, '4', '79', 15, '500000.00', 1, 3, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(71, 24, '4', '79', 16, '999999.99', 1, 3, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(72, 24, '4', '79', 17, '999999.99', 1, 3, '2022-05-25 11:04:45', '2022-05-25 11:04:45'),
(73, 25, '1', '72', 8, '708.00', 50, 0, '2022-05-25 11:47:08', '2022-05-25 11:47:08'),
(74, 25, '2', '73', 8, '500.00', 50, 1, '2022-05-25 11:47:08', '2022-05-25 11:47:08'),
(75, 25, '3', '78', 8, '236.00', 50, 2, '2022-05-25 11:47:08', '2022-05-25 11:47:08'),
(76, 25, '1', '72', 9, '1416.00', 50, 0, '2022-05-25 11:47:08', '2022-05-25 11:47:08'),
(77, 25, '2', '73', 9, '1000.00', 50, 1, '2022-05-25 11:47:08', '2022-05-25 11:47:08'),
(78, 25, '3', '78', 9, '472.00', 50, 2, '2022-05-25 11:47:08', '2022-05-25 11:47:08'),
(79, 26, '1', '72', 8, '708.00', 50, 0, '2022-05-25 11:59:04', '2022-05-25 11:59:04'),
(80, 26, '2', '73', 8, '500.00', 50, 1, '2022-05-25 11:59:04', '2022-05-25 11:59:04'),
(81, 26, '3', '78', 8, '236.00', 50, 2, '2022-05-25 11:59:04', '2022-05-25 11:59:04'),
(82, 26, '1', '72', 9, '1416.00', 50, 0, '2022-05-25 11:59:04', '2022-05-25 11:59:04'),
(83, 26, '2', '73', 9, '1000.00', 50, 1, '2022-05-25 11:59:04', '2022-05-25 11:59:04'),
(84, 26, '3', '78', 9, '472.00', 50, 2, '2022-05-25 11:59:04', '2022-05-25 11:59:04'),
(85, 27, '1', '72', 8, '708.00', 50, 0, '2022-05-25 12:00:27', '2022-05-25 12:00:27'),
(86, 27, '2', '73', 8, '500.00', 50, 1, '2022-05-25 12:00:27', '2022-05-25 12:00:27'),
(87, 27, '3', '78', 8, '236.00', 50, 2, '2022-05-25 12:00:27', '2022-05-25 12:00:27'),
(88, 27, '1', '72', 9, '1416.00', 50, 0, '2022-05-25 12:00:27', '2022-05-25 12:00:27'),
(89, 27, '2', '73', 9, '1000.00', 50, 1, '2022-05-25 12:00:27', '2022-05-25 12:00:27'),
(90, 27, '3', '78', 9, '472.00', 50, 2, '2022-05-25 12:00:27', '2022-05-25 12:00:27'),
(91, 28, '1', '72', 12, '225000.00', 1, 0, '2022-05-25 12:05:07', '2022-05-25 12:05:07'),
(92, 28, '2', '73', 12, '250000.00', 1, 1, '2022-05-25 12:05:07', '2022-05-25 12:05:07'),
(93, 28, '3', '78', 12, '75000.00', 1, 2, '2022-05-25 12:05:07', '2022-05-25 12:05:07'),
(94, 28, '4', '79', 12, '1250000.00', 1, 3, '2022-05-25 12:05:07', '2022-05-25 12:05:07');

-- --------------------------------------------------------

--
-- Table structure for table `cotton_payments`
--

CREATE TABLE `cotton_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trans_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `date` date NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `created_at`, `updated_at`, `name`, `code`) VALUES
(1, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 'Tanzania', 'TZ');

-- --------------------------------------------------------

--
-- Table structure for table `courier`
--

CREATE TABLE `courier` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pacel_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pacel_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `due_date` date NOT NULL,
  `owner_id` int(11) NOT NULL,
  `confirmation_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` decimal(20,2) NOT NULL,
  `route_id` int(100) NOT NULL,
  `receiver_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `docs` int(100) DEFAULT 0,
  `non_docs` int(100) DEFAULT 0,
  `bags` int(100) DEFAULT 0,
  `mobile` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exchange_rate` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `tax` decimal(20,2) DEFAULT NULL,
  `due_amount` decimal(20,2) DEFAULT NULL,
  `discount` decimal(20,2) DEFAULT 0.00,
  `instructions` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `good_receive` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courier`
--

INSERT INTO `courier` (`id`, `pacel_name`, `pacel_number`, `date`, `due_date`, `owner_id`, `confirmation_number`, `weight`, `route_id`, `receiver_name`, `docs`, `non_docs`, `bags`, `mobile`, `currency_code`, `exchange_rate`, `amount`, `tax`, `due_amount`, `discount`, `instructions`, `good_receive`, `status`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Shop Shipment', 'CM-1', '2022-05-11', '2022-05-14', 3, 'CM-tW1v1', '5.00', 9, 'John Doe', 0, 2, 0, '+255713000000', 'TZS', '1.00', '337500.00', '0.00', '62500.00', '37500.00', 'keep the cargo safe', '1', '1', 1, '2022-05-11 21:27:23', '2022-05-23 13:33:37'),
(2, 'Office Eqipment', 'CM-2', '2022-05-09', '2022-05-13', 1, 'CM-OqkZ2', '50.00', 1, 'Anna', 0, 1, 0, '+255655123456', 'TZS', '1.00', '2950000.00', '450000.00', '2950000.00', '0.00', NULL, '0', '0', 1, '2022-05-11 21:47:00', '2022-05-11 21:47:00'),
(3, 'Clothes', 'CM-3', '2022-05-09', '2022-05-11', 4, 'CM-FtVI3', '5.00', 9, 'Sarah Gepfrey', 0, 1, NULL, '+255714456789', 'EUR', '1850.00', '23.60', '3.60', '23.60', '0.00', NULL, '0', '7', 1, '2022-05-11 21:50:11', '2022-05-11 21:50:41');

-- --------------------------------------------------------

--
-- Table structure for table `courier_activities`
--

CREATE TABLE `courier_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `activity` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loading_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courier_activities`
--

INSERT INTO `courier_activities` (`id`, `module_id`, `module`, `date`, `activity`, `notes`, `loading_id`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', 'Courier', '2022-05-11', 'Confirm Collection', 'to be covered properly', 1, 1, '2022-05-11 23:18:30', '2022-05-11 23:18:30'),
(2, '1', 'Courier', '2022-05-11', 'Confirm Loading', 'to be loaded safely', 1, 1, '2022-05-11 23:24:08', '2022-05-11 23:24:08'),
(3, '1', 'Courier', '2022-05-11', 'Confirm Offloading', 'offloaded safely', 1, 1, '2022-05-11 23:24:49', '2022-05-11 23:24:49'),
(4, '1', 'Courier', '2022-05-12', 'Confirm Delivery', 'delivered safe at the office and on time', 1, 1, '2022-05-11 23:25:49', '2022-05-11 23:25:49');

-- --------------------------------------------------------

--
-- Table structure for table `courier_clients`
--

CREATE TABLE `courier_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TIN` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courier_clients`
--

INSERT INTO `courier_clients` (`id`, `user_id`, `name`, `address`, `phone`, `email`, `TIN`, `created_at`, `updated_at`) VALUES
(1, '1', 'Juma Shabani', 'Bagamoyo,Pwani', '+255655100200', 'proedu2009@gmail.com', NULL, '2022-05-11 20:51:50', '2022-05-11 20:53:30'),
(2, '1', 'Christina John', 'P.o box 1185,Dar es Salaam', '+255713123456', 'christinajohn@gmail.com', '456712349', '2022-05-11 20:52:54', '2022-05-11 21:03:50'),
(3, '1', 'John Doe', 'Pwani', '+255713000000', 'johndoe@gmail.com', NULL, '2022-05-11 21:23:14', '2022-05-11 21:23:14'),
(4, '1', 'Sarah Geofrey', 'Moshono,Arusha', '+255754890345', 'sarah95@gmail.com', NULL, '2022-05-11 21:24:38', '2022-05-11 21:24:38');

-- --------------------------------------------------------

--
-- Table structure for table `courier_collection`
--

CREATE TABLE `courier_collection` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pacel_id` int(100) NOT NULL,
  `pacel_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pacel_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_id` int(11) NOT NULL,
  `receiver_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route_id` int(100) NOT NULL,
  `start_location` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_location` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` decimal(20,2) NOT NULL,
  `due_weight` decimal(20,2) NOT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courier_collection`
--

INSERT INTO `courier_collection` (`id`, `pacel_id`, `pacel_number`, `pacel_name`, `owner_id`, `receiver_name`, `route_id`, `start_location`, `end_location`, `weight`, `due_weight`, `amount`, `status`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'CM-1', 'Shop Shipment', 3, 'John Doe', 9, '18', '2', '5.00', '0.00', '337500.00', '3', 1, '2022-05-11 21:43:15', '2022-05-11 23:18:30');

-- --------------------------------------------------------

--
-- Table structure for table `courier_items`
--

CREATE TABLE `courier_items` (
  `id` int(11) NOT NULL,
  `pacel_id` int(11) NOT NULL,
  `tax_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_tax` decimal(20,2) NOT NULL DEFAULT 0.00,
  `quantity` decimal(10,2) DEFAULT 0.00,
  `total_cost` decimal(20,2) NOT NULL DEFAULT 0.00,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `unit` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL DEFAULT 0,
  `order_no` int(11) DEFAULT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `courier_items`
--

INSERT INTO `courier_items` (`id`, `pacel_id`, `tax_rate`, `total_tax`, `quantity`, `total_cost`, `item_name`, `price`, `unit`, `items_id`, `order_no`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 1, '0.00', '0.00', '5.00', '175000.00', '2', '35000.00', 'pairs', 2, 0, 1, '2022-05-11 21:27:23', '2022-05-11 21:32:55'),
(2, 1, '0.00', '0.00', '20.00', '200000.00', '3', '10000.00', 'inch', 3, 1, 1, '2022-05-11 21:27:23', '2022-05-11 21:32:55'),
(3, 2, '0.18', '450000.00', '5.00', '2500000.00', '1', '500000.00', 'pcs', 1, 0, 1, '2022-05-11 21:47:00', '2022-05-11 21:47:00'),
(4, 3, '0.18', '3.60', '4.00', '20.00', '3', '5.00', 'inch', 3, 0, 1, '2022-05-11 21:50:11', '2022-05-11 21:50:11');

-- --------------------------------------------------------

--
-- Table structure for table `courier_lists`
--

CREATE TABLE `courier_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `unit` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(200) DEFAULT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courier_lists`
--

INSERT INTO `courier_lists` (`id`, `name`, `price`, `unit`, `quantity`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Laptop', '500000.00', 'pcs', NULL, 1, '2022-05-11 20:33:29', '2022-05-11 20:34:12'),
(2, 'Shoes', '35000.00', 'pairs', NULL, 1, '2022-05-11 20:34:46', '2022-05-11 20:34:46'),
(3, 'Shirts', '10000.00', 'inch', NULL, 1, '2022-05-11 20:35:48', '2022-05-11 20:35:48');

-- --------------------------------------------------------

--
-- Table structure for table `courier_loading`
--

CREATE TABLE `courier_loading` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pacel_id` int(100) NOT NULL,
  `pacel_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pacel_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_id` int(11) NOT NULL,
  `receiver_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_location` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_id` int(100) NOT NULL,
  `end_location` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` int(11) NOT NULL,
  `total_weight` int(100) DEFAULT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `truck_id` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_id` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_date` date NOT NULL,
  `fuel` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courier_loading`
--

INSERT INTO `courier_loading` (`id`, `pacel_id`, `pacel_number`, `pacel_name`, `owner_id`, `receiver_name`, `start_location`, `route_id`, `end_location`, `weight`, `total_weight`, `amount`, `status`, `type`, `truck_id`, `driver_id`, `collection_date`, `fuel`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'CM-1', 'Shop Shipment', 3, 'John Doe', '18', 9, '2', 5, 5, '337500.00', '6', 'non_owned', 'T456 ABC', 'Peter Abraham', '2022-05-11', '0', 1, '2022-05-11 23:18:30', '2022-05-11 23:25:49');

-- --------------------------------------------------------

--
-- Table structure for table `courier_payments`
--

CREATE TABLE `courier_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pacel_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trans_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `date` date NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` int(200) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courier_payments`
--

INSERT INTO `courier_payments` (`id`, `pacel_id`, `trans_id`, `amount`, `date`, `payment_method`, `notes`, `account_id`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', 'TRANS_CM_1_gsSB', '175000.00', '2022-05-11', '1', 'paid half first', 28, 1, '2022-05-11 22:27:47', '2022-05-11 22:29:39'),
(2, '1', 'TRANS_CM_1_ZoUR', '100000.00', '2022-05-23', '3', NULL, 6, 1, '2022-05-23 13:21:39', '2022-05-23 13:32:43');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'HR', '2022-05-03 21:16:52', '2022-05-03 21:16:52'),
(2, 'Finance', '2022-05-03 21:17:08', '2022-05-03 21:17:08'),
(3, 'Marketing', '2022-05-03 21:17:26', '2022-05-03 21:17:26'),
(4, 'IT', '2022-05-03 21:17:37', '2022-05-03 21:17:37'),
(5, 'Operations', '2022-05-03 22:01:48', '2022-05-03 22:01:48');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `department_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Accountant', '2', '1', '2022-05-03 21:52:37', '2022-05-03 21:52:37'),
(2, 'Software Developer', '4', '1', '2022-05-03 21:57:15', '2022-05-03 21:57:15'),
(3, 'Human Resource Officer', '1', '1', '2022-05-03 21:57:52', '2022-05-03 21:57:52'),
(4, 'Digital Marketing', '3', '1', '2022-05-03 21:58:17', '2022-05-03 21:58:17'),
(5, 'Logistic', '5', '1', '2022-05-03 22:02:12', '2022-05-03 22:02:12'),
(6, 'Agronomist', '5', '1', '2022-05-08 19:49:34', '2022-05-08 19:49:34');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `region_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `levy_status` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `levy_id` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` int(200) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `region_id`, `name`, `levy_status`, `levy_id`, `added_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(117, 21, 'KISHAPU', '1', '4', 50, NULL, '2022-04-12 01:37:26', '2022-05-25 10:31:15'),
(118, 21, 'SHINYANGA MJINI', NULL, NULL, 50, NULL, '2022-04-12 01:37:26', '2022-04-12 01:37:26'),
(122, 22, 'MASWA', NULL, NULL, 50, NULL, '2022-04-12 01:37:26', '2022-04-12 01:37:26'),
(123, 22, 'MEATU', NULL, NULL, 50, NULL, '2022-04-12 01:37:26', '2022-04-12 01:37:26'),
(130, 25, 'IGUNGA', NULL, NULL, 50, NULL, '2022-04-12 01:37:26', '2022-04-12 01:37:26'),
(156, 21, 'SHINYANGA VIJIJINI', NULL, NULL, 50, NULL, '2022-04-12 01:37:26', '2022-04-12 01:37:26'),
(157, 21, 'KAHAMA', '1', '4', 50, NULL, '2022-05-25 10:32:55', '2022-05-25 10:32:55');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referee` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `available` int(200) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `driver_name`, `address`, `referee`, `experience`, `profile`, `type`, `driver_status`, `added_by`, `available`, `created_at`, `updated_at`) VALUES
(1, 'Jumanne Ally Hassa', 'Mwembe Yanga Dar es salaam', 'Halima Juma Mwakitende', '5 years', 'seed_1649177555.PNG', 'owned', 'Permanent Driver', 19, 0, '2022-04-05 20:52:35', '2022-04-28 23:10:17'),
(2, 'Jumanne Ally Hassal', 'ubungo', 'Halima Juma Mwakitende', '5 years', 'final_logo_prst_1649753578.png', 'owned', 'Permanent Driver', 19, 0, '2022-04-12 12:52:58', '2022-05-18 12:21:00'),
(3, 'John Mashauri', 'Mvomero,Morogoro', 'Hamisi Juma', '2 years', 'alita_battle_angel_short_black_hair_alita_holding_sword_on_shoulder_hd_movies-1280x720_1650911518.jpg', 'non_owned', 'Permanent Driver', 19, 1, '2022-04-25 22:28:20', '2022-05-20 22:59:21'),
(4, 'said isiaka', 'ilala,dar es salaam', 'sese', '5 years', 'image_picker1421275901_1651661208.jpg', 'non_owned', 'Permanent Driver', 19, 1, '2022-05-04 14:46:48', '2022-05-20 23:01:35');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `farmers`
--

CREATE TABLE `farmers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region_id` int(200) NOT NULL,
  `district_id` int(200) NOT NULL,
  `ward_id` int(200) NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `assign` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `farmers`
--

INSERT INTO `farmers` (`id`, `firstname`, `lastname`, `phone`, `email`, `region_id`, `district_id`, `ward_id`, `address`, `user_id`, `group_id`, `assign`, `created_at`, `updated_at`) VALUES
(1, 'Mkulima', 'Mosha', '0655973246', 'mainl@mailcom', 23, 124, 194, 'Singida Ikungi', 1, 0, NULL, '2022-04-11 17:59:05', '2022-05-08 12:14:08'),
(2, 'John', 'Doe', '0655306060', 'example@example.com', 1, 3, 1105, 'test', 20, 0, '29', '2022-04-11 17:47:51', '2022-04-12 20:55:12'),
(6, 'Awadhi Juma', 'Ally', '37662222', 'awadhi9@gmai.com', 9, 47, 1247, 'shimbi/kati', 20, 6, NULL, '2022-05-08 12:51:38', '2022-05-08 12:51:38'),
(7, 'Awadhi Juma', 'Hamis', '0712722684', 'awadhi9@gmai.com', 1, 1, 3232, 'Sombetinf:dfhh', 20, 6, NULL, '2022-05-08 12:59:20', '2022-05-08 12:59:20');

-- --------------------------------------------------------

--
-- Table structure for table `farm_lands`
--

CREATE TABLE `farm_lands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `farmer_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `regno` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ownership` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `farm_program`
--

CREATE TABLE `farm_program` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `season_id` int(200) NOT NULL,
  `gap` varchar(200) NOT NULL,
  `cost` decimal(20,2) DEFAULT NULL,
  `acre` decimal(20,2) NOT NULL,
  `total_cost` decimal(20,2) NOT NULL,
  `distributor` varchar(200) NOT NULL,
  `added_by` int(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `farm_program`
--

INSERT INTO `farm_program` (`id`, `name`, `season_id`, `gap`, `cost`, `acre`, `total_cost`, `distributor`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Levelilng', 7, '2', '60000.00', '4.00', '240000.00', 'hjsvdv', 20, '2022-04-12 20:52:43', '2022-04-12 20:52:43'),
(2, 'land preparation', 9, '2', '50000.00', '6.00', '300000.00', 'yy', 39, '2022-04-21 14:28:17', '2022-04-21 14:28:17'),
(3, 'Land cultivation', 10, '2', '50000.00', '2.00', '100000.00', 'to be identify', 20, '2022-05-11 21:21:56', '2022-05-11 21:21:56'),
(4, 'Land leveling', 10, '2', '10000.00', '2.00', '20000.00', 'to be identify', 20, '2022-05-11 21:22:50', '2022-05-11 21:22:50'),
(5, 'Acidic control', 10, '2', '20000.00', '2.00', '40000.00', 'to be identify', 20, '2022-05-11 21:23:37', '2022-05-11 21:23:37'),
(6, 'sowing', 10, '3', '70000.00', '2.00', '140000.00', 'to be identify', 20, '2022-05-11 21:24:17', '2022-05-11 21:24:17'),
(7, 'fertilizer and manual', 10, '4', '120000.00', '2.00', '240000.00', 'to be identify', 20, '2022-05-11 21:25:07', '2022-05-11 21:25:07'),
(8, 'Weeding', 10, '1', '100000.00', '2.00', '200000.00', 'to be identify', 20, '2022-05-11 21:25:59', '2022-05-11 21:25:59');

-- --------------------------------------------------------

--
-- Table structure for table `feed_type`
--

CREATE TABLE `feed_type` (
  `id` int(100) NOT NULL,
  `crop_name` varchar(100) NOT NULL,
  `feed_name` varchar(200) NOT NULL,
  `characteristics` text DEFAULT NULL,
  `added_by` int(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feed_type`
--

INSERT INTO `feed_type` (`id`, `crop_name`, `feed_name`, `characteristics`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', 'Seed A', 'test', 1, '2022-04-04 21:55:07', '2022-04-05 13:06:41'),
(2, '4', 'Seed B', 'Need high rainfall or water volume', 20, '2022-04-12 19:51:04', '2022-04-12 19:51:04'),
(3, '1', 'c130', 'hello', 20, '2022-05-08 11:35:25', '2022-05-08 11:35:25'),
(4, '8', 'c130', 'tabia mbegu', 20, '2022-05-09 19:43:42', '2022-05-09 19:43:42'),
(5, '9', 'Karanga nyekundu', 'text', 20, '2022-05-09 20:26:42', '2022-05-09 20:26:42'),
(6, '1', 'g492', 'any content,', 20, '2022-05-11 21:04:20', '2022-05-11 21:04:20');

-- --------------------------------------------------------

--
-- Table structure for table `field_staff`
--

CREATE TABLE `field_staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `field_staff`
--

INSERT INTO `field_staff` (`id`, `name`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Said Issaya', 19, '2022-04-06 10:08:29', '2022-04-06 10:08:29');

-- --------------------------------------------------------

--
-- Table structure for table `fuels`
--

CREATE TABLE `fuels` (
  `id` int(200) NOT NULL,
  `truck_id` varchar(200) NOT NULL,
  `driver_id` varchar(191) DEFAULT NULL,
  `route_id` varchar(200) NOT NULL,
  `fuel_rate` decimal(20,2) DEFAULT NULL,
  `fuel_used` decimal(20,2) NOT NULL,
  `due_fuel` decimal(20,2) NOT NULL,
  `fuel_adjustment` decimal(20,2) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `status_approve` int(200) NOT NULL,
  `approved_by` int(100) DEFAULT NULL,
  `movement_id` int(200) DEFAULT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fuels`
--

INSERT INTO `fuels` (`id`, `truck_id`, `driver_id`, `route_id`, `fuel_rate`, `fuel_used`, `due_fuel`, `fuel_adjustment`, `reason`, `status_approve`, `approved_by`, `movement_id`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '3', '2', '4', '4.81', '90.00', '90.00', NULL, NULL, 0, NULL, 1, 53, '2022-04-24 02:24:15', '2022-05-18 13:40:18'),
(2, '2', '1', '4', '5.50', '78.64', '78.64', NULL, NULL, 0, NULL, 3, 19, '2022-04-24 02:25:20', '2022-04-24 02:25:20'),
(5, '3', '2', '5', '3.00', '27.66', '27.66', NULL, NULL, 0, NULL, NULL, 19, '2022-04-25 14:14:14', '2022-04-25 14:14:14'),
(7, '7', '3', '7', '3.00', '340.33', '340.33', NULL, NULL, 0, NULL, NULL, 19, '2022-04-28 23:07:01', '2022-04-28 23:07:01'),
(8, '6', '2', '3', '2.50', '249.72', '249.72', NULL, NULL, 0, NULL, 4, 19, '2022-04-28 23:14:42', '2022-04-28 23:14:42'),
(9, '7', '1', '6', '2.80', '278.57', '278.57', NULL, NULL, 0, NULL, 5, 19, '2022-04-28 23:15:14', '2022-04-28 23:15:14'),
(10, '6', '1', '8', '3.50', '178.29', '0.00', NULL, NULL, 0, NULL, NULL, 19, '2022-04-28 23:20:06', '2022-04-28 23:51:36'),
(11, '1', NULL, '2', '23.00', '19.35', '19.35', NULL, NULL, 0, NULL, NULL, 19, '2022-05-07 15:47:36', '2022-05-07 15:47:36'),
(12, '9', '1', '10', '2.50', '180.00', '130.00', '20.00', 'FHHJ', 1, 53, NULL, 53, '2022-05-17 14:38:08', '2022-05-17 14:52:57'),
(13, '9', '2', '7', '2.50', '408.40', '404.40', NULL, NULL, 0, NULL, 6, 53, '2022-05-17 15:27:51', '2022-05-23 14:12:43'),
(14, '1', NULL, '5', '2.50', '33.20', '33.20', NULL, NULL, 0, NULL, NULL, 53, '2022-05-18 12:16:33', '2022-05-18 12:16:33'),
(15, '8', NULL, '3', NULL, '25.00', '22.00', NULL, NULL, 0, NULL, NULL, 1, '2022-05-20 15:49:25', '2022-05-20 15:53:23'),
(16, '8', '3', '11', NULL, '5.00', '5.00', NULL, NULL, 0, NULL, 8, 1, '2022-05-20 22:51:16', '2022-05-20 22:51:16'),
(17, '5', '4', '11', NULL, '5.00', '5.00', NULL, NULL, 0, NULL, 9, 1, '2022-05-20 22:57:31', '2022-05-20 22:57:31');

-- --------------------------------------------------------

--
-- Table structure for table `gl_account_class`
--

CREATE TABLE `gl_account_class` (
  `id` int(11) NOT NULL,
  `class_id` varchar(200) NOT NULL,
  `class_name` varchar(500) NOT NULL,
  `class_type` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gl_account_class`
--

INSERT INTO `gl_account_class` (`id`, `class_id`, `class_name`, `class_type`) VALUES
(10, '1100', 'Current Assets', 'Assets'),
(11, '1200', 'Non Current Assets', 'Assets'),
(12, '2100', 'Current Liabilty', 'Liability'),
(13, '2200', 'Non Current Liabilty', 'Liability'),
(14, '3100', 'Capital', 'Equity'),
(15, '4100', 'INCOME', 'Income'),
(16, '4200', 'Other Income', 'Income'),
(17, '5000', 'EXPENSES', 'Expense');

-- --------------------------------------------------------

--
-- Table structure for table `gl_account_codes`
--

CREATE TABLE `gl_account_codes` (
  `id` int(11) NOT NULL,
  `account_codes` int(200) NOT NULL,
  `account_name` varchar(200) NOT NULL,
  `account_group` varchar(200) NOT NULL,
  `account_type` varchar(500) NOT NULL,
  `account_status` varchar(200) NOT NULL,
  `allow_manual` tinyint(4) NOT NULL DEFAULT 0,
  `account_id` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gl_account_codes`
--

INSERT INTO `gl_account_codes` (`id`, `account_codes`, `account_name`, `account_group`, `account_type`, `account_status`, `allow_manual`, `account_id`) VALUES
(4, 1141, 'Receivable and Prepayments', 'Receivables', 'Assets', 'Active', 0, '4'),
(6, 1122, 'CRDB', 'Cash and Cash Equivalent', 'Assets', 'Active', 0, '6'),
(7, 1112, 'Petty Cash', 'Cash and Cash Equivalent', 'Assets', 'Active', 0, '7'),
(8, 1210, 'Furniture and Office Equipment', 'Fixed Assets', 'Assets', 'Active', 0, '8'),
(9, 1230, 'Land and Building', 'Fixed Assets', 'Assets', 'Active', 0, '9'),
(10, 2206, 'Deffered Tax', 'Creditors', 'Liability', 'Active', 0, '10'),
(11, 3105, 'Retained Surplus/(Deficity)', 'Retained Earnings/Loss', 'Equity', 'Active', 0, '11'),
(12, 3106, 'Annual Surplus/Deficity', 'Retained Earnings/Loss', 'Equity', 'Active', 0, '12'),
(13, 5201, 'Salaries And Wages', 'Personnel Expenses', 'Expense', 'Active', 0, '13'),
(14, 5202, 'NSSF', 'Personnel Expenses', 'Expense', 'Active', 0, '14'),
(15, 5302, 'Medical Insurance', 'Administrative Expenses', 'Expense', 'Active', 0, '15'),
(16, 2204, 'Payables', 'Creditors', 'Liability', 'Active', 0, '16'),
(17, 4203, 'Parcel', 'Income', 'Income', 'Active', 0, '17'),
(19, 5000, 'Fuel', 'Logistic Expenses', 'Expense', 'Active', 0, '19'),
(20, 5100, 'Tire', 'Logistic Expenses', 'Expense', 'Active', 0, '20'),
(21, 5200, 'Inventory', 'Logistic Expenses', 'Expense', 'Active', 0, '21'),
(22, 7400, 'VAT IN', '', '', 'Active', 0, '22'),
(23, 7500, 'VAT OUT', '', '', 'Active', 0, '23'),
(24, 4111, 'Bank of Africa (BOA)=>USD', 'Cash and Cash Equivalent', 'Assets', 'Active', 0, '24'),
(25, 4112, 'NBC', 'Cash and Cash Equivalent', 'Assets', 'Active', 0, '25'),
(26, 4113, 'TCB', 'Cash and Cash Equivalent', 'Assets', 'Active', 0, '26'),
(27, 4114, 'MPESA', 'Cash and Cash Equivalent', 'Assets', 'Active', 0, '27'),
(28, 4115, 'TIGO PESA', 'Cash and Cash Equivalent', 'Assets', 'Active', 0, '28'),
(29, 4116, 'AIRTEL MONEY', 'Cash and Cash Equivalent', 'Assets', 'Active', 0, '29'),
(30, 1512, 'Transport and Travelling', 'Administrative Expenses', 'Expense', 'Active', 0, '30'),
(31, 4118, 'NMB', 'Cash and Cash Equivalent', 'Assets', 'Active', 0, '31'),
(32, 4119, 'Cash Account', 'Cash and Cash Equivalent', 'Assets', 'Active', 0, '32'),
(33, 1510, 'Maintenance and Repair', 'Administrative Expenses', 'Expense', 'Active', 0, '33'),
(34, 1518, 'Fuel Expenses', 'Administrative Expenses', 'Expense', 'Active', 0, '34'),
(35, 4122, 'Bank of Africa (BOA)=>TZS', 'Cash and Cash Equivalent', 'Assets', 'Active', 0, '35'),
(36, 4123, 'Tanzania Commercial Bank=>TZS', 'Cash and Cash Equivalent', 'Assets', 'Active', 0, '36'),
(37, 4124, 'Tanzania Commercial Bank=>USD', 'Cash and Cash Equivalent', 'Assets', 'Active', 0, '37'),
(38, 1625, 'Licence', 'Administrative Expenses', 'Expense', 'Active', 0, '38'),
(39, 1626, 'Insurance', 'Administrative Expenses', 'Expense', 'Active', 0, '39'),
(40, 5300, 'Mileage', 'Logistic Expenses', 'Expense', 'Active', 0, '40'),
(41, 5402, 'Training', 'Administrative Expenses', 'Expense', 'Active', 0, '41'),
(42, 1525, 'PAYE', 'Personnel Expenses', 'Expense', 'Active', 0, '42'),
(43, 1524, 'NSSF', 'Personnel Expenses', 'Expense', 'Active', 0, '43'),
(44, 1524, 'NSSF (Employer Contribution)', 'Administrative Expenses', 'Expense', 'Active', 0, '44'),
(45, 1524, 'NSSF (Employer Contribution)', 'Administrative Expenses', 'Expense', 'Active', 0, '45'),
(46, 1527, 'WCF contribution', 'Administrative Expenses', 'Expense', 'Active', 0, '46'),
(47, 1529, 'WCF', 'Personnel Expenses', 'Expense', 'Active', 0, '47'),
(49, 1517, 'NHIF (Heath Insurance Expense)', 'Administrative Expenses', 'Expense', 'Active', 0, '49'),
(50, 1520, 'NHIF', 'Personnel Expenses', 'Expense', 'Active', 0, '50'),
(51, 1530, 'Advance Salary', 'Personnel Expenses', 'Expense', 'Active', 0, '51'),
(52, 1531, 'Employee Loan', 'Personnel Expenses', 'Expense', 'Active', 0, '52'),
(53, 1532, 'Overtime', 'Personnel Expenses', 'Expense', 'Active', 0, '53'),
(54, 1533, 'Employee Award', 'Personnel Expenses', 'Expense', 'Active', 0, '54'),
(56, 4204, 'Courier', 'Income', 'Income', 'Active', 0, '56');

-- --------------------------------------------------------

--
-- Table structure for table `gl_account_group`
--

CREATE TABLE `gl_account_group` (
  `id` int(200) NOT NULL,
  `group_id` int(200) NOT NULL,
  `name` varchar(500) NOT NULL,
  `class` varchar(500) NOT NULL,
  `type` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gl_account_group`
--

INSERT INTO `gl_account_group` (`id`, `group_id`, `name`, `class`, `type`) VALUES
(11, 1130, 'Receivables', 'Current Assets', 'Assets'),
(12, 1140, 'Cash and Cash Equivalent', 'Current Assets', 'Assets'),
(13, 1210, 'Fixed Assets', 'Non Current Assets', 'Assets'),
(14, 2150, 'Retained Earnings/Loss', 'Capital', 'Equity'),
(15, 3210, 'Creditors', 'Current Liabilty', 'Liability'),
(16, 5110, 'Income', 'INCOME', 'Income'),
(17, 6180, 'Financial Cost', 'EXPENSES', 'Expense'),
(18, 6120, 'Administrative Expenses', 'EXPENSES', 'Expense'),
(19, 6120, 'Personnel Expenses', 'EXPENSES', 'Expense'),
(20, 7000, 'Logistic Expenses', 'EXPENSES', 'Expense');

-- --------------------------------------------------------

--
-- Table structure for table `gl_account_type`
--

CREATE TABLE `gl_account_type` (
  `account_type_id` int(100) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gl_account_type`
--

INSERT INTO `gl_account_type` (`account_type_id`, `type`) VALUES
(1, 'Assets'),
(2, 'Liability'),
(3, 'Equity'),
(4, 'Expense'),
(5, 'Income');

-- --------------------------------------------------------

--
-- Table structure for table `gmembers`
--

CREATE TABLE `gmembers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `good_disposals`
--

CREATE TABLE `good_disposals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `staff` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `good_issues`
--

CREATE TABLE `good_issues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `staff` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `good_issue_items`
--

CREATE TABLE `good_issue_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issue_id` int(11) NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `added_by` int(11) NOT NULL,
  `order_no` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `good_movements`
--

CREATE TABLE `good_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `staff` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source_location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination_location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `good_reallocations`
--

CREATE TABLE `good_reallocations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `staff` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source_truck` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination_truck` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `good_returns`
--

CREATE TABLE `good_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `staff` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `truck` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `good_return_items`
--

CREATE TABLE `good_return_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_id` int(11) NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `added_by` int(11) NOT NULL,
  `order_no` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'vijana kwanza', 1, '2022-01-31 08:57:18', '2022-01-31 08:57:18'),
(3, 'test group', 1, '2022-01-31 09:43:54', '2022-01-31 09:43:54'),
(5, 'sam', 1, '2022-02-19 13:56:42', '2022-02-19 13:56:42'),
(6, 'Mwantuma', 20, '2022-03-22 11:17:14', '2022-03-22 11:17:14'),
(7, 'wakulima', 38, '2022-04-21 07:39:33', '2022-04-21 07:39:33');

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `name`, `unit`, `quantity`, `price`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'filter', 'pc', 17, '23000.00', 1, '2022-04-12 13:10:13', '2022-05-16 17:49:05'),
(2, 'pump', 'PC', 11, '65000.00', 19, '2022-04-12 13:10:50', '2022-04-25 15:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_histories`
--

CREATE TABLE `inventory_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `supplier_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_histories`
--

INSERT INTO `inventory_histories` (`id`, `purchase_id`, `items_id`, `quantity`, `supplier_id`, `purchase_date`, `location`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', 1, '3.00', '1', '2022-04-19', '1', 19, '2022-04-25 15:03:31', '2022-04-25 15:03:31'),
(2, '1', 2, '2.00', '1', '2022-04-19', '1', 19, '2022-04-25 15:03:31', '2022-04-25 15:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_list`
--

CREATE TABLE `inventory_list` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `serial_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `truck_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `assign_reference` int(200) NOT NULL DEFAULT 0,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_list`
--

INSERT INTO `inventory_list` (`id`, `serial_no`, `reference`, `brand_id`, `purchase_id`, `purchase_date`, `location`, `truck_id`, `status`, `assign_reference`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'filter_1_1_2022', '9011', '1', '1', '2022-04-19', '1', '', 0, 1, 19, '2022-04-25 15:03:31', '2022-05-20 12:18:38'),
(2, 'filter_1_2_2022', NULL, '1', '1', '2022-04-19', '1', '', 0, 0, 19, '2022-04-25 15:03:31', '2022-04-25 15:03:31'),
(3, 'filter_1_3_2022', NULL, '1', '1', '2022-04-19', '1', '', 0, 0, 19, '2022-04-25 15:03:31', '2022-04-25 15:03:31'),
(4, 'pump_1_1_2022', '55555', '2', '1', '2022-04-19', '1', '', 0, 1, 19, '2022-04-25 15:03:31', '2022-05-19 23:38:47'),
(5, 'pump_1_2_2022', '57555', '2', '1', '2022-04-19', '1', '', 0, 1, 19, '2022-04-25 15:03:31', '2022-05-23 21:44:55');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_payments`
--

CREATE TABLE `inventory_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trans_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `date` date NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_payments`
--

INSERT INTO `inventory_payments` (`id`, `purchase_id`, `trans_id`, `amount`, `date`, `payment_method`, `notes`, `account_id`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', 'TRANS_INV-1-9-28/04/22', '204820.00', '2022-04-28', '3', '21ku', '6', 19, '2022-04-29 00:04:22', '2022-04-29 00:04:22'),
(2, '1', 'TRANS_INV-1-6-23/05/22', '30000.00', '2022-05-23', '1', NULL, '27', 1, '2022-05-23 14:50:09', '2022-05-23 14:50:09');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_payments`
--

CREATE TABLE `invoice_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `unit` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `price`, `unit`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Manure', '500000.00', 'pounds', 0, '2022-02-09 14:44:34', '2022-03-22 15:34:46'),
(2, 'Salt', '350000.00', 'kgs', 0, '2022-02-09 14:44:34', '2022-03-22 15:35:05'),
(3, 'Documents', '10000.00', 'kgs', 0, '2022-02-09 14:45:05', '2022-02-09 14:45:05'),
(4, 'Silico Manganese', '1500000.00', 'tons', 0, '2022-02-09 14:46:53', '2022-02-09 14:46:53'),
(5, 'Gold', '1800000.00', 'tons', 0, '2022-02-09 14:47:34', '2022-02-09 14:47:34'),
(6, 'Containers', '250000.00', 'kgs', 0, '2022-02-09 14:48:08', '2022-02-09 14:48:08'),
(7, 'sam', '12000.00', 'hh', 0, '2022-02-23 19:44:42', '2022-02-23 19:44:42'),
(1, 'Manure', '500000.00', 'pounds', 0, '2022-02-09 14:44:34', '2022-03-22 15:34:46'),
(2, 'Salt', '350000.00', 'kgs', 0, '2022-02-09 14:44:34', '2022-03-22 15:35:05'),
(3, 'Documents', '10000.00', 'kgs', 0, '2022-02-09 14:45:05', '2022-02-09 14:45:05'),
(4, 'Silico Manganese', '1500000.00', 'tons', 0, '2022-02-09 14:46:53', '2022-02-09 14:46:53'),
(5, 'Gold', '1800000.00', 'tons', 0, '2022-02-09 14:47:34', '2022-02-09 14:47:34'),
(6, 'Containers', '250000.00', 'kgs', 0, '2022-02-09 14:48:08', '2022-02-09 14:48:08'),
(7, 'sam', '12000.00', 'hh', 0, '2022-02-23 19:44:42', '2022-02-23 19:44:42'),
(1, 'Manure', '500000.00', 'pounds', 0, '2022-02-09 14:44:34', '2022-03-22 15:34:46'),
(2, 'Salt', '350000.00', 'kgs', 0, '2022-02-09 14:44:34', '2022-03-22 15:35:05'),
(3, 'Documents', '10000.00', 'kgs', 0, '2022-02-09 14:45:05', '2022-02-09 14:45:05'),
(4, 'Silico Manganese', '1500000.00', 'tons', 0, '2022-02-09 14:46:53', '2022-02-09 14:46:53'),
(5, 'Gold', '1800000.00', 'tons', 0, '2022-02-09 14:47:34', '2022-02-09 14:47:34'),
(6, 'Containers', '250000.00', 'kgs', 0, '2022-02-09 14:48:08', '2022-02-09 14:48:08'),
(7, 'sam', '12000.00', 'hh', 0, '2022-02-23 19:44:42', '2022-02-23 19:44:42'),
(0, 'Ammoniums Soluble', '23000.00', 'kg', 23, '2022-03-22 21:16:04', '2022-03-22 21:16:04'),
(0, 'test suppler', '2344.00', 'kg', 23, '2022-03-22 21:24:03', '2022-03-22 21:24:03');

-- --------------------------------------------------------

--
-- Table structure for table `journal_entries`
--

CREATE TABLE `journal_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `transaction_type` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `gl_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `month` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `payment_month` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `income_id` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `debit` decimal(38,2) DEFAULT NULL,
  `credit` decimal(38,2) DEFAULT NULL,
  `currency_code` varchar(200) COLLATE utf8_unicode_ci DEFAULT 'TZS',
  `exchange_rate` decimal(20,2) DEFAULT 1.00,
  `balance` decimal(65,4) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `loan_transaction_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `reconcile` int(10) NOT NULL DEFAULT 0,
  `transaction_sub_type` enum('overpayment','repayment_interest','repayment_principal','repayment_fees','repayment_penalty') COLLATE utf8_unicode_ci DEFAULT NULL,
  `reversed` tinyint(4) NOT NULL DEFAULT 0,
  `operator_id` int(200) DEFAULT NULL,
  `center_id` int(200) DEFAULT NULL,
  `client_id` int(200) DEFAULT NULL,
  `added_by` int(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `journal_entries`
--

INSERT INTO `journal_entries` (`id`, `user_id`, `account_id`, `transaction_type`, `name`, `gl_code`, `date`, `month`, `year`, `reference`, `payment_id`, `payment_month`, `income_id`, `debit`, `credit`, `currency_code`, `exchange_rate`, `balance`, `active`, `notes`, `created_at`, `updated_at`, `loan_transaction_id`, `branch_id`, `reconcile`, `transaction_sub_type`, `reversed`, `operator_id`, `center_id`, `client_id`, `added_by`) VALUES
(1, NULL, 17, 'cargo', 'Invoice', NULL, '2022-04-23', '04', '2022', NULL, NULL, NULL, '1', NULL, '69200.00', 'TZS', '1.00', NULL, 1, 'Invoice with reference no PCL-1  by Client Jefag Logistics Tanzania Limited', '2022-04-23 18:19:37', '2022-04-23 18:19:37', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(2, NULL, 23, 'cargo', 'Invoice', NULL, '2022-04-23', '04', '2022', NULL, NULL, NULL, '1', NULL, '12420.00', 'TZS', '1.00', NULL, 1, 'Invoice Tax with reference no PCL-1  by Client Jefag Logistics Tanzania Limited', '2022-04-23 18:19:37', '2022-04-23 18:19:37', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(3, NULL, 4, 'cargo', 'Invoice', NULL, '2022-04-23', '04', '2022', NULL, NULL, NULL, '1', '81620.00', NULL, 'TZS', '1.00', NULL, 1, 'Debit Receivables for Invoice with reference no PCL-1  by Client Jefag Logistics Tanzania Limited', '2022-04-23 18:19:37', '2022-04-23 18:19:37', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(4, NULL, 40, 'mileage', 'Mileage', NULL, '2022-04-23', '04', '2022', NULL, NULL, NULL, '1', '2595000.00', NULL, 'TZS', '1.00', NULL, 1, 'Mileage of Shipment Construction Cargo  to Driver  Jumanne Ally Hassal with Truck Suzuki', '2022-04-24 02:24:15', '2022-04-24 02:24:15', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(5, NULL, 16, 'mileage', 'Mileage', NULL, '2022-04-23', '04', '2022', NULL, NULL, NULL, '1', NULL, '2595000.00', 'TZS', '1.00', NULL, 1, 'Mileage of Shipment Construction Cargo  to Driver  Jumanne Ally Hassal with Truck Suzuki', '2022-04-24 02:24:15', '2022-04-24 02:24:15', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(6, NULL, 40, 'mileage', 'Mileage', NULL, '2022-04-23', '04', '2022', NULL, NULL, NULL, '2', '2595000.00', NULL, 'TZS', '1.00', NULL, 1, 'Mileage of Shipment Construction Cargo  to Driver  Jumanne Ally Hassa with Truck Lorry', '2022-04-24 02:25:20', '2022-04-24 02:37:24', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(7, NULL, 16, 'mileage', 'Mileage', NULL, '2022-04-23', '04', '2022', NULL, NULL, NULL, '2', NULL, '2595000.00', 'TZS', '1.00', NULL, 1, 'Mileage of Shipment Construction Cargo  to Driver  Jumanne Ally Hassa with Truck Lorry', '2022-04-24 02:25:20', '2022-04-24 02:37:24', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(8, NULL, 17, 'cargo', 'Invoice', NULL, '2022-04-24', '04', '2022', NULL, NULL, NULL, '2', NULL, '5000000.00', 'TZS', '1.00', NULL, 1, 'Invoice with reference no PCL-2  by Client Mohammed Enterprises', '2022-04-24 15:26:41', '2022-04-24 15:26:41', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(9, NULL, 23, 'cargo', 'Invoice', NULL, '2022-04-24', '04', '2022', NULL, NULL, NULL, '2', NULL, '900000.00', 'TZS', '1.00', NULL, 1, 'Invoice Tax with reference no PCL-2  by Client Mohammed Enterprises', '2022-04-24 15:26:41', '2022-04-24 15:26:41', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(10, NULL, 4, 'cargo', 'Invoice', NULL, '2022-04-24', '04', '2022', NULL, NULL, NULL, '2', '5900000.00', NULL, 'TZS', '1.00', NULL, 1, 'Debit Receivables for Invoice with reference no PCL-2  by Client Mohammed Enterprises', '2022-04-24 15:26:41', '2022-04-24 15:26:41', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(14, NULL, 16, 'mileage', 'Mileage', NULL, '2022-04-25', '04', '2022', NULL, NULL, NULL, '4', NULL, '249000.00', 'TZS', '1.00', NULL, 1, 'Mileage  to Driver  Jumanne Ally Hassal with Truck Suzuki', '2022-04-25 14:14:14', '2022-04-25 14:14:14', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(13, NULL, 40, 'mileage', 'Mileage', NULL, '2022-04-25', '04', '2022', NULL, NULL, NULL, '4', '249000.00', NULL, 'TZS', '1.00', NULL, 1, 'Mileage to Driver  Jumanne Ally Hassal with Truck Suzuki', '2022-04-25 14:14:14', '2022-04-25 14:14:14', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(18, NULL, 22, 'inventory', 'Inventory Purchase', NULL, '2022-04-19', '04', '2022', NULL, NULL, NULL, '1', '35820.00', NULL, 'TZS', '1.00', NULL, 1, 'Inventory Purchase Tax with reference no PUR_INV-1-2022-04-19 by Supplier Mussa Kombe', '2022-04-25 15:03:31', '2022-04-25 15:03:31', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(17, NULL, 21, 'inventory', 'Inventory Purchase', NULL, '2022-04-19', '04', '2022', NULL, NULL, NULL, '1', '199000.00', NULL, 'TZS', '1.00', NULL, 1, 'Inventory Purchase with reference no PUR_INV-1-2022-04-19 by Supplier Mussa Kombe', '2022-04-25 15:03:31', '2022-04-25 15:03:31', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(19, NULL, 16, 'inventory', 'Inventory Purchase', NULL, '2022-04-19', '04', '2022', NULL, NULL, NULL, '1', NULL, '234820.00', 'TZS', '1.00', NULL, 1, 'Credit for Inventory Purchase with reference no PUR_INV-1-2022-04-19 by Supplier Mussa Kombe', '2022-04-25 15:03:31', '2022-04-25 15:03:31', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(20, NULL, 6, 'cargo_payment', 'Invoice Payment', NULL, '2022-04-28', '04', '2022', NULL, 1, NULL, NULL, '500000.00', NULL, 'TZS', '1.00', NULL, 1, 'Payment for Clear Credit  with reference no PCL-2', '2022-04-28 21:39:35', '2022-04-28 21:39:35', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(21, NULL, 4, 'cargo_payment', 'Invoice Payment', NULL, '2022-04-28', '04', '2022', NULL, 1, NULL, NULL, NULL, '500000.00', 'TZS', '1.00', NULL, 1, 'Clear Debitor  with reference no PCL-2', '2022-04-28 21:39:35', '2022-04-28 21:39:35', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(22, NULL, 17, 'cargo', 'Invoice', NULL, '2022-04-26', '04', '2022', NULL, NULL, NULL, '3', NULL, '11690640.00', 'TZS', '1.00', NULL, 1, 'Invoice with reference no PCL-3  by Client Jefag Logistics Tanzania Limited', '2022-04-28 22:42:34', '2022-04-28 22:42:34', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(23, NULL, 23, 'cargo', 'Invoice', NULL, '2022-04-26', '04', '2022', NULL, NULL, NULL, '3', NULL, '2104315.20', 'TZS', '1.00', NULL, 1, 'Invoice Tax with reference no PCL-3  by Client Jefag Logistics Tanzania Limited', '2022-04-28 22:42:34', '2022-04-28 22:42:34', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(24, NULL, 4, 'cargo', 'Invoice', NULL, '2022-04-26', '04', '2022', NULL, NULL, NULL, '3', '13794955.20', NULL, 'TZS', '1.00', NULL, 1, 'Debit Receivables for Invoice with reference no PCL-3  by Client Jefag Logistics Tanzania Limited', '2022-04-28 22:42:34', '2022-04-28 22:42:34', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(25, NULL, 40, 'mileage', 'Mileage', NULL, '2022-04-28', '04', '2022', NULL, NULL, NULL, '6', '102100.00', NULL, 'TZS', '1.00', NULL, 1, 'Mileage to Driver  John Mashauri with Truck Scania 420P', '2022-04-28 23:07:01', '2022-04-28 23:07:01', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(26, NULL, 16, 'mileage', 'Mileage', NULL, '2022-04-28', '04', '2022', NULL, NULL, NULL, '6', NULL, '102100.00', 'TZS', '1.00', NULL, 1, 'Mileage  to Driver  John Mashauri with Truck Scania 420P', '2022-04-28 23:07:01', '2022-04-28 23:07:01', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(27, NULL, 40, 'mileage', 'Mileage', NULL, '2022-04-28', '04', '2022', NULL, NULL, NULL, '7', '68673.00', NULL, 'TZS', '1.00', NULL, 1, 'Mileage of Shipment Transportation of Cargo- 2  to Driver  Jumanne Ally Hassal with Truck Scania Mende 12345', '2022-04-28 23:14:42', '2022-04-28 23:14:42', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(28, NULL, 16, 'mileage', 'Mileage', NULL, '2022-04-28', '04', '2022', NULL, NULL, NULL, '7', NULL, '68673.00', 'TZS', '1.00', NULL, 1, 'Mileage of Shipment Transportation of Cargo- 2  to Driver  Jumanne Ally Hassal with Truck Scania Mende 12345', '2022-04-28 23:14:43', '2022-04-28 23:14:43', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(29, NULL, 40, 'mileage', 'Mileage', NULL, '2022-04-28', '04', '2022', NULL, NULL, NULL, '8', '85800.00', NULL, 'TZS', '1.00', NULL, 1, 'Mileage of Shipment Transport of CaCo3 from msata to Njombe  to Driver  Jumanne Ally Hassa with Truck Scania 420P', '2022-04-28 23:15:14', '2022-04-28 23:15:14', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(30, NULL, 16, 'mileage', 'Mileage', NULL, '2022-04-28', '04', '2022', NULL, NULL, NULL, '8', NULL, '85800.00', 'TZS', '1.00', NULL, 1, 'Mileage of Shipment Transport of CaCo3 from msata to Njombe  to Driver  Jumanne Ally Hassa with Truck Scania 420P', '2022-04-28 23:15:14', '2022-04-28 23:15:14', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(31, NULL, 40, 'mileage', 'Mileage', NULL, '2022-04-28', '04', '2022', NULL, NULL, NULL, '9', '62400.00', NULL, 'TZS', '1.00', NULL, 1, 'Mileage to Driver  Jumanne Ally Hassa with Truck Scania Mende 12345', '2022-04-28 23:20:06', '2022-04-28 23:20:06', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(32, NULL, 16, 'mileage', 'Mileage', NULL, '2022-04-28', '04', '2022', NULL, NULL, NULL, '9', NULL, '62400.00', 'TZS', '1.00', NULL, 1, 'Mileage  to Driver  Jumanne Ally Hassa with Truck Scania Mende 12345', '2022-04-28 23:20:06', '2022-04-28 23:20:06', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(33, NULL, 19, 'fuel', 'Fuel Refill', NULL, '2022-04-28', '04', '2022', NULL, 1, NULL, NULL, '484948.80', NULL, 'TZS', '1.00', NULL, 1, 'Fuel Refill Payment with transaction id TRANS_EXP_qvic', '2022-04-28 23:54:12', '2022-04-28 23:54:12', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(34, NULL, 16, 'fuel', 'Fuel Refill', NULL, '2022-04-28', '04', '2022', NULL, 1, NULL, NULL, NULL, '484948.80', 'TZS', '1.00', NULL, 1, 'Fuel Refill Payment with transaction id TRANS_EXP_qvic', '2022-04-28 23:54:12', '2022-04-28 23:54:12', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(35, NULL, 16, 'inventory_payment', 'Inventory Payment', NULL, '2022-04-28', '04', '2022', NULL, 1, NULL, NULL, '204820.00', NULL, 'TZS', '1.00', NULL, 1, 'Clear Creditor  with reference no PUR_INV-1-2022-04-19 by Supplier Mussa Kombe', '2022-04-29 00:04:22', '2022-04-29 00:04:22', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(36, NULL, 6, 'inventory_payment', 'Inventory Payment', NULL, '2022-04-28', '04', '2022', NULL, 1, NULL, NULL, NULL, '204820.00', 'TZS', '1.00', NULL, 1, 'Payment for Clear Credit  with reference no PUR_INV-1-2022-04-19 by Supplier Mussa Kombe', '2022-04-29 00:04:22', '2022-04-29 00:04:22', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(37, NULL, 34, 'expense_payment', 'Expense Payment', NULL, '2022-05-03', '05', '2022', NULL, 2, NULL, NULL, '40000.00', NULL, 'TZS', '1.00', NULL, 1, 'Expense Payment with transaction id TRANS_EXP_BdfM', '2022-05-02 23:14:49', '2022-05-02 23:14:49', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(38, NULL, 6, 'expense_payment', 'Expense Payment', NULL, '2022-05-03', '05', '2022', NULL, 2, NULL, NULL, NULL, '40000.00', 'TZS', '1.00', NULL, 1, 'Expense Payment with transaction id TRANS_EXP_BdfM', '2022-05-02 23:14:49', '2022-05-02 23:14:49', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(39, NULL, 19, 'fuel', 'Fuel Refill', NULL, '2022-05-04', '05', '2022', NULL, 2, NULL, NULL, '5382.00', NULL, 'TZS', '1.00', NULL, 1, 'Fuel Refill for Truck Suzuki', '2022-05-04 13:12:12', '2022-05-04 13:12:12', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(40, NULL, 25, 'fuel', 'Fuel Refill', NULL, '2022-05-04', '05', '2022', NULL, 2, NULL, NULL, NULL, '5382.00', 'TZS', '1.00', NULL, 1, 'Payment for Fuel Refill for Truck Suzuki', '2022-05-04 13:12:13', '2022-05-04 13:12:13', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(486, 43, 35, 'salary', 'Overtime  Salary Payment', NULL, '2022-05-09', '05', '2022', NULL, 13, '2022-03', NULL, NULL, '30000.00', 'TZS', '1.00', NULL, 1, 'Overtime  Salary Payment to test  for the month March 2022', '2022-05-09 23:02:14', '2022-05-09 23:02:14', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(485, 43, 53, 'salary', 'Overtime Salary Payment', NULL, '2022-05-09', '05', '2022', NULL, 13, '2022-03', NULL, '30000.00', NULL, 'TZS', '1.00', NULL, 1, 'Overtime Salary Payment to test  for the month March 2022', '2022-05-09 23:02:14', '2022-05-09 23:02:14', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(484, 43, 50, 'salary', 'NHIF Payment', NULL, '2022-05-09', '05', '2022', NULL, 13, '2022-03', NULL, NULL, '21000.00', 'TZS', '1.00', NULL, 1, 'NHIF  Payment from test  for the month March 2022', '2022-05-09 23:02:14', '2022-05-09 23:02:14', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(483, 43, 49, 'salary', 'NHIF (Heath Insurance Expense) Payment', NULL, '2022-05-09', '05', '2022', NULL, 13, '2022-03', NULL, '21000.00', NULL, 'TZS', '1.00', NULL, 1, 'NHIF (Heath Insurance Expense) Payment from test  for the month March 2022', '2022-05-09 23:02:14', '2022-05-09 23:02:14', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(482, 43, 47, 'salary', 'WCF Payment', NULL, '2022-05-09', '05', '2022', NULL, 13, '2022-03', NULL, NULL, '4200.00', 'TZS', '1.00', NULL, 1, 'WCF  Payment from test  for the month March 2022', '2022-05-09 23:02:14', '2022-05-09 23:02:14', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(481, 43, 46, 'salary', 'WCF Contribution Payment', NULL, '2022-05-09', '05', '2022', NULL, 13, '2022-03', NULL, '4200.00', NULL, 'TZS', '1.00', NULL, 1, 'WCF Contribution Payment from test  for the month March 2022', '2022-05-09 23:02:14', '2022-05-09 23:02:14', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(480, 43, 14, 'salary', 'NSSF Payment', NULL, '2022-05-09', '05', '2022', NULL, 13, '2022-03', NULL, NULL, '70000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from test  for the month March 2022', '2022-05-09 23:02:14', '2022-05-09 23:02:14', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(479, 43, 43, 'salary', 'NSSF (Employer Contribution) Payment', NULL, '2022-05-09', '05', '2022', NULL, 13, '2022-03', NULL, '70000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF (Employer Contribution) Payment from test  for the month March 2022', '2022-05-09 23:02:14', '2022-05-09 23:02:14', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(478, 43, 14, 'salary', 'NSSF Payment', NULL, '2022-05-09', '05', '2022', NULL, 13, '2022-03', NULL, NULL, '70000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from test  for the month March 2022', '2022-05-09 23:02:14', '2022-05-09 23:02:14', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(477, 43, 13, 'salary', 'NSSF Payment', NULL, '2022-05-09', '05', '2022', NULL, 13, '2022-03', NULL, '70000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF Payment from test  for the month March 2022', '2022-05-09 23:02:14', '2022-05-09 23:02:14', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(476, 43, 42, 'salary', 'PAYE Payment', NULL, '2022-05-09', '05', '2022', NULL, 13, '2022-03', NULL, NULL, '21000.00', 'TZS', '1.00', NULL, 1, 'PAYE Payment from test  for the month March 2022', '2022-05-09 23:02:14', '2022-05-09 23:02:14', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(475, 43, 13, 'salary', 'PAYE Payment', NULL, '2022-05-09', '05', '2022', NULL, 13, '2022-03', NULL, '21000.00', NULL, 'TZS', '1.00', NULL, 1, 'PAYE Payment from test  for the month March 2022', '2022-05-09 23:02:14', '2022-05-09 23:02:14', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(473, 43, 13, 'salary', 'Salary Payment', NULL, '2022-05-09', '05', '2022', NULL, 13, '2022-03', NULL, '534000.00', NULL, 'TZS', '1.00', NULL, 1, 'Net Salary Payment to test  for the month March 2022', '2022-05-09 23:02:14', '2022-05-09 23:02:14', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(474, 43, 35, 'salary', 'Salary Payment', NULL, '2022-05-09', '05', '2022', NULL, 13, '2022-03', NULL, NULL, '534000.00', 'TZS', '1.00', NULL, 1, 'Net Salary Payment to test  for the month March 2022', '2022-05-09 23:02:14', '2022-05-09 23:02:14', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(470, 19, 31, 'salary', 'Overtime  Salary Payment', NULL, '2022-05-09', '05', '2022', NULL, 12, '2022-04', NULL, NULL, '38000.00', 'TZS', '1.00', NULL, 1, 'Overtime  Salary Payment to sam2  for the month April 2022', '2022-05-09 22:33:19', '2022-05-09 22:33:19', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(469, 19, 53, 'salary', 'Overtime Salary Payment', NULL, '2022-05-09', '05', '2022', NULL, 12, '2022-04', NULL, '38000.00', NULL, 'TZS', '1.00', NULL, 1, 'Overtime Salary Payment to sam2  for the month April 2022', '2022-05-09 22:33:19', '2022-05-09 22:33:19', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(468, 19, 50, 'salary', 'NHIF Payment', NULL, '2022-05-09', '05', '2022', NULL, 12, '2022-04', NULL, NULL, '19500.00', 'TZS', '1.00', NULL, 1, 'NHIF  Payment from sam2  for the month April 2022', '2022-05-09 22:33:19', '2022-05-09 22:33:19', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(467, 19, 49, 'salary', 'NHIF (Heath Insurance Expense) Payment', NULL, '2022-05-09', '05', '2022', NULL, 12, '2022-04', NULL, '19500.00', NULL, 'TZS', '1.00', NULL, 1, 'NHIF (Heath Insurance Expense) Payment from sam2  for the month April 2022', '2022-05-09 22:33:19', '2022-05-09 22:33:19', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(466, 19, 47, 'salary', 'WCF Payment', NULL, '2022-05-09', '05', '2022', NULL, 12, '2022-04', NULL, NULL, '3900.00', 'TZS', '1.00', NULL, 1, 'WCF  Payment from sam2  for the month April 2022', '2022-05-09 22:33:19', '2022-05-09 22:33:19', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(464, 19, 14, 'salary', 'NSSF Payment', NULL, '2022-05-09', '05', '2022', NULL, 12, '2022-04', NULL, NULL, '65000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam2  for the month April 2022', '2022-05-09 22:33:19', '2022-05-09 22:33:19', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(465, 19, 46, 'salary', 'WCF Contribution Payment', NULL, '2022-05-09', '05', '2022', NULL, 12, '2022-04', NULL, '3900.00', NULL, 'TZS', '1.00', NULL, 1, 'WCF Contribution Payment from sam2  for the month April 2022', '2022-05-09 22:33:19', '2022-05-09 22:33:19', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(463, 19, 43, 'salary', 'NSSF (Employer Contribution) Payment', NULL, '2022-05-09', '05', '2022', NULL, 12, '2022-04', NULL, '65000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF (Employer Contribution) Payment from sam2  for the month April 2022', '2022-05-09 22:33:19', '2022-05-09 22:33:19', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(462, 19, 14, 'salary', 'NSSF Payment', NULL, '2022-05-09', '05', '2022', NULL, 12, '2022-04', NULL, NULL, '65000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam2  for the month April 2022', '2022-05-09 22:33:19', '2022-05-09 22:33:19', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(461, 19, 13, 'salary', 'NSSF Payment', NULL, '2022-05-09', '05', '2022', NULL, 12, '2022-04', NULL, '65000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam2  for the month April 2022', '2022-05-09 22:33:19', '2022-05-09 22:33:19', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(460, 19, 42, 'salary', 'PAYE Payment', NULL, '2022-05-09', '05', '2022', NULL, 12, '2022-04', NULL, NULL, '17400.00', 'TZS', '1.00', NULL, 1, 'PAYE Payment from sam2  for the month April 2022', '2022-05-09 22:33:19', '2022-05-09 22:33:19', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(459, 19, 13, 'salary', 'PAYE Payment', NULL, '2022-05-09', '05', '2022', NULL, 12, '2022-04', NULL, '17400.00', NULL, 'TZS', '1.00', NULL, 1, 'PAYE Payment from sam2  for the month April 2022', '2022-05-09 22:33:19', '2022-05-09 22:33:19', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(458, 19, 31, 'salary', 'Salary Payment', NULL, '2022-05-09', '05', '2022', NULL, 12, '2022-04', NULL, NULL, '508100.00', 'TZS', '1.00', NULL, 1, 'Net Salary Payment to sam2  for the month April 2022', '2022-05-09 22:33:19', '2022-05-09 22:33:19', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(457, 19, 13, 'salary', 'Salary Payment', NULL, '2022-05-09', '05', '2022', NULL, 12, '2022-04', NULL, '508100.00', NULL, 'TZS', '1.00', NULL, 1, 'Net Salary Payment to sam2  for the month April 2022', '2022-05-09 22:33:19', '2022-05-09 22:33:19', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(456, 43, 35, 'salary', 'Employee Loan Payment', NULL, '2022-05-09', '05', '2022', NULL, 11, '2022-05', NULL, '300000.00', '300000.00', 'TZS', '1.00', NULL, 1, 'Employee Loan Payment to test  for the month May 2022', '2022-05-09 12:05:41', '2022-05-09 12:05:41', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(455, 43, 50, 'salary', 'NHIF Payment', NULL, '2022-05-09', '05', '2022', NULL, 11, '2022-05', NULL, NULL, '21000.00', 'TZS', '1.00', NULL, 1, 'NHIF  Payment from test  for the month May 2022', '2022-05-09 12:05:41', '2022-05-09 12:05:41', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(454, 43, 49, 'salary', 'NHIF (Heath Insurance Expense) Payment', NULL, '2022-05-09', '05', '2022', NULL, 11, '2022-05', NULL, '21000.00', NULL, 'TZS', '1.00', NULL, 1, 'NHIF (Heath Insurance Expense) Payment from test  for the month May 2022', '2022-05-09 12:05:41', '2022-05-09 12:05:41', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(453, 43, 47, 'salary', 'WCF Payment', NULL, '2022-05-09', '05', '2022', NULL, 11, '2022-05', NULL, NULL, '4200.00', 'TZS', '1.00', NULL, 1, 'WCF  Payment from test  for the month May 2022', '2022-05-09 12:05:41', '2022-05-09 12:05:41', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(452, 43, 46, 'salary', 'WCF Contribution Payment', NULL, '2022-05-09', '05', '2022', NULL, 11, '2022-05', NULL, '4200.00', NULL, 'TZS', '1.00', NULL, 1, 'WCF Contribution Payment from test  for the month May 2022', '2022-05-09 12:05:41', '2022-05-09 12:05:41', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(451, 43, 14, 'salary', 'NSSF Payment', NULL, '2022-05-09', '05', '2022', NULL, 11, '2022-05', NULL, NULL, '70000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from test  for the month May 2022', '2022-05-09 12:05:41', '2022-05-09 12:05:41', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(450, 43, 43, 'salary', 'NSSF (Employer Contribution) Payment', NULL, '2022-05-09', '05', '2022', NULL, 11, '2022-05', NULL, '70000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF (Employer Contribution) Payment from test  for the month May 2022', '2022-05-09 12:05:41', '2022-05-09 12:05:41', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(448, 43, 13, 'salary', 'NSSF Payment', NULL, '2022-05-09', '05', '2022', NULL, 11, '2022-05', NULL, '70000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF Payment from test  for the month May 2022', '2022-05-09 12:05:41', '2022-05-09 12:05:41', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(449, 43, 14, 'salary', 'NSSF Payment', NULL, '2022-05-09', '05', '2022', NULL, 11, '2022-05', NULL, NULL, '70000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from test  for the month May 2022', '2022-05-09 12:05:41', '2022-05-09 12:05:41', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(447, 43, 42, 'salary', 'PAYE Payment', NULL, '2022-05-09', '05', '2022', NULL, 11, '2022-05', NULL, NULL, '21000.00', 'TZS', '1.00', NULL, 1, 'PAYE Payment from test  for the month May 2022', '2022-05-09 12:05:41', '2022-05-09 12:05:41', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(446, 43, 13, 'salary', 'PAYE Payment', NULL, '2022-05-09', '05', '2022', NULL, 11, '2022-05', NULL, '21000.00', NULL, 'TZS', '1.00', NULL, 1, 'PAYE Payment from test  for the month May 2022', '2022-05-09 12:05:41', '2022-05-09 12:05:41', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(445, 43, 35, 'salary', 'Salary Payment', NULL, '2022-05-09', '05', '2022', NULL, 11, '2022-05', NULL, '200000.00', '200000.00', 'TZS', '1.00', NULL, 1, 'Net Salary Payment to test  for the month May 2022', '2022-05-09 12:05:41', '2022-05-09 12:05:41', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(444, 20, 50, 'salary', 'NHIF Payment', NULL, '2022-05-08', '05', '2022', NULL, 10, '2022-04', NULL, NULL, '15000.00', 'TZS', '1.00', NULL, 1, 'NHIF  Payment from sam3  for the month April 2022', '2022-05-09 00:57:00', '2022-05-09 00:57:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(443, 20, 49, 'salary', 'NHIF (Heath Insurance Expense) Payment', NULL, '2022-05-08', '05', '2022', NULL, 10, '2022-04', NULL, '15000.00', NULL, 'TZS', '1.00', NULL, 1, 'NHIF (Heath Insurance Expense) Payment from sam3  for the month April 2022', '2022-05-09 00:57:00', '2022-05-09 00:57:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(442, 20, 47, 'salary', 'WCF Payment', NULL, '2022-05-08', '05', '2022', NULL, 10, '2022-04', NULL, NULL, '3000.00', 'TZS', '1.00', NULL, 1, 'WCF  Payment from sam3  for the month April 2022', '2022-05-09 00:57:00', '2022-05-09 00:57:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(441, 20, 46, 'salary', 'WCF Contribution Payment', NULL, '2022-05-08', '05', '2022', NULL, 10, '2022-04', NULL, '3000.00', NULL, 'TZS', '1.00', NULL, 1, 'WCF Contribution Payment from sam3  for the month April 2022', '2022-05-09 00:57:00', '2022-05-09 00:57:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(440, 20, 14, 'salary', 'NSSF Payment', NULL, '2022-05-08', '05', '2022', NULL, 10, '2022-04', NULL, NULL, '50000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam3  for the month April 2022', '2022-05-09 00:57:00', '2022-05-09 00:57:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(439, 20, 43, 'salary', 'NSSF (Employer Contribution) Payment', NULL, '2022-05-08', '05', '2022', NULL, 10, '2022-04', NULL, '50000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF (Employer Contribution) Payment from sam3  for the month April 2022', '2022-05-09 00:57:00', '2022-05-09 00:57:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(438, 20, 14, 'salary', 'NSSF Payment', NULL, '2022-05-08', '05', '2022', NULL, 10, '2022-04', NULL, NULL, '50000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam3  for the month April 2022', '2022-05-09 00:57:00', '2022-05-09 00:57:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(437, 20, 13, 'salary', 'NSSF Payment', NULL, '2022-05-08', '05', '2022', NULL, 10, '2022-04', NULL, '50000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam3  for the month April 2022', '2022-05-09 00:57:00', '2022-05-09 00:57:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(436, 20, 42, 'salary', 'PAYE Payment', NULL, '2022-05-08', '05', '2022', NULL, 10, '2022-04', NULL, NULL, '31000.00', 'TZS', '1.00', NULL, 1, 'PAYE Payment from sam3  for the month April 2022', '2022-05-09 00:57:00', '2022-05-09 00:57:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(435, 20, 13, 'salary', 'PAYE Payment', NULL, '2022-05-08', '05', '2022', NULL, 10, '2022-04', NULL, '31000.00', NULL, 'TZS', '1.00', NULL, 1, 'PAYE Payment from sam3  for the month April 2022', '2022-05-09 00:57:00', '2022-05-09 00:57:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(434, 20, 25, 'salary', 'Salary Payment', NULL, '2022-05-08', '05', '2022', NULL, 10, '2022-04', NULL, '544000.00', '544000.00', 'TZS', '1.00', NULL, 1, 'Net Salary Payment to sam3  for the month April 2022', '2022-05-09 00:57:00', '2022-05-09 00:57:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(433, 43, 35, 'salary', 'Employee Loan Payment', NULL, '2022-05-08', '05', '2022', NULL, 9, '2022-04', NULL, '300000.00', '300000.00', 'TZS', '1.00', NULL, 1, 'Employee Loan Payment to test  for the month April 2022', '2022-05-09 00:17:06', '2022-05-09 00:17:06', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(421, 19, 31, 'salary', 'Advance Salary Payment', NULL, '2022-05-08', '05', '2022', NULL, 8, '2022-02', NULL, '100000.00', '100000.00', 'TZS', '1.00', NULL, 1, 'Net Salary Payment to sam  for the month February 2022', '2022-05-08 17:20:21', '2022-05-08 17:20:21', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(420, 19, 50, 'salary', 'NHIF Payment', NULL, '2022-05-08', '05', '2022', NULL, 8, '2022-02', NULL, NULL, '19500.00', 'TZS', '1.00', NULL, 1, 'NHIF  Payment from sam  for the month February 2022', '2022-05-08 17:20:21', '2022-05-08 17:20:21', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(419, 19, 49, 'salary', 'NHIF (Heath Insurance Expense) Payment', NULL, '2022-05-08', '05', '2022', NULL, 8, '2022-02', NULL, '19500.00', NULL, 'TZS', '1.00', NULL, 1, 'NHIF (Heath Insurance Expense) Payment from sam  for the month February 2022', '2022-05-08 17:20:21', '2022-05-08 17:20:21', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(418, 19, 47, 'salary', 'WCF Payment', NULL, '2022-05-08', '05', '2022', NULL, 8, '2022-02', NULL, NULL, '3900.00', 'TZS', '1.00', NULL, 1, 'WCF  Payment from sam  for the month February 2022', '2022-05-08 17:20:21', '2022-05-08 17:20:21', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(417, 19, 46, 'salary', 'WCF Contribution Payment', NULL, '2022-05-08', '05', '2022', NULL, 8, '2022-02', NULL, '3900.00', NULL, 'TZS', '1.00', NULL, 1, 'WCF Contribution Payment from sam  for the month February 2022', '2022-05-08 17:20:21', '2022-05-08 17:20:21', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(416, 19, 14, 'salary', 'NSSF Payment', NULL, '2022-05-08', '05', '2022', NULL, 8, '2022-02', NULL, NULL, '65000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam  for the month February 2022', '2022-05-08 17:20:21', '2022-05-08 17:20:21', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(414, 19, 14, 'salary', 'NSSF Payment', NULL, '2022-05-08', '05', '2022', NULL, 8, '2022-02', NULL, NULL, '65000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam  for the month February 2022', '2022-05-08 17:20:21', '2022-05-08 17:20:21', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(415, 19, 43, 'salary', 'NSSF (Employer Contribution) Payment', NULL, '2022-05-08', '05', '2022', NULL, 8, '2022-02', NULL, '65000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF (Employer Contribution) Payment from sam  for the month February 2022', '2022-05-08 17:20:21', '2022-05-08 17:20:21', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(413, 19, 13, 'salary', 'NSSF Payment', NULL, '2022-05-08', '05', '2022', NULL, 8, '2022-02', NULL, '65000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam  for the month February 2022', '2022-05-08 17:20:21', '2022-05-08 17:20:21', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(412, 19, 42, 'salary', 'PAYE Payment', NULL, '2022-05-08', '05', '2022', NULL, 8, '2022-02', NULL, NULL, '17400.00', 'TZS', '1.00', NULL, 1, 'PAYE Payment from sam  for the month February 2022', '2022-05-08 17:20:21', '2022-05-08 17:20:21', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(411, 19, 13, 'salary', 'PAYE Payment', NULL, '2022-05-08', '05', '2022', NULL, 8, '2022-02', NULL, '17400.00', NULL, 'TZS', '1.00', NULL, 1, 'PAYE Payment from sam  for the month February 2022', '2022-05-08 17:20:21', '2022-05-08 17:20:21', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(422, 43, 35, 'salary', 'Salary Payment', NULL, '2022-05-08', '05', '2022', NULL, 9, '2022-04', NULL, '204000.00', '204000.00', 'TZS', '1.00', NULL, 1, 'Net Salary Payment to test  for the month April 2022', '2022-05-09 00:17:06', '2022-05-09 00:17:06', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(423, 43, 13, 'salary', 'PAYE Payment', NULL, '2022-05-08', '05', '2022', NULL, 9, '2022-04', NULL, '21000.00', NULL, 'TZS', '1.00', NULL, 1, 'PAYE Payment from test  for the month April 2022', '2022-05-09 00:17:06', '2022-05-09 00:17:06', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(424, 43, 42, 'salary', 'PAYE Payment', NULL, '2022-05-08', '05', '2022', NULL, 9, '2022-04', NULL, NULL, '21000.00', 'TZS', '1.00', NULL, 1, 'PAYE Payment from test  for the month April 2022', '2022-05-09 00:17:06', '2022-05-09 00:17:06', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(425, 43, 13, 'salary', 'NSSF Payment', NULL, '2022-05-08', '05', '2022', NULL, 9, '2022-04', NULL, '70000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF Payment from test  for the month April 2022', '2022-05-09 00:17:06', '2022-05-09 00:17:06', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(426, 43, 14, 'salary', 'NSSF Payment', NULL, '2022-05-08', '05', '2022', NULL, 9, '2022-04', NULL, NULL, '70000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from test  for the month April 2022', '2022-05-09 00:17:06', '2022-05-09 00:17:06', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(427, 43, 43, 'salary', 'NSSF (Employer Contribution) Payment', NULL, '2022-05-08', '05', '2022', NULL, 9, '2022-04', NULL, '70000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF (Employer Contribution) Payment from test  for the month April 2022', '2022-05-09 00:17:06', '2022-05-09 00:17:06', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(428, 43, 14, 'salary', 'NSSF Payment', NULL, '2022-05-08', '05', '2022', NULL, 9, '2022-04', NULL, NULL, '70000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from test  for the month April 2022', '2022-05-09 00:17:06', '2022-05-09 00:17:06', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(429, 43, 46, 'salary', 'WCF Contribution Payment', NULL, '2022-05-08', '05', '2022', NULL, 9, '2022-04', NULL, '4200.00', NULL, 'TZS', '1.00', NULL, 1, 'WCF Contribution Payment from test  for the month April 2022', '2022-05-09 00:17:06', '2022-05-09 00:17:06', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(430, 43, 47, 'salary', 'WCF Payment', NULL, '2022-05-08', '05', '2022', NULL, 9, '2022-04', NULL, NULL, '4200.00', 'TZS', '1.00', NULL, 1, 'WCF  Payment from test  for the month April 2022', '2022-05-09 00:17:06', '2022-05-09 00:17:06', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(431, 43, 49, 'salary', 'NHIF (Heath Insurance Expense) Payment', NULL, '2022-05-08', '05', '2022', NULL, 9, '2022-04', NULL, '21000.00', NULL, 'TZS', '1.00', NULL, 1, 'NHIF (Heath Insurance Expense) Payment from test  for the month April 2022', '2022-05-09 00:17:06', '2022-05-09 00:17:06', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(432, 43, 50, 'salary', 'NHIF Payment', NULL, '2022-05-08', '05', '2022', NULL, 9, '2022-04', NULL, NULL, '21000.00', 'TZS', '1.00', NULL, 1, 'NHIF  Payment from test  for the month April 2022', '2022-05-09 00:17:06', '2022-05-09 00:17:06', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(377, 19, 31, 'salary', 'Salary Payment', NULL, '2022-05-08', '05', '2022', NULL, 5, NULL, NULL, '370100.00', '370100.00', 'TZS', '1.00', NULL, 1, 'Net Salary Payment to sam  for the month February 2022', '2022-05-08 17:09:39', '2022-05-08 17:09:39', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(378, 19, 13, 'salary', 'PAYE Payment', NULL, '2022-05-08', '05', '2022', NULL, 5, NULL, NULL, '17400.00', NULL, 'TZS', '1.00', NULL, 1, 'PAYE Payment from sam  for the month February 2022', '2022-05-08 17:09:39', '2022-05-08 17:09:39', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(379, 19, 42, 'salary', 'PAYE Payment', NULL, '2022-05-08', '05', '2022', NULL, 5, NULL, NULL, NULL, '17400.00', 'TZS', '1.00', NULL, 1, 'PAYE Payment from sam  for the month February 2022', '2022-05-08 17:09:39', '2022-05-08 17:09:39', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(380, 19, 13, 'salary', 'NSSF Payment', NULL, '2022-05-08', '05', '2022', NULL, 5, NULL, NULL, '65000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam  for the month February 2022', '2022-05-08 17:09:39', '2022-05-08 17:09:39', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(381, 19, 14, 'salary', 'NSSF Payment', NULL, '2022-05-08', '05', '2022', NULL, 5, NULL, NULL, NULL, '65000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam  for the month February 2022', '2022-05-08 17:09:39', '2022-05-08 17:09:39', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(382, 19, 43, 'salary', 'NSSF (Employer Contribution) Payment', NULL, '2022-05-08', '05', '2022', NULL, 5, NULL, NULL, '65000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF (Employer Contribution) Payment from sam  for the month February 2022', '2022-05-08 17:09:39', '2022-05-08 17:09:39', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(383, 19, 14, 'salary', 'NSSF Payment', NULL, '2022-05-08', '05', '2022', NULL, 5, NULL, NULL, NULL, '65000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam  for the month February 2022', '2022-05-08 17:09:39', '2022-05-08 17:09:39', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(384, 19, 46, 'salary', 'WCF Contribution Payment', NULL, '2022-05-08', '05', '2022', NULL, 5, NULL, NULL, '3900.00', NULL, 'TZS', '1.00', NULL, 1, 'WCF Contribution Payment from sam  for the month February 2022', '2022-05-08 17:09:39', '2022-05-08 17:09:39', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(385, 19, 47, 'salary', 'WCF Payment', NULL, '2022-05-08', '05', '2022', NULL, 5, NULL, NULL, NULL, '3900.00', 'TZS', '1.00', NULL, 1, 'WCF  Payment from sam  for the month February 2022', '2022-05-08 17:09:39', '2022-05-08 17:09:39', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(386, 19, 49, 'salary', 'NHIF (Heath Insurance Expense) Payment', NULL, '2022-05-08', '05', '2022', NULL, 5, NULL, NULL, '19500.00', NULL, 'TZS', '1.00', NULL, 1, 'NHIF (Heath Insurance Expense) Payment from sam  for the month February 2022', '2022-05-08 17:09:39', '2022-05-08 17:09:39', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(387, 19, 50, 'salary', 'NHIF Payment', NULL, '2022-05-08', '05', '2022', NULL, 5, NULL, NULL, NULL, '19500.00', 'TZS', '1.00', NULL, 1, 'NHIF  Payment from sam  for the month February 2022', '2022-05-08 17:09:39', '2022-05-08 17:09:39', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(365, 19, 50, 'salary', 'NHIF Payment', NULL, '2022-05-07', '05', '2022', NULL, 3, NULL, NULL, NULL, '19500.00', 'TZS', '1.00', NULL, 1, 'NHIF  Payment from sam  for the month December 2021', '2022-05-07 14:31:46', '2022-05-07 14:31:46', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(410, 19, 31, 'salary', 'Salary Payment', NULL, '2022-05-08', '05', '2022', NULL, 8, '2022-02', NULL, '370100.00', '370100.00', 'TZS', '1.00', NULL, 1, 'Net Salary Payment to sam  for the month February 2022', '2022-05-08 17:20:21', '2022-05-08 17:20:21', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(364, 19, 49, 'salary', 'NHIF (Heath Insurance Expense) Payment', NULL, '2022-05-07', '05', '2022', NULL, 3, NULL, NULL, '19500.00', NULL, 'TZS', '1.00', NULL, 1, 'NHIF (Heath Insurance Expense) Payment from sam  for the month December 2021', '2022-05-07 14:31:46', '2022-05-07 14:31:46', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(363, 19, 47, 'salary', 'WCF Payment', NULL, '2022-05-07', '05', '2022', NULL, 3, NULL, NULL, NULL, '3900.00', 'TZS', '1.00', NULL, 1, 'WCF  Payment from sam  for the month December 2021', '2022-05-07 14:31:46', '2022-05-07 14:31:46', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(362, 19, 46, 'salary', 'WCF Contribution Payment', NULL, '2022-05-07', '05', '2022', NULL, 3, NULL, NULL, '3900.00', NULL, 'TZS', '1.00', NULL, 1, 'WCF Contribution Payment from sam  for the month December 2021', '2022-05-07 14:31:46', '2022-05-07 14:31:46', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(361, 19, 14, 'salary', 'NSSF Payment', NULL, '2022-05-07', '05', '2022', NULL, 3, NULL, NULL, NULL, '65000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam  for the month December 2021', '2022-05-07 14:31:46', '2022-05-07 14:31:46', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(360, 19, 43, 'salary', 'NSSF (Employer Contribution) Payment', NULL, '2022-05-07', '05', '2022', NULL, 3, NULL, NULL, '65000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF (Employer Contribution) Payment from sam  for the month December 2021', '2022-05-07 14:31:46', '2022-05-07 14:31:46', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(359, 19, 14, 'salary', 'NSSF Payment', NULL, '2022-05-07', '05', '2022', NULL, 3, NULL, NULL, NULL, '65000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam  for the month December 2021', '2022-05-07 14:31:46', '2022-05-07 14:31:46', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(358, 19, 13, 'salary', 'NSSF Payment', NULL, '2022-05-07', '05', '2022', NULL, 3, NULL, NULL, '65000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam  for the month December 2021', '2022-05-07 14:31:46', '2022-05-07 14:31:46', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(357, 19, 42, 'salary', 'PAYE Payment', NULL, '2022-05-07', '05', '2022', NULL, 3, NULL, NULL, NULL, '17400.00', 'TZS', '1.00', NULL, 1, 'PAYE Payment from sam  for the month December 2021', '2022-05-07 14:31:46', '2022-05-07 14:31:46', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(356, 19, 13, 'salary', 'PAYE Payment', NULL, '2022-05-07', '05', '2022', NULL, 3, NULL, NULL, '17400.00', NULL, 'TZS', '1.00', NULL, 1, 'PAYE Payment from sam  for the month December 2021', '2022-05-07 14:31:46', '2022-05-07 14:31:46', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(355, 19, 6, 'salary', 'Salary Payment', NULL, '2022-05-07', '05', '2022', NULL, 3, NULL, NULL, '460100.00', '460100.00', 'TZS', '1.00', NULL, 1, 'Net Salary Payment to sam  for the month December 2021', '2022-05-07 14:31:46', '2022-05-07 14:31:46', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(354, 19, 50, 'salary', 'NHIF Payment', NULL, '2022-05-07', '05', '2022', NULL, 2, '2021-12', NULL, NULL, '19500.00', 'TZS', '1.00', NULL, 1, 'NHIF  Payment from sam  for the month December 2021', '2022-05-07 14:29:00', '2022-05-07 14:29:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(353, 19, 49, 'salary', 'NHIF (Heath Insurance Expense) Payment', NULL, '2022-05-07', '05', '2022', NULL, 2, '2021-12', NULL, '19500.00', NULL, 'TZS', '1.00', NULL, 1, 'NHIF (Heath Insurance Expense) Payment from sam  for the month December 2021', '2022-05-07 14:29:00', '2022-05-07 14:29:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(352, 19, 47, 'salary', 'WCF Payment', NULL, '2022-05-07', '05', '2022', NULL, 2, '2021-12', NULL, NULL, '3900.00', 'TZS', '1.00', NULL, 1, 'WCF  Payment from sam  for the month December 2021', '2022-05-07 14:29:00', '2022-05-07 14:29:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(351, 19, 46, 'salary', 'WCF Contribution Payment', NULL, '2022-05-07', '05', '2022', NULL, 2, '2021-12', NULL, '3900.00', NULL, 'TZS', '1.00', NULL, 1, 'WCF Contribution Payment from sam  for the month December 2021', '2022-05-07 14:29:00', '2022-05-07 14:29:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(350, 19, 14, 'salary', 'NSSF Payment', NULL, '2022-05-07', '05', '2022', NULL, 2, '2021-12', NULL, NULL, '65000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam  for the month December 2021', '2022-05-07 14:29:00', '2022-05-07 14:29:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(349, 19, 43, 'salary', 'NSSF (Employer Contribution) Payment', NULL, '2022-05-07', '05', '2022', NULL, 2, '2021-12', NULL, '65000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF (Employer Contribution) Payment from sam  for the month December 2021', '2022-05-07 14:29:00', '2022-05-07 14:29:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(348, 19, 14, 'salary', 'NSSF Payment', NULL, '2022-05-07', '05', '2022', NULL, 2, '2021-12', NULL, NULL, '65000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam  for the month December 2021', '2022-05-07 14:29:00', '2022-05-07 14:29:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(346, 19, 42, 'salary', 'PAYE Payment', NULL, '2022-05-07', '05', '2022', NULL, 2, '2021-12', NULL, NULL, '17400.00', 'TZS', '1.00', NULL, 1, 'PAYE Payment from sam  for the month December 2021', '2022-05-07 14:29:00', '2022-05-07 14:29:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(347, 19, 13, 'salary', 'NSSF Payment', NULL, '2022-05-07', '05', '2022', NULL, 2, '2021-12', NULL, '65000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam  for the month December 2021', '2022-05-07 14:29:00', '2022-05-07 14:29:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(345, 19, 13, 'salary', 'PAYE Payment', NULL, '2022-05-07', '05', '2022', NULL, 2, '2021-12', NULL, '17400.00', NULL, 'TZS', '1.00', NULL, 1, 'PAYE Payment from sam  for the month December 2021', '2022-05-07 14:29:00', '2022-05-07 14:29:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(344, 19, 6, 'salary', 'Salary Payment', NULL, '2022-05-07', '05', '2022', NULL, 2, '2021-12', NULL, '460100.00', '460100.00', 'TZS', '1.00', NULL, 1, 'Net Salary Payment to sam  for the month December 2021', '2022-05-07 14:29:00', '2022-05-07 14:29:00', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(488, 45, 35, 'salary', 'Salary Payment', NULL, '2022-05-11', '05', '2022', NULL, 14, '2022-07', NULL, NULL, '500000.00', 'TZS', '1.00', NULL, 1, 'Net Salary Payment to   for the month July 2022', '2022-05-11 15:59:42', '2022-05-11 15:59:42', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(489, 45, 13, 'salary', 'PAYE Payment', NULL, '2022-05-11', '05', '2022', NULL, 14, '2022-07', NULL, '31000.00', NULL, 'TZS', '1.00', NULL, 1, 'PAYE Payment from   for the month July 2022', '2022-05-11 15:59:42', '2022-05-11 15:59:42', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(490, 45, 42, 'salary', 'PAYE Payment', NULL, '2022-05-11', '05', '2022', NULL, 14, '2022-07', NULL, NULL, '31000.00', 'TZS', '1.00', NULL, 1, 'PAYE Payment from   for the month July 2022', '2022-05-11 15:59:42', '2022-05-11 15:59:42', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(491, 45, 13, 'salary', 'NSSF Payment', NULL, '2022-05-11', '05', '2022', NULL, 14, '2022-07', NULL, '50000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF Payment from   for the month July 2022', '2022-05-11 15:59:42', '2022-05-11 15:59:42', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(492, 45, 14, 'salary', 'NSSF Payment', NULL, '2022-05-11', '05', '2022', NULL, 14, '2022-07', NULL, NULL, '50000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from   for the month July 2022', '2022-05-11 15:59:42', '2022-05-11 15:59:42', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(493, 45, 43, 'salary', 'NSSF (Employer Contribution) Payment', NULL, '2022-05-11', '05', '2022', NULL, 14, '2022-07', NULL, '50000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF (Employer Contribution) Payment from   for the month July 2022', '2022-05-11 15:59:42', '2022-05-11 15:59:42', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(494, 45, 14, 'salary', 'NSSF Payment', NULL, '2022-05-11', '05', '2022', NULL, 14, '2022-07', NULL, NULL, '50000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from   for the month July 2022', '2022-05-11 15:59:42', '2022-05-11 15:59:42', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(495, 45, 46, 'salary', 'WCF Contribution Payment', NULL, '2022-05-11', '05', '2022', NULL, 14, '2022-07', NULL, '3000.00', NULL, 'TZS', '1.00', NULL, 1, 'WCF Contribution Payment from   for the month July 2022', '2022-05-11 15:59:42', '2022-05-11 15:59:42', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(496, 45, 47, 'salary', 'WCF Payment', NULL, '2022-05-11', '05', '2022', NULL, 14, '2022-07', NULL, NULL, '3000.00', 'TZS', '1.00', NULL, 1, 'WCF  Payment from   for the month July 2022', '2022-05-11 15:59:42', '2022-05-11 15:59:42', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(497, 45, 49, 'salary', 'NHIF (Heath Insurance Expense) Payment', NULL, '2022-05-11', '05', '2022', NULL, 14, '2022-07', NULL, '15000.00', NULL, 'TZS', '1.00', NULL, 1, 'NHIF (Heath Insurance Expense) Payment from   for the month July 2022', '2022-05-11 15:59:42', '2022-05-11 15:59:42', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(332, 19, 50, 'salary', 'NHIF Payment', NULL, '2022-05-07', '05', '2022', NULL, 1, '2022-01', NULL, NULL, '19500.00', 'TZS', '1.00', NULL, 1, 'NHIF  Payment from sam  for the month August 2022', '2022-05-07 14:01:43', '2022-05-07 14:01:43', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(331, 19, 49, 'salary', 'NHIF (Heath Insurance Expense) Payment', NULL, '2022-05-07', '05', '2022', NULL, 1, '2022-01', NULL, '19500.00', NULL, 'TZS', '1.00', NULL, 1, 'NHIF (Heath Insurance Expense) Payment from sam  for the month August 2022', '2022-05-07 14:01:43', '2022-05-07 14:01:43', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(330, 19, 47, 'salary', 'WCF Payment', NULL, '2022-05-07', '05', '2022', NULL, 1, '2022-01', NULL, NULL, '3900.00', 'TZS', '1.00', NULL, 1, 'WCF  Payment from sam  for the month August 2022', '2022-05-07 14:01:43', '2022-05-07 14:01:43', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(329, 19, 46, 'salary', 'WCF Contribution Payment', NULL, '2022-05-07', '05', '2022', NULL, 1, '2022-01', NULL, '3900.00', NULL, 'TZS', '1.00', NULL, 1, 'WCF Contribution Payment from sam  for the month August 2022', '2022-05-07 14:01:43', '2022-05-07 14:01:43', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(328, 19, 14, 'salary', 'NSSF Payment', NULL, '2022-05-07', '05', '2022', NULL, 1, '2022-01', NULL, NULL, '65000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam  for the month August 2022', '2022-05-07 14:01:43', '2022-05-07 14:01:43', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(327, 19, 43, 'salary', 'NSSF (Employer Contribution) Payment', NULL, '2022-05-07', '05', '2022', NULL, 1, '2022-01', NULL, '65000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF (Employer Contribution) Payment from sam  for the month August 2022', '2022-05-07 14:01:43', '2022-05-07 14:01:43', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(326, 19, 14, 'salary', 'NSSF Payment', NULL, '2022-05-07', '05', '2022', NULL, 1, '2022-01', NULL, NULL, '65000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam  for the month August 2022', '2022-05-07 14:01:43', '2022-05-07 14:01:43', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(325, 19, 13, 'salary', 'NSSF Payment', NULL, '2022-05-07', '05', '2022', NULL, 1, '2022-01', NULL, '65000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF Payment from sam  for the month August 2022', '2022-05-07 14:01:43', '2022-05-07 14:01:43', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(324, 19, 42, 'salary', 'PAYE Payment', NULL, '2022-05-07', '05', '2022', NULL, 1, '2022-01', NULL, NULL, '17400.00', 'TZS', '1.00', NULL, 1, 'PAYE Payment from sam  for the month August 2022', '2022-05-07 14:01:43', '2022-05-07 14:01:43', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(323, 19, 13, 'salary', 'PAYE Payment', NULL, '2022-05-07', '05', '2022', NULL, 1, '2022-01', NULL, '17400.00', NULL, 'TZS', '1.00', NULL, 1, 'PAYE Payment from sam  for the month August 2022', '2022-05-07 14:01:43', '2022-05-07 14:01:43', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(322, 19, 6, 'salary', 'Salary Payment', NULL, '2022-05-07', '05', '2022', NULL, 1, '2022-01', NULL, '470100.00', '470100.00', 'TZS', '1.00', NULL, 1, 'Net Salary Payment to sam  for the month August 2022', '2022-05-07 14:01:43', '2022-05-07 14:01:43', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0);
INSERT INTO `journal_entries` (`id`, `user_id`, `account_id`, `transaction_type`, `name`, `gl_code`, `date`, `month`, `year`, `reference`, `payment_id`, `payment_month`, `income_id`, `debit`, `credit`, `currency_code`, `exchange_rate`, `balance`, `active`, `notes`, `created_at`, `updated_at`, `loan_transaction_id`, `branch_id`, `reconcile`, `transaction_sub_type`, `reversed`, `operator_id`, `center_id`, `client_id`, `added_by`) VALUES
(487, 45, 13, 'salary', 'Salary Payment', NULL, '2022-05-11', '05', '2022', NULL, 14, '2022-07', NULL, '500000.00', NULL, 'TZS', '1.00', NULL, 1, 'Net Salary Payment to   for the month July 2022', '2022-05-11 15:59:42', '2022-05-11 15:59:42', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(498, 45, 50, 'salary', 'NHIF Payment', NULL, '2022-05-11', '05', '2022', NULL, 14, '2022-07', NULL, NULL, '15000.00', 'TZS', '1.00', NULL, 1, 'NHIF  Payment from   for the month July 2022', '2022-05-11 15:59:42', '2022-05-11 15:59:42', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(499, NULL, 56, 'courier', 'Invoice', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '1', NULL, '337500.00', 'TZS', '1.00', NULL, 1, 'Courier Invoice with reference no CM-1  by Client John Doe', '2022-05-11 21:43:15', '2022-05-11 21:43:15', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(500, NULL, 4, 'courier', 'Invoice', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '1', '337500.00', NULL, 'TZS', '1.00', NULL, 1, 'Courier Debit Receivables for Invoice with reference no CM-1  by Client John Doe', '2022-05-11 21:43:15', '2022-05-11 21:43:15', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(501, NULL, 28, 'courier_payment', 'Invoice Payment', NULL, '2022-05-11', '05', '2022', NULL, 1, NULL, NULL, '175000.00', NULL, 'TZS', '1.00', NULL, 1, 'Courier Payment for Clear Credit  with reference no CM-1', '2022-05-11 22:27:47', '2022-05-11 22:29:39', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(502, NULL, 4, 'courier_payment', 'Invoice Payment', NULL, '2022-05-11', '05', '2022', NULL, 1, NULL, NULL, NULL, '175000.00', 'TZS', '1.00', NULL, 1, 'Clear Courier Creditor  with reference no CM-1', '2022-05-11 22:27:47', '2022-05-11 22:29:39', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(503, NULL, 7, 'transfer', 'Transfer Payment', NULL, '2022-05-14', '05', '2022', NULL, 1, NULL, NULL, '5000000.00', NULL, 'TZS', '1.00', NULL, 1, 'Money Transfer From CRDB to Petty Cash', '2022-05-15 13:03:31', '2022-05-15 13:03:31', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(504, NULL, 6, 'transfer', 'Transfer Payment', NULL, '2022-05-14', '05', '2022', NULL, 1, NULL, NULL, NULL, '5000000.00', 'TZS', '1.00', NULL, 1, 'Money Transfer From CRDB to Petty Cash', '2022-05-15 13:03:31', '2022-05-15 13:03:31', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(505, NULL, 27, 'transfer', 'Transfer Payment', NULL, '2022-05-15', '05', '2022', NULL, 2, NULL, NULL, '50000.00', NULL, 'TZS', '1.00', NULL, 1, 'Money Transfer From CRDB to MPESA', '2022-05-15 13:14:13', '2022-05-15 13:14:13', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(506, NULL, 6, 'transfer', 'Transfer Payment', NULL, '2022-05-15', '05', '2022', NULL, 2, NULL, NULL, NULL, '50000.00', 'TZS', '1.00', NULL, 1, 'Money Transfer From CRDB to MPESA', '2022-05-15 13:14:13', '2022-05-15 13:14:13', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(507, NULL, 29, 'transfer', 'Transfer Payment', NULL, '2022-05-15', '05', '2022', NULL, 3, NULL, NULL, '10000.00', NULL, 'TZS', '1.00', NULL, 1, 'Money Transfer From TIGO PESA to AIRTEL MONEY', '2022-05-15 13:20:10', '2022-05-15 13:20:10', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(508, NULL, 28, 'transfer', 'Transfer Payment', NULL, '2022-05-15', '05', '2022', NULL, 3, NULL, NULL, NULL, '10000.00', 'TZS', '1.00', NULL, 1, 'Money Transfer From TIGO PESA to AIRTEL MONEY', '2022-05-15 13:20:10', '2022-05-15 13:20:10', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(555, NULL, 40, 'mileage', 'Mileage', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '11', '102100.00', NULL, 'TZS', '1.00', NULL, 1, 'Mileage of Shipment XTEW SHING TO SINGIDA  to Driver  Jumanne Ally Hassal with Truck T711 CFS SCANIA', '2022-05-17 15:27:51', '2022-05-17 15:27:51', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(554, NULL, 16, 'fuel', 'Fuel Refill', NULL, '2022-05-17', '05', '2022', NULL, 3, NULL, NULL, NULL, '155000.00', 'TZS', '1.00', NULL, 1, 'Fuel Refill Payment with transaction id TRANS_EXP_IMX1', '2022-05-17 14:44:51', '2022-05-17 14:44:51', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(553, NULL, 19, 'fuel', 'Fuel Refill', NULL, '2022-05-17', '05', '2022', NULL, 3, NULL, NULL, '155000.00', NULL, 'TZS', '1.00', NULL, 1, 'Fuel Refill Payment with transaction id TRANS_EXP_IMX1', '2022-05-17 14:44:51', '2022-05-17 14:44:51', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(551, NULL, 40, 'mileage', 'Mileage', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '10', '40000.00', NULL, 'TZS', '1.00', NULL, 1, 'Mileage to Driver  Jumanne Ally Hassa with Truck T711 CFS SCANIA', '2022-05-17 14:38:08', '2022-05-17 14:38:08', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(552, NULL, 16, 'mileage', 'Mileage', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '10', NULL, '40000.00', 'TZS', '1.00', NULL, 1, 'Mileage  to Driver  Jumanne Ally Hassa with Truck T711 CFS SCANIA', '2022-05-17 14:38:08', '2022-05-17 14:38:08', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(550, NULL, 4, 'cargo', 'Invoice', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '4', '3658000.00', NULL, 'TZS', '1.00', NULL, 1, 'Debit Receivables for Invoice with reference no PCL-4  by Client Mohammed Enterprises', '2022-05-17 14:25:10', '2022-05-17 14:25:10', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(549, NULL, 23, 'cargo', 'Invoice', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '4', NULL, '558000.00', 'TZS', '1.00', NULL, 1, 'Invoice Tax with reference no PCL-4  by Client Mohammed Enterprises', '2022-05-17 14:25:10', '2022-05-17 14:25:10', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(548, NULL, 17, 'cargo', 'Invoice', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '4', NULL, '3100000.00', 'TZS', '1.00', NULL, 1, 'Invoice with reference no PCL-4  by Client Mohammed Enterprises', '2022-05-17 14:25:10', '2022-05-17 14:25:10', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(547, NULL, 16, 'tire', 'Tire Purchase', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '1', NULL, '475776000.00', 'USD', '2400.00', NULL, 1, 'Credit for Tire Purchase with reference no PUR_TYRE_1_2022-05-17 by Supplier Ujuzinet', '2022-05-17 14:00:34', '2022-05-17 14:00:34', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(546, NULL, 22, 'tire', 'Tire Purchase', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '1', '72576000.00', NULL, 'USD', '2400.00', NULL, 1, 'Tire Purchase Tax with reference no PUR_TYRE_1_2022-05-17 by Supplier Ujuzinet', '2022-05-17 14:00:34', '2022-05-17 14:00:34', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(545, NULL, 20, 'tire', 'Tire Purchase', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '1', '403200000.00', NULL, 'USD', '2400.00', NULL, 1, 'Tire Purchase with reference no PUR_TYRE_1_2022-05-17 by Supplier Ujuzinet', '2022-05-17 14:00:34', '2022-05-17 14:00:34', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(556, NULL, 16, 'mileage', 'Mileage', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '11', NULL, '102100.00', 'TZS', '1.00', NULL, 1, 'Mileage of Shipment XTEW SHING TO SINGIDA  to Driver  Jumanne Ally Hassal with Truck T711 CFS SCANIA', '2022-05-17 15:27:51', '2022-05-17 15:27:51', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(557, NULL, 70, 'operator', 'Top Up Operator', NULL, '2022-05-17', '05', '2022', NULL, 4, NULL, NULL, '58800.00', NULL, 'TZS', '1.00', NULL, 1, 'Top Up From Petty Cash to Operator Test New Operator', '2022-05-17 16:01:37', '2022-05-17 16:01:37', NULL, NULL, 0, NULL, 0, 3, NULL, NULL, 0),
(558, NULL, 7, 'operator', 'Top Up Operator', NULL, '2022-05-17', '05', '2022', NULL, 4, NULL, NULL, NULL, '58800.00', 'TZS', '1.00', NULL, 1, 'Top Up From Petty Cash to Operator Test New Operator', '2022-05-17 16:01:37', '2022-05-17 16:01:37', NULL, NULL, 0, NULL, 0, 3, NULL, NULL, 0),
(559, NULL, 71, 'collection', 'Top Up Collection', NULL, '2022-05-17', '05', '2022', NULL, 2, NULL, NULL, '20000.00', NULL, 'TZS', '1.00', NULL, 1, 'Top Up From Operator Test New Operator to Collection Center Solwa', '2022-05-17 16:02:59', '2022-05-17 16:02:59', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(560, NULL, 70, 'collection', 'Top Up Collection', NULL, '2022-05-17', '05', '2022', NULL, 2, NULL, NULL, NULL, '20000.00', 'TZS', '1.00', NULL, 1, 'Top Up From Operator Test New Operator to Collection Center Solwa', '2022-05-17 16:02:59', '2022-05-17 16:02:59', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(561, NULL, 65, 'cotton', 'Cotton Purchase', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '1', '400000.00', NULL, 'TZS', '1.00', NULL, 1, 'Cotton Purchase with reference no PUR_CTN-1-2022-05-17 by Supplier Test New Operator', '2022-05-17 16:15:57', '2022-05-17 16:15:57', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(562, NULL, 22, 'cotton', 'Cotton Purchase', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '1', '72000.00', NULL, 'TZS', '1.00', NULL, 1, 'Cotton Purchase Tax with reference no PUR_CTN-1-2022-05-17 by Supplier Test New Operator', '2022-05-17 16:15:57', '2022-05-17 16:15:57', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(563, NULL, 16, 'cotton', 'Cotton Purchase', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '1', NULL, '472000.00', 'TZS', '1.00', NULL, 1, 'Credit for Cotton Purchase with reference no PUR_CTN-1-2022-05-17 by Supplier Test New Operator', '2022-05-17 16:15:57', '2022-05-17 16:15:57', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(564, NULL, 65, 'cotton', 'Cotton Purchase', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '2', '6000000.00', NULL, 'TZS', '1.00', NULL, 1, 'Cotton Purchase with reference no PUR_CTN-2-2022-05-17 by Supplier Test New Operator', '2022-05-17 16:54:18', '2022-05-17 16:54:18', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(565, NULL, 16, 'cotton', 'Cotton Purchase', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '2', NULL, '6000000.00', 'TZS', '1.00', NULL, 1, 'Credit for Cotton Purchase with reference no PUR_CTN-2-2022-05-17 by Supplier Test New Operator', '2022-05-17 16:54:18', '2022-05-17 16:54:18', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(566, NULL, 66, 'cotton', 'Good Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '1', '200000.00', NULL, 'TZS', '1.00', NULL, 1, 'Good Movement From Solwa to  Main Center', '2022-05-17 17:40:07', '2022-05-17 17:40:07', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(567, NULL, 71, 'cotton', 'Good Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, NULL, NULL, '200000.00', 'TZS', '1.00', NULL, 1, 'Good Movement From  Solwa to Main Center', '2022-05-17 17:40:08', '2022-05-17 17:40:08', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(568, NULL, 75, 'cotton', 'Good Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '1', NULL, NULL, 'TZS', '1.00', NULL, 1, 'Good Movement From Solwa to  Main Center', '2022-05-17 17:40:08', '2022-05-17 17:40:08', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(569, NULL, 76, 'cotton', 'Good Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, NULL, NULL, NULL, 'TZS', '1.00', NULL, 1, 'Good Movement From  Solwa to Main Center', '2022-05-17 17:40:08', '2022-05-17 17:40:08', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(570, NULL, 72, 'cotton', 'Good Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '1', '12000.00', NULL, 'TZS', '1.00', NULL, 1, 'Good Movement District Levy From Solwa to  Main Center', '2022-05-17 17:40:08', '2022-05-17 17:40:08', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(571, NULL, 74, 'cotton', 'Good Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, NULL, NULL, '12000.00', 'TZS', '1.00', NULL, 1, 'Good Movement Levy Control From  Solwa to Main Center', '2022-05-17 17:40:08', '2022-05-17 17:40:08', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(572, NULL, 73, 'cotton', 'Good Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '1', '0.00', NULL, 'TZS', '1.00', NULL, 1, 'Good Movement Community Levy From Solwa to  Main Center', '2022-05-17 17:40:08', '2022-05-17 17:40:08', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(573, NULL, 74, 'cotton', 'Good Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, NULL, NULL, '0.00', 'TZS', '1.00', NULL, 1, 'Good Movement Levy Control From  Solwa to Main Center', '2022-05-17 17:40:08', '2022-05-17 17:40:08', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(574, NULL, 66, 'cotton', 'Good Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '2', '200000.00', NULL, 'TZS', '1.00', NULL, 1, 'Good Movement From Solwa to  Main Center', '2022-05-17 17:41:38', '2022-05-17 17:41:38', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(575, NULL, 71, 'cotton', 'Good Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, NULL, NULL, '200000.00', 'TZS', '1.00', NULL, 1, 'Good Movement From  Solwa to Main Center', '2022-05-17 17:41:38', '2022-05-17 17:41:38', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(576, NULL, 75, 'cotton', 'Good Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '2', NULL, NULL, 'TZS', '1.00', NULL, 1, 'Good Movement From Solwa to  Main Center', '2022-05-17 17:41:38', '2022-05-17 17:41:38', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(577, NULL, 76, 'cotton', 'Good Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, NULL, NULL, NULL, 'TZS', '1.00', NULL, 1, 'Good Movement From  Solwa to Main Center', '2022-05-17 17:41:38', '2022-05-17 17:41:38', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(578, NULL, 72, 'cotton', 'Good Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '2', '12000.00', NULL, 'TZS', '1.00', NULL, 1, 'Good Movement District Levy From Solwa to  Main Center', '2022-05-17 17:41:38', '2022-05-17 17:41:38', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(579, NULL, 74, 'cotton', 'Good Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, NULL, NULL, '12000.00', 'TZS', '1.00', NULL, 1, 'Good Movement Levy Control From  Solwa to Main Center', '2022-05-17 17:41:38', '2022-05-17 17:41:38', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(580, NULL, 73, 'cotton', 'Good Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '2', '0.00', NULL, 'TZS', '1.00', NULL, 1, 'Good Movement Community Levy From Solwa to  Main Center', '2022-05-17 17:41:38', '2022-05-17 17:41:38', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(581, NULL, 74, 'cotton', 'Good Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, NULL, NULL, '0.00', 'TZS', '1.00', NULL, 1, 'Good Movement Levy Control From  Solwa to Main Center', '2022-05-17 17:41:38', '2022-05-17 17:41:38', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(582, NULL, 65, 'cotton', 'Cotton Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '6', '0.00', NULL, NULL, NULL, NULL, 1, 'Cotton Purchase with reference no 5555 by Supplier Test New Operator', '2022-05-18 06:25:59', '2022-05-18 06:25:59', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(583, NULL, 16, 'cotton', 'Cotton Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '6', NULL, '0.00', NULL, NULL, NULL, 1, 'Credit for Cotton Purchase with reference no 5555 by Supplier Test New Operator', '2022-05-18 06:25:59', '2022-05-18 06:25:59', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(584, NULL, 65, 'cotton', 'Cotton Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '7', '0.00', NULL, NULL, NULL, NULL, 1, 'Cotton Purchase with reference no 12345 by Supplier Mwakikungu station', '2022-05-18 06:35:37', '2022-05-18 06:35:37', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(585, NULL, 22, 'cotton', 'Cotton Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '7', '0.00', NULL, NULL, NULL, NULL, 1, 'Cotton Purchase Tax with reference no 12345 by Supplier Mwakikungu station', '2022-05-18 06:35:37', '2022-05-18 06:35:37', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(586, NULL, 16, 'cotton', 'Cotton Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '7', NULL, '0.00', NULL, NULL, NULL, 1, 'Credit for Cotton Purchase with reference no 12345 by Supplier Mwakikungu station', '2022-05-18 06:35:37', '2022-05-18 06:35:37', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(587, NULL, 65, 'cotton', 'Cotton Purchase', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '8', '0.00', NULL, NULL, NULL, NULL, 1, 'Cotton Purchase with reference no 56734 by Supplier Mwakikungu station', '2022-05-18 06:39:59', '2022-05-18 06:39:59', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(588, NULL, 22, 'cotton', 'Cotton Purchase', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '8', '0.00', NULL, NULL, NULL, NULL, 1, 'Cotton Purchase Tax with reference no 56734 by Supplier Mwakikungu station', '2022-05-18 06:39:59', '2022-05-18 06:39:59', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(589, NULL, 16, 'cotton', 'Cotton Purchase', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '8', NULL, '0.00', NULL, NULL, NULL, 1, 'Credit for Cotton Purchase with reference no 56734 by Supplier Mwakikungu station', '2022-05-18 06:39:59', '2022-05-18 06:39:59', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(590, NULL, 65, 'cotton', 'Cotton Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '9', '40000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Control with reference no 345 by Operator Mwakikungu station to mwakiponya A Center', '2022-05-18 06:55:14', '2022-05-18 06:55:14', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(591, NULL, 22, 'cotton', 'Cotton Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '9', '7200.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Control with reference no 345 by Operator Mwakikungu station to mwakiponya A Center', '2022-05-18 06:55:14', '2022-05-18 06:55:14', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(592, NULL, 16, 'cotton', 'Cotton Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '9', NULL, '47200.00', 'TZS', '1.00', NULL, 1, 'Stock Control with reference no 345 by Operator Mwakikungu station to mwakiponya A Center', '2022-05-18 06:55:14', '2022-05-18 06:55:14', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(593, NULL, 65, 'cotton', 'Cotton Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '10', '9450000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Control with reference no 45665 by Operator Test New Operator to Solwa Center', '2022-05-18 09:01:07', '2022-05-18 09:01:07', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(594, NULL, 16, 'cotton', 'Cotton Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '10', NULL, '9450000.00', 'TZS', '1.00', NULL, 1, 'Stock Control with reference no 45665 by Operator Test New Operator to Solwa Center', '2022-05-18 09:01:07', '2022-05-18 09:01:07', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(595, NULL, 66, 'cotton', 'Stock Movement', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '6', '12050000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Movement From Solwa to  Main Center', '2022-05-18 17:37:04', '2022-05-18 17:37:04', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(596, NULL, 71, 'cotton', 'Stock  Movement', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '6', NULL, '12050000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  Solwa to Main Center', '2022-05-18 17:37:04', '2022-05-18 17:37:04', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(597, NULL, 75, 'cotton', 'Stock Movement', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '6', NULL, NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement From Solwa to  Main Center', '2022-05-18 17:37:04', '2022-05-18 17:37:04', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(598, NULL, 76, 'cotton', 'Stock  Movement', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '6', NULL, NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement From  Solwa to Main Center', '2022-05-18 17:37:04', '2022-05-18 17:37:04', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(599, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '6', '12000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement District Levy From Solwa to  Main Center', '2022-05-18 17:37:04', '2022-05-18 17:37:04', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(600, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '6', NULL, '12000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Solwa to Main Center', '2022-05-18 17:37:04', '2022-05-18 17:37:04', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(601, NULL, 73, 'cotton', 'Stock  Movement', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '6', '150000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Community Levy From Solwa to  Main Center', '2022-05-18 17:37:04', '2022-05-18 17:37:04', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(602, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '6', NULL, '150000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Solwa to Main Center', '2022-05-18 17:37:04', '2022-05-18 17:37:04', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(603, NULL, 65, 'cotton', 'Cotton Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '11', '21000000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Control with reference no 11579 by Operator Test New Operator to Solwa Center', '2022-05-18 18:51:59', '2022-05-18 18:51:59', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(604, NULL, 16, 'cotton', 'Cotton Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '11', NULL, '21000000.00', 'TZS', '1.00', NULL, 1, 'Stock Control with reference no 11579 by Operator Test New Operator to Solwa Center', '2022-05-18 18:51:59', '2022-05-18 18:51:59', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(605, NULL, 70, 'operator', 'Top Up Operator', NULL, '2022-05-16', '05', '2022', NULL, 3, NULL, NULL, '4000000.00', NULL, 'TZS', '1.00', NULL, 1, 'Top Up From Petty Cash to Operator Nicco Kowero', '2022-05-18 18:59:55', '2022-05-18 18:59:55', NULL, NULL, 0, NULL, 0, 2, NULL, NULL, 0),
(606, NULL, 7, 'operator', 'Top Up Operator', NULL, '2022-05-16', '05', '2022', NULL, 3, NULL, NULL, NULL, '4000000.00', 'TZS', '1.00', NULL, 1, 'Top Up From Petty Cash to Operator Nicco Kowero', '2022-05-18 18:59:55', '2022-05-18 18:59:55', NULL, NULL, 0, NULL, 0, 2, NULL, NULL, 0),
(607, NULL, 65, 'cotton', 'Cotton Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '12', '7500000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Control with reference no 11157 by Operator Nicco Kowero to Mwamahasa Center', '2022-05-18 19:02:48', '2022-05-18 19:02:48', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 0),
(608, NULL, 16, 'cotton', 'Cotton Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '12', NULL, '7500000.00', 'TZS', '1.00', NULL, 1, 'Stock Control with reference no 11157 by Operator Nicco Kowero to Mwamahasa Center', '2022-05-18 19:02:48', '2022-05-18 19:02:48', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 0),
(609, NULL, 66, 'cotton', 'Stock Movement', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '7', '7500000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Movement From mwakiponya to  Main Center', '2022-05-18 19:06:55', '2022-05-18 19:06:55', NULL, NULL, 0, NULL, 0, NULL, 1, NULL, 0),
(610, NULL, 71, 'cotton', 'Stock  Movement', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '7', NULL, '7500000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya to Main Center', '2022-05-18 19:06:55', '2022-05-18 19:06:55', NULL, NULL, 0, NULL, 0, NULL, 1, NULL, 0),
(611, NULL, 75, 'cotton', 'Stock Movement', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '7', '145000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement From mwakiponya to  Main Center', '2022-05-18 19:06:55', '2022-05-18 19:06:55', NULL, NULL, 0, NULL, 0, NULL, 1, NULL, 0),
(612, NULL, 76, 'cotton', 'Stock  Movement', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '7', NULL, '145000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya to Main Center', '2022-05-18 19:06:55', '2022-05-18 19:06:55', NULL, NULL, 0, NULL, 0, NULL, 1, NULL, 0),
(613, NULL, 21, 'manual_entry', NULL, NULL, '2022-05-17', '05', '2022', '115478', NULL, NULL, NULL, NULL, '150000000.00', 'TZS', '1.00', NULL, 1, NULL, '2022-05-18 19:12:29', '2022-05-18 19:12:29', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(614, NULL, 4, 'manual_entry', NULL, NULL, '2022-05-17', '05', '2022', '115478', NULL, NULL, NULL, '150000000.00', NULL, 'TZS', '1.00', NULL, 1, NULL, '2022-05-18 19:12:29', '2022-05-18 19:12:29', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(615, NULL, 66, 'cotton', 'Stock Movement', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '11', '12050000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Movement From Solwa to  Main Center', '2022-05-18 20:41:05', '2022-05-18 20:41:05', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(616, NULL, 71, 'cotton', 'Stock  Movement', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '11', NULL, '12050000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  Solwa to Main Center', '2022-05-18 20:41:05', '2022-05-18 20:41:05', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(617, NULL, 75, 'cotton', 'Stock Movement', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '11', '50000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement From Solwa to  Main Center', '2022-05-18 20:41:05', '2022-05-18 20:41:05', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(618, NULL, 76, 'cotton', 'Stock  Movement', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '11', NULL, '50000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  Solwa to Main Center', '2022-05-18 20:41:05', '2022-05-18 20:41:05', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(619, NULL, 66, 'cotton', 'Stock Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '12', '30000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Movement From mwakiponya A to  Main Center', '2022-05-18 20:49:33', '2022-05-18 20:49:33', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(620, NULL, 71, 'cotton', 'Stock  Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '12', NULL, '30000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya A to Main Center', '2022-05-18 20:49:33', '2022-05-18 20:49:33', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(621, NULL, 75, 'cotton', 'Stock Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '12', '50000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement From mwakiponya A to  Main Center', '2022-05-18 20:49:33', '2022-05-18 20:49:33', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(622, NULL, 76, 'cotton', 'Stock  Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '12', NULL, '50000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya A to Main Center', '2022-05-18 20:49:33', '2022-05-18 20:49:33', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(623, NULL, 66, 'cotton', 'Stock Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '13', '4000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Movement From mwakiponya A to  Main Center', '2022-05-18 20:56:24', '2022-05-18 20:56:24', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(624, NULL, 71, 'cotton', 'Stock  Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '13', NULL, '4000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya A to Main Center', '2022-05-18 20:56:24', '2022-05-18 20:56:24', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(625, NULL, 75, 'cotton', 'Stock Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '13', '5000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement From mwakiponya A to  Main Center', '2022-05-18 20:56:24', '2022-05-18 20:56:24', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(626, NULL, 76, 'cotton', 'Stock  Movement', NULL, '2022-05-17', '05', '2022', NULL, NULL, NULL, '13', NULL, '5000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya A to Main Center', '2022-05-18 20:56:24', '2022-05-18 20:56:24', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(627, NULL, 66, 'cotton', 'Stock Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '14', '4000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Movement From mwakiponya A to  Main Center', '2022-05-18 21:05:41', '2022-05-18 21:05:41', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(628, NULL, 71, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '14', NULL, '4000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya A to Main Center', '2022-05-18 21:05:41', '2022-05-18 21:05:41', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(629, NULL, 75, 'cotton', 'Stock Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '14', '1000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement From mwakiponya A to  Main Center', '2022-05-18 21:05:41', '2022-05-18 21:05:41', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(630, NULL, 76, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '14', NULL, '1000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya A to Main Center', '2022-05-18 21:05:41', '2022-05-18 21:05:41', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(631, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '14', '708.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement District Levy From mwakiponya A to  Main Center', '2022-05-18 21:05:41', '2022-05-18 21:05:41', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(632, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '14', NULL, '708.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-18 21:05:41', '2022-05-18 21:05:41', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(633, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '14', '708.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement District Levy From mwakiponya A to  Main Center', '2022-05-18 21:05:41', '2022-05-18 21:05:41', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(634, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '14', NULL, '708.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-18 21:05:41', '2022-05-18 21:05:41', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(635, NULL, 66, 'cotton', 'Stock Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '15', '4000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Movement From mwakiponya A to  Main Center', '2022-05-18 21:13:27', '2022-05-18 21:13:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(636, NULL, 71, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '15', NULL, '4000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya A to Main Center', '2022-05-18 21:13:27', '2022-05-18 21:13:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(637, NULL, 75, 'cotton', 'Stock Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '15', '1000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement From mwakiponya A to  Main Center', '2022-05-18 21:13:27', '2022-05-18 21:13:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(638, NULL, 76, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '15', NULL, '1000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya A to Main Center', '2022-05-18 21:13:27', '2022-05-18 21:13:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(639, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '15', '708.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement District Levy From mwakiponya A to  Main Center', '2022-05-18 21:13:27', '2022-05-18 21:13:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(640, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '15', NULL, '708.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-18 21:13:27', '2022-05-18 21:13:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(641, NULL, 73, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '15', '1000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Community Levy From mwakiponya A to  Main Center', '2022-05-18 21:13:27', '2022-05-18 21:13:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(642, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '15', NULL, '1000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-18 21:13:27', '2022-05-18 21:13:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(643, NULL, 66, 'cotton', 'Stock Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '16', '4000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Movement From mwakiponya A to  Main Center', '2022-05-18 21:19:13', '2022-05-18 21:19:13', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(644, NULL, 71, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '16', NULL, '4000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya A to Main Center', '2022-05-18 21:19:13', '2022-05-18 21:19:13', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(645, NULL, 75, 'cotton', 'Stock Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '16', '1000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement From mwakiponya A to  Main Center', '2022-05-18 21:19:13', '2022-05-18 21:19:13', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(646, NULL, 76, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '16', NULL, '1000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya A to Main Center', '2022-05-18 21:19:13', '2022-05-18 21:19:13', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(647, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '16', '708.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement District Levy From mwakiponya A to  Main Center', '2022-05-18 21:19:13', '2022-05-18 21:19:13', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(648, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '16', NULL, '708.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-18 21:19:13', '2022-05-18 21:19:13', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(649, NULL, 73, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '16', '500.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Community Levy From mwakiponya A to  Main Center', '2022-05-18 21:19:13', '2022-05-18 21:19:13', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(650, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '16', NULL, '500.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-18 21:19:13', '2022-05-18 21:19:13', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(651, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '16', '1416.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement District Levy From mwakiponya A to  Main Center', '2022-05-18 21:19:13', '2022-05-18 21:19:13', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(652, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '16', NULL, '1416.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-18 21:19:13', '2022-05-18 21:19:13', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(653, NULL, 73, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '16', '1000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Community Levy From mwakiponya A to  Main Center', '2022-05-18 21:19:13', '2022-05-18 21:19:13', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(654, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-11', '05', '2022', NULL, NULL, NULL, '16', NULL, '1000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-18 21:19:13', '2022-05-18 21:19:13', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 0),
(655, NULL, 17, 'cargo', 'Invoice', NULL, '2022-05-19', '05', '2022', NULL, NULL, NULL, '5', NULL, '1350000.00', 'TZS', '1.00', NULL, 1, 'Invoice with reference no PCL-5  by Client Mohammed Enterprises', '2022-05-19 13:06:34', '2022-05-19 13:06:34', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(656, NULL, 23, 'cargo', 'Invoice', NULL, '2022-05-19', '05', '2022', NULL, NULL, NULL, '5', NULL, '243000.00', 'TZS', '1.00', NULL, 1, 'Invoice Tax with reference no PCL-5  by Client Mohammed Enterprises', '2022-05-19 13:06:34', '2022-05-19 13:06:34', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(657, NULL, 4, 'cargo', 'Invoice', NULL, '2022-05-19', '05', '2022', NULL, NULL, NULL, '5', '1593000.00', NULL, 'TZS', '1.00', NULL, 1, 'Debit Receivables for Invoice with reference no PCL-5  by Client Mohammed Enterprises', '2022-05-19 13:06:34', '2022-05-19 13:06:34', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(658, NULL, 70, 'operator', 'Top Up Operator', NULL, '2022-05-17', '05', '2022', NULL, 2, NULL, NULL, '23000.00', NULL, 'TZS', '1.00', NULL, 1, 'Top Up From Petty Cash to Operator Mwakikungu station', '2022-05-19 16:15:08', '2022-05-19 16:15:08', NULL, NULL, 0, NULL, 0, 1, NULL, NULL, 0),
(659, NULL, 7, 'operator', 'Top Up Operator', NULL, '2022-05-17', '05', '2022', NULL, 2, NULL, NULL, NULL, '23000.00', 'TZS', '1.00', NULL, 1, 'Top Up From Petty Cash to Operator Mwakikungu station', '2022-05-19 16:15:09', '2022-05-19 16:15:09', NULL, NULL, 0, NULL, 0, 1, NULL, NULL, 0),
(660, NULL, 7, 'operator', 'Reverse Top Up Operator', NULL, '2022-05-17', '05', '2022', NULL, 2, NULL, NULL, '23000.00', NULL, 'TZS', '1.00', NULL, 1, 'Reverse Top Up From Operator Mwakikungu station to Petty Cash', '2022-05-19 16:16:13', '2022-05-19 16:16:13', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(661, NULL, 6, 'operator', 'Reverse Top Up Operator', NULL, '2022-05-16', '05', '2022', NULL, 3, NULL, NULL, '4000000.00', NULL, 'TZS', '1.00', NULL, 1, 'Reverse Top Up From Operator Nicco Kowero to CRDB', '2022-05-19 16:22:37', '2022-05-19 16:22:37', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(662, NULL, 20, 'tire', 'Tire Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '2', '10000.00', NULL, 'TZS', '1.00', NULL, 1, 'Tire Purchase with reference no PUR_TYRE_2_2022-05-18 by Supplier Charles', '2022-05-19 19:11:38', '2022-05-19 19:11:38', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(663, NULL, 22, 'tire', 'Tire Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '2', '1800.00', NULL, 'TZS', '1.00', NULL, 1, 'Tire Purchase Tax with reference no PUR_TYRE_2_2022-05-18 by Supplier Charles', '2022-05-19 19:11:38', '2022-05-19 19:11:38', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(664, NULL, 16, 'tire', 'Tire Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '2', NULL, '11800.00', 'TZS', '1.00', NULL, 1, 'Credit for Tire Purchase with reference no PUR_TYRE_2_2022-05-18 by Supplier Charles', '2022-05-19 19:11:38', '2022-05-19 19:11:38', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(665, NULL, 20, 'tire', 'Tire Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '3', '5000.00', NULL, 'TZS', '1.00', NULL, 1, 'Tire Purchase with reference no PUR_TYRE_3_2022-05-18 by Supplier Mussa Kombe', '2022-05-19 21:36:59', '2022-05-19 21:36:59', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(666, NULL, 16, 'tire', 'Tire Purchase', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '3', NULL, '5000.00', 'TZS', '1.00', NULL, 1, 'Credit for Tire Purchase with reference no PUR_TYRE_3_2022-05-18 by Supplier Mussa Kombe', '2022-05-19 21:36:59', '2022-05-19 21:36:59', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(667, NULL, 66, 'cotton', 'Stock Movement', NULL, '2022-05-20', '05', '2022', NULL, NULL, NULL, '18', '0.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Movement From Solwa to  Main Center', '2022-05-20 12:37:08', '2022-05-20 12:37:08', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(668, NULL, 71, 'cotton', 'Stock  Movement', NULL, '2022-05-20', '05', '2022', NULL, NULL, NULL, '18', NULL, '0.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  Solwa to Main Center', '2022-05-20 12:37:08', '2022-05-20 12:37:08', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(669, NULL, 75, 'cotton', 'Stock Movement', NULL, '2022-05-20', '05', '2022', NULL, NULL, NULL, '18', '400.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement From Solwa to  Main Center', '2022-05-20 12:37:08', '2022-05-20 12:37:08', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(670, NULL, 76, 'cotton', 'Stock  Movement', NULL, '2022-05-20', '05', '2022', NULL, NULL, NULL, '18', NULL, '400.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  Solwa to Main Center', '2022-05-20 12:37:08', '2022-05-20 12:37:08', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 0),
(671, NULL, 66, 'cotton', 'Stock Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '19', '0.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Movement From mwakiponya to  Main Center', '2022-05-20 13:57:09', '2022-05-20 13:57:09', NULL, NULL, 0, NULL, 0, NULL, 1, NULL, NULL),
(672, NULL, 71, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '19', NULL, '0.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya to Main Center', '2022-05-20 13:57:09', '2022-05-20 13:57:09', NULL, NULL, 0, NULL, 0, NULL, 1, NULL, NULL),
(673, NULL, 75, 'cotton', 'Stock Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '19', '400.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement From mwakiponya to  Main Center', '2022-05-20 13:57:09', '2022-05-20 13:57:09', NULL, NULL, 0, NULL, 0, NULL, 1, NULL, NULL),
(674, NULL, 76, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '19', NULL, '400.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya to Main Center', '2022-05-20 13:57:09', '2022-05-20 13:57:09', NULL, NULL, 0, NULL, 0, NULL, 1, NULL, NULL),
(675, NULL, 19, 'fuel', 'Fuel Refill', NULL, '2022-05-20', '05', '2022', NULL, 4, NULL, NULL, '15000.00', NULL, 'TZS', '1.00', NULL, 1, 'Fuel Refill for Truck scania', '2022-05-20 15:53:23', '2022-05-20 15:53:23', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(676, NULL, 32, 'fuel', 'Fuel Refill', NULL, '2022-05-20', '05', '2022', NULL, 4, NULL, NULL, NULL, '15000.00', 'TZS', '1.00', NULL, 1, 'Payment for Fuel Refill for Truck scania', '2022-05-20 15:53:23', '2022-05-20 15:53:23', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(677, NULL, 17, 'cargo', 'Invoice', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '8', NULL, '0.00', 'TZS', '1.00', NULL, 1, 'Invoice with reference no 12AB  by Client ABC Company', '2022-05-20 21:15:55', '2022-05-20 21:15:55', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(678, NULL, 17, 'cargo', 'Invoice', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '8', NULL, '0.00', 'TZS', '1.00', NULL, 1, 'Invoice with reference no 12AB  by Client ABC Company', '2022-05-20 21:16:27', '2022-05-20 21:16:27', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(679, NULL, 4, 'cargo', 'Invoice', NULL, '2022-05-18', '05', '2022', NULL, NULL, NULL, '8', '0.00', NULL, 'TZS', '1.00', NULL, 1, 'Debit Receivables for Invoice with reference no 12AB  by Client ABC Company', '2022-05-20 21:16:27', '2022-05-20 21:16:27', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(680, NULL, 40, 'mileage', 'Mileage', NULL, '2022-05-20', '05', '2022', NULL, NULL, NULL, '12', '50000.00', NULL, 'TZS', '1.00', NULL, 1, 'Mileage of Shipment test shipment  to Driver  John Mashauri with Truck scania', '2022-05-20 22:51:16', '2022-05-20 22:51:16', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(681, NULL, 16, 'mileage', 'Mileage', NULL, '2022-05-20', '05', '2022', NULL, NULL, NULL, '12', NULL, '50000.00', 'TZS', '1.00', NULL, 1, 'Mileage of Shipment test shipment  to Driver  John Mashauri with Truck scania', '2022-05-20 22:51:16', '2022-05-20 22:51:16', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(682, NULL, 40, 'mileage', 'Mileage', NULL, '2022-05-20', '05', '2022', NULL, NULL, NULL, '13', '51525.00', NULL, 'TZS', '1.00', NULL, 1, 'Mileage of Shipment test shipment  to Driver  said isiaka with Truck Toyota', '2022-05-20 22:57:31', '2022-05-20 22:57:31', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(683, NULL, 16, 'mileage', 'Mileage', NULL, '2022-05-20', '05', '2022', NULL, NULL, NULL, '13', NULL, '51525.00', 'TZS', '1.00', NULL, 1, 'Mileage of Shipment test shipment  to Driver  said isiaka with Truck Toyota', '2022-05-20 22:57:31', '2022-05-20 22:57:31', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(684, NULL, 71, 'collection', 'Top Up Collection', NULL, '2022-05-18', '05', '2022', NULL, 3, NULL, NULL, '1500000.00', NULL, 'TZS', '1.00', NULL, 1, 'Top Up From Operator Nicco Kowero to Collection Center Mwamahasa', '2022-05-21 17:09:06', '2022-05-21 17:09:06', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, NULL),
(685, NULL, 70, 'collection', 'Top Up Collection', NULL, '2022-05-18', '05', '2022', NULL, 3, NULL, NULL, NULL, '1500000.00', 'TZS', '1.00', NULL, 1, 'Top Up From Operator Nicco Kowero to Collection Center Mwamahasa', '2022-05-21 17:09:06', '2022-05-21 17:09:06', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, NULL),
(686, NULL, 65, 'cotton', 'Cotton Purchase', NULL, '2022-05-13', '05', '2022', NULL, NULL, NULL, '15', '4000000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Control with reference no AUTO-2022-05-13 by Operator Mwakikungu station to Mwamahasa Center', '2022-05-21 17:19:58', '2022-05-21 17:19:58', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, NULL),
(687, NULL, 16, 'cotton', 'Cotton Purchase', NULL, '2022-05-13', '05', '2022', NULL, NULL, NULL, '15', NULL, '4000000.00', 'TZS', '1.00', NULL, 1, 'Stock Control with reference no AUTO-2022-05-13 by Operator Mwakikungu station to Mwamahasa Center', '2022-05-21 17:19:58', '2022-05-21 17:19:58', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, NULL),
(688, NULL, 66, 'cotton', 'Stock Movement', NULL, '2022-05-21', '05', '2022', NULL, NULL, NULL, '20', '0.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Movement From Mwamahasa to  Main Center', '2022-05-21 19:31:53', '2022-05-21 19:31:53', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 50),
(689, NULL, 71, 'cotton', 'Stock  Movement', NULL, '2022-05-21', '05', '2022', NULL, NULL, NULL, '20', NULL, '0.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  Mwamahasa to Main Center', '2022-05-21 19:31:53', '2022-05-21 19:31:53', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 50),
(690, NULL, 75, 'cotton', 'Stock Movement', NULL, '2022-05-21', '05', '2022', NULL, NULL, NULL, '20', '52920.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement From Mwamahasa to  Main Center', '2022-05-21 19:31:53', '2022-05-21 19:31:53', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 50),
(691, NULL, 76, 'cotton', 'Stock  Movement', NULL, '2022-05-21', '05', '2022', NULL, NULL, NULL, '20', NULL, '52920.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  Mwamahasa to Main Center', '2022-05-21 19:31:53', '2022-05-21 19:31:53', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 50),
(692, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-21', '05', '2022', NULL, NULL, NULL, '20', '225000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement District Levy From Mwamahasa to  Main Center', '2022-05-21 19:31:53', '2022-05-21 19:31:53', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 50),
(693, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-21', '05', '2022', NULL, NULL, NULL, '20', NULL, '225000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-21 19:31:53', '2022-05-21 19:31:53', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 50),
(694, NULL, 73, 'cotton', 'Stock  Movement', NULL, '2022-05-21', '05', '2022', NULL, NULL, NULL, '20', '250000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement District Levy From Mwamahasa to  Main Center', '2022-05-21 19:31:53', '2022-05-21 19:31:53', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 50),
(695, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-21', '05', '2022', NULL, NULL, NULL, '20', NULL, '250000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-21 19:31:53', '2022-05-21 19:31:53', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 50),
(696, NULL, 78, 'cotton', 'Stock  Movement', NULL, '2022-05-21', '05', '2022', NULL, NULL, NULL, '20', '75000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement District Levy From Mwamahasa to  Main Center', '2022-05-21 19:31:53', '2022-05-21 19:31:53', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 50),
(697, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-21', '05', '2022', NULL, NULL, NULL, '20', NULL, '75000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-21 19:31:53', '2022-05-21 19:31:53', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 50),
(698, NULL, 79, 'cotton', 'Stock  Movement', NULL, '2022-05-21', '05', '2022', NULL, NULL, NULL, '20', '999999.99', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement District Levy From Mwamahasa to  Main Center', '2022-05-21 19:31:53', '2022-05-21 19:31:53', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 50),
(699, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-21', '05', '2022', NULL, NULL, NULL, '20', NULL, '999999.99', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-21 19:31:53', '2022-05-21 19:31:53', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 50),
(700, NULL, 29, 'cargo_payment', 'Invoice Payment', NULL, '2022-05-21', '05', '2022', NULL, 2, NULL, NULL, '700.00', NULL, 'TZS', '1.00', NULL, 1, 'Payment for Clear Credit  with reference no PCL-8', '2022-05-21 23:12:15', '2022-05-21 23:20:32', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1);
INSERT INTO `journal_entries` (`id`, `user_id`, `account_id`, `transaction_type`, `name`, `gl_code`, `date`, `month`, `year`, `reference`, `payment_id`, `payment_month`, `income_id`, `debit`, `credit`, `currency_code`, `exchange_rate`, `balance`, `active`, `notes`, `created_at`, `updated_at`, `loan_transaction_id`, `branch_id`, `reconcile`, `transaction_sub_type`, `reversed`, `operator_id`, `center_id`, `client_id`, `added_by`) VALUES
(701, NULL, 4, 'cargo_payment', 'Invoice Payment', NULL, '2022-05-21', '05', '2022', NULL, 2, NULL, NULL, NULL, '700.00', 'TZS', '1.00', NULL, 1, 'Clear Creditor  with reference no PCL-8', '2022-05-21 23:12:15', '2022-05-21 23:20:32', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(709, NULL, 29, 'cargo_payment', 'Cargo Payment', NULL, '2022-05-22', '05', '2022', NULL, 3, NULL, NULL, '10000.00', NULL, 'TZS', '1.00', NULL, 1, 'Payment for Clear Credit  with reference no PCL-1', '2022-05-22 15:34:24', '2022-05-22 15:34:24', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(708, NULL, 29, 'operator', 'Reverse Top Up Operator', NULL, '2022-05-17', '05', '2022', NULL, 2, NULL, NULL, '23000.00', NULL, 'TZS', '1.00', NULL, 1, 'Reverse Top Up From Operator Mwakikungu station to AIRTEL MONEY', '2022-05-22 14:52:50', '2022-05-22 14:52:50', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(707, NULL, 7, 'mileage_payment', 'Mileage Payment', NULL, '2022-05-21', '05', '2022', NULL, 1, NULL, NULL, NULL, '25000.00', 'TZS', '1.00', NULL, 1, 'Payment for Clear Credit   to Driver  John Mashauri driving Truck scania', '2022-05-21 23:53:32', '2022-05-21 23:53:32', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(706, NULL, 16, 'mileage_payment', 'Mileage Payment', NULL, '2022-05-21', '05', '2022', NULL, 1, NULL, NULL, '25000.00', NULL, 'TZS', '1.00', NULL, 1, 'Clear Creditor  to Driver  John Mashauri with Truck scania', '2022-05-21 23:53:32', '2022-05-21 23:53:32', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(713, NULL, 6, 'courier_payment', 'Invoice Payment', NULL, '2022-05-23', '05', '2022', NULL, 2, NULL, NULL, '100000.00', NULL, 'TZS', '1.00', NULL, 1, 'Courier Payment for Clear Credit  with reference no CM-1', '2022-05-23 13:21:40', '2022-05-23 13:33:37', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(711, NULL, 29, 'cargo_payment', 'Cargo Payment', NULL, '2022-05-22', '05', '2022', NULL, 4, NULL, NULL, '10000.00', NULL, 'TZS', '1.00', NULL, 1, 'Payment for Clear Credit  with reference no PCL-1', '2022-05-22 15:35:08', '2022-05-22 15:35:08', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(712, NULL, 4, 'cargo_payment', 'Cargo Payment', NULL, '2022-05-22', '05', '2022', NULL, 4, NULL, NULL, NULL, '10000.00', 'TZS', '1.00', NULL, 1, 'Clear Debitor  with reference no PCL-1', '2022-05-22 15:35:08', '2022-05-22 15:35:08', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(714, NULL, 4, 'courier_payment', 'Invoice Payment', NULL, '2022-05-23', '05', '2022', NULL, 2, NULL, NULL, NULL, '100000.00', 'TZS', '1.00', NULL, 1, 'Clear Courier Creditor  with reference no CM-1', '2022-05-23 13:21:40', '2022-05-23 13:33:37', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(715, 45, 13, 'salary', 'Salary Payment', NULL, '2022-05-23', '05', '2022', NULL, 15, '2022-04', NULL, '544000.00', NULL, 'TZS', '1.00', NULL, 1, 'Net Salary Payment to   for the month April 2022', '2022-05-23 13:55:57', '2022-05-23 13:55:57', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(716, 45, 6, 'salary', 'Salary Payment', NULL, '2022-05-23', '05', '2022', NULL, 15, '2022-04', NULL, NULL, '544000.00', 'TZS', '1.00', NULL, 1, 'Net Salary Payment to   for the month April 2022', '2022-05-23 13:55:57', '2022-05-23 13:55:57', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(717, 45, 13, 'salary', 'PAYE Payment', NULL, '2022-05-23', '05', '2022', NULL, 15, '2022-04', NULL, '31000.00', NULL, 'TZS', '1.00', NULL, 1, 'PAYE Payment from   for the month April 2022', '2022-05-23 13:55:57', '2022-05-23 13:55:57', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(718, 45, 42, 'salary', 'PAYE Payment', NULL, '2022-05-23', '05', '2022', NULL, 15, '2022-04', NULL, NULL, '31000.00', 'TZS', '1.00', NULL, 1, 'PAYE Payment from   for the month April 2022', '2022-05-23 13:55:57', '2022-05-23 13:55:57', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(719, 45, 13, 'salary', 'NSSF Payment', NULL, '2022-05-23', '05', '2022', NULL, 15, '2022-04', NULL, '50000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF Payment from   for the month April 2022', '2022-05-23 13:55:57', '2022-05-23 13:55:57', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(720, 45, 14, 'salary', 'NSSF Payment', NULL, '2022-05-23', '05', '2022', NULL, 15, '2022-04', NULL, NULL, '50000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from   for the month April 2022', '2022-05-23 13:55:57', '2022-05-23 13:55:57', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(721, 45, 44, 'salary', 'NSSF (Employer Contribution) Payment', NULL, '2022-05-23', '05', '2022', NULL, 15, '2022-04', NULL, '50000.00', NULL, 'TZS', '1.00', NULL, 1, 'NSSF (Employer Contribution) Payment from   for the month April 2022', '2022-05-23 13:55:57', '2022-05-23 13:55:57', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(722, 45, 14, 'salary', 'NSSF Payment', NULL, '2022-05-23', '05', '2022', NULL, 15, '2022-04', NULL, NULL, '50000.00', 'TZS', '1.00', NULL, 1, 'NSSF Payment from   for the month April 2022', '2022-05-23 13:55:57', '2022-05-23 13:55:57', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(723, 45, 46, 'salary', 'WCF Contribution Payment', NULL, '2022-05-23', '05', '2022', NULL, 15, '2022-04', NULL, '3000.00', NULL, 'TZS', '1.00', NULL, 1, 'WCF Contribution Payment from   for the month April 2022', '2022-05-23 13:55:57', '2022-05-23 13:55:57', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(724, 45, 47, 'salary', 'WCF Payment', NULL, '2022-05-23', '05', '2022', NULL, 15, '2022-04', NULL, NULL, '3000.00', 'TZS', '1.00', NULL, 1, 'WCF  Payment from   for the month April 2022', '2022-05-23 13:55:57', '2022-05-23 13:55:57', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(725, 45, 49, 'salary', 'NHIF (Heath Insurance Expense) Payment', NULL, '2022-05-23', '05', '2022', NULL, 15, '2022-04', NULL, '15000.00', NULL, 'TZS', '1.00', NULL, 1, 'NHIF (Heath Insurance Expense) Payment from   for the month April 2022', '2022-05-23 13:55:57', '2022-05-23 13:55:57', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(726, 45, 50, 'salary', 'NHIF Payment', NULL, '2022-05-23', '05', '2022', NULL, 15, '2022-04', NULL, NULL, '15000.00', 'TZS', '1.00', NULL, 1, 'NHIF  Payment from   for the month April 2022', '2022-05-23 13:55:57', '2022-05-23 13:55:57', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(727, NULL, 19, 'fuel', 'Fuel Refill', NULL, '2022-05-23', '05', '2022', NULL, 5, NULL, NULL, '20000.00', NULL, 'TZS', '1.00', NULL, 1, 'Fuel Refill for Truck T711 CFS SCANIA', '2022-05-23 14:12:43', '2022-05-23 14:12:43', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(728, NULL, 32, 'fuel', 'Fuel Refill', NULL, '2022-05-23', '05', '2022', NULL, 5, NULL, NULL, NULL, '20000.00', 'TZS', '1.00', NULL, 1, 'Payment for Fuel Refill for Truck T711 CFS SCANIA', '2022-05-23 14:12:43', '2022-05-23 14:12:43', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(729, NULL, 16, 'tire_payment', 'Tire Payment', NULL, '2022-05-23', '05', '2022', NULL, 1, NULL, NULL, '2400000.00', NULL, 'USD', '2400.00', NULL, 1, 'Clear Creditor  with reference no PUR_TYRE_1_2022-05-17 by Supplier Ujuzinet', '2022-05-23 14:36:10', '2022-05-23 14:38:29', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(730, NULL, 24, 'tire_payment', 'Tire Payment', NULL, '2022-05-23', '05', '2022', NULL, 1, NULL, NULL, NULL, '2400000.00', 'USD', '2400.00', NULL, 1, 'Payment for Clear Credit  with reference no PUR_TYRE_1_2022-05-17 by Supplier Ujuzinet', '2022-05-23 14:36:10', '2022-05-23 14:38:29', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(737, NULL, 6, 'deposit', 'Deposit Payment', NULL, '2022-05-23', '05', '2022', NULL, 2, NULL, NULL, '70000.00', NULL, 'TZS', '1.00', NULL, 1, 'Deposit Payment with transaction id TRANS_DEP_IP5v', '2022-05-23 15:21:42', '2022-05-23 15:21:42', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(736, NULL, 33, 'deposit', 'Deposit Payment', NULL, '2022-05-23', '05', '2022', NULL, 2, NULL, NULL, NULL, '70000.00', 'TZS', '1.00', NULL, 1, 'Deposit Payment with transaction id TRANS_DEP_IP5v', '2022-05-23 15:21:22', '2022-05-23 15:21:22', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(733, NULL, 16, 'inventory_payment', 'Inventory Payment', NULL, '2022-05-23', '05', '2022', NULL, 3, NULL, NULL, '30000.00', NULL, 'TZS', '1.00', NULL, 1, 'Clear Creditor  with reference no PUR_INV-1-2022-04-19 by Supplier unknown', '2022-05-23 14:51:36', '2022-05-23 14:51:36', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(734, NULL, 27, 'inventory_payment', 'Inventory Payment', NULL, '2022-05-23', '05', '2022', NULL, 3, NULL, NULL, NULL, '30000.00', 'TZS', '1.00', NULL, 1, 'Payment for Clear Credit  with reference no PUR_INV-1-2022-04-19 by Supplier unknown', '2022-05-23 14:51:36', '2022-05-23 14:51:36', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(739, NULL, 30, 'expense_payment', 'Expense Payment', NULL, '2022-05-23', '05', '2022', NULL, 4, NULL, NULL, '10000.00', NULL, 'TZS', '1.00', NULL, 1, 'Expense Payment with transaction id TRANS_EXP_7Hpg', '2022-05-23 15:54:52', '2022-05-23 15:54:52', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(740, NULL, 7, 'expense_payment', 'Expense Payment', NULL, '2022-05-23', '05', '2022', NULL, 4, NULL, NULL, NULL, '10000.00', 'TZS', '1.00', NULL, 1, 'Expense Payment with transaction id TRANS_EXP_7Hpg', '2022-05-23 15:54:52', '2022-05-23 15:54:52', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(741, NULL, 32, 'transfer', 'Transfer Payment', NULL, '2022-05-23', '05', '2022', NULL, 4, NULL, NULL, '50000.00', NULL, 'TZS', '1.00', NULL, 1, 'Money Transfer From CRDB to Cash Account', '2022-05-23 16:14:48', '2022-05-23 16:14:48', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(742, NULL, 6, 'transfer', 'Transfer Payment', NULL, '2022-05-23', '05', '2022', NULL, 4, NULL, NULL, NULL, '50000.00', 'TZS', '1.00', NULL, 1, 'Money Transfer From CRDB to Cash Account', '2022-05-23 16:14:48', '2022-05-23 16:14:48', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(743, NULL, 27, 'transfer', 'Transfer Payment', NULL, '2022-05-23', '05', '2022', NULL, 6, NULL, NULL, '10000.00', NULL, 'TZS', '1.00', NULL, 1, 'Money Transfer From CRDB to MPESA', '2022-05-23 16:19:16', '2022-05-23 16:19:16', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(744, NULL, 6, 'transfer', 'Transfer Payment', NULL, '2022-05-23', '05', '2022', NULL, 6, NULL, NULL, NULL, '10000.00', 'TZS', '1.00', NULL, 1, 'Money Transfer From CRDB to MPESA', '2022-05-23 16:19:16', '2022-05-23 16:19:16', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(745, NULL, 65, 'cotton', 'Cotton Purchase', NULL, '2022-05-23', '05', '2022', NULL, NULL, NULL, '16', '26000000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Control with reference no AUTO-2022-05-23 by Operator Mwakikungu station to Mwamahasa Center', '2022-05-23 17:31:08', '2022-05-23 17:31:08', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, NULL),
(746, NULL, 16, 'cotton', 'Cotton Purchase', NULL, '2022-05-23', '05', '2022', NULL, NULL, NULL, '16', NULL, '26000000.00', 'TZS', '1.00', NULL, 1, 'Stock Control with reference no AUTO-2022-05-23 by Operator Mwakikungu station to Mwamahasa Center', '2022-05-23 17:31:08', '2022-05-23 17:31:08', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, NULL),
(747, NULL, 17, 'cargo', 'Invoice', NULL, '2022-05-23', '05', '2022', NULL, NULL, NULL, '9', NULL, '0.00', 'TZS', '1.00', NULL, 1, 'Invoice with reference no 12AB  by Client Jefag Logistics Tanzania Limited', '2022-05-23 22:57:46', '2022-05-23 22:57:46', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(748, NULL, 4, 'cargo', 'Invoice', NULL, '2022-05-23', '05', '2022', NULL, NULL, NULL, '9', '0.00', NULL, 'TZS', '1.00', NULL, 1, 'Debit Receivables for Invoice with reference no 12AB  by Client Jefag Logistics Tanzania Limited', '2022-05-23 22:57:46', '2022-05-23 22:57:46', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 1),
(749, NULL, 65, 'cotton', 'Cotton Purchase', NULL, '2022-05-24', '05', '2022', NULL, NULL, NULL, '17', '60000000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Control with reference no 44w3345 by Operator Nicco Kowero to Mwamahasa Center', '2022-05-24 12:51:30', '2022-05-24 12:51:30', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, NULL),
(750, NULL, 16, 'cotton', 'Cotton Purchase', NULL, '2022-05-24', '05', '2022', NULL, NULL, NULL, '17', NULL, '60000000.00', 'TZS', '1.00', NULL, 1, 'Stock Control with reference no 44w3345 by Operator Nicco Kowero to Mwamahasa Center', '2022-05-24 12:51:30', '2022-05-24 12:51:30', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, NULL),
(751, NULL, 66, 'cotton', 'Stock Movement', NULL, '2022-05-24', '05', '2022', NULL, NULL, NULL, '21', '0.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Movement From Solwa to  Main Center', '2022-05-24 22:35:32', '2022-05-24 22:35:32', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 1),
(752, NULL, 71, 'cotton', 'Stock  Movement', NULL, '2022-05-24', '05', '2022', NULL, NULL, NULL, '21', NULL, '0.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  Solwa to Main Center', '2022-05-24 22:35:32', '2022-05-24 22:35:32', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 1),
(753, NULL, 75, 'cotton', 'Stock Movement', NULL, '2022-05-24', '05', '2022', NULL, NULL, NULL, '21', '20000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement From Solwa to  Main Center', '2022-05-24 22:35:32', '2022-05-24 22:35:32', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 1),
(754, NULL, 76, 'cotton', 'Stock  Movement', NULL, '2022-05-24', '05', '2022', NULL, NULL, NULL, '21', NULL, '20000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  Solwa to Main Center', '2022-05-24 22:35:32', '2022-05-24 22:35:32', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 1),
(755, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-24', '05', '2022', NULL, NULL, NULL, '21', '283500.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement District Levy From Solwa to  Main Center', '2022-05-24 22:35:32', '2022-05-24 22:35:32', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 1),
(756, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-24', '05', '2022', NULL, NULL, NULL, '21', NULL, '283500.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Solwa to Main Center', '2022-05-24 22:35:32', '2022-05-24 22:35:32', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 1),
(757, NULL, 73, 'cotton', 'Stock  Movement', NULL, '2022-05-24', '05', '2022', NULL, NULL, NULL, '21', '225000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement District Levy From Solwa to  Main Center', '2022-05-24 22:35:32', '2022-05-24 22:35:32', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 1),
(758, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-24', '05', '2022', NULL, NULL, NULL, '21', NULL, '225000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Solwa to Main Center', '2022-05-24 22:35:32', '2022-05-24 22:35:32', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 1),
(759, NULL, 78, 'cotton', 'Stock  Movement', NULL, '2022-05-24', '05', '2022', NULL, NULL, NULL, '21', '94500.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement District Levy From Solwa to  Main Center', '2022-05-24 22:35:32', '2022-05-24 22:35:32', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 1),
(760, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-24', '05', '2022', NULL, NULL, NULL, '21', NULL, '94500.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Solwa to Main Center', '2022-05-24 22:35:32', '2022-05-24 22:35:32', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 1),
(761, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-24', '05', '2022', NULL, NULL, NULL, '21', '630000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement District Levy From Solwa to  Main Center', '2022-05-24 22:35:32', '2022-05-24 22:35:32', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 1),
(762, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-24', '05', '2022', NULL, NULL, NULL, '21', NULL, '630000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Solwa to Main Center', '2022-05-24 22:35:32', '2022-05-24 22:35:32', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 1),
(763, NULL, 73, 'cotton', 'Stock  Movement', NULL, '2022-05-24', '05', '2022', NULL, NULL, NULL, '21', '500000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement District Levy From Solwa to  Main Center', '2022-05-24 22:35:32', '2022-05-24 22:35:32', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 1),
(764, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-24', '05', '2022', NULL, NULL, NULL, '21', NULL, '500000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Solwa to Main Center', '2022-05-24 22:35:32', '2022-05-24 22:35:32', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 1),
(765, NULL, 78, 'cotton', 'Stock  Movement', NULL, '2022-05-24', '05', '2022', NULL, NULL, NULL, '21', '210000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement District Levy From Solwa to  Main Center', '2022-05-24 22:35:32', '2022-05-24 22:35:32', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 1),
(766, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-24', '05', '2022', NULL, NULL, NULL, '21', NULL, '210000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Solwa to Main Center', '2022-05-24 22:35:32', '2022-05-24 22:35:32', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, 1),
(767, NULL, 65, 'cotton', 'Cotton Purchase', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '18', '89600000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Control with reference no 1200 by Operator Nicco Kowero to Mwamahasa Center', '2022-05-25 10:56:32', '2022-05-25 10:56:32', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, NULL),
(768, NULL, 16, 'cotton', 'Cotton Purchase', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '18', NULL, '89600000.00', 'TZS', '1.00', NULL, 1, 'Stock Control with reference no 1200 by Operator Nicco Kowero to Mwamahasa Center', '2022-05-25 10:56:32', '2022-05-25 10:56:32', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, NULL),
(769, NULL, 66, 'cotton', 'Stock Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', '0.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Movement From Mwamahasa to  Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(770, NULL, 71, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', NULL, '0.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  Mwamahasa to Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(771, NULL, 75, 'cotton', 'Stock Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', '50000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement From Mwamahasa to  Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(772, NULL, 76, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', NULL, '50000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  Mwamahasa to Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(773, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', NULL, '225000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(774, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', '225000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(775, NULL, 73, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', NULL, '250000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(776, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', '250000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(777, NULL, 78, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', NULL, '75000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(778, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', '75000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(779, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', NULL, '120000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(780, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', '120000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(781, NULL, 73, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', NULL, '100000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(782, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', '100000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(783, NULL, 78, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', NULL, '40000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(784, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', '40000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(785, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', NULL, '780000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(786, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', '780000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(787, NULL, 73, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', NULL, '650000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(788, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', '650000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(789, NULL, 78, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', NULL, '260000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(790, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', '260000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(791, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', NULL, '999999.99', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(792, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', '999999.99', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(793, NULL, 73, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', NULL, '999999.99', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(794, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', '999999.99', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(795, NULL, 78, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', NULL, '600000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(796, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', '600000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(797, NULL, 79, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', NULL, '999999.99', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(798, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', '999999.99', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(799, NULL, 79, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', NULL, '500000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(800, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', '500000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(801, NULL, 79, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', NULL, '999999.99', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(802, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', '999999.99', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(803, NULL, 79, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', NULL, '999999.99', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(804, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '24', '999999.99', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 11:04:45', '2022-05-25 11:04:45', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(805, NULL, 65, 'cotton', 'Cotton Purchase', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '19', '88000000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Control with reference no 1112 by Operator Nicco Kowero to Mwamahasa Center', '2022-05-25 11:11:07', '2022-05-25 11:11:07', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, NULL),
(806, NULL, 16, 'cotton', 'Cotton Purchase', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '19', NULL, '88000000.00', 'TZS', '1.00', NULL, 1, 'Stock Control with reference no 1112 by Operator Nicco Kowero to Mwamahasa Center', '2022-05-25 11:11:07', '2022-05-25 11:11:07', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, NULL),
(807, NULL, 65, 'cotton', 'Cotton Purchase', NULL, '2022-05-25', '05', '22', NULL, NULL, NULL, '20', '922000000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Control with reference no AUTO-22-05-25 by Operator Mwakikungu station to Mwamahasa Center', '2022-05-25 11:25:41', '2022-05-25 11:25:41', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, NULL),
(808, NULL, 16, 'cotton', 'Cotton Purchase', NULL, '2022-05-25', '05', '22', NULL, NULL, NULL, '20', NULL, '922000000.00', 'TZS', '1.00', NULL, 1, 'Stock Control with reference no AUTO-22-05-25 by Operator Mwakikungu station to Mwamahasa Center', '2022-05-25 11:25:41', '2022-05-25 11:25:41', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, NULL),
(809, NULL, 66, 'cotton', 'Stock Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '25', '0.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Movement From mwakiponya A to  Main Center', '2022-05-25 11:47:08', '2022-05-25 11:47:08', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(810, NULL, 71, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '25', NULL, '0.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya A to Main Center', '2022-05-25 11:47:08', '2022-05-25 11:47:08', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(811, NULL, 75, 'cotton', 'Stock Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '25', '5000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement From mwakiponya A to  Main Center', '2022-05-25 11:47:08', '2022-05-25 11:47:08', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(812, NULL, 76, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '25', NULL, '5000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya A to Main Center', '2022-05-25 11:47:08', '2022-05-25 11:47:08', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(813, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '25', NULL, '708.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From mwakiponya A to  Main Center', '2022-05-25 11:47:08', '2022-05-25 11:47:08', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(814, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '25', '708.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-25 11:47:08', '2022-05-25 11:47:08', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(815, NULL, 73, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '25', NULL, '500.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From mwakiponya A to  Main Center', '2022-05-25 11:47:08', '2022-05-25 11:47:08', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(816, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '25', '500.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-25 11:47:08', '2022-05-25 11:47:08', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(817, NULL, 78, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '25', NULL, '236.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From mwakiponya A to  Main Center', '2022-05-25 11:47:08', '2022-05-25 11:47:08', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(818, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '25', '236.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-25 11:47:08', '2022-05-25 11:47:08', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(819, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '25', NULL, '1416.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From mwakiponya A to  Main Center', '2022-05-25 11:47:08', '2022-05-25 11:47:08', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(820, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '25', '1416.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-25 11:47:08', '2022-05-25 11:47:08', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(821, NULL, 73, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '25', NULL, '1000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From mwakiponya A to  Main Center', '2022-05-25 11:47:08', '2022-05-25 11:47:08', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(822, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '25', '1000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-25 11:47:08', '2022-05-25 11:47:08', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(823, NULL, 78, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '25', NULL, '472.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From mwakiponya A to  Main Center', '2022-05-25 11:47:08', '2022-05-25 11:47:08', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(824, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '25', '472.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-25 11:47:08', '2022-05-25 11:47:08', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(825, NULL, 66, 'cotton', 'Stock Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '26', '0.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Movement From mwakiponya A to  Main Center', '2022-05-25 11:59:04', '2022-05-25 11:59:04', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(826, NULL, 71, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '26', NULL, '0.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya A to Main Center', '2022-05-25 11:59:04', '2022-05-25 11:59:04', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(827, NULL, 75, 'cotton', 'Stock Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '26', '5000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement From mwakiponya A to  Main Center', '2022-05-25 11:59:04', '2022-05-25 11:59:04', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(828, NULL, 76, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '26', NULL, '5000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya A to Main Center', '2022-05-25 11:59:04', '2022-05-25 11:59:04', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(829, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '26', NULL, '708.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From mwakiponya A to  Main Center', '2022-05-25 11:59:04', '2022-05-25 11:59:04', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(830, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '26', '708.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-25 11:59:04', '2022-05-25 11:59:04', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(831, NULL, 73, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '26', NULL, '500.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From mwakiponya A to  Main Center', '2022-05-25 11:59:04', '2022-05-25 11:59:04', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(832, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '26', '500.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-25 11:59:04', '2022-05-25 11:59:04', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(833, NULL, 78, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '26', NULL, '236.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From mwakiponya A to  Main Center', '2022-05-25 11:59:04', '2022-05-25 11:59:04', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(834, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '26', '236.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-25 11:59:04', '2022-05-25 11:59:04', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(835, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '26', NULL, '1416.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From mwakiponya A to  Main Center', '2022-05-25 11:59:04', '2022-05-25 11:59:04', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(836, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '26', '1416.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-25 11:59:04', '2022-05-25 11:59:04', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(837, NULL, 73, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '26', NULL, '1000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From mwakiponya A to  Main Center', '2022-05-25 11:59:04', '2022-05-25 11:59:04', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(838, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '26', '1000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-25 11:59:04', '2022-05-25 11:59:04', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(839, NULL, 78, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '26', NULL, '472.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From mwakiponya A to  Main Center', '2022-05-25 11:59:04', '2022-05-25 11:59:04', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(840, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '26', '472.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-25 11:59:04', '2022-05-25 11:59:04', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(841, NULL, 66, 'cotton', 'Stock Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '27', '0.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Movement From mwakiponya A to  Main Center', '2022-05-25 12:00:27', '2022-05-25 12:00:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(842, NULL, 71, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '27', NULL, '0.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya A to Main Center', '2022-05-25 12:00:27', '2022-05-25 12:00:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(843, NULL, 75, 'cotton', 'Stock Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '27', '5000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement From mwakiponya A to  Main Center', '2022-05-25 12:00:27', '2022-05-25 12:00:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(844, NULL, 76, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '27', NULL, '5000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  mwakiponya A to Main Center', '2022-05-25 12:00:27', '2022-05-25 12:00:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(845, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '27', NULL, '708.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From mwakiponya A to  Main Center', '2022-05-25 12:00:27', '2022-05-25 12:00:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(846, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '27', '708.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-25 12:00:27', '2022-05-25 12:00:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(847, NULL, 73, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '27', NULL, '500.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From mwakiponya A to  Main Center', '2022-05-25 12:00:27', '2022-05-25 12:00:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(848, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '27', '500.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-25 12:00:27', '2022-05-25 12:00:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(849, NULL, 78, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '27', NULL, '236.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From mwakiponya A to  Main Center', '2022-05-25 12:00:27', '2022-05-25 12:00:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(850, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '27', '236.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-25 12:00:27', '2022-05-25 12:00:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(851, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '27', NULL, '1416.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From mwakiponya A to  Main Center', '2022-05-25 12:00:27', '2022-05-25 12:00:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(852, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '27', '1416.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-25 12:00:27', '2022-05-25 12:00:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(853, NULL, 73, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '27', NULL, '1000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From mwakiponya A to  Main Center', '2022-05-25 12:00:27', '2022-05-25 12:00:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(854, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '27', '1000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-25 12:00:27', '2022-05-25 12:00:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(855, NULL, 78, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '27', NULL, '472.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From mwakiponya A to  Main Center', '2022-05-25 12:00:27', '2022-05-25 12:00:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(856, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '27', '472.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  mwakiponya A to Main Center', '2022-05-25 12:00:27', '2022-05-25 12:00:27', NULL, NULL, 0, NULL, 0, NULL, 2, NULL, 50),
(857, NULL, 66, 'cotton', 'Stock Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '28', '0.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock Movement From Mwamahasa to  Main Center', '2022-05-25 12:05:08', '2022-05-25 12:05:08', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(858, NULL, 71, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '28', NULL, '0.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  Mwamahasa to Main Center', '2022-05-25 12:05:08', '2022-05-25 12:05:08', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(859, NULL, 75, 'cotton', 'Stock Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '28', '10000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement From Mwamahasa to  Main Center', '2022-05-25 12:05:08', '2022-05-25 12:05:08', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(860, NULL, 76, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '28', NULL, '10000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement From  Mwamahasa to Main Center', '2022-05-25 12:05:08', '2022-05-25 12:05:08', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(861, NULL, 72, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '28', NULL, '225000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 12:05:08', '2022-05-25 12:05:08', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(862, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '28', '225000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 12:05:08', '2022-05-25 12:05:08', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(863, NULL, 73, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '28', NULL, '250000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 12:05:08', '2022-05-25 12:05:08', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(864, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '28', '250000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 12:05:08', '2022-05-25 12:05:08', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(865, NULL, 78, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '28', NULL, '75000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 12:05:08', '2022-05-25 12:05:08', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(866, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '28', '75000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 12:05:08', '2022-05-25 12:05:08', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(867, NULL, 79, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '28', NULL, '1250000.00', 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy From Mwamahasa to  Main Center', '2022-05-25 12:05:08', '2022-05-25 12:05:08', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(868, NULL, 74, 'cotton', 'Stock  Movement', NULL, '2022-05-25', '05', '2022', NULL, NULL, NULL, '28', '1250000.00', NULL, 'TZS', '1.00', NULL, 1, 'Stock  Movement Levy Control From  Mwamahasa to Main Center', '2022-05-25 12:05:08', '2022-05-25 12:05:08', NULL, NULL, 0, NULL, 0, NULL, 5, NULL, 1),
(869, NULL, 71, 'collection', 'Top Up Collection', NULL, '2022-05-25', '05', '2022', NULL, 8, NULL, NULL, '36800.00', NULL, 'TZS', '1.00', NULL, 1, 'Top Up From Operator Test New Operator to Collection Center Solwa', '2022-05-25 19:21:14', '2022-05-25 19:21:14', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, NULL),
(870, NULL, 70, 'collection', 'Top Up Collection', NULL, '2022-05-25', '05', '2022', NULL, 8, NULL, NULL, NULL, '36800.00', 'TZS', '1.00', NULL, 1, 'Top Up From Operator Test New Operator to Collection Center Solwa', '2022-05-25 19:21:14', '2022-05-25 19:21:14', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, NULL),
(871, NULL, 7, 'operator', 'Reverse Top Up Operator', NULL, '2022-05-17', '05', '2022', NULL, 4, NULL, NULL, '2000.00', NULL, 'TZS', '1.00', NULL, 1, 'Reverse Top Up From Operator Test New Operator to Petty Cash', '2022-05-25 19:22:35', '2022-05-25 19:22:35', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(872, NULL, 71, 'collection', 'Top Up Collection', NULL, '2022-05-25', '05', '2022', NULL, 9, NULL, NULL, '2000.00', NULL, 'TZS', '1.00', NULL, 1, 'Top Up From Operator Test New Operator to Collection Center Solwa', '2022-05-25 19:29:08', '2022-05-25 19:29:08', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, NULL),
(873, NULL, 70, 'collection', 'Top Up Collection', NULL, '2022-05-25', '05', '2022', NULL, 9, NULL, NULL, NULL, '2000.00', 'TZS', '1.00', NULL, 1, 'Top Up From Operator Test New Operator to Collection Center Solwa', '2022-05-25 19:29:08', '2022-05-25 19:29:08', NULL, NULL, 0, NULL, 0, NULL, 4, NULL, NULL),
(874, NULL, 27, 'operator', 'Reverse Top Up Operator', NULL, '2022-05-16', '05', '2022', NULL, 3, NULL, NULL, '2500000.00', NULL, 'TZS', '1.00', NULL, 1, 'Reverse Top Up From Operator Nicco Kowero to MPESA', '2022-05-25 20:08:08', '2022-05-25 20:08:08', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(875, NULL, 27, 'operator', 'Reverse Top Up Operator', NULL, '2022-05-16', '05', '2022', NULL, 3, NULL, NULL, '2500000.00', NULL, 'TZS', '1.00', NULL, 1, 'Reverse Top Up From Operator Nicco Kowero to MPESA', '2022-05-25 20:11:36', '2022-05-25 20:11:36', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(876, NULL, 70, 'operator', 'Reverse Top Up Operator', NULL, '2022-05-16', '05', '2022', NULL, 3, NULL, NULL, NULL, '2500000.00', 'TZS', '1.00', NULL, 1, 'Reverse Top Up From Operator Nicco Kowero to MPESA', '2022-05-25 20:11:36', '2022-05-25 20:11:36', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(903, NULL, 80, 'seed', 'Seed Invoice', NULL, '2022-06-02', '06', '2022', NULL, NULL, NULL, '1', NULL, '40250000.00', 'USD', '2300.00', NULL, 1, 'Sales for Seed Invoice No 1115 to Client XYZ Company', '2022-05-26 15:18:48', '2022-05-26 15:18:48', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, 50);
INSERT INTO `journal_entries` (`id`, `user_id`, `account_id`, `transaction_type`, `name`, `gl_code`, `date`, `month`, `year`, `reference`, `payment_id`, `payment_month`, `income_id`, `debit`, `credit`, `currency_code`, `exchange_rate`, `balance`, `active`, `notes`, `created_at`, `updated_at`, `loan_transaction_id`, `branch_id`, `reconcile`, `transaction_sub_type`, `reversed`, `operator_id`, `center_id`, `client_id`, `added_by`) VALUES
(904, NULL, 4, 'seed', 'Seed Invoice', NULL, '2022-06-02', '06', '2022', NULL, NULL, NULL, '1', '40250000.00', NULL, 'USD', '2300.00', NULL, 1, 'Receivables for Seed Invoice No 1115 to Client XYZ Company', '2022-05-26 15:18:48', '2022-05-26 15:18:48', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, 50),
(905, NULL, 65, 'cotton', 'Cotton Invoice', NULL, '2022-05-26', '05', '2022', NULL, NULL, NULL, '1', NULL, '2440.00', 'TZS', '1.00', NULL, 1, 'Sales for Invoice No 4445 to Client XYZ Company', '2022-05-26 15:37:14', '2022-05-26 15:37:14', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, 50),
(906, NULL, 4, 'cotton', 'Cotton Invoice', NULL, '2022-05-26', '05', '2022', NULL, NULL, NULL, '1', '2440.00', NULL, 'TZS', '1.00', NULL, 1, 'Receivables for Invoice No 4445 to Client XYZ Company', '2022-05-26 15:37:14', '2022-05-26 15:37:14', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, 50),
(907, NULL, 80, 'seed', 'Seed Invoice', NULL, '2022-05-26', '05', '2022', NULL, NULL, NULL, '2', NULL, '7500000.00', 'TZS', '1.00', NULL, 1, 'Sales for Seed Invoice No 45875 to Client XYZ Company', '2022-05-26 17:13:19', '2022-05-26 17:13:19', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, 50),
(908, NULL, 23, 'seed', 'Seed Invoice', NULL, '2022-05-26', '05', '2022', NULL, NULL, NULL, '2', NULL, '1350000.00', 'TZS', '1.00', NULL, 1, 'Sales Tax for Seed Invoice No 45875 to Client XYZ Company', '2022-05-26 17:13:19', '2022-05-26 17:13:19', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, 50),
(909, NULL, 4, 'seed', 'Seed Invoice', NULL, '2022-05-26', '05', '2022', NULL, NULL, NULL, '2', '8850000.00', NULL, 'TZS', '1.00', NULL, 1, 'Receivables for Seed Invoice No 45875 to Client XYZ Company', '2022-05-26 17:13:19', '2022-05-26 17:13:19', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, 50),
(885, NULL, 7, 'operator', 'Reverse Top Up Operator', NULL, '2022-05-17', '05', '2022', NULL, 2, NULL, NULL, '23000.00', NULL, 'TZS', '1.00', NULL, 1, 'Reverse Top Up From Operator Mwakikungu station to Petty Cash', '2022-05-25 23:24:25', '2022-05-25 23:24:25', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(886, NULL, 70, 'operator', 'Reverse Top Up Operator', NULL, '2022-05-17', '05', '2022', NULL, 2, NULL, NULL, NULL, '23000.00', 'TZS', '1.00', NULL, 1, 'Reverse Top Up From Operator Mwakikungu station to Petty Cash', '2022-05-25 23:24:25', '2022-05-25 23:24:25', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL),
(887, NULL, 70, 'operator', 'Top Up Operator', NULL, '2022-05-25', '05', '2022', NULL, 6, NULL, NULL, '50000.00', NULL, 'TZS', '1.00', NULL, 1, 'Top Up From Petty Cash to Operator Test New Operator', '2022-05-26 02:44:32', '2022-05-26 02:44:32', NULL, NULL, 0, NULL, 0, 3, NULL, NULL, NULL),
(888, NULL, 7, 'operator', 'Top Up Operator', NULL, '2022-05-25', '05', '2022', NULL, 6, NULL, NULL, NULL, '50000.00', 'TZS', '1.00', NULL, 1, 'Top Up From Petty Cash to Operator Test New Operator', '2022-05-26 02:44:32', '2022-05-26 02:44:32', NULL, NULL, 0, NULL, 0, 3, NULL, NULL, NULL),
(910, NULL, 65, 'cotton', 'Cotton Invoice', NULL, '2022-05-26', '05', '2022', NULL, NULL, NULL, '2', NULL, '2145900.00', 'USD', '2300.00', NULL, 1, 'Sales for Invoice No LINT 2022/06A to Client XYZ Company', '2022-05-26 17:24:51', '2022-05-26 17:24:51', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, 50),
(911, NULL, 4, 'cotton', 'Cotton Invoice', NULL, '2022-05-26', '05', '2022', NULL, NULL, NULL, '2', '2145900.00', NULL, 'USD', '2300.00', NULL, 1, 'Receivables for Invoice No LINT 2022/06A to Client XYZ Company', '2022-05-26 17:24:51', '2022-05-26 17:24:51', NULL, NULL, 0, NULL, 0, NULL, NULL, 1, 50);

-- --------------------------------------------------------

--
-- Table structure for table `levy`
--

CREATE TABLE `levy` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` int(11) DEFAULT NULL COMMENT '0=optional,1=required',
  `value` decimal(8,2) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `levy`
--

INSERT INTO `levy` (`id`, `name`, `account_id`, `type`, `required`, `value`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'District Levy', '72', 'Rate', 1, '3.00', 50, '2022-05-21 16:01:32', '2022-05-21 16:43:03'),
(2, 'Community Levy', '73', 'Fixed', 1, '50.00', 50, '2022-05-21 16:02:15', '2022-05-21 16:45:36'),
(3, 'TDF', '78', 'Rate', 1, '1.00', 50, '2022-05-21 16:03:28', '2022-05-23 17:33:02'),
(4, 'Union Levy', '79', 'Fixed', 0, '250.00', 50, '2022-05-21 16:04:03', '2022-05-21 17:26:39');

-- --------------------------------------------------------

--
-- Table structure for table `licences`
--

CREATE TABLE `licences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `licences`
--

INSERT INTO `licences` (`id`, `class`, `year`, `expire`, `attachment`, `driver_id`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'C', '2021', '2029', '372050422045427.PNG', '1', 19, '2022-04-05 20:54:27', '2022-04-05 20:54:27'),
(2, 'C', '2022', '2025', '448120422085335.png', '2', 19, '2022-04-12 12:53:35', '2022-04-12 12:53:35');

-- --------------------------------------------------------

--
-- Table structure for table `lime_base`
--

CREATE TABLE `lime_base` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lime_base`
--

INSERT INTO `lime_base` (`id`, `name`, `type`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Test 1', 'Lime', 1, '2022-04-05 16:58:55', '2022-04-05 16:58:55'),
(2, 'B', 'Salt', 1, '2022-04-05 16:59:12', '2022-04-05 16:59:12'),
(3, 'S', 'Salt', 1, '2022-04-05 16:59:30', '2022-04-05 16:59:30'),
(4, 'CaCO3', 'Lime', 20, '2022-05-09 20:18:30', '2022-05-09 20:18:30'),
(5, 'sulhate', 'Salt', 20, '2022-05-11 21:05:52', '2022-05-11 21:05:52');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL COMMENT 'user resposible',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Main Store', 19, '2022-04-05 19:42:12', '2022-04-05 19:42:12'),
(2, 'Zambia', 19, '2022-04-06 13:27:54', '2022-04-06 13:27:54');

-- --------------------------------------------------------

--
-- Table structure for table `maintainances`
--

CREATE TABLE `maintainances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `truck` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `truck_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mechanical` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report` int(200) DEFAULT 0,
  `status` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maintainances`
--

INSERT INTO `maintainances` (`id`, `truck`, `truck_name`, `driver`, `mechanical`, `date`, `type`, `reason`, `report`, `status`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', 'Scania', '1', '1', '2022-04-07', 'Major', 'bbhfb', 1, 1, 19, '2022-04-06 10:24:00', '2022-05-20 12:01:16'),
(2, '1', 'Scania', '', '26', '2022-04-06', 'Minor', 'fff', 0, 0, 1, '2022-04-06 13:29:39', '2022-05-20 00:02:04'),
(3, '1', 'Scania', '1', '1', '2022-04-12', 'Minor', 'errerrert ggh', 1, 1, 19, '2022-04-12 13:08:08', '2022-05-23 21:46:01');

-- --------------------------------------------------------

--
-- Table structure for table `maintainance_report`
--

CREATE TABLE `maintainance_report` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `maintainance_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_no` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maintainance_report`
--

INSERT INTO `maintainance_report` (`id`, `maintainance_id`, `item_name`, `order_no`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', '1', 0, 1, '2022-05-20 12:04:21', '2022-05-20 12:04:21'),
(2, '1', '2', 1, 1, '2022-05-20 12:04:21', '2022-05-20 12:04:21'),
(3, '3', '1', 0, 1, '2022-05-23 21:46:00', '2022-05-23 21:46:00');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturing_inventories`
--

CREATE TABLE `manufacturing_inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_type` int(11) NOT NULL COMMENT '1.Manufacturing\r\n2.Inventory',
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manufacturing_inventories`
--

INSERT INTO `manufacturing_inventories` (`id`, `name`, `product_type`, `unit`, `quantity`, `price`, `added_by`, `created_at`, `updated_at`) VALUES
(3, 'Boxes', 2, 'pc', 0, '120.00', 1, '2022-05-19 13:39:28', '2022-05-19 13:41:04'),
(4, 'Chupa', 2, 'pc', 0, '130.00', 1, '2022-05-19 13:40:11', '2022-05-19 13:41:23'),
(5, 'Diamond 200 mls', 1, 'pc', 0, '2000.00', 1, '2022-05-19 13:43:45', '2022-05-19 13:43:45'),
(6, 'Diamond 200 mls', 1, 'pc', 0, '2000.00', 1, '2022-05-19 13:43:46', '2022-05-19 13:43:46');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturing_inventory_histories`
--

CREATE TABLE `manufacturing_inventory_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `supplier_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manufacturing_inventory_histories`
--

INSERT INTO `manufacturing_inventory_histories` (`id`, `purchase_id`, `items_id`, `quantity`, `supplier_id`, `purchase_date`, `location`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', 1, '3.00', '1', '2022-04-19', '1', 19, '2022-04-25 15:03:31', '2022-04-25 15:03:31'),
(2, '1', 2, '2.00', '1', '2022-04-19', '1', 19, '2022-04-25 15:03:31', '2022-04-25 15:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturing_inventory_list`
--

CREATE TABLE `manufacturing_inventory_list` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `serial_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `truck_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manufacturing_inventory_list`
--

INSERT INTO `manufacturing_inventory_list` (`id`, `serial_no`, `brand_id`, `purchase_id`, `purchase_date`, `location`, `truck_id`, `status`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'filter_1_1_2022', '1', '1', '2022-04-19', '1', '', 0, 19, '2022-04-25 15:03:31', '2022-04-25 15:03:31'),
(2, 'filter_1_2_2022', '1', '1', '2022-04-19', '1', '', 0, 19, '2022-04-25 15:03:31', '2022-04-25 15:03:31'),
(3, 'filter_1_3_2022', '1', '1', '2022-04-19', '1', '', 0, 19, '2022-04-25 15:03:31', '2022-04-25 15:03:31'),
(4, 'pump_1_1_2022', '2', '1', '2022-04-19', '1', '', 0, 19, '2022-04-25 15:03:31', '2022-04-25 15:03:31'),
(5, 'pump_1_2_2022', '2', '1', '2022-04-19', '1', '', 0, 19, '2022-04-25 15:03:31', '2022-04-25 15:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturing_inventory_payments`
--

CREATE TABLE `manufacturing_inventory_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trans_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `date` date NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manufacturing_inventory_payments`
--

INSERT INTO `manufacturing_inventory_payments` (`id`, `purchase_id`, `trans_id`, `amount`, `date`, `payment_method`, `notes`, `account_id`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', 'TRANS_INV-1-9-28/04/22', '204820.00', '2022-04-28', '3', '21ku', '6', 19, '2022-04-29 00:04:22', '2022-04-29 00:04:22');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturing_locations`
--

CREATE TABLE `manufacturing_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manager` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_type` int(11) DEFAULT NULL COMMENT '1-Work Centre\r\n2-Finished Product\r\n3-inventory store',
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manufacturing_locations`
--

INSERT INTO `manufacturing_locations` (`id`, `name`, `manager`, `store_type`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Main Store', 'Ally Mtoni', 1, 1, '2022-04-05 19:42:12', '2022-05-16 17:19:36'),
(2, 'Zambia', 'bakari msheri', 3, 1, '2022-04-06 13:27:54', '2022-05-16 17:19:58'),
(3, 'Production Centre', 'Ally Hamed', 1, 1, '2022-05-19 13:19:57', '2022-05-19 13:19:57'),
(4, 'Finish Good', 'test for test', 2, 1, '2022-05-19 13:21:36', '2022-05-19 13:21:36');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturing_purchase_inventories`
--

CREATE TABLE `manufacturing_purchase_inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `due_date` date NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` decimal(8,2) NOT NULL,
  `purchase_amount` decimal(20,2) NOT NULL,
  `due_amount` decimal(20,2) NOT NULL,
  `purchase_tax` decimal(20,2) NOT NULL,
  `status` int(11) NOT NULL,
  `good_receive` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manufacturing_purchase_inventories`
--

INSERT INTO `manufacturing_purchase_inventories` (`id`, `reference_no`, `supplier_id`, `purchase_date`, `due_date`, `location`, `exchange_code`, `exchange_rate`, `purchase_amount`, `due_amount`, `purchase_tax`, `status`, `good_receive`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'PUR_INV-1-2022-04-19', '1', '2022-04-19', '2022-04-26', '1', 'TZS', '1.00', '199000.00', '30000.00', '35820.00', 2, '1', 19, '2022-04-25 15:02:21', '2022-04-29 00:04:22'),
(2, 'PUR_INV-2-2022-05-10', '1', '2022-05-10', '2022-05-15', '1', 'TZS', '1.00', '555000.00', '654900.00', '99900.00', 1, '0', 44, '2022-05-10 16:38:17', '2022-05-10 16:40:34');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturing_purchase_item_inventories`
--

CREATE TABLE `manufacturing_purchase_item_inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_rate` decimal(8,2) NOT NULL,
  `total_tax` decimal(8,2) NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `total_cost` decimal(8,2) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL,
  `order_no` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manufacturing_purchase_item_inventories`
--

INSERT INTO `manufacturing_purchase_item_inventories` (`id`, `purchase_id`, `item_name`, `tax_rate`, `total_tax`, `quantity`, `total_cost`, `price`, `unit`, `items_id`, `order_no`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', '1', '0.18', '12420.00', '3.00', '69000.00', '23000.00', 'pc', 1, 0, 19, '2022-04-25 15:02:21', '2022-04-25 15:03:31'),
(2, '1', '2', '0.18', '23400.00', '2.00', '130000.00', '65000.00', 'PC', 2, 1, 19, '2022-04-25 15:02:21', '2022-04-25 15:03:31'),
(3, '2', '1', '0.18', '41400.00', '10.00', '230000.00', '23000.00', 'pc', 1, 0, 44, '2022-05-10 16:38:17', '2022-05-10 16:38:17'),
(4, '2', '2', '0.18', '58500.00', '5.00', '325000.00', '65000.00', 'PC', 2, 1, 44, '2022-05-10 16:38:17', '2022-05-10 16:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `medicine_category`
--

CREATE TABLE `medicine_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_client`
--

CREATE TABLE `medicine_client` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TIN` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_history`
--

CREATE TABLE `medicine_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items_id` int(110) NOT NULL,
  `purchase_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_qty` decimal(8,2) DEFAULT NULL,
  `supplier_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_id` int(200) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `client_id` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sales_qty` decimal(20,2) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_invoice`
--

CREATE TABLE `medicine_invoice` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `due_date` date NOT NULL,
  `exchange_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` decimal(8,2) NOT NULL,
  `purchase_amount` decimal(20,2) NOT NULL,
  `due_amount` decimal(20,2) NOT NULL,
  `purchase_tax` decimal(20,2) NOT NULL,
  `status` int(11) NOT NULL,
  `good_receive` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_invoice_item`
--

CREATE TABLE `medicine_invoice_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch_no` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire_date` date NOT NULL,
  `tax_rate` decimal(8,2) NOT NULL,
  `total_tax` decimal(8,2) NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `total_cost` decimal(8,2) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_no` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_list`
--

CREATE TABLE `medicine_list` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_location`
--

CREATE TABLE `medicine_location` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL COMMENT 'user resposible',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_sales_payments`
--

CREATE TABLE `medicine_sales_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trans_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `date` date NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_stock`
--

CREATE TABLE `medicine_stock` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `batch_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` decimal(20,2) NOT NULL,
  `due_qty` decimal(20,2) NOT NULL,
  `purchase_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) DEFAULT 0 COMMENT '0=available,1=sold',
  `expire_date` date NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_supplier`
--

CREATE TABLE `medicine_supplier` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TIN` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_10_05_104512_create_zones_table', 12),
(28, '2014_10_12_000000_create_users_table', 1),
(29, '2014_10_12_100000_create_password_resets_table', 1),
(30, '2019_08_19_000000_create_failed_jobs_table', 1),
(32, '2022_01_19_135551_create_posts_table', 1),
(33, '2022_01_26_135448_create_farmers_table', 1),
(34, '2022_01_28_090429_create_groups_table', 1),
(35, '2022_01_28_131303_create_gmembers_table', 1),
(36, '2022_02_01_111711_create_farm_lands_table', 2),
(37, '2022_02_04_093118_create_contacts_table', 3),
(38, '2022_02_04_102442_create_mawasilianos_table', 4),
(39, '2022_02_07_112802_create_supplies_table', 5),
(40, '2022_02_07_150910_create_products_table', 6),
(41, '2022_02_08_081648_create_units_table', 7),
(43, '2022_02_10_115932_create_groceries_table', 8),
(45, '2022_02_15_150412_create_balances_table', 10),
(46, '2022_02_18_084001_create_sales_table', 11),
(47, '2019_10_05_104513_create_regions_table', 13),
(48, '2019_10_05_104514_create_districts_table', 13),
(49, '2019_12_14_000001_create_personal_access_tokens_table', 13),
(50, '2022_01_08_063104_create_countries_table', 13),
(51, '2022_02_14_112453_create_orders_table', 13),
(52, '2022_02_26_092502_create_purchases_table', 13),
(53, '2022_02_26_093337_create_purchase_items_table', 13),
(54, '2022_02_27_054315_create_sales_table', 13),
(55, '2022_02_27_054457_create_sales_items_table', 13),
(56, '2022_02_27_161836_create_invoice_payments_table', 13),
(57, '2022_02_28_145220_create_transport_quotations_table', 13),
(58, '2022_02_28_150818_create_quotation_costs_table', 13),
(59, '2022_02_28_151527_create_cost_functions_table', 13),
(60, '2022_03_04_075256_create_seassons_table', 14),
(61, '2022_03_04_114306_create_preparation_costs_table', 14),
(62, '2022_03_07_083738_create_preparation_details_table', 14),
(63, '2022_03_07_083930_create_preparation_cost_lists_table', 14),
(64, '2022_03_11_105622_create_seeds_types_table', 15),
(65, '2022_03_11_125025_create_sowings_table', 15),
(66, '2022_03_15_100149_create_trucks_table', 15),
(67, '2022_03_15_110512_create_drivers_table', 15),
(68, '2022_03_15_114158_create_user_details_table', 15),
(69, '2022_03_15_185405_create_licences_table', 15),
(70, '2022_03_15_185507_create_performances_table', 15),
(71, '2022_03_15_194201_add_driver_to_licences_table', 15),
(72, '2022_03_15_194328_add_driver_to_performances_table', 15),
(73, '2022_03_16_170425_create_stickers_table', 15),
(74, '2022_03_16_170654_create_truck_insurances_table', 15),
(75, '2022_03_17_093853_create_locations_table', 15),
(76, '2022_03_17_094205_create_inventories_table', 15),
(77, '2022_03_17_094242_create_field_staff_table', 15),
(78, '2022_03_17_094405_create_purchase_inventories_table', 15),
(79, '2022_03_17_094438_create_purchase_item_inventories_table', 15),
(80, '2022_03_17_094750_create_inventory_histories_table', 15),
(81, '2022_03_17_124418_create_fertilers_table', 15),
(82, '2022_03_17_124927_create_inventory_payments_table', 15),
(83, '2022_03_18_190421_create_maintainances_table', 15),
(84, '2022_03_18_191433_create_services_table', 15),
(85, '2022_03_18_191526_create_service_items_table', 15),
(86, '2022_03_19_181447_create_good_issue_items_table', 15),
(87, '2022_03_19_181624_create_good_issues_table', 15),
(88, '2022_03_20_040925_create_good_returns_table', 15),
(89, '2022_03_20_041049_create_good_return_items_table', 15),
(90, '2022_03_20_050647_create_irrigation_settings_table', 15),
(91, '2022_03_20_071343_create_good_movements_table', 15),
(92, '2022_03_20_071446_create_good_reallocations_table', 15),
(93, '2022_03_20_071528_create_good_disposals_table', 15),
(94, '2022_03_21_101055_create_irrigation_systems_table', 15),
(95, '2022_03_21_122145_create_irrigation_processes_table', 15),
(96, '2022_03_21_131947_create_order_payments_table', 15),
(97, '2022_03_21_132440_create_order_movements_table', 15),
(98, '2022_03_21_132728_create_activities_table', 15),
(99, '2022_03_24_150209_create_pestisides_table', 16),
(100, '2022_03_24_155930_create_pre_harvests_table', 17),
(101, '2022_03_24_163417_create_post_harvests_table', 18),
(102, '2022_03_24_170142_create_parking_types_table', 19),
(103, '2022_03_25_075919_create_fuels_table', 20),
(104, '2022_03_25_081003_create_refills_table', 21),
(105, '2022_03_25_081044_create_routes_table', 22),
(106, '2022_03_29_122838_create_tyre_brands_table', 23),
(107, '2022_03_29_163730_create_purchase_tyres_table', 24),
(108, '2022_03_29_164041_create_purchase_item_tyres_table', 25),
(109, '2022_03_29_164434_create_tyre_histories_table', 26),
(110, '2022_03_29_164644_create_tyre_activities_table', 27),
(111, '2022_03_29_181545_create_tyre_payments_table', 28),
(112, '2022_03_30_130131_create_tyre_disposals_table', 28),
(113, '2022_03_31_062131_create_tyres_table', 29),
(114, '2022_03_31_094617_create_tyre_returns_table', 29),
(115, '2022_03_31_124505_create_tyre_reallocations_table', 29),
(116, '2022_03_31_164525_create_pacels_table', 30),
(117, '2022_03_31_175801_create_pacel_items_table', 31),
(118, '2022_03_31_180421_create_pacel_payments_table', 32),
(119, '2022_03_31_181128_create_pacel_lists_table', 33),
(120, '2022_04_15_103020_create_salary_templates_table', 34),
(121, '2022_04_15_104129_create_salary_allowances_table', 34),
(122, '2022_04_15_104435_create_salary_deductions_table', 34),
(125, '2022_04_17_081429_create_departments_table', 35),
(126, '2022_04_23_112045_create_employee_payrolls_table', 35),
(127, '2022_04_25_094322_create_salary_payments_table', 36),
(128, '2022_04_25_095012_create_salary_payment_details_table', 36),
(129, '2022_04_25_113634_create_salary_payment_allowances_table', 37),
(131, '2022_04_25_114455_create_salary_payment_deductions_table', 38),
(132, '2022_04_27_090812_create_advance_salaries_table', 39),
(133, '2022_04_27_102406_create_overtimes_table', 40),
(134, '2022_04_27_103519_create_payment_methodes_table', 41),
(135, '2022_04_27_105215_create_accounts_table', 42);

-- --------------------------------------------------------

--
-- Table structure for table `mileages`
--

CREATE TABLE `mileages` (
  `id` int(200) NOT NULL,
  `truck_id` varchar(200) NOT NULL,
  `driver_id` varchar(191) NOT NULL,
  `route_id` varchar(200) NOT NULL,
  `fuel_rate` decimal(20,2) NOT NULL,
  `total_mileage` decimal(20,2) NOT NULL,
  `due_mileage` decimal(20,2) NOT NULL,
  `fuel_adjustment` decimal(20,2) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `payment_status` int(200) NOT NULL,
  `status_approve` int(200) NOT NULL,
  `approved_by` int(100) DEFAULT NULL,
  `movement_id` int(200) DEFAULT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mileages`
--

INSERT INTO `mileages` (`id`, `truck_id`, `driver_id`, `route_id`, `fuel_rate`, `total_mileage`, `due_mileage`, `fuel_adjustment`, `reason`, `payment_status`, `status_approve`, `approved_by`, `movement_id`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '3', '2', '4', '6000.00', '2595000.00', '2595000.00', NULL, NULL, 0, 0, NULL, 1, 19, '2022-04-24 02:24:15', '2022-04-24 02:24:15'),
(2, '2', '1', '4', '5500.00', '2595000.00', '2595000.00', '210250.00', 'test', 0, 1, 19, 3, 19, '2022-04-24 02:25:20', '2022-04-24 02:37:24'),
(4, '3', '2', '5', '3000.00', '249000.00', '249000.00', NULL, NULL, 0, 0, NULL, NULL, 19, '2022-04-25 14:14:14', '2022-04-25 14:14:14'),
(6, '7', '3', '7', '100.00', '102100.00', '102100.00', NULL, NULL, 0, 0, NULL, NULL, 19, '2022-04-28 23:07:01', '2022-04-28 23:07:01'),
(7, '6', '2', '3', '110.00', '68673.00', '68673.00', NULL, NULL, 0, 0, NULL, 4, 19, '2022-04-28 23:14:42', '2022-04-28 23:14:42'),
(8, '7', '1', '6', '110.00', '85800.00', '85800.00', NULL, NULL, 0, 0, NULL, 5, 19, '2022-04-28 23:15:14', '2022-04-28 23:15:14'),
(9, '6', '1', '8', '100.00', '62400.00', '-62400.00', NULL, NULL, 1, 0, NULL, NULL, 19, '2022-04-28 23:20:06', '2022-04-29 00:00:08'),
(10, '9', '1', '10', '100.00', '40000.00', '0.00', NULL, NULL, 2, 0, NULL, NULL, 53, '2022-05-17 14:38:08', '2022-05-17 15:10:36'),
(11, '9', '2', '7', '100.00', '102100.00', '102100.00', NULL, NULL, 0, 0, NULL, 6, 53, '2022-05-17 15:27:51', '2022-05-17 15:27:51'),
(12, '8', '3', '11', '75.00', '51525.00', '26525.00', NULL, NULL, 1, 0, NULL, 8, 1, '2022-05-20 22:51:16', '2022-05-21 23:53:32'),
(13, '5', '4', '11', '75.00', '51525.00', '51525.00', NULL, NULL, 0, 0, NULL, 9, 1, '2022-05-20 22:57:31', '2022-05-20 22:57:31');

-- --------------------------------------------------------

--
-- Table structure for table `millage_payments`
--

CREATE TABLE `millage_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mileage_id` int(200) NOT NULL,
  `movement_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trans_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `date` date NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` int(200) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `millage_payments`
--

INSERT INTO `millage_payments` (`id`, `mileage_id`, `movement_id`, `trans_id`, `amount`, `date`, `payment_method`, `notes`, `account_id`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 12, '8', 'TRANS_MLG-12-9-21/05/22', '25000.00', '2022-05-21', '2', NULL, 7, 1, '2022-05-21 23:53:32', '2022-05-21 23:53:32');

-- --------------------------------------------------------

--
-- Table structure for table `operators`
--

CREATE TABLE `operators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TIN` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_codes` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `operators`
--

INSERT INTO `operators` (`id`, `user_id`, `name`, `address`, `phone`, `email`, `TIN`, `account_codes`, `created_at`, `updated_at`) VALUES
(1, '50', 'Mwakikungu station', 'tell', '0712722682', 'mwaki@tena.co.tz', '152', NULL, '2022-05-16 16:43:32', '2022-05-16 16:43:32'),
(2, '50', 'Nicco Kowero', '707 masa', '+25576658949', 'nicco@gmail.com', NULL, NULL, '2022-05-17 12:19:30', '2022-05-17 12:19:30'),
(3, '50', 'Test New Operator', 'test', '255', 'admin@gmail.com', NULL, NULL, '2022-05-17 15:57:25', '2022-05-17 15:57:25');

-- --------------------------------------------------------

--
-- Table structure for table `order_movements`
--

CREATE TABLE `order_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_id` int(11) NOT NULL,
  `module` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `crop_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `amount` decimal(20,2) NOT NULL,
  `due_amount` decimal(20,2) NOT NULL,
  `tax` decimal(20,2) NOT NULL,
  `status` int(11) NOT NULL,
  `truck` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_date` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `fuel` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_payments`
--

CREATE TABLE `order_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transport_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trans_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `date` date NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pacels`
--

CREATE TABLE `pacels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pacel_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pacel_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `due_date` date NOT NULL,
  `owner_id` int(11) NOT NULL,
  `confirmation_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` decimal(20,2) NOT NULL,
  `route_id` int(100) NOT NULL,
  `receiver_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `docs` int(100) DEFAULT 0,
  `non_docs` int(100) DEFAULT 0,
  `bags` int(100) DEFAULT 0,
  `mobile` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exchange_rate` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `tax` decimal(20,2) DEFAULT NULL,
  `due_amount` decimal(20,2) DEFAULT NULL,
  `discount` decimal(20,2) DEFAULT 0.00,
  `instructions` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `good_receive` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pacels`
--

INSERT INTO `pacels` (`id`, `pacel_name`, `pacel_number`, `date`, `due_date`, `owner_id`, `confirmation_number`, `weight`, `route_id`, `receiver_name`, `docs`, `non_docs`, `bags`, `mobile`, `currency_code`, `exchange_rate`, `amount`, `tax`, `due_amount`, `discount`, `instructions`, `good_receive`, `status`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Construction Cargo', 'PCL-1', '2022-04-23', '2022-04-30', 4, 'PCL-Y1Lr1', '200.00', 4, 'Anna', 0, 5, 0, '+255714456789', 'TZS', '1.00', '81620.00', '12420.00', '71620.00', '0.00', 'Anna will receive the package', '1', '1', 19, '2022-04-23 18:19:11', '2022-05-22 15:35:08'),
(2, 'Transportation of Cargo- 2', 'PCL-2', '2022-04-24', '2022-04-30', 1, 'PCL-5jQz2', '60000.00', 3, 'Hamis Lines Limited', 0, 2, 0, '07127223456', 'TZS', '1.00', '5900000.00', '900000.00', '5400000.00', '0.00', NULL, '1', '1', 1, '2022-04-24 15:26:26', '2022-04-28 21:39:35'),
(3, 'Transport of CaCo3 from msata to Njombe', 'PCL-3', '2022-04-26', '2022-04-28', 4, 'PCL-zydo3', '120000.00', 6, 'Jefag LTD', 0, 4, 0, '07127223456', 'TZS', '1.00', '13794955.20', '2104315.20', '13794955.20', '0.00', 'gggg', '1', '0', 19, '2022-04-26 18:30:28', '2022-04-28 22:42:33'),
(4, 'XTEW SHING TO SINGIDA', 'PCL-4', '2022-05-17', '2022-05-23', 1, 'PCL-kWZn4', '300000.00', 7, '-', 0, 10, 0, '-', 'TZS', '1.00', '3658000.00', '558000.00', '3658000.00', '0.00', 'GGHGHG', '1', '0', 53, '2022-05-17 14:23:49', '2022-05-17 14:25:10'),
(5, 'test movements of cargo', 'PCL-5', '2022-05-19', '2022-05-19', 1, 'PCL-XfJ15', '300000.00', 8, '-', 0, 0, 0, '-', 'TZS', '1.00', '1593000.00', '243000.00', '1593000.00', '0.00', '-', '1', '0', 53, '2022-05-19 13:02:59', '2022-05-19 13:06:34'),
(6, 'test movements of cargo GAKI', 'PCL-6', '2022-05-20', '2022-05-21', 2, 'PCL-MvFg6', '90000.00', 5, '-', 0, 0, 0, '-', 'TZS', '1.00', '4779000.00', '729000.00', '4779000.00', '0.00', 'test instruction', '0', '0', 53, '2022-05-20 20:09:35', '2022-05-20 20:09:35'),
(8, 'test shipment', 'PCL-8', '2022-05-18', '2022-05-19', 3, 'PCL-EgJ18', '5000.00', 11, 'john', 0, 20, 0, '+255788016969', 'TZS', '1.00', '1416.00', '216.00', '716.00', '0.00', NULL, '1', '1', 1, '2022-05-20 21:16:27', '2022-05-21 23:20:32'),
(9, 'mwanza shipment', 'PCL-9', '2022-05-23', '2022-05-27', 4, 'PCL-VKDx9', '200.00', 12, 'asha', 0, 10, 0, '+255655123456', 'TZS', '1.00', '271400.00', '41400.00', '271400.00', '0.00', NULL, '0', '0', 1, '2022-05-23 22:57:46', '2022-05-23 22:57:46');

-- --------------------------------------------------------

--
-- Table structure for table `pacel_items`
--

CREATE TABLE `pacel_items` (
  `id` int(11) NOT NULL,
  `pacel_id` int(11) NOT NULL,
  `tax_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_tax` decimal(20,2) NOT NULL DEFAULT 0.00,
  `quantity` decimal(10,2) DEFAULT 0.00,
  `total_cost` decimal(20,2) NOT NULL DEFAULT 0.00,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `unit` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL DEFAULT 0,
  `order_no` int(11) DEFAULT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pacel_items`
--

INSERT INTO `pacel_items` (`id`, `pacel_id`, `tax_rate`, `total_tax`, `quantity`, `total_cost`, `item_name`, `price`, `unit`, `items_id`, `order_no`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 1, '0.18', '12420.00', '3.00', '69000.00', '4', '23000.00', 'km', 4, 0, 19, '2022-04-23 18:19:11', '2022-04-23 18:19:11'),
(2, 1, '0.00', '0.00', '2.00', '200.00', '1', '100.00', 'Bulk', 1, 1, 19, '2022-04-23 18:19:11', '2022-04-23 18:19:11'),
(3, 2, '0.18', '900000.00', '50000.00', '5000000.00', '1', '100.00', 'Bulk', 1, 0, 1, '2022-04-24 15:26:26', '2022-04-24 15:26:26'),
(4, 3, '0.18', '2104315.20', '3120.00', '11690640.00', '1', '3747.00', 'Bulk', 1, 0, 19, '2022-04-26 18:30:28', '2022-04-28 22:42:16'),
(5, 4, '0.18', '540000.00', '30.00', '3000000.00', '1', '100000.00', 'Bulk', 1, 0, 53, '2022-05-17 14:23:49', '2022-05-17 14:23:49'),
(6, 4, '0.18', '18000.00', '1.00', '100000.00', '2', '100000.00', 'PC', 2, 1, 53, '2022-05-17 14:23:49', '2022-05-17 14:23:49'),
(7, 5, '0.18', '243000.00', '10.00', '1350000.00', '1', '135000.00', 'Bulk', 1, 0, 53, '2022-05-19 13:02:59', '2022-05-19 13:02:59'),
(8, 6, '0.18', '729000.00', '3.00', '4050000.00', '1', '1350000.00', 'Bulk', 1, 0, 53, '2022-05-20 20:09:35', '2022-05-20 20:09:35'),
(11, 8, '0.18', '180.00', '10.00', '1000.00', '2', '100.00', 'PC', 2, 0, 1, '2022-05-20 21:16:27', '2022-05-20 21:16:27'),
(12, 8, '0.18', '36.00', '10.00', '200.00', '3', '20.00', 'pc', 3, 1, 1, '2022-05-20 21:16:27', '2022-05-20 21:16:27'),
(13, 9, '0.18', '41400.00', '10.00', '230000.00', '4', '23000.00', 'kgs', 4, 0, 1, '2022-05-23 22:57:46', '2022-05-23 22:57:46');

-- --------------------------------------------------------

--
-- Table structure for table `pacel_lists`
--

CREATE TABLE `pacel_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `unit` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(200) DEFAULT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pacel_lists`
--

INSERT INTO `pacel_lists` (`id`, `name`, `price`, `unit`, `quantity`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Loose Cargo', '100.00', 'Bulk', NULL, 1, '2022-04-06 08:49:51', '2022-05-24 16:04:14'),
(2, 'Container 40ft', '100.00', 'PC', NULL, 19, '2022-04-06 09:37:17', '2022-04-06 09:37:17'),
(3, 'Conterner 20ft', '20.00', 'pc', NULL, 19, '2022-04-06 12:55:44', '2022-04-06 12:55:44'),
(4, 'Cements', '23000.00', 'kg', NULL, 1, '2022-04-12 12:35:33', '2022-05-24 15:37:27'),
(5, 'Computers', '500000.00', 'tons', NULL, 1, '2022-05-24 16:00:38', '2022-05-24 16:00:38');

-- --------------------------------------------------------

--
-- Table structure for table `pacel_payments`
--

CREATE TABLE `pacel_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pacel_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trans_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `date` date NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` int(200) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pacel_payments`
--

INSERT INTO `pacel_payments` (`id`, `pacel_id`, `trans_id`, `amount`, `date`, `payment_method`, `notes`, `account_id`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '2', 'TRANS_PCL_2_jpyG', '500000.00', '2022-04-28', '1', 'jkj', 6, 19, '2022-04-28 21:39:35', '2022-04-28 21:39:35'),
(2, '8', 'TRANS_PCL_8_lL14', '700.00', '2022-05-21', '1', NULL, 29, 1, '2022-05-21 23:18:35', '2022-05-21 23:20:32'),
(4, '1', 'TRANS_PCL_1_uxce', '10000.00', '2022-05-22', '1', NULL, 29, 1, '2022-05-22 15:35:08', '2022-05-22 15:35:08');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(100) NOT NULL,
  `payment_methode_id` int(100) NOT NULL,
  `trans_id` varchar(100) NOT NULL,
  `supplier_id` int(100) DEFAULT NULL,
  `client_id` int(100) DEFAULT NULL,
  `amount` int(100) NOT NULL,
  `due_amount` int(100) NOT NULL,
  `notes` varchar(100) NOT NULL,
  `purchase_id` int(100) NOT NULL,
  `invoice_id` int(100) DEFAULT NULL,
  `date` date NOT NULL,
  `updated_at` date DEFAULT current_timestamp(),
  `created_at` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `payment_methode_id`, `trans_id`, `supplier_id`, `client_id`, `amount`, `due_amount`, `notes`, `purchase_id`, `invoice_id`, `date`, `updated_at`, `created_at`) VALUES
(1, 2, 'TRANS-53-01/02/22', 1, NULL, 10000, 990043, '43', 53, NULL, '2022-02-02', '2022-02-01', '2022-02-01'),
(2, 1, 'TRANS-56-02/02/22', 9, NULL, 81600, 0, '0', 56, NULL, '2022-02-03', '2022-02-02', '2022-02-02'),
(3, 1, 'TRANS-58-04/02/22', 11, NULL, 600000, 9000000, 'hello thanks for payments', 58, NULL, '2022-02-04', '2022-02-04', '2022-02-04'),
(4, 1, 'TRANS-58-04/02/22', 11, NULL, 9000000, 600000, '600000', 58, NULL, '2022-02-03', '2022-02-04', '2022-02-04'),
(5, 3, 'TRANS-64-04/02/22', 8, NULL, 400000, 450000, 'test', 64, NULL, '2022-02-05', '2022-02-04', '2022-02-04'),
(6, 1, 'TRANS-61-04/02/22', 6, NULL, 200000, 47800000, '0', 61, NULL, '2022-02-05', '2022-02-04', '2022-02-04'),
(7, 1, 'TRANS-20-26/02/22', NULL, NULL, 50000, 2000000, '-2050000', 20, NULL, '2022-02-26', '2022-02-26', '2022-02-26'),
(8, 1, 'TRANS-21-26/02/22', NULL, NULL, 50000, 2000000, '-2050000', 21, NULL, '2022-02-25', '2022-02-26', '2022-02-26'),
(9, 1, 'TRANS-23-26/02/22', NULL, NULL, 150000, 1900000, '-2050000', 23, NULL, '2022-02-25', '2022-02-26', '2022-02-26');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methodes`
--

CREATE TABLE `payment_methodes` (
  `id` int(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_methodes`
--

INSERT INTO `payment_methodes` (`id`, `name`, `description`) VALUES
(1, 'Mobile Money', NULL),
(2, 'Cash', NULL),
(3, 'Bank', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `performances`
--

CREATE TABLE `performances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `issue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `explanation` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `effect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sys_module_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `slug`, `sys_module_id`, `created_at`, `updated_at`) VALUES
(1, 'view-dashboard', 1, '2022-05-14 13:05:20', '2022-06-01 17:11:03'),
(2, 'edit-dashboard', 1, '2022-05-14 13:05:20', '2022-06-01 17:11:03'),
(3, 'delete-dashboard', 1, '2022-05-14 13:05:20', '2022-06-01 17:11:03'),
(4, 'add-dashboard', 1, '2022-05-14 13:05:20', '2022-06-01 17:11:03'),
(5, 'view-farmer', 2, '2022-05-14 13:05:20', '2022-05-25 16:06:50'),
(6, 'edit-farmer', 2, '2022-05-14 13:05:20', '2022-05-25 16:06:50'),
(7, 'delete-farmer', 2, '2022-05-14 13:05:20', '2022-05-25 16:06:50'),
(8, 'add-farmer', 2, '2022-05-14 13:05:20', '2022-05-25 16:06:50'),
(9, 'confirm-farmer', 2, '2022-05-14 13:05:20', '2022-05-25 16:06:50'),
(10, 'view-group', 2, '2022-05-14 13:05:20', '2022-05-25 16:06:50'),
(11, 'edit-group', 2, '2022-05-14 13:05:20', '2022-05-25 16:06:50'),
(12, 'delete-group', 2, '2022-05-14 13:05:20', '2022-05-25 16:06:50'),
(13, 'add-group', 2, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(14, 'confirm-group', 2, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(15, 'view-farmer-assets', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(16, 'edit-farmer-assets', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(17, 'delete-farmer-assets', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(18, 'add-farmer-assets', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(19, 'view-farming-cost', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(20, 'edit-farming-cost', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(21, 'delete-farming-cost', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(22, 'add-farming-cost', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(23, 'view-cost-centre', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(24, 'edit-cost-centre', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(25, 'delete-cost-centre', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(26, 'add-cost-centre', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(27, 'view-farming-process', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(28, 'edit-farming-process', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(29, 'delete-farming-process', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(30, 'add-farming-process', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(31, 'view-crop-monitoring', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(32, 'edit-crop-monitoring', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(33, 'delete-crop-monitoring', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(34, 'add-crop-monitoring', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(35, 'view-manage_seasson', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(36, 'edit-manage_seasson', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(37, 'delete-manage_seasson', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(38, 'add-manage_seasson', 3, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(39, 'view-order_list', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(40, 'edit-order_list', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(41, 'delete-order_list', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(42, 'add-order_list', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(43, 'view-quotation-list', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(44, 'edit-quotation-list', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(45, 'delete-quotation-list', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(46, 'add-quotation-list', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(47, 'view-cargo-list', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(48, 'edit-cargo-list', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(49, 'delete-cargo-list', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(50, 'add-cargo-list', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(51, 'view-cargo-client-list', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(52, 'edit-cargo-client-list', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(53, 'delete-cargo-client-list', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(54, 'add-cargo-client-list', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(55, 'view-cargo-quotation', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(56, 'edit-cargo-quotation', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(57, 'delete-cargo-quotation', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(58, 'add-cargo-quotation', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(59, 'view-cargo-invoice', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(60, 'edit-cargo-invoice', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(61, 'delete-cargo-invoice', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(62, 'add-cargo-invoice', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(63, 'view-cargo-mileage', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(64, 'edit-cargo-mileage', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(65, 'delete-cargo-mileage', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(66, 'add-cargo-mileage', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(67, 'view-cargo-collection', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(68, 'edit-cargo-collection', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(69, 'delete-cargo-collection', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(70, 'add-cargo-collection', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(71, 'view-cargo-loading', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(72, 'edit-cargo-loading', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(73, 'delete-cargo-loading', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(74, 'add-cargo-loading', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(75, 'view-cargo-offloading', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(76, 'edit-cargo-offloading', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(77, 'delete-cargo-offloading', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(78, 'add-cargo-offloading', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(79, 'view-cargo-delivering', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(80, 'edit-cargo-delivering', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(81, 'delete-cargo-delivering', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(82, 'add-cargo-delivering', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(83, 'view-cargo-activity', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(84, 'edit-cargo-activity', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(85, 'delete-cargo-activity', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(86, 'add-cargo-activity', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(87, 'view-cargo-order_report', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(88, 'edit-cargo-order_report', 4, '2022-05-14 13:05:21', '2022-05-23 22:49:33'),
(89, 'delete-cargo-order_report', 4, '2022-05-14 13:05:21', '2022-05-23 22:49:33'),
(90, 'add-cargo-order_report', 4, '2022-05-14 13:05:21', '2022-05-23 22:49:33'),
(91, 'view-cargo-truck_mileage', 4, '2022-05-14 13:05:21', '2022-06-01 17:11:03'),
(92, 'edit-cargo-truck_mileage', 4, '2022-05-14 13:05:21', '2022-05-23 22:49:33'),
(93, 'delete-cargo-truck_mileage', 4, '2022-05-14 13:05:21', '2022-05-23 22:49:33'),
(94, 'add-cargo-truck_mileage', 4, '2022-05-14 13:05:21', '2022-05-23 22:49:33'),
(95, 'view-warehouse', 5, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(96, 'edit-warehouse', 5, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(97, 'delete-warehouse', 5, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(98, 'add-warehouse', 5, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(99, 'view-supplier', 6, '2022-05-14 13:05:21', '2022-05-25 16:06:50'),
(100, 'edit-supplier', 6, '2022-05-14 13:05:21', '2022-05-14 13:05:21'),
(101, 'delete-supplier', 6, '2022-05-14 13:05:22', '2022-05-14 13:05:22'),
(102, 'add-supplier', 6, '2022-05-14 13:05:22', '2022-05-14 13:05:22'),
(103, 'view-product', 6, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(104, 'edit-product', 6, '2022-05-14 13:05:22', '2022-05-14 13:05:22'),
(105, 'delete-product', 6, '2022-05-14 13:05:22', '2022-05-14 13:05:22'),
(106, 'add-product', 6, '2022-05-14 13:05:22', '2022-05-14 13:05:22'),
(107, 'view-purchase', 6, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(108, 'edit-purchase', 6, '2022-05-14 13:05:22', '2022-05-14 13:05:22'),
(109, 'delete-purchase', 6, '2022-05-14 13:05:22', '2022-05-14 13:05:22'),
(110, 'add-purchase', 6, '2022-05-14 13:05:22', '2022-05-14 13:05:22'),
(111, 'view-sales', 6, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(112, 'edit-sales', 6, '2022-05-14 13:05:22', '2022-05-14 13:05:22'),
(113, 'delete-sales', 6, '2022-05-14 13:05:22', '2022-05-14 13:05:22'),
(114, 'add-sales', 6, '2022-05-14 13:05:22', '2022-05-14 13:05:22'),
(115, 'view-roles', 7, '2022-05-14 13:05:22', '2022-06-01 17:11:03'),
(116, 'add-roles', 7, '2022-05-14 13:05:22', '2022-05-23 22:49:33'),
(117, 'edit-roles', 7, '2022-05-14 13:05:22', '2022-05-23 22:49:33'),
(118, 'delete-roles', 7, '2022-05-14 13:05:22', '2022-05-23 22:49:33'),
(119, 'view-permission', 7, '2022-05-14 13:05:22', '2022-06-01 17:11:03'),
(120, 'add-permission', 7, '2022-05-14 13:05:22', '2022-05-23 22:49:33'),
(121, 'edit-permission', 7, '2022-05-14 13:05:22', '2022-05-23 22:49:33'),
(122, 'delete-permission', 7, '2022-05-14 13:05:22', '2022-05-23 22:49:33'),
(123, 'view-user', 7, '2022-05-14 13:05:22', '2022-06-01 17:11:03'),
(124, 'add-user', 7, '2022-05-14 13:05:22', '2022-05-23 22:49:33'),
(125, 'edit-user', 7, '2022-05-14 13:05:22', '2022-05-23 22:49:33'),
(126, 'delete-user', 7, '2022-05-14 13:05:22', '2022-05-23 22:49:33'),
(127, 'view-dashboard', 7, '2022-05-14 13:05:22', '2022-06-01 17:11:03'),
(128, 'view-courier_list', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(129, 'add-courier_list', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(130, 'edit-courier_list', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(131, 'delete-courier_list', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(132, 'view-courier_quotation', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(133, 'add-courier_quotation', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(134, 'edit-courier_quotation', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(135, 'delete-courier_quotation', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(136, 'view-courier_invoice', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(137, 'add-courier_invoice', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(138, 'edit-courier_invoice', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(139, 'delete-courier_invoice', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(140, 'view-courier_collection', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(141, 'add-courier_collection', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(142, 'edit-courier_collection', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(143, 'delete-courier_collection', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(144, 'view-courier_loading', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(145, 'add-courier_loading', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(146, 'edit-courier_loading', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(147, 'delete-courier_loading', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(148, 'view-courier_offloading', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(149, 'add-courier_offloading', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(150, 'edit-courier_offloading', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(151, 'delete-courier_offloading', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(152, 'view-courier_delivering', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(153, 'add-courier_delivering', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(154, 'edit-courier_delivering', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(155, 'delete-courier_delivering', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(156, 'view-courier_activity', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(157, 'add-courier_activity', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(158, 'edit-courier_activity', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(159, 'delete-courier_activity', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(160, 'view-courier_report', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(161, 'add-courier_report', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(162, 'edit-courier_report', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(163, 'delete-courier_report', 17, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(164, 'view-salary_template', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(165, 'add-salary_template', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(166, 'edit-salary_template', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(167, 'delete-salary_template', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(168, 'view-manage_salary', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(169, 'add-manage_salary', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(170, 'edit-manage_salary', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(171, 'delete-manage_salary', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(172, 'view-employee_salary_list', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(173, 'add-employee_salary_list', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(174, 'edit-employee_salary_list', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(175, 'delete-employee_salary_list', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(176, 'view-make_payment', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(177, 'add-make_payment', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(178, 'edit-make_payment', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(179, 'delete-make_payment', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(180, 'view-generate_payslip', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(181, 'add-generate_payslip', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(182, 'edit-generate_payslip', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(183, 'delete-generate_payslip', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(184, 'view-payroll_summary', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(185, 'add-payroll_summary', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(186, 'edit-payroll_summary', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(187, 'delete-payroll_summary', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(188, 'view-advance_salary', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(189, 'add-advance_salary', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(190, 'edit-advance_salary', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(191, 'delete-advance_salary', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(192, 'view-employee_loan', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(193, 'add-employee_loan', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(194, 'edit-employee_loan', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(195, 'delete-employee_loan', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(196, 'view-overtime', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(197, 'add-overtime', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(198, 'edit-overtime', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(199, 'delete-overtime', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(200, 'view-nssf', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(201, 'add-nssf', 16, '2022-05-14 13:05:22', '2022-05-25 16:06:50'),
(202, 'edit-nssf', 16, '2022-05-14 13:05:23', '2022-05-25 16:06:50'),
(203, 'delete-nssf', 16, '2022-05-14 13:05:23', '2022-05-25 16:06:50'),
(204, 'view-tax', 16, '2022-05-14 13:05:23', '2022-05-25 16:06:50'),
(205, 'add-tax', 16, '2022-05-14 13:05:23', '2022-05-25 16:06:50'),
(206, 'edit-tax', 16, '2022-05-14 13:05:23', '2022-05-25 16:06:50'),
(207, 'delete-tax', 16, '2022-05-14 13:05:23', '2022-05-25 16:06:50'),
(208, 'view-nhif', 16, '2022-05-14 13:05:23', '2022-05-25 16:06:50'),
(209, 'add-nhif', 16, '2022-05-14 13:05:23', '2022-05-25 16:06:50'),
(210, 'edit-nhif', 16, '2022-05-14 13:05:23', '2022-05-25 16:06:50'),
(211, 'delete-nhif', 16, '2022-05-14 13:05:23', '2022-05-25 16:06:50'),
(212, 'view-wcf', 16, '2022-05-14 13:05:23', '2022-05-25 16:06:50'),
(213, 'add-wcf', 16, '2022-05-14 13:05:23', '2022-05-25 16:06:50'),
(214, 'edit-wcf', 16, '2022-05-14 13:05:23', '2022-05-25 16:06:50'),
(215, 'delete-wcf', 16, '2022-05-14 13:05:23', '2022-05-25 16:06:50'),
(216, 'view-leave', 12, '2022-05-14 13:05:23', '2022-05-25 16:06:50'),
(217, 'add-leave', 12, '2022-05-14 13:05:23', '2022-05-14 13:05:23'),
(218, 'edit-leave', 12, '2022-05-14 13:05:23', '2022-05-14 13:05:23'),
(219, 'delete-leave', 12, '2022-05-14 13:05:23', '2022-05-14 13:05:23'),
(220, 'view-training', 13, '2022-05-14 13:05:23', '2022-05-25 16:06:50'),
(221, 'add-training', 13, '2022-05-14 13:05:23', '2022-05-14 13:05:23'),
(222, 'edit-training', 13, '2022-05-14 13:05:23', '2022-05-14 13:05:23'),
(223, 'delete-training', 13, '2022-05-14 13:05:23', '2022-05-14 13:05:23'),
(224, 'view-truck', 15, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(225, 'add-truck', 15, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(226, 'edit-truck', 15, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(227, 'delete-truck', 15, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(228, 'view-driver', 15, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(229, 'add-driver', 15, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(230, 'edit-driver', 15, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(231, 'delete-driver', 15, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(232, 'view-fuel', 15, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(233, 'add-fuel', 15, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(234, 'edit-fuel', 15, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(235, 'delete-fuel', 15, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(236, 'view-tyre_brand', 14, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(237, 'add-tyre_brand', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(238, 'edit-tyre_brand', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(239, 'delete-tyre_brand', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(240, 'view-purchase_tyre', 14, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(241, 'add-purchase_tyre', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(242, 'edit-purchase_tyre', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(243, 'delete-purchase_tyre', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(244, 'view-tyre_list', 14, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(245, 'add-tyre_list', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(246, 'edit-tyre_list', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(247, 'delete-tyre_list', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(248, 'view-assign_truck', 14, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(249, 'add-assign_truck', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(250, 'edit-assign_truck', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(251, 'delete-assign_truck', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(252, 'view-tyre_return', 14, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(253, 'add-tyre_return', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(254, 'edit-tyre_return', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(255, 'delete-tyre_return', 14, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(256, 'view-tyre_reallocation', 14, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(257, 'add-tyre_reallocation', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(258, 'edit-tyre_reallocation', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(259, 'delete-tyre_reallocation', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(260, 'view-tyre_disposal', 14, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(261, 'add-tyre_disposal', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(262, 'edit-tyre_disposal', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(263, 'delete-tyre_disposal', 14, '2022-05-14 13:05:23', '2022-05-23 22:49:33'),
(264, 'view-location', 14, '2022-05-14 13:05:23', '2022-06-01 17:11:03'),
(265, 'add-location', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(266, 'edit-location', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(267, 'delete-location', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(268, 'view-inventory', 14, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(269, 'add-inventory', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(270, 'edit-inventory', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(271, 'delete-inventory', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(272, 'view-fieldstaff', 14, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(273, 'add-fieldstaff', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(274, 'edit-fieldstaff', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(275, 'delete-fieldstaff', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(276, 'view-purchase_inventory', 14, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(277, 'add-purchase_inventory', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(278, 'edit-purchase_inventory', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(279, 'delete-purchase_inventory', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(280, 'view-inventory_list', 14, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(281, 'add-inventory_list', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(282, 'edit-inventory_list', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(283, 'delete-inventory_list', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(284, 'view-maintainance', 14, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(285, 'add-maintainance', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(286, 'edit-maintainance', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(287, 'delete-maintainance', 14, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(288, 'view-service', 14, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(289, 'add-service', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(290, 'edit-service', 14, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(291, 'delete-service', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(292, 'view-good_issue', 14, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(293, 'add-good_issue', 14, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(294, 'edit-good_issue', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(295, 'delete-good_issue', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(296, 'view-good_return', 14, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(297, 'add-good_return', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(298, 'edit-good_return', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(299, 'delete-good_return', 14, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(300, 'view-good_movement', 14, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(301, 'add-good_movement', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(302, 'edit-good_movement', 14, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(303, 'delete-good_movement', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(304, 'view-good_reallocation', 14, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(305, 'add-good_reallocation', 14, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(306, 'edit-good_reallocation', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(307, 'delete-good_reallocation', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(308, 'view-good_disposal', 14, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(309, 'add-good_disposal', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(310, 'edit-good_disposal', 14, '2022-05-14 13:05:24', '2022-05-23 22:49:33'),
(311, 'delete-good_disposal', 14, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(312, 'view-deposit', 11, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(313, 'add-deposit', 11, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(314, 'edit-deposit', 11, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(315, 'delete-deposit', 11, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(316, 'view-expenses', 11, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(317, 'add-expenses', 11, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(318, 'edit-expenses', 11, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(319, 'delete-expenses', 11, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(320, 'view-bank_statement', 11, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(321, 'add-bank_statement', 11, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(322, 'edit-bank_statement', 11, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(323, 'delete-bank_statement', 11, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(324, 'view-bank_reconciliation', 11, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(325, 'add-bank_reconciliation', 11, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(326, 'edit-bank_reconciliation', 11, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(327, 'delete-bank_reconciliation', 11, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(328, 'view-reconciliation_report', 11, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(329, 'add-reconciliation_report', 11, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(330, 'edit-reconciliation_report', 11, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(331, 'delete-reconciliation_report', 11, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(332, 'view-class_account', 10, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(333, 'add-class_account', 10, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(334, 'edit-class_account', 10, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(335, 'delete-class_account', 10, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(336, 'view-group_account', 10, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(337, 'add-group_account', 10, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(338, 'edit-group_account', 10, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(339, 'delete-group_account', 10, '2022-05-14 13:05:24', '2022-05-25 16:07:41'),
(340, 'view-account_codes', 10, '2022-05-14 13:05:24', '2022-06-01 17:11:03'),
(341, 'add-account_codes', 10, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(342, 'edit-account_codes', 10, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(343, 'delete-account_codes', 10, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(344, 'view-chart_of_account', 10, '2022-05-14 13:05:25', '2022-06-01 17:11:03'),
(345, 'add-chart_of_account', 10, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(346, 'edit-chart_of_account', 10, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(347, 'delete-chart_of_account', 10, '2022-05-14 13:05:25', '2022-05-18 23:21:23'),
(348, 'view-manual_entry', 9, '2022-05-14 13:05:25', '2022-06-01 17:11:03'),
(349, 'add-manual_entry', 9, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(350, 'edit-manual_entry', 9, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(351, 'delete-manual_entry', 9, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(352, 'view-journal', 9, '2022-05-14 13:05:25', '2022-06-01 17:11:03'),
(353, 'add-journal', 9, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(354, 'edit-journal', 9, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(355, 'delete-journal', 9, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(356, 'view-ledger', 9, '2022-05-14 13:05:25', '2022-06-01 17:11:03'),
(357, 'add-ledger', 9, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(358, 'edit-ledger', 9, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(359, 'delete-ledger', 9, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(360, 'view-trial_balance', 9, '2022-05-14 13:05:25', '2022-06-01 17:11:03'),
(361, 'add-trial_balance', 9, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(362, 'edit-trial_balance', 9, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(363, 'delete-trial_balance', 9, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(364, 'view-income_statement', 9, '2022-05-14 13:05:25', '2022-06-01 17:11:03'),
(365, 'add-income_statement', 9, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(366, 'edit-income_statement', 9, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(367, 'delete-income_statement', 9, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(368, 'view-balance_sheet', 9, '2022-05-14 13:05:25', '2022-06-01 17:11:03'),
(369, 'add-balance_sheet', 9, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(370, 'edit-balance_sheet', 9, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(371, 'delete-balance_sheet', 9, '2022-05-14 13:05:25', '2022-05-25 16:07:41'),
(372, 'view-courier_client', 17, '2022-05-14 14:10:51', '2022-05-25 16:06:50'),
(373, 'add-courier_clientn', 17, '2022-05-14 14:10:51', '2022-05-14 14:10:51'),
(374, 'edit-courier_client', 17, '2022-05-14 14:10:51', '2022-05-14 14:10:51'),
(375, 'delete-courier_client', 17, '2022-05-14 14:10:51', '2022-05-14 14:10:51'),
(376, 'approve-payment', 16, '2022-05-15 10:50:09', '2022-05-25 16:06:50'),
(377, 'view-transfer', 11, '2022-05-16 08:23:49', '2022-06-01 17:11:03'),
(378, 'add-transfer', 11, '2022-05-16 08:24:16', '2022-06-01 17:11:03'),
(379, 'edit-transfer', 11, '2022-05-16 08:25:11', '2022-06-01 17:11:03'),
(380, 'delete-transfer', 11, '2022-05-16 08:26:12', '2022-06-01 17:11:03'),
(381, 'view-top-up-operator', 18, '2022-05-16 08:57:27', '2022-05-25 16:07:41'),
(382, 'add-top-up-operator', 18, '2022-05-16 08:57:50', '2022-05-25 16:07:41'),
(383, 'edit-top-up-operator', 18, '2022-05-16 08:58:14', '2022-05-25 16:07:41'),
(384, 'delete-top-up-operator', 18, '2022-05-16 08:58:37', '2022-05-25 16:07:41'),
(385, 'view-center', 18, '2022-05-16 08:57:27', '2022-05-25 16:07:41'),
(386, 'add-center', 18, '2022-05-16 08:57:50', '2022-05-25 16:07:41'),
(387, 'edit-center', 18, '2022-05-16 08:58:14', '2022-05-25 16:07:41'),
(388, 'delete-center', 18, '2022-05-16 08:58:37', '2022-05-25 16:07:41'),
(389, 'view-operator', 18, '2022-05-16 08:57:27', '2022-05-25 16:07:41'),
(390, 'add-operator', 18, '2022-05-16 08:57:50', '2022-05-25 16:07:41'),
(391, 'edit-operator', 18, '2022-05-16 08:58:14', '2022-05-25 16:07:41'),
(392, 'delete-operator', 18, '2022-05-16 08:58:37', '2022-05-25 16:07:41'),
(393, 'view-top-up-center', 18, '2022-05-16 08:57:27', '2022-05-25 16:07:41'),
(394, 'add-top-up-center', 18, '2022-05-16 08:57:50', '2022-05-25 16:07:41'),
(395, 'edit-top-up-center', 18, '2022-05-16 08:58:14', '2022-05-25 16:07:41'),
(396, 'delete-top-up-center', 18, '2022-05-16 08:58:37', '2022-05-25 16:07:41'),
(397, 'view-reverse-top-up-center', 18, '2022-05-16 08:57:27', '2022-05-25 16:07:41'),
(398, 'add-reverse-top-up-center', 18, '2022-05-16 08:57:50', '2022-05-25 16:07:41'),
(399, 'edit-reverse-top-up-center', 18, '2022-05-16 08:58:14', '2022-05-25 16:07:41'),
(400, 'delete-reverse-top-up-center', 18, '2022-05-16 08:58:37', '2022-05-25 16:07:41'),
(401, 'view-reverse-top-up-operator', 18, '2022-05-16 08:57:27', '2022-05-25 16:07:41'),
(402, 'add-reverse-top-up-operator', 18, '2022-05-16 08:57:50', '2022-05-25 16:07:41'),
(403, 'edit-reverse-top-up-operator', 18, '2022-05-16 08:58:14', '2022-05-25 16:07:41'),
(404, 'delete-reverse-top-up-operator', 18, '2022-05-16 08:58:37', '2022-05-25 16:07:41'),
(405, 'view-stock-report', 18, '2022-05-16 08:57:27', '2022-05-25 16:07:41'),
(406, 'add-stock-report', 18, '2022-05-16 08:57:50', '2022-05-25 16:07:41'),
(407, 'edit-stock-report', 18, '2022-05-16 08:58:14', '2022-05-25 16:07:41'),
(408, 'delete-stock-report', 18, '2022-05-16 08:58:37', '2022-05-25 16:07:41'),
(409, 'view-items', 18, '2022-05-16 08:57:27', '2022-05-25 16:07:41'),
(410, 'add-items', 18, '2022-05-16 08:57:50', '2022-05-25 16:07:41'),
(411, 'edit-items', 18, '2022-05-16 08:58:14', '2022-05-25 16:07:41'),
(412, 'delete-items', 18, '2022-05-16 08:58:37', '2022-05-25 16:07:41'),
(413, 'view-cotton-purchase', 18, '2022-05-16 08:57:27', '2022-05-25 16:07:41'),
(414, 'add-cotton-purchase', 18, '2022-05-16 08:57:50', '2022-05-25 16:07:41'),
(415, 'edit-cotton-purchase', 18, '2022-05-16 08:58:14', '2022-05-25 16:07:41'),
(416, 'delete-cotton-purchase', 18, '2022-05-16 08:58:37', '2022-05-25 16:07:41'),
(417, 'view-cotton-movement', 18, '2022-05-16 08:57:27', '2022-05-25 16:07:41'),
(418, 'add-cotton-movement', 18, '2022-05-16 08:57:50', '2022-05-25 16:07:41'),
(419, 'edit-cotton-movement', 18, '2022-05-16 08:58:14', '2022-05-25 16:07:41'),
(420, 'delete-cotton-movement', 18, '2022-05-16 08:58:37', '2022-05-25 16:07:41'),
(421, 'view-center-report', 18, '2022-05-16 08:57:27', '2022-05-25 16:07:41'),
(422, 'add-center-report', 18, '2022-05-16 08:57:50', '2022-05-25 16:07:41'),
(423, 'edit-center-report', 18, '2022-05-16 08:58:14', '2022-05-25 16:07:41'),
(424, 'delete-center-report', 18, '2022-05-16 08:58:37', '2022-05-25 16:07:41'),
(425, 'view-connect', 15, '2022-05-20 16:36:15', '2022-06-01 17:11:03'),
(426, 'view-cargo-wb', 4, '2022-05-20 23:17:51', '2022-06-01 17:11:03'),
(427, 'view-levy-report', 18, '2022-05-24 23:03:54', '2022-05-25 16:07:41'),
(428, 'view-district', 18, '2022-05-25 10:19:25', '2022-05-25 16:07:41'),
(430, 'add-district', 18, '2022-05-25 10:24:44', '2022-05-25 16:07:41'),
(431, 'edit-district', 18, '2022-05-25 10:25:10', '2022-05-25 16:07:41'),
(432, 'delete-district', 18, '2022-05-25 10:25:33', '2022-05-25 16:07:41'),
(433, 'view-cotton-invoice', 18, '2022-05-25 14:53:49', '2022-05-25 16:07:41'),
(434, 'add-cotton-invoice', 18, '2022-05-25 14:55:54', '2022-05-25 16:07:41'),
(435, 'edit-cotton-invoice', 18, '2022-05-25 14:56:26', '2022-05-25 16:07:41'),
(436, 'delete-cotton-invoice', 18, '2022-05-25 14:56:56', '2022-05-25 16:07:41'),
(437, 'view-seed-invoice', 18, '2022-05-25 14:57:38', '2022-05-25 16:07:41'),
(438, 'add-seed-invoice', 18, '2022-05-25 14:58:19', '2022-05-25 16:07:41'),
(439, 'edit-seed-invoice', 18, '2022-05-25 14:58:41', '2022-05-25 16:07:41'),
(440, 'delete-seed-invoice', 18, '2022-05-25 14:59:02', '2022-05-25 16:07:41'),
(441, 'view-cotton-client', 18, '2022-05-25 14:57:38', '2022-05-25 16:07:41'),
(442, 'add-cotton-client', 18, '2022-05-25 14:58:19', '2022-05-25 16:07:41'),
(443, 'edit-cotton-client', 18, '2022-05-25 14:58:41', '2022-05-25 16:07:41'),
(444, 'delete-cotton-client', 18, '2022-05-25 14:59:02', '2022-05-25 16:07:41'),
(445, 'view-store-location', 19, '2022-06-01 16:42:30', '2022-06-01 17:16:36'),
(446, 'add-store-location', 19, '2022-06-01 16:42:51', '2022-06-01 17:17:28'),
(447, 'edit-store-location', 19, '2022-06-01 16:43:15', '2022-06-01 17:17:49'),
(448, 'delete-store-location', 19, '2022-06-01 16:43:33', '2022-06-01 17:18:07');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 19, 'Personal Access Token', 'a0c7f4814a23b4cb7cac974c2dc20776be25968eb60c658e0eff6236a52fd83e', '[\"*\"]', NULL, '2022-05-04 13:07:25', '2022-05-04 13:07:25'),
(2, 'App\\Models\\User', 19, 'Personal Access Token', '886a9f9d5757399b607a5e30c5ef2a8c0905e99cc9f3b7c9326d9fc72ef6b421', '[\"*\"]', '2022-05-04 13:32:17', '2022-05-04 13:08:30', '2022-05-04 13:32:17'),
(3, 'App\\Models\\User', 19, 'Personal Access Token', '53111ba6c07c1c0202a35372db7a36b7312ef658fb3da2337be0af2af78f3576', '[\"*\"]', '2022-05-04 14:51:32', '2022-05-04 14:35:57', '2022-05-04 14:51:32'),
(4, 'App\\Models\\User', 19, 'Personal Access Token', 'a2f235408396dbd71a0e44933416a41e43d8280ef24f1b0146e361731ca1ff31', '[\"*\"]', '2022-05-07 15:43:47', '2022-05-07 15:41:45', '2022-05-07 15:43:47'),
(5, 'App\\Models\\User', 19, 'Personal Access Token', '9a32a3c164040f7386bbad354985de91e64b770170bb94eb82489c17e99699c2', '[\"*\"]', '2022-05-07 15:48:00', '2022-05-07 15:46:34', '2022-05-07 15:48:00');

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE `prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `unit` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`id`, `name`, `price`, `unit`, `created_at`, `updated_at`) VALUES
(1, 'Desktop Computer', '500000.00', 'pounds', '2022-02-09 14:44:34', '2022-02-09 14:46:09'),
(2, 'Furniture', '350000.00', 'kgs', '2022-02-09 14:44:34', '2022-02-09 14:45:20'),
(3, 'Documents', '10000.00', 'kgs', '2022-02-09 14:45:05', '2022-02-09 14:45:05'),
(4, 'Silico Manganese', '1500000.00', 'tons', '2022-02-09 14:46:53', '2022-02-09 14:46:53'),
(5, 'Gold', '1800000.00', 'tons', '2022-02-09 14:47:34', '2022-02-09 14:47:34'),
(6, 'Containers', '250000.00', 'kgs', '2022-02-09 14:48:08', '2022-02-09 14:48:08');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `buyprice` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sellprice` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `name`, `code`, `buyprice`, `sellprice`, `unit`, `balance`, `created_at`, `updated_at`) VALUES
(1, '1', 'Jembe', 'jp238ht', '12000', '15000', 'litre', 12, '2022-02-08 11:47:54', '2022-02-08 13:07:36'),
(3, '1', 'mbolea', 'mb344 43', '7000', '9000', 'litre', 1, '2022-02-08 13:11:25', '2022-02-08 13:11:25');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_cotton`
--

CREATE TABLE `purchase_cotton` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `due_date` date NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` int(100) NOT NULL,
  `item_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(20,2) NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `tax_rate` decimal(20,2) DEFAULT NULL,
  `unit` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_amount` decimal(20,2) NOT NULL,
  `due_amount` decimal(20,2) NOT NULL,
  `purchase_tax` decimal(20,2) NOT NULL,
  `exchange_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'TZS',
  `exchange_rate` decimal(8,2) DEFAULT 1.00,
  `status` int(11) NOT NULL,
  `good_receive` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_cotton`
--

INSERT INTO `purchase_cotton` (`id`, `reference`, `reference_no`, `supplier_id`, `purchase_date`, `due_date`, `location`, `district_id`, `item_id`, `quantity`, `price`, `tax_rate`, `unit`, `purchase_amount`, `due_amount`, `purchase_tax`, `exchange_code`, `exchange_rate`, `status`, `good_receive`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '456', 'PUR_CTN-1-2022-05-17', '3', '2022-05-17', '2022-05-18', '4', 118, '1', '200.00', '2000.00', '0.18', 'kg', '400000.00', '472000.00', '72000.00', 'TZS', '1.00', 1, '1', 50, '2022-05-17 16:04:20', '2022-05-17 16:15:57'),
(2, '4566', 'PUR_CTN-2-2022-05-17', '3', '2022-05-17', '2022-05-17', '4', 118, '1', '3000.00', '2000.00', '0.18', 'kg', '6000000.00', '6000000.00', '0.00', 'TZS', '1.00', 1, '1', 50, '2022-05-17 16:50:42', '2022-05-17 16:54:18'),
(6, '5555', 'PUR_CTN-6-2022-05-18', '3', '2022-05-18', '2022-05-19', '4', 118, '1', '2500.00', '2000.00', '0.00', 'kg', '5000000.00', '5000000.00', '0.00', 'TZS', '1.00', 1, '1', 50, '2022-05-18 06:25:59', '2022-05-18 06:25:59'),
(7, '12345', 'PUR_CTN-7-2022-05-18', '1', '2022-05-18', '2022-05-20', '1', 118, '1', '150.00', '2000.00', '0.18', 'kg', '354000.00', '354000.00', '54000.00', 'TZS', '1.00', 1, '1', 50, '2022-05-18 06:35:36', '2022-05-18 06:35:36'),
(8, '56734', 'PUR_CTN-8-2022-05-17', '1', '2022-05-17', '2022-05-18', '2', 117, '1', '10.00', '2000.00', '0.18', 'kg', '23600.00', '23600.00', '3600.00', 'TZS', '1.00', 1, '1', 50, '2022-05-18 06:39:59', '2022-05-18 06:39:59'),
(9, '345', 'PUR_CTN-9-2022-05-18', '1', '2022-05-18', '2022-05-18', '2', 117, '1', '20.00', '2000.00', '0.18', 'kg', '47200.00', '47200.00', '7200.00', 'TZS', '1.00', 1, '1', 50, '2022-05-18 06:55:14', '2022-05-18 06:55:14'),
(10, '45665', 'PUR_CTN-10-2022-05-18', '3', '2022-05-18', '2022-05-19', '4', 117, '1', '4500.00', '2100.00', '0.00', 'kg', '9450000.00', '9450000.00', '0.00', 'TZS', '1.00', 1, '1', 50, '2022-05-18 09:01:07', '2022-05-18 09:01:07'),
(11, '11579', 'PUR_CTN-11-2022-05-18', '3', '2022-05-18', '2022-05-18', '4', 117, '1', '10000.00', '2100.00', '0.00', 'tonnes', '21000000.00', '21000000.00', '0.00', 'TZS', '1.00', 1, '1', 50, '2022-05-18 18:51:59', '2022-05-18 18:51:59'),
(12, '11157', 'PUR_CTN-12-2022-05-18', '2', '2022-05-18', '2022-05-19', '5', 117, '1', '5000.00', '1500.00', '0.00', 'kg', '7500000.00', '7500000.00', '0.00', 'TZS', '1.00', 1, '1', 50, '2022-05-18 19:02:48', '2022-05-18 19:02:48'),
(15, 'AUTO-2022-05-13', 'PUR_CTN-15-2022-05-13', '1', '2022-05-13', '2022-05-13', '5', 0, '1', '2000.00', '2000.00', '0.00', 'Kg', '4000000.00', '4000000.00', '0.00', 'TZS', '1.00', 1, '1', 50, '2022-05-21 17:19:58', '2022-05-21 17:19:58'),
(16, 'AUTO-2022-05-23', 'PUR_CTN-16-2022-05-23', '1', '2022-05-23', '2022-05-23', '5', 0, '1', '13000.00', '2000.00', '0.00', 'Kg', '26000000.00', '26000000.00', '0.00', 'TZS', '1.00', 1, '1', 50, '2022-05-23 17:31:08', '2022-05-23 17:31:08'),
(17, '44w3345', 'PUR_CTN-17-2022-05-24', '2', '2022-05-24', '2022-05-24', '5', 0, '1', '30000.00', '2000.00', '0.00', 'kg', '60000000.00', '60000000.00', '0.00', 'TZS', '1.00', 1, '1', 50, '2022-05-24 12:51:30', '2022-05-24 12:51:30'),
(18, '1200', 'PUR_CTN-18-2022-05-25', '2', '2022-05-25', '2022-05-25', '5', 0, '1', '44800.00', '2000.00', '0.00', 'kg', '89600000.00', '89600000.00', '0.00', 'TZS', '1.00', 1, '1', 1, '2022-05-25 10:56:31', '2022-05-25 10:56:32'),
(19, '1112', 'PUR_CTN-19-2022-05-25', '2', '2022-05-25', '2022-05-25', '5', 117, '1', '44000.00', '2000.00', '0.00', 'kg', '88000000.00', '88000000.00', '0.00', 'TZS', '1.00', 1, '1', 1, '2022-05-25 11:11:07', '2022-05-25 11:11:07'),
(20, 'AUTO-22-05-25', 'PUR_CTN-20-22-05-25', '1', '2022-05-25', '2022-05-25', '5', 117, '1', '461000.00', '2000.00', '0.00', 'Kg', '922000000.00', '922000000.00', '0.00', 'TZS', '1.00', 1, '1', 1, '2022-05-25 11:25:41', '2022-05-25 11:25:41');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_inventories`
--

CREATE TABLE `purchase_inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `due_date` date NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` decimal(8,2) NOT NULL,
  `purchase_amount` decimal(20,2) NOT NULL,
  `due_amount` decimal(20,2) NOT NULL,
  `purchase_tax` decimal(20,2) NOT NULL,
  `status` int(11) NOT NULL,
  `good_receive` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_inventories`
--

INSERT INTO `purchase_inventories` (`id`, `reference_no`, `supplier_id`, `purchase_date`, `due_date`, `location`, `exchange_code`, `exchange_rate`, `purchase_amount`, `due_amount`, `purchase_tax`, `status`, `good_receive`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'PUR_INV-1-2022-04-19', '1', '2022-04-19', '2022-04-26', '1', 'TZS', '1.00', '199000.00', '0.00', '35820.00', 3, '1', 19, '2022-04-25 15:02:21', '2022-05-23 14:51:36'),
(2, 'PUR_INV-2-2022-05-10', '1', '2022-05-10', '2022-05-15', '1', 'TZS', '1.00', '555000.00', '654900.00', '99900.00', 1, '0', 44, '2022-05-10 16:38:17', '2022-05-10 16:40:34');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_item_cotton`
--

CREATE TABLE `purchase_item_cotton` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_rate` decimal(8,2) NOT NULL,
  `total_tax` decimal(8,2) NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `total_cost` decimal(8,2) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL,
  `order_no` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_item_cotton`
--

INSERT INTO `purchase_item_cotton` (`id`, `purchase_id`, `item_name`, `tax_rate`, `total_tax`, `quantity`, `total_cost`, `price`, `unit`, `items_id`, `order_no`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', '1', '0.18', '72000.00', '200.00', '400000.00', '2000.00', 'kg', 1, 0, 50, '2022-05-17 16:04:20', '2022-05-17 16:15:57'),
(2, '2', '1', '0.00', '0.00', '3000.00', '999999.99', '2000.00', 'kg', 1, 0, 50, '2022-05-17 16:50:42', '2022-05-17 16:54:18');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_item_inventories`
--

CREATE TABLE `purchase_item_inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_rate` decimal(8,2) NOT NULL,
  `total_tax` decimal(8,2) NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `total_cost` decimal(8,2) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL,
  `order_no` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_item_inventories`
--

INSERT INTO `purchase_item_inventories` (`id`, `purchase_id`, `item_name`, `tax_rate`, `total_tax`, `quantity`, `total_cost`, `price`, `unit`, `items_id`, `order_no`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', '1', '0.18', '12420.00', '3.00', '69000.00', '23000.00', 'pc', 1, 0, 19, '2022-04-25 15:02:21', '2022-04-25 15:03:31'),
(2, '1', '2', '0.18', '23400.00', '2.00', '130000.00', '65000.00', 'PC', 2, 1, 19, '2022-04-25 15:02:21', '2022-04-25 15:03:31'),
(3, '2', '1', '0.18', '41400.00', '10.00', '230000.00', '23000.00', 'pc', 1, 0, 44, '2022-05-10 16:38:17', '2022-05-10 16:38:17'),
(4, '2', '2', '0.18', '58500.00', '5.00', '325000.00', '65000.00', 'PC', 2, 1, 44, '2022-05-10 16:38:17', '2022-05-10 16:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_item_medicine`
--

CREATE TABLE `purchase_item_medicine` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch_no` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire_date` date NOT NULL,
  `tax_rate` decimal(8,2) NOT NULL,
  `total_tax` decimal(8,2) NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `total_cost` decimal(8,2) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_no` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_item_tyres`
--

CREATE TABLE `purchase_item_tyres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_rate` decimal(8,2) NOT NULL,
  `total_tax` decimal(8,2) NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `total_cost` decimal(8,2) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL,
  `order_no` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_item_tyres`
--

INSERT INTO `purchase_item_tyres` (`id`, `purchase_id`, `item_name`, `tax_rate`, `total_tax`, `quantity`, `total_cost`, `price`, `unit`, `items_id`, `order_no`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', '1', '0.18', '30240.00', '3.00', '168000.00', '56000.00', 'PC', 1, 0, 53, '2022-05-17 13:56:52', '2022-05-17 14:00:34'),
(2, '2', '1', '0.18', '1800.00', '2.00', '10000.00', '5000.00', 'PC', 1, 0, 1, '2022-05-19 19:10:58', '2022-05-19 19:11:38'),
(3, '3', '1', '0.00', '0.00', '1.00', '5000.00', '5000.00', 'PC', 1, 0, 1, '2022-05-19 21:35:57', '2022-05-19 21:36:59');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_medicine`
--

CREATE TABLE `purchase_medicine` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `due_date` date NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` decimal(8,2) NOT NULL,
  `purchase_amount` decimal(20,2) NOT NULL,
  `due_amount` decimal(20,2) NOT NULL,
  `purchase_tax` decimal(20,2) NOT NULL,
  `status` int(11) NOT NULL,
  `good_receive` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_medicine_payments`
--

CREATE TABLE `purchase_medicine_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trans_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `date` date NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_tyres`
--

CREATE TABLE `purchase_tyres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `due_date` date NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` decimal(8,2) NOT NULL,
  `purchase_amount` decimal(8,2) NOT NULL,
  `due_amount` decimal(8,2) NOT NULL,
  `purchase_tax` decimal(8,2) NOT NULL,
  `status` int(11) NOT NULL,
  `good_receive` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_tyres`
--

INSERT INTO `purchase_tyres` (`id`, `reference_no`, `supplier_id`, `purchase_date`, `due_date`, `location`, `exchange_code`, `exchange_rate`, `purchase_amount`, `due_amount`, `purchase_tax`, `status`, `good_receive`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'PUR_TYRE_1_2022-05-17', '6', '2022-05-17', '2022-05-20', '1', 'USD', '2400.00', '168000.00', '197240.00', '30240.00', 2, '1', 53, '2022-05-17 13:56:52', '2022-05-23 14:38:29'),
(2, 'PUR_TYRE_2_2022-05-18', '4', '2022-05-18', '2022-05-21', '1', 'TZS', '1.00', '10000.00', '11800.00', '1800.00', 1, '1', 1, '2022-05-19 19:10:58', '2022-05-19 19:11:38'),
(3, 'PUR_TYRE_3_2022-05-18', '1', '2022-05-18', '2022-05-19', '1', 'TZS', '1.00', '5000.00', '5000.00', '0.00', 1, '1', 1, '2022-05-19 21:35:57', '2022-05-19 21:36:59');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_costs`
--

CREATE TABLE `quotation_costs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refills`
--

CREATE TABLE `refills` (
  `id` int(200) NOT NULL,
  `truck` varchar(200) NOT NULL,
  `route` varchar(200) NOT NULL,
  `fuel_id` varchar(200) NOT NULL,
  `litres` decimal(20,2) NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `supplier` varchar(200) DEFAULT NULL,
  `account_id` int(200) DEFAULT NULL,
  `payment_type` varchar(200) NOT NULL,
  `total_cost` decimal(20,2) NOT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `refills`
--

INSERT INTO `refills` (`id`, `truck`, `route`, `fuel_id`, `litres`, `price`, `supplier`, `account_id`, `payment_type`, `total_cost`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '6', '8', '10', '178.29', '2720.00', '', NULL, 'credit', '484948.80', 19, '2022-04-28 23:51:36', '2022-04-28 23:51:36'),
(2, '3', '4', '1', '23.00', '234.00', '', 25, '', '5382.00', 19, '2022-05-04 13:12:12', '2022-05-04 13:12:12'),
(3, '9', '10', '12', '50.00', '3100.00', '', 7, 'credit', '155000.00', 53, '2022-05-17 14:44:01', '2022-05-17 14:44:01'),
(4, '8', '3', '15', '3.00', '5000.00', '6', 32, 'cash', '15000.00', 1, '2022-05-20 15:53:23', '2022-05-20 15:53:23'),
(5, '9', '7', '13', '4.00', '5000.00', '7', 32, 'cash', '20000.00', 1, '2022-05-23 14:12:43', '2022-05-23 14:12:43');

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `zone_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `country_id` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `zone_id`, `name`, `deleted_at`, `created_at`, `updated_at`, `country_id`) VALUES
(1, 0, 'Arusha', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(2, 0, 'Dar es Salaam', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(3, 0, 'Dodoma', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(4, 0, 'Geita', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(5, 0, 'Iringa', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(6, 0, 'Kagera', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(7, 0, 'Katavi', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(8, 0, 'Kigoma', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(9, 0, 'Kilimanjaro', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(10, 0, 'Lindi', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(11, 0, 'Manyara', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(12, 0, 'Mara', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(13, 0, 'Mbeya', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(14, 0, 'Morogoro', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(15, 0, 'Mtwara', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(16, 0, 'Mwanza', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(17, 0, 'Njombe', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(18, 0, 'Pwani', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(19, 0, 'Rukwa', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(20, 0, 'Ruvuma', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(21, 0, 'Shinyanga', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(22, 0, 'Simiyu', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(23, 0, 'Singida', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(24, 0, 'Songwe', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(25, 0, 'Tabora', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(26, 0, 'Tanga', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(27, 0, 'UNG', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(28, 0, 'UNG', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(29, 0, 'PEM', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(30, 0, 'PEM', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(31, 0, 'UNG', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1),
(32, 0, 'Other', NULL, '2022-04-12 01:37:25', '2022-04-12 01:37:25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reversed_top_up_center`
--

CREATE TABLE `reversed_top_up_center` (
  `id` int(11) NOT NULL,
  `from_account_id` int(11) NOT NULL,
  `to_account_id` int(11) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `due_amount` decimal(20,2) NOT NULL,
  `exchange_code` varchar(200) DEFAULT 'TZS',
  `exchange_rate` decimal(20,2) DEFAULT 1.00,
  `payment_method` int(11) NOT NULL,
  `reference` varchar(200) DEFAULT NULL,
  `top_up_id` int(200) NOT NULL,
  `top_up_reference` varchar(200) NOT NULL,
  `status` varchar(200) DEFAULT '0' COMMENT '0=pending,1=approved,2=completed',
  `notes` text DEFAULT NULL,
  `date` date NOT NULL,
  `type` varchar(20) DEFAULT 'Top Up',
  `added_by` int(200) NOT NULL,
  `approve_by` int(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reversed_top_up_operator`
--

CREATE TABLE `reversed_top_up_operator` (
  `id` int(11) NOT NULL,
  `from_account_id` int(11) NOT NULL,
  `to_account_id` int(11) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `due_amount` decimal(20,2) NOT NULL,
  `exchange_code` varchar(200) DEFAULT 'TZS',
  `exchange_rate` decimal(20,2) DEFAULT 1.00,
  `payment_method` int(11) NOT NULL,
  `reference` varchar(200) DEFAULT NULL,
  `status` varchar(200) DEFAULT '0' COMMENT '0=pending,1=approved,2=completed',
  `notes` text DEFAULT NULL,
  `date` date NOT NULL,
  `type` varchar(20) DEFAULT 'Reversed Top Up',
  `added_by` int(200) NOT NULL,
  `approve_by` int(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `top_up_id` int(200) NOT NULL,
  `top_up_reference` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reversed_top_up_operator`
--

INSERT INTO `reversed_top_up_operator` (`id`, `from_account_id`, `to_account_id`, `amount`, `due_amount`, `exchange_code`, `exchange_rate`, `payment_method`, `reference`, `status`, `notes`, `date`, `type`, `added_by`, `approve_by`, `created_at`, `updated_at`, `top_up_id`, `top_up_reference`) VALUES
(1, 1, 7, '0.00', '0.00', 'TZS', '1.00', 2, 'TRO_jzRe', '1', 'hgg', '2022-05-17', 'Reversed Top Up', 1, 1, '2022-05-17 09:34:22', '2022-05-17 09:34:22', 1, 'TO_oL5Z'),
(2, 1, 7, '0.00', '0.00', 'TZS', '1.00', 2, 'TRO_SqWJ', '1', 'hgg', '2022-05-17', 'Reversed Top Up', 1, 1, '2022-05-17 09:35:44', '2022-05-17 09:35:44', 1, 'TO_oL5Z'),
(3, 1, 32, '23000.00', '23000.00', 'TZS', '1.00', 2, 'TRO_HjmB', '1', 'bb', '2022-05-19', 'Reversed Top Up', 50, 50, '2022-05-19 16:15:51', '2022-05-19 16:15:51', 2, 'TO_7Ogd'),
(4, 1, 7, '23000.00', '23000.00', 'TZS', '1.00', 2, 'TRO_magk', '1', 'bb', '2022-05-19', 'Reversed Top Up', 50, 50, '2022-05-19 16:16:13', '2022-05-19 16:16:13', 2, 'TO_7Ogd'),
(5, 2, 6, '4000000.00', '4000000.00', 'TZS', '1.00', 3, 'TRO_poa1', '1', 'jbjb', '2022-05-20', 'Reversed Top Up', 50, 50, '2022-05-19 16:22:37', '2022-05-19 16:22:37', 3, 'TO_0McG'),
(6, 1, 29, '23000.00', '23000.00', 'TZS', '1.00', 2, 'TRO_RrIK', '1', 'Test', '2022-05-22', 'Reversed Top Up', 50, 50, '2022-05-22 14:52:50', '2022-05-22 14:52:50', 2, 'TO_7Ogd'),
(7, 3, 7, '2000.00', '2000.00', 'TZS', '1.00', 2, 'TRO_a1cq', '1', 'jhkj', '2022-05-25', 'Reversed Top Up', 50, 50, '2022-05-25 19:22:35', '2022-05-25 19:22:35', 4, 'TO_Qcup'),
(8, 2, 27, '2500000.00', '2500000.00', 'TZS', '1.00', 1, 'TRO_zMyw', '1', NULL, '2022-05-25', 'Reversed Top Up', 50, 50, '2022-05-25 20:08:08', '2022-05-25 20:08:08', 3, 'TO_0McG'),
(9, 2, 27, '2500000.00', '2500000.00', 'TZS', '1.00', 1, 'TRO_OWb9', '1', NULL, '2022-05-25', 'Reversed Top Up', 50, 50, '2022-05-25 20:11:36', '2022-05-25 20:11:36', 3, 'TO_0McG'),
(10, 1, 7, '23000.00', '23000.00', 'TZS', '1.00', 2, 'TRO_Thq0', '1', NULL, '2022-05-25', 'Reversed Top Up', 50, 50, '2022-05-25 23:24:25', '2022-05-25 23:24:25', 2, 'TO_7Ogd');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `slug`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'superAdmin', 1, '2021-12-04 17:17:50', '2021-12-04 17:17:50'),
(13, 'Logistic', 1, '2022-03-15 13:48:14', '2022-03-15 13:48:14'),
(25, 'driver', 24, '2022-03-22 09:42:31', '2022-03-22 09:42:31'),
(26, 'shopkeer', 23, '2022-03-22 09:53:48', '2022-03-22 09:53:48'),
(28, 'accountant', 40, '2022-04-30 16:07:15', '2022-04-30 16:07:15'),
(31, 'HR', 1, '2022-05-07 20:29:52', '2022-05-07 20:29:52'),
(32, 'Test', 19, '2022-05-09 12:33:36', '2022-05-09 12:33:36'),
(33, 'Inventory', 1, '2022-05-10 15:54:55', '2022-05-10 15:54:55'),
(34, 'Courier-Systems', 1, '2022-05-12 15:50:31', '2022-05-12 15:50:31'),
(35, 'cotton-colection', 1, '2022-05-16 08:38:59', '2022-05-16 08:38:59');

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(1, 50),
(1, 51),
(1, 52),
(1, 53),
(1, 54),
(1, 55),
(1, 56),
(1, 57),
(1, 58),
(1, 59),
(1, 60),
(1, 61),
(1, 62),
(1, 63),
(1, 64),
(1, 65),
(1, 66),
(1, 67),
(1, 68),
(1, 69),
(1, 70),
(1, 71),
(1, 72),
(1, 73),
(1, 74),
(1, 75),
(1, 76),
(1, 77),
(1, 78),
(1, 79),
(1, 80),
(1, 81),
(1, 82),
(1, 83),
(1, 84),
(1, 85),
(1, 86),
(1, 87),
(1, 91),
(1, 115),
(1, 119),
(1, 123),
(1, 127),
(1, 224),
(1, 225),
(1, 226),
(1, 227),
(1, 228),
(1, 229),
(1, 230),
(1, 231),
(1, 232),
(1, 233),
(1, 234),
(1, 235),
(1, 236),
(1, 240),
(1, 244),
(1, 248),
(1, 252),
(1, 255),
(1, 256),
(1, 260),
(1, 264),
(1, 268),
(1, 272),
(1, 276),
(1, 280),
(1, 284),
(1, 287),
(1, 288),
(1, 290),
(1, 292),
(1, 293),
(1, 296),
(1, 299),
(1, 300),
(1, 302),
(1, 304),
(1, 305),
(1, 308),
(1, 311),
(1, 312),
(1, 316),
(1, 320),
(1, 324),
(1, 328),
(1, 332),
(1, 336),
(1, 340),
(1, 344),
(1, 348),
(1, 352),
(1, 356),
(1, 360),
(1, 364),
(1, 368),
(1, 377),
(1, 378),
(1, 379),
(1, 380),
(1, 425),
(1, 426),
(1, 445),
(1, 446),
(1, 447),
(1, 448),
(13, 1),
(13, 39),
(13, 40),
(13, 41),
(13, 42),
(13, 43),
(13, 44),
(13, 45),
(13, 46),
(13, 47),
(13, 48),
(13, 49),
(13, 50),
(13, 51),
(13, 52),
(13, 53),
(13, 54),
(13, 55),
(13, 56),
(13, 57),
(13, 58),
(13, 59),
(13, 60),
(13, 61),
(13, 62),
(13, 63),
(13, 64),
(13, 65),
(13, 66),
(13, 67),
(13, 68),
(13, 69),
(13, 70),
(13, 71),
(13, 72),
(13, 73),
(13, 74),
(13, 75),
(13, 76),
(13, 77),
(13, 78),
(13, 79),
(13, 80),
(13, 81),
(13, 82),
(13, 83),
(13, 84),
(13, 85),
(13, 86),
(13, 87),
(13, 88),
(13, 89),
(13, 90),
(13, 91),
(13, 92),
(13, 93),
(13, 94),
(13, 115),
(13, 116),
(13, 117),
(13, 118),
(13, 119),
(13, 120),
(13, 121),
(13, 122),
(13, 123),
(13, 124),
(13, 125),
(13, 126),
(13, 127),
(13, 224),
(13, 225),
(13, 226),
(13, 227),
(13, 228),
(13, 229),
(13, 230),
(13, 231),
(13, 232),
(13, 233),
(13, 234),
(13, 235),
(13, 236),
(13, 237),
(13, 238),
(13, 239),
(13, 240),
(13, 241),
(13, 242),
(13, 243),
(13, 244),
(13, 245),
(13, 246),
(13, 247),
(13, 248),
(13, 249),
(13, 250),
(13, 251),
(13, 252),
(13, 253),
(13, 254),
(13, 255),
(13, 256),
(13, 257),
(13, 258),
(13, 259),
(13, 260),
(13, 261),
(13, 262),
(13, 263),
(13, 264),
(13, 265),
(13, 266),
(13, 267),
(13, 268),
(13, 269),
(13, 270),
(13, 271),
(13, 272),
(13, 273),
(13, 274),
(13, 275),
(13, 276),
(13, 277),
(13, 278),
(13, 279),
(13, 280),
(13, 281),
(13, 282),
(13, 283),
(13, 284),
(13, 285),
(13, 286),
(13, 287),
(13, 288),
(13, 289),
(13, 290),
(13, 291),
(13, 292),
(13, 293),
(13, 294),
(13, 295),
(13, 296),
(13, 297),
(13, 298),
(13, 299),
(13, 300),
(13, 301),
(13, 302),
(13, 303),
(13, 304),
(13, 305),
(13, 306),
(13, 307),
(13, 308),
(13, 309),
(13, 310),
(13, 311),
(13, 312),
(13, 313),
(13, 314),
(13, 315),
(13, 316),
(13, 317),
(13, 318),
(13, 319),
(13, 320),
(13, 321),
(13, 322),
(13, 323),
(13, 324),
(13, 325),
(13, 326),
(13, 327),
(13, 328),
(13, 329),
(13, 330),
(13, 331),
(13, 332),
(13, 348),
(13, 349),
(13, 350),
(13, 351),
(13, 352),
(13, 353),
(13, 354),
(13, 355),
(13, 356),
(13, 357),
(13, 358),
(13, 359),
(13, 360),
(13, 361),
(13, 362),
(13, 363),
(13, 364),
(13, 365),
(13, 366),
(13, 367),
(13, 368),
(13, 369),
(13, 370),
(13, 371),
(13, 377),
(13, 378),
(13, 379),
(13, 380),
(13, 425),
(13, 426),
(13, 445),
(13, 446),
(13, 447),
(13, 448),
(14, 1),
(14, 2),
(14, 3),
(14, 4),
(14, 5),
(14, 6),
(14, 7),
(14, 8),
(14, 9),
(14, 10),
(14, 11),
(14, 12),
(14, 13),
(14, 14),
(14, 15),
(14, 16),
(14, 17),
(14, 18),
(14, 19),
(14, 20),
(14, 21),
(14, 22),
(14, 23),
(14, 24),
(14, 25),
(14, 26),
(14, 27),
(14, 28),
(14, 29),
(14, 30),
(14, 31),
(14, 32),
(14, 33),
(14, 34),
(14, 35),
(14, 36),
(14, 37),
(14, 38),
(14, 67),
(14, 68),
(14, 69),
(14, 70),
(14, 71),
(14, 72),
(14, 73),
(14, 74),
(14, 75),
(14, 76),
(14, 77),
(14, 78),
(14, 79),
(14, 80),
(15, 1),
(15, 2),
(15, 3),
(15, 4),
(15, 5),
(15, 6),
(15, 7),
(15, 8),
(15, 9),
(15, 10),
(15, 11),
(15, 12),
(15, 13),
(15, 14),
(15, 15),
(15, 16),
(15, 17),
(15, 18),
(15, 19),
(15, 20),
(15, 21),
(15, 22),
(15, 23),
(15, 24),
(15, 25),
(15, 26),
(15, 27),
(15, 28),
(15, 29),
(15, 30),
(15, 31),
(15, 32),
(15, 33),
(15, 34),
(15, 35),
(15, 36),
(15, 37),
(15, 38),
(15, 83),
(16, 5),
(16, 6),
(16, 7),
(16, 8),
(16, 9),
(16, 10),
(16, 11),
(16, 39),
(16, 40),
(16, 41),
(16, 42),
(16, 43),
(16, 44),
(16, 45),
(16, 46),
(17, 1),
(17, 2),
(17, 3),
(17, 4),
(17, 39),
(17, 40),
(17, 41),
(17, 42),
(17, 43),
(17, 44),
(17, 45),
(17, 46),
(17, 47),
(17, 48),
(17, 49),
(17, 50),
(17, 67),
(17, 68),
(17, 69),
(17, 70),
(17, 71),
(17, 72),
(17, 73),
(17, 74),
(17, 75),
(17, 76),
(17, 77),
(17, 78),
(17, 79),
(17, 80),
(17, 83),
(23, 1),
(23, 2),
(23, 3),
(23, 4),
(23, 5),
(23, 6),
(23, 7),
(23, 8),
(23, 9),
(23, 10),
(23, 11),
(23, 12),
(23, 13),
(23, 14),
(23, 51),
(23, 52),
(23, 53),
(23, 54),
(23, 55),
(23, 56),
(23, 57),
(23, 58),
(23, 59),
(23, 60),
(23, 61),
(23, 62),
(23, 63),
(23, 64),
(23, 65),
(23, 66),
(23, 67),
(23, 68),
(23, 69),
(23, 70),
(23, 71),
(23, 72),
(23, 73),
(23, 74),
(23, 75),
(23, 76),
(23, 77),
(23, 78),
(23, 79),
(23, 80),
(24, 1),
(24, 2),
(24, 3),
(24, 4),
(24, 39),
(24, 40),
(24, 41),
(24, 42),
(24, 43),
(24, 44),
(24, 45),
(24, 46),
(28, 1),
(28, 39),
(28, 40),
(28, 41),
(28, 42),
(28, 43),
(28, 44),
(28, 45),
(28, 46),
(28, 85),
(31, 1),
(31, 2),
(31, 3),
(31, 4),
(31, 75),
(31, 76),
(31, 77),
(31, 78),
(31, 84),
(32, 1),
(32, 2),
(32, 3),
(32, 4),
(32, 39),
(32, 40),
(32, 41),
(32, 42),
(32, 43),
(32, 44),
(32, 45),
(32, 46),
(32, 47),
(32, 48),
(32, 49),
(32, 50),
(32, 51),
(32, 52),
(32, 53),
(32, 54),
(32, 55),
(32, 56),
(32, 57),
(32, 58),
(32, 59),
(32, 60),
(32, 61),
(32, 62),
(32, 63),
(32, 64),
(32, 65),
(32, 66),
(32, 75),
(32, 76),
(32, 77),
(32, 78),
(32, 79),
(32, 80),
(32, 81),
(32, 82),
(32, 83),
(33, 83),
(34, 1),
(34, 2),
(34, 3),
(34, 4),
(34, 84),
(34, 85),
(34, 86),
(35, 1),
(35, 2),
(35, 3),
(35, 4),
(35, 127),
(35, 312),
(35, 313),
(35, 314),
(35, 315),
(35, 316),
(35, 317),
(35, 318),
(35, 319),
(35, 320),
(35, 321),
(35, 322),
(35, 323),
(35, 324),
(35, 325),
(35, 326),
(35, 327),
(35, 328),
(35, 329),
(35, 330),
(35, 331),
(35, 332),
(35, 333),
(35, 334),
(35, 335),
(35, 336),
(35, 337),
(35, 338),
(35, 339),
(35, 340),
(35, 341),
(35, 342),
(35, 343),
(35, 344),
(35, 345),
(35, 346),
(35, 348),
(35, 349),
(35, 350),
(35, 351),
(35, 352),
(35, 353),
(35, 354),
(35, 355),
(35, 356),
(35, 357),
(35, 358),
(35, 359),
(35, 360),
(35, 361),
(35, 362),
(35, 363),
(35, 364),
(35, 365),
(35, 366),
(35, 367),
(35, 368),
(35, 369),
(35, 370),
(35, 371),
(35, 377),
(35, 378),
(35, 379),
(35, 380),
(35, 381),
(35, 382),
(35, 383),
(35, 384),
(35, 385),
(35, 386),
(35, 387),
(35, 388),
(35, 389),
(35, 390),
(35, 391),
(35, 392),
(35, 393),
(35, 394),
(35, 395),
(35, 396),
(35, 397),
(35, 398),
(35, 399),
(35, 400),
(35, 401),
(35, 402),
(35, 403),
(35, 404),
(35, 405),
(35, 406),
(35, 407),
(35, 408),
(35, 409),
(35, 410),
(35, 411),
(35, 412),
(35, 413),
(35, 414),
(35, 415),
(35, 416),
(35, 417),
(35, 418),
(35, 419),
(35, 420),
(35, 421),
(35, 422),
(35, 423),
(35, 424),
(35, 427),
(35, 428),
(35, 430),
(35, 431),
(35, 432),
(35, 433),
(35, 434),
(35, 435),
(35, 436),
(35, 437),
(35, 438),
(35, 439),
(35, 440),
(35, 441),
(35, 442),
(35, 443),
(35, 444);

-- --------------------------------------------------------

--
-- Table structure for table `roles_sys_modules`
--

CREATE TABLE `roles_sys_modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `sys_module_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `distance` decimal(20,3) DEFAULT NULL,
  `added_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `from`, `to`, `distance`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Morogoro', 'Dar es Salaam', '184.200', '19', '2022-04-23 17:16:58', '2022-04-23 17:16:58'),
(2, 'Dar es Salaam', 'Dodoma', '445.000', '19', '2022-04-23 17:51:45', '2022-04-23 17:51:45'),
(3, 'Dar es Salaam', 'Arusha', '624.300', '19', '2022-04-23 17:52:09', '2022-04-23 17:54:36'),
(4, 'Dodoma', 'Arusha', '432.500', '19', '2022-04-23 17:53:48', '2022-04-23 17:55:31'),
(5, 'Arusha', 'Kilimanjaro', '83.000', '19', '2022-04-25 13:46:44', '2022-04-25 13:46:44'),
(6, 'Pwani', 'Njombe', '780.000', '19', '2022-04-26 18:21:43', '2022-04-26 18:21:43'),
(7, 'Kigoma', 'Pwani', '1021.000', '19', '2022-04-28 23:05:24', '2022-04-28 23:05:24'),
(8, 'Arusha', 'Dar es Salaam', '624.000', '19', '2022-04-28 23:18:59', '2022-04-28 23:18:59'),
(9, 'Pwani', 'Dar es Salaam', '100.000', '1', '2022-05-11 21:19:45', '2022-05-11 21:19:45'),
(10, 'Shinyanga', 'Kigoma', '400.000', '53', '2022-05-17 14:31:07', '2022-05-17 14:31:07'),
(11, 'Dodoma', 'Mwanza', '687.000', '1', '2022-05-20 21:14:58', '2022-05-20 21:14:58'),
(12, 'Mwanza', 'Arusha', '220.000', '1', '2022-05-23 22:57:06', '2022-05-23 22:57:06'),
(13, 'Dar es Salaam', 'Njombe', '771.100', '1', '2022-05-24 17:18:21', '2022-05-24 17:19:33');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sale` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `payment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `due_date` date NOT NULL,
  `payment_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `user_id`, `farmer_id`, `product_id`, `sale`, `cost`, `payment`, `due_date`, `payment_status`, `status`, `created_at`, `updated_at`) VALUES
(8, 1, 3, 1, 4, 15000, 'grant', '0000-00-00', '', 'confirmed', '2022-02-18 07:22:13', '2022-02-19 14:24:28'),
(9, 1, 2, 1, 4, 15000, 'loan', '0000-00-00', '', 'confirmed', '2022-02-18 08:03:28', '2022-02-19 14:24:28');

-- --------------------------------------------------------

--
-- Table structure for table `sales_items`
--

CREATE TABLE `sales_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seed_invoice`
--

CREATE TABLE `seed_invoice` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT 'Seed',
  `reference` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `due_date` date NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exchange_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` decimal(8,2) NOT NULL,
  `purchase_amount` decimal(20,2) NOT NULL,
  `due_amount` decimal(20,2) NOT NULL,
  `purchase_tax` decimal(20,2) NOT NULL,
  `status` int(11) NOT NULL,
  `good_receive` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seed_invoice`
--

INSERT INTO `seed_invoice` (`id`, `reference_no`, `type`, `reference`, `supplier_id`, `purchase_date`, `due_date`, `location`, `exchange_code`, `exchange_rate`, `purchase_amount`, `due_amount`, `purchase_tax`, `status`, `good_receive`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'INV_SEED-1-2022-06-02', 'Seed', '1115', '1', '2022-05-26', '2022-05-28', NULL, 'USD', '2300.00', '17500.00', '17500.00', '0.00', 1, '1', 50, '2022-05-26 15:18:48', '2022-05-26 15:18:48'),
(2, 'INV_SEED-2-2022-05-26', 'Seed', '45875', '1', '2022-05-26', '2022-05-26', NULL, 'TZS', '1.00', '7500000.00', '8850000.00', '1350000.00', 1, '1', 50, '2022-05-26 17:13:19', '2022-05-26 17:13:19');

-- --------------------------------------------------------

--
-- Table structure for table `seed_invoice_history`
--

CREATE TABLE `seed_invoice_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `supplier_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seed_invoice_history`
--

INSERT INTO `seed_invoice_history` (`id`, `invoice_id`, `items_id`, `quantity`, `supplier_id`, `purchase_date`, `location`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', 1, '10.00', '1', '2022-06-02', NULL, 50, '2022-05-26 15:18:48', '2022-05-26 15:18:48'),
(2, '1', 2, '20.00', '1', '2022-06-02', NULL, 50, '2022-05-26 15:18:48', '2022-05-26 15:18:48'),
(3, '2', 1, '10000.00', '1', '2022-05-26', NULL, 50, '2022-05-26 17:13:19', '2022-05-26 17:13:19');

-- --------------------------------------------------------

--
-- Table structure for table `seed_invoice_item`
--

CREATE TABLE `seed_invoice_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_rate` decimal(8,2) NOT NULL,
  `total_tax` decimal(8,2) NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `total_cost` decimal(8,2) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL,
  `order_no` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seed_invoice_item`
--

INSERT INTO `seed_invoice_item` (`id`, `invoice_id`, `item_name`, `tax_rate`, `total_tax`, `quantity`, `total_cost`, `price`, `unit`, `items_id`, `order_no`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', '1', '0.00', '0.00', '10.00', '7500.00', '750.00', 'kgs', 1, 0, 50, '2022-05-26 15:18:48', '2022-05-26 15:18:48'),
(2, '1', '2', '0.00', '0.00', '20.00', '10000.00', '500.00', 'kgs', 2, 1, 50, '2022-05-26 15:18:48', '2022-05-26 15:18:48'),
(3, '2', '1', '0.18', '999999.99', '10000.00', '999999.99', '750.00', 'kgs', 1, 0, 50, '2022-05-26 17:13:19', '2022-05-26 17:13:19');

-- --------------------------------------------------------

--
-- Table structure for table `seed_lists`
--

CREATE TABLE `seed_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `unit` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(200) DEFAULT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seed_lists`
--

INSERT INTO `seed_lists` (`id`, `name`, `price`, `unit`, `quantity`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Seed', '750.00', 'kgs', NULL, 50, '2022-05-26 15:17:41', '2022-05-26 15:17:41'),
(2, 'Dust', '500.00', 'kgs', NULL, 50, '2022-05-26 15:18:03', '2022-05-26 15:18:03');

-- --------------------------------------------------------

--
-- Table structure for table `seed_payments`
--

CREATE TABLE `seed_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trans_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `date` date NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `truck` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `truck_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mechanical` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `reading` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `history` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `major` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `truck`, `truck_name`, `driver`, `mechanical`, `date`, `reading`, `history`, `major`, `status`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', 'Scania', '1', '1', '2022-04-06', '6000', 'ff', '12000', 1, 19, '2022-04-06 13:35:34', '2022-04-06 13:36:56'),
(2, '1', 'Scania', '', '16', '2022-04-24', '7820', 'rrtththg hgh', '12300', 0, 1, '2022-04-12 13:19:40', '2022-05-20 12:39:07');

-- --------------------------------------------------------

--
-- Table structure for table `service_items`
--

CREATE TABLE `service_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `truck` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_id` int(11) NOT NULL,
  `minor` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `order_no` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_items`
--

INSERT INTO `service_items` (`id`, `truck`, `service_id`, `minor`, `added_by`, `order_no`, `created_at`, `updated_at`) VALUES
(1, '1', 1, 'eletrical', 19, 0, '2022-04-06 13:35:34', '2022-04-06 13:35:34'),
(2, '1', 1, 'pumpu', 19, 1, '2022-04-06 13:35:34', '2022-04-06 13:35:34'),
(3, '1', 1, 'engine', 19, 2, '2022-04-06 13:35:34', '2022-04-06 13:35:34'),
(4, '1', 2, 'fillter', 1, 0, '2022-04-12 13:19:40', '2022-05-20 12:39:07'),
(5, '1', 2, 'gracre', 1, 1, '2022-04-12 13:19:40', '2022-05-20 12:39:07'),
(6, '1', 2, 'pllug', 1, 2, '2022-04-12 13:19:40', '2022-05-20 12:39:07');

-- --------------------------------------------------------

--
-- Table structure for table `service_report`
--

CREATE TABLE `service_report` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_no` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_report`
--

INSERT INTO `service_report` (`id`, `service_id`, `item_name`, `order_no`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '2', '1', 0, 1, '2022-05-20 12:37:26', '2022-05-20 12:39:07');

-- --------------------------------------------------------

--
-- Table structure for table `stickers`
--

CREATE TABLE `stickers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `issue_date` date NOT NULL,
  `expire_date` date NOT NULL,
  `office` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(8,2) NOT NULL,
  `officer` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `truck_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stickers`
--

INSERT INTO `stickers` (`id`, `issue_date`, `expire_date`, `office`, `value`, `officer`, `truck_id`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '2022-05-17', '2022-06-04', 'HHHH', '450000.00', 'JJ', '9', 53, '2022-05-17 13:28:52', '2022-05-17 13:28:52');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TIN` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `user_id`, `name`, `address`, `phone`, `TIN`, `email`, `created_at`, `updated_at`) VALUES
(1, '1', 'unknown', 'kigoma,ujiji mjini', '0677278940', 'TZ 12334bt', 'george@hmail.com', NULL, NULL),
(4, '1', 'Charles', 'Malando', '0977657367', 'TZ 87373642987 MT', 'george@test.com', '2022-02-07 12:01:33', '2022-02-07 12:01:33'),
(6, '1', 'Ujuzinet', 'Kijitonyama , Dar es Salaam', '+255713000000', '14111111116', 'ujuzinet@gmail.com', '2022-04-20 12:40:09', '2022-04-20 12:40:09'),
(7, '1', 'Mussa Kombe', 'kigoma,ujiji mjini', '0677278940', 'TZ 12334bt', 'george@hmail.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `system_control`
--

CREATE TABLE `system_control` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `picture` varchar(500) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tin` varchar(100) DEFAULT NULL,
  `vat` varchar(100) DEFAULT NULL,
  `added_by` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `system_control`
--

INSERT INTO `system_control` (`id`, `name`, `picture`, `address`, `phone`, `email`, `tin`, `vat`, `added_by`) VALUES
(4, 'EMA Systems', '903180522025427.PNG', 'Dar es Salaam', '0655973248', 'info@ema.co.tz', '152-626-320', '-', 1),
(5, 'Fleet Managements Systems', '844070422055139.jpeg', 'Costech House 3rd Floor Room 9', '0712722684', '-', '-', '-', 19);

-- --------------------------------------------------------

--
-- Table structure for table `sys_modules`
--

CREATE TABLE `sys_modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sys_modules`
--

INSERT INTO `sys_modules` (`id`, `slug`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'manage-dashboard', '2022-05-14 13:05:20', '2022-05-14 13:05:20', NULL),
(2, 'manage-farmer', '2022-05-14 13:05:20', '2022-05-14 13:05:20', NULL),
(3, 'manage-farming', '2022-05-14 13:05:20', '2022-05-14 13:05:20', NULL),
(4, 'manage-orders', '2022-05-14 13:05:20', '2022-05-14 13:05:20', NULL),
(5, 'manage-warehouse', '2022-05-14 13:05:20', '2022-05-14 13:05:20', NULL),
(6, 'manage-shop', '2022-05-14 13:05:20', '2022-05-14 13:05:20', NULL),
(7, 'manage-fuel', '2022-05-14 13:05:20', '2022-05-14 13:05:20', NULL),
(8, 'manage-access-control', '2022-05-14 13:05:20', '2022-05-14 13:05:20', NULL),
(9, 'manage-accounting', '2022-05-14 13:05:20', '2022-05-14 13:05:20', NULL),
(10, 'manage-gl-setup', '2022-05-14 13:05:20', '2022-05-14 13:05:20', NULL),
(11, 'manage-transaction', '2022-05-14 13:05:20', '2022-05-14 13:05:20', NULL),
(12, 'manage-leave', '2022-05-14 13:05:20', '2022-05-14 13:05:20', NULL),
(13, 'manage-training', '2022-05-14 13:05:20', '2022-05-14 13:05:20', NULL),
(14, 'manage-inventory', '2022-05-14 13:05:20', '2022-05-14 13:05:20', NULL),
(15, 'manage-logistic', '2022-05-14 13:05:20', '2022-05-14 13:05:20', NULL),
(16, 'manage-payroll', '2022-05-14 13:05:20', '2022-05-14 13:05:20', NULL),
(17, 'manage-courier', '2022-05-14 13:05:20', '2022-05-14 13:05:20', NULL),
(18, 'manage-cotton', '2022-05-16 11:20:26', '2022-05-16 11:20:26', NULL),
(19, 'manage-pharmacy', '2022-06-01 19:41:19', '2022-06-01 19:41:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account_details`
--

CREATE TABLE `tbl_account_details` (
  `id` int(200) NOT NULL,
  `account_id` int(11) NOT NULL,
  `account_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `balance` decimal(20,2) NOT NULL DEFAULT 0.00,
  `exchange_code` varchar(200) COLLATE utf8_unicode_ci DEFAULT 'TZS',
  `account_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_person` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_advance_salary`
--

CREATE TABLE `tbl_advance_salary` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `advance_amount` varchar(200) NOT NULL,
  `deduct_month` varchar(30) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `request_date` date DEFAULT current_timestamp(),
  `status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0 =pending,1=accpect , 2 = reject and 3 = paid',
  `approve_by` int(11) DEFAULT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_advance_salary`
--

INSERT INTO `tbl_advance_salary` (`id`, `user_id`, `advance_amount`, `deduct_month`, `reason`, `request_date`, `status`, `approve_by`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 19, '100000', '2022-02', 'family emergency', '2022-01-25', 3, 1, 1, '2022-05-08 15:00:45', '2022-05-08 17:20:21'),
(2, 19, '2330', '2022-05', 'Gjjj', '2022-05-08', 1, 1, 19, '2022-05-08 18:52:31', '2022-05-09 17:16:24'),
(3, 20, '250000', '2022-05', 'Sick', '2022-05-08', 1, 1, 1, '2022-05-08 23:22:41', '2022-05-08 23:22:41');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_corops_monitoring`
--

CREATE TABLE `tbl_corops_monitoring` (
  `id` int(100) NOT NULL,
  `name` int(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `course` varchar(300) NOT NULL,
  `symptoms` varchar(300) NOT NULL,
  `attachment` varchar(100) DEFAULT NULL,
  `status` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_costants`
--

CREATE TABLE `tbl_costants` (
  `id` int(100) NOT NULL,
  `cotton` varchar(100) DEFAULT NULL,
  `seeds` int(100) DEFAULT NULL,
  `raw_cotton` int(100) DEFAULT NULL,
  `dust` int(100) DEFAULT NULL,
  `added_by` int(100) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_costants`
--

INSERT INTO `tbl_costants` (`id`, `cotton`, `seeds`, `raw_cotton`, `dust`, `added_by`, `updated_at`, `created_at`) VALUES
(4, '2', 4, 3, 3, NULL, '2022-05-25 10:33:01', '2022-05-25 10:33:01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cost_centres`
--

CREATE TABLE `tbl_cost_centres` (
  `id` int(100) NOT NULL,
  `code` int(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `costing` int(100) DEFAULT NULL,
  `user_id` int(100) NOT NULL,
  `updated_at` date NOT NULL DEFAULT current_timestamp(),
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_cost_centres`
--

INSERT INTO `tbl_cost_centres` (`id`, `code`, `name`, `costing`, `user_id`, `updated_at`, `created_at`) VALUES
(1, NULL, 'farming', 10000, 1, '2022-02-20', '2022-02-20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cost_functions`
--

CREATE TABLE `tbl_cost_functions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `price` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_cost_functions`
--

INSERT INTO `tbl_cost_functions` (`id`, `price`, `name`, `description`, `unit`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1000, 'Fuel', 'Fuel', 'litre', '1', NULL, NULL),
(2, 100000, 'ushuru', 'ushuru', 'pc', '19', NULL, NULL),
(3, 100, 'transportation cost per KM', 'transportation cost per KM', '', '19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cotton`
--

CREATE TABLE `tbl_cotton` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_cotton`
--

INSERT INTO `tbl_cotton` (`id`, `name`, `unit`, `quantity`, `price`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Cotton', 'kg', NULL, '2000.00', 50, '2022-05-17 15:56:42', '2022-05-17 15:56:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_crops_monitoring`
--

CREATE TABLE `tbl_crops_monitoring` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `module` varchar(200) DEFAULT 'Crop Monitoring',
  `module_id` varchar(200) DEFAULT NULL,
  `season_id` int(200) DEFAULT NULL,
  `type` varchar(100) NOT NULL,
  `farm_id` int(100) NOT NULL,
  `course` varchar(300) NOT NULL,
  `symptoms` varchar(300) NOT NULL,
  `attachment` varchar(100) DEFAULT NULL,
  `status` int(100) DEFAULT 0,
  `added_by` int(100) NOT NULL,
  `updated_at` date NOT NULL DEFAULT current_timestamp(),
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_crops_monitoring`
--

INSERT INTO `tbl_crops_monitoring` (`id`, `name`, `module`, `module_id`, `season_id`, `type`, `farm_id`, `course`, `symptoms`, `attachment`, `status`, `added_by`, `updated_at`, `created_at`) VALUES
(1, 'one', 'Crop Monitoring', NULL, NULL, 'Disseases', 2, 'we', 'we', NULL, 1, 20, '2022-04-11', '2022-04-11'),
(2, 'two', 'preparation', '13', 7, 'Weeds', 5, 'test course', 'yellow', NULL, 0, 20, '2022-04-11', '2022-04-11'),
(4, 'program A', 'preparation', '14', 7, 'Disseases', 5, 'aaa', 'bbb', NULL, 0, 20, '2022-04-11', '2022-04-11'),
(5, 'program B', 'program', '3', 7, 'Disseases', 2, 'aaa', 'yellow', NULL, 0, 20, '2022-04-11', '2022-04-11'),
(7, 'YAPI MERKE7I', 'program', '2', 9, 'Disseases', 8, 'test', 'test', NULL, 0, 39, '2022-04-21', '2022-04-21'),
(8, 'mbegu hazijaota', 'sowing', '2', 10, 'Disseases', 9, 'diaseses', 'mbegu zimeliwa', NULL, 0, 20, '2022-05-11', '2022-05-11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_crops_types`
--

CREATE TABLE `tbl_crops_types` (
  `id` int(100) NOT NULL,
  `crop_name` varchar(100) NOT NULL,
  `crop_category` varchar(200) NOT NULL,
  `storage_type` varchar(100) NOT NULL,
  `status` int(100) NOT NULL,
  `added_by` int(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_crops_types`
--

INSERT INTO `tbl_crops_types` (`id`, `crop_name`, `crop_category`, `storage_type`, `status`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Maize', 'Non Grain', 'kusindika', 2, 1, '2022-04-04 17:01:10', '2022-04-04 21:04:38'),
(4, 'Beans', 'Non Grain', 'kubambika', 1, 1, '2022-04-04 17:01:10', '2022-04-04 21:03:55'),
(5, 'Rice', 'Grain', 'kusindika', 0, 1, '2022-04-04 21:02:35', '2022-04-04 21:02:35'),
(6, 'White', 'Grain', '-', 0, 20, '2022-04-12 19:49:55', '2022-04-12 19:49:55'),
(7, 'test crop', 'Grain', 'tanks', 0, 20, '2022-05-09 17:41:25', '2022-05-09 17:41:25'),
(8, 'Mtama', 'Grain', 'Tanks Storage', 0, 20, '2022-05-09 19:42:19', '2022-05-09 19:42:19'),
(9, 'Karanga', 'Grain', 'Tanks starage', 0, 20, '2022-05-09 20:25:34', '2022-05-09 20:25:34'),
(10, 'Banana', 'Non Grain', 'kreat', 0, 20, '2022-05-11 21:03:23', '2022-05-11 21:03:23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_currencies`
--

CREATE TABLE `tbl_currencies` (
  `code` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `symbol` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `xrate` decimal(12,5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_currencies`
--

INSERT INTO `tbl_currencies` (`code`, `name`, `symbol`, `xrate`) VALUES
('AUD', 'Australian Dollar', '$', NULL),
('BAN', 'Bangladesh', 'BDT', NULL),
('BRL', 'Brazilian Real', 'R$', NULL),
('CAD', 'Canadian Dollar', '$', NULL),
('CHF', 'Swiss Franc', 'Fr', NULL),
('CLP', 'Chilean Peso', '$', NULL),
('CNY', 'Chinese Yuan', 'Ã‚Â¥', NULL),
('CZK', 'Czech Koruna', 'KÃ„', NULL),
('DKK', 'Danish Krone', 'kr', NULL),
('EUR', 'Euro', 'Ã¢â€š', NULL),
('GBP', 'British Pound', 'Ã‚Â£', NULL),
('HKD', 'Hong Kong Dollar', '$', NULL),
('HUF', 'Hungarian Forint', 'Ft', NULL),
('IDR', 'Indonesian Rupiah', 'Rp', NULL),
('ILS', 'Israeli New Shekel', 'Ã¢â€š', NULL),
('INR', 'Indian Rupee', 'Ã Â¤Â', NULL),
('JPY', 'Japanese Yen', 'Ã‚Â¥', NULL),
('KRW', 'Korean Won', 'Ã¢â€š', NULL),
('MXN', 'Mexican Peso', '$', NULL),
('MYR', 'Malaysian Ringgit', 'RM', NULL),
('NOK', 'Norwegian Krone', 'kr', NULL),
('NZD', 'New Zealand Dollar', '$', NULL),
('PHP', 'Philippine Peso', 'Ã¢â€š', NULL),
('PKR', 'Pakistan Rupee', 'PKR', NULL),
('PLN', 'Polish Zloty', 'zl', NULL),
('RUB', 'Russian Ruble', ' RUB', NULL),
('SEK', 'Swedish Krona', 'kr', NULL),
('SGD', 'Singapore Dollar', 'S$', NULL),
('THB', 'Thai Baht', 'Ã Â¸Â', NULL),
('TRY', 'Turkish Lira', ' TRY', NULL),
('TWD', 'Taiwan Dollar', 'NT$', NULL),
('TZS', 'Tanzania Shiling', 'TZS', NULL),
('USD', 'US Dollar', '$', '1.00000'),
('VEF', 'Bol?var Fuerte', 'Bs.', NULL),
('ZAR', 'South African Rand', 'R', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_deposit`
--

CREATE TABLE `tbl_deposit` (
  `id` int(11) NOT NULL,
  `bank_id` varchar(200) NOT NULL,
  `account_id` varchar(500) NOT NULL,
  `name` varchar(500) DEFAULT NULL,
  `date` date NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `notes` varchar(500) DEFAULT NULL,
  `trans_id` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL,
  `status` varchar(200) DEFAULT NULL,
  `exchange_rate` decimal(20,2) DEFAULT 1.00,
  `exchange_code` varchar(200) DEFAULT 'TZS',
  `payment_method` varchar(200) DEFAULT NULL,
  `added_by` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_deposit`
--

INSERT INTO `tbl_deposit` (`id`, `bank_id`, `account_id`, `name`, `date`, `amount`, `notes`, `trans_id`, `type`, `status`, `exchange_rate`, `exchange_code`, `payment_method`, `added_by`) VALUES
(1, '6', '4', '1111', '2022-05-18', '150000000.00', 'Bales Payment', 'TRANS_DEP_Lo3k', ' Deposit', '0', NULL, NULL, NULL, 1),
(2, '6', '33', '1112', '2022-05-23', '35000.00', 'repair', 'TRANS_DEP_IP5v', ' Deposit', '1', '1.00', 'TZS', '3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_deposite_withdraw`
--

CREATE TABLE `tbl_deposite_withdraw` (
  `id` int(100) NOT NULL,
  `farm_account_id` int(100) NOT NULL,
  `warehouse_id` int(100) NOT NULL,
  `quantity` decimal(65,0) NOT NULL,
  `cost` int(100) DEFAULT 0,
  `status` int(11) NOT NULL COMMENT 'if 1 withdraw, 2 diposite',
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_deposite_withdraw`
--

INSERT INTO `tbl_deposite_withdraw` (`id`, `farm_account_id`, `warehouse_id`, `quantity`, `cost`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '1234', 0, 2, '2022-02-23 14:41:56.000000', '2022-02-23 14:41:56.000000'),
(2, 1, 1, '1234', 0, 2, '2022-02-23 14:43:05.000000', '2022-02-23 14:43:05.000000'),
(3, 1, 1, '1234', 0, 2, '2022-02-23 14:44:33.000000', '2022-02-23 14:44:33.000000'),
(4, 1, 1, '1234', 0, 2, '2022-02-23 19:49:57.000000', '2022-02-23 19:49:57.000000'),
(5, 1, 1, '123454', 12345, 2, '2022-02-23 20:17:48.000000', '2022-02-23 20:17:48.000000'),
(6, 1, 1, '1234', 123344, 2, '2022-02-23 20:21:58.000000', '2022-02-23 20:21:58.000000'),
(7, 1, 1, '32000', NULL, 1, '2022-02-23 20:45:36.000000', '2022-02-23 20:45:36.000000'),
(8, 1, 1, '1234', 123344, 2, '2022-02-24 13:16:08.000000', '2022-02-24 13:16:08.000000'),
(9, 1, 1, '1234', 123344, 2, '2022-02-24 13:19:03.000000', '2022-02-24 13:19:03.000000'),
(10, 4, 1, '1234', 123344, 2, '2022-02-24 13:20:19.000000', '2022-02-24 13:20:19.000000'),
(11, 1, 1, '123400', 999, 2, '2022-02-24 13:22:42.000000', '2022-02-24 13:22:42.000000'),
(12, 1, 1, '32000', NULL, 1, '2022-02-24 13:37:43.000000', '2022-02-24 13:37:43.000000'),
(13, 6, 1, '1234', 123344, 2, '2022-02-24 18:05:55.000000', '2022-02-24 18:05:55.000000'),
(14, 5, 2, '1234000', 8000, 2, '2022-02-24 18:06:50.000000', '2022-02-24 18:06:50.000000'),
(1, 1, 1, '1234', 0, 2, '2022-02-23 14:41:56.000000', '2022-02-23 14:41:56.000000'),
(2, 1, 1, '1234', 0, 2, '2022-02-23 14:43:05.000000', '2022-02-23 14:43:05.000000'),
(3, 1, 1, '1234', 0, 2, '2022-02-23 14:44:33.000000', '2022-02-23 14:44:33.000000'),
(4, 1, 1, '1234', 0, 2, '2022-02-23 19:49:57.000000', '2022-02-23 19:49:57.000000'),
(5, 1, 1, '123454', 12345, 2, '2022-02-23 20:17:48.000000', '2022-02-23 20:17:48.000000'),
(6, 1, 1, '1234', 123344, 2, '2022-02-23 20:21:58.000000', '2022-02-23 20:21:58.000000'),
(7, 1, 1, '32000', NULL, 1, '2022-02-23 20:45:36.000000', '2022-02-23 20:45:36.000000'),
(8, 1, 1, '1234', 123344, 2, '2022-02-24 13:16:08.000000', '2022-02-24 13:16:08.000000'),
(9, 1, 1, '1234', 123344, 2, '2022-02-24 13:19:03.000000', '2022-02-24 13:19:03.000000'),
(10, 4, 1, '1234', 123344, 2, '2022-02-24 13:20:19.000000', '2022-02-24 13:20:19.000000'),
(11, 1, 1, '123400', 999, 2, '2022-02-24 13:22:42.000000', '2022-02-24 13:22:42.000000'),
(12, 1, 1, '32000', NULL, 1, '2022-02-24 13:37:43.000000', '2022-02-24 13:37:43.000000'),
(13, 6, 1, '1234', 123344, 2, '2022-02-24 18:05:55.000000', '2022-02-24 18:05:55.000000'),
(14, 5, 2, '1234000', 8000, 2, '2022-02-24 18:06:50.000000', '2022-02-24 18:06:50.000000'),
(1, 1, 1, '1234', 0, 2, '2022-02-23 14:41:56.000000', '2022-02-23 14:41:56.000000'),
(2, 1, 1, '1234', 0, 2, '2022-02-23 14:43:05.000000', '2022-02-23 14:43:05.000000'),
(3, 1, 1, '1234', 0, 2, '2022-02-23 14:44:33.000000', '2022-02-23 14:44:33.000000'),
(4, 1, 1, '1234', 0, 2, '2022-02-23 19:49:57.000000', '2022-02-23 19:49:57.000000'),
(5, 1, 1, '123454', 12345, 2, '2022-02-23 20:17:48.000000', '2022-02-23 20:17:48.000000'),
(6, 1, 1, '1234', 123344, 2, '2022-02-23 20:21:58.000000', '2022-02-23 20:21:58.000000'),
(7, 1, 1, '32000', NULL, 1, '2022-02-23 20:45:36.000000', '2022-02-23 20:45:36.000000'),
(8, 1, 1, '1234', 123344, 2, '2022-02-24 13:16:08.000000', '2022-02-24 13:16:08.000000'),
(9, 1, 1, '1234', 123344, 2, '2022-02-24 13:19:03.000000', '2022-02-24 13:19:03.000000'),
(10, 4, 1, '1234', 123344, 2, '2022-02-24 13:20:19.000000', '2022-02-24 13:20:19.000000'),
(11, 1, 1, '123400', 999, 2, '2022-02-24 13:22:42.000000', '2022-02-24 13:22:42.000000'),
(12, 1, 1, '32000', NULL, 1, '2022-02-24 13:37:43.000000', '2022-02-24 13:37:43.000000'),
(13, 6, 1, '1234', 123344, 2, '2022-02-24 18:05:55.000000', '2022-02-24 18:05:55.000000'),
(14, 5, 2, '1234000', 8000, 2, '2022-02-24 18:06:50.000000', '2022-02-24 18:06:50.000000'),
(0, 1, 3, '1234', 123344, 2, '2022-03-22 11:23:19.000000', '2022-03-22 11:23:19.000000'),
(0, 6, 22, '2000000', 1900, 2, '2022-03-22 12:02:02.000000', '2022-03-22 12:02:02.000000'),
(0, 6, 22, '4000', NULL, 1, '2022-03-22 12:03:07.000000', '2022-03-22 12:03:07.000000'),
(0, 7, 22, '100000', 190, 2, '2022-03-22 21:41:10.000000', '2022-03-22 21:41:10.000000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_award`
--

CREATE TABLE `tbl_employee_award` (
  `id` int(11) NOT NULL,
  `award_name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gift_item` varchar(300) NOT NULL,
  `award_amount` int(5) NOT NULL,
  `award_date` varchar(10) NOT NULL,
  `status` varchar(200) NOT NULL DEFAULT '0' COMMENT '0=pending,1=approved,2=rejected,3=paid',
  `view` tinyint(1) DEFAULT 2 COMMENT '1=Read 2=Unread',
  `given_date` date DEFAULT NULL,
  `added_by` int(200) NOT NULL,
  `approve_by` int(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_loan`
--

CREATE TABLE `tbl_employee_loan` (
  `id` int(11) NOT NULL,
  `user_id` int(200) NOT NULL,
  `loan_amount` decimal(20,2) NOT NULL,
  `paid_amount` decimal(20,2) NOT NULL,
  `sponsor` varchar(200) DEFAULT NULL,
  `deduct_month` varchar(200) NOT NULL,
  `request_date` date DEFAULT current_timestamp(),
  `reason` text DEFAULT NULL,
  `returns` int(100) NOT NULL,
  `status` int(200) DEFAULT 0 COMMENT '0=pending,1=approved,2=reject,3-partially_paid,4=paid',
  `approve_by` int(200) DEFAULT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_employee_loan`
--

INSERT INTO `tbl_employee_loan` (`id`, `user_id`, `loan_amount`, `paid_amount`, `sponsor`, `deduct_month`, `request_date`, `reason`, `returns`, `status`, `approve_by`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 43, '1000000.00', '300000.00', NULL, '2022-04', '2022-05-08', 'Emergency', 4, 3, 1, 1, '2022-05-08 23:28:22', '2022-05-09 12:05:41');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_loan_returns`
--

CREATE TABLE `tbl_employee_loan_returns` (
  `id` int(11) NOT NULL,
  `loan_id` int(200) NOT NULL,
  `user_id` int(200) NOT NULL,
  `loan_amount` decimal(20,2) NOT NULL,
  `deduct_month` varchar(200) NOT NULL,
  `request_date` date DEFAULT NULL,
  `status` int(200) DEFAULT 0 COMMENT '0=pending,1=approved,2=reject,3=paid		',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_employee_loan_returns`
--

INSERT INTO `tbl_employee_loan_returns` (`id`, `loan_id`, `user_id`, `loan_amount`, `deduct_month`, `request_date`, `status`, `created_at`, `updated_at`) VALUES
(9, 1, 43, '300000.00', '2022-04', NULL, 3, '2022-05-08 23:35:49', '2022-05-09 00:17:06'),
(10, 1, 43, '300000.00', '2022-05', NULL, 3, '2022-05-08 23:35:49', '2022-05-09 12:05:41'),
(11, 1, 43, '300000.00', '2022-06', NULL, 1, '2022-05-08 23:35:49', '2022-05-08 23:35:49'),
(12, 1, 43, '100000.00', '2022-07', NULL, 1, '2022-05-08 23:35:49', '2022-05-08 23:35:49');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_payroll`
--

CREATE TABLE `tbl_employee_payroll` (
  `payroll_id` int(200) NOT NULL,
  `user_id` int(200) NOT NULL,
  `department_id` varchar(200) NOT NULL,
  `salary_template_id` int(200) DEFAULT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_employee_payroll`
--

INSERT INTO `tbl_employee_payroll` (`payroll_id`, `user_id`, `department_id`, `salary_template_id`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 19, '5', 3, 19, '2022-05-09 14:38:51', '2022-05-09 16:12:53'),
(2, 20, '5', 2, 19, '2022-05-09 14:38:51', '2022-05-09 16:12:53'),
(3, 43, '1', 1, 19, '2022-05-09 14:44:15', '2022-05-09 16:13:20'),
(4, 45, '4', 2, 19, '2022-05-11 15:50:23', '2022-05-11 15:50:23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expenses`
--

CREATE TABLE `tbl_expenses` (
  `id` int(11) NOT NULL,
  `bank_id` varchar(200) NOT NULL,
  `account_id` varchar(500) NOT NULL,
  `name` varchar(500) DEFAULT NULL,
  `date` date NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `notes` varchar(500) DEFAULT NULL,
  `trans_id` varchar(200) NOT NULL,
  `type` varchar(500) NOT NULL,
  `status` varchar(200) NOT NULL,
  `exchange_rate` decimal(20,2) DEFAULT 1.00,
  `exchange_code` varchar(200) DEFAULT 'TZS',
  `payment_method` varchar(200) DEFAULT NULL,
  `added_by` int(200) NOT NULL,
  `refill_id` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_expenses`
--

INSERT INTO `tbl_expenses` (`id`, `bank_id`, `account_id`, `name`, `date`, `amount`, `notes`, `trans_id`, `type`, `status`, `exchange_rate`, `exchange_code`, `payment_method`, `added_by`, `refill_id`) VALUES
(1, '16', '19', 'Fuel Refill on Credit', '2022-04-28', '484948.80', 'Fuel Refill  on Credit for Truck Scania Mende 12345', 'TRANS_EXP_qvic', 'Expenses', '1', '1.00', 'TZS', NULL, 19, 1),
(2, '6', '34', 'test suppler expense', '2022-05-03', '40000.00', 'Hello', 'TRANS_EXP_BdfM', 'Expenses', '1', '1.00', 'TZS', '3', 19, NULL),
(3, '16', '19', 'Fuel Refill on Credit', '2022-05-17', '155000.00', 'Fuel Refill  on Credit for Truck T711 CFS SCANIA', 'TRANS_EXP_IMX1', 'Expenses', '1', '1.00', 'TZS', NULL, 53, 3),
(4, '7', '30', 'office expenses', '2022-05-23', '10000.00', NULL, 'TRANS_EXP_7Hpg', 'Expenses', '1', '1.00', 'TZS', '2', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_farmer_accounts`
--

CREATE TABLE `tbl_farmer_accounts` (
  `id` int(100) NOT NULL,
  `farmer_id` int(100) NOT NULL,
  `warehouse_id` int(100) NOT NULL,
  `crops_type_id` int(100) NOT NULL,
  `total_quantity` decimal(65,0) NOT NULL,
  `updated_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_farmer_accounts`
--

INSERT INTO `tbl_farmer_accounts` (`id`, `farmer_id`, `warehouse_id`, `crops_type_id`, `total_quantity`, `updated_at`, `created_at`) VALUES
(1, 2, 3, 4, '10697164404', '2022-03-22 11:23:18.000000', '2022-03-03 10:03:27.000000'),
(2, 3, 3, 4, '1234', '2022-03-03 11:57:49.000000', '2022-03-03 10:04:04.000000'),
(3, 4, 3, 3, '1000', '2022-03-03 11:57:16.000000', '2022-03-03 11:56:32.000000'),
(4, 3, 3, 3, '0', '2022-03-21 06:58:25.000000', '2022-03-21 06:58:25.000000'),
(5, 2, 21, 3, '0', '2022-03-22 11:41:25.000000', '2022-03-22 11:41:25.000000'),
(6, 6, 22, 3, '1996000', '2022-03-22 12:03:07.000000', '2022-03-22 12:01:36.000000'),
(7, 4, 22, 4, '100000', '2022-03-22 21:41:10.000000', '2022-03-22 12:03:36.000000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_farming_costing`
--

CREATE TABLE `tbl_farming_costing` (
  `id` int(100) NOT NULL,
  `farm_id` int(100) DEFAULT NULL,
  `farmer_id` int(100) DEFAULT NULL,
  `user_id` int(100) DEFAULT NULL,
  `updated_at` date NOT NULL DEFAULT current_timestamp(),
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_farming_costing`
--

INSERT INTO `tbl_farming_costing` (`id`, `farm_id`, `farmer_id`, `user_id`, `updated_at`, `created_at`) VALUES
(1, 1, 6, 1, '2022-03-22', '2022-03-22'),
(4, 1, 6, 20, '2022-03-22', '2022-03-22'),
(5, 1, 6, 20, '2022-03-22', '2022-03-22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_farming_cost_items`
--

CREATE TABLE `tbl_farming_cost_items` (
  `id` int(11) NOT NULL,
  `farming_cost_id` int(11) NOT NULL,
  `tax_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_tax` decimal(20,2) NOT NULL DEFAULT 0.00,
  `quantity` decimal(10,2) DEFAULT 0.00,
  `total_cost` decimal(20,2) NOT NULL DEFAULT 0.00,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `unit` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL DEFAULT 0,
  `order_no` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_farming_cost_items`
--

INSERT INTO `tbl_farming_cost_items` (`id`, `farming_cost_id`, `tax_rate`, `total_tax`, `quantity`, `total_cost`, `item_name`, `price`, `unit`, `items_id`, `order_no`, `created_at`, `updated_at`) VALUES
(45, 4, '0.00', '0.00', '50000.00', '75000000000.00', '4', '1500000.00', 'tons/lime', 4, 0, '2022-03-22 14:06:39', '2022-03-22 14:06:39'),
(46, 4, '0.00', '0.00', '65.00', '325000.00', '3', '5000.00', 'kgs', 3, 1, '2022-03-22 14:06:39', '2022-03-22 14:06:39'),
(47, 4, '0.00', '0.00', '10.00', '1800000.00', '5', '180000.00', 'lot', 5, 2, '2022-03-22 14:06:39', '2022-03-22 14:06:39'),
(48, 4, '0.00', '0.00', '10.00', '2500000.00', '6', '250000.00', 'hk', 6, 3, '2022-03-22 14:06:39', '2022-03-22 14:06:39'),
(49, 4, '0.00', '0.00', '10.00', '1000000.00', '7', '100000.00', 'hk', 7, 4, '2022-03-22 14:06:39', '2022-03-22 14:06:39'),
(50, 4, '0.00', '0.00', '10.00', '500000.00', '8', '50000.00', 'hk', 8, 5, '2022-03-22 14:06:39', '2022-03-22 14:06:39'),
(51, 4, '0.00', '0.00', '10.00', '500000.00', '2', '50000.00', 'hk', 2, 6, '2022-03-22 14:06:39', '2022-03-22 14:06:39'),
(52, 5, '0.00', '0.00', '10.00', '500000.00', '2', '50000.00', 'hk', 2, 0, '2022-03-22 14:17:49', '2022-03-22 14:17:49'),
(53, 5, '0.00', '0.00', '40000.00', '48000000.00', '4', '1200.00', 'kg /Lime', 4, 1, '2022-03-22 14:17:49', '2022-03-22 14:17:49'),
(54, 5, '0.00', '0.00', '10.00', '50000.00', '3', '5000.00', 'kgs', 3, 2, '2022-03-22 14:17:49', '2022-03-22 14:17:49'),
(55, 5, '0.00', '0.00', '10.00', '150000.00', '4', '15000.00', 'kg', 4, 3, '2022-03-22 14:17:49', '2022-03-22 14:17:49'),
(56, 5, '0.00', '0.00', '10.00', '1800000.00', '5', '180000.00', 'hk', 5, 4, '2022-03-22 14:17:49', '2022-03-22 14:17:49'),
(57, 5, '0.00', '0.00', '10.00', '2500000.00', '6', '250000.00', 'hk', 6, 5, '2022-03-22 14:17:49', '2022-03-22 14:17:49'),
(58, 5, '0.00', '0.00', '10.00', '200000.00', '7', '20000.00', 'kgs', 7, 6, '2022-03-22 14:17:49', '2022-03-22 14:17:49'),
(59, 5, '0.00', '0.00', '10.00', '1000000.00', '8', '100000.00', 'hk', 8, 7, '2022-03-22 14:17:49', '2022-03-22 14:17:49');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_farming_processes`
--

CREATE TABLE `tbl_farming_processes` (
  `id` int(100) NOT NULL,
  `process_name` varchar(100) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_farming_processes`
--

INSERT INTO `tbl_farming_processes` (`id`, `process_name`, `created_at`, `updated_at`) VALUES
(1, 'Weeding', '2022-02-20', '2022-03-22'),
(2, 'Land Preparation', '2022-03-22', '2022-03-22'),
(3, 'Sowing', '2022-03-22', '2022-03-22'),
(4, 'Manual and Fertizer', '2022-03-22', '2022-03-22'),
(5, 'Irrigation', '2022-03-22', '2022-03-22'),
(6, 'Pestside', '2022-03-22', '2022-03-22'),
(7, 'Pre-Harvest', '2022-03-22', '2022-03-22'),
(8, 'Post Harverst', '2022-03-22', '2022-03-22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fertilizers`
--

CREATE TABLE `tbl_fertilizers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `program` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `farming_process` int(11) NOT NULL,
  `fertilizer_amount` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `fertilizer_price` int(11) NOT NULL,
  `fertilizer_cost` int(11) NOT NULL,
  `no_hector` int(11) NOT NULL,
  `total_cost` decimal(20,2) NOT NULL,
  `seasson_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_insurances`
--

CREATE TABLE `tbl_insurances` (
  `id` int(100) NOT NULL,
  `insurance_name` varchar(100) NOT NULL,
  `insurance_type` varchar(100) NOT NULL,
  `asset_value` int(100) NOT NULL,
  `insurance_amount` int(100) NOT NULL,
  `cover_age` int(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `updated_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_insurances`
--

INSERT INTO `tbl_insurances` (`id`, `insurance_name`, `insurance_type`, `asset_value`, `insurance_amount`, `cover_age`, `start_date`, `end_date`, `updated_at`, `created_at`) VALUES
(1, 'NHIF', 'private', 2147483647, 50400, 5, '2022-03-03', '2022-03-11', '2022-03-22 11:14:52.000000', '2022-03-22 11:14:52.000000'),
(2, 'Jubilee Insurance Company', 'hired', 15000000, 52000, 1, '2022-01-01', '2022-12-30', '2022-03-22 11:58:52.000000', '2022-03-22 11:58:52.000000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_payments`
--

CREATE TABLE `tbl_invoice_payments` (
  `id` int(100) NOT NULL,
  `payment_methode_id` int(100) NOT NULL,
  `trans_id` varchar(100) NOT NULL,
  `client_id` int(100) DEFAULT NULL,
  `amount` int(100) NOT NULL,
  `due_amount` int(100) NOT NULL,
  `notes` varchar(100) NOT NULL,
  `invoice_id` int(100) DEFAULT NULL,
  `date` date NOT NULL,
  `updated_at` date DEFAULT current_timestamp(),
  `created_at` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_invoice_payments`
--

INSERT INTO `tbl_invoice_payments` (`id`, `payment_methode_id`, `trans_id`, `client_id`, `amount`, `due_amount`, `notes`, `invoice_id`, `date`, `updated_at`, `created_at`) VALUES
(1, 2, 'TRANS-53-01/02/22', NULL, 10000, 990043, '43', NULL, '2022-02-02', '2022-02-01', '2022-02-01'),
(2, 1, 'TRANS-56-02/02/22', NULL, 81600, 0, '0', NULL, '2022-02-03', '2022-02-02', '2022-02-02'),
(3, 1, 'TRANS-58-04/02/22', NULL, 600000, 9000000, 'hello thanks for tbl_invoice_payments', NULL, '2022-02-04', '2022-02-04', '2022-02-04'),
(4, 1, 'TRANS-58-04/02/22', NULL, 9000000, 600000, '600000', NULL, '2022-02-03', '2022-02-04', '2022-02-04'),
(5, 3, 'TRANS-64-04/02/22', NULL, 400000, 450000, 'test', NULL, '2022-02-05', '2022-02-04', '2022-02-04'),
(6, 1, 'TRANS-61-04/02/22', NULL, 200000, 47800000, '0', NULL, '2022-02-05', '2022-02-04', '2022-02-04'),
(7, 1, 'TRANS-20-26/02/22', NULL, 50000, 2000000, '-2050000', NULL, '2022-02-26', '2022-02-26', '2022-02-26'),
(8, 1, 'TRANS-21-26/02/22', NULL, 50000, 2000000, '-2050000', NULL, '2022-02-25', '2022-02-26', '2022-02-26'),
(9, 1, 'TRANS-23-26/02/22', NULL, 150000, 1900000, '-2050000', NULL, '2022-02-25', '2022-02-26', '2022-02-26'),
(10, 1, 'TRANS-7-27/02/22', NULL, 2000, 1998000, '-2000000', NULL, '2022-02-18', '2022-02-27', '2022-02-27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_irrigation_processes`
--

CREATE TABLE `tbl_irrigation_processes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `irrigation_date` date NOT NULL,
  `water_volume` int(11) NOT NULL,
  `next_date` date NOT NULL,
  `cost_per_heck` int(11) NOT NULL,
  `no_of_heck` int(11) NOT NULL,
  `total_volume` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `seasson_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_irrigation_processes`
--

INSERT INTO `tbl_irrigation_processes` (`id`, `irrigation_date`, `water_volume`, `next_date`, `cost_per_heck`, `no_of_heck`, `total_volume`, `added_by`, `seasson_id`, `created_at`, `updated_at`) VALUES
(2, '2022-04-08', 2000, '2022-04-10', 300000, 4, 120000, 0, 0, '2022-04-02 14:08:16', '2022-04-02 14:08:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_irrigation_settings`
--

CREATE TABLE `tbl_irrigation_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `irrigation_type` int(11) NOT NULL,
  `method` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_cost` decimal(20,2) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_irrigation_settings2`
--

CREATE TABLE `tbl_irrigation_settings2` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `irrigation_type` int(11) NOT NULL,
  `irrigation_cost` int(11) NOT NULL,
  `number_of_hk` int(11) NOT NULL,
  `power_source` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pump_cost` int(11) NOT NULL,
  `pump_rate` int(11) NOT NULL,
  `hector_per_day` int(11) NOT NULL,
  `pump_no` int(11) NOT NULL,
  `total_pump_cost` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_irrigation_settings2`
--

INSERT INTO `tbl_irrigation_settings2` (`id`, `irrigation_type`, `irrigation_cost`, `number_of_hk`, `power_source`, `pump_cost`, `pump_rate`, `hector_per_day`, `pump_no`, `total_pump_cost`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, '2022-03-21 17:38:31', '2022-03-21 17:38:31'),
(2, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, '2022-03-21 20:03:27', '2022-03-21 20:03:27'),
(3, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, '2022-03-21 20:06:30', '2022-03-21 20:06:30'),
(4, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, '2022-03-21 20:12:30', '2022-03-21 20:12:30'),
(5, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, '2022-03-31 18:08:04', '2022-03-31 18:08:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_irrigation_settings_items`
--

CREATE TABLE `tbl_irrigation_settings_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `irrigation_id` int(11) NOT NULL,
  `item_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` decimal(20,2) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_irrigation_systems`
--

CREATE TABLE `tbl_irrigation_systems` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `added_by` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_irrigation_systems`
--

INSERT INTO `tbl_irrigation_systems` (`id`, `added_by`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'watering', '', NULL, NULL),
(2, 1, 'watering', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_land_properties`
--

CREATE TABLE `tbl_land_properties` (
  `id` int(100) NOT NULL,
  `reg_no` varchar(100) DEFAULT NULL,
  `region_id` int(200) NOT NULL,
  `district_id` int(200) NOT NULL,
  `ward_id` int(100) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `size` int(100) NOT NULL,
  `land_value` int(100) NOT NULL,
  `owner_id` int(100) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `status` int(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_land_properties`
--

INSERT INTO `tbl_land_properties` (`id`, `reg_no`, `region_id`, `district_id`, `ward_id`, `location`, `size`, `land_value`, `owner_id`, `description`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Saew23', 2, 8, 314, 'mbezi2', 23, 234, 1, NULL, NULL, '2022-02-21 00:41:03', '2022-04-12 21:25:11'),
(5, '87y:reshuvvb', 13, 72, 1711, 'Mtwara', 50, 20000, 1, NULL, NULL, '2022-04-04 12:30:50', '2022-04-12 21:25:44'),
(6, 'trn123:', 18, 106, 520, 'mkuranga maengeni', 50, 50000000, 1, NULL, NULL, '2022-04-12 20:04:12', '2022-04-12 21:26:00'),
(7, 'Johnt*45', 14, 74, 362, 'Morogoro', 31, 34000, 2, NULL, NULL, '2022-04-12 20:12:14', '2022-04-12 21:26:29'),
(9, '34eikje', 1, 1, 3232, 'sombetini', 2, 30000000, 7, NULL, NULL, '2022-05-08 14:03:30', '2022-05-08 14:03:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave_application`
--

CREATE TABLE `tbl_leave_application` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `leave_category_id` int(11) NOT NULL,
  `reason` text NOT NULL,
  `leave_type` enum('single_day','multiple_days','hours') NOT NULL,
  `hours` varchar(20) DEFAULT NULL,
  `leave_start_date` date NOT NULL,
  `leave_end_date` date DEFAULT NULL,
  `application_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=pending,2=accepted 3=rejected',
  `application_date` date DEFAULT current_timestamp(),
  `attachment` text DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `approve_by` int(11) DEFAULT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_leave_application`
--

INSERT INTO `tbl_leave_application` (`id`, `staff_id`, `leave_category_id`, `reason`, `leave_type`, `hours`, `leave_start_date`, `leave_end_date`, `application_status`, `application_date`, `attachment`, `comments`, `approve_by`, `added_by`, `created_at`, `updated_at`) VALUES
(2, 29, 1, 'checkup', 'multiple_days', NULL, '2022-04-23', '2022-04-25', 2, '2022-04-22', NULL, NULL, 1, 1, '2022-04-22 20:33:24', '2022-04-27 21:49:29'),
(3, 24, 2, 'unexpected meeting', 'hours', '3', '2022-04-25', NULL, 2, '2022-04-22', NULL, NULL, 1, 1, '2022-04-22 20:40:47', '2022-04-22 20:41:01'),
(6, 28, 1, 'jjjkj', 'single_day', NULL, '2022-04-27', NULL, 1, '2022-04-27', NULL, NULL, NULL, 1, '2022-04-27 21:49:18', '2022-04-27 21:49:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave_category`
--

CREATE TABLE `tbl_leave_category` (
  `id` int(11) NOT NULL,
  `leave_category` varchar(100) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_leave_category`
--

INSERT INTO `tbl_leave_category` (`id`, `leave_category`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Sick Leave', 1, '2022-04-22 20:28:53', '2022-04-22 20:28:53'),
(2, 'Emergency', 1, '2022-04-22 20:40:09', '2022-04-22 20:40:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_monitoring_solutions`
--

CREATE TABLE `tbl_monitoring_solutions` (
  `id` int(100) NOT NULL,
  `monitoring_id` int(100) NOT NULL,
  `action` varchar(300) NOT NULL,
  `chemical` varchar(300) NOT NULL,
  `result` varchar(300) NOT NULL,
  `status` int(100) DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_monitoring_solutions`
--

INSERT INTO `tbl_monitoring_solutions` (`id`, `monitoring_id`, `action`, `chemical`, `result`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 'hhjhj', 'jkj', 'jhhjhj', NULL, '2022-02-22', '2022-02-22'),
(4, 1, 'hhjhj', 'jkj', 'jhhjhj', NULL, '2022-02-22', '2022-02-22'),
(5, 2, 'hhjhj', 'jkj', 'jhhjhj', NULL, '2022-02-22', '2022-02-22'),
(6, 4, 'hhjhj', 'jkj', 'jhhjhj', NULL, '2022-02-22', '2022-02-22'),
(3, 1, 'hhjhj', 'jkj', 'jhhjhj', NULL, '2022-02-22', '2022-02-22'),
(4, 1, 'hhjhj', 'jkj', 'jhhjhj', NULL, '2022-02-22', '2022-02-22'),
(5, 2, 'hhjhj', 'jkj', 'jhhjhj', NULL, '2022-02-22', '2022-02-22'),
(6, 4, 'hhjhj', 'jkj', 'jhhjhj', NULL, '2022-02-22', '2022-02-22'),
(3, 1, 'hhjhj', 'jkj', 'jhhjhj', NULL, '2022-02-22', '2022-02-22'),
(4, 1, 'hhjhj', 'jkj', 'jhhjhj', NULL, '2022-02-22', '2022-02-22'),
(5, 2, 'hhjhj', 'jkj', 'jhhjhj', NULL, '2022-02-22', '2022-02-22'),
(6, 4, 'hhjhj', 'jkj', 'jhhjhj', NULL, '2022-02-22', '2022-02-22'),
(0, 0, 'Applied Pest side', 'VVVV main', 'recover', NULL, '2022-03-22', '2022-03-22'),
(0, 1, 'ewfewf', 'wfefew', 'fdfdf', NULL, '2022-04-11', '2022-04-11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_monitoring_type`
--

CREATE TABLE `tbl_monitoring_type` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_monitoring_type`
--

INSERT INTO `tbl_monitoring_type` (`id`, `name`) VALUES
(1, 'Weeds'),
(2, 'Disseases');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(100) NOT NULL,
  `logistics_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `crop_type` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `offered_amount` int(191) NOT NULL,
  `start_location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_location` varchar(199) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`id`, `user_id`, `logistics_id`, `quantity`, `client_id`, `crop_type`, `warehouse_id`, `offered_amount`, `start_location`, `end_location`, `route_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 16, 16, 200, 25, 1, 22, 777, 'Arusha', 'Daresalam', '1', '2', '2022-03-22 15:46:16', '2022-04-28 16:26:41'),
(2, 1, NULL, 3455, 25, 4, 22, 567899, 'morogoro', 'Dar es salaam', '3', '3', '2022-03-22 15:46:16', '2022-03-22 15:46:16'),
(3, 1, NULL, 200, 25, 4, 22, 10000, 'Morogoro', 'Mbeya', '1', '2', '2022-03-22 15:46:16', '2022-03-22 15:46:16'),
(4, 1, NULL, 3455, 25, 1, 3, 567899, 'Dar es salaam', 'Arusha', '2', '2', '2022-03-22 15:46:16', '2022-03-22 15:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_overtime`
--

CREATE TABLE `tbl_overtime` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `overtime_date` date NOT NULL,
  `overtime_amount` decimal(20,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `status` varchar(200) NOT NULL DEFAULT '0' COMMENT '0=pending,1=approved,2=rejected,3=paid',
  `added_by` int(200) NOT NULL,
  `approve_by` int(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_overtime`
--

INSERT INTO `tbl_overtime` (`id`, `user_id`, `overtime_date`, `overtime_amount`, `notes`, `status`, `added_by`, `approve_by`, `created_at`, `updated_at`) VALUES
(1, 20, '2022-01-08', '25000.00', NULL, '1', 1, 1, '2022-05-09 20:38:16', '2022-05-09 20:38:16'),
(2, 43, '2022-05-07', '30000.00', NULL, '1', 1, 1, '2022-05-09 20:45:30', '2022-05-09 20:45:30'),
(3, 19, '2022-04-16', '18000.00', NULL, '3', 19, 1, '2022-05-09 21:00:57', '2022-05-09 22:33:19'),
(4, 19, '2022-04-25', '20000.00', NULL, '3', 19, 1, '2022-05-09 21:07:07', '2022-05-09 22:33:19'),
(5, 43, '2022-03-16', '18000.00', NULL, '3', 1, 1, '2022-05-09 22:57:09', '2022-05-09 23:02:14'),
(6, 43, '2022-03-19', '12000.00', NULL, '3', 1, 1, '2022-05-09 22:58:51', '2022-05-09 23:02:14');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_parking_types`
--

CREATE TABLE `tbl_parking_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parking_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_parking_types`
--

INSERT INTO `tbl_parking_types` (`id`, `parking_name`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Courier', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payroll_activities`
--

CREATE TABLE `tbl_payroll_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date DEFAULT current_timestamp(),
  `activity` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_payroll_activities`
--

INSERT INTO `tbl_payroll_activities` (`id`, `module_id`, `module`, `date`, `activity`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '4', 'Salary Template', '2022-05-10', 'Salary Template D Created', 1, '2022-05-10 17:41:52', '2022-05-10 17:41:52'),
(2, '1', 'Payslip', '2022-05-11', 'Payslip 2022051 has been generated for  sam2  for the month April 2022', 1, '2022-05-11 10:24:29', '2022-05-11 10:24:29'),
(3, '2', 'Payslip', '2022-05-11', 'Payslip 2022052 has been generated for  sam3  for the month April 2022', 1, '2022-05-11 11:34:59', '2022-05-11 11:34:59'),
(4, '3', 'Payslip', '2022-05-11', 'Payslip 2022053 has been generated for  test  for the month April 2022', 1, '2022-05-11 11:38:16', '2022-05-11 11:38:16'),
(5, '4', 'Salary Details', '2022-05-11', 'Salary Details for  IT  Department Updated', 19, '2022-05-11 15:50:23', '2022-05-11 15:50:23'),
(6, '14', 'Salary Payment', '2022-05-11', 'Salary Payment to   for the month July 2022', 19, '2022-05-11 15:59:42', '2022-05-11 15:59:42'),
(7, '4', 'Payslip', '2022-05-11', 'Payslip 2022054 has been generated for    for the month July 2022', 19, '2022-05-11 15:59:53', '2022-05-11 15:59:53'),
(8, '6', 'Salary Template', '2022-05-12', 'Salary Template for  F  Updated ', 1, '2022-05-12 13:30:22', '2022-05-12 13:30:22'),
(9, '15', 'Salary Payment', '2022-05-23', 'Salary Payment to   for the month April 2022', 1, '2022-05-23 13:55:57', '2022-05-23 13:55:57');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pestisides`
--

CREATE TABLE `tbl_pestisides` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pestiside_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesticide_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `farming_process` int(11) NOT NULL,
  `pestiside_amount` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `pestiside_price` int(11) NOT NULL,
  `pestiside_cost` int(11) NOT NULL,
  `no_hector` int(11) NOT NULL,
  `total_cost` decimal(20,2) NOT NULL,
  `seasson_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_pestisides`
--

INSERT INTO `tbl_pestisides` (`id`, `pestiside_type`, `pesticide_name`, `farming_process`, `pestiside_amount`, `total_amount`, `pestiside_price`, `pestiside_cost`, `no_hector`, `total_cost`, `seasson_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Insect', '3', 6, 5, 10, 12000, 120000, 2, '120000.00', 7, 20, '2022-04-13 12:10:47', '2022-04-13 12:28:19'),
(2, 'Plants', '2', 3, 10, 50, 10000, 500000, 5, '500000.00', 7, 20, '2022-04-13 12:12:43', '2022-04-13 12:29:17');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pestisides_type`
--

CREATE TABLE `tbl_pestisides_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_pestisides_type`
--

INSERT INTO `tbl_pestisides_type` (`id`, `type`, `name`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Plants', 'Bonide', 20, '2022-04-13 11:18:09', '2022-04-13 11:18:09'),
(2, 'Plants', 'Neem Powder', 20, '2022-04-13 11:18:37', '2022-04-13 11:18:37'),
(3, 'Insect', 'Boric Acid', 20, '2022-04-13 11:20:40', '2022-04-13 11:22:54'),
(4, 'Lavercides', 'plant pest', 20, '2022-05-09 17:48:09', '2022-05-09 17:48:09'),
(5, 'Fungicides', 'new pestides', 20, '2022-05-09 19:44:58', '2022-05-09 19:44:58'),
(6, 'Rodenticides', 'insert', 20, '2022-05-11 21:05:06', '2022-05-11 21:05:06');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_post_harvests`
--

CREATE TABLE `tbl_post_harvests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harvest_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maturity_index` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maturity_level` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harvest_date` date NOT NULL,
  `packing_type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `drying_method` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `market` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `water` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` decimal(20,2) NOT NULL,
  `acre` decimal(20,2) NOT NULL,
  `total_cost` decimal(20,2) NOT NULL,
  `harvest_amount` decimal(20,2) NOT NULL,
  `total_harvest` decimal(20,2) NOT NULL,
  `seasson_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_post_harvests`
--

INSERT INTO `tbl_post_harvests` (`id`, `category`, `harvest_method`, `maturity_index`, `maturity_level`, `harvest_date`, `packing_type`, `drying_method`, `warehouse_id`, `market`, `water`, `cost`, `acre`, `total_cost`, `harvest_amount`, `total_harvest`, `seasson_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Non Grain', 'Harvesting with Hand Tool', '4', 'intermediate', '2022-04-11', 'test', NULL, '', '50km', '5ltrs', '15000.00', '2.00', '30000.00', '18000.00', '36000.00', 8, 20, '2022-04-10 18:05:09', '2022-04-13 14:28:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_preparation_costs`
--

CREATE TABLE `tbl_preparation_costs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cost_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_preparation_costs`
--

INSERT INTO `tbl_preparation_costs` (`id`, `cost_name`, `cost`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'kulima', 10000, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_preparation_cost_lists`
--

CREATE TABLE `tbl_preparation_cost_lists` (
  `id` int(11) NOT NULL,
  `preparation_id` int(11) NOT NULL,
  `tax_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_tax` decimal(20,2) NOT NULL DEFAULT 0.00,
  `quantity` decimal(10,2) DEFAULT 0.00,
  `total_cost` decimal(20,2) NOT NULL DEFAULT 0.00,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `unit` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL DEFAULT 0,
  `order_no` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_preparation_cost_lists`
--

INSERT INTO `tbl_preparation_cost_lists` (`id`, `preparation_id`, `tax_rate`, `total_tax`, `quantity`, `total_cost`, `item_name`, `price`, `unit`, `items_id`, `order_no`, `created_at`, `updated_at`) VALUES
(49, 13, '0.00', '0.00', '10.00', '5000000.00', '1', '500000.00', '', 1, 0, '2022-03-22 11:32:58', '2022-03-22 11:32:58'),
(50, 14, '0.00', '0.00', '10.00', '500000.00', '1', '50000.00', '', 1, 0, '2022-03-31 16:21:32', '2022-03-31 16:21:32'),
(51, 15, '0.00', '0.00', '50.00', '2000000.00', '1', '40000.00', '', 1, 0, '2022-04-02 13:25:31', '2022-04-02 13:25:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_preparation_details`
--

CREATE TABLE `tbl_preparation_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `seasson_id` int(100) DEFAULT NULL,
  `organization_id` int(11) NOT NULL,
  `preparation_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `soil_salt` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lime_control` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acid_level` decimal(20,2) DEFAULT NULL,
  `moisture_level` decimal(20,2) NOT NULL,
  `weight` decimal(20,2) DEFAULT NULL,
  `cost` decimal(20,2) NOT NULL,
  `acre` decimal(20,2) NOT NULL,
  `total_cost` decimal(20,2) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_preparation_details`
--

INSERT INTO `tbl_preparation_details` (`id`, `user_id`, `seasson_id`, `organization_id`, `preparation_type`, `soil_salt`, `lime_control`, `acid_level`, `moisture_level`, `weight`, `cost`, `acre`, `total_cost`, `status`, `created_at`, `updated_at`) VALUES
(1, 20, 8, 0, 'Levelling', 'Lime', '1', '6.50', '123.00', NULL, '2300.00', '1.00', '2300.00', 0, '2022-04-12 20:36:35', '2022-04-12 22:39:46'),
(2, 20, 10, 0, 'Clearing and weeding the field', 'Lime', '4', '6.50', '200.00', NULL, '45000.00', '2.00', '90000.00', 0, '2022-05-11 21:29:46', '2022-05-11 21:29:46'),
(3, 20, 10, 0, 'Levelling', 'Lime', '4', '6.50', '200.00', NULL, '10000.00', '2.00', '20000.00', 0, '2022-05-11 21:30:31', '2022-05-11 21:30:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pre_harvests`
--

CREATE TABLE `tbl_pre_harvests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harvest_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maturity_index` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maturity_level` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harvest_date` date NOT NULL,
  `packing_type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `drying_method` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse_id` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `market` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `water` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` decimal(20,2) NOT NULL,
  `acre` decimal(20,2) NOT NULL,
  `total_cost` decimal(20,2) NOT NULL,
  `harvest_amount` decimal(20,2) NOT NULL,
  `total_harvest` decimal(20,2) NOT NULL,
  `seasson_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_pre_harvests`
--

INSERT INTO `tbl_pre_harvests` (`id`, `category`, `harvest_method`, `maturity_index`, `maturity_level`, `harvest_date`, `packing_type`, `drying_method`, `warehouse_id`, `market`, `water`, `cost`, `acre`, `total_cost`, `harvest_amount`, `total_harvest`, `seasson_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Grain', 'Hand Harvesting', '3', 'beginner', '2022-04-10', 'test', 'Hot Air Drying', '22', NULL, NULL, '10000.00', '10.00', '100000.00', '5000.00', '50000.00', 7, 20, '2022-04-10 17:33:31', '2022-04-13 12:46:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_production`
--

CREATE TABLE `tbl_production` (
  `id` int(100) NOT NULL,
  `weight_note` int(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `lot_no` int(100) DEFAULT NULL,
  `client` varchar(100) DEFAULT NULL,
  `bale_weight` int(100) DEFAULT NULL,
  `net_weight` int(100) DEFAULT NULL,
  `gross_weight` int(100) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `tale` int(100) DEFAULT NULL,
  `status` varchar(200) DEFAULT '0',
  `added_by` int(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_production`
--

INSERT INTO `tbl_production` (`id`, `weight_note`, `date`, `location`, `lot_no`, `client`, `bale_weight`, `net_weight`, `gross_weight`, `remarks`, `name`, `tale`, `status`, `added_by`, `created_at`, `updated_at`) VALUES
(25, 10, '2022-05-18', 'mafinga', 564, '1', 2440, 2440, 2500, NULL, NULL, NULL, '1', NULL, '2022-05-26 09:38:36', '2022-05-26 15:37:14'),
(26, 15101, '2022-05-25', 'GAKI GINNERY', 18308, '1', 933, 933, 1093, NULL, NULL, 800, '1', NULL, '2022-05-26 17:16:51', '2022-05-26 17:24:51'),
(27, 15101, '2022-05-25', 'GAKI GINNERY', 18308, '1', 2063, 2063, 2223, NULL, NULL, 1600, '0', NULL, '2022-05-26 17:17:33', '2022-05-26 17:17:33'),
(28, 78, '2022-05-25', 'main', 0, '1', 2276, 2276, 2292, NULL, NULL, 160, '0', NULL, '2022-05-26 23:07:46', '2022-05-26 23:07:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_productionactivity`
--

CREATE TABLE `tbl_productionactivity` (
  `id` int(100) NOT NULL,
  `production_id` int(100) DEFAULT NULL,
  `lot_no` int(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL COMMENT '1-seeds,2-dust',
  `sales_quantity` int(100) DEFAULT NULL,
  `production_quantity` int(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `added_by` int(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_productionactivity`
--

INSERT INTO `tbl_productionactivity` (`id`, `production_id`, `lot_no`, `type`, `sales_quantity`, `production_quantity`, `status`, `added_by`, `created_at`, `updated_at`) VALUES
(8, 25, 564, 'seeds', NULL, 9760, NULL, 50, '2022-05-26 09:38:36', '2022-05-26 09:38:36'),
(9, 25, 564, 'raw_cotton', NULL, 7320, NULL, 50, '2022-05-26 09:38:36', '2022-05-26 09:38:36'),
(10, 25, 564, 'dust', NULL, 7320, NULL, 50, '2022-05-26 09:38:36', '2022-05-26 09:38:36'),
(13, NULL, 1, '1', 10, NULL, NULL, 50, '2022-05-26 15:18:48', '2022-05-26 15:18:48'),
(14, NULL, 1, '2', 20, NULL, NULL, 50, '2022-05-26 15:18:48', '2022-05-26 15:18:48'),
(15, NULL, 2, '1', 10000, NULL, NULL, 50, '2022-05-26 17:13:19', '2022-05-26 17:13:19'),
(16, 26, 18308, '1', NULL, 3732, NULL, 50, '2022-05-26 17:16:51', '2022-05-26 17:16:51'),
(17, 26, 18308, '3', NULL, 2799, NULL, 50, '2022-05-26 17:16:51', '2022-05-26 17:16:51'),
(18, 26, 18308, '2', NULL, 2799, NULL, 50, '2022-05-26 17:16:51', '2022-05-26 17:16:51'),
(19, 27, 18308, '1', NULL, 8252, NULL, 50, '2022-05-26 17:17:33', '2022-05-26 17:17:33'),
(20, 27, 18308, '3', NULL, 6189, NULL, 50, '2022-05-26 17:17:33', '2022-05-26 17:17:33'),
(21, 27, 18308, '2', NULL, 6189, NULL, 50, '2022-05-26 17:17:33', '2022-05-26 17:17:33'),
(22, 28, 0, '1', NULL, 9104, NULL, 50, '2022-05-26 23:07:46', '2022-05-26 23:07:46'),
(23, 28, 0, '3', NULL, 6828, NULL, 50, '2022-05-26 23:07:46', '2022-05-26 23:07:46'),
(24, 28, 0, '2', NULL, 6828, NULL, 50, '2022-05-26 23:07:46', '2022-05-26 23:07:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_productionlist`
--

CREATE TABLE `tbl_productionlist` (
  `id` int(100) NOT NULL,
  `production_id` int(100) DEFAULT NULL,
  `bale` int(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT '1',
  `added_by` int(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_productionlist`
--

INSERT INTO `tbl_productionlist` (`id`, `production_id`, `bale`, `status`, `added_by`, `created_at`, `updated_at`) VALUES
(78, 25, 700, '1', 50, '2022-05-26 09:38:36', '2022-05-26 09:38:36'),
(79, 25, 700, '1', 50, '2022-05-26 09:38:36', '2022-05-26 09:38:36'),
(80, 25, 200, '1', 50, '2022-05-26 09:38:36', '2022-05-26 09:38:36'),
(81, 25, 200, '1', 50, '2022-05-26 09:38:36', '2022-05-26 09:38:36'),
(82, 25, 700, '1', 50, '2022-05-26 09:38:36', '2022-05-26 09:38:36'),
(83, 26, 220, '1', 50, '2022-05-26 17:16:51', '2022-05-26 17:16:51'),
(84, 26, 212, '1', 50, '2022-05-26 17:16:51', '2022-05-26 17:16:51'),
(85, 26, 224, '1', 50, '2022-05-26 17:16:51', '2022-05-26 17:16:51'),
(86, 26, 219, '1', 50, '2022-05-26 17:16:51', '2022-05-26 17:16:51'),
(87, 26, 218, '1', 50, '2022-05-26 17:16:51', '2022-05-26 17:16:51'),
(88, 27, 220, '1', 50, '2022-05-26 17:17:33', '2022-05-26 17:17:33'),
(89, 27, 212, '1', 50, '2022-05-26 17:17:33', '2022-05-26 17:17:33'),
(90, 27, 224, '1', 50, '2022-05-26 17:17:33', '2022-05-26 17:17:33'),
(91, 27, 219, '1', 50, '2022-05-26 17:17:33', '2022-05-26 17:17:33'),
(92, 27, 218, '1', 50, '2022-05-26 17:17:33', '2022-05-26 17:17:33'),
(93, 27, 227, '1', 50, '2022-05-26 17:17:33', '2022-05-26 17:17:33'),
(94, 27, 225, '1', 50, '2022-05-26 17:17:33', '2022-05-26 17:17:33'),
(95, 27, 226, '1', 50, '2022-05-26 17:17:33', '2022-05-26 17:17:33'),
(96, 27, 227, '1', 50, '2022-05-26 17:17:33', '2022-05-26 17:17:33'),
(97, 27, 225, '1', 50, '2022-05-26 17:17:33', '2022-05-26 17:17:33'),
(98, 28, 220, '1', 50, '2022-05-26 23:07:46', '2022-05-26 23:07:46'),
(99, 28, 222, '1', 50, '2022-05-26 23:07:46', '2022-05-26 23:07:46'),
(100, 28, 235, '1', 50, '2022-05-26 23:07:46', '2022-05-26 23:07:46'),
(101, 28, 245, '1', 50, '2022-05-26 23:07:46', '2022-05-26 23:07:46'),
(102, 28, 232, '1', 50, '2022-05-26 23:07:46', '2022-05-26 23:07:46'),
(103, 28, 200, '1', 50, '2022-05-26 23:07:46', '2022-05-26 23:07:46'),
(104, 28, 242, '1', 50, '2022-05-26 23:07:46', '2022-05-26 23:07:46'),
(105, 28, 230, '1', 50, '2022-05-26 23:07:46', '2022-05-26 23:07:46'),
(106, 28, 212, '1', 50, '2022-05-26 23:07:46', '2022-05-26 23:07:46'),
(107, 28, 254, '1', 50, '2022-05-26 23:07:46', '2022-05-26 23:07:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_tools`
--

CREATE TABLE `tbl_product_tools` (
  `id` int(100) NOT NULL,
  `tool_name` varchar(100) NOT NULL,
  `owner_id` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `units` varchar(100) DEFAULT NULL,
  `status` int(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product_tools`
--

INSERT INTO `tbl_product_tools` (`id`, `tool_name`, `owner_id`, `quantity`, `units`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Power Tiller', 1, 2, 'PC', NULL, '2022-04-12 20:09:03', '2022-04-12 20:09:03'),
(2, 'Trecker', 7, 1, 'PC', NULL, '2022-05-08 14:04:42', '2022-05-08 14:04:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchases`
--

CREATE TABLE `tbl_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `due_date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `purchase_amount` int(11) NOT NULL,
  `due_amount` int(100) DEFAULT 0,
  `purchase_tax` int(100) DEFAULT NULL,
  `currency_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exchange_rate` int(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_purchases`
--

INSERT INTO `tbl_purchases` (`id`, `reference_no`, `supplier_id`, `purchase_date`, `due_date`, `user_id`, `status`, `purchase_amount`, `due_amount`, `purchase_tax`, `currency_code`, `exchange_rate`, `created_at`, `updated_at`) VALUES
(20, 'sdsdds', 4, '2022-02-10', '2022-02-10', 1, 2, 2050000, 2050000, 9000, NULL, NULL, '2022-02-26 20:34:13', '2022-02-26 22:19:43'),
(21, 'sdsdds', 4, '2022-02-10', '2022-02-10', 1, 2, 2050000, 2000000, 9000, NULL, NULL, '2022-02-26 20:45:25', '2022-02-26 22:21:52'),
(22, 'sdsdds', 4, '2022-02-10', '2022-02-10', 1, 1, 2050000, 2050000, 9000, NULL, NULL, '2022-02-26 21:01:34', '2022-02-26 21:01:34'),
(23, 'sdsdds', 4, '2022-02-10', '2022-02-10', 1, 2, 2050000, 1900000, 9000, NULL, NULL, '2022-02-26 21:01:58', '2022-02-26 22:56:27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_items`
--

CREATE TABLE `tbl_purchase_items` (
  `purchase_items_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `tax_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_tax` decimal(20,2) NOT NULL DEFAULT 0.00,
  `quantity` decimal(10,2) DEFAULT 0.00,
  `total_cost` decimal(20,2) NOT NULL DEFAULT 0.00,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `unit` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL DEFAULT 0,
  `order_no` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_purchase_items`
--

INSERT INTO `tbl_purchase_items` (`purchase_items_id`, `purchase_id`, `tax_rate`, `total_tax`, `quantity`, `total_cost`, `item_name`, `price`, `unit`, `items_id`, `order_no`, `created_at`, `updated_at`) VALUES
(3, 63, '0.18', '225000.00', '5.00', '1250000.00', '6', '250000.00', 'kgs', 6, 0, '2022-02-10 16:43:57', '2022-02-11 01:08:54'),
(35, 20, '0.00', '0.00', '4.00', '2000000.00', '6', '500000.00', 'pc', 6, 0, '2022-02-26 20:34:13', '2022-02-26 20:34:13'),
(36, 20, '0.18', '9000.00', '5.00', '50000.00', '6', '10000.00', 'pc', 6, 1, '2022-02-26 20:34:13', '2022-02-26 20:34:13'),
(37, 21, '0.00', '0.00', '4.00', '2000000.00', '6', '500000.00', 'pc', 6, 0, '2022-02-26 20:45:25', '2022-02-26 20:45:25'),
(38, 21, '0.18', '9000.00', '5.00', '50000.00', '6', '10000.00', 'pc', 6, 1, '2022-02-26 20:45:25', '2022-02-26 20:45:25'),
(39, 22, '0.00', '0.00', '4.00', '2000000.00', '6', '500000.00', 'pc', 6, 0, '2022-02-26 21:01:34', '2022-02-26 21:01:34'),
(40, 22, '0.18', '9000.00', '5.00', '50000.00', '6', '10000.00', 'pc', 6, 1, '2022-02-26 21:01:34', '2022-02-26 21:01:34'),
(41, 23, '0.00', '0.00', '4.00', '2000000.00', '6', '500000.00', 'pc', 6, 0, '2022-02-26 21:01:58', '2022-02-26 21:01:58'),
(42, 23, '0.18', '9000.00', '5.00', '50000.00', '6', '10000.00', 'pc', 6, 1, '2022-02-26 21:01:58', '2022-02-26 21:01:58');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotation_costs`
--

CREATE TABLE `tbl_quotation_costs` (
  `id` int(11) NOT NULL,
  `quotation_id` int(11) NOT NULL,
  `tax_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_tax` decimal(20,2) NOT NULL DEFAULT 0.00,
  `quantity` decimal(10,2) DEFAULT 0.00,
  `total_cost` decimal(20,2) NOT NULL DEFAULT 0.00,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `unit` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL DEFAULT 0,
  `order_no` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_quotation_costs`
--

INSERT INTO `tbl_quotation_costs` (`id`, `quotation_id`, `tax_rate`, `total_tax`, `quantity`, `total_cost`, `item_name`, `price`, `unit`, `items_id`, `order_no`, `created_at`, `updated_at`) VALUES
(43, 3, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-03-01 20:00:45', '2022-03-01 20:00:45'),
(44, 4, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-03-01 20:56:06', '2022-03-01 20:56:06'),
(45, 5, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-03-01 20:57:12', '2022-03-01 20:57:12'),
(46, 6, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-03-01 20:57:49', '2022-03-01 20:57:49'),
(47, 7, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-03-01 21:11:27', '2022-03-01 21:11:27'),
(48, 8, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-03-01 21:15:37', '2022-03-01 21:15:37'),
(49, 9, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-03-01 21:16:04', '2022-03-01 21:16:04'),
(50, 10, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-03-01 21:17:53', '2022-03-01 21:17:53'),
(51, 11, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-03-01 21:18:31', '2022-03-01 21:18:31'),
(52, 12, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-03-01 21:18:55', '2022-03-01 21:18:55'),
(53, 13, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-03-01 21:19:16', '2022-03-01 21:19:16'),
(54, 14, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-03-01 21:19:47', '2022-03-01 21:19:47'),
(55, 15, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-03-01 21:20:05', '2022-03-01 21:20:05'),
(56, 16, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-03-02 14:36:03', '2022-03-02 14:36:03'),
(57, 1, '0.00', '0.00', '6.00', '180000.00', '2', '30000.00', 'kgs', 2, 0, '2022-03-22 12:42:32', '2022-03-22 12:42:32'),
(58, 1, '0.18', '41400000.00', '23000.00', '230000000.00', '3', '10000.00', 'kgs', 3, 1, '2022-03-22 12:42:32', '2022-03-22 12:42:32'),
(59, 2, '0.00', '0.00', '1.00', '500000.00', '1', '500000.00', 'pounds', 1, 0, '2022-03-29 14:05:43', '2022-03-29 14:05:43'),
(60, 3, '0.00', '0.00', '10.00', '5000000.00', '1', '500000.00', 'pounds', 1, 0, '2022-03-29 14:36:46', '2022-03-29 14:36:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salary_allowance`
--

CREATE TABLE `tbl_salary_allowance` (
  `salary_allowance_id` bigint(20) UNSIGNED NOT NULL,
  `salary_template_id` int(11) NOT NULL,
  `allowance_label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `allowance_value` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_salary_allowance`
--

INSERT INTO `tbl_salary_allowance` (`salary_allowance_id`, `salary_template_id`, `allowance_label`, `allowance_value`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, 'House Rent Allowance', 150000, 19, '2022-05-04 17:40:33', '2022-05-04 17:40:33'),
(2, 2, 'Medical Allowance', 50000, 19, '2022-05-04 17:40:33', '2022-05-04 17:40:33'),
(3, 5, 'Medical Allowance', 50000, 1, '2022-05-12 00:54:46', '2022-05-12 00:54:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salary_deduction`
--

CREATE TABLE `tbl_salary_deduction` (
  `salary_deduction_id` bigint(20) UNSIGNED NOT NULL,
  `salary_template_id` int(11) NOT NULL,
  `deduction_label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deduction_value` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_salary_deduction`
--

INSERT INTO `tbl_salary_deduction` (`salary_deduction_id`, `salary_template_id`, `deduction_label`, `deduction_value`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'NSSF', 70000, 19, '2022-05-04 17:36:41', '2022-05-04 17:36:41'),
(2, 1, 'PAYE', 21000, 19, '2022-05-04 17:36:41', '2022-05-04 17:36:41'),
(3, 1, 'HESLB', 105000, 19, '2022-05-04 17:36:41', '2022-05-04 17:36:41'),
(4, 2, 'NSSF', 50000, 19, '2022-05-04 17:40:33', '2022-05-04 17:40:33'),
(5, 2, 'PAYE', 31000, 19, '2022-05-04 17:40:33', '2022-05-04 17:40:33'),
(6, 2, 'HESLB', 75000, 19, '2022-05-04 17:40:33', '2022-05-04 17:40:33'),
(7, 3, 'NSSF', 65000, 19, '2022-05-04 18:30:43', '2022-05-04 18:31:36'),
(8, 3, 'PAYE', 17400, 19, '2022-05-04 18:30:43', '2022-05-04 18:31:36'),
(9, 3, 'HESLB', 97500, 19, '2022-05-04 18:30:43', '2022-05-04 18:31:36'),
(10, 4, 'NSSF', 60000, 1, '2022-05-10 17:41:52', '2022-05-10 17:41:52'),
(11, 4, 'PAYE', 24000, 1, '2022-05-10 17:41:52', '2022-05-10 17:41:52'),
(12, 5, 'NSSF', 95000, 1, '2022-05-12 00:54:46', '2022-05-12 00:54:46'),
(13, 5, 'PAYE', 104250, 1, '2022-05-12 00:54:46', '2022-05-12 00:54:46'),
(14, 6, 'NSSF', 120000, 1, '2022-05-12 01:05:58', '2022-05-12 13:30:22'),
(15, 6, 'PAYE', 152000, 1, '2022-05-12 01:05:58', '2022-05-12 13:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salary_payments`
--

CREATE TABLE `tbl_salary_payments` (
  `id` int(5) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_month` varchar(20) NOT NULL,
  `fine_deduction` varchar(200) DEFAULT NULL,
  `payment_type` varchar(20) NOT NULL,
  `comments` text DEFAULT NULL,
  `paid_date` date DEFAULT current_timestamp(),
  `account_id` varchar(200) NOT NULL,
  `deduct_from` int(11) DEFAULT 0 COMMENT 'deduct from means tracking deduct from which account',
  `added_by` int(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_salary_payments`
--

INSERT INTO `tbl_salary_payments` (`id`, `user_id`, `payment_month`, `fine_deduction`, `payment_type`, `comments`, `paid_date`, `account_id`, `deduct_from`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 19, '2022-01', NULL, '3', 'paid late', '2022-05-07', '31', 0, NULL, '2022-05-07 14:03:16', '2022-05-07 14:03:16'),
(2, 19, '2021-12', '10000', '3', NULL, '2022-05-07', '6', 0, NULL, '2022-05-07 14:29:00', '2022-05-07 14:29:00'),
(8, 19, '2022-02', NULL, '3', NULL, '2022-05-08', '31', 0, NULL, '2022-05-08 17:20:21', '2022-05-08 17:20:21'),
(9, 43, '2022-04', NULL, '3', 'First payment of loan has been done', '2022-05-08', '35', 0, NULL, '2022-05-09 00:17:06', '2022-05-09 00:17:06'),
(10, 20, '2022-04', NULL, '3', NULL, '2022-05-08', '25', 0, NULL, '2022-05-09 00:57:00', '2022-05-09 00:57:00'),
(11, 43, '2022-05', '4000', '3', 'Hello', '2022-05-09', '35', 0, NULL, '2022-05-09 12:05:41', '2022-05-09 12:05:41'),
(12, 19, '2022-04', NULL, '3', 'overtime payment is included', '2022-05-09', '31', 0, NULL, '2022-05-09 22:33:19', '2022-05-09 22:33:19'),
(13, 43, '2022-03', NULL, '3', 'overtime payment is included', '2022-05-09', '35', 0, NULL, '2022-05-09 23:02:14', '2022-05-09 23:02:14'),
(14, 45, '2022-07', '44000', '3', 'Hello', '2022-05-11', '35', 0, NULL, '2022-05-11 15:59:42', '2022-05-11 15:59:42'),
(15, 45, '2022-04', NULL, '3', NULL, '2022-05-23', '6', 0, NULL, '2022-05-23 13:55:56', '2022-05-23 13:55:56');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salary_payment_allowance`
--

CREATE TABLE `tbl_salary_payment_allowance` (
  `salary_payment_allowance_id` bigint(20) UNSIGNED NOT NULL,
  `salary_payment_id` int(11) NOT NULL,
  `salary_payment_allowance_label` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary_payment_allowance_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_salary_payment_allowance`
--

INSERT INTO `tbl_salary_payment_allowance` (`salary_payment_allowance_id`, `salary_payment_id`, `salary_payment_allowance_label`, `salary_payment_allowance_value`, `created_at`, `updated_at`) VALUES
(1, 10, 'House Rent Allowance', '150000', '2022-05-09 00:57:00', '2022-05-09 00:57:00'),
(2, 10, 'Medical Allowance', '50000', '2022-05-09 00:57:00', '2022-05-09 00:57:00'),
(3, 14, 'House Rent Allowance', '150000', '2022-05-11 15:59:42', '2022-05-11 15:59:42'),
(4, 14, 'Medical Allowance', '50000', '2022-05-11 15:59:42', '2022-05-11 15:59:42'),
(5, 15, 'House Rent Allowance', '150000', '2022-05-23 13:55:57', '2022-05-23 13:55:57'),
(6, 15, 'Medical Allowance', '50000', '2022-05-23 13:55:57', '2022-05-23 13:55:57');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salary_payment_deduction`
--

CREATE TABLE `tbl_salary_payment_deduction` (
  `salary_payment_deduction_id` bigint(20) UNSIGNED NOT NULL,
  `salary_payment_id` int(11) NOT NULL,
  `salary_payment_deduction_label` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary_payment_deduction_value` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_salary_payment_deduction`
--

INSERT INTO `tbl_salary_payment_deduction` (`salary_payment_deduction_id`, `salary_payment_id`, `salary_payment_deduction_label`, `salary_payment_deduction_value`, `created_at`, `updated_at`) VALUES
(1, 1, 'NSSF', '65000.00', '2022-05-07 14:01:43', '2022-05-07 14:01:43'),
(2, 1, 'PAYE', '17400.00', '2022-05-07 14:01:43', '2022-05-07 14:01:43'),
(3, 1, 'HESLB', '97500.00', '2022-05-07 14:01:43', '2022-05-07 14:01:43'),
(7, 2, 'NSSF', '65000.00', '2022-05-07 14:31:46', '2022-05-07 14:31:46'),
(8, 2, 'PAYE', '17400.00', '2022-05-07 14:31:46', '2022-05-07 14:31:46'),
(9, 2, 'HESLB', '97500.00', '2022-05-07 14:31:46', '2022-05-07 14:31:46'),
(13, 8, 'NSSF', '65000.00', '2022-05-08 17:20:21', '2022-05-08 17:20:21'),
(14, 8, 'PAYE', '17400.00', '2022-05-08 17:20:21', '2022-05-08 17:20:21'),
(15, 8, 'HESLB', '97500.00', '2022-05-08 17:20:21', '2022-05-08 17:20:21'),
(16, 8, 'Advance Amount', '100000.00', '2022-05-08 17:20:21', '2022-05-08 17:20:21'),
(17, 9, 'NSSF', '70000.00', '2022-05-09 00:17:06', '2022-05-09 00:17:06'),
(18, 9, 'PAYE', '21000.00', '2022-05-09 00:17:06', '2022-05-09 00:17:06'),
(19, 9, 'HESLB', '105000.00', '2022-05-09 00:17:06', '2022-05-09 00:17:06'),
(20, 9, 'Employee Loan', '300000.00', '2022-05-09 00:17:06', '2022-05-09 00:17:06'),
(21, 10, 'NSSF', '50000.00', '2022-05-09 00:57:00', '2022-05-09 00:57:00'),
(22, 10, 'PAYE', '31000.00', '2022-05-09 00:57:00', '2022-05-09 00:57:00'),
(23, 10, 'HESLB', '75000.00', '2022-05-09 00:57:00', '2022-05-09 00:57:00'),
(24, 11, 'NSSF', '70000.00', '2022-05-09 12:05:42', '2022-05-09 12:05:42'),
(25, 11, 'PAYE', '21000.00', '2022-05-09 12:05:42', '2022-05-09 12:05:42'),
(26, 11, 'HESLB', '105000.00', '2022-05-09 12:05:42', '2022-05-09 12:05:42'),
(27, 11, 'Employee Loan', '300000.00', '2022-05-09 12:05:42', '2022-05-09 12:05:42'),
(28, 12, 'NSSF', '65000.00', '2022-05-09 22:33:19', '2022-05-09 22:33:19'),
(29, 12, 'PAYE', '17400.00', '2022-05-09 22:33:19', '2022-05-09 22:33:19'),
(30, 12, 'HESLB', '97500.00', '2022-05-09 22:33:19', '2022-05-09 22:33:19'),
(31, 13, 'NSSF', '70000.00', '2022-05-09 23:02:14', '2022-05-09 23:02:14'),
(32, 13, 'PAYE', '21000.00', '2022-05-09 23:02:14', '2022-05-09 23:02:14'),
(33, 13, 'HESLB', '105000.00', '2022-05-09 23:02:14', '2022-05-09 23:02:14'),
(34, 14, 'NSSF', '50000.00', '2022-05-11 15:59:42', '2022-05-11 15:59:42'),
(35, 14, 'PAYE', '31000.00', '2022-05-11 15:59:42', '2022-05-11 15:59:42'),
(36, 14, 'HESLB', '75000.00', '2022-05-11 15:59:42', '2022-05-11 15:59:42'),
(37, 15, 'NSSF', '50000.00', '2022-05-23 13:55:57', '2022-05-23 13:55:57'),
(38, 15, 'PAYE', '31000.00', '2022-05-23 13:55:57', '2022-05-23 13:55:57'),
(39, 15, 'HESLB', '75000.00', '2022-05-23 13:55:57', '2022-05-23 13:55:57');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salary_payment_details`
--

CREATE TABLE `tbl_salary_payment_details` (
  `salary_payment_details_id` int(11) NOT NULL,
  `salary_payment_id` int(11) NOT NULL,
  `salary_payment_details_label` varchar(200) NOT NULL,
  `salary_payment_details_value` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_salary_payment_details`
--

INSERT INTO `tbl_salary_payment_details` (`salary_payment_details_id`, `salary_payment_id`, `salary_payment_details_label`, `salary_payment_details_value`, `created_at`, `updated_at`) VALUES
(1, 1, 'Salary Grade', 'C', '2022-05-07 14:01:43', '2022-05-07 14:01:43'),
(2, 1, 'Basic Salary', '650000', '2022-05-07 14:01:43', '2022-05-07 14:01:43'),
(4, 2, 'Salary Grade', 'C', '2022-05-07 14:01:43', '2022-05-07 14:01:43'),
(5, 2, 'Basic Salary', '650000', '2022-05-07 14:29:00', '2022-05-07 14:29:00'),
(9, 8, 'Salary Grade ', 'C', '2022-05-08 17:20:21', '2022-05-08 17:20:21'),
(10, 8, 'Basic Salary ', '650000', '2022-05-08 17:20:21', '2022-05-08 17:20:21'),
(11, 9, 'Salary Grade ', 'A', '2022-05-09 00:17:06', '2022-05-09 00:17:06'),
(12, 9, 'Basic Salary ', '700000', '2022-05-09 00:17:06', '2022-05-09 00:17:06'),
(13, 10, 'Salary Grade ', 'B', '2022-05-09 00:57:00', '2022-05-09 00:57:00'),
(14, 10, 'Basic Salary ', '500000', '2022-05-09 00:57:00', '2022-05-09 00:57:00'),
(15, 11, 'Salary Grade ', 'A', '2022-05-09 12:05:41', '2022-05-09 12:05:41'),
(16, 11, 'Basic Salary ', '700000', '2022-05-09 12:05:42', '2022-05-09 12:05:42'),
(17, 12, 'Salary Grade ', 'C', '2022-05-09 22:33:19', '2022-05-09 22:33:19'),
(18, 12, 'Basic Salary ', '650000', '2022-05-09 22:33:19', '2022-05-09 22:33:19'),
(19, 12, 'Overtime Amount', '38000', '2022-05-09 22:33:19', '2022-05-09 22:33:19'),
(21, 13, 'Salary Grade ', 'A', '2022-05-09 23:02:14', '2022-05-09 23:02:14'),
(22, 13, 'Basic Salary ', '700000', '2022-05-09 23:02:14', '2022-05-09 23:02:14'),
(23, 13, 'Overtime Amount', '30000', '2022-05-09 23:02:14', '2022-05-09 23:02:14'),
(24, 14, 'Salary Grade ', 'B', '2022-05-11 15:59:42', '2022-05-11 15:59:42'),
(25, 14, 'Basic Salary ', '500000', '2022-05-11 15:59:42', '2022-05-11 15:59:42'),
(26, 15, 'Salary Grade ', 'B', '2022-05-23 13:55:57', '2022-05-23 13:55:57'),
(27, 15, 'Basic Salary ', '500000', '2022-05-23 13:55:57', '2022-05-23 13:55:57');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salary_payslip`
--

CREATE TABLE `tbl_salary_payslip` (
  `id` int(11) NOT NULL,
  `payslip_number` varchar(100) DEFAULT NULL,
  `salary_payment_id` int(5) NOT NULL,
  `payslip_generate_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_salary_payslip`
--

INSERT INTO `tbl_salary_payslip` (`id`, `payslip_number`, `salary_payment_id`, `payslip_generate_date`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '2022051', 12, '2022-05-11 06:24:29', 1, '2022-05-11 10:24:29', '2022-05-11 10:24:29'),
(2, '2022052', 10, '2022-05-11 07:34:59', 1, '2022-05-11 11:34:59', '2022-05-11 11:34:59'),
(3, '2022053', 9, '2022-05-11 07:38:16', 1, '2022-05-11 11:38:16', '2022-05-11 11:38:16'),
(4, '2022054', 14, '2022-05-11 11:59:53', 19, '2022-05-11 15:59:53', '2022-05-11 15:59:53');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salary_template`
--

CREATE TABLE `tbl_salary_template` (
  `salary_template_id` bigint(20) UNSIGNED NOT NULL,
  `salary_grade` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `basic_salary` int(11) NOT NULL,
  `overtime_salary` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_salary_template`
--

INSERT INTO `tbl_salary_template` (`salary_template_id`, `salary_grade`, `basic_salary`, `overtime_salary`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'A', 700000, NULL, 19, '2022-05-04 17:36:41', '2022-05-04 17:36:41'),
(2, 'B', 500000, NULL, 19, '2022-05-04 17:40:33', '2022-05-04 17:40:33'),
(3, 'C', 650000, NULL, 19, '2022-05-04 18:30:43', '2022-05-04 18:31:36'),
(4, 'D', 600000, NULL, 1, '2022-05-10 17:41:52', '2022-05-10 17:41:52'),
(5, 'E', 950000, NULL, 1, '2022-05-12 00:54:46', '2022-05-12 00:54:46'),
(6, 'F', 1200000, NULL, 1, '2022-05-12 01:05:58', '2022-05-12 13:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sales`
--

CREATE TABLE `tbl_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `exchange_rate` int(11) NOT NULL,
  `currency_code` int(11) NOT NULL,
  `invoice_amount` int(11) NOT NULL,
  `due_amount` int(11) NOT NULL,
  `invoice_tax` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_sales`
--

INSERT INTO `tbl_sales` (`id`, `reference_no`, `client_id`, `invoice_date`, `due_date`, `user_id`, `exchange_rate`, `currency_code`, `invoice_amount`, `due_amount`, `invoice_tax`, `status`, `created_at`, `updated_at`) VALUES
(4, 'ssd', 4, '2022-02-10', '2022-02-15', 1, 2350, 0, 2000000, 2000000, 0, 1, '2022-02-27 15:25:53', '2022-02-27 15:25:53'),
(5, 'ssd', 4, '2022-02-10', '2022-02-15', 1, 2350, 0, 2000000, 2000000, 0, 1, '2022-02-27 15:26:41', '2022-02-27 15:26:41'),
(6, 'ssd', 4, '2022-02-10', '2022-02-15', 1, 2350, 0, 2000000, 2000000, 0, 1, '2022-02-27 15:27:34', '2022-02-27 15:27:35'),
(7, 'ssd', 4, '2022-02-03', '2022-02-10', 1, 2350, 0, 2000000, 1998000, 360000, 2, '2022-02-28 00:06:30', '2022-02-28 00:13:58'),
(8, 'ssd', 3, '2022-02-11', '2022-02-11', 1, 2350, 0, 0, 0, 0, 1, '2022-02-28 01:51:08', '2022-02-28 01:51:08'),
(9, 'INV-9-2022-02-11', 3, '2022-02-11', '2022-02-11', 1, 2350, 0, 2000000, 2000000, 0, 1, '2022-02-28 01:51:48', '2022-02-28 01:51:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sales_items`
--

CREATE TABLE `tbl_sales_items` (
  `sales_items_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `tax_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_tax` decimal(20,2) NOT NULL DEFAULT 0.00,
  `quantity` decimal(10,2) DEFAULT 0.00,
  `total_cost` decimal(20,2) NOT NULL DEFAULT 0.00,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `unit` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL DEFAULT 0,
  `order_no` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_sales_items`
--

INSERT INTO `tbl_sales_items` (`sales_items_id`, `invoice_id`, `tax_rate`, `total_tax`, `quantity`, `total_cost`, `item_name`, `price`, `unit`, `items_id`, `order_no`, `created_at`, `updated_at`) VALUES
(3, 63, '0.18', '225000.00', '5.00', '1250000.00', '6', '250000.00', 'kgs', 6, 0, '2022-02-10 16:43:57', '2022-02-11 01:08:54'),
(35, 20, '0.00', '0.00', '4.00', '2000000.00', '6', '500000.00', 'pc', 6, 0, '2022-02-26 20:34:13', '2022-02-26 20:34:13'),
(36, 20, '0.18', '9000.00', '5.00', '50000.00', '6', '10000.00', 'pc', 6, 1, '2022-02-26 20:34:13', '2022-02-26 20:34:13'),
(37, 21, '0.00', '0.00', '4.00', '2000000.00', '6', '500000.00', 'pc', 6, 0, '2022-02-26 20:45:25', '2022-02-26 20:45:25'),
(38, 21, '0.18', '9000.00', '5.00', '50000.00', '6', '10000.00', 'pc', 6, 1, '2022-02-26 20:45:25', '2022-02-26 20:45:25'),
(39, 22, '0.00', '0.00', '4.00', '2000000.00', '6', '500000.00', 'pc', 6, 0, '2022-02-26 21:01:34', '2022-02-26 21:01:34'),
(40, 22, '0.18', '9000.00', '5.00', '50000.00', '6', '10000.00', 'pc', 6, 1, '2022-02-26 21:01:34', '2022-02-26 21:01:34'),
(41, 23, '0.00', '0.00', '4.00', '2000000.00', '6', '500000.00', 'pc', 6, 0, '2022-02-26 21:01:58', '2022-02-26 21:01:58'),
(42, 23, '0.18', '9000.00', '5.00', '50000.00', '6', '10000.00', 'pc', 6, 1, '2022-02-26 21:01:58', '2022-02-26 21:01:58'),
(43, 2, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-02-27 15:24:40', '2022-02-27 15:24:40'),
(44, 3, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-02-27 15:25:29', '2022-02-27 15:25:29'),
(45, 4, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-02-27 15:25:53', '2022-02-27 15:25:53'),
(46, 5, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-02-27 15:26:41', '2022-02-27 15:26:41'),
(47, 6, '0.00', '0.00', '4.00', '2000000.00', '2', '500000.00', 'pc', 2, 0, '2022-02-27 15:27:34', '2022-02-27 15:27:34'),
(48, 7, '0.18', '360000.00', '4.00', '2000000.00', '7', '500000.00', 'pc', 7, 0, '2022-02-28 00:06:30', '2022-02-28 00:06:30'),
(49, 8, '0.00', '0.00', '4.00', '2000000.00', '4', '500000.00', 'pc', 4, 0, '2022-02-28 01:51:08', '2022-02-28 01:51:08'),
(50, 9, '0.00', '0.00', '4.00', '2000000.00', '4', '500000.00', 'pc', 4, 0, '2022-02-28 01:51:48', '2022-02-28 01:51:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seassons`
--

CREATE TABLE `tbl_seassons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seasson_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `farm_id` int(100) DEFAULT NULL,
  `farmer_id` int(100) DEFAULT NULL,
  `start_date` date NOT NULL,
  `harvest_date` date NOT NULL,
  `crop_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_seassons`
--

INSERT INTO `tbl_seassons` (`id`, `seasson_name`, `farm_id`, `farmer_id`, `start_date`, `harvest_date`, `crop_name`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(5, 'january', 2, 1, '2022-03-10', '2022-03-24', '1', 1, '', '2022-03-23 21:00:35', '2022-04-05 14:55:12'),
(7, 'Jan 2022', 5, 1, '2022-03-01', '2022-10-18', '1', 20, '', '2022-04-11 15:03:43', '2022-04-11 15:03:43'),
(8, 'April Session', 7, 2, '2022-04-13', '2022-10-28', '1', 20, '', '2022-04-12 20:13:53', '2022-04-12 20:13:53'),
(9, 'dry 2022', 8, 3, '2022-04-14', '2022-09-29', '1', 39, '', '2022-04-21 14:26:26', '2022-04-21 14:26:26'),
(10, 'Masika 2022: Awadhi', 9, 7, '2022-05-11', '2022-09-27', '1', 20, '', '2022-05-11 21:19:03', '2022-05-11 21:19:03');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seed_types`
--

CREATE TABLE `tbl_seed_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `soil_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `properties` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int(11) NOT NULL,
  `water_volume` int(11) NOT NULL,
  `harvest_volume` int(11) NOT NULL,
  `crop_type_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_seed_types`
--

INSERT INTO `tbl_seed_types` (`id`, `name`, `soil_type`, `properties`, `age`, `water_volume`, `harvest_volume`, `crop_type_id`, `status`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'procrosmic', 'ph', 'ghh', 4, 8, 9, 1, 0, 1, NULL, NULL),
(10, '', '', '', 0, 0, 0, 0, 0, 0, '2022-03-21 20:17:43', '2022-03-21 20:17:43'),
(11, '', '', '', 0, 0, 0, 0, 0, 0, '2022-03-21 20:25:54', '2022-03-21 20:25:54');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sowings`
--

CREATE TABLE `tbl_sowings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seasson_id` int(100) NOT NULL,
  `crop_type` int(11) NOT NULL,
  `seed_type` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `qheck` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `nh` int(11) NOT NULL,
  `qn` int(11) NOT NULL,
  `total_cost` decimal(20,2) NOT NULL,
  `harvest_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_sowings`
--

INSERT INTO `tbl_sowings` (`id`, `seasson_id`, `crop_type`, `seed_type`, `user_id`, `qheck`, `cost`, `nh`, `qn`, `total_cost`, `harvest_date`, `created_at`, `updated_at`) VALUES
(1, 7, 1, 1, 20, 78, 2300, 7, 546, '1255800.00', '2022-09-28', '2022-04-12 21:18:26', '2022-04-12 21:18:26'),
(2, 10, 1, 6, 20, 20, 2000, 2, 40, '80000.00', '2022-05-11', '2022-05-11 21:33:25', '2022-05-11 21:33:25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_training`
--

CREATE TABLE `tbl_training` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `training_name` varchar(100) NOT NULL,
  `vendor_name` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `training_cost` decimal(25,2) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = pending, 1 = started, 2 = completed, 3 = terminated',
  `performance` tinyint(1) DEFAULT 0 COMMENT '0 = not concluded, 1 = satisfactory, 2 = average, 3 = poor, 4 = excellent',
  `remarks` text DEFAULT NULL,
  `attachment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_training`
--

INSERT INTO `tbl_training` (`id`, `staff_id`, `added_by`, `training_name`, `vendor_name`, `start_date`, `end_date`, `training_cost`, `status`, `performance`, `remarks`, `attachment`, `created_at`, `updated_at`) VALUES
(1, 31, 1, 'Use of Software', 'UjuziNet', '2022-04-25', '2022-04-26', '120000.00', 0, 0, NULL, NULL, '2022-04-22 18:54:11', '2022-04-22 18:58:22'),
(2, 34, 1, 'ADBOX', 'UjuziNet', '2022-04-22', '2022-04-22', '45000.00', 2, 4, 'two hours of training', NULL, '2022-04-22 18:59:58', '2022-04-22 19:00:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transactions`
--

CREATE TABLE `tbl_transactions` (
  `id` int(11) NOT NULL,
  `module` varchar(500) NOT NULL,
  `module_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `code_id` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `transaction_prefix` varchar(50) DEFAULT NULL,
  `type` enum('Income','Expense','Transfer') NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `debit` decimal(18,2) NOT NULL DEFAULT 0.00,
  `credit` decimal(18,2) NOT NULL DEFAULT 0.00,
  `total_balance` decimal(18,2) NOT NULL DEFAULT 0.00,
  `date` date NOT NULL,
  `paid_by` int(11) DEFAULT 0,
  `payment_methods_id` int(11) DEFAULT NULL,
  `status` enum('non_approved','paid','unpaid') DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `user_id` int(200) DEFAULT NULL,
  `added_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_transactions`
--

INSERT INTO `tbl_transactions` (`id`, `module`, `module_id`, `account_id`, `code_id`, `name`, `transaction_prefix`, `type`, `amount`, `debit`, `credit`, `total_balance`, `date`, `paid_by`, `payment_methods_id`, `status`, `notes`, `user_id`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Cargo Payment', 2, 29, 4, 'Cargo Payment with reference TRANS_PCL_8_lL14', 'TRANS_PCL_8_lL14', 'Income', '700.00', '0.00', '700.00', '10700.00', '2022-05-21', 3, 1, 'paid', 'This deposit is from cargo payment.The Reference is PCL-8', NULL, 1, '2022-05-21 23:18:35', '2022-05-21 23:20:32'),
(2, 'Mileage Payment', 1, 7, 16, 'Mileage Payment to  driver John Mashauri', 'TRANS_MLG-12-9-21/05/22', 'Expense', '25000.00', '25000.00', '0.00', '356200.00', '2022-05-21', 0, 2, 'paid', 'This expense is from mileage payment. DriverJohn Mashauri driving Truck scania', NULL, 1, '2022-05-21 23:53:32', '2022-05-21 23:53:32'),
(3, 'Cargo Payment', 4, 29, 4, 'Cargo Payment with referenceTRANS_PCL_1_uxce', 'TRANS_PCL_1_uxce', 'Income', '10000.00', '0.00', '10000.00', '53700.00', '2022-05-22', 4, 1, 'paid', 'This deposit is from cargo payment.The Reference is PCL-1', NULL, 1, '2022-05-22 15:35:08', '2022-05-22 15:35:08'),
(4, 'Courier Payment', 2, 6, 4, 'Courier Payment with reference TRANS_CM_1_ZoUR', 'TRANS_CM_1_ZoUR', 'Income', '100000.00', '0.00', '100000.00', '14050000.00', '2022-05-23', 3, 3, 'paid', 'This deposit is from courier payment.The Reference is CM-1', NULL, 1, '2022-05-23 13:21:40', '2022-05-23 13:33:37'),
(5, 'Salary Payment', 15, 6, NULL, 'Salary Payment for ', NULL, 'Expense', '544000.00', '544000.00', '0.00', '13506000.00', '2022-05-23', 1, 3, 'paid', 'This expense is from salary payment.The Reference is payment to   for the month April 2022', 45, 1, '2022-05-23 13:55:57', '2022-05-23 13:55:57'),
(6, 'Fuel Refill', 5, 32, 32, 'Fuel Refill Payment for truck T711 CFS SCANIA', NULL, 'Expense', '20000.00', '20000.00', '0.00', '-20000.00', '2022-05-23', 0, NULL, 'paid', 'This expense is from fuel refill payment. Payment to Truck T711 CFS SCANIA', NULL, 1, '2022-05-23 14:12:43', '2022-05-23 14:12:43'),
(7, 'Tire Payment', 1, 24, 16, 'Tire Payment with reference no PUR_TYRE_1_2022-05-17', 'TRANS_TYRE-1-8-2022-05-23', 'Expense', '1000.00', '1000.00', '0.00', '4000.00', '2022-05-23', 6, 3, 'paid', 'This expense is from tire payment. The Reference is PUR_TYRE_1_2022-05-17', NULL, 1, '2022-05-23 14:36:10', '2022-05-23 14:38:29'),
(8, 'Inventory Payment', 3, 27, 16, 'Inventory Payment with reference no PUR_INV-1-2022-04-19', 'TRANS_INV-1-7-23/05/22', 'Expense', '30000.00', '30000.00', '0.00', '20000.00', '2022-05-23', 1, 1, 'paid', 'This expense is from inventory payment. The Reference is PUR_INV-1-2022-04-19', NULL, 1, '2022-05-23 14:51:36', '2022-05-23 14:51:36'),
(9, 'Deposit', 2, 6, 33, 'Deposit Payment with referenceTRANS_DEP_IP5v', 'TRANS_DEP_IP5v', 'Income', '70000.00', '0.00', '70000.00', '13576000.00', '2022-05-23', 0, 3, 'paid', 'Deposit Payment with transaction id TRANS_DEP_IP5v', NULL, 1, '2022-05-23 15:21:42', '2022-05-23 15:21:42'),
(10, 'Expenses', 4, 7, 30, 'Expense Payment with referenceTRANS_EXP_7Hpg', 'TRANS_EXP_7Hpg', 'Expense', '10000.00', '10000.00', '0.00', '346200.00', '2022-05-23', 0, 2, 'paid', 'Expense Payment with transaction id TRANS_EXP_7Hpg', NULL, 1, '2022-05-23 15:54:52', '2022-05-23 15:54:52'),
(11, 'Transfer', 4, 6, NULL, 'Transfer Payment with reference  TRANS_G2hY', 'TRANS_G2hY', 'Transfer', '50000.00', '50000.00', '0.00', '13526000.00', '2022-05-23', 0, 3, 'paid', 'This is a transfer payment from CRDB to Cash Account', NULL, 1, '2022-05-23 16:14:48', '2022-05-23 16:14:48'),
(12, 'Transfer', 4, 32, NULL, 'Transfer Payment with reference  TRANS_G2hY', 'TRANS_G2hY', 'Transfer', '50000.00', '0.00', '50000.00', '30000.00', '2022-05-23', 0, 3, 'paid', 'This is a transfer payment from CRDB to Cash Account', NULL, 1, '2022-05-23 16:14:48', '2022-05-23 16:14:48'),
(13, 'Transfer', 6, 6, NULL, 'Transfer Payment with reference  TRANS_3gZw', 'TRANS_3gZw', 'Transfer', '10000.00', '10000.00', '0.00', '13516000.00', '2022-05-23', 0, 3, 'paid', 'This is a transfer payment from CRDB to MPESA', NULL, 1, '2022-05-23 16:19:17', '2022-05-23 16:19:17'),
(14, 'Transfer', 6, 27, NULL, 'Transfer Payment with reference  TRANS_3gZw', 'TRANS_3gZw', 'Transfer', '10000.00', '0.00', '10000.00', '30000.00', '2022-05-23', 0, 3, 'paid', 'This is a transfer payment from CRDB to MPESA', NULL, 1, '2022-05-23 16:19:17', '2022-05-23 16:19:17');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transfer`
--

CREATE TABLE `tbl_transfer` (
  `id` int(11) NOT NULL,
  `from_account_id` int(11) NOT NULL,
  `to_account_id` int(11) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `exchange_code` varchar(200) DEFAULT 'TZS',
  `exchange_rate` decimal(20,2) DEFAULT 1.00,
  `payment_method` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `status` varchar(200) DEFAULT '0' COMMENT '0=pending,1=approved',
  `notes` text DEFAULT NULL,
  `date` date NOT NULL,
  `type` varchar(20) DEFAULT 'Transfer',
  `added_by` int(200) NOT NULL,
  `approve_by` int(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_transfer`
--

INSERT INTO `tbl_transfer` (`id`, `from_account_id`, `to_account_id`, `amount`, `exchange_code`, `exchange_rate`, `payment_method`, `name`, `status`, `notes`, `date`, `type`, `added_by`, `approve_by`, `created_at`, `updated_at`) VALUES
(1, 6, 7, '5000000.00', 'TZS', '1.00', 3, 'TRANS_qvNb', '1', NULL, '2022-05-14', 'Transfer', 1, 1, '2022-05-15 12:56:49', '2022-05-15 13:03:31'),
(2, 6, 27, '50000.00', 'TZS', '1.00', 3, 'TRANS_n6Fz', '1', 'for monthly voucher', '2022-05-15', 'Transfer', 1, 1, '2022-05-15 13:09:16', '2022-05-15 13:10:11'),
(3, 28, 29, '10000.00', 'TZS', '1.00', 1, 'TRANS_N1LU', '1', NULL, '2022-05-15', 'Transfer', 1, 1, '2022-05-15 13:19:55', '2022-05-15 13:20:10'),
(4, 6, 32, '50000.00', 'TZS', '1.00', 3, 'TRANS_G2hY', '1', NULL, '2022-05-23', 'Transfer', 1, 1, '2022-05-23 16:14:11', '2022-05-23 16:14:48'),
(6, 6, 27, '10000.00', 'TZS', '1.00', 3, 'TRANS_3gZw', '1', 'for voucher', '2022-05-23', 'Transfer', 1, 1, '2022-05-23 16:19:05', '2022-05-23 16:19:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transport_quotations`
--

CREATE TABLE `tbl_transport_quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `crop_type` int(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `start_location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_location` varchar(110) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `due_amount` decimal(20,2) DEFAULT NULL,
  `tax` decimal(20,2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_transport_quotations`
--

INSERT INTO `tbl_transport_quotations` (`id`, `crop_type`, `quantity`, `start_location`, `end_location`, `client_id`, `warehouse_id`, `amount`, `due_amount`, `tax`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 4, 3455, 'morogoro', 'Dar es salaam', 2, 22, '230180000.00', '260580000.00', '41400000.00', 1, 19, '2022-03-22 12:42:31', '2022-03-29 14:57:36'),
(2, 1, 3455, 'Dar es salaam', 'Arusha', 25, 3, '500000.00', '0.00', '0.00', 2, 1, '2022-03-29 14:05:43', '2022-03-29 14:56:30'),
(3, 4, 200, 'Morogoro', 'Mbeya', 25, 22, '5000000.00', '5000000.00', '0.00', 0, 1, '2022-03-29 14:36:46', '2022-03-29 14:36:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_details`
--

CREATE TABLE `tbl_user_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `added_by` int(11) NOT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_user_details`
--

INSERT INTO `tbl_user_details` (`id`, `added_by`, `company_name`, `location`, `company_email`, `tin`, `website`, `logo`, `created_at`, `updated_at`) VALUES
(1, 15, 'Enamo Logistics', '', '', '123434', 'mangungo@gmail.com', NULL, '2022-03-15 19:47:34', '2022-03-15 19:47:34'),
(2, 15, 'Enamo Logistics', '', '', '123434', 'mangungo@gmail.com', NULL, '2022-03-15 19:49:17', '2022-03-15 19:49:17'),
(3, 15, 'Enamo Logistics', '', '', '123434', 'mangungo@gmail.com', NULL, '2022-03-15 19:50:15', '2022-03-15 19:50:15'),
(4, 16, 'Enamo Warehouse', '', '', '123434', 'mangungo@gmail.com', NULL, '2022-03-15 20:19:00', '2022-03-15 20:19:00'),
(5, 19, 'Enamo Logistics', '', '', '123434', 'mangungo@gmail.com', NULL, '2022-03-22 10:50:30', '2022-03-22 10:50:30'),
(6, 20, 'Enamo2 Ltd', '', '', '123434', 'mangungo@gmail.com', NULL, '2022-03-22 10:51:41', '2022-03-22 10:51:41'),
(7, 21, 'eliudi cooperaion', '', '', '123434', 'mangungo@gmail.com', NULL, '2022-03-22 10:52:56', '2022-03-22 10:52:56'),
(8, 24, 'Humber Logistic Compay', '', '', '11223344', 'crystal.co.tz', NULL, '2022-03-22 09:38:43', '2022-03-22 09:38:43'),
(9, 25, 'Enamo Logistics', '', '', '123434', 'mangungo@gmail.com', NULL, '2022-03-22 11:13:59', '2022-03-22 11:13:59'),
(10, 26, 'Test WareHouse', '', '', '11223344', 'crystal.co.tz', NULL, '2022-03-22 21:39:14', '2022-03-22 21:39:14'),
(11, 29, 'Mwakisepa FARM Manager', '', '', '-', '-', NULL, '2022-04-11 12:06:51', '2022-04-11 12:06:51'),
(12, 35, 'Cleo for E.A', '', '', 'N/A', 'N/A', NULL, '2022-04-19 17:51:08', '2022-04-19 17:51:08'),
(13, 39, 'Sia Agronomy', '', '', '45673', 'www.agronomy.co.tz', NULL, '2022-04-21 14:18:57', '2022-04-21 14:18:57'),
(14, 40, 'GOD HALLMARK SACCOS LTD', '', '', '11223344', 'crystal.co.tz', NULL, '2022-04-30 16:06:29', '2022-04-30 16:06:29'),
(15, 47, 'Malezi Ya Watoto App', '', '', '125 926 940', 'www.maleziyawatoto.co.tz', NULL, '2022-05-14 22:28:12', '2022-05-14 22:28:12'),
(16, 49, 'Secure Logistics Ltd', '', '', '131750455', 'www.securelogistics.co.tz', NULL, '2022-05-15 14:14:49', '2022-05-15 14:14:49'),
(17, 52, 'ABC courier', '', '', '123434', 'mangungo@gmail.com', NULL, '2022-05-17 09:48:04', '2022-05-17 09:48:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_warehouses`
--

CREATE TABLE `tbl_warehouses` (
  `id` int(100) NOT NULL,
  `warehouse_name` varchar(100) NOT NULL,
  `added_by` int(100) NOT NULL,
  `warehouse_manager` varchar(100) NOT NULL,
  `region_id` int(100) NOT NULL,
  `district_id` int(100) NOT NULL,
  `manager_contact` varchar(100) NOT NULL,
  `insurance_id` int(100) NOT NULL,
  `updated_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_warehouses`
--

INSERT INTO `tbl_warehouses` (`id`, `warehouse_name`, `added_by`, `warehouse_manager`, `region_id`, `district_id`, `manager_contact`, `insurance_id`, `updated_at`, `created_at`) VALUES
(3, 'azam food prodact', 1, 'baklesa', 10, 53, '06543217724', 1, '2022-02-21 03:29:16.000000', '2022-02-21 03:29:16.000000'),
(4, 'modeuji', 2, 'mooo', 10, 53, '06543217724', 1, '2022-02-21 03:31:45.000000', '2022-02-21 03:31:45.000000'),
(21, 'testing ware house', 1, 'said', 15, 88, '0712457724', 0, '2022-03-22 11:40:50.000000', '2022-03-22 11:40:50.000000'),
(22, 'Kilosa Trading Company', 16, 'John Hassan', 12, 68, '07123455', 0, '2022-03-22 12:00:50.000000', '2022-03-22 12:00:50.000000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_weedings`
--

CREATE TABLE `tbl_weedings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seasson_id` int(100) NOT NULL,
  `process` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `effect` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chemical_status` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weed_cost` decimal(20,2) DEFAULT NULL,
  `acre` decimal(20,2) NOT NULL,
  `chemical` decimal(20,2) DEFAULT NULL,
  `cost` decimal(20,2) DEFAULT NULL,
  `total_cost` decimal(20,2) NOT NULL,
  `added_by` int(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_weedings`
--

INSERT INTO `tbl_weedings` (`id`, `seasson_id`, `process`, `method`, `name`, `effect`, `chemical_status`, `weed_cost`, `acre`, `chemical`, `cost`, `total_cost`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 8, '1', 'Chemical Weed Control', 'test suppler', 'Drying plants', 'Yes', NULL, '1.00', '16.00', '3400.00', '54400.00', 20, '2022-04-12 21:23:49', '2022-04-12 21:23:49');

-- --------------------------------------------------------

--
-- Table structure for table `top_up_center`
--

CREATE TABLE `top_up_center` (
  `id` int(11) NOT NULL,
  `from_account_id` int(11) NOT NULL,
  `to_account_id` int(11) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `due_amount` decimal(20,2) NOT NULL,
  `exchange_code` varchar(200) DEFAULT 'TZS',
  `exchange_rate` decimal(20,2) DEFAULT 1.00,
  `payment_method` int(11) NOT NULL,
  `reference` varchar(200) DEFAULT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `status` varchar(200) DEFAULT '0' COMMENT '0=pending,1=approved,2=completed',
  `reversed` int(200) DEFAULT 0,
  `notes` text DEFAULT NULL,
  `date` date NOT NULL,
  `type` varchar(20) DEFAULT 'Top Up',
  `added_by` int(200) NOT NULL,
  `approve_by` int(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `top_up_center`
--

INSERT INTO `top_up_center` (`id`, `from_account_id`, `to_account_id`, `amount`, `due_amount`, `exchange_code`, `exchange_rate`, `payment_method`, `reference`, `reference_no`, `status`, `reversed`, `notes`, `date`, `type`, `added_by`, `approve_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '500000.00', '-7344750.00', 'TZS', '1.00', 2, 'TC_giSW', NULL, '2', 0, NULL, '2022-05-16', 'Top Up', 50, 50, '2022-05-16 20:22:49', '2022-05-25 19:29:19'),
(2, 3, 4, '20000.00', '-27397400.00', 'TZS', '1.00', 2, 'TC_HDef', NULL, '1', 0, NULL, '2022-05-17', 'Top Up', 50, 50, '2022-05-17 16:02:35', '2022-05-24 22:35:32'),
(3, 2, 5, '1500000.00', '-10562919.94', 'TZS', '1.00', 2, 'TC_nJKu', NULL, '1', 0, NULL, '2022-05-18', 'Top Up', 50, 50, '2022-05-18 19:02:02', '2022-05-25 12:05:08'),
(4, 2, 5, '100000.00', '100000.00', 'TZS', '1.00', 2, 'TC_Hq7K', NULL, '0', 0, NULL, '2022-05-19', 'Top Up', 50, NULL, '2022-05-19 13:10:26', '2022-05-19 13:10:26'),
(5, 2, 5, '100000.00', '100000.00', 'TZS', '1.00', 2, 'TC_p3jV', NULL, '0', 0, NULL, '2022-05-19', 'Top Up', 50, NULL, '2022-05-19 13:10:26', '2022-05-19 13:10:26'),
(6, 2, 5, '150000.00', '150000.00', 'TZS', '1.00', 2, 'TC_6XGj', NULL, '0', 0, NULL, '2022-05-20', 'Top Up', 50, NULL, '2022-05-20 14:21:38', '2022-05-20 14:21:38'),
(7, 1, 1, '100.00', '100.00', 'TZS', '1.00', 1, 'TC_rphn', 'erreer', '0', 0, NULL, '2022-05-21', 'Top Up', 50, NULL, '2022-05-21 11:16:50', '2022-05-21 11:16:50'),
(8, 3, 4, '36800.00', '36800.00', 'TZS', '1.00', 2, 'TC_Hxp6', '789', '2', 0, NULL, '2022-05-25', 'Top Up', 50, 50, '2022-05-25 19:20:08', '2022-05-25 19:21:36'),
(9, 3, 4, '2000.00', '2000.00', 'TZS', '1.00', 2, 'TC_c0NW', '790', '2', 0, NULL, '2022-05-25', 'Top Up', 50, 50, '2022-05-25 19:28:36', '2022-05-25 19:29:35');

-- --------------------------------------------------------

--
-- Table structure for table `top_up_operator`
--

CREATE TABLE `top_up_operator` (
  `id` int(11) NOT NULL,
  `top_up_id` varchar(500) NOT NULL,
  `from_account_id` int(11) NOT NULL,
  `to_account_id` int(11) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `due_amount` decimal(20,2) NOT NULL,
  `exchange_code` varchar(200) DEFAULT 'TZS',
  `exchange_rate` decimal(20,2) DEFAULT 1.00,
  `payment_method` int(11) NOT NULL,
  `reference` varchar(200) DEFAULT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `status` varchar(200) DEFAULT '0' COMMENT '0=pending,1=approved,2=completed',
  `reversed` int(200) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  `date` date NOT NULL,
  `type` varchar(20) DEFAULT 'Top Up',
  `added_by` int(200) NOT NULL,
  `approve_by` int(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `top_up_operator`
--

INSERT INTO `top_up_operator` (`id`, `top_up_id`, `from_account_id`, `to_account_id`, `amount`, `due_amount`, `exchange_code`, `exchange_rate`, `payment_method`, `reference`, `reference_no`, `status`, `reversed`, `notes`, `date`, `type`, `added_by`, `approve_by`, `created_at`, `updated_at`) VALUES
(1, '', 7, 1, '500000.00', '0.00', 'TZS', '1.00', 2, 'TO_oL5Z', NULL, '2', 0, NULL, '2022-05-16', 'Top Up', 50, 50, '2022-05-16 20:16:06', '2022-05-17 11:11:55'),
(2, '', 7, 1, '23000.00', '0.00', 'TZS', '1.00', 2, 'TO_7Ogd', NULL, '2', 1, NULL, '2022-05-17', 'Top Up', 1, 50, '2022-05-17 11:12:27', '2022-05-25 23:24:39'),
(3, '', 7, 2, '4000000.00', '0.00', 'TZS', '1.00', 2, 'TO_0McG', NULL, '1', 1, NULL, '2022-05-16', 'Top Up', 50, 50, '2022-05-17 12:20:19', '2022-05-25 20:11:36'),
(4, '', 7, 3, '58800.00', '0.00', 'TZS', '1.00', 2, 'TO_Qcup', NULL, '2', 0, NULL, '2022-05-17', 'Top Up', 50, 50, '2022-05-17 16:01:25', '2022-05-25 19:29:59'),
(6, '', 7, 3, '50000.00', '50000.00', 'TZS', '1.00', 2, 'TO_Pvr6', '650', '1', 0, NULL, '2022-05-25', 'Top Up', 50, 50, '2022-05-26 02:44:09', '2022-05-26 02:44:32');

-- --------------------------------------------------------

--
-- Table structure for table `trucks`
--

CREATE TABLE `trucks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `truck_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `truck_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` decimal(20,2) NOT NULL,
  `fuel` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `truck_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'Available',
  `driver_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tyre` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reading` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `connect_horse` int(11) DEFAULT 0,
  `connect_trailer` int(11) DEFAULT 0,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trucks`
--

INSERT INTO `trucks` (`id`, `truck_name`, `reg_no`, `driver`, `truck_type`, `capacity`, `fuel`, `type`, `truck_status`, `driver_status`, `tyre`, `staff`, `location`, `position`, `reading`, `connect_horse`, `connect_trailer`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Scania', 'T620DGA', NULL, 'Horse', '30000.00', 'Diesel', 'owned', 'Available', NULL, NULL, NULL, '2', NULL, NULL, 0, 0, 19, '2022-04-05 20:56:07', '2022-04-28 23:24:49'),
(2, 'Lorry', 'T686 CLG', NULL, 'Horse', '300.00', 'Diesel', 'owned', 'Available', NULL, NULL, NULL, '1', NULL, NULL, 0, 0, 19, '2022-04-21 17:26:45', '2022-04-24 02:45:46'),
(3, 'Suzuki', 'T456 DAZ', NULL, 'Vehicle', '100.00', 'Diesel', 'owned', 'Available', NULL, NULL, NULL, '9', NULL, '100', 0, 0, 19, '2022-04-21 17:29:28', '2022-05-19 22:58:22'),
(4, 'Scania Mende', 'T620DGA', NULL, 'Horse', '30000.00', 'Disel', 'owned', 'Available', NULL, NULL, NULL, '1', NULL, NULL, 0, 0, 19, '2022-04-22 22:45:34', '2022-04-23 17:35:28'),
(5, 'Toyota', 'T389 BAS', NULL, 'Vehicle', '1000.00', 'Diesel', 'non_owned', 'Available', NULL, '5', '16', '16', 'Rear', '85', 0, 0, 1, '2022-04-25 22:17:09', '2022-05-20 23:01:35'),
(6, 'Scania Mende 12345', 'T621DGA', NULL, 'Horse', '30000.00', 'Disel', 'owned', 'Available', NULL, NULL, NULL, '1', NULL, NULL, 0, 0, 19, '2022-04-28 22:23:48', '2022-04-28 23:27:07'),
(7, 'Scania 420P', 'T629DGA', NULL, 'Horse', '30000.00', 'GAS', 'owned', 'Unavailable', NULL, NULL, NULL, '18', NULL, NULL, 0, 0, 19, '2022-04-28 22:53:23', '2022-05-19 21:49:10'),
(8, 'scania', 'TD234', '3', 'Horse', '4000.00', 'Diesel', 'non_owned', 'Available', NULL, NULL, NULL, '16', NULL, NULL, 0, 0, 1, '2022-05-04 13:10:38', '2022-05-20 22:59:21'),
(9, 'T711 CFS SCANIA', 'T711 CFS', NULL, 'Horse', '300000.00', 'DIESEL', 'owned', 'Available', NULL, '1', '16', '18', 'Diff', NULL, 0, 0, 53, '2022-05-17 13:25:12', '2022-05-23 20:46:53'),
(10, 'Semi Trailer', 'T888CDF', NULL, 'Trailer', '5000.00', 'Diesel', 'owned', 'Available', NULL, NULL, NULL, '2', NULL, '150', 0, 0, 1, '2022-05-20 17:38:22', '2022-05-23 20:46:53'),
(11, 'Trailer A', 'T390BYK', NULL, 'Trailer', '2500.00', 'Diesel', 'owned', 'Available', NULL, '3', '26', '16', 'Trailer', '180', 0, 0, 1, '2022-05-20 20:11:02', '2022-05-23 20:26:33');

-- --------------------------------------------------------

--
-- Table structure for table `truck_insurances`
--

CREATE TABLE `truck_insurances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `broker_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire_date` date NOT NULL,
  `cover` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(8,2) NOT NULL,
  `cover_date` date NOT NULL,
  `truck_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `truck_insurances`
--

INSERT INTO `truck_insurances` (`id`, `broker_name`, `company`, `expire_date`, `cover`, `value`, `cover_date`, `truck_id`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Swai Insurance Agent', 'Jubilee Insurance', '2022-04-15', 'Premium', '138000.00', '2021-03-15', '1', 19, '2022-04-15 21:03:16', '2022-04-15 21:03:16'),
(2, 'Swai Insurance Agent', 'Jubilee Insurance', '2023-07-28', 'Premium', '47000.00', '2022-04-28', '6', 19, '2022-04-28 22:24:37', '2022-04-28 22:24:37'),
(3, 'KANGAROO INSU BR', 'NIC', '2023-05-17', 'Premium', '300000.00', '2022-05-17', '9', 53, '2022-05-17 13:27:11', '2022-05-17 13:27:11');

-- --------------------------------------------------------

--
-- Table structure for table `tyres`
--

CREATE TABLE `tyres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `serial_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `truck_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `assign_reference` int(11) DEFAULT 0,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tyres`
--

INSERT INTO `tyres` (`id`, `serial_no`, `reference`, `brand_id`, `purchase_id`, `purchase_date`, `location`, `truck_id`, `status`, `assign_reference`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Super Doll_1_1_2022', '67890', '1', '1', '2022-05-17', '1', '9', 1, 1, 53, '2022-05-17 14:00:34', '2022-05-17 14:02:28'),
(2, 'Super Doll_1_2_2022', '4566', '1', '1', '2022-05-17', '1', '', 0, 1, 53, '2022-05-17 14:00:34', '2022-05-19 20:29:27'),
(3, 'Super Doll_1_3_2022', '1115', '1', '1', '2022-05-17', '1', '11', 1, 1, 53, '2022-05-17 14:00:34', '2022-05-23 20:26:33'),
(4, 'Super Doll_2_1_2022', NULL, '1', '2', '2022-05-18', '1', '', 0, 0, 1, '2022-05-19 19:11:38', '2022-05-19 19:11:38'),
(5, 'Super Doll_2_2_2022', '12345', '1', '2', '2022-05-18', '1', '5', 1, 1, 1, '2022-05-19 19:11:38', '2022-05-19 22:58:22'),
(6, 'Super Doll_3_1_2022', '34512', '1', '3', '2022-05-18', '1', '', 2, 1, 1, '2022-05-19 21:36:59', '2022-05-19 21:49:10');

-- --------------------------------------------------------

--
-- Table structure for table `tyre_activities`
--

CREATE TABLE `tyre_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `activity` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tyre_activities`
--

INSERT INTO `tyre_activities` (`id`, `module`, `module_id`, `date`, `activity`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Purchase', '1', '2022-05-17', 'Purchase Created', 53, '2022-05-17 13:56:52', '2022-05-17 13:56:52'),
(2, 'Purchase', '1', '2022-05-17', 'Purchase Approved', 53, '2022-05-17 13:58:20', '2022-05-17 13:58:20'),
(3, 'Purchase', '1', '2022-05-17', 'Purchase Updated to Good Receive', 53, '2022-05-17 14:00:34', '2022-05-17 14:00:34'),
(4, 'Assign Tyre', '9', '2022-05-17', 'Tyre Super Doll_1_1_2022 Assigned to T711 CFS SCANIA', 53, '2022-05-17 14:02:28', '2022-05-17 14:02:28'),
(5, 'Purchase', '2', '2022-05-18', 'Purchase Created', 1, '2022-05-19 19:10:58', '2022-05-19 19:10:58'),
(6, 'Purchase', '2', '2022-05-19', 'Purchase Approved', 1, '2022-05-19 19:11:17', '2022-05-19 19:11:17'),
(7, 'Purchase', '2', '2022-05-18', 'Purchase Updated to Good Receive', 1, '2022-05-19 19:11:38', '2022-05-19 19:11:38'),
(8, 'Tyre Reference Assigned', '5', '2022-05-19', 'Tyre Super Doll_2_2_2022 Assigned Reference no 12345', 1, '2022-05-19 20:14:56', '2022-05-19 20:14:56'),
(10, 'Tyre Reference Assigned', '2', '2022-05-19', 'Tyre Super Doll_1_2_2022 Assigned Reference no 4566', 53, '2022-05-19 20:29:27', '2022-05-19 20:29:27'),
(11, 'Assign Tyre', '3', '2022-05-19', 'Tyre 12345 Assigned to Suzuki', 1, '2022-05-19 21:00:56', '2022-05-19 21:00:56'),
(12, 'Purchase', '3', '2022-05-18', 'Purchase Created', 1, '2022-05-19 21:35:57', '2022-05-19 21:35:57'),
(13, 'Purchase', '3', '2022-05-19', 'Purchase Approved', 1, '2022-05-19 21:36:08', '2022-05-19 21:36:08'),
(14, 'Purchase', '3', '2022-05-18', 'Purchase Updated to Good Receive', 1, '2022-05-19 21:36:59', '2022-05-19 21:36:59'),
(15, 'Tyre Reference Assigned', '6', '2022-05-19', 'Tyre Super Doll_3_1_2022 Assigned Reference no 34512', 1, '2022-05-19 21:37:41', '2022-05-19 21:37:41'),
(16, 'Assign Tyre', '7', '2022-05-19', 'Tyre 34512 Assigned to Scania 420P', 1, '2022-05-19 21:38:55', '2022-05-19 21:38:55'),
(17, 'Tyre Return', '1', '2022-05-19', 'Return of Tyre 34512 is Created', 1, '2022-05-19 21:46:47', '2022-05-19 21:46:47'),
(18, 'Tyre Return', '1', '2022-05-19', 'Return of Tyre 34512 is Approved', 1, '2022-05-19 21:49:10', '2022-05-19 21:49:10'),
(19, 'Tyre Reallocation', '1', '2022-05-19', 'Reallocation of Tyre 12345 is Created', 1, '2022-05-19 22:51:40', '2022-05-19 22:51:40'),
(20, 'Tyre Reallocation', '1', '2022-05-19', 'Reallocation of Tyre 12345 is Updated', 1, '2022-05-19 22:55:35', '2022-05-19 22:55:35'),
(21, 'Tyre Reallocation', '1', '2022-05-19', 'Reallocation of Tyre 12345 is Approved', 1, '2022-05-19 22:58:22', '2022-05-19 22:58:22'),
(22, 'Purchase Payment', '1', '2022-05-23', 'Purchase Payment Created', 1, '2022-05-23 14:36:10', '2022-05-23 14:36:10'),
(23, 'Purchase Payment', '1', '2022-05-23', 'Purchase Payment Updated', 1, '2022-05-23 14:37:11', '2022-05-23 14:37:11'),
(24, 'Purchase Payment', '1', '2022-05-23', 'Purchase Payment Updated', 1, '2022-05-23 14:38:29', '2022-05-23 14:38:29'),
(25, 'Tyre Reference Assigned', '3', '2022-05-23', 'Tyre Super Doll_1_3_2022 Assigned Reference no 1115', 1, '2022-05-23 20:06:44', '2022-05-23 20:06:44'),
(26, 'Tyre Reference Assigned', '3', '2022-05-23', 'Tyre Super Doll_1_3_2022 Assigned Reference no 1115', 1, '2022-05-23 20:07:37', '2022-05-23 20:07:37'),
(27, 'Tyre Reference Assigned', '3', '2022-05-23', 'Tyre Super Doll_1_3_2022 Assigned Reference no 1115', 1, '2022-05-23 20:07:59', '2022-05-23 20:07:59'),
(28, 'Tyre Reference Assigned', '3', '2022-05-23', 'Tyre Super Doll_1_3_2022 Assigned Reference no 1115', 1, '2022-05-23 20:10:43', '2022-05-23 20:10:43'),
(29, 'Assign Tyre', '10', '2022-05-23', 'Tyre 1115 Assigned to Semi Trailer', 1, '2022-05-23 20:21:59', '2022-05-23 20:21:59'),
(30, 'Tyre Reallocation', '2', '2022-05-23', 'Reallocation of Tyre 1115 is Created', 1, '2022-05-23 20:26:23', '2022-05-23 20:26:23'),
(31, 'Tyre Reallocation', '2', '2022-05-23', 'Reallocation of Tyre 1115 is Approved', 1, '2022-05-23 20:26:33', '2022-05-23 20:26:33');

-- --------------------------------------------------------

--
-- Table structure for table `tyre_brands`
--

CREATE TABLE `tyre_brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `manufacturer` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `unit` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(200) DEFAULT NULL,
  `size` decimal(10,0) NOT NULL,
  `added_by` int(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tyre_brands`
--

INSERT INTO `tyre_brands` (`id`, `manufacturer`, `brand`, `price`, `unit`, `quantity`, `size`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'Super Doll', 'Super Doll', '5000.00', 'PC', 21, '17', 19, '2022-04-06 10:03:28', '2022-05-23 20:21:59');

-- --------------------------------------------------------

--
-- Table structure for table `tyre_disposals`
--

CREATE TABLE `tyre_disposals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tyre_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `staff` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `location` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tyre_histories`
--

CREATE TABLE `tyre_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items_id` int(11) NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `supplier_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tyre_histories`
--

INSERT INTO `tyre_histories` (`id`, `purchase_id`, `items_id`, `quantity`, `supplier_id`, `purchase_date`, `location`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', 1, '3.00', '6', '2022-05-17', '1', 53, '2022-05-17 14:00:34', '2022-05-17 14:00:34'),
(2, '2', 1, '2.00', '4', '2022-05-18', '1', 1, '2022-05-19 19:11:38', '2022-05-19 19:11:38'),
(3, '3', 1, '1.00', '1', '2022-05-18', '1', 1, '2022-05-19 21:36:59', '2022-05-19 21:36:59');

-- --------------------------------------------------------

--
-- Table structure for table `tyre_payments`
--

CREATE TABLE `tyre_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trans_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `date` date NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` int(200) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tyre_payments`
--

INSERT INTO `tyre_payments` (`id`, `purchase_id`, `trans_id`, `amount`, `date`, `payment_method`, `notes`, `account_id`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '1', 'TRANS_TYRE-1-8-2022-05-23', '1000.00', '2022-05-23', '3', NULL, 24, 1, '2022-05-23 14:36:10', '2022-05-23 14:38:29');

-- --------------------------------------------------------

--
-- Table structure for table `tyre_reallocations`
--

CREATE TABLE `tyre_reallocations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tyre_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `staff` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source_truck` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination_truck` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source_reading` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `destination_reading` int(200) DEFAULT NULL,
  `position` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tyre_reallocations`
--

INSERT INTO `tyre_reallocations` (`id`, `tyre_id`, `date`, `staff`, `source_truck`, `destination_truck`, `status`, `source_reading`, `destination_reading`, `position`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '5', '2022-05-19', '16', '3', '5', '1', '100', 85, 'Rear', 1, '2022-05-19 22:51:40', '2022-05-19 22:58:22'),
(2, '3', '2022-05-23', '26', '10', '11', '1', '150', 180, 'Trailer', 1, '2022-05-23 20:26:23', '2022-05-23 20:26:33');

-- --------------------------------------------------------

--
-- Table structure for table `tyre_returns`
--

CREATE TABLE `tyre_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tyre_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `truck_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `status` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tyre_returns`
--

INSERT INTO `tyre_returns` (`id`, `tyre_id`, `truck_id`, `staff`, `location`, `date`, `status`, `added_by`, `created_at`, `updated_at`) VALUES
(1, '6', '7', '16', '1', '2022-05-19', '1', 1, '2022-05-19 21:46:47', '2022-05-19 21:49:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation_id` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `added_by`, `fname`, `lname`, `phone`, `address`, `email`, `email_verified_at`, `password`, `role`, `department_id`, `designation_id`, `status`, `country`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', '1', 'superadmin', 'admin', '0765454334', 'po box 12 Dar es salaam', 'admin@gmail.com', '2021-12-04 17:17:45', '$2y$10$mnh0GE0MQ5CxKMgG.WXOhO9sQBhtuPT0qDrO83Gi79ZPI/CcFSyg2', NULL, NULL, NULL, 1, 'Tanzania', 'TWQ3cadD8dE6BYV9MQSWiOapzF4gqKBnboQoVeChJaaqpoDgYxbYZ2v332iK', '2021-12-04 17:17:45', '2021-12-04 17:17:45', NULL),
(15, 'Test EMA', '15', '', '', '', 'dododma', 'sam@gmail.com', NULL, '$2y$10$dYgac3QWW3S5fBLA0mz9ceuSoIKYWRQD1hY9mVBDy/yjdgOFSB7/C', NULL, NULL, NULL, 0, NULL, NULL, '2022-03-15 17:25:05', '2022-03-15 17:25:05', NULL),
(16, 'warehouse', '16', NULL, '', '0712324323', 'dododma', 'warehouse@gmail.com', NULL, '$2y$10$FpCjodr/2qI4AW0cQjsfdeoIe/bbJT2g6kOMlJuOKNUl/br5xaWFi', NULL, NULL, NULL, 0, NULL, NULL, '2022-03-15 20:18:07', '2022-03-15 20:18:07', NULL),
(17, 'sam', '17', NULL, '', '0712324323', 'dododma', 'sam2@gmail.com', NULL, '$2y$10$dF10/31/PtUzEVUjYLkiROdd9030zsvBF5PPsWHjo4cHcGBZJE6A6', NULL, NULL, NULL, 0, NULL, NULL, '2022-03-15 22:54:07', '2022-03-15 22:54:07', NULL),
(18, 'samwel', '18', NULL, '', '0712324323', 'dododma', 'farmer@gmail.com', NULL, '$2y$10$YAdpHptpH/wO9HVoPlmmZOf8fnntI.ePnG0alE1F4PvVp6vUCDZ9.', NULL, NULL, NULL, 0, NULL, NULL, '2022-03-22 10:48:44', '2022-03-22 10:48:44', NULL),
(19, 'sam2', '19', NULL, '', '0712324323', 'dododma', 'logistic@gmail.com', NULL, '$2y$10$A/lUHsxrzC6zm71XAZ0vKuHsmSZ6/8B0WJ8Y5PbQJkXeWtu8VwJgW', NULL, '5', '5', 0, NULL, '7bVxGdXsfZhLZBKWzMh5GqwgikgDMxnEFlExCNu7ZlfA2QvRvskpulzH8CcT', '2022-03-22 10:49:57', '2022-05-09 12:35:21', NULL),
(20, 'sam3', '20', NULL, '', '0712324323', 'dododma', 'agronomy@gmail.com', NULL, '$2y$10$Xysl2bwdWyw/EpIl/n2jSee6g/xSZ6NA8Qtmmv7BtSsjQDh4RtNCK', NULL, '5', '6', 0, NULL, NULL, '2022-03-22 10:51:19', '2022-05-08 19:50:24', NULL),
(21, 'sam', '21', NULL, '', '0712324323', 'dodoma', 'cooperate@gmail.com', NULL, '$2y$10$mUIRuFWJ3k3XC6FPVAua5.xu15UaZ5CcyTFph7u18GNoIjmGsdt4W', NULL, NULL, NULL, 0, NULL, NULL, '2022-03-22 10:52:34', '2022-03-22 10:52:34', NULL),
(23, 'sam', '23', NULL, '', '0712324323', 'dododma', 'agrodealer@gmail.com', NULL, '$2y$10$PZZyhc2ci/TsMfFRRqcQR.pIbd1/HwfNM6FU0FkOvcMXttdxR5JZ.', 'agronomy', NULL, NULL, 0, NULL, NULL, '2022-03-22 09:31:11', '2022-03-22 09:31:11', NULL),
(24, 'Tenganamba', '24', NULL, '', '0712722684', 'Iringa-town', 'sales@crystal.co.tz', NULL, '$2y$10$l2uQOFr/kbbM3hUVy47PWuCZGD2l0woWAcLa9gesh4APxsB2CFkq6', NULL, NULL, NULL, 0, NULL, NULL, '2022-03-22 09:36:37', '2022-03-22 09:36:37', NULL),
(25, 'sam', '25', NULL, '', '0712324323', 'dododma', 'client@gmail.com', NULL, '$2y$10$q3UGGxtznzyr23uPFhmUDuejXpmeoR9l.h9LPyIblGksDbkyS6GiS', NULL, NULL, NULL, 0, NULL, NULL, '2022-03-22 11:13:39', '2022-03-22 11:13:40', NULL),
(26, 'warehouse3', '26', NULL, '', '37662222', 'Singida Iramba', 'warehouse2@gmail.com', NULL, '$2y$10$lfchFqT0XfhLXWRFBffJc.ZaGksW5gAPmFG295lBAQWN15uCq1xPC', NULL, NULL, NULL, 0, NULL, NULL, '2022-03-22 21:38:33', '2022-03-22 21:38:34', NULL),
(27, 'Given  Hubert Njiro', '27', NULL, '', '0783730146', '258. Mbeya', 'njirogiven@protonmail.com', NULL, '$2y$10$dlTI2s9IBoDEKz0EW6j0NuO82NkZLVEfAMMECpbuEEI9ezRXaOVnC', NULL, NULL, NULL, 0, NULL, NULL, '2022-04-04 15:28:40', '2022-04-04 15:28:40', NULL),
(28, 'Jushi Entreprises Limited', '28', NULL, '', '0788940955', '6627', 'jushientreprisesltd@gmail.com', NULL, '$2y$10$Je/fvdaG1/Ox6ysx4xc3E.k4FMF/AuPQfotT6M2qi3kUNBNW8wk1W', NULL, NULL, NULL, 0, NULL, NULL, '2022-04-11 12:01:19', '2022-04-11 12:01:19', NULL),
(29, 'Juma Ally', '29', NULL, '', '0672376876', 'Agronomy', 'agronomy1@gmail.com', NULL, '$2y$10$4066yLZU0ND1W.8pDoLlOuoYT26mqoodjkETqYsCAwqq/ezWoaKk.', 'agronomy', NULL, NULL, 0, NULL, NULL, '2022-04-11 12:05:45', '2022-04-11 12:05:45', NULL),
(30, 'Taty Emmanuel', '30', NULL, '', '+255754371256', 'P.O Box 70390 Dar Es Salaam', 'taty_e@hotmail.com', NULL, '$2y$10$ez9iECOD17mUna/7AiepUeuaCywdi0pJOGZdIWqjwVny8b4AN0vTW', NULL, NULL, NULL, 0, NULL, NULL, '2022-04-11 16:57:25', '2022-04-11 16:57:25', NULL),
(31, 'Noel', '31', NULL, '', '+255767460717', 'Alex', 'Alexnoel81@gmail.com', NULL, '$2y$10$XGP0iOGO6iQV8guMNyBCHutlwRS7F/ZLfQX3.puM19nhwBCp/1z6K', NULL, NULL, NULL, 0, NULL, NULL, '2022-04-12 00:38:24', '2022-04-12 00:38:24', NULL),
(32, 'Chacha Revocatus', '32', NULL, '', '+255752689822', '338 Bunda', 'revocatus86@gmail.com', NULL, '$2y$10$Mwt.ei0Yg4fyvs/oVzb2sO.Ivklg6OWdaca9TQJ/RMg/8/WW9ayKK', NULL, NULL, NULL, 0, NULL, NULL, '2022-04-19 12:44:22', '2022-04-19 12:44:22', NULL),
(33, 'Cathbert Alfred Goroba', '33', NULL, '', '0713417383', '275 katavi', 'calfredy@yahoo.com', NULL, '$2y$10$vSFRGn8jy6mqXRQ5OM12jutip.AvkU6lPFctEk1V1nevZwh0VyDZ6', NULL, NULL, NULL, 0, NULL, NULL, '2022-04-19 12:49:57', '2022-04-19 12:49:57', NULL),
(34, 'Sophia fidelis mgassa', '34', NULL, '', '0653973558', 'Kisesa- mwanza', 'mgasophy@yahoo.co.com', NULL, '$2y$10$4EwMqj5m/RXLQQZEZpVxhOsRVrguv9UkGD/AkEBA6MOphk9BIIfGS', NULL, NULL, NULL, 0, NULL, NULL, '2022-04-19 13:58:32', '2022-04-19 13:58:32', NULL),
(35, 'Cleophas Birech', '35', NULL, '', '+254722625793', '2947-30100', 'cleobirech@gmail.com', NULL, '$2y$10$cf4Ho/ark1GVJOSBTEJQDuonMVxCS2C87V0g0zUpMF1JgvZhV77yK', NULL, NULL, NULL, 0, NULL, NULL, '2022-04-19 17:44:09', '2022-04-19 17:44:09', NULL),
(36, 'Bernard Kazoba', '36', NULL, '', '0767573165', '11037 Mwanza', 'cbenchristopher@mmservices.co.tz', NULL, '$2y$10$c7GgcR9LlSvbQz9OCR4M0uodqqmgzFl89aZreLywWUqOauGpcLg0S', NULL, NULL, NULL, 0, NULL, NULL, '2022-04-19 18:08:02', '2022-04-19 18:08:02', NULL),
(37, 'JOSEPH JOHN CHOKA', '37', NULL, '', '+255764729966', 'Sumbawanga,Rukwa Tanzania', 'josephc351@gmail.com', NULL, '$2y$10$OQz9RJe9u88bBffGUZMOKOlhlCBKc5OPUVWjlJ4kipHlp19hkdsW.', NULL, NULL, NULL, 0, NULL, 'Q3BkwxAcL98YFQUznWIzSh1kXTxsB9taSzmBSG7wyDp43W4A5SIhdcKavrfG', '2022-04-20 11:01:43', '2022-04-20 11:01:43', NULL),
(38, 'Alex Noel', '38', NULL, '', '0713460717', 'Helsinki', 'noel.makumuli@gmail.com', NULL, '$2y$10$J8qRNe9tSmVtHX7Yfuecpu7W9bNxvpG2xI/UW9/Blofy4e/YUNeJy', NULL, NULL, NULL, 0, NULL, NULL, '2022-04-21 07:38:09', '2022-04-21 07:38:09', NULL),
(39, 'Geophrey Tenganamba', '39', NULL, '', '+255655973248', 'Costech Building, 3rd floor, Kijitonyama', 'fursa101africa@gmail.com', NULL, '$2y$10$G0VaM6rycwjAFRc3JtEtLuPuFYq2EvLPe1P8dWXJ1ViwAM096hy9a', NULL, NULL, NULL, 0, NULL, NULL, '2022-04-21 14:17:24', '2022-04-21 14:17:24', NULL),
(40, 'Tenganamba', '40', NULL, '', '0712722684', 'JMO Building 7th Floor, Flat 705', 'extrahelptz@gmail.com', NULL, '$2y$10$zzb6Bjv9jD6VfNeWi5K11uMVxDoYCMYpJWJLSkeJovhzPlI1U60Mm', NULL, NULL, NULL, 0, NULL, NULL, '2022-04-30 16:05:29', '2022-04-30 16:05:29', NULL),
(41, NULL, '40', NULL, '', '0655973246', 'yutiofbifbc', 'test2@gmail.com', NULL, '$2y$10$isAmKl/iuXUxebnrrubnCeRSM9Fgpb/SUcUpYznXuAS4AKckuAziq', NULL, NULL, NULL, 1, NULL, NULL, '2022-04-30 16:11:03', '2022-04-30 16:11:03', NULL),
(42, 'YEMTAZ LOGISTICS LIMITED', '42', NULL, '', '0767969136', '8064 Dar es salaam', 'j.masau@yemtaz.co.uk', NULL, '$2y$10$8bENY3W73F3LXphRmIfWgeu7vUMy1BuOeLOH28vn3QgwIDalx1Jim', NULL, NULL, NULL, 0, NULL, NULL, '2022-05-05 14:03:33', '2022-05-05 14:03:33', NULL),
(43, 'test', '1', 'Test', 'tester', '0712722684', 'ubungo', 'sales1@crystal.co.tz', NULL, '$2y$10$Qsz8NkCjiR7/xi87F0j92uT2pjRSAC9zedSPJzYZwFLiSUmI/H6WC', NULL, '1', '3', 1, NULL, NULL, '2022-05-07 10:13:34', '2022-05-07 10:14:05', NULL),
(44, NULL, '1', NULL, '', '0715438485', 'dar es salaam', 'inventory@gmail.com', NULL, '$2y$10$qOXJhaA6Px4cvBVLm1BLUOYhp9P6Lg81Jqrfqqb1I077hbSJRCZh6', NULL, '1', '3', 1, NULL, NULL, '2022-05-10 15:57:37', '2022-05-10 15:57:37', NULL),
(45, NULL, '19', NULL, '', '0712722684', 'JMO Building 7th Floor, Flat 705', 'newtest@gmail.com', NULL, '$2y$10$ebYBKArwaXDfNZ932qpYqeCnviJEHVQVDLy8Q0k04FhExj4OO.9qW', NULL, '4', '2', 1, NULL, NULL, '2022-05-11 15:46:06', '2022-05-11 15:46:06', NULL),
(46, NULL, '1', NULL, '', '0655973246', 'JMO Building 7th Floor, Flat 705', 'courier@gmaill.com', NULL, '$2y$10$kSV9Y1QNvaPPUBgqvcB7tuZx/HWHayhkm/Xknhyz3i1NujF8GhZtu', NULL, '1', '3', 1, NULL, NULL, '2022-05-12 15:58:40', '2022-05-12 15:58:40', NULL),
(47, 'Faizi Tamim', '47', NULL, '', '713904754', 'Kisarawe Pwani', 'faizitamimft@gmail.com', NULL, '$2y$10$e4KKqlAf28PrzExRP3nDyOPtP4WnqpvQVNrVZl2aER0DoLHl0K/9u', NULL, NULL, NULL, 0, NULL, NULL, '2022-05-14 22:24:19', '2022-05-14 22:24:19', NULL),
(48, 'Purity', '48', NULL, '', '0629636411', 'Dad es salaam', 'purityjallah088@gmail.com', NULL, '$2y$10$JRb61HnzwCSLtJtleJ1fjegCMwoJkXiZ/YHpryw1ZHwcVRHgp6L6a', NULL, NULL, NULL, 0, NULL, NULL, '2022-05-15 07:31:34', '2022-05-15 07:31:34', NULL),
(49, 'Verian Aloyce', '49', NULL, '', '0742340527', 'P.O BOX 19706 DSM', 'info@securelogistics.co.tz', NULL, '$2y$10$jCuu9U6vVZlJUubcVOOtBeq.bzXdI2igPJUWSV54BrlVmEjX1bG7e', NULL, NULL, NULL, 0, NULL, NULL, '2022-05-15 14:12:32', '2022-05-15 14:12:32', NULL),
(50, NULL, '1', NULL, '', '0712722682', '62220', 'cotton@gmail.com', NULL, '$2y$10$jhK/7ALY5jDg.JuxHnuPiexAEd72jzHmoe6n4cwiF6gy4n3kp32w.', NULL, '1', 'Select Designation', 1, NULL, NULL, '2022-05-16 09:19:55', '2022-05-16 09:19:55', NULL),
(51, 'Gak Investiments Limited', '51', NULL, '', '0712722682', 'Shinyanga viwandani', 'cotton1@gmail.com', NULL, '$2y$10$Lh.rbAor7PgCc.15MGTMIuJtWamrKAAsGCGf6PO8XK0ULP4JjRSFu', NULL, NULL, NULL, 0, NULL, NULL, '2022-05-17 09:39:09', '2022-05-17 09:39:09', NULL),
(52, 'pedro', '52', NULL, '', '0715438485', 'dar es salaam', 'pedro@gmail.com', NULL, '$2y$10$SdsPPD.sHYpQEQraeahGPuptaQmAUC1dgejLIIcH.P2lV3jVlSEXm', NULL, NULL, NULL, 0, NULL, NULL, '2022-05-17 09:43:53', '2022-05-17 09:43:53', NULL),
(53, NULL, '1', NULL, '', '0712722682', '62220', 'logistic1@gmail.com', NULL, '$2y$10$Sfz5YeMChUyAT9jvhP6gFegrSs2Dp/90wsA/5L3Ndvek3c5M8k6eW', NULL, '1', '3', 1, NULL, 'nvgN6pyI6rJU9sBgE9p1xTa1NlxnqnkbrNcHpAgvbu4TxIvQhqpd6wJEDqA9', '2022-05-17 13:04:49', '2022-05-17 13:04:49', NULL),
(54, 'Jafari', '54', NULL, '', '0685808128', 'Nchimbi', 'japharnchimbi1998@gmail.com', NULL, '$2y$10$Gj7KDgUyt0RwOv02bZgN..a6NYZJ6mioo8wolnGFhMZMIYiLz4tPW', NULL, NULL, NULL, 0, NULL, NULL, '2022-05-21 01:28:11', '2022-05-21 01:28:11', NULL),
(55, 'Timoth Japhethy Kyara', '55', NULL, '', '+255767990110', '21 Paradise Street', 'timjaykay@yahoo.com', NULL, '$2y$10$.r8ZAqpfx5bNyrmXi7gj2OEtkJKYyu7j85iPh7KXFU68ddgDwTCiy', NULL, NULL, NULL, 0, NULL, NULL, '2022-05-26 14:31:34', '2022-05-26 14:31:34', NULL),
(56, 'Justine Massaba', '56', NULL, '', '0713063281', 'Dar Es Salaam', 'justinemassaba@gmail.com', NULL, '$2y$10$d5HoINT2zZn16cOcVSO8H.d8hxFxx8jlcWmE05anVTtBX9kzp2d0q', NULL, NULL, NULL, 0, NULL, NULL, '2022-06-04 19:37:26', '2022-06-04 19:37:26', NULL),
(57, 'Shabbir', '57', NULL, '', '0688781459', 'PO Box 21338 DSM', 'shabbirkhataw@gmail.com', NULL, '$2y$10$d7Ls.9e8uK8G3fQ3FnuZF.M4TYERCjDdJUxN.85serf8dhTaIS5x2', NULL, NULL, NULL, 0, NULL, NULL, '2022-06-28 11:21:13', '2022-06-28 11:21:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`user_id`, `role_id`, `updated_at`) VALUES
(1, 13, '2022-06-15 13:28:09'),
(2, 2, '2022-05-23 07:24:18'),
(6, 4, '2022-05-23 07:24:18'),
(7, 2, '2022-05-23 07:24:18'),
(8, 4, '2022-05-23 07:24:18'),
(9, 4, '2022-05-23 07:24:18'),
(10, 4, '2022-05-23 07:24:18'),
(11, 8, '2022-05-23 07:24:18'),
(12, 11, '2022-05-23 07:24:18'),
(13, 9, '2022-05-23 07:24:18'),
(15, 13, '2022-05-23 07:24:18'),
(16, 17, '2022-05-23 07:24:18'),
(17, 16, '2022-05-23 07:24:18'),
(18, 16, '2022-05-23 07:24:18'),
(19, 32, '2022-05-23 07:24:18'),
(20, 14, '2022-05-23 07:24:18'),
(21, 15, '2022-05-23 07:24:18'),
(22, 23, '2022-05-23 07:24:18'),
(23, 23, '2022-05-23 07:24:18'),
(24, 25, '2022-05-23 07:24:18'),
(25, 24, '2022-05-23 07:24:18'),
(26, 17, '2022-05-23 07:24:18'),
(27, 16, '2022-05-23 07:24:18'),
(28, 23, '2022-05-23 07:24:18'),
(29, 14, '2022-05-23 07:24:18'),
(30, 16, '2022-05-23 07:24:18'),
(31, 13, '2022-05-23 07:24:18'),
(32, 23, '2022-05-23 07:24:18'),
(33, 13, '2022-05-23 07:24:18'),
(34, 16, '2022-05-23 07:24:18'),
(35, 13, '2022-05-23 07:24:18'),
(36, 16, '2022-05-23 07:24:18'),
(37, 16, '2022-05-23 07:24:18'),
(38, 16, '2022-05-23 07:24:18'),
(39, 14, '2022-05-23 07:24:18'),
(40, 13, '2022-05-23 07:24:18'),
(41, 28, '2022-05-23 07:24:18'),
(42, 13, '2022-05-23 07:24:18'),
(43, 28, '2022-05-23 07:24:18'),
(44, 33, '2022-05-23 07:24:18'),
(45, 13, '2022-05-23 07:24:18'),
(46, 34, '2022-05-23 07:24:18'),
(47, 13, '2022-05-23 07:24:18'),
(48, 13, '2022-05-23 07:24:18'),
(49, 13, '2022-05-23 07:24:18'),
(50, 35, '2022-05-27 10:48:25'),
(51, 35, '2022-05-23 07:24:18'),
(52, 35, '2022-05-23 07:24:18'),
(53, 13, '2022-05-24 00:31:07'),
(54, 13, '2022-05-23 07:24:18'),
(55, 34, '2022-05-26 10:31:34'),
(56, 33, '2022-06-04 15:37:26'),
(57, 13, '2022-06-28 07:21:13');

-- --------------------------------------------------------

--
-- Table structure for table `wards`
--

CREATE TABLE `wards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `district_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wards`
--

INSERT INTO `wards` (`id`, `district_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 12, 'Makanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2, 12, 'Ilindi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3, 12, 'Kigwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(4, 12, 'Chikola', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(5, 12, 'Chipanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(6, 12, 'Chali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(7, 12, 'Nondwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(8, 12, 'Mpalanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(9, 12, 'Ibugule', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(10, 12, 'Chibelela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(11, 12, 'Mwitikira', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(12, 12, 'Lamaiti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(13, 12, 'Mtitaa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(14, 12, 'Babayu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(15, 12, 'Zanka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(16, 12, 'Msisi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(17, 12, 'Mundemu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(18, 12, 'Bahi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(19, 12, 'Mpamantwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(20, 12, 'Ibihwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(21, 14, 'Makorongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(22, 14, 'Mrijo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(23, 14, 'Chandama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(24, 14, 'Goima', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(25, 14, 'Chemba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(26, 14, 'Paranga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(27, 14, 'Gwandi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(28, 14, 'Farkwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(29, 14, 'Mpendo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(30, 14, 'Sanzawa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(31, 14, 'Kwamtoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(32, 14, 'Ovada', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(33, 14, 'Lalta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(34, 14, 'Msaada', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(35, 14, 'Kimaha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(36, 14, 'Churuku', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(37, 14, 'Songoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(38, 14, 'Mondo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(39, 14, 'Dalai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(40, 14, 'Jangalo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(41, 13, 'Haneti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(42, 13, 'Manchali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(43, 13, 'Ikowa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(44, 13, 'Msamalo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(45, 13, 'Igandu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(46, 13, 'Muungano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(47, 13, 'Mvumi Makulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(48, 13, 'Handali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(49, 13, 'Mvumi Mission', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(50, 13, 'Idifu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(51, 13, 'Makangwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(52, 13, 'Segala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(53, 13, 'Iringa Mvumi Zamani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(54, 13, 'Manzase', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(55, 13, 'Fufu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(56, 13, 'Mlowa Bwawani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(57, 13, 'Mpwayungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(58, 13, 'Nghambaku', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(59, 13, 'Chinugulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(60, 13, 'Manda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(61, 13, 'Huzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(62, 13, 'Loje', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(63, 13, 'Itiso', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(64, 13, 'Chiboli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(65, 13, 'Nhinhi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(66, 13, 'Zajilwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(67, 13, 'Dabalo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(68, 13, 'Membe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(69, 13, 'Msanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(70, 13, 'Chilonwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(71, 13, 'Buigiri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(72, 13, 'Majeleko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(73, 15, 'Viwandani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(74, 15, 'Hombolo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(75, 15, 'Ipala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(76, 15, 'Nzuguni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(77, 15, 'Dodoma Makulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(78, 15, 'Mtumba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(79, 15, 'Kikombo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(80, 15, 'Ng hong honha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(81, 15, 'Mpunguzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(82, 15, 'Tambukareli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(83, 15, 'Kilimani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(84, 15, 'Uhuru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(85, 15, 'Kikuyu Kusini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(86, 15, 'Kikuyu Kaskazini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(87, 15, 'Mkonze', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(88, 15, 'Mbabala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(89, 15, 'Zuzu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(90, 15, 'Hazina', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(91, 15, 'Madukani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(92, 15, 'Majengo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(93, 15, 'Kizota', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(94, 15, 'Nala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(95, 15, 'Chamwino', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(96, 15, 'Mbalawala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(97, 15, 'Ntyuka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(98, 15, 'Chigongwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(99, 15, 'Chang ombe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(100, 15, 'Iyumbu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(101, 15, 'Chahwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(102, 15, 'Mnadani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(103, 15, 'Ipagala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(104, 15, 'Kiwanja cha Ndege', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(105, 15, 'Makole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(106, 15, 'Miyuji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(107, 15, 'Msalato', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(108, 15, 'Makutupora', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(109, 15, 'Chihanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(110, 16, 'Bumbuta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(111, 16, 'Kisese', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(112, 16, 'Kikore', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(113, 16, 'Serya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(114, 16, 'Chemchem', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(115, 16, 'Hondomairo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(116, 16, 'Bolisa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(117, 16, 'Kinyasi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(118, 16, 'Salanka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(119, 16, 'Itololo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(120, 16, 'Pahi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(121, 16, 'Itaswi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(122, 16, 'Suruke', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(123, 16, 'Kingale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(124, 16, 'Kondoa Mjini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(125, 16, 'Kolo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(126, 16, 'Changaa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(127, 16, 'Thawi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(128, 16, 'Mnenia', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(129, 16, 'Soera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(130, 16, 'Busi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(131, 16, 'Haubi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(132, 16, 'Kalamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(133, 16, 'Kwadelo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(134, 16, 'Masange', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(135, 16, 'Kikilo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(136, 16, 'Bereko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(137, 17, 'Kongwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(138, 17, 'Iduo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(139, 17, 'Sagara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(140, 17, 'Kibaigwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(141, 17, 'Ugogoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(142, 17, 'Chamkoroma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(143, 17, 'Makawa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(144, 17, 'Chitego', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(145, 17, 'Matongoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(146, 17, 'Ngomai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(147, 17, 'Songambele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(148, 17, 'Sejeli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(149, 17, 'Chiwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(150, 17, 'Lenjulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(151, 17, 'Nghumbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(152, 17, 'Hogoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(153, 17, 'Zoissa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(154, 17, 'Mkoka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(155, 17, 'Njoge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(156, 17, 'Mtanana', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(157, 17, 'Pandambili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(158, 17, 'Mlali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(159, 18, 'Mazae', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(160, 18, 'Rudi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(161, 18, 'Mlunduzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(162, 18, 'Wotta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(163, 18, 'Mima', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(164, 18, 'Berege', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(165, 18, 'Chunyu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(166, 18, 'Mbuga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(167, 18, 'Godegode', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(168, 18, 'Mpwapwa Mjini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(169, 18, 'Lupeta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(170, 18, 'Ving hawe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(171, 18, 'Gulwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(172, 18, 'Nghambi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(173, 18, 'Chitemo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(174, 18, 'Iwondo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(175, 18, 'Kingiti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(176, 18, 'Lufu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(177, 18, 'Pwaga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(178, 18, 'Galigali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(179, 18, 'Mtera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(180, 18, 'Chipogoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(181, 18, 'Matomondo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(182, 18, 'Malolo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(183, 18, 'Kimagai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(184, 18, 'Kibakwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(185, 18, 'Lumuma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(186, 18, 'Luhundwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(187, 18, 'Massa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(188, 18, 'Ipera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(189, 124, 'Puma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(190, 124, 'Mang onyi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(191, 124, 'Mkiwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(192, 124, 'Issuna', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(193, 124, 'Unyahati', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(194, 124, 'Ikungi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(195, 124, 'Iglansoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(196, 124, 'Iseke', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(197, 124, 'Ihanja', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(198, 124, 'Minyughe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(199, 124, 'Muhintiri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(200, 124, 'Kituntu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(201, 124, 'Mgungira', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(202, 124, 'Mwaru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(203, 124, 'Ighombwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(204, 124, 'Mtunduru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(205, 124, 'Sepuka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(206, 124, 'Irisya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(207, 124, 'Mungaa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(208, 124, 'Siuyu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(209, 124, 'Kikio', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(210, 124, 'Lighwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(211, 124, 'Misughaa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(212, 124, 'Ntuntu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(213, 124, 'Dung unyi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(214, 125, 'Urughu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(215, 125, 'Kiomboi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(216, 125, 'Kinampanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(217, 125, 'Ulemo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(218, 125, 'Kyengege', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(219, 125, 'Ndago', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(220, 125, 'Mbelekese', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(221, 125, 'Kaselya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(222, 125, 'Ndulungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(223, 125, 'Mtekente', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(224, 125, 'Mtoa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(225, 125, 'Mgongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(226, 125, 'Shelui', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(227, 125, 'Ntwike', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(228, 125, 'Tulya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(229, 125, 'Kidaru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(230, 125, 'Kisiriri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(231, 127, 'Mpambala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(232, 127, 'Kinyangiri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(233, 127, 'Iguguno', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(234, 127, 'Miganga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(235, 127, 'Matongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(236, 127, 'Kikhonda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(237, 127, 'Mwangeza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(238, 127, 'Mwanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(239, 127, 'Nkinto', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(240, 127, 'Ibaga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(241, 127, 'Gumanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(242, 127, 'Msingi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(243, 127, 'Nduguti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(244, 127, 'Ilunda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(245, 126, 'Manyoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(246, 126, 'Heka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(247, 126, 'Nkonko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(248, 126, 'Sanza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(249, 126, 'Isseke', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(250, 126, 'Solya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(251, 126, 'Mkwese', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(252, 126, 'Muhalala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(253, 126, 'Saranda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(254, 126, 'Makutopora', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(255, 126, 'Sasilo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(256, 126, 'Makuru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(257, 126, 'Chikuyu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(258, 126, 'Kintinku', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(259, 126, 'Mvumi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(260, 126, 'Majiri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(261, 126, 'Sasajila', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(262, 126, 'Idodyandole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(263, 126, 'Rungwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(264, 126, 'Mgandu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(265, 126, 'Itigi Mjini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(266, 126, 'Ipande', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(267, 126, 'Sanjaranda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(268, 126, 'Aghondi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(269, 126, 'Mwamagembe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(270, 126, 'Mitundu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(271, 126, 'Kitaraka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(272, 126, 'Itigi Majengo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(273, 7, 'Ukonga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(274, 7, 'Buguruni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(275, 7, 'Kariakoo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(276, 7, 'Jangwani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(277, 7, 'Gerezani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(278, 7, 'Kisutu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(279, 7, 'Mchafukoge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(280, 7, 'Upanga Mashariki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(281, 7, 'Upanga Magharibi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(282, 7, 'Kivukoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(283, 7, 'Kiwalani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(284, 7, 'Pugu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(285, 7, 'Segerea', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(286, 7, 'Kitunda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(287, 7, 'Chanika', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(288, 7, 'Kivule', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(289, 7, 'Gongo la Mboto', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(290, 7, 'Majohe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(291, 7, 'Kimanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(292, 7, 'Msongola', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(293, 7, 'Tabata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(294, 7, 'Kinyerezi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(295, 7, 'Ilala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(296, 7, 'Mchikichini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(297, 7, 'Vingunguti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(298, 7, 'Kipawa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(299, 10, 'Kigamboni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(300, 10, 'Vijibweni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(301, 10, 'Pembamnazi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(302, 10, 'Mjimwema', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(303, 10, 'Tungi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(304, 10, 'Kibada', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(305, 10, 'Kisarawe II', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(306, 10, 'Somangila', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(307, 10, 'Kimbiji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(308, 8, 'Magomeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(314, 8, 'Kawe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(315, 8, 'Kunduchi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(316, 8, 'Mbweni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(317, 8, 'Bunju', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(321, 8, 'Makumbusho', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(322, 8, 'Sinza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(323, 8, 'Kijitonyama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(325, 8, 'Mikocheni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(327, 8, 'Hananasif', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(330, 8, 'Ndugumbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(332, 8, 'Mbezi juu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(333, 8, 'Makongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(334, 8, 'Mabwepande', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(335, 8, 'Wazo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(336, 8, 'Tandale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(337, 8, 'Mwananyamala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(338, 8, 'Msasani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(339, 8, 'Kinondoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(340, 8, 'Mzimuni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(341, 8, 'Kigogo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(342, 9, 'Charambe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(343, 9, 'Toangoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(344, 9, 'Miburani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(345, 9, 'Temeke', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(346, 9, 'Mtoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(347, 9, 'Keko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(348, 9, 'Kurasini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(349, 9, 'Azimio', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(350, 9, 'Tandika', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(351, 9, 'Sandali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(352, 9, 'Mbagala Kuu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(353, 9, 'Makangarawe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(354, 9, 'Kijichi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(355, 9, 'Mianzini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(356, 9, 'Kiburugwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(357, 9, 'Buza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(358, 9, 'Kilakala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(359, 9, 'Mbagala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(360, 9, 'Chamazi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(361, 9, 'Yombo Vituka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(362, 74, 'Chakwale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(363, 74, 'Chanjale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(364, 74, 'Nongwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(365, 74, 'Iyogwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(366, 74, 'Idibo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(367, 74, 'Kibedya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(368, 74, 'Msingisi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(369, 74, 'Gairo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(370, 74, 'Rubeho', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(371, 74, 'Mandege', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(372, 74, 'Chagongwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(373, 75, 'Kidatu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(374, 75, 'Idete', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(375, 75, 'Mbingu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(376, 75, 'Mofu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(377, 75, 'Mchombe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(378, 75, 'Chita', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(379, 75, 'Chisano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(380, 75, 'Mlimba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(381, 75, 'Utengule', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(382, 75, 'Masagati', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(383, 75, 'Uchindile', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(384, 75, 'Sanje', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(385, 75, 'Mwaya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(386, 75, 'Mngeta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(387, 75, 'Kamwene', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(388, 75, 'Igima', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(389, 75, 'Msolwa Station', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(390, 75, 'Mkula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(391, 75, 'Mang ula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(392, 75, 'Kisawasawa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(393, 75, 'Kiberege', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(394, 75, 'Lipangalala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(395, 75, 'Mbasa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(396, 75, 'Katindiuka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(397, 75, 'Michenga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(398, 75, 'Mlabani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(399, 75, 'Viwanja Sitini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(400, 75, 'Kibaoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(401, 75, 'Ifakara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(402, 75, 'Lumemo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(403, 76, 'Mabula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(404, 76, 'Chanzulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(405, 76, 'Kimamba A', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(406, 76, 'Kimamba B', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(407, 76, 'Mbumi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(408, 76, 'Mkwatani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(409, 76, 'Kasiki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(410, 76, 'Mabwerebwere', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(411, 76, 'Kilangali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(412, 76, 'Mikumi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(413, 76, 'Maguha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(414, 76, 'Ruhembe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(415, 76, 'Kidodi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(416, 76, 'Vidunda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(417, 76, 'Kisanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(418, 76, 'Uleling`ombe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(419, 76, 'Ulaya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(420, 76, 'Zombo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(421, 76, 'Masanze', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(422, 76, 'Berega', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(423, 76, 'Kidete', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(424, 76, 'Lumbiji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(425, 76, 'Kitete', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(426, 76, 'Madoto', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(427, 76, 'Tindiga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(428, 76, 'Ruaha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(429, 76, 'Magubike', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(430, 76, 'Mamboya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(431, 76, 'Dumila', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(432, 76, 'Magole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(433, 76, 'Msowero', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(434, 76, 'Rudewa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(435, 78, 'Mvomero', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(436, 78, 'Bunduki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(437, 78, 'Kikeo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(438, 78, 'Langali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(439, 78, 'Tchenzema', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(440, 78, 'Mzumbe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(441, 78, 'Doma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(442, 78, 'Melela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(443, 78, 'Hembeti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(444, 78, 'Maskati', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(445, 78, 'Kibati', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(446, 78, 'Sungaji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(447, 78, 'Mhonda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(448, 78, 'Diongoya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(449, 78, 'Mtibwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(450, 78, 'Kanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(451, 79, 'Minepa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(452, 79, 'Sali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(453, 79, 'Euga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(454, 79, 'Lukande', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(455, 79, 'Ilonga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(456, 79, 'Lupiro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(457, 79, 'Iragua', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(458, 79, 'Uponera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(459, 79, 'Nawenge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(460, 79, 'Mawasiliano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(461, 79, 'Milola', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(462, 79, 'Ketaketa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(463, 79, 'Kichangani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(464, 79, 'Msogezi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(465, 79, 'Vigoi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(466, 79, 'Mahenge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(467, 79, 'Isongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(468, 79, 'Chirombola', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(469, 79, 'Kilosa kwa Mpepo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(470, 79, 'Ngoheranga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(471, 79, 'Biro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(472, 79, 'Malinyi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(473, 79, 'Sofi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(474, 79, 'Usangule', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(475, 79, 'Mtimbira', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(476, 79, 'Itete', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(477, 79, 'Igawa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(478, 79, 'Njiwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(479, 102, 'Fukayosi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(480, 102, 'Kerege', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(481, 102, 'Pera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(482, 102, 'Dunda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(483, 102, 'Kiromo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(484, 102, 'Zinga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(485, 102, 'Yombo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(486, 102, 'Kiwangwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(487, 102, 'Vigwaza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(488, 102, 'Talawanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(489, 102, 'Bwilingu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(490, 102, 'Lugoba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(491, 102, 'Ubenazomozi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(492, 102, 'Mbwewe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(493, 102, 'Kibindu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(494, 102, 'Msata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(495, 102, 'Msoga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(496, 102, 'Kimange', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(497, 102, 'Mandera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(498, 102, 'Miono', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(499, 102, 'Mkange', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(500, 104, 'Kisarawe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(501, 104, 'Vikumbulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(502, 104, 'Mafizi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(503, 104, 'Kurui', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(504, 104, 'Mzenga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(505, 104, 'Vihingo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(506, 104, 'Kiluvya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(507, 104, 'Msimbu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(508, 104, 'Masaki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(509, 104, 'Kibuta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(510, 104, 'Marumbo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(511, 104, 'Maneromango', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(512, 104, 'Marui', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(513, 104, 'Cholesamvula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(514, 105, 'Kirongwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(515, 105, 'Baleni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(516, 105, 'Kilindoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(517, 105, 'Kiegeani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(518, 105, 'Jibondo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(519, 105, 'Ndagoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(520, 106, 'Mkuranga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(521, 106, 'Nyamato', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(522, 106, 'Kimanzichana', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(523, 106, 'Mkamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(524, 106, 'Panzuo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(525, 106, 'Bupu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(526, 106, 'Mwalusembe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(527, 106, 'Vianzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(528, 106, 'Njia nne', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(529, 106, 'Kiparang anda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(530, 106, 'Tambani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(531, 106, 'Vikindu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(532, 106, 'Shungubweni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(533, 106, 'Kisiju', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(534, 106, 'Magawa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(535, 106, 'Kitomondo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(536, 106, 'Lukanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(537, 107, 'Ikwiriri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(538, 107, 'Chumbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(539, 107, 'Mbwara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(540, 107, 'Mgomba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(541, 107, 'Ngarambe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(542, 107, 'Mohoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(543, 107, 'Kipugira', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(544, 107, 'Umwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(545, 107, 'Utete', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(546, 107, 'Mkongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(547, 107, 'Ngorongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(548, 107, 'Mwaseni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(549, 107, 'Mahege', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(550, 107, 'Mchukwi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(551, 107, 'Mtunda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(552, 107, 'Ruaruke', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(553, 107, 'Salale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(554, 107, 'Mbuchi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(555, 107, 'Kiongoroni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(556, 107, 'Maparoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(557, 107, 'Dimani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(558, 107, 'Mtawanya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(559, 107, 'Mjawa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(560, 107, 'Mlanzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(561, 107, 'Mwambao', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(562, 107, 'Msala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(563, 107, 'Kibiti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(564, 107, 'Bungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(565, 19, 'Runzewe Mashariki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(566, 19, 'Bukombe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(567, 19, 'Bugelenga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(568, 19, 'Iyogelo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(569, 19, 'Igulwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(570, 19, 'Runzewe Magharibi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(571, 19, 'Namonge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(572, 19, 'Uyovu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(573, 19, 'Busonzo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(574, 19, 'Ng anzo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(575, 19, 'Butinzya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(576, 19, 'Ushirombo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(577, 19, 'Lyambamgongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(578, 20, 'Muganza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(579, 20, 'Bwina', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(580, 20, 'Katende', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(581, 20, 'Ilyamchele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(582, 20, 'Bukome', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(583, 20, 'Buziku', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(584, 20, 'Nyarutembo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(585, 20, 'Makurugusi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(586, 20, 'Buseresere', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(587, 20, 'Butengorumasa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(588, 20, 'Bwongera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(589, 20, 'Iparamasa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(590, 20, 'Bwanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(591, 20, 'Bwera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(592, 20, 'Kigongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(593, 20, 'Nyamirembe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(594, 20, 'Ichwankima', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(595, 20, 'Kachwamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(596, 20, 'Kasenga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(597, 20, 'Ilemela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(598, 20, 'Chato', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(599, 22, 'Nanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(600, 22, 'Nyasato', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(601, 22, 'Lugunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(602, 22, 'Nyakafulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(603, 22, 'Bukandwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(604, 22, 'Ng homolwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(605, 22, 'Masumbwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(606, 22, 'Iponya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(607, 22, 'Ikobe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(608, 22, 'Lulembela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(609, 22, 'Ikunguigazi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(610, 22, 'Isebya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(611, 22, 'Ilolangulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(612, 22, 'Mbogwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(613, 22, 'Ngemo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(614, 22, 'Ushirika', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(615, 23, 'Shabaka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(616, 23, 'Nyabulanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(617, 23, 'Nyang hwale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(618, 23, 'Nyijundu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(619, 23, 'Busolwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(620, 23, 'Kakora', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(621, 23, 'Nyugwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(622, 23, 'Bukwimba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(623, 23, 'Kafita', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(624, 23, 'Kharumwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(625, 23, 'Izunya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(626, 23, 'Mwingiro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(627, 28, 'Nyakahura', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(628, 28, 'Nyabusozi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(629, 28, 'Nemba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(630, 28, 'Lusahunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(631, 28, 'Kaniha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(632, 28, 'Nyantakara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(633, 28, 'Kalenge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(634, 28, 'Ruziba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(635, 28, 'Biharamulo Mjini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(636, 28, 'Bisibo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(637, 28, 'Nyarubungo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(638, 28, 'Nyamahanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(639, 28, 'Runazi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(640, 28, 'Kabindi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(641, 28, 'Nyamigogo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(642, 29, 'Rubafu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(643, 29, 'Kanyangereko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(644, 29, 'Katerero', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(645, 29, 'Kemondo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(646, 29, 'Nyakibimbili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(647, 29, 'Ibwera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(648, 29, 'Mikoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(649, 29, 'Butelankuzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(650, 29, 'Rubale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(651, 29, 'Rukoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(652, 29, 'Kikomero', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(653, 29, 'Kishanje', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(654, 29, 'Kibirizi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(655, 29, 'Izimbya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(656, 29, 'Butulage', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(657, 29, 'Ruhunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(658, 29, 'Mugajwale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(659, 29, 'Kyamulaile', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(660, 29, 'Katoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(661, 29, 'Kaibanja', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(662, 29, 'Kasharu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(663, 29, 'Kishogo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(664, 29, 'Kaagya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(665, 29, 'Buhendangabo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(666, 29, 'Nyakato', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(667, 29, 'Katoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(668, 29, 'Karabagaine', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(669, 29, 'Bujugo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(670, 29, 'Maruku', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(671, 29, 'Hamugembe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(672, 29, 'Kitendaguro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(673, 29, 'Kibeta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(674, 29, 'Kagondo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(675, 29, 'Nyanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(676, 29, 'Rwamishenye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(677, 29, 'Nshambya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(678, 29, 'Buhembe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(679, 29, 'Kahororo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(680, 29, 'Kashai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(681, 29, 'Miembeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(682, 29, 'Bilele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(683, 29, 'Bakoba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(684, 29, 'Ijuganyondo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(685, 30, 'Igurwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(686, 30, 'Ihembe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(687, 30, 'Nyaishozi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(688, 30, 'Rugu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(689, 30, 'Nyakasimbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(690, 30, 'Nyakakika', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(691, 30, 'Nyakabanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(692, 30, 'Bweranyange', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(693, 30, 'Kibondo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(694, 30, 'Nyabiyonza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(695, 30, 'Kiruruma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(696, 30, 'Kanoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(697, 30, 'Nyakahanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(698, 30, 'Ihanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(699, 30, 'Chonyonyo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(700, 30, 'Kihanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(701, 30, 'Kayanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(702, 30, 'Bugene', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(703, 30, 'Ndama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(704, 30, 'Rugera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(705, 31, 'Isingiro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(706, 31, 'Kamuli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(707, 31, 'Nyakatuntu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(708, 31, 'Kimuli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(709, 31, 'Kikukuru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(710, 31, 'Rwabwere', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(711, 31, 'Nkwenda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(712, 31, 'Rukuraijo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(713, 31, 'Kyerwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(714, 31, 'Kaisho', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(715, 31, 'Rutunguru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(716, 31, 'Kibingo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(717, 31, 'Murongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(718, 31, 'Bugomora', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(719, 31, 'Kibale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(720, 31, 'Mabira', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(721, 31, 'Businde', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(722, 33, 'Muhutwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(723, 33, 'Kikuku', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(724, 33, 'Bureza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(725, 33, 'Muleba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(726, 33, 'Ikondo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(727, 33, 'Buhangaza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(728, 33, 'Mazinga Kisiwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(729, 33, 'Magata Karutanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(730, 33, 'Gwanseli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(731, 33, 'Kibanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(732, 33, 'Kasharunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(733, 33, 'Mayondwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(734, 33, 'Rulanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(735, 33, 'Kimwani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(736, 33, 'Nyakabango', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(737, 33, 'Kyebitembe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(738, 33, 'Karambi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(739, 33, 'Mubunda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(740, 33, 'Bisheke', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(741, 33, 'Burungura', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(742, 33, 'Biirabo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(743, 33, 'Mushabago', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(744, 33, 'Goziba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(745, 33, 'Nyakatanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(746, 33, 'Ngenge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(747, 33, 'Rutoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(748, 33, 'Kabirizi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(749, 33, 'Nshamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(750, 33, 'Kashasha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(751, 33, 'Ijumbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(752, 33, 'Kishanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(753, 33, 'Buganguzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(754, 33, 'Ibuga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(755, 33, 'Kerebe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(756, 33, 'Bulyakashaju', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(757, 33, 'Kamachumu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(758, 33, 'Ruhanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(759, 33, 'Mafumbo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(760, 33, 'Bumbire', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(761, 33, 'Ikuza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(762, 33, 'Izigo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(763, 33, 'Katoke', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(764, 33, 'Kagoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(765, 32, 'Kakunyu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(766, 32, 'Buyango', '2022-04-11 21:37:26', '2022-04-11 21:37:26');
INSERT INTO `wards` (`id`, `district_id`, `name`, `created_at`, `updated_at`) VALUES
(767, 32, 'Bwanjai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(768, 32, 'Ishozi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(769, 32, 'Gera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(770, 32, 'Bugandika', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(771, 32, 'Kitobo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(772, 32, 'Bugorora', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(773, 32, 'Kyaka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(774, 32, 'Mushasha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(775, 32, 'Kilimilile', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(776, 32, 'Nsunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(777, 32, 'Mabale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(778, 32, 'Mutukula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(779, 32, 'Kassambya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(780, 32, 'Minziro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(781, 32, 'Ruzinga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(782, 32, 'Kashenye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(783, 32, 'Kanyigo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(784, 32, 'Ishunju', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(785, 34, 'Rusumo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(786, 34, 'Mabawe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(787, 34, 'Kanazi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(788, 34, 'Mugoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(789, 34, 'Kirushya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(790, 34, 'Ntobeye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(791, 34, 'Nyamiyaga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(792, 34, 'Ngara Mjini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(793, 34, 'Kibimba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(794, 34, 'Mbuba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(795, 34, 'Murukulazo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(796, 34, 'Nyakisasa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(797, 34, 'Kasulo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(798, 34, 'Rulenge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(799, 34, 'Keza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(800, 34, 'Murusagamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(801, 34, 'Bugarama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(802, 34, 'Bukiriro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(803, 34, 'Kabanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(804, 60, 'Nyamuswa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(805, 60, 'Butimba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(806, 60, 'Neruma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(807, 60, 'Kibara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(808, 60, 'Nansimo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(809, 60, 'Kisorya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(810, 60, 'Igundu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(811, 60, 'Iramba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(812, 60, 'Namhula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(813, 60, 'Salama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(814, 60, 'Nampindi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(815, 60, 'Chitengule', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(816, 60, 'Kasuguti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(817, 60, 'Nyamanguta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(818, 60, 'Ketare', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(819, 60, 'Mihingo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(820, 60, 'Mugeta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(821, 60, 'Hunyari', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(822, 60, 'Guta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(823, 60, 'Wariku', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(824, 60, 'Kabasa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(825, 60, 'Balili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(826, 60, 'Bunda Stoo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(827, 60, 'Nyasura', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(828, 60, 'Nyamakokoto', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(829, 60, 'Manyamanyama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(830, 60, 'Kabarimu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(831, 60, 'Nyatwali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(832, 60, 'Mcharo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(833, 60, 'Sazira', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(834, 60, 'Kunzugu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(835, 60, 'Bunda Mjini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(836, 61, 'Bwiregi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(837, 61, 'Kyanyari', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(838, 61, 'Kukirango', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(839, 61, 'Buruma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(840, 61, 'Nyakatende', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(841, 61, 'Etaro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(842, 61, 'Nyegina', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(843, 61, 'Nyankanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(844, 61, 'Bisumwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(845, 61, 'Bukabwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(846, 61, 'Butuguri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(847, 61, 'Buswahili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(848, 61, 'Busegwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(849, 61, 'Kamugegi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(850, 61, 'Nyamimange', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(851, 61, 'Sirorisimba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(852, 61, 'Buhemba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(853, 61, 'Mirwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(854, 61, 'Muriaza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(855, 61, 'Butiama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(856, 61, 'Masaba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(857, 63, 'Kigunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(858, 63, 'Kitembe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(859, 63, 'Mirare', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(860, 63, 'Goribe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(861, 63, 'Ikoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(862, 63, 'Koryo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(863, 63, 'Bukwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(864, 63, 'Nyathorogo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(865, 63, 'Rabour', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(866, 63, 'Kisumwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(867, 63, 'Komuge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(868, 63, 'Kirogo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(869, 63, 'Nyamunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(870, 63, 'Kyangombe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(871, 63, 'Nyamtinga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(872, 63, 'Nyamagaro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(873, 63, 'Nyahongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(874, 63, 'Mkoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(875, 63, 'Tai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(876, 63, 'Bukura', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(877, 63, 'Roche', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(878, 64, 'Kenyamonta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(879, 64, 'Natta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(880, 64, 'Issenye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(881, 64, 'Rigicha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(882, 64, 'Nyambureti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(883, 64, 'Nyamoko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(884, 64, 'Manchira', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(885, 64, 'Kyambahi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(886, 64, 'Nyamatare', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(887, 64, 'Majimoto', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(888, 64, 'Busawe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(889, 64, 'Magange', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(890, 64, 'Nyansurura', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(891, 64, 'Mosongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(892, 64, 'Sedeco', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(893, 64, 'Mbalibali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(894, 64, 'Stendi Kuu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(895, 64, 'Geitasamo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(896, 64, 'Morotonga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(897, 64, 'Uwanja wa Ndege', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(898, 64, 'Kisaka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(899, 64, 'Kebanchabancha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(900, 64, 'Ringwani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(901, 64, 'Rungabure', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(902, 64, 'Machochwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(903, 64, 'Kisangura', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(904, 64, 'Mugumu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(905, 65, 'Susuni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(906, 65, 'Goronga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(907, 65, 'Nyarokoba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(908, 65, 'Kemambo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(909, 65, 'Kibasuka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(910, 65, 'Binagi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(911, 65, 'Manga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(912, 65, 'Mwema', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(913, 65, 'Bumera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(914, 65, 'Komaswa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(915, 65, 'Kiore', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(916, 65, 'Nyamaranga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(917, 65, 'Mbogi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(918, 65, 'Genyange', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(919, 65, 'Nyansincha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(920, 65, 'Sirari', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(921, 65, 'Itiryo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(922, 65, 'Pemba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(923, 65, 'Nyakonga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(924, 65, 'Nyarero', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(925, 65, 'Nyamwaga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(926, 65, 'Muriba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(927, 65, 'Nyanungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(928, 65, 'Turwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(929, 65, 'Bomani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(930, 65, 'Nyandoto', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(931, 65, 'Sabasaba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(932, 65, 'Nyamisangura', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(933, 65, 'Kentare', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(934, 86, 'Buswelu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(935, 86, 'Nyamanoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(936, 86, 'Kirumba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(937, 86, 'Kitangiri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(938, 86, 'Pasiansi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(939, 86, 'Bugogwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(940, 86, 'Sangabuye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(941, 87, 'Walla', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(942, 87, 'Maligisu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(943, 87, 'Mwandu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(944, 87, 'Malya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(945, 87, 'Lyoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(946, 87, 'Mwanghalanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(947, 87, 'Nyamilama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(948, 87, 'Mwakilyambiti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(949, 87, 'Hungumalwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(950, 87, 'Mwamala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(951, 87, 'Kikubiji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(952, 87, 'Bungulwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(953, 87, 'Mhande', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(954, 87, 'Bupamwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(955, 87, 'Fukalo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(956, 87, 'Nghundi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(957, 87, 'Igongwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(958, 87, 'Ngudu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(959, 87, 'Bugando', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(960, 87, 'Nkalalo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(961, 87, 'Mwankulwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(962, 87, 'Ilula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(963, 87, 'Sumve', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(964, 87, 'Shilembo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(965, 87, 'Mantare', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(966, 87, 'Ngulla', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(967, 87, 'Mwabomba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(968, 87, 'Mwagi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(969, 87, 'Iseni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(970, 87, 'Nyambiti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(971, 88, 'Kisesa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(972, 88, 'Mwamabanza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(973, 88, 'Sukuma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(974, 88, 'Lubugu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(975, 88, 'Nghaya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(976, 88, 'Nkungulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(977, 88, 'Jinjimili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(978, 88, 'Shishani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(979, 88, 'Magu Mjini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(980, 88, 'Bujashi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(981, 88, 'Lutale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(982, 88, 'Kongolo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(983, 88, 'Nyanguge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(984, 88, 'Kitongo Sima', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(985, 88, 'Mwamanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(986, 88, 'Kahangara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(987, 88, 'Nyigogo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(988, 89, 'Bulemeji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(989, 89, 'Misasi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(990, 89, 'Kijima', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(991, 89, 'Shilalo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(992, 89, 'Buhingo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(993, 89, 'Busongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(994, 89, 'Nhundulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(995, 89, 'Lubili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(996, 89, 'Ilujamate', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(997, 89, 'Mbarika', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(998, 89, 'Sumbugu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(999, 89, 'Idetemya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1000, 89, 'Kasololo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1001, 89, 'Ilalambogo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1002, 89, 'Isesa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1003, 89, 'Gulumungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1004, 89, 'Mabuki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1005, 89, 'Mamaye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1006, 89, 'Fella', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1007, 89, 'Usagara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1008, 89, 'Ukiriguru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1009, 89, 'Kanyelele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1010, 89, 'Koromije', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1011, 89, 'Igokelo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1012, 89, 'Mwaniko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1013, 89, 'Misungwi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1014, 90, 'Mikuyuni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1015, 90, 'Buhongwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1016, 90, 'Mkolani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1017, 90, 'Igogo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1018, 90, 'Pamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1019, 90, 'Nyamagana', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1020, 90, 'Mirongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1021, 90, 'Isamilo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1022, 90, 'Mbugani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1023, 90, 'Mahina', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1024, 90, 'Igoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1025, 91, 'Ibisabageni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1026, 91, 'Igalula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1027, 91, 'Kagunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1028, 91, 'Sima', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1029, 91, 'Nyamazugo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1030, 91, 'Buzilasoga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1031, 91, 'Irenza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1032, 91, 'Kasenyi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1033, 91, 'Mwabaluhi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1034, 91, 'Chifunfu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1035, 91, 'Nyatukala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1036, 91, 'Nyampulukano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1037, 91, 'Nyampande', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1038, 91, 'Kishinda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1039, 91, 'Igulumuki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1040, 91, 'Katunguru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1041, 91, 'Kasungamile', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1042, 91, 'Nyamatongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1043, 91, 'Tabaruka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1044, 91, 'Busisi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1045, 91, 'Buyagu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1046, 91, 'Nyakasungwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1047, 91, 'Kalebezo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1048, 91, 'Nyehunge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1049, 91, 'Kafunzo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1050, 91, 'Bupandwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1051, 91, 'Katwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1052, 91, 'Maisome', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1053, 91, 'Kazunzu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1054, 91, 'Lugata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1055, 91, 'Nyakaliro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1056, 91, 'Nyakasasa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1057, 91, 'Nyanzenda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1058, 91, 'Bulyaheke', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1059, 92, 'Nansio', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1060, 92, 'Bwiro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1061, 92, 'Muriti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1062, 92, 'Ilangala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1063, 92, 'Namilembe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1064, 92, 'Nduruma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1065, 92, 'Murutunguru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1066, 92, 'Kagunguli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1067, 92, 'Bukindo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1068, 92, 'Namagondo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1069, 92, 'Ngoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1070, 92, 'Kagera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1071, 92, 'Bwisya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1072, 92, 'Bukungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1073, 92, 'Nyamanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1074, 92, 'Bukiko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1075, 92, 'Irugwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1076, 92, 'Nakatunguru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1077, 92, 'Kakerege', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1078, 92, 'Bukongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1079, 92, 'Nkilizya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1080, 92, 'Bukanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1081, 92, 'Mukituntu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1082, 92, 'Igalla', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1083, 2, 'Karatu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1084, 2, 'Qurus', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1085, 2, 'Ganako', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1086, 2, 'Rhotia', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1087, 2, 'Mbulumbulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1088, 2, 'Endamaghang', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1089, 2, 'Endamarariek', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1090, 2, 'Buger', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1091, 2, 'Endabash', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1092, 2, 'Kansay', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1093, 2, 'Baray', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1094, 2, 'Mangola', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1095, 2, 'Daa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1096, 2, 'Oldean', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1097, 3, 'Ketumbeine', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1098, 3, 'Kimokouwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1099, 3, 'Namanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1100, 3, 'Orbomba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1101, 3, 'Longido', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1102, 3, 'Tingatinga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1103, 3, 'Olmolog', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1104, 3, 'Kamwanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1105, 3, 'Engikaret', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1106, 3, 'Elengata Dapash', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1107, 3, 'Ilorienito', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1108, 3, 'Gelai Meirugoi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1109, 3, 'Gelai Lumbwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1110, 3, 'Matale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1111, 3, 'Engarenaibor', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1112, 3, 'Mundarara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1113, 5, 'Engaruka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1114, 5, 'Esilalei', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1115, 5, 'Mto wa Mbu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1116, 5, 'Lepurko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1117, 5, 'Meserani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1118, 5, 'Mswakini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1119, 5, 'Selela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1120, 5, 'Monduli Juu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1121, 5, 'Engutoto', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1122, 5, 'Monduli Mjini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1123, 5, 'Moita', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1124, 5, 'Sepeko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1125, 5, 'Lolkisale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1126, 5, 'Makuyuni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1127, 6, 'Orgosorok', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1128, 6, 'Ngorongoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1129, 6, 'Enduleni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1130, 6, 'Kakesio', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1131, 6, 'Arash', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1132, 6, 'Soit-Sambu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1133, 6, 'Enguserosambu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1134, 6, 'Oloirien', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1135, 6, 'Samunge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1136, 6, 'Alailelai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1137, 6, 'Maalon', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1138, 6, 'Digodigo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1139, 6, 'Ololosokwan', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1140, 6, 'Oloipiri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1141, 6, 'Oldonyosambu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1142, 6, 'Pinyinyi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1143, 6, 'Sale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1144, 6, 'Malambo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1145, 6, 'Naiyobi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1146, 6, 'Nainokanoka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1147, 6, 'Olbalbal', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1148, 44, 'Machame Mashariki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1149, 44, 'Hai Mjini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1150, 44, 'Masama Kati', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1151, 44, 'Machame Weruweru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1152, 44, 'KIA', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1153, 44, 'Machame Narumu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1154, 44, 'Machame Kusini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1155, 44, 'Machame Kaskazini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1156, 44, 'Machame Magharibi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1157, 44, 'Machame Uroki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1158, 44, 'Masama Mashariki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1159, 44, 'Masama Magharibi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1160, 44, 'Masama Kusini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1161, 44, 'Masama Rundugai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1162, 45, 'Mwika Kusini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1163, 45, 'Kirua Vunjo Mashariki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1164, 45, 'Kirua Vunjo Magharibi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1165, 45, 'Kahe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1166, 45, 'Kahe Mashariki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1167, 45, 'Old Moshi Mashariki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1168, 45, 'Old Moshi Magharibi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1169, 45, 'Mbokomu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1170, 45, 'Uru Mashariki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1171, 45, 'Uru Shimbwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1172, 45, 'Uru Kusini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1173, 45, 'Mwika Kaskazini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1174, 45, 'Uru Kaskazini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1175, 45, 'Mabogini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1176, 45, 'Arusha Chini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1177, 45, 'Kibosho Mashariki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1178, 45, 'Kibosho Kati', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1179, 45, 'Kibosho Magharibi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1180, 45, 'Kindi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1181, 45, 'Kiruavunjo Kusini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1182, 45, 'Kirima', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1183, 45, 'Okaoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1184, 45, 'Mamba Kaskazini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1185, 45, 'Kimochi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1186, 45, 'Kilema Kati', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1187, 45, 'Mamba Kusini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1188, 45, 'Marangu Mashariki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1189, 45, 'Marangu Magharibi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1190, 45, 'Kilema Kaskazini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1191, 45, 'Kilema Kusini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1192, 45, 'Kilimanjaro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1193, 45, 'Pasua', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1194, 45, 'Kaloleni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1195, 45, 'Kiboriloni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1196, 45, 'Msaranga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1197, 45, 'Karanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1198, 45, 'Longuo B', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1199, 45, 'Mfumuni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1200, 45, 'Soweto', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1201, 45, 'Boma Mbuzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1202, 45, 'Njoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1203, 45, 'Ngambo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1204, 45, 'Shirimatunda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1205, 45, 'Mji Mpya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1206, 45, 'Mawenzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1207, 45, 'Rau', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1208, 45, 'Korongoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1209, 45, 'Kiusa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1210, 45, 'Bondeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1211, 46, 'Kileo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1212, 46, 'Chomvu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1213, 46, 'Ngujini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1214, 46, 'Kirya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1215, 46, 'Kilomeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1216, 46, 'Shighatini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1217, 46, 'Langata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1218, 46, 'Mgagao', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1219, 46, 'Toloha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1220, 46, 'Kigonigoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1221, 46, 'Kivisini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1222, 46, 'Msangeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1223, 46, 'Kifula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1224, 46, 'Kighare', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1225, 46, 'Kwakoa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1226, 46, 'Lembeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1227, 46, 'Jipe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1228, 47, 'Mamsera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1229, 47, 'Mrao Keryo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1230, 47, 'Kirwa Keni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1231, 47, 'Katangara Mrere', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1232, 47, 'Kisale Msaranga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1233, 47, 'Olele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1234, 47, 'Kirongo Samanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1235, 47, 'Kitirima Kingachi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1236, 47, 'Ubetu Kahe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1237, 47, 'Nanjara Reha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1238, 47, 'Tarakea Motamburu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1239, 47, 'Mahida', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1240, 47, 'Motamburu Kitendeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1241, 47, 'Marangu Kitowo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1242, 47, 'Ngoyoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1243, 47, 'Holili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1244, 47, 'Mengwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1245, 47, 'Keni Mengeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1246, 47, 'Aleni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1247, 47, 'Shimbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1248, 47, 'Makiidi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1249, 47, 'Kelamfua Mokala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1250, 47, 'Ushiri Ikuini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1251, 48, 'Same', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1252, 48, 'Vuje', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1253, 48, 'Bombo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1254, 48, 'Mtii', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1255, 48, 'Maore', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1256, 48, 'Ndungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1257, 48, 'Kihurio', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1258, 48, 'Bendera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1259, 48, 'Myamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1260, 48, 'Mpinji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1261, 48, 'Bwambo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1262, 48, 'Ruvu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1263, 48, 'Vunta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1264, 48, 'Chome', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1265, 48, 'Suji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1266, 48, 'Makanya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1267, 48, 'Hedaru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1268, 48, 'Kirangare', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1269, 48, 'Kisima', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1270, 48, 'Stesheni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1271, 48, 'Vumari', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1272, 48, 'Mabilioni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1273, 48, 'Kalemawe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1274, 48, 'Lugulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1275, 48, 'Kisiwani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1276, 48, 'Msindo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1277, 48, 'Mshewa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1278, 48, 'Mhezi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1279, 48, 'Mwembe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1280, 48, 'Vudee', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1281, 49, 'Ndumeti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1282, 49, 'Kashashi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1283, 49, 'Karansi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1284, 49, 'Olkolili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1285, 49, 'Miti mirefu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1286, 49, 'Ormelili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1287, 49, 'Donyomurwak', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1288, 49, 'Kiruwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1289, 49, 'Songu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1290, 49, 'Ngarenairobi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1291, 49, 'Gararagua', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1292, 49, 'Sanya Juu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1293, 49, 'Biriri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1294, 49, 'Makiwaru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1295, 49, 'Nasai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1296, 49, 'Livishi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1297, 49, 'Ivaeny', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1298, 56, 'Balangidalalu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1299, 56, 'Gitting', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1300, 56, 'Masakta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1301, 56, 'Masqaroda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1302, 56, 'Endasak', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1303, 56, 'Gidahababieg', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1304, 56, 'Measkron', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1305, 56, 'Hidet', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1306, 56, 'Simbay', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1307, 56, 'Sirop', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1308, 56, 'Gisambalang', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1309, 56, 'Gehandu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1310, 56, 'Nangwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1311, 56, 'Katesh', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1312, 56, 'Ganana', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1313, 56, 'Dirma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1314, 56, 'Lalaji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1315, 56, 'Endasiwold', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1316, 56, 'Laghanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1317, 56, 'Getanuwas', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1318, 56, 'Hirbadaw', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1319, 56, 'Bassodesh', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1320, 56, 'Bassotu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1321, 56, 'Gendabi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1322, 56, 'Mogitu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1323, 57, 'Kibaya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1324, 57, 'Dongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1325, 57, 'Dosidosi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1326, 57, 'Engusero', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1327, 57, 'Matui', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1328, 57, 'Bwagamoyo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1329, 57, 'Loolera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1330, 57, 'Magungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1331, 57, 'Chapakazi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1332, 57, 'Namelock', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1333, 57, 'Partimbo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1334, 57, 'Olboloti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1335, 57, 'Makame', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1336, 57, 'Ndedo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1337, 57, 'Kijungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1338, 57, 'Lengatei', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1339, 57, 'Sunya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1340, 58, 'Dongobesh', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1341, 58, 'Tumati', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1342, 58, 'Maretadu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1343, 58, 'Maghang', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1344, 58, 'Haydom', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1345, 58, 'Yaeda Chini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1346, 58, 'Masieda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1347, 58, 'Endamilay', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1348, 58, 'Yaeda Ampa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1349, 58, 'Nambisi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1350, 58, 'Dinamu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1351, 58, 'Ayamohe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1352, 58, 'Endagikot', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1353, 58, 'Geterer', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1354, 58, 'Hayderer', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1355, 58, 'Eshkesh', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1356, 58, 'Gidihim', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1357, 58, 'Ayamaami', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1358, 58, 'Bashay', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1359, 58, 'Daudi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1360, 58, 'Marang', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1361, 58, 'Gunyoda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1362, 58, 'Nahasey', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1363, 58, 'Bargish', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1364, 58, 'Sanu Baray', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1365, 58, 'Imboru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1366, 58, 'Kainam', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1367, 58, 'Murray', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1368, 58, 'Tlawi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1369, 59, 'Orkesumet', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1370, 59, 'Ngorika', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1371, 59, 'Liborsoit', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1372, 59, 'Ruvu Remiti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1373, 59, 'Kitwai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1374, 59, 'Komolo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1375, 59, 'Naisinyai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1376, 59, 'Endiamtu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1377, 59, 'Endonyongijape', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1378, 59, 'Naberera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1379, 59, 'Loiborsiret', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1380, 59, 'Emboreet', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1381, 59, 'Terrat', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1382, 59, 'Oljoro No. 5', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1383, 59, 'Shambarai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1384, 59, 'Mrerani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1385, 59, 'Msitu wa Tembo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1386, 137, 'Malezi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1387, 137, 'Mdoe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1388, 137, 'Kwediyamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1389, 137, 'Kwenjugo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1390, 137, 'Mabanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1391, 137, 'Konje', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1392, 137, 'Mlimani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1393, 137, 'Msasa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1394, 137, 'Kideleko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1395, 137, 'Kwamagome', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1396, 137, 'Vibaoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1397, 137, 'Segera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1398, 137, 'Sindeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1399, 137, 'Misima', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1400, 137, 'Kiva', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1401, 137, 'Kabuku', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1402, 137, 'Kwamatuku', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1403, 137, 'Kwedizinga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1404, 137, 'Mgambo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1405, 137, 'Komkonga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1406, 137, 'Mkata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1407, 137, 'Kabuku Ndani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1408, 137, 'Ndolwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1409, 137, 'Kwamgwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1410, 137, 'Mazingara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1411, 137, 'Kwamsisi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1412, 137, 'Kwasunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1413, 137, 'Kwaluguru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1414, 137, 'Kangata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1415, 137, 'Kwankonje', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1416, 137, 'Kwachaga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1417, 138, 'Lwande', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1418, 138, 'Mvungwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1419, 138, 'Kwediboma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1420, 138, 'Saunyi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1421, 138, 'Jaila', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1422, 138, 'Msanja', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1423, 138, 'Kisangasa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1424, 138, 'Mabalanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1425, 138, 'Kibirashi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1426, 138, 'Kilwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1427, 138, 'Tunguli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1428, 138, 'Kikunde', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1429, 138, 'Kwekivu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1430, 138, 'Songe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1431, 138, 'Pagwi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1432, 138, 'Masagulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1433, 138, 'Kimbe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1434, 138, 'Kilindi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1435, 138, 'Negero', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1436, 138, 'Mkindi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1437, 139, 'Mashewa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1438, 139, 'Lutindi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1439, 139, 'Chekelei', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1440, 139, 'Mombo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1441, 139, 'Mkalamo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1442, 139, 'Mazinde', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1443, 139, 'Mkomazi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1444, 139, 'Kwashemshi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1445, 139, 'Mpale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1446, 139, 'Mswaha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1447, 139, 'Kizara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1448, 139, 'Magamba Kwalukonge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1449, 139, 'Magoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1450, 139, 'Kerenge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1451, 139, 'Kwagunda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1452, 139, 'Mnyuzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1453, 139, 'Vugiri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1454, 139, 'Dindira', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1455, 139, 'Ngombezi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1456, 139, 'Mtonga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1457, 139, 'Magunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1458, 139, 'Kwamndolwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1459, 139, 'Old Korogwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1460, 139, 'Manundu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1461, 139, 'Kilole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1462, 140, 'Lushoto', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1463, 140, 'Mtae', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1464, 140, 'Sunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1465, 140, 'Rangwi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1466, 140, 'Gare', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1467, 140, 'Mnazi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1468, 140, 'Lunguza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1469, 140, 'Mbaramo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1470, 140, 'Mngaro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1471, 140, 'Mlalo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1472, 140, 'Mwangoi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1473, 140, 'Shume', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1474, 140, 'Malindi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1475, 140, 'Hemtoye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1476, 140, 'Malibwi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1477, 140, 'Kwai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1478, 140, 'Mlola', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1479, 140, 'Ngwelo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1480, 140, 'Kwekanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1481, 140, 'Lukozi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1482, 140, 'Manolo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1483, 140, 'Dule M', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1484, 140, 'Kwemshasha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1485, 140, 'Ubiri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1486, 140, 'Ngulwi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1487, 140, 'Kwemashai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1488, 140, 'Tamota', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1489, 140, 'Bumbuli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1490, 140, 'Funta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1491, 140, 'Mayo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1492, 140, 'Baga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1493, 140, 'Mlingano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1494, 140, 'Mgwashi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1495, 140, 'Nkongoi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1496, 140, 'Dule B', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1497, 140, 'Maheza Ngulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1498, 140, 'Usambara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1499, 140, 'Soni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1500, 140, 'Vuga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1501, 140, 'Mponde', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1502, 140, 'Mamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1503, 140, 'Mbuzii', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1504, 141, 'Misozwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26');
INSERT INTO `wards` (`id`, `district_id`, `name`, `created_at`, `updated_at`) VALUES
(1505, 141, 'Masuguru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1506, 141, 'Tingeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1507, 141, 'Kilulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1508, 141, 'Mkuzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1509, 141, 'Mtindiro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1510, 141, 'Kwafungo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1511, 141, 'Songa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1512, 141, 'Bwembwera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1513, 141, 'Potwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1514, 141, 'Pande Darajani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1515, 141, 'Nkumba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1516, 141, 'Misalai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1517, 141, 'Zirai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1518, 141, 'Mbomole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1519, 141, 'Amani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1520, 141, 'Tongwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1521, 141, 'Mhamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1522, 141, 'Kwakifua', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1523, 141, 'Kwemkabala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1524, 141, 'Ngomeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1525, 141, 'Genge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1526, 141, 'Tanganyika', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1527, 141, 'Mpapayu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1528, 141, 'Mlingoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1529, 141, 'Kigombe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1530, 141, 'Lusanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1531, 141, 'Kicheba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1532, 141, 'Magoroto', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1533, 141, 'Magila', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1534, 142, 'Mwakijembe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1535, 142, 'Maramba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1536, 142, 'Kigongoi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1537, 142, 'Daluni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1538, 142, 'Bosha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1539, 142, 'Mapatano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1540, 142, 'Bwiti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1541, 142, 'Mnyenzani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1542, 142, 'Doda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1543, 142, 'Boma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1544, 142, 'Parungu Kasera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1545, 142, 'Mkinga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1546, 142, 'Mayomboni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1547, 142, 'Sigaya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1548, 142, 'Duga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1549, 142, 'Moa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1550, 142, 'Manza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1551, 142, 'Kwale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1552, 142, 'Mtimbwani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1553, 142, 'Gombero', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1554, 142, 'Mhinduro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1555, 143, 'Pangani Mashariki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1556, 143, 'Mikunguni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1557, 143, 'Ubangaa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1558, 143, 'Mkwaja', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1559, 143, 'Pangani Magharibi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1560, 143, 'Bweni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1561, 143, 'Madanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1562, 143, 'Kimanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1563, 143, 'Bushiri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1564, 143, 'Mwera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1565, 143, 'Tungamaa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1566, 143, 'Kipumbwi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1567, 25, 'Image', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1568, 25, 'Ukwega', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1569, 25, 'Boma la Ngombe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1570, 25, 'Masisiwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1571, 25, 'Nguruhe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1572, 25, 'Ngangange', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1573, 25, 'Ihimbo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1574, 25, 'Lugalo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1575, 25, 'Nyalumbu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1576, 25, 'Mlafu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1577, 25, 'Irole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1578, 25, 'Ibumu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1579, 25, 'Ruaha Mbuyuni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1580, 25, 'Kimala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1581, 25, 'Uhambingeto', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1582, 25, 'Udekwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1583, 25, 'Mtitu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1584, 25, 'Dabaga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1585, 25, 'Ukumbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1586, 27, 'Kiyowela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1587, 27, 'Malangali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1588, 27, 'Nyololo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1589, 27, 'Ihowanza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1590, 27, 'Ikweha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1591, 27, 'Sadani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1592, 27, 'Igombavu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1593, 27, 'Bumilayinga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1594, 27, 'Mtwango', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1595, 27, 'Isalavanu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1596, 27, 'Rungemba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1597, 27, 'Makungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1598, 27, 'Ifwagi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1599, 27, 'Mdabulo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1600, 27, 'Ihalimba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1601, 27, 'Kibengu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1602, 27, 'Mapanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1603, 27, 'Mpanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1604, 27, 'Ihanu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1605, 27, 'Luhunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1606, 27, 'Mninga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1607, 27, 'Kasanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1608, 27, 'Igowole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1609, 27, 'Mtambula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1610, 27, 'Itandula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1611, 27, 'Mbalamaziwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1612, 27, 'Idunda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1613, 35, 'Mbede', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1614, 35, 'Usevya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1615, 35, 'Ikuba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1616, 35, 'Mwamapuli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1617, 35, 'Kasansa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1618, 35, 'Nsenkwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1619, 35, 'Inyonga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1620, 35, 'Ilunde', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1621, 35, 'Ilela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1622, 35, 'Utende', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1623, 35, 'Kasokola', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1624, 35, 'Urwila', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1625, 35, 'Nsimbo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1626, 35, 'Magamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1627, 35, 'Sitalike', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1628, 35, 'Machimboni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1629, 35, 'Kapalala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1630, 35, 'Itenka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1631, 35, 'Ugala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1632, 35, 'Litapunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1633, 35, 'Mtapenda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1634, 36, 'Kakese', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1635, 36, 'Misunkumilo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1636, 36, 'Shanwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1637, 36, 'Makanyagio', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1638, 36, 'Kashaulili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1639, 36, 'Mpanda Hotel', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1640, 36, 'Kawajense', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1641, 36, 'Nsemulwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1642, 36, 'Ilembo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1643, 36, 'Mishamo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1644, 36, 'Mnyagala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1645, 36, 'Kasekese', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1646, 36, 'Isengule', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1647, 36, 'Bulamata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1648, 36, 'Ilangu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1649, 36, 'Ipwaga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1650, 36, 'Mpandandogo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1651, 36, 'Mwese', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1652, 36, 'Katuma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1653, 36, 'Kabungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1654, 36, 'Sibwesa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1655, 36, 'Ikola', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1656, 36, 'Karema', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1657, 36, 'Kapalamsenga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1658, 67, 'Kambikatoto', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1659, 67, 'Chalangwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1660, 67, 'Ifumbo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1661, 67, 'Mafyeko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1662, 67, 'Mkola', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1663, 67, 'Makongolosi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1664, 67, 'Matwiga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1665, 67, 'Matundasi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1666, 67, 'Mtanila', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1667, 67, 'Lupatingatinga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1668, 67, 'Luwalaje', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1669, 67, 'Sangambi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1670, 67, 'Itewe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1671, 67, 'Chokaa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1672, 68, 'Lusungo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1673, 68, 'Ngana', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1674, 68, 'Busale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1675, 68, 'Ikama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1676, 68, 'Ipinda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1677, 68, 'Ngonga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1678, 68, 'Ikimba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1679, 68, 'Itope', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1680, 68, 'Talatala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1681, 68, 'Makwale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1682, 68, 'Kyela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1683, 68, 'Matema', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1684, 68, 'Ndobo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1685, 68, 'Kajunjumele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1686, 68, 'Bujonde', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1687, 68, 'Ikolo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1688, 68, 'Katumba Songwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1689, 69, 'Luhanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1690, 69, 'Ubaruku', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1691, 69, 'Igurusi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1692, 69, 'Mwatenga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1693, 69, 'Imalilosongwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1694, 69, 'Igava', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1695, 69, 'Ipwani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1696, 69, 'Itamboleo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1697, 69, 'Miyombweni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1698, 69, 'Rujewa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1699, 69, 'Madibira', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1700, 69, 'Lugelele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1701, 69, 'Mawindi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1702, 69, 'Ihahi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1703, 69, 'Mapogoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1704, 69, 'Chimala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1705, 69, 'Utengule Usangu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1706, 69, 'Ruiwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1707, 69, 'Mahongole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1708, 72, 'Swaya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1709, 72, 'Masukulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1710, 72, 'Kisiba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1711, 72, 'Masoko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1712, 72, 'Bujela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1713, 72, 'Ilima', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1714, 72, 'Masebe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1715, 72, 'Kisondela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1716, 72, 'Ikuti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1717, 72, 'Malindo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1718, 72, 'Mpuguso', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1719, 72, 'Kikole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1720, 72, 'Lufingo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1721, 72, 'Nkunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1722, 72, 'Kyimo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1723, 72, 'Kinyala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1724, 72, 'Kiwira', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1725, 72, 'Suma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1726, 72, 'Isongole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1727, 72, 'Ibighi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1728, 72, 'Bagamoyo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1729, 72, 'Kawetele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1730, 72, 'Bulyaga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1731, 72, 'Makandana', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1732, 72, 'Lufilyo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1733, 72, 'Kisegese', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1734, 72, 'Lupata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1735, 72, 'Kambasegela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1736, 72, 'Kandete', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1737, 72, 'Luteba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1738, 72, 'Mpombo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1739, 72, 'Isange', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1740, 72, 'Kabula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1741, 72, 'Lwangwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1742, 93, 'Lumbila', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1743, 93, 'Mundindi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1744, 93, 'Mavanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1745, 93, 'Ibumi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1746, 93, 'Nkomangombe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1747, 93, 'Luilo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1748, 93, 'Masasi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1749, 93, 'Iwela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1750, 93, 'Lupingu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1751, 93, 'Ludewa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1752, 93, 'Kilondo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1753, 93, 'Ludende', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1754, 93, 'Luana', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1755, 93, 'Makonde', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1756, 93, 'Mkongobaki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1757, 93, 'Lifuma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1758, 93, 'Ruhuhu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1759, 93, 'Mawengi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1760, 93, 'Lupanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1761, 93, 'Mlangali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1762, 93, 'Milo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1763, 93, 'Lugarawa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1764, 93, 'Madope', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1765, 93, 'Madilu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1766, 95, 'Lupalilo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1767, 95, 'Kigulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1768, 95, 'Matamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1769, 95, 'Mlondwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1770, 95, 'Kitulo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1771, 95, 'Ikuwo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1772, 95, 'Mfumbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1773, 95, 'Ipepo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1774, 95, 'Mbalatse', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1775, 95, 'Tandala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1776, 95, 'Luwumbu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1777, 95, 'Iwawa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1778, 95, 'Isapulano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1779, 95, 'Kigala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1780, 95, 'Itundu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1781, 95, 'Mang`oto', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1782, 95, 'Lupila', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1783, 95, 'Ukwama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1784, 95, 'Bulongwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1785, 95, 'Kipagilo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1786, 95, 'Iniho', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1787, 95, 'Ipelele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1788, 97, 'Saja', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1789, 97, 'Imalinyi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1790, 97, 'Ulembwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1791, 97, 'Makoga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1792, 97, 'Kipengere', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1793, 97, 'Igosi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1794, 97, 'Wangama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1795, 97, 'Kidugala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1796, 97, 'Luduga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1797, 97, 'Kijombe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1798, 97, 'Wanging`ombe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1799, 97, 'Ilembula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1800, 97, 'Uhambule', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1801, 97, 'Usuka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1802, 97, 'Igwachanya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1803, 97, 'Mdandu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1804, 108, 'Mwembenkoswe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1805, 108, 'Legeza Mwendo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1806, 108, 'Ulumi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1807, 108, 'Mnamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1808, 108, 'Katete', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1809, 108, 'Kisumba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1810, 108, 'Mkali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1811, 108, 'Kilesha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1812, 108, 'Mkowe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1813, 108, 'Msanzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1814, 108, 'Matai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1815, 108, 'Sopa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1816, 108, 'Mwazye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1817, 108, 'Katazi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1818, 108, 'Mwimbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1819, 108, 'Mambwekenya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1820, 109, 'Korongwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1821, 109, 'Wampembe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1822, 109, 'Ninde', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1823, 109, 'Kirando', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1824, 109, 'Kabwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1825, 109, 'Kipili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1826, 109, 'Nkandasi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1827, 109, 'Namanyere', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1828, 109, 'Nkomolo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1829, 109, 'Mtenga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1830, 109, 'Mkwamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1831, 109, 'Chala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1832, 109, 'Kipande', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1833, 109, 'Isale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1834, 109, 'Kate', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1835, 109, 'Sintali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1836, 109, 'Kala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1837, 110, 'Mfinga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1838, 110, 'Kipeta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1839, 110, 'Kaoze', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1840, 110, 'Miangalua', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1841, 110, 'Kalambanzite', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1842, 110, 'Lusaka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1843, 110, 'Laela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1844, 110, 'Muze', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1845, 110, 'Mtowisa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1846, 110, 'Milepa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1847, 110, 'Sandulula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1848, 110, 'Kaengesa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1849, 110, 'Mpui', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1850, 110, 'Msanda Muungano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1851, 110, 'Ilemba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1852, 110, 'Pito', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1853, 110, 'Milanzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1854, 110, 'Matanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1855, 110, 'Kasense', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1856, 110, 'Chanji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1857, 110, 'Mazwi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1858, 110, 'Izia', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1859, 110, 'Katandala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1860, 110, 'Old Sumbawanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1861, 110, 'Kizwite', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1862, 110, 'Ntendo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1863, 110, 'Senga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1864, 110, 'Mollo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1865, 71, 'Myovizi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1866, 71, 'Igamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1867, 71, 'Halungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1868, 71, 'Msia', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1869, 71, 'Mlowo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1870, 71, 'Ipunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1871, 71, 'Isandula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1872, 71, 'Vwawa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1873, 71, 'Bara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1874, 71, 'Nanyala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1875, 71, 'Nambinzo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1876, 71, 'Itaka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1877, 71, 'Isansa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1878, 71, 'Ruanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1879, 71, 'Iyula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1880, 71, 'Nyimbili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1881, 50, 'Tingi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1882, 50, 'Miguruwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1883, 50, 'Likawage', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1884, 50, 'Nanjirinji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1885, 50, 'Kiranjeranje', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1886, 50, 'Mandawa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1887, 50, 'Lihimalyao', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1888, 50, 'Pande Mikoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1889, 50, 'Kivinjesingino', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1890, 50, 'Songosongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1891, 50, 'Miteja', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1892, 50, 'Kibata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1893, 50, 'Mingumbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1894, 50, 'Kinjumbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1895, 50, 'Chumo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1896, 50, 'Kipatimu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1897, 50, 'Kandawale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1898, 50, 'Njinjo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1899, 50, 'Mitole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1900, 51, 'Mipingo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1901, 51, 'Nachunyu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1902, 51, 'Mtama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1903, 51, 'Nyangao', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1904, 51, 'Namupa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1905, 51, 'Nyengedi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1906, 51, 'Mtua', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1907, 51, 'Nahukahuka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1908, 51, 'Nyangamara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1909, 51, 'Mandwanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1910, 51, 'Mnara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1911, 51, 'Kitomanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1912, 51, 'Chiponda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1913, 51, 'Pangatena', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1914, 51, 'Longa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1915, 51, 'Rutamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1916, 51, 'Kiwawa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1917, 51, 'Mtumbya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1918, 51, 'Matimba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1919, 51, 'Nangaru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1920, 51, 'Mchinga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1921, 51, 'Namangwale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1922, 51, 'Kilolambwani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1923, 51, 'Kilangala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1924, 51, 'Kiwalala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1925, 51, 'Navanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1926, 51, 'Mnolela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1927, 51, 'Sudi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1928, 51, 'Ndoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1929, 51, 'Rasbura', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1930, 51, 'Mtanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1931, 51, 'Jamhuri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1932, 51, 'Msanjihili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1933, 51, 'Mingoyo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1934, 51, 'Ng?apa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1935, 51, 'Tandangongoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1936, 51, 'Chikonji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1937, 51, 'Mbanja', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1938, 51, 'Mikumbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1939, 51, 'Mitandi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1940, 51, 'Rahaleo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1941, 51, 'Mwenge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1942, 51, 'Matopeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1943, 51, 'Wailes', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1944, 51, 'Nachingwea', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1945, 52, 'Liwale Mjini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1946, 52, 'Kiangara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1947, 52, 'Kibutuka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1948, 52, 'Nangano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1949, 52, 'Mpigamiti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1950, 52, 'Mirui', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1951, 52, 'Liwale B', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1952, 52, 'Mangirirkiti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1953, 52, 'Nangando', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1954, 52, 'Likongowele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1955, 52, 'Kichonda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1956, 52, 'Mihumo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1957, 52, 'Lilombe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1958, 52, 'Ngongowele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1959, 52, 'Mlembwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1960, 52, 'Makata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1961, 52, 'Barikiwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1962, 52, 'Mkutano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1963, 52, 'Mbaya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1964, 52, 'Kimambi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1965, 53, 'Nambambo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1966, 53, 'Kilimarondo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1967, 53, 'Mbondo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1968, 53, 'Kiegei', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1969, 53, 'Chiola', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1970, 53, 'Mpiruka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1971, 53, 'Nangowe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1972, 53, 'Mkotokuyana', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1973, 53, 'Naipanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1974, 53, 'Kilimahewa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1975, 53, 'Naipingo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1976, 53, 'Mnerongongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1977, 53, 'Matekwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1978, 53, 'Marambo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1979, 53, 'Namatula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1980, 53, 'Ndomoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1981, 53, 'Ruponda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1982, 53, 'Mneromiembeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1983, 53, 'Namapwia', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1984, 53, 'Kiparamnero', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1985, 53, 'Lionja', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1986, 53, 'Namikango', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1987, 53, 'Nditi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1988, 54, 'Ruangwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1989, 54, 'Likunja', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1990, 54, 'Mnacho', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1991, 54, 'Nambilaje', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1992, 54, 'Mandarawe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1993, 54, 'Matambarale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1994, 54, 'Chibula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1995, 54, 'Nandagala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1996, 54, 'Mbekenyera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1997, 54, 'Nanganga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1998, 54, 'Chinongwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(1999, 54, 'Nambilanje', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2000, 54, 'Nkowe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2001, 54, 'Luchelegwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2002, 54, 'Chienjele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2003, 54, 'Namichiga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2004, 54, 'Narungombe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2005, 54, 'Makanjiro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2006, 80, 'Namatutwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2007, 80, 'Chiwata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2008, 80, 'Mkundi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2009, 80, 'Mkululu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2010, 80, 'Nanjota', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2011, 80, 'Chiungutwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2012, 80, 'Mbuyuni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2013, 80, 'Lipumburu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2014, 80, 'Sindano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2015, 80, 'Namalenga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2016, 80, 'Mchauru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2017, 80, 'Namajani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2018, 80, 'Mnavira', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2019, 80, 'Chikolopola', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2020, 80, 'Lulindi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2021, 80, 'Mlingula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2022, 80, 'Chiwale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2023, 80, 'Lukuledi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2024, 80, 'Mpanyani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2025, 80, 'Chigugu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2026, 80, 'Mwena', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2027, 80, 'Mwenge Mtapika', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2028, 80, 'Migongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2029, 80, 'Sululu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2030, 80, 'Mkuti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2031, 80, 'Mpindimbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2032, 80, 'Nyasa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2033, 80, 'Marika', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2034, 80, 'Mkomaindo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2035, 80, 'Mtandi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2036, 80, 'Jida', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2037, 83, 'Mangaka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2038, 83, 'Mkonona', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2039, 83, 'Nanyumbu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2040, 83, 'Chipuputa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2041, 83, 'Napacho', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2042, 83, 'Nangomba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2043, 83, 'Lumesule', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2044, 83, 'Likokona', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2045, 83, 'Sengenya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2046, 83, 'Mnanje', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2047, 83, 'Mikangaula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2048, 83, 'Maratani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2049, 83, 'Nandete', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2050, 84, 'Chilangala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2051, 84, 'Mkoma II', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2052, 84, 'Kitangari', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2053, 84, 'Malatu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2054, 84, 'Mchemo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2055, 84, 'Mtopwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2056, 84, 'Chiwonga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2057, 84, 'Maputi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2058, 84, 'Makukwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2059, 84, 'Mkwedu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2060, 84, 'Nakahako', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2061, 84, 'Chihangu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2062, 84, 'Nambali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2063, 84, 'Nandwahi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2064, 84, 'Mtunguru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2065, 84, 'Mdimbampelempele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2066, 84, 'Mpwapwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2067, 84, 'Mnyeu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2068, 84, 'Chitekete', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2069, 84, 'Mnyambe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2070, 84, 'Luchingu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2071, 84, 'Makote', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2072, 84, 'Mcholi II', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2073, 84, 'Mtonya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2074, 84, 'Makonga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2075, 84, 'Nangwala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2076, 84, 'Tulindane', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2077, 84, 'Julia', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2078, 84, 'Mkulungulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2079, 84, 'Mahumbika', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2080, 84, 'Mtumachi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2081, 84, 'Nanguruwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2082, 84, 'Mkunya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2083, 84, 'Mcholi I', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2084, 84, 'Namiyonga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2085, 84, 'Mnekachi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2086, 85, 'Tandahimba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2087, 85, 'Lukokoda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2088, 85, 'Mahuta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2089, 85, 'Nanhyanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2090, 85, 'Chingungwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2091, 85, 'Mdimbamnyoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2092, 85, 'Milingodi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2093, 85, 'Lyenje', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2094, 85, 'Chaume', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2095, 85, 'Mkonjowano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2096, 85, 'Kitama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2097, 85, 'Luagala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2098, 85, 'Ngunja', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2099, 85, 'Mkwiti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2100, 85, 'Litehu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2101, 85, 'Nambahu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2102, 85, 'Mihuta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2103, 85, 'Kwanyama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2104, 85, 'Mchichira', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2105, 85, 'Chikongola', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2106, 85, 'Dinduma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2107, 85, 'Michenjele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2108, 85, 'Mdumbwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2109, 85, 'Mihambwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2110, 85, 'Mkoreha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2111, 85, 'Maundo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2112, 85, 'Naputa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2113, 85, 'Namikupa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2114, 85, 'Mnyawa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2115, 111, 'Kambarage', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2116, 111, 'Mapera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2117, 111, 'Kipapa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2118, 111, 'Kipololo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2119, 111, 'Nyoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2120, 111, 'Maguu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2121, 111, 'Kitumbalomo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2122, 111, 'Mkako', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2123, 111, 'Litumbandyosi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2124, 111, 'Mkalanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2125, 111, 'Langiro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2126, 111, 'Mbuji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2127, 111, 'Litembo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2128, 111, 'Ngima', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2129, 111, 'Mkumbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2130, 111, 'Linda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2131, 111, 'Matiri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2132, 111, 'Ukata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2133, 111, 'Kigonsera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2134, 111, 'Kitura', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2135, 111, 'Namswea', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2136, 111, 'Mpapa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2137, 111, 'Mhongozi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2138, 111, 'Amani Makolo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2139, 111, 'Wukiro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2140, 111, 'Lukarasi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2141, 111, 'Kihangi Mahuka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2142, 111, 'Kikolo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2143, 111, 'Luwaita', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2144, 111, 'Myangayanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2145, 111, 'Kitanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2146, 111, 'Mpepai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2147, 111, 'Mateka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2148, 111, 'Kagugu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2149, 111, 'Mbambi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2150, 111, 'Lusonga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2151, 111, 'Matarawe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2152, 111, 'Masumuni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2153, 111, 'Betrehemu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2154, 111, 'Luhuwiko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2155, 111, 'Mbinga Mjini A', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2156, 111, 'Utiri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2157, 111, 'Mbinga Mjini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2158, 111, 'Mbangamao', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2159, 111, 'Kihungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2160, 114, 'Rwinga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2161, 114, 'Luegu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2162, 114, 'Namtumbo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2163, 114, 'Mgombasi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2164, 114, 'Iitola', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2165, 114, 'Likuyuseka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2166, 114, 'Mputa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2167, 114, 'Hanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2168, 114, 'Limamu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2169, 114, 'Mchomoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2170, 114, 'Ligera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2171, 114, 'Lusewa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2172, 114, 'Magazini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2173, 114, 'Luchili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2174, 114, 'Namabengo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2175, 115, 'Liparamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2176, 115, 'Liuli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2177, 115, 'Kihagara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2178, 115, 'Ngumbo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2179, 115, 'Liwundi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2180, 115, 'Mbaha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2181, 115, 'Lituhi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2182, 115, 'Chiwanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2183, 115, 'Mtipwili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2184, 115, 'Kingerikiti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2185, 115, 'Luhangarasi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2186, 115, 'Kilosa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2187, 115, 'Mbambabay', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2188, 115, 'Lipingo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2189, 112, 'Wino', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2190, 112, 'Kilagano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2191, 112, 'Maposeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2192, 112, 'Peramiho', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2193, 112, 'Mahanje', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2194, 112, 'Matimira', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2195, 112, 'Mtyangimbole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2196, 112, 'Mkongotema', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2197, 112, 'Mbinga Mhalule', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2198, 112, 'Ndongosi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2199, 112, 'Matumbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2200, 112, 'Mpandangindo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2201, 112, 'Gumbiro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2202, 112, 'Mpitimbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2203, 112, 'Muhukuru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2204, 112, 'Magagura', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2205, 112, 'Litisha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2206, 112, 'Mjini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2207, 112, 'Subira', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2208, 112, 'Ruhuwiko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2209, 112, 'Mshangano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2210, 112, 'Mletele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2211, 112, 'SeedFarm', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2212, 112, 'Tanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2213, 112, 'Msamala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2214, 112, 'Lilambo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2215, 112, 'Mwengemshindo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2216, 112, 'Ndilimalitembo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2217, 112, 'Misufini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2218, 112, 'Mfaranyaki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2219, 112, 'Lizaboni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2220, 112, 'Bombambili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2221, 112, 'Matogoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2222, 112, 'Ruvuma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2223, 112, 'Lituta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2224, 112, 'Matetereka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2225, 113, 'Kalulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2226, 113, 'Misechela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2227, 113, 'Namasakata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2228, 113, 'Mtina', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2229, 113, 'Mchesi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2230, 113, 'Lukumbule', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2231, 113, 'Nalasi Magharibi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2232, 113, 'Mchoteka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2233, 113, 'Marumba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2234, 113, 'Mbesa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2235, 113, 'Mlingoti Magharibi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2236, 113, 'Ligunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2237, 113, 'Kidodoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2238, 113, 'Nandembo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2239, 113, 'Nampungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2240, 113, 'Matemanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26');
INSERT INTO `wards` (`id`, `district_id`, `name`, `created_at`, `updated_at`) VALUES
(2241, 113, 'Namwinyu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2242, 113, 'Mbati', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2243, 113, 'Nalasi Mashariki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2244, 113, 'Mchuluka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2245, 113, 'Namiungo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2246, 113, 'Jakika', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2247, 113, 'Mlingoti Mashariki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2248, 113, 'Masonya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2249, 113, 'Sisikwasisi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2250, 113, 'Mchangani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2251, 113, 'Nanjoka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2252, 113, 'Nakayaya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2253, 113, 'Mindu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2254, 113, 'Ngapa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2255, 113, 'Nakapanya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2256, 113, 'Muhuwesi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2257, 113, 'Tuwemacho', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2258, 113, 'Ligoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2259, 37, 'Nyamugali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2260, 37, 'Janda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2261, 37, 'Munzeze', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2262, 37, 'Rusaba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2263, 37, 'Muhinda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2264, 37, 'Munanila', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2265, 37, 'Mwayaya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2266, 37, 'Biharu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2267, 37, 'Muyama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2268, 37, 'Kajana', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2269, 37, 'Mugera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2270, 37, 'Kilelema', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2271, 37, 'Munyegera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2272, 37, 'Buhigwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2273, 37, 'Kibande', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2274, 41, 'Misezero', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2275, 41, 'Mabamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2276, 41, 'Bunyanbo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2277, 41, 'Itaba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2278, 41, 'Kitahana', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2279, 41, 'Bitare', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2280, 41, 'Murungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2281, 41, 'Busagara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2282, 41, 'Rugongwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2283, 41, 'Busunzu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2284, 41, 'Kumsenga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2285, 41, 'Kizazi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2286, 38, 'Nyabibuye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2287, 38, 'Katanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2288, 38, 'Mugunzu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2289, 38, 'Nyamtukuza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2290, 38, 'Muhange', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2291, 38, 'Kasuga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2292, 38, 'Kakonko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2293, 38, 'Kiziguzigu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2294, 38, 'Rugenge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2295, 38, 'Kasanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2296, 38, 'Gwanumpu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2297, 39, 'Kitanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2298, 39, 'Kurugongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2299, 39, 'Rungwe Mpya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2300, 39, 'Asante Nyerere', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2301, 39, 'Titye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2302, 39, 'Shunguliba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2303, 39, 'Muzye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2304, 39, 'Bugaga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2305, 39, 'Kigembe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2306, 39, 'Rusesa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2307, 39, 'Kwaga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2308, 39, 'Herushingo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2309, 39, 'Nyamidaho', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2310, 39, 'Kitagata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2311, 39, 'Nyachenda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2312, 39, 'Buhoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2313, 39, 'Nyamnyusi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2314, 39, 'Nyakitonto', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2315, 39, 'Kagerankanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2316, 39, 'Kigondo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2317, 39, 'Msambara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2318, 39, 'Ruhita', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2319, 39, 'Nyumbigwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2320, 39, 'Murufiti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2321, 39, 'Nyansha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2322, 39, 'Kasulu Mjini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2323, 39, 'Muhunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2324, 43, 'Kalya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2325, 43, 'Uvinza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2326, 43, 'Mganza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2327, 43, 'Mtego wa Noti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2328, 43, 'Nguruka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2329, 43, 'Itebula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2330, 43, 'Buhingu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2331, 43, 'Sigunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2332, 43, 'Sunuka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2333, 43, 'Ilagala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2334, 43, 'Simbo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2335, 43, 'Kandaga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2336, 43, 'Kazuramimba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2337, 119, 'Nkindwabiye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2338, 119, 'Ngulyati', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2339, 119, 'Kilalo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2340, 119, 'Kasoli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2341, 119, 'Gambosi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2342, 119, 'Ikungulyabashashi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2343, 119, 'Dutwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2344, 119, 'Sapiwi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2345, 119, 'Mwaubingi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2346, 119, 'Gilya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2347, 119, 'Nkololo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2348, 119, 'Mwaumatondo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2349, 119, 'Mwadobana', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2350, 119, 'Sakwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2351, 119, 'Mhango', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2352, 119, 'Guduwi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2353, 119, 'Nyakabindi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2354, 119, 'Isanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2355, 119, 'Bariadi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2356, 119, 'Nyangokolwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2357, 119, 'Somanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2358, 119, 'Bunamhala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2359, 120, 'Shigala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2360, 120, 'Ngasamo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2361, 120, 'Malili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2362, 120, 'Igalukilo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2363, 120, 'Badugu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2364, 120, 'Nyaluhande', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2365, 120, 'Kiloleli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2366, 120, 'Mwamanyili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2367, 120, 'Kabita', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2368, 120, 'Kalemela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2369, 120, 'Lamadi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2370, 120, 'Lutubiga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2371, 121, 'Ndolelezi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2372, 121, 'Lagangabilili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2373, 121, 'Budalabujiga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2374, 121, 'Nkoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2375, 121, 'Mwalushu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2376, 121, 'Mwamapalala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2377, 121, 'Nyamalapa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2378, 121, 'Nhobora', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2379, 121, 'Zagayu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2380, 121, 'Ikindilo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2381, 121, 'Kinangweli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2382, 121, 'Mbita', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2383, 121, 'Sawida', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2384, 121, 'Mwamtani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2385, 121, 'Sagata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2386, 121, 'Mwaswale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2387, 121, 'Nkuyu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2388, 121, 'Mhunze', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2389, 121, 'Migato', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2390, 121, 'Chinamili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2391, 123, 'Mwanhuzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2392, 123, 'Imalaseko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2393, 123, 'Mwabuzo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2394, 123, 'Mwamalole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2395, 123, 'Mwanjolo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2396, 123, 'Mwabuma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2397, 123, 'Mwabusalu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2398, 123, 'Lubiga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2399, 123, 'Mwamanongu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2400, 123, 'Nghoboko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2401, 123, 'Bukundi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2402, 123, 'Mwasengela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2403, 123, 'Mwamanimba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2404, 123, 'Tindabuligi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2405, 123, 'Mwakisandu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2406, 123, 'Mwangundo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2407, 123, 'Mwanyahina', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2408, 123, 'Kimali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2409, 123, 'Mwamishali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2410, 123, 'Itinje', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2411, 123, 'Mwandoya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2412, 123, 'Lingeka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2413, 123, 'Sakasaka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2414, 122, 'Ngwigwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2415, 122, 'Budekwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2416, 122, 'Busilili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2417, 122, 'Sengwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2418, 122, 'Masela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2419, 122, 'Zanzui', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2420, 122, 'Mwamashimba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2421, 122, 'Buchambi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2422, 122, 'Kadoto', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2423, 122, 'Shishiyu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2424, 122, 'Nguliguli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2425, 122, 'Nyabubinza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2426, 122, 'Mwanghonoli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2427, 122, 'Kulimi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2428, 122, 'Malampaka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2429, 122, 'Badi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2430, 122, 'Nyalikungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2431, 122, 'Binza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2432, 122, 'Ipililo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2433, 122, 'Senani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2434, 122, 'Mwamanenge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2435, 122, 'Mpindo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2436, 122, 'Dakama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2437, 122, 'Lalago', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2438, 116, 'Ngogwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2439, 116, 'Mwendakulima', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2440, 116, 'Zongomera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2441, 116, 'Mhungula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2442, 116, 'Nyihogo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2443, 116, 'Nyasubi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2444, 116, 'Kahama Mjini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2445, 116, 'Busoka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2446, 116, 'Kilago', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2447, 116, 'Iyenze', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2448, 116, 'Wendele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2449, 116, 'Nyandekwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2450, 116, 'Kinaga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2451, 116, 'Isagehe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2452, 116, 'Kagongwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2453, 116, 'Nyahanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2454, 116, 'Malunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2455, 116, 'Mhongolo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2456, 116, 'Bulyanhulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2457, 116, 'Ngaya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2458, 116, 'Bulige', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2459, 116, 'Kashishi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2460, 116, 'Mwanase', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2461, 116, 'Mwalugulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2462, 116, 'Jana', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2463, 116, 'Isaka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2464, 116, 'Lunguya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2465, 116, 'Shilela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2466, 116, 'Segese', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2467, 116, 'Mega', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2468, 116, 'Chela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2469, 116, 'Busangi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2470, 116, 'Ntobo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2471, 116, 'Chona', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2472, 116, 'Chambo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2473, 116, 'Kisuke', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2474, 116, 'Mapamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2475, 116, 'Bukomela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2476, 116, 'Ukune', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2477, 116, 'Igunda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2478, 116, 'Kinamapula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2479, 116, 'Igwamanoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2480, 116, 'Mpunze', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2481, 116, 'Sabasabini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2482, 116, 'Idahina', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2483, 116, 'Bulungwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2484, 116, 'Nyankende', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2485, 116, 'Ulewe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2486, 116, 'Ushetu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2487, 116, 'Uyogo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2488, 116, 'Ulowa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2489, 116, 'Ubagwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2490, 117, 'Bunambiyu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2491, 117, 'Shagihilu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2492, 117, 'Somagedi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2493, 117, 'Mwamalasa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2494, 117, 'Masanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2495, 117, 'Lagana', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2496, 117, 'Mwamashele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2497, 117, 'Ngofila', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2498, 117, 'Ukenyenge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2499, 117, 'Talaga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2500, 117, 'Bubiki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2501, 117, 'Itilima', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2502, 117, 'Songwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2503, 117, 'Seke-Bugoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2504, 117, 'Mwadui Luhumbo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2505, 117, 'Uchunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2506, 117, 'Kishapu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2507, 117, 'Mwakipoya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2508, 130, 'Igunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2509, 130, 'Igurubi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2510, 130, 'Kinungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2511, 130, 'Itunduru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2512, 130, 'Mwamashiga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2513, 130, 'Choma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2514, 130, 'Mwashiku', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2515, 130, 'Ziba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2516, 130, 'Ndembezi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2517, 130, 'Itumba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2518, 130, 'Nkinga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2519, 130, 'Ngulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2520, 130, 'Igoweko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2521, 130, 'Mwisi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2522, 130, 'Chabutwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2523, 130, 'Sungwizi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2524, 130, 'Bukoko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2525, 130, 'Isakamaliwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2526, 130, 'Nanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2527, 130, 'Nguvumoja', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2528, 130, 'Mbutu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2529, 130, 'Kiningila', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2530, 131, 'Ukumbisiganga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2531, 131, 'Igwisi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2532, 131, 'Uyowa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2533, 131, 'Silambo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2534, 131, 'Sasu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2535, 131, 'Seleli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2536, 131, 'Ichemba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2537, 131, 'Mwongozo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2538, 131, 'Kanoge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2539, 131, 'Kanindo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2540, 131, 'Zugimlole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2541, 131, 'Milambo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2542, 131, 'Igombe Mkulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2543, 131, 'Ushokola', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2544, 131, 'Ugunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2545, 131, 'Kaliua', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2546, 131, 'Usinge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2547, 131, 'Igagala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2548, 131, 'Kamsekwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2549, 131, 'Kazaroho', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2550, 132, 'Puge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2551, 132, 'Wela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2552, 132, 'Muhugi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2553, 132, 'Utwigu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2554, 132, 'Lusu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2555, 132, 'Nkiniziwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2556, 132, 'Nata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2557, 132, 'Isanzu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2558, 132, 'Itobo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2559, 132, 'Mwangoye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2560, 132, 'Sigili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2561, 132, 'Igusule', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2562, 132, 'Shigamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2563, 132, 'Kasela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2564, 132, 'Karitu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2565, 132, 'Budushi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2566, 132, 'Bukene', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2567, 132, 'Mogwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2568, 132, 'Mambali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2569, 132, 'Kahama Nhalanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2570, 132, 'Uduka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2571, 132, 'Semembela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2572, 132, 'Isagenhe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2573, 132, 'Ikindwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2574, 132, 'Mwakashanhala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2575, 132, 'Tongi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2576, 132, 'Mizibaziba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2577, 132, 'Milambo Itobo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2578, 132, 'Magengati', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2579, 132, 'Ndala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2580, 132, 'Nzega Mjini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2581, 132, 'Miguwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2582, 132, 'Itilo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2583, 132, 'Ijanija', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2584, 132, 'Nzega Ndogo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2585, 133, 'Tutuo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2586, 133, 'Pangale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2587, 133, 'Ipole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2588, 133, 'Ngoywa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2589, 133, 'Misheni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2590, 133, 'Mole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2591, 133, 'Mpombwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2592, 133, 'Usunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2593, 133, 'Kipanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2594, 133, 'Sikonge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2595, 133, 'Igigwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2596, 133, 'Kiloli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2597, 134, 'Kanyenye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2598, 134, 'Cheyo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2599, 134, 'Ng`ambo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2600, 134, 'Kakola', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2601, 134, 'Uyui', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2602, 134, 'Itonjanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2603, 134, 'Ndevelwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2604, 134, 'Itetemia', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2605, 134, 'Tumbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2606, 134, 'Gongoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2607, 134, 'Kalunde', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2608, 134, 'Misha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2609, 134, 'Kabila', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2610, 134, 'Ikomwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2611, 134, 'Ifucha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2612, 134, 'Ntalikwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2613, 134, 'Kiloleni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2614, 134, 'Mtendeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2615, 134, 'Isevya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2616, 134, 'Ipuli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2617, 135, 'Kapilula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2618, 135, 'Ugalla', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2619, 135, 'Usisya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2620, 135, 'Kasisi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2621, 135, 'Imalamakoye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2622, 135, 'Nsenda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2623, 135, 'Ukondamoyo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2624, 135, 'Urambo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2625, 135, 'Vumilia', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2626, 135, 'Ussoke', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2627, 135, 'Uyumbu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2628, 136, 'Lutende', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2629, 136, 'Ibiri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2630, 136, 'Bukumbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2631, 136, 'Ikongolo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2632, 136, 'Upuge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2633, 136, 'Magiri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2634, 136, 'Isikizya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2635, 136, 'Shitage', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2636, 136, 'Loya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2637, 136, 'Miswaki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2638, 136, 'Tura', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2639, 136, 'Kizengi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2640, 136, 'Nsololo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2641, 136, 'Kigwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2642, 136, 'Miyenze', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2643, 136, 'Ibelamilundi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2644, 136, 'Goweko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2645, 136, 'Ilolanguru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2646, 136, 'Mabama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2647, 136, 'Ndono', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2648, 136, 'Ufulumwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2649, 136, 'Usagari', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2651, 24, 'Kalenga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2652, 24, 'Kiwere', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2653, 24, 'Nzihi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2654, 24, 'Ulanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2655, 24, 'Mseke', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2656, 24, 'Maguliwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2657, 24, 'Mgama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2658, 24, 'Ifunda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2659, 24, 'Lumuli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2660, 24, 'Kihesa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2661, 24, 'Mtwivila', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2662, 24, 'Gangilonga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2663, 24, 'Kitanzini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2664, 24, 'Mshindo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2665, 24, 'Mivinjeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2666, 24, 'Mlandege', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2667, 24, 'Mwangata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2668, 24, 'Maboga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2669, 24, 'Wasa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2670, 24, 'Mahuninga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2671, 24, 'Idodi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2672, 24, 'Mlowa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2673, 24, 'Itunundu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2674, 24, 'Ilolo Mpya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2675, 24, 'Nduli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2676, 24, 'Kihorogota', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2677, 24, 'Izazi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2678, 24, 'Malenga Makali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2679, 24, 'Nyangoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2680, 24, 'Luhota', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2681, 24, 'Lyamgungwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2682, 24, 'Mlenge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2683, 24, 'Migoli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2684, 24, 'Kwakilosa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2685, 24, 'Makorongoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2686, 24, 'Mkwawa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2687, 24, 'Kitwiru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2688, 24, 'Isakalilo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2689, 42, 'Mkigo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2690, 42, 'Mwamgongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2691, 42, 'Kalinzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2692, 42, 'Bitale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2693, 42, 'Mkongoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2694, 42, 'Mahembe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2695, 42, 'Matendo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2696, 42, 'Mungonya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2697, 42, 'Gungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2698, 42, 'Buhanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2699, 42, 'Machinjioni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2700, 42, 'Kasimbu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2701, 42, 'Rubuga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2702, 42, 'Kasingirima', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2703, 42, 'Kagongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2704, 42, 'Mwandiga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2705, 42, 'Kitongoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2706, 42, 'Kipampa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2707, 42, 'Rusimbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2708, 42, 'Buzebazeba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2709, 42, 'Mwanga Kusini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2710, 42, 'Kigoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2711, 42, 'Bangwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2712, 42, 'Mwanga Kaskazini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2713, 42, 'Katubuka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2714, 96, 'Njombe Mjini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2715, 96, 'Ramadhani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2716, 96, 'Yakobi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2717, 96, 'Kifanya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2718, 96, 'Ihanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2719, 96, 'Iwungilo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2720, 96, 'Luponde', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2721, 96, 'Matola', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2722, 96, 'Igongolo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2723, 96, 'Kichiwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2724, 96, 'Ninga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2725, 96, 'Ikuna', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2726, 96, 'Kidegembye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2727, 96, 'Matembwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2728, 96, 'Lupembe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2729, 96, 'Ubena', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2730, 96, 'Lyamkena', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2731, 96, 'Mwembetogwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2732, 96, 'Kitandililo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2733, 96, 'Makowo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2734, 96, 'Lugenge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2735, 96, 'Uwemba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2736, 96, 'Utalingolo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2737, 96, 'Mfriga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2738, 96, 'Idamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2739, 118, 'Mwamalili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2740, 118, 'Kolandoto', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2741, 118, 'Ngokolo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2742, 118, 'Ibadakuli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2743, 118, 'Shinyanga Mjini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2744, 118, 'Chamaguha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2745, 118, 'Ibinzamata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2746, 118, 'Kitangili', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2747, 118, 'Kizumbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2748, 118, 'Imesela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2749, 118, 'Usule', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2750, 118, 'Ilola', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2751, 118, 'Didia', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2752, 118, 'Itwangi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2753, 118, 'Tinde', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2754, 118, 'Mwakitolyo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2755, 118, 'Salawe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2756, 118, 'Solwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2757, 118, 'Mwawaza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2758, 118, 'Chibe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2759, 118, 'Lubaga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2760, 118, 'Masekelo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2761, 118, 'Old Shinyanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2762, 118, 'Iselamagazi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2763, 118, 'Lyabukande', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2764, 118, 'Mwantini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2765, 118, 'Pandagichiza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2766, 118, 'Samuye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2767, 118, 'Usanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2768, 118, 'Puni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2769, 118, 'Nyida', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2770, 118, 'Nsalala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2771, 118, 'Masengwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2772, 118, 'Lyabusalu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2773, 118, 'Mwalukwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2774, 118, 'Nyamalogo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2775, 118, 'Lyamidati', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2776, 128, 'Mudida', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2777, 128, 'Makuro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2778, 128, 'Ikhanoda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2779, 128, 'Mwasauya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2780, 128, 'Msange', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2781, 128, 'Maghojoa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2782, 128, 'Itaja', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2783, 128, 'Ngimu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2784, 128, 'Mughunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2785, 128, 'Mtipa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2786, 128, 'Mughanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2787, 128, 'Mitunduruni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2788, 128, 'Unyambwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2789, 128, 'Mungumaji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2790, 128, 'Unyamikumbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2791, 128, 'Mtamaa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2792, 128, 'Kindai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2793, 128, 'Mgori', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2794, 128, 'Mughamo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2795, 128, 'Kinyagigi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2796, 128, 'Merya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2797, 128, 'Kinyeto', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2798, 128, 'Ntonge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2799, 128, 'Ilongero', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2800, 128, 'Mrama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2801, 128, 'Kijota', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2802, 128, 'Mtinko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2803, 128, 'Ughandi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2804, 128, 'Ipembe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2805, 128, 'Utemini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2806, 128, 'Mwankoko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2807, 128, 'Mandewa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2808, 128, 'Minga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2809, 128, 'Misuna', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2810, 128, 'Uhamaka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2811, 144, 'Central', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2812, 144, 'Nguvumali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2813, 144, 'Chumbageni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2814, 144, 'Ngamiani Kaskazini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2815, 144, 'Ngamiani Kati', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2816, 144, 'Ngamiani Kusini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2817, 144, 'Makorora', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2818, 144, 'Mzingani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2819, 144, 'Msambweni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2820, 144, 'Mwanzange', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2821, 144, 'Tangasisi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2822, 144, 'Mabawa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2823, 144, 'Tongoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2824, 144, 'Marungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2825, 144, 'Pongwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2826, 144, 'Maweni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2827, 144, 'Mzizima', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2828, 144, 'Mabokweni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2829, 144, 'Kirare', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2830, 144, 'Kiomoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2831, 144, 'Chongoleani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2832, 4, 'Mbuguni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2833, 4, 'Shambarai Burka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2834, 4, 'Maroroni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2835, 4, 'Makiba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2836, 4, 'Kikwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2837, 4, 'Kingori', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2838, 4, 'Malula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2839, 4, 'Ngarenanyuki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2840, 4, 'Uwiro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2841, 4, 'Ngabobo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2842, 4, 'Kikatiti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2843, 4, 'Leguruki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2844, 4, 'Maruvango', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2845, 4, 'Maji ya chai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2846, 4, 'Imbaseni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2847, 4, 'Nkoaranga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2848, 4, 'Nkoanekoli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2849, 4, 'Nkoarisambu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2850, 4, 'Seela Singisi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2851, 4, 'Akheri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2852, 4, 'Poli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2853, 4, 'Nkoanrua', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2854, 4, 'Ambureni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2855, 4, 'Usariver', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2856, 26, 'Wambi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2857, 26, 'Kinyanambo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2858, 26, 'Upendo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2859, 26, 'Sao Hill', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2860, 26, 'Changarawe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2861, 55, 'Singe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2862, 55, 'Bonga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2863, 55, 'Nangara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2864, 55, 'Babati', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2865, 55, 'Bagara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2866, 55, 'Maisaka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2867, 55, 'Mutuka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2868, 55, 'Sigino', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2869, 62, 'Bweri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2870, 62, 'Rwamlimi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2871, 62, 'Kigera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2872, 62, 'Kwangwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2873, 62, 'Makoko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2874, 62, 'Mwisenge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2875, 62, 'Mshikamano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2876, 62, 'Buhare', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2877, 62, 'Iringo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2878, 62, 'Kamunyonge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2879, 62, 'Kitaji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2880, 62, 'Mkendo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2881, 62, 'Mwigobero', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2882, 62, 'Nyasho', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2883, 66, 'Ntaba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2884, 66, 'Mpata', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2885, 81, 'Chanikanguo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2886, 81, 'Napupa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2887, 81, 'Mumbaka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2888, 81, 'Matawale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2889, 94, 'Makambako', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2890, 94, 'Maguvani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2891, 94, 'Kitisi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2892, 94, 'Kivavi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2893, 103, 'Pangani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2894, 103, 'Mailimoja', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2895, 103, 'Tangini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2896, 103, 'Picha ya ndege', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2897, 103, 'Sofu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2898, 103, 'Mkuza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2899, 103, 'Msangani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2900, 103, 'Kibaha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2901, 103, 'Kongowe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2902, 103, 'Viziwa ziwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2903, 103, 'Misugusugu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2904, 103, 'Visiga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2905, 103, 'Mbwawa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2906, 129, 'Gua', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2907, 129, 'Ngwala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2908, 129, 'Mbangala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2909, 129, 'Saza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2910, 129, 'Mkwajuni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2911, 129, 'Mwambani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2912, 129, 'Totowe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2913, 129, 'Mpona', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2914, 129, 'Namkukwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2915, 129, 'Galula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2916, 129, 'Ifwenkenya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2917, 24, 'Mkimbizi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2918, 24, 'Igumbilo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2919, 96, 'Utalingoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2920, 98, 'Chimba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2921, 98, 'Finya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2922, 98, 'Kifundi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2923, 98, 'Kinowe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2924, 98, 'Kinyasini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2925, 98, 'Konde', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2926, 98, 'Majenzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2927, 98, 'Makangale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2928, 98, 'Maziwa Ngombe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2929, 98, 'Mgogoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2930, 98, 'Micheweni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2931, 98, 'Mjini Wingwi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2932, 98, 'Mlindo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2933, 98, 'Msuka Magharibi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2934, 98, 'Msuka Mashariki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2935, 98, 'Mtemani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2936, 98, 'Shumba Mjini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2937, 98, 'Shumba Viamboni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2938, 98, 'Sizini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2939, 98, 'Tumbe Magharibi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2940, 98, 'Tumbe Mashariki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2941, 98, 'Wingwi Mapofu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2942, 98, 'Wingwi Mjananza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2943, 99, 'Bopwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2944, 99, 'Chwale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2945, 99, 'Fundo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2946, 99, 'Gando', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2947, 99, 'Jadida', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2948, 99, 'Junguni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2949, 99, 'Kambini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2950, 99, 'Kangagani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2951, 99, 'Kinyikani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2952, 99, 'Kipangani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2953, 99, 'Kiungoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2954, 99, 'Kiuyu Kigongoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2955, 99, 'Kiuyu Minungwini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2956, 99, 'Kizimbani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2957, 99, 'Kojani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2958, 99, 'Limbani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2959, 99, 'Maziwani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2960, 99, 'Mchanga Mdogo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2961, 99, 'Mjini Ole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2962, 99, 'Mpambani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2963, 99, 'Mtambwe Kaskazini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2964, 99, 'Mtambwe Kusini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2965, 99, 'Mzambarauni Takao', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2966, 99, 'Ole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2967, 99, 'Pandani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2968, 99, 'Pembeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2969, 99, 'Piki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2970, 99, 'Selem', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2971, 99, 'Shengejuu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2972, 99, 'Ukunjwi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2973, 99, 'Utaani', '2022-04-11 21:37:26', '2022-04-11 21:37:26');
INSERT INTO `wards` (`id`, `district_id`, `name`, `created_at`, `updated_at`) VALUES
(2974, 100, 'Chachani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2975, 100, 'Chanjaani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2976, 100, 'Chonga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2977, 100, 'Dodo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2978, 100, 'Kibokoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2979, 100, 'Kichungwani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2980, 100, 'Madungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2981, 100, 'Mbuzini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2982, 100, 'Mfikiwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2983, 100, 'Mgelema', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2984, 100, 'Michungwani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2985, 100, 'Mkoroshoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2986, 100, 'Msingini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2987, 100, 'Mvumoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2988, 100, 'Ngambwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2989, 100, 'Pujini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2990, 100, 'Shungi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2991, 100, 'Tibirinzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2992, 100, 'Uwandani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2993, 100, 'Vitongoji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2994, 100, 'Wara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2995, 100, 'Wawi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2996, 100, 'Wesha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2997, 100, 'Ziwani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2998, 101, 'Chambani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(2999, 101, 'Changaweni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3000, 101, 'Chokocho', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3001, 101, 'Jombwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3002, 101, 'Kangani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3003, 101, 'Kendwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3004, 101, 'Kengeja', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3005, 101, 'Kisiwa Panza', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3006, 101, 'Kiwani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3007, 101, 'Kuukuu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3008, 101, 'Makombeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3009, 101, 'Makoongwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3010, 101, 'Mbuguani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3011, 101, 'Mgagadu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3012, 101, 'Michenzani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3013, 101, 'Minazini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3014, 101, 'Mizingani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3015, 101, 'Mjimbini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3016, 101, 'Mkanyageni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3017, 101, 'Mkungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3018, 101, 'Mtambile', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3019, 101, 'Mtangani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3020, 101, 'Muambe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3021, 101, 'Ngombeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3022, 101, 'Ngwachani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3023, 101, 'Shamiani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3024, 101, 'Shidi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3025, 101, 'Stahabu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3026, 101, 'Ukutini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3027, 101, 'Uweleni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3028, 101, 'Wambaa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3029, 145, 'Bububu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3030, 145, 'Bumbwisudi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3031, 145, 'Bweleo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3032, 145, 'Chuini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3033, 145, 'Chukwani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3034, 145, 'Dole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3035, 145, 'Fumba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3036, 145, 'Fuoni Kibondeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3037, 145, 'Fuoni Kijitoupele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3038, 145, 'Kama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3039, 145, 'Kianga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3040, 145, 'Kibweni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3041, 145, 'Kiembesamaki', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3042, 145, 'Kihinani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3043, 145, 'Kinuni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3044, 145, 'Kisauni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3045, 145, 'Kombeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3046, 145, 'Magogoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3047, 145, 'Maungani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3048, 145, 'Meli nne', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3049, 145, 'Mfenesini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3050, 145, 'Mombasa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3051, 145, 'Mto Pepo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3052, 145, 'Mtoni Kidatu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3053, 145, 'Mtufaani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3054, 145, 'Mwakaje', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3055, 145, 'Mwanakwerekwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3056, 145, 'Mwanyanya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3057, 145, 'Nyamanzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3058, 145, 'Pangawe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3059, 145, 'Shakani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3060, 145, 'Sharifu Msa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3061, 145, 'Tomondo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3062, 145, 'Welezo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3063, 146, 'Chumbuni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3064, 146, 'Gulioni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3065, 146, 'Jangombe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3066, 146, 'Karakana', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3067, 146, 'Kidongo Chekundu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3068, 146, 'Kikwajuni Bondeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3069, 146, 'Kikwajuni Juu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3070, 146, 'Kilimahewa Bondeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3071, 146, 'Kilimahewa Juu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3072, 146, 'Kiponda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3073, 146, 'Kisimamajongoo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3074, 146, 'Kisiwandui', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3075, 146, 'Kwa Wazee', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3076, 146, 'Kwaalimsha', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3077, 146, 'Kwaalinatu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3078, 146, 'Kwahani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3079, 146, 'Kwamtipura', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3080, 146, 'Makadara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3081, 146, 'Matarumbeta', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3082, 146, 'Meya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3083, 146, 'Migombani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3084, 146, 'Mkele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3085, 146, 'Mkunazini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3086, 146, 'Mpendae', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3087, 146, 'Muembetanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3088, 146, 'Mwembeladu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3089, 146, 'Mwembemakumbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3090, 146, 'Mwembeshauri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3091, 146, 'Nyerere', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3092, 146, 'Sebleni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3093, 146, 'Shangani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3094, 146, 'Shaurimoyo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3095, 146, 'Sogea', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3096, 146, 'Urusi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3097, 146, 'Vikokotoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3098, 147, 'Bandamaji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3099, 147, 'Bwereu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3100, 147, 'Chaani Kubwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3101, 147, 'Chaani Masingini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3102, 147, 'Chutama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3103, 147, 'Fukuchani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3104, 147, 'Gamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3105, 147, 'Kandwi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3106, 147, 'Kibeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3107, 147, 'Kidombo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3108, 147, 'Kidoti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3109, 147, 'Kigomani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3110, 147, 'Kigunda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3111, 147, 'Kijini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3112, 147, 'Kikobweni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3113, 147, 'Kisongoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3114, 147, 'Kivunge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3115, 147, 'Matemwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3116, 147, 'Mchenza Shauri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3117, 147, 'Mkokotoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3118, 147, 'Moga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3119, 147, 'Mto wa Pwani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3120, 147, 'Muwange', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3121, 147, 'Nungwi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3122, 147, 'Pale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3123, 147, 'Pitanazako', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3124, 147, 'Potoa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3125, 147, 'Pwani Mchangani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3126, 147, 'Tazari', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3127, 147, 'Tumbatu Gomani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3128, 147, 'Tumbatu Jongowe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3129, 147, 'Uvivini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3130, 148, 'Donge Karange', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3131, 148, 'Donge Kipange', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3132, 148, 'Donge Mbiji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3133, 148, 'Donge Mchangani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3134, 148, 'Donge Mtambile', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3135, 148, 'Donge Vijibweni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3136, 148, 'Fujoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3137, 148, 'Kidanzini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3138, 148, 'Kilombero', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3139, 148, 'Kinduni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3140, 148, 'Kiombamvua', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3141, 148, 'Kitope', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3142, 148, 'Kiwengwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3143, 148, 'Mafufuni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3144, 148, 'Mahonda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3145, 148, 'Makoba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3146, 148, 'Matetema', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3147, 148, 'Mbaleni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3148, 148, 'Mkadini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3149, 148, 'Mkataleni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3150, 148, 'Mnyimbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3151, 148, 'Muwanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3152, 148, 'Njia ya Mtoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3153, 148, 'Pangeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3154, 148, 'Upenja', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3155, 148, 'Zingwezingwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3156, 149, 'Bambi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3157, 149, 'Binguni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3158, 149, 'Bungi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3159, 149, 'Charawe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3160, 149, 'Cheju', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3161, 149, 'Chwaka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3162, 149, 'Dunga Bweni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3163, 149, 'Dunga Kiembeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3164, 149, 'Ghana', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3165, 149, 'Jendele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3166, 149, 'Jumbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3167, 149, 'Kaebona', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3168, 149, 'Kaepwani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3169, 149, 'Kiboje Mkwajuni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3170, 149, 'Kiboje Mwembeshauri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3171, 149, 'Kidimni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3172, 149, 'Kikungwi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3173, 149, 'Koani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3174, 149, 'Machui', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3175, 149, 'Marumbi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3176, 149, 'Mgeni Haji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3177, 149, 'Michamvi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3178, 149, 'Mitakawani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3179, 149, 'Miwani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3180, 149, 'Ndijani Mseweni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3181, 149, 'Pagali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3182, 149, 'Tindini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3183, 149, 'Tunduni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3184, 149, 'Tunguu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3185, 149, 'Ubago', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3186, 149, 'Ukongoroni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3187, 149, 'Umbuji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3188, 149, 'Uroa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3189, 149, 'Uzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3190, 149, 'Uzini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3191, 150, 'Bwejuu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3192, 150, 'Dongwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3193, 150, 'Jambiani Kibigija', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3194, 150, 'Jambiani Kikadini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3195, 150, 'Kajengwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3196, 150, 'Kibuteni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3197, 150, 'Kiongoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3198, 150, 'Kitogani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3199, 150, 'Kizimkazi Dimbani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3200, 150, 'Kizimkazi Mkunguni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3201, 150, 'Mtende', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3202, 150, 'Muungoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3203, 150, 'Muyuni B', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3204, 150, 'Muyuni C', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3205, 150, 'Muyuni A', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3206, 150, 'Mzuri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3207, 150, 'Nganani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3208, 150, 'Paje', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3209, 150, 'Pete', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3210, 150, 'Tasani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3211, 11, 'Mabibo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3212, 11, 'Msigani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3213, 11, 'Mburahati', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3214, 11, 'Makuburi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3215, 11, 'Makurumla', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3216, 11, 'Kwembe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3217, 11, 'Manzese', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3218, 11, 'Ubungo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3219, 11, 'Kibamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3220, 11, 'Goba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3221, 11, 'Kimara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3222, 11, 'Mbezi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3223, 11, 'Saranga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3224, 1, 'Kimandolu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3225, 1, 'Baraa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3226, 1, 'Moshono', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3227, 1, 'Moivaro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3228, 1, 'Lemara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3229, 1, 'Sokon I', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3230, 1, 'Sinoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3231, 1, 'Muriet', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3232, 1, 'Sombetini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3233, 1, 'Osunyai Jr', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3234, 1, 'Elerai', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3235, 1, 'Sakina', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3236, 1, 'Olasiti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3237, 1, 'Olmoti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3238, 1, 'Kati', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3239, 1, 'Daraja Ii', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3240, 1, 'Themi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3241, 1, 'Ngarenaro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3242, 1, 'Levolosi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3243, 1, 'Unga Ltd', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3244, 1, 'Sekei', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3245, 21, 'Kalangalala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3246, 21, 'Buhalahala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3247, 21, 'Nyankumbu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3248, 21, 'Mtakuja', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3249, 21, 'Mgusu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3250, 21, 'Kasamwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3251, 21, 'Kanyala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3252, 21, 'Bungwangoko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3253, 21, 'Bulela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3254, 21, 'Shiloleli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3255, 21, 'Nyanguku', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3256, 21, 'Ihanamilo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3257, 40, 'Kumnyika', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3258, 40, 'Murubona', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3259, 40, 'Murusi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3260, 40, 'Mwilavya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3261, 40, 'Heru Juu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3262, 40, 'Kimobwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3263, 70, 'Forest', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3264, 70, 'Iduda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3265, 70, 'Iganjo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3266, 70, 'Igawilo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3267, 70, 'Ilomba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3268, 70, 'Itezi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3269, 70, 'Iwambi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3270, 70, 'Iyela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3271, 70, 'Iyunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3272, 70, 'Kalobe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3273, 70, 'Maanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3274, 70, 'Mabatini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3275, 70, 'Mbalizi Road', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3276, 70, 'Mwakibete', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3277, 70, 'Mwansanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3278, 70, 'Nsalaga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3279, 70, 'Nzovwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3280, 70, 'Sinde', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3281, 70, 'Tembela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3282, 70, 'Uyole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3283, 70, 'Iganzo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3284, 70, 'Ilemi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3285, 70, 'Isyesye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3286, 70, 'Itagano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3287, 70, 'Itende', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3288, 70, 'Itiji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3289, 70, 'Iziwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3290, 70, 'Maendeleo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3291, 70, 'Mwansenkwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3292, 70, 'Nonde', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3293, 70, 'Nsoho', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3294, 70, 'Sisimba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3295, 77, 'Mwembesongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3296, 77, 'Mafisa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3297, 77, 'Kingolwira', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3298, 77, 'Mzinga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3299, 77, 'Luhungo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3300, 77, 'Kauzeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3301, 77, 'Magadu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3302, 77, 'Lukobe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3303, 77, 'Kihonda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3304, 77, 'Kihonda Maghorofani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3305, 77, 'Mazimbu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3306, 77, 'Uwanja wa Taifa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3307, 77, 'Saba Saba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3308, 77, 'Sultan Area', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3309, 77, 'Mafiga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3310, 77, 'Bigwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3311, 77, 'Kingo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3312, 77, 'Mji Mkuu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3313, 82, 'Naliandele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3314, 82, 'Ufukoni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3315, 82, 'Likombe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3316, 82, 'Vigaeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3317, 82, 'Reli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3318, 82, 'Chuno', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3319, 82, 'Mitengo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3320, 82, 'Kisungule', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3321, 82, 'Magengeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3322, 151, 'Bonde la Usongwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3323, 151, 'Igale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3324, 151, 'Ihango', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3325, 151, 'Ijombe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3326, 151, 'Ikukwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3327, 151, 'Ilembo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3328, 151, 'Ilungu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3329, 151, 'Inyala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3330, 151, 'Isuto', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3331, 151, 'Itawa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3332, 151, 'Iwiji', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3333, 151, 'Iwindi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3334, 151, 'Iyunga Mapinduzi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3335, 151, 'Lwanjiro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3336, 151, 'Mshewe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3337, 151, 'Santilya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3338, 151, 'Ulenje', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3339, 151, 'Utengule Usongwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3340, 152, 'Chawi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3341, 152, 'Dihimba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3342, 152, 'Kiromba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3343, 152, 'Kitaya', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3344, 152, 'Kitere', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3345, 152, 'Kiyanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3346, 152, 'Libobe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3347, 152, 'Madimba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3348, 152, 'Mahurunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3349, 152, 'Mayanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3350, 152, 'Mbawala', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3351, 152, 'Mbembaleo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3352, 152, 'Milangominne', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3353, 152, 'Mnima', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3354, 152, 'Mpapura', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3355, 152, 'Msanga Mkuu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3356, 152, 'Mtimbwilimbwi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3357, 152, 'Mtiniko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3358, 152, 'Namtumbuka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3359, 152, 'Nanyamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3360, 152, 'Naumbu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3361, 152, 'Ndumbwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3362, 152, 'Nitekela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3363, 152, 'Njengwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3364, 152, 'Tangazo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3365, 152, 'Ziwani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3366, 152, 'Nanguruwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3367, 152, 'Muungano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3368, 152, 'Chawi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3369, 153, 'Itumba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3370, 153, 'Ikinga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3371, 153, 'Kafule', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3372, 153, 'Malangali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3373, 153, 'Bupigu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3374, 153, 'Isongole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3375, 153, 'Chitete', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3376, 153, 'Mbebe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3377, 153, 'Mlale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3378, 153, 'Kalembo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3379, 153, 'Itale', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3380, 153, 'Ibaba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3381, 153, 'Ndola', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3382, 153, 'Luswisi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3383, 153, 'Ngulilo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3384, 153, 'Lubanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3385, 153, 'Ngulugulu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3386, 153, 'Sange', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3387, 154, 'Tunduma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3388, 154, 'Mpemba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3389, 154, 'Chiwezi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3390, 154, 'Katete', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3391, 154, 'makambini', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3392, 154, 'Chapwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3393, 154, 'Chipaka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3394, 154, 'Majengo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3395, 154, 'Kaloleni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3396, 154, 'Maporomoko', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3397, 154, 'Mpande', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3398, 154, 'Muungano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3399, 154, 'Mwaka Kati', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3400, 154, 'Uwanjani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3401, 154, 'Sogea', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3402, 154, 'Chilulumo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3403, 154, 'Ndalambo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3404, 154, 'Kapele', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3405, 154, 'Nzoka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3406, 154, 'Miyunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3407, 154, 'Ikana', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3408, 154, 'Kamsamba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3409, 154, 'Ivuna', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3410, 154, 'Mpapa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3411, 154, 'Mkulwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3412, 154, 'Chitete', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3413, 154, 'Msangano', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3414, 154, 'Mkomba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3415, 154, 'Nkangamo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3416, 71, 'Ihanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3417, 71, 'Mlangali', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3418, 155, 'Overseas', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3419, 62, 'Bukumi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3420, 62, 'Suguti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3421, 62, 'Tegeruka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3422, 62, 'Kiriba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3423, 62, 'Busambara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3424, 62, 'Mugango', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3425, 62, 'Makojo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3426, 62, 'Bwasi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3427, 62, 'Bulinga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3428, 62, 'Bukima', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3429, 62, 'Murangi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3430, 62, 'Bugwema', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3431, 62, 'Nyamrandirira', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3432, 62, 'Nyambono', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3433, 62, 'Mukendo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3434, 55, 'Magara', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3435, 55, 'Riroda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3436, 55, 'Arri', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3437, 55, 'Dareda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3438, 55, 'Dabil', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3439, 55, 'Ufana', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3440, 55, 'Bashnet', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3441, 55, 'Madunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3442, 55, 'Kiru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3443, 55, 'Magugu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3444, 55, 'Baoy', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3445, 55, 'Nkaiti', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3446, 55, 'Nar', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3447, 55, 'Endakiso', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3448, 55, 'Mwada', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3449, 55, 'Mamire', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3450, 55, 'Gallapo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3451, 55, 'Qash', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3452, 55, 'Ayasanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3453, 55, 'Gidas', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3454, 55, 'Duru', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3455, 86, 'Ilemela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3456, 134, 'Mpela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3457, 134, 'Mwinyi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3458, 21, 'Nyarugusu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3459, 21, 'Bukoli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3460, 21, 'Kagu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3461, 21, 'Bugalama', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3462, 21, 'Lubanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3463, 21, 'Isulwabutundwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3464, 21, 'Kamena', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3465, 21, 'Nyamalimbe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3466, 21, 'Bugulula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3467, 21, 'Bujula', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3468, 21, 'Butobela', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3469, 21, 'Nyakamwaga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3470, 21, 'Lwamgasa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3471, 21, 'Kaseme', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3472, 21, 'Busanda', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3473, 21, 'Katoro', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3474, 21, 'Nyamigota', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3475, 21, 'Senga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3476, 21, 'Nyakagomba', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3477, 21, 'Nyachiluluma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3478, 21, 'Bukondo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3479, 21, 'Chigunga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3480, 21, 'Nyamwilolelwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3481, 21, 'Butundwe', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3482, 21, 'Magenge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3483, 21, 'Ludete', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3484, 21, 'Nyaruyeye', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3485, 21, 'Nyalwanzaja', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3486, 21, 'Kakubilo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3487, 21, 'Izumacheli', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3488, 21, 'Nyamboge', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3489, 21, 'Nyawilimilwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3490, 21, 'Nkome', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3491, 21, 'Katoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3492, 21, 'Nzera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3493, 21, 'Lwezera', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3494, 21, 'Kamhanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3495, 134, 'Kitete', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3496, 76, 'Magomeni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3497, 64, 'Ikoma', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3498, 65, 'Matongo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3499, 111, 'Kilimani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3500, 77, 'Kasanga', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3501, 77, 'Mkambarani', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3502, 77, 'Mikese', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3503, 77, 'Kidugalo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3504, 77, 'Mkulazi', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3505, 77, 'Ngerengere', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3506, 77, 'Tununguo', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3507, 77, 'Kinole', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3508, 77, 'Kiroka', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3509, 77, 'Mkuyuni', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3510, 77, 'Tegetero', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3511, 77, 'Kolero', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3512, 77, 'Kibogwa', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3513, 77, 'Kibungo Juu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3514, 77, 'Kisemu', '2022-04-11 21:37:26', '2022-04-11 21:37:26'),
(3515, 77, 'Lundi', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3516, 77, 'Mtombozi', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3517, 77, 'Tawa', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3518, 77, 'Matuli', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3519, 77, 'Gwata', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3520, 77, 'Konde', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3521, 77, 'Bungu', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3522, 77, 'Mvuha', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3523, 77, 'Selembala', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3524, 77, 'Bwakila Chini', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3525, 77, 'Bwakila Juu', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3526, 77, 'Kisaki', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3527, 77, 'Mngazi', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3528, 77, 'Singisa', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3529, 77, 'Sabasaba', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3530, 77, 'Boma', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3531, 1, 'Oldonyosambu', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3532, 1, 'Oltrumet', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3533, 1, 'Mwandeti', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3534, 1, 'Mussa', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3535, 1, 'Kisongo', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3536, 1, 'Mateves', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3537, 1, 'Oljoro', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3538, 1, 'Bwawani', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3539, 1, 'Nduruma', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3540, 1, 'Mlangarini', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3541, 1, 'Sambasha', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3542, 1, 'Olkokola', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3543, 1, 'Olorieni', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3544, 1, 'Olmotonyi', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3545, 1, 'Ilkidinga', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3546, 1, 'Bangata', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3547, 1, 'Sokon II', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3548, 1, 'Oltoroto', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3549, 1, 'Moivo', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3550, 1, 'Kiranyi', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3551, 1, 'Kimnyaki', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3552, 90, 'Nyegezi', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3553, 30, 'Chanika', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3554, 45, 'Makuyuni', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3555, 42, 'Majengo', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3556, 114, 'Mkongo', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3557, 144, 'Duga', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3558, 96, 'Mtwango', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3559, 133, 'Kiloleli', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3560, 58, 'Gehandu', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3561, 77, 'Mlimani', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3562, 103, 'Gwata', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3563, 103, 'Janga', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3564, 103, 'Bokomnemela', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3565, 103, 'Dutumi', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3566, 103, 'Magindu', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3567, 103, 'Soga', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3568, 103, 'Kikongo', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3569, 103, 'Ruvu', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3570, 103, 'Mlandizi', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3571, 103, 'Kwala', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3572, 103, 'Kilangalanga', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3573, 103, 'Maili Moja', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3574, 86, 'Buzuruga', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3575, 123, 'Nkoma', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3576, 90, 'Butimba', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3577, 86, 'Nyakato', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3578, 80, 'Ndanda', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3579, 30, 'Kituntu', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3580, 77, 'Kilakala', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3581, 90, 'Luchelele', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3582, 151, 'Swaya', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3583, 58, 'Uhuru', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3584, 58, 'Masqaroda', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3585, 136, 'Igalula', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3586, 82, 'Rahaleo', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3587, 123, 'Kisesa', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3588, 77, 'Kichangani', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3589, 50, 'Masoko', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3590, 86, 'Nyasaka', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3591, 82, 'Shangani', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3592, 45, 'Miembeni', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3593, 45, 'Njia Panda', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3594, 77, 'Mbuyuni', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3595, 76, 'Malolo', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3596, 141, 'Majengo', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3597, 141, 'Mbaramo', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3598, 77, 'Tungi', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3599, 46, 'Mwanga', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3600, 4, 'Songoro', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3601, 129, 'Udinde', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3602, 70, 'Ruanda', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3603, 45, 'Majengo', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3604, 146, 'Malindi', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3605, 70, 'Ghana', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3606, 82, 'Jangwani', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3607, 77, 'Kiwanja cha Ndege', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3608, 64, 'Matare', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3609, 82, 'Magomeni', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3610, 82, 'Chikongola', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3611, 77, 'Chamwino', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3612, 44, 'Mnadani', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3614, 90, 'Mabatini', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3615, 7, 'Kipunguni B', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3616, 132, 'Mbogwe', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3617, 35, 'Mamba', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3618, 50, 'Kikole', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3619, 72, 'Ndato', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3620, 130, 'Simbo', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3621, 134, 'Mbugani', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3622, 78, 'Mlali', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3623, 146, 'Magomeni', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3624, 85, 'Mkundi', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3625, 134, 'Malolo', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3626, 67, 'Mbugani', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3627, 111, 'Ruanda', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3628, 77, 'Mji Mpya', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3629, 82, 'Mtawanya', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3630, 144, 'Majengo', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3631, 134, 'Chemchem', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3632, 25, 'Mahenge', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3633, 129, 'Kanga', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3634, 82, 'Majengo', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3635, 66, 'Itete', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3636, 100, 'Ndagoni', '2022-04-11 21:37:27', '2022-04-11 21:37:27'),
(3637, 77, 'Mkundi', '2022-04-11 21:37:27', '2022-04-11 21:37:27');

-- --------------------------------------------------------

--
-- Table structure for table `work_orders`
--

CREATE TABLE `work_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `destination_location` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `labour_cost` int(11) DEFAULT NULL,
  `overhead_cost` int(11) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(100) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_orders`
--

INSERT INTO `work_orders` (`id`, `reference_no`, `type`, `item_id`, `destination_location`, `quantity`, `date`, `labour_cost`, `overhead_cost`, `added_by`, `description`, `status`, `created_at`, `updated_at`) VALUES
(3, '', 3, 1, 2, 100000000, 2022, 2000, 4000, 1, 'fggggggggggggg', 0, '2022-05-17 18:54:39', '2022-05-17 18:54:39');

-- --------------------------------------------------------

--
-- Table structure for table `work_order_issue`
--

CREATE TABLE `work_order_issue` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `work_oder_id` int(100) NOT NULL,
  `issue_date` date NOT NULL,
  `location` int(11) NOT NULL,
  `work_centre` int(11) DEFAULT NULL,
  `reference` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(110) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_order_issue`
--

INSERT INTO `work_order_issue` (`id`, `work_oder_id`, `issue_date`, `location`, `work_centre`, `reference`, `type`, `added_by`, `notes`, `created_at`, `updated_at`) VALUES
(3, 0, '2022-05-05', 2, 1, NULL, NULL, 1, '2022-05-20', '2022-05-17 21:16:02', '2022-05-17 21:16:02');

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

CREATE TABLE `zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_reconciliations`
--
ALTER TABLE `bank_reconciliations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `basic_details`
--
ALTER TABLE `basic_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_of_materials`
--
ALTER TABLE `bill_of_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_of_material_inventory`
--
ALTER TABLE `bill_of_material_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cargo_collection`
--
ALTER TABLE `cargo_collection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cargo_loading`
--
ALTER TABLE `cargo_loading`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  ADD PRIMARY KEY (`chart_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collection_centers`
--
ALTER TABLE `collection_centers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cotton_clients`
--
ALTER TABLE `cotton_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cotton_history`
--
ALTER TABLE `cotton_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cotton_invoice`
--
ALTER TABLE `cotton_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cotton_invoice_history`
--
ALTER TABLE `cotton_invoice_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cotton_invoice_item`
--
ALTER TABLE `cotton_invoice_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cotton_list`
--
ALTER TABLE `cotton_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cotton_movement`
--
ALTER TABLE `cotton_movement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cotton_movement_items`
--
ALTER TABLE `cotton_movement_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cotton_movement_levy`
--
ALTER TABLE `cotton_movement_levy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cotton_payments`
--
ALTER TABLE `cotton_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courier`
--
ALTER TABLE `courier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courier_activities`
--
ALTER TABLE `courier_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courier_clients`
--
ALTER TABLE `courier_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courier_collection`
--
ALTER TABLE `courier_collection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courier_items`
--
ALTER TABLE `courier_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courier_lists`
--
ALTER TABLE `courier_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courier_loading`
--
ALTER TABLE `courier_loading`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courier_payments`
--
ALTER TABLE `courier_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `districts_region_id_foreign` (`region_id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `farmers`
--
ALTER TABLE `farmers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `farm_lands`
--
ALTER TABLE `farm_lands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `farm_program`
--
ALTER TABLE `farm_program`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feed_type`
--
ALTER TABLE `feed_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `field_staff`
--
ALTER TABLE `field_staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fuels`
--
ALTER TABLE `fuels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl_account_class`
--
ALTER TABLE `gl_account_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl_account_codes`
--
ALTER TABLE `gl_account_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl_account_group`
--
ALTER TABLE `gl_account_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl_account_type`
--
ALTER TABLE `gl_account_type`
  ADD PRIMARY KEY (`account_type_id`);

--
-- Indexes for table `gmembers`
--
ALTER TABLE `gmembers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `good_disposals`
--
ALTER TABLE `good_disposals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `good_issues`
--
ALTER TABLE `good_issues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `good_issue_items`
--
ALTER TABLE `good_issue_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `good_movements`
--
ALTER TABLE `good_movements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `good_reallocations`
--
ALTER TABLE `good_reallocations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `good_returns`
--
ALTER TABLE `good_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `good_return_items`
--
ALTER TABLE `good_return_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_histories`
--
ALTER TABLE `inventory_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_list`
--
ALTER TABLE `inventory_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_payments`
--
ALTER TABLE `inventory_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal_entries`
--
ALTER TABLE `journal_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journal_entries_id_index` (`id`),
  ADD KEY `journal_entries_month_index` (`month`),
  ADD KEY `journal_entries_year_index` (`year`);

--
-- Indexes for table `levy`
--
ALTER TABLE `levy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `licences`
--
ALTER TABLE `licences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lime_base`
--
ALTER TABLE `lime_base`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintainances`
--
ALTER TABLE `maintainances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintainance_report`
--
ALTER TABLE `maintainance_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturing_inventories`
--
ALTER TABLE `manufacturing_inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturing_inventory_histories`
--
ALTER TABLE `manufacturing_inventory_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturing_inventory_list`
--
ALTER TABLE `manufacturing_inventory_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturing_inventory_payments`
--
ALTER TABLE `manufacturing_inventory_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturing_locations`
--
ALTER TABLE `manufacturing_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturing_purchase_inventories`
--
ALTER TABLE `manufacturing_purchase_inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturing_purchase_item_inventories`
--
ALTER TABLE `manufacturing_purchase_item_inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_category`
--
ALTER TABLE `medicine_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_client`
--
ALTER TABLE `medicine_client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_history`
--
ALTER TABLE `medicine_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_invoice`
--
ALTER TABLE `medicine_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_invoice_item`
--
ALTER TABLE `medicine_invoice_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_list`
--
ALTER TABLE `medicine_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_location`
--
ALTER TABLE `medicine_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_sales_payments`
--
ALTER TABLE `medicine_sales_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_stock`
--
ALTER TABLE `medicine_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_supplier`
--
ALTER TABLE `medicine_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mileages`
--
ALTER TABLE `mileages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `millage_payments`
--
ALTER TABLE `millage_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operators`
--
ALTER TABLE `operators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_movements`
--
ALTER TABLE `order_movements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_payments`
--
ALTER TABLE `order_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pacels`
--
ALTER TABLE `pacels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pacel_items`
--
ALTER TABLE `pacel_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pacel_lists`
--
ALTER TABLE `pacel_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pacel_payments`
--
ALTER TABLE `pacel_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_methodes`
--
ALTER TABLE `payment_methodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `performances`
--
ALTER TABLE `performances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_sys_module_id_foreign` (`sys_module_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_cotton`
--
ALTER TABLE `purchase_cotton`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference` (`reference`);

--
-- Indexes for table `purchase_inventories`
--
ALTER TABLE `purchase_inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_item_cotton`
--
ALTER TABLE `purchase_item_cotton`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_item_inventories`
--
ALTER TABLE `purchase_item_inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_item_medicine`
--
ALTER TABLE `purchase_item_medicine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_item_tyres`
--
ALTER TABLE `purchase_item_tyres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_medicine`
--
ALTER TABLE `purchase_medicine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_medicine_payments`
--
ALTER TABLE `purchase_medicine_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_tyres`
--
ALTER TABLE `purchase_tyres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotation_costs`
--
ALTER TABLE `quotation_costs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refills`
--
ALTER TABLE `refills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `regions_zone_id_foreign` (`zone_id`);

--
-- Indexes for table `reversed_top_up_center`
--
ALTER TABLE `reversed_top_up_center`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reversed_top_up_operator`
--
ALTER TABLE `reversed_top_up_operator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `roles_permissions_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `roles_sys_modules`
--
ALTER TABLE `roles_sys_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_sys_modules_role_id_foreign` (`role_id`),
  ADD KEY `roles_sys_modules_sys_module_id_foreign` (`sys_module_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_items`
--
ALTER TABLE `sales_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seed_invoice`
--
ALTER TABLE `seed_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seed_invoice_history`
--
ALTER TABLE `seed_invoice_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seed_invoice_item`
--
ALTER TABLE `seed_invoice_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seed_lists`
--
ALTER TABLE `seed_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seed_payments`
--
ALTER TABLE `seed_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_items`
--
ALTER TABLE `service_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_report`
--
ALTER TABLE `service_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stickers`
--
ALTER TABLE `stickers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_control`
--
ALTER TABLE `system_control`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_modules`
--
ALTER TABLE `sys_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_account_details`
--
ALTER TABLE `tbl_account_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_id` (`account_id`) USING BTREE;

--
-- Indexes for table `tbl_advance_salary`
--
ALTER TABLE `tbl_advance_salary`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tbl_corops_monitoring`
--
ALTER TABLE `tbl_corops_monitoring`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_costants`
--
ALTER TABLE `tbl_costants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cost_centres`
--
ALTER TABLE `tbl_cost_centres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cost_functions`
--
ALTER TABLE `tbl_cost_functions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cotton`
--
ALTER TABLE `tbl_cotton`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_crops_monitoring`
--
ALTER TABLE `tbl_crops_monitoring`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_crops_types`
--
ALTER TABLE `tbl_crops_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_currencies`
--
ALTER TABLE `tbl_currencies`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `tbl_deposit`
--
ALTER TABLE `tbl_deposit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_employee_award`
--
ALTER TABLE `tbl_employee_award`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tbl_employee_loan`
--
ALTER TABLE `tbl_employee_loan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_employee_loan_returns`
--
ALTER TABLE `tbl_employee_loan_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_employee_payroll`
--
ALTER TABLE `tbl_employee_payroll`
  ADD PRIMARY KEY (`payroll_id`);

--
-- Indexes for table `tbl_expenses`
--
ALTER TABLE `tbl_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_farmer_accounts`
--
ALTER TABLE `tbl_farmer_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_farming_costing`
--
ALTER TABLE `tbl_farming_costing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_farming_cost_items`
--
ALTER TABLE `tbl_farming_cost_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_farming_processes`
--
ALTER TABLE `tbl_farming_processes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_fertilizers`
--
ALTER TABLE `tbl_fertilizers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_insurances`
--
ALTER TABLE `tbl_insurances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_invoice_payments`
--
ALTER TABLE `tbl_invoice_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_irrigation_processes`
--
ALTER TABLE `tbl_irrigation_processes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_irrigation_settings`
--
ALTER TABLE `tbl_irrigation_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_irrigation_settings2`
--
ALTER TABLE `tbl_irrigation_settings2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_irrigation_settings_items`
--
ALTER TABLE `tbl_irrigation_settings_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_irrigation_systems`
--
ALTER TABLE `tbl_irrigation_systems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_land_properties`
--
ALTER TABLE `tbl_land_properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_leave_application`
--
ALTER TABLE `tbl_leave_application`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tbl_leave_category`
--
ALTER TABLE `tbl_leave_category`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tbl_monitoring_type`
--
ALTER TABLE `tbl_monitoring_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_overtime`
--
ALTER TABLE `tbl_overtime`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tbl_parking_types`
--
ALTER TABLE `tbl_parking_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_payroll_activities`
--
ALTER TABLE `tbl_payroll_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pestisides`
--
ALTER TABLE `tbl_pestisides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pestisides_type`
--
ALTER TABLE `tbl_pestisides_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_post_harvests`
--
ALTER TABLE `tbl_post_harvests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_preparation_costs`
--
ALTER TABLE `tbl_preparation_costs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_preparation_cost_lists`
--
ALTER TABLE `tbl_preparation_cost_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_preparation_details`
--
ALTER TABLE `tbl_preparation_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pre_harvests`
--
ALTER TABLE `tbl_pre_harvests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_production`
--
ALTER TABLE `tbl_production`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_productionactivity`
--
ALTER TABLE `tbl_productionactivity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_productionlist`
--
ALTER TABLE `tbl_productionlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product_tools`
--
ALTER TABLE `tbl_product_tools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_purchases`
--
ALTER TABLE `tbl_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_purchase_items`
--
ALTER TABLE `tbl_purchase_items`
  ADD PRIMARY KEY (`purchase_items_id`);

--
-- Indexes for table `tbl_quotation_costs`
--
ALTER TABLE `tbl_quotation_costs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_salary_allowance`
--
ALTER TABLE `tbl_salary_allowance`
  ADD PRIMARY KEY (`salary_allowance_id`);

--
-- Indexes for table `tbl_salary_deduction`
--
ALTER TABLE `tbl_salary_deduction`
  ADD PRIMARY KEY (`salary_deduction_id`);

--
-- Indexes for table `tbl_salary_payments`
--
ALTER TABLE `tbl_salary_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_salary_payment_allowance`
--
ALTER TABLE `tbl_salary_payment_allowance`
  ADD PRIMARY KEY (`salary_payment_allowance_id`);

--
-- Indexes for table `tbl_salary_payment_deduction`
--
ALTER TABLE `tbl_salary_payment_deduction`
  ADD PRIMARY KEY (`salary_payment_deduction_id`);

--
-- Indexes for table `tbl_salary_payment_details`
--
ALTER TABLE `tbl_salary_payment_details`
  ADD PRIMARY KEY (`salary_payment_details_id`);

--
-- Indexes for table `tbl_salary_payslip`
--
ALTER TABLE `tbl_salary_payslip`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_salary_template`
--
ALTER TABLE `tbl_salary_template`
  ADD PRIMARY KEY (`salary_template_id`);

--
-- Indexes for table `tbl_sales`
--
ALTER TABLE `tbl_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sales_items`
--
ALTER TABLE `tbl_sales_items`
  ADD PRIMARY KEY (`sales_items_id`);

--
-- Indexes for table `tbl_seassons`
--
ALTER TABLE `tbl_seassons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_seed_types`
--
ALTER TABLE `tbl_seed_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sowings`
--
ALTER TABLE `tbl_sowings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_training`
--
ALTER TABLE `tbl_training`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_transfer`
--
ALTER TABLE `tbl_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_transport_quotations`
--
ALTER TABLE `tbl_transport_quotations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_details`
--
ALTER TABLE `tbl_user_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_warehouses`
--
ALTER TABLE `tbl_warehouses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_weedings`
--
ALTER TABLE `tbl_weedings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `top_up_center`
--
ALTER TABLE `top_up_center`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `top_up_operator`
--
ALTER TABLE `top_up_operator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trucks`
--
ALTER TABLE `trucks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `truck_insurances`
--
ALTER TABLE `truck_insurances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tyres`
--
ALTER TABLE `tyres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tyre_activities`
--
ALTER TABLE `tyre_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tyre_brands`
--
ALTER TABLE `tyre_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tyre_disposals`
--
ALTER TABLE `tyre_disposals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tyre_histories`
--
ALTER TABLE `tyre_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tyre_payments`
--
ALTER TABLE `tyre_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tyre_reallocations`
--
ALTER TABLE `tyre_reallocations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tyre_returns`
--
ALTER TABLE `tyre_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `users_roles_role_id_foreign` (`role_id`);

--
-- Indexes for table `wards`
--
ALTER TABLE `wards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_orders`
--
ALTER TABLE `work_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_order_issue`
--
ALTER TABLE `work_order_issue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `balances`
--
ALTER TABLE `balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `bank_details`
--
ALTER TABLE `bank_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bank_reconciliations`
--
ALTER TABLE `bank_reconciliations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `basic_details`
--
ALTER TABLE `basic_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bill_of_materials`
--
ALTER TABLE `bill_of_materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bill_of_material_inventory`
--
ALTER TABLE `bill_of_material_inventory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cargo_collection`
--
ALTER TABLE `cargo_collection`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cargo_loading`
--
ALTER TABLE `cargo_loading`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  MODIFY `chart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `collection_centers`
--
ALTER TABLE `collection_centers`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cotton_clients`
--
ALTER TABLE `cotton_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cotton_history`
--
ALTER TABLE `cotton_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `cotton_invoice`
--
ALTER TABLE `cotton_invoice`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cotton_invoice_history`
--
ALTER TABLE `cotton_invoice_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cotton_invoice_item`
--
ALTER TABLE `cotton_invoice_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cotton_list`
--
ALTER TABLE `cotton_list`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `cotton_movement`
--
ALTER TABLE `cotton_movement`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `cotton_movement_items`
--
ALTER TABLE `cotton_movement_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `cotton_movement_levy`
--
ALTER TABLE `cotton_movement_levy`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `cotton_payments`
--
ALTER TABLE `cotton_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courier`
--
ALTER TABLE `courier`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courier_activities`
--
ALTER TABLE `courier_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courier_clients`
--
ALTER TABLE `courier_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courier_collection`
--
ALTER TABLE `courier_collection`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courier_items`
--
ALTER TABLE `courier_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courier_lists`
--
ALTER TABLE `courier_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courier_loading`
--
ALTER TABLE `courier_loading`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courier_payments`
--
ALTER TABLE `courier_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `farmers`
--
ALTER TABLE `farmers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `farm_lands`
--
ALTER TABLE `farm_lands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `farm_program`
--
ALTER TABLE `farm_program`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `feed_type`
--
ALTER TABLE `feed_type`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `field_staff`
--
ALTER TABLE `field_staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fuels`
--
ALTER TABLE `fuels`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `gl_account_class`
--
ALTER TABLE `gl_account_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `gl_account_codes`
--
ALTER TABLE `gl_account_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `gl_account_group`
--
ALTER TABLE `gl_account_group`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `gl_account_type`
--
ALTER TABLE `gl_account_type`
  MODIFY `account_type_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `gmembers`
--
ALTER TABLE `gmembers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `good_disposals`
--
ALTER TABLE `good_disposals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `good_issues`
--
ALTER TABLE `good_issues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `good_issue_items`
--
ALTER TABLE `good_issue_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `good_movements`
--
ALTER TABLE `good_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `good_reallocations`
--
ALTER TABLE `good_reallocations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `good_returns`
--
ALTER TABLE `good_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `good_return_items`
--
ALTER TABLE `good_return_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventory_histories`
--
ALTER TABLE `inventory_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventory_list`
--
ALTER TABLE `inventory_list`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inventory_payments`
--
ALTER TABLE `inventory_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journal_entries`
--
ALTER TABLE `journal_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=912;

--
-- AUTO_INCREMENT for table `levy`
--
ALTER TABLE `levy`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `licences`
--
ALTER TABLE `licences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lime_base`
--
ALTER TABLE `lime_base`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `maintainances`
--
ALTER TABLE `maintainances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `maintainance_report`
--
ALTER TABLE `maintainance_report`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `manufacturing_inventories`
--
ALTER TABLE `manufacturing_inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `manufacturing_inventory_histories`
--
ALTER TABLE `manufacturing_inventory_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `manufacturing_inventory_list`
--
ALTER TABLE `manufacturing_inventory_list`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `manufacturing_inventory_payments`
--
ALTER TABLE `manufacturing_inventory_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `manufacturing_locations`
--
ALTER TABLE `manufacturing_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `manufacturing_purchase_inventories`
--
ALTER TABLE `manufacturing_purchase_inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `manufacturing_purchase_item_inventories`
--
ALTER TABLE `manufacturing_purchase_item_inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `medicine_category`
--
ALTER TABLE `medicine_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_client`
--
ALTER TABLE `medicine_client`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_history`
--
ALTER TABLE `medicine_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_invoice`
--
ALTER TABLE `medicine_invoice`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_invoice_item`
--
ALTER TABLE `medicine_invoice_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_list`
--
ALTER TABLE `medicine_list`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_location`
--
ALTER TABLE `medicine_location`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_sales_payments`
--
ALTER TABLE `medicine_sales_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_stock`
--
ALTER TABLE `medicine_stock`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_supplier`
--
ALTER TABLE `medicine_supplier`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `mileages`
--
ALTER TABLE `mileages`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `millage_payments`
--
ALTER TABLE `millage_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `operators`
--
ALTER TABLE `operators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_movements`
--
ALTER TABLE `order_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_payments`
--
ALTER TABLE `order_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pacels`
--
ALTER TABLE `pacels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pacel_items`
--
ALTER TABLE `pacel_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pacel_lists`
--
ALTER TABLE `pacel_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pacel_payments`
--
ALTER TABLE `pacel_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment_methodes`
--
ALTER TABLE `payment_methodes`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `performances`
--
ALTER TABLE `performances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=449;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `purchase_cotton`
--
ALTER TABLE `purchase_cotton`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `purchase_inventories`
--
ALTER TABLE `purchase_inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_item_cotton`
--
ALTER TABLE `purchase_item_cotton`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_item_inventories`
--
ALTER TABLE `purchase_item_inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchase_item_medicine`
--
ALTER TABLE `purchase_item_medicine`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_item_tyres`
--
ALTER TABLE `purchase_item_tyres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchase_medicine`
--
ALTER TABLE `purchase_medicine`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_medicine_payments`
--
ALTER TABLE `purchase_medicine_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_tyres`
--
ALTER TABLE `purchase_tyres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quotation_costs`
--
ALTER TABLE `quotation_costs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refills`
--
ALTER TABLE `refills`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `reversed_top_up_center`
--
ALTER TABLE `reversed_top_up_center`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reversed_top_up_operator`
--
ALTER TABLE `reversed_top_up_operator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `roles_sys_modules`
--
ALTER TABLE `roles_sys_modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sales_items`
--
ALTER TABLE `sales_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seed_invoice`
--
ALTER TABLE `seed_invoice`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `seed_invoice_history`
--
ALTER TABLE `seed_invoice_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `seed_invoice_item`
--
ALTER TABLE `seed_invoice_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `seed_lists`
--
ALTER TABLE `seed_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `seed_payments`
--
ALTER TABLE `seed_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service_items`
--
ALTER TABLE `service_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `service_report`
--
ALTER TABLE `service_report`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stickers`
--
ALTER TABLE `stickers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `system_control`
--
ALTER TABLE `system_control`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sys_modules`
--
ALTER TABLE `sys_modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_account_details`
--
ALTER TABLE `tbl_account_details`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_advance_salary`
--
ALTER TABLE `tbl_advance_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_corops_monitoring`
--
ALTER TABLE `tbl_corops_monitoring`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_costants`
--
ALTER TABLE `tbl_costants`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_cost_centres`
--
ALTER TABLE `tbl_cost_centres`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_cost_functions`
--
ALTER TABLE `tbl_cost_functions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_cotton`
--
ALTER TABLE `tbl_cotton`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_crops_monitoring`
--
ALTER TABLE `tbl_crops_monitoring`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_crops_types`
--
ALTER TABLE `tbl_crops_types`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_deposit`
--
ALTER TABLE `tbl_deposit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_employee_award`
--
ALTER TABLE `tbl_employee_award`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_employee_loan`
--
ALTER TABLE `tbl_employee_loan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_employee_loan_returns`
--
ALTER TABLE `tbl_employee_loan_returns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_employee_payroll`
--
ALTER TABLE `tbl_employee_payroll`
  MODIFY `payroll_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_expenses`
--
ALTER TABLE `tbl_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_farmer_accounts`
--
ALTER TABLE `tbl_farmer_accounts`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_farming_costing`
--
ALTER TABLE `tbl_farming_costing`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_farming_cost_items`
--
ALTER TABLE `tbl_farming_cost_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `tbl_farming_processes`
--
ALTER TABLE `tbl_farming_processes`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_fertilizers`
--
ALTER TABLE `tbl_fertilizers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_insurances`
--
ALTER TABLE `tbl_insurances`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_invoice_payments`
--
ALTER TABLE `tbl_invoice_payments`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_irrigation_processes`
--
ALTER TABLE `tbl_irrigation_processes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_irrigation_settings`
--
ALTER TABLE `tbl_irrigation_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_irrigation_settings2`
--
ALTER TABLE `tbl_irrigation_settings2`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_irrigation_settings_items`
--
ALTER TABLE `tbl_irrigation_settings_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_irrigation_systems`
--
ALTER TABLE `tbl_irrigation_systems`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_land_properties`
--
ALTER TABLE `tbl_land_properties`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_leave_application`
--
ALTER TABLE `tbl_leave_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_leave_category`
--
ALTER TABLE `tbl_leave_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_monitoring_type`
--
ALTER TABLE `tbl_monitoring_type`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_overtime`
--
ALTER TABLE `tbl_overtime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_parking_types`
--
ALTER TABLE `tbl_parking_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_payroll_activities`
--
ALTER TABLE `tbl_payroll_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_pestisides`
--
ALTER TABLE `tbl_pestisides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_pestisides_type`
--
ALTER TABLE `tbl_pestisides_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_post_harvests`
--
ALTER TABLE `tbl_post_harvests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_preparation_costs`
--
ALTER TABLE `tbl_preparation_costs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_preparation_cost_lists`
--
ALTER TABLE `tbl_preparation_cost_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `tbl_preparation_details`
--
ALTER TABLE `tbl_preparation_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_pre_harvests`
--
ALTER TABLE `tbl_pre_harvests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_production`
--
ALTER TABLE `tbl_production`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_productionactivity`
--
ALTER TABLE `tbl_productionactivity`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_productionlist`
--
ALTER TABLE `tbl_productionlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `tbl_product_tools`
--
ALTER TABLE `tbl_product_tools`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_purchases`
--
ALTER TABLE `tbl_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_purchase_items`
--
ALTER TABLE `tbl_purchase_items`
  MODIFY `purchase_items_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tbl_quotation_costs`
--
ALTER TABLE `tbl_quotation_costs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `tbl_salary_allowance`
--
ALTER TABLE `tbl_salary_allowance`
  MODIFY `salary_allowance_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_salary_deduction`
--
ALTER TABLE `tbl_salary_deduction`
  MODIFY `salary_deduction_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_salary_payments`
--
ALTER TABLE `tbl_salary_payments`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_salary_payment_allowance`
--
ALTER TABLE `tbl_salary_payment_allowance`
  MODIFY `salary_payment_allowance_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_salary_payment_deduction`
--
ALTER TABLE `tbl_salary_payment_deduction`
  MODIFY `salary_payment_deduction_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_salary_payment_details`
--
ALTER TABLE `tbl_salary_payment_details`
  MODIFY `salary_payment_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_salary_payslip`
--
ALTER TABLE `tbl_salary_payslip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_salary_template`
--
ALTER TABLE `tbl_salary_template`
  MODIFY `salary_template_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_sales`
--
ALTER TABLE `tbl_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_sales_items`
--
ALTER TABLE `tbl_sales_items`
  MODIFY `sales_items_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tbl_seassons`
--
ALTER TABLE `tbl_seassons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_seed_types`
--
ALTER TABLE `tbl_seed_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_sowings`
--
ALTER TABLE `tbl_sowings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_training`
--
ALTER TABLE `tbl_training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_transfer`
--
ALTER TABLE `tbl_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_transport_quotations`
--
ALTER TABLE `tbl_transport_quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_user_details`
--
ALTER TABLE `tbl_user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_warehouses`
--
ALTER TABLE `tbl_warehouses`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_weedings`
--
ALTER TABLE `tbl_weedings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `top_up_center`
--
ALTER TABLE `top_up_center`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `top_up_operator`
--
ALTER TABLE `top_up_operator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `trucks`
--
ALTER TABLE `trucks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `truck_insurances`
--
ALTER TABLE `truck_insurances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tyres`
--
ALTER TABLE `tyres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tyre_activities`
--
ALTER TABLE `tyre_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tyre_brands`
--
ALTER TABLE `tyre_brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tyre_disposals`
--
ALTER TABLE `tyre_disposals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tyre_histories`
--
ALTER TABLE `tyre_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tyre_payments`
--
ALTER TABLE `tyre_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tyre_reallocations`
--
ALTER TABLE `tyre_reallocations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tyre_returns`
--
ALTER TABLE `tyre_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `wards`
--
ALTER TABLE `wards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3638;

--
-- AUTO_INCREMENT for table `work_orders`
--
ALTER TABLE `work_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `work_order_issue`
--
ALTER TABLE `work_order_issue`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `zones`
--
ALTER TABLE `zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `roles_sys_modules`
--
ALTER TABLE `roles_sys_modules`
  ADD CONSTRAINT `roles_sys_modules_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_sys_modules_sys_module_id_foreign` FOREIGN KEY (`sys_module_id`) REFERENCES `sys_modules` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
