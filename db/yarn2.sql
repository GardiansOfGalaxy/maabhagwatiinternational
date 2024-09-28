-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2024 at 07:24 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yarn`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Amol2', '2024-07-28 02:50:02', '2024-07-28 05:35:09'),
(2, 'Nikhil', '2024-07-28 02:50:10', '2024-07-28 02:50:10'),
(3, 'Chetan', '2024-07-28 03:25:03', '2024-07-28 03:25:03'),
(4, 'Tom', '2024-07-28 17:21:33', '2024-07-28 17:21:33');

-- --------------------------------------------------------

--
-- Table structure for table `deniers`
--

CREATE TABLE `deniers` (
  `id` int(11) NOT NULL,
  `den` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deniers`
--

INSERT INTO `deniers` (`id`, `den`, `created`, `modified`) VALUES
(1, 100, '2024-07-28 02:50:53', '2024-07-28 02:50:53'),
(2, 120, '2024-07-28 04:36:51', '2024-07-28 04:36:51'),
(3, 130, '2024-07-28 04:37:00', '2024-07-28 04:37:00');

-- --------------------------------------------------------

--
-- Table structure for table `designs`
--

CREATE TABLE `designs` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designs`
--

INSERT INTO `designs` (`id`, `name`, `created`, `modified`) VALUES
(1, '123', '2024-07-28 02:51:30', '2024-07-28 17:17:16'),
(2, '1002', '2024-07-28 02:51:42', '2024-07-28 17:18:02'),
(3, '1111', '2024-07-28 17:17:35', '2024-07-28 17:17:35'),
(4, '1001', '2024-07-28 17:17:46', '2024-07-28 17:17:46');

-- --------------------------------------------------------

--
-- Table structure for table `dispatch_stock_sales`
--

CREATE TABLE `dispatch_stock_sales` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `length_id` int(11) NOT NULL,
  `design_id` int(11) NOT NULL,
  `total_no_rolls` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dispatch_stock_sales`
--

INSERT INTO `dispatch_stock_sales` (`id`, `date`, `length_id`, `design_id`, `total_no_rolls`, `created`, `modified`) VALUES
(1, '2024-07-27', 1, 1, 10, '2024-07-28 03:23:05', '2024-07-28 13:33:50'),
(2, '2024-07-28', 2, 2, 30, '2024-07-28 04:56:58', '2024-07-28 04:56:58'),
(3, '2024-07-30', 1, 1, 22, '2024-07-28 13:30:53', '2024-07-28 13:30:53'),
(4, '2024-07-30', 1, 1, 100, '2024-07-28 17:22:31', '2024-07-28 17:22:31'),
(5, '2024-08-02', 1, 2, 100, '2024-08-01 17:14:17', '2024-08-01 17:14:17');

-- --------------------------------------------------------

--
-- Table structure for table `dispatch_to_own_factories`
--

CREATE TABLE `dispatch_to_own_factories` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `pick_id` int(11) NOT NULL,
  `factory_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dispatch_to_own_factories`
--

INSERT INTO `dispatch_to_own_factories` (`id`, `date`, `pick_id`, `factory_name`, `quantity`, `created`, `modified`) VALUES
(1, '2024-07-28', 1, 'Shree Ram Tower', 50000, '2024-07-28 04:57:38', '2024-07-28 04:57:38');

-- --------------------------------------------------------

--
-- Table structure for table `foldings`
--

CREATE TABLE `foldings` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `length_id` int(11) NOT NULL,
  `design_id` int(11) NOT NULL,
  `mtrperroll_id` int(11) NOT NULL,
  `total_rolls` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foldings`
--

INSERT INTO `foldings` (`id`, `date`, `length_id`, `design_id`, `mtrperroll_id`, `total_rolls`, `created`, `modified`) VALUES
(1, '2024-07-29', 2, 2, 1, 55, '2024-07-28 13:36:33', '2024-07-28 13:41:10'),
(2, '2024-08-17', 1, 4, 2, 22, '2024-08-16 12:32:43', '2024-08-16 12:33:10');

-- --------------------------------------------------------

--
-- Table structure for table `grey_remainings`
--

CREATE TABLE `grey_remainings` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `picks` varchar(255) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grey_remainings`
--

INSERT INTO `grey_remainings` (`id`, `date`, `picks`, `data`, `created`, `modified`) VALUES
(1, '2024-08-03', '25', '2000', '2024-08-03 22:25:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lengths`
--

CREATE TABLE `lengths` (
  `id` int(11) NOT NULL,
  `L` varchar(100) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lengths`
--

INSERT INTO `lengths` (`id`, `L`, `created`, `modified`) VALUES
(1, '50', '2024-07-28 03:00:21', '2024-07-28 03:00:21'),
(2, '40', '2024-07-28 03:00:31', '2024-07-28 03:00:31'),
(3, '125', '2024-07-28 17:18:22', '2024-07-28 17:18:22'),
(4, '100', '2024-07-28 17:19:01', '2024-07-28 17:19:01');

-- --------------------------------------------------------

--
-- Table structure for table `mtrperrolls`
--

CREATE TABLE `mtrperrolls` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mtrperrolls`
--

INSERT INTO `mtrperrolls` (`id`, `number`, `created`, `modified`) VALUES
(1, 20, '2024-07-28 03:01:35', '2024-07-28 03:01:35'),
(2, 125, '2024-07-28 04:58:14', '2024-07-28 04:58:14');

-- --------------------------------------------------------

--
-- Table structure for table `picks`
--

CREATE TABLE `picks` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `denier_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `picks`
--

INSERT INTO `picks` (`id`, `name`, `denier_id`, `created`, `modified`) VALUES
(1, '25', 2, '2024-07-28 04:38:41', '2024-07-28 13:49:44'),
(2, '30', 2, '2024-07-28 17:24:05', '2024-08-15 14:50:49');

-- --------------------------------------------------------

--
-- Table structure for table `printed_stock_entries`
--

CREATE TABLE `printed_stock_entries` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `pick_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL,
  `design_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `printed_stock_entries`
--

INSERT INTO `printed_stock_entries` (`id`, `date`, `pick_id`, `quantity`, `created`, `modified`, `design_id`) VALUES
(1, '2024-07-28', 1, 100, '2024-07-28 04:58:54', '2024-07-28 04:58:54', 0),
(2, '2024-07-31', 2, 20, '2024-07-28 17:24:55', '2024-07-28 17:24:55', 0),
(3, '2024-08-14', 1, 1234, '2024-08-14 17:54:33', '2024-08-14 17:54:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `first_name`, `last_name`, `created`, `modified`) VALUES
(1, 'admin@test.com', '$2y$10$1bVXW6JzAhUsWgF.ezM6/uBVCGA.hIZu0/L8wrpWoCLMQC2HlrRPC', 'admin@test.com', 'admin', '', '2024-06-11 23:52:37', '2024-06-11');

-- --------------------------------------------------------

--
-- Table structure for table `waterjets`
--

CREATE TABLE `waterjets` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `pick_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `waterjets`
--

INSERT INTO `waterjets` (`id`, `date`, `pick_id`, `quantity`, `created`, `modified`) VALUES
(1, '2024-07-28', 1, 20000, '2024-07-28 04:59:22', '2024-07-28 04:59:22'),
(2, '2024-08-03', 1, 220000, '2024-08-03 18:36:11', '2024-08-16 16:45:53');

-- --------------------------------------------------------

--
-- Table structure for table `widths`
--

CREATE TABLE `widths` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pick_id` int(11) NOT NULL,
  `denier_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `widths`
--

INSERT INTO `widths` (`id`, `name`, `pick_id`, `denier_id`, `created`, `modified`) VALUES
(1, '1001', 1, 1, '2024-08-14 17:58:35', '2024-08-15 14:53:08'),
(2, '1002', 2, 2, '2024-08-15 11:46:09', '2024-08-15 14:53:19'),
(3, '1003', 1, 1, '2024-08-15 15:30:22', '2024-08-15 15:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `yarn_stocks`
--

CREATE TABLE `yarn_stocks` (
  `id` int(11) NOT NULL,
  `denier_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `boxes` int(11) NOT NULL,
  `kg` decimal(10,2) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `yarn_stocks`
--

INSERT INTO `yarn_stocks` (`id`, `denier_id`, `agent_id`, `date`, `boxes`, `kg`, `created`, `modified`, `customer_name`) VALUES
(1, 3, 1, '2024-07-29', 10, 300.00, '2024-07-28 05:00:25', '2024-08-14 14:33:21', '2'),
(2, 1, 1, '2024-08-14', 12, 22.00, '2024-08-14 14:30:47', '2024-08-14 14:30:47', 'test');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deniers`
--
ALTER TABLE `deniers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designs`
--
ALTER TABLE `designs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dispatch_stock_sales`
--
ALTER TABLE `dispatch_stock_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dispatch_to_own_factories`
--
ALTER TABLE `dispatch_to_own_factories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `foldings`
--
ALTER TABLE `foldings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grey_remainings`
--
ALTER TABLE `grey_remainings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lengths`
--
ALTER TABLE `lengths`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mtrperrolls`
--
ALTER TABLE `mtrperrolls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `picks`
--
ALTER TABLE `picks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `printed_stock_entries`
--
ALTER TABLE `printed_stock_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `waterjets`
--
ALTER TABLE `waterjets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `widths`
--
ALTER TABLE `widths`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yarn_stocks`
--
ALTER TABLE `yarn_stocks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `deniers`
--
ALTER TABLE `deniers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `designs`
--
ALTER TABLE `designs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dispatch_stock_sales`
--
ALTER TABLE `dispatch_stock_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dispatch_to_own_factories`
--
ALTER TABLE `dispatch_to_own_factories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `foldings`
--
ALTER TABLE `foldings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `grey_remainings`
--
ALTER TABLE `grey_remainings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lengths`
--
ALTER TABLE `lengths`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mtrperrolls`
--
ALTER TABLE `mtrperrolls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `picks`
--
ALTER TABLE `picks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `printed_stock_entries`
--
ALTER TABLE `printed_stock_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `waterjets`
--
ALTER TABLE `waterjets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `widths`
--
ALTER TABLE `widths`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `yarn_stocks`
--
ALTER TABLE `yarn_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
