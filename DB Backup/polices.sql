-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2023 at 06:18 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `isp_company`
--

-- --------------------------------------------------------

--
-- Table structure for table `polices`
--

CREATE TABLE `polices` (
  `id` int(10) NOT NULL,
  `bp_no` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `evsjv` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `division` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `polices`
--

INSERT INTO `polices` (`id`, `bp_no`, `evsjv`, `name`, `rank`, `division`, `picture`, `created_at`, `updated_at`) VALUES
(1, 'BP7402084188', 'অপূর্ব হাসান, পিপিএম', 'APURBO HASAN, PPM', 'Inspector (UB)', 'তেজগাঁও বিভাগ', '1_1.png', '2023-09-26 21:48:11', '2023-09-26 21:48:11'),
(2, 'BP8110139993', 'মোঃ নূর আলম সিদ্দিক', 'MD. NOOR ALAM SIDDIQUEE', 'Inspector (UB)', 'ওয়ারী বিভাগ', '2_1.png', '2023-09-26 21:48:11', '2023-09-26 21:48:11'),
(3, 'BP7700055319', 'মোঃ শফিকুল গনি সাবু', 'MD. SHAFIQUL GANI SABU', 'Inspector (UB)', 'রমনা  বিভাগ', '3_1.png', '2023-09-26 21:48:11', '2023-09-26 21:48:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `polices`
--
ALTER TABLE `polices`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `polices`
--
ALTER TABLE `polices`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
