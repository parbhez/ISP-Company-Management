-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2023 at 08:35 AM
-- Server version: 10.4.24-MariaDB
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
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `account_number`, `type`, `description`, `balance`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Masud Parbhez', '00000001', 'Assets', 'Description', '15000.00', 1, '2023-04-30 15:48:07', '2023-04-30 22:47:10'),
(2, 'Minhajur Rahman', '00000002', 'Liabilities', 'Description', '18500.00', 1, '2023-04-30 15:48:07', '2023-04-30 15:48:07'),
(3, 'Prosenjit  Das', '00000003', 'Income', 'Saving && income', '50000.00', 1, '2023-04-30 16:44:46', '2023-04-30 16:45:40');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `month` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid' COMMENT '1=>Paid, 0=>Unpaid, 2=>Due',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `customer_id`, `month`, `year`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'January', '2023', '500.00', 'Unpaid', '2023-04-30 12:46:36', '2023-04-30 12:46:36'),
(2, 2, 'February', '2023', '1500.00', 'Paid', '2023-04-30 12:46:36', '2023-04-30 12:46:36'),
(3, 3, 'March', '2023', '2500.00', 'Unpaid', '2023-04-30 12:46:36', '2023-04-30 12:46:36'),
(4, 3, 'July', '2022', '1500.00', 'Unpaid', '2023-04-30 14:19:19', '2023-04-30 14:24:43');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `package_id`, `name`, `email`, `phone`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Customer 1', 'customer1@gmail.com', '01778565178', 'Dhaka', 1, '2023-04-30 09:03:17', '2023-04-30 09:03:17'),
(2, 2, 'Customer 2', 'customer2@gmail.com', '01778565578', 'Dhaka', 1, '2023-04-30 09:03:17', '2023-04-30 09:03:17'),
(3, 3, 'Customer 3', 'customer3@gmail.com', '01778565978', 'Dhaka', 1, '2023-04-30 09:03:17', '2023-04-30 09:03:17'),
(4, 3, 'Masud Parbhez', 'masud@gmail.com', '01778565179', 'Mirpur-10, Dhaka-1216', 1, '2023-04-30 09:52:07', '2023-04-30 09:55:14');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `name`, `date`, `description`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Electricty Bill', '2023-05-01', 'Electricty Bill Electricty Bill', '2500.00', 1, '2023-04-30 14:36:11', '2023-04-30 14:36:11'),
(2, 'Newspaper Bill', '2023-05-01', 'Newspaper Bill Newspaper Bill', '2000.00', 1, '2023-04-30 14:36:11', '2023-04-30 14:36:11'),
(3, 'Office Party update', '2023-05-18', 'Office PartyOffice Party', '3000.00', 1, '2023-04-30 15:15:25', '2023-04-30 15:16:25');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_04_27_184447_create_sessions_table', 1),
(7, '2023_04_29_051544_create_permission_tables', 1),
(8, '2023_04_30_114116_create_packages_table', 2),
(9, '2023_04_30_145328_create_customers_table', 3),
(10, '2023_04_30_183359_create_bills_table', 4),
(11, '2023_04_30_202748_create_expenses_table', 5),
(12, '2023_04_30_213806_create_accounts_table', 6),
(13, '2023_04_30_213444806_create_accounts_table', 7),
(14, '2023_05_01_033653_create_transactions_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 3),
(5, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monthly_fee` decimal(8,2) NOT NULL DEFAULT 0.00,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `monthly_fee`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, '5-10 MBPS', '500.00', 'test description', 1, '2023-04-30 06:00:53', '2023-04-30 06:00:53'),
(2, '10-15 MBPS', '1000.00', 'test description', 1, '2023-04-30 06:00:53', '2023-04-30 06:00:53'),
(3, '15-20 MBPS', '1500.00', 'test description', 1, '2023-04-30 06:00:53', '2023-04-30 06:00:53'),
(4, '25-35 MBPS update', '5000.00', 'test', 1, '2023-04-30 08:48:57', '2023-04-30 08:49:16');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'dashboard.view', 'web', 'dashboard', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(2, 'dashboard.edit', 'web', 'dashboard', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(3, 'blog.create', 'web', 'blog', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(4, 'blog.view', 'web', 'blog', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(5, 'blog.edit', 'web', 'blog', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(6, 'blog.delete', 'web', 'blog', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(7, 'blog.approve', 'web', 'blog', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(8, 'user.create', 'web', 'user', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(9, 'user.view', 'web', 'user', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(10, 'user.edit', 'web', 'user', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(11, 'user.delete', 'web', 'user', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(12, 'user.approve', 'web', 'user', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(13, 'role.create', 'web', 'role', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(14, 'role.view', 'web', 'role', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(15, 'role.edit', 'web', 'role', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(16, 'role.delete', 'web', 'role', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(17, 'role.approve', 'web', 'role', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(18, 'profile.view', 'web', 'profile', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(19, 'profile.edit', 'web', 'profile', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(20, 'account.create', 'web', 'account', '2023-04-30 01:36:52', '2023-04-30 01:41:07'),
(21, 'permission.create', 'web', 'permission', '2023-04-30 04:50:37', '2023-04-30 04:51:47'),
(22, 'permission.view', 'web', 'permission', '2023-04-30 04:50:47', '2023-04-30 04:51:29'),
(23, 'permission.edit', 'web', 'permission', '2023-04-30 04:51:13', '2023-04-30 04:51:13'),
(24, 'permission.delete', 'web', 'permission', '2023-05-01 05:39:09', '2023-05-01 05:39:10'),
(25, 'permission.approve', 'web', 'permission', '2023-05-01 05:39:35', '2023-05-01 05:39:36'),
(26, 'package.create', 'web', 'package', '2023-05-01 05:40:06', '2023-05-01 05:40:08'),
(27, 'package.view', 'web', 'package', '2023-05-01 05:40:32', '2023-05-01 05:40:33'),
(28, 'package.edit', 'web', 'package', '2023-05-01 05:40:57', '2023-05-01 05:40:59'),
(29, 'customer.create', 'web', 'customer', '2023-05-01 05:41:47', '2023-05-01 05:41:48'),
(30, 'customer.edit', 'web', 'customer', '2023-05-01 05:41:45', '2023-05-01 05:41:46'),
(31, 'customer.view', 'web', 'customer', '2023-05-01 05:42:29', '2023-05-01 05:42:29'),
(32, 'bill.create', 'web', 'bill', '2023-05-01 05:42:54', '2023-05-01 05:42:55'),
(33, 'bill.view', 'web', 'bill', '2023-05-01 05:43:17', '2023-05-01 05:43:17'),
(34, 'bill.edit', 'web', 'bill', '2023-05-01 05:43:34', '2023-05-01 05:43:34'),
(35, 'expense.create', 'web', 'expense', '2023-05-01 05:43:59', '2023-05-01 05:43:59'),
(36, 'expense.view', 'web', 'expense', '2023-05-01 05:44:10', '2023-05-01 05:44:11'),
(37, 'expense.edit', 'web', 'expense', '2023-05-01 05:44:24', '2023-05-01 05:44:25'),
(39, 'account.view', 'web', 'account', '2023-05-01 05:44:46', '2023-05-01 05:44:47'),
(40, 'account.edit', 'web', 'account', '2023-05-01 05:45:30', '2023-05-01 05:45:31'),
(41, 'transaction.create', 'web', 'transaction', '2023-05-01 05:45:52', '2023-05-01 05:45:52'),
(42, 'transaction.view', 'web', 'transaction', '2023-05-01 05:46:03', '2023-05-01 05:46:04');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'web', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(2, 'admin', 'web', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(3, 'client', 'web', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(4, 'editor', 'web', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(5, 'user', 'web', '2023-04-29 09:21:15', '2023-04-29 09:21:15'),
(6, 'test', 'web', '2023-04-29 12:27:12', '2023-04-29 16:29:25');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 3),
(1, 5),
(2, 1),
(2, 3),
(2, 5),
(3, 1),
(3, 2),
(3, 3),
(4, 1),
(4, 2),
(4, 3),
(5, 1),
(5, 2),
(5, 3),
(6, 1),
(6, 2),
(6, 3),
(7, 1),
(7, 2),
(7, 3),
(8, 1),
(8, 3),
(8, 4),
(8, 6),
(9, 1),
(9, 3),
(9, 4),
(9, 6),
(10, 1),
(10, 3),
(10, 4),
(10, 6),
(11, 1),
(11, 3),
(11, 4),
(11, 6),
(12, 1),
(12, 3),
(12, 4),
(12, 6),
(13, 1),
(13, 3),
(14, 1),
(14, 3),
(15, 1),
(15, 3),
(16, 1),
(16, 3),
(17, 1),
(17, 3),
(18, 1),
(18, 3),
(18, 5),
(19, 1),
(19, 3),
(19, 5),
(20, 1),
(20, 3),
(21, 1),
(21, 3),
(22, 1),
(22, 3),
(23, 1),
(23, 3),
(24, 1),
(24, 3),
(25, 1),
(25, 3),
(26, 1),
(26, 3),
(27, 1),
(27, 3),
(28, 1),
(28, 3),
(29, 1),
(29, 3),
(30, 1),
(30, 3),
(31, 1),
(31, 3),
(32, 1),
(32, 3),
(33, 1),
(33, 3),
(34, 1),
(34, 3),
(35, 1),
(35, 3),
(36, 1),
(36, 3),
(37, 1),
(37, 3),
(39, 1),
(39, 3),
(40, 1),
(40, 3),
(41, 1),
(41, 3),
(42, 1),
(42, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('lKNCIB1PY9pDAM94U2Zg5YAvuqp5xa438dJ55heL', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiVVpPQndhZDMzZzRYR3AzUFo0NUNOaDBXVzlKckhvb0NzNDhPbUs5NyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWNjb3VudHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJEtqa3ZTWWN1Z3FkeG5DUUdRQmVBRk9HN20zMEtHTDdBMU1mbVRoRlpneW1JdE9lV2hIWWF1Ijt9', 1682922826);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(11) NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Deposit, Withdraw',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `account_id`, `date`, `type`, `description`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-05-01', 'Deposit', 'description', '5000.00', 1, '2023-04-30 21:44:38', '2023-04-30 21:44:38'),
(2, 2, '2023-04-01', 'Withdraw', 'description', '5000.00', 1, '2023-04-30 21:44:38', '2023-04-30 21:44:38'),
(3, 1, '2023-05-01', 'Deposit', '1000 tk deposit', '5000.00', 1, '2023-04-30 22:43:04', '2023-04-30 22:43:04'),
(4, 1, '2023-04-30', 'Deposit', '2500 deposit', '2500.00', 1, '2023-04-30 22:45:57', '2023-04-30 22:45:57'),
(5, 1, '2023-05-01', 'Withdraw', '5000 withdraw for buying laptop', '5000.00', 1, '2023-04-30 22:47:10', '2023-04-30 22:47:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `is_admin`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Client', 0, 'client@gmail.com', NULL, '$2y$10$ngjtahfEPB.j1i8TjrfkXechJgj56/DDuRxNuDqQSanH92jc.EsCu', NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-29 09:21:15', '2023-04-30 02:01:03'),
(2, 'masud', 0, 'masud@gmail.com', NULL, '$2y$10$OG61n9yRJMCRP5BUZrvsL.P7rmkTYGNP0enJ5B/fNbTmeVCEkgW7W', NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-29 23:38:52', '2023-04-30 02:03:42'),
(3, 'Test', 0, 'test@gmail.com', NULL, '$2y$10$KTiZojfNo1nRzeRQknXi..TgG/a7BAGuWQ67BxPbPhcOLsylGg1bC', NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-29 23:55:38', '2023-04-29 23:55:38'),
(4, 'Super Admin', 0, 'admin@gmail.com', NULL, '$2y$10$KjkvSYcugqdxnCQGQBeAFOG7m30KGL7A1MfmThFZgymItOeWhHYau', NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-29 23:58:32', '2023-04-30 03:23:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD UNIQUE KEY `customers_phone_unique` (`phone`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
