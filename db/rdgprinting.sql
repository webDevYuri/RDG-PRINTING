-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2025 at 09:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rdgprinting`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'Reymundo', '$2y$10$TPh5ywrXfI8odIa.4p1/suN87y8BUWw54NBy4HZtsYHOuGm6k7TE2');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `service` enum('print','2x2','passport size','1x1') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `isNotified` tinyint(1) NOT NULL DEFAULT 0,
  `job_instructions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `name`, `email`, `service`, `created_at`, `isActive`, `isNotified`, `job_instructions`) VALUES
(29, 'Yuri', 'yurigonzaga643@gmail.com', 'print', '2025-05-21 09:56:13', 1, 0, 'print'),
(31, 'Yuri', 'yurigonzaga643@gmail.com', 'print', '2025-05-21 12:35:38', 1, 0, 'hehe'),
(40, 'dewqfd', 'fwefwef@gmail.com', 'print', '2025-05-21 14:26:30', 1, 0, 'd2r23r'),
(41, 'wefwefew', '3dwfwfw@gmail.com', 'print', '2025-05-21 14:28:02', 1, 0, 'dqwdqwd'),
(42, 'Yuri po', 'yuri@gmail.com', 'print', '2025-05-21 14:37:51', 1, 0, '2x2 po');

-- --------------------------------------------------------

--
-- Table structure for table `upload_files`
--

CREATE TABLE `upload_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `upload_id` int(10) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `upload_files`
--

INSERT INTO `upload_files` (`id`, `upload_id`, `file_name`, `file_path`) VALUES
(37, 29, '1745736793927.jpeg', 'uploads/1747821373_0_1745736793927.jpeg'),
(39, 31, 'received_679819604969373.jpeg', 'uploads/1747830938_0_received_679819604969373.jpeg'),
(49, 40, '1745735836593.jpeg', 'uploads/1747837590_0_1745735836593.jpeg'),
(50, 41, '2_638813861943635465.jpg', 'uploads/1747837682_0_2_638813861943635465.jpg'),
(51, 41, '1_638812851949692738.png', 'uploads/1747837682_1_1_638812851949692738.png'),
(52, 42, 'test1.jpg', 'uploads/1747838271_0_test1.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upload_files`
--
ALTER TABLE `upload_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_upload` (`upload_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `upload_files`
--
ALTER TABLE `upload_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `upload_files`
--
ALTER TABLE `upload_files`
  ADD CONSTRAINT `fk_upload_files_upload` FOREIGN KEY (`upload_id`) REFERENCES `uploads` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
