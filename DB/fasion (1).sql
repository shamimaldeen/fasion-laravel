-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2023 at 06:25 PM
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
-- Database: `fasion`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `serial` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `serial`, `status`, `description`, `photo`, `user_id`, `created_at`, `updated_at`) VALUES
(23, 'i Phone', 'i-phone', 1, 0, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,\nmolestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum\nnumquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium\noptio, eaque rerum! Provide', 'SQM0Z8ehvzqblZGhZsJHeoh0cccYJpAK.jpg', 1, '2023-10-24 13:45:50', '2023-10-24 13:45:50'),
(24, 'Samsung', 'samsung', 2, 0, 'Samsung Phone description will be here', 'Cf0O4UTZpENVoBvHoDqPPFo4J86POfGe.jpg', 1, '2023-10-24 13:47:55', '2023-10-24 13:47:55'),
(26, 'Nokia Updatedd', 'nokia-updatedd', 34, 1, 'Nokia Phone Description', 'nokia-updatedd-pEFauWGRgj4UHOL.jpg', 1, '2023-10-24 13:52:21', '2023-10-31 11:13:05'),
(27, 'RedME', 'redme', 6, 1, 'gfdg', NULL, 1, '2023-10-24 13:53:43', '2023-10-30 13:29:43'),
(28, 'fdsfdsf', 'fdsfdsf', 3, 1, 'fdsfsaf', 'fdsfdsf-nUHAIOqKNrlStvZ.jpg', 1, '2023-10-24 14:00:47', '2023-10-24 14:00:47'),
(29, 'fdsfsd', 'fdsfsd', 42, 1, 'fsdfsd', 'fdsfsd-OeXWrjgYxgze2xX.jpg', 1, '2023-10-24 14:03:25', '2023-10-24 14:03:25'),
(30, 'gggfdg', 'gggfdg', 4, 1, 'gfgfdg', 'gggfdg-xZikHBux9mfqTF3.jpg', 1, '2023-10-24 14:07:55', '2023-10-24 14:07:55'),
(31, 'gfdsg', 'gfdsg', 3, 1, 'gfdgf', 'gfdsg-P1gJo6Tkzzwclfy.jpg', 1, '2023-10-24 14:36:47', '2023-10-24 14:36:47'),
(32, 'fsdfds', 'fsdfds', 65, 1, 'gfh', 'fsdfds-VCHwp31AaqX0rmY.jpg', 1, '2023-10-24 14:48:13', '2023-10-24 14:48:13'),
(39, 'bv', 'bv', 3, 1, 'gfdsgdfg', 'bv-XCrNBXmrUhC2rOz.jpg', 1, '2023-10-28 15:24:13', '2023-10-28 15:24:13'),
(40, 'pppppppp', 'pppppppp', 4, 1, 'gfdgfdg', 'pppppppp-VxvPw0lsVr2EbPt.jpg', 1, '2023-10-28 15:24:52', '2023-10-28 15:24:52'),
(44, 'kkk', 'kkk', 76, 1, 'kk', 'kkk-pl7HBJ4OD5ZdcTw.jpg', 1, '2023-10-30 12:10:07', '2023-10-30 12:10:07'),
(45, 'test Category updated', 'test-category-updated', 7, 1, 'test Category Updated', 'test-category-updated-9BnBbM8EI8WxJqG.jpg', 1, '2023-10-31 10:58:41', '2023-10-31 11:11:40');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_10_21_174744_create_categories_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(76, 'App\\Models\\User', 1, 'admin@gmail.com', '6671d82269e89afd3245ef073e0e8bd691179c9cb3a15a2919c2ad0713992486', '[\"*\"]', '2023-10-31 11:25:18', NULL, '2023-10-24 09:41:04', '2023-10-31 11:25:18'),
(77, 'App\\Models\\User', 1, 'admin@gmail.com', 'a9ec9bbcfd7957d4f85aeafc7fce8092a50b134f902f232308fb3c81c3c5621c', '[\"*\"]', '2023-10-24 09:44:24', NULL, '2023-10-24 09:43:52', '2023-10-24 09:44:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `role_id` varchar(255) NOT NULL DEFAULT '2' COMMENT '1= Admin,2= Sales manager',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `photo`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '01738298777', NULL, '$2y$10$Kgh96M9eYOC1yb53iqyhueDwwVgh7vSMwSaAnEIfL4zxp1ltEvPCa', NULL, '1', NULL, '2023-10-15 11:50:02', '2023-10-15 11:50:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_user_id_foreign` (`user_id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
