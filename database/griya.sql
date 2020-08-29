-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 24, 2020 at 06:43 PM
-- Server version: 5.7.30-0ubuntu0.18.04.1
-- PHP Version: 7.2.28-3+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `griya`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(50) NOT NULL,
  `saldo` int(25) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `number`, `saldo`, `created_at`, `updated_at`) VALUES
(3, 'Bank Mandiri', '1620    0038    2620    7', 1000000, '2020-08-19 19:15:05', '2020-08-19 19:15:05'),
(4, 'Bank BNI', '100 000 000', 1500000, '2020-08-20 19:21:57', '2020-08-20 19:21:57'),
(6, 'Kas Perusahaan', '100 000 001', 100000000, '2020-08-21 16:45:04', '2020-08-21 16:45:04'),
(7, 'a', '1', 10, '2020-08-24 01:31:14', '2020-08-24 01:31:14');

-- --------------------------------------------------------

--
-- Table structure for table `clusters`
--

CREATE TABLE `clusters` (
  `id` int(10) UNSIGNED NOT NULL,
  `block` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clusters`
--

INSERT INTO `clusters` (`id`, `block`, `number`, `created_at`, `updated_at`) VALUES
(1, 'A', 1, '2020-08-20 05:14:23', NULL),
(3, 'B', 1, '2020-08-21 09:04:00', '2020-08-21 09:04:00'),
(4, 'A', 2, '2020-08-23 08:46:48', NULL),
(5, 'C', 1, '2020-08-23 20:03:24', '2020-08-23 20:03:24'),
(6, 'D', 1, '2020-08-24 01:47:35', '2020-08-24 01:47:35');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `state_id` int(10) UNSIGNED DEFAULT NULL,
  `cluster_id` int(10) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `method_payment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fee` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sale_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `state_id`, `cluster_id`, `date`, `name`, `phone`, `job`, `type`, `method_payment`, `fee`, `description`, `created_at`, `updated_at`, `sale_id`) VALUES
(1, NULL, NULL, '2020-08-21', 'Bukan Pelanggan', '081234567890', '-', '-', '-', '-', '-', '2020-08-21 16:17:06', NULL, NULL),
(4, 2, 1, '2020-08-21', 'Al Zidni', '081234567890', 'Mahasiswa', 'Subsidi', 'Kredit', 'half', '-', '2020-08-20 03:10:45', '2020-08-22 19:14:47', 1),
(10, 3, 3, '2020-08-21', 'A', '081234567890', 'a', 'Subsidi', 'Kredit', 'full', '-', '2020-08-21 09:29:19', '2020-08-21 09:34:39', 1),
(14, 1, 5, '2020-08-24', 'Al Zidni Kasim', '081234567812', 'Wiraswasta', 'Subsidi', 'Kredit', 'half', '-', '2020-08-23 20:11:11', '2020-08-23 20:15:36', 1),
(17, 3, 4, '2020-08-24', 'Al Zidni Kasim', '081234567812', 'Wiraswasta', 'Subsidi', 'Kredit', 'full', '-', '2020-08-23 20:13:29', '2020-08-23 20:14:46', 3);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `list_id` varchar(200) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `position` int(4) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `menu_id`, `name`, `link`, `list_id`, `icon`, `status`, `position`, `description`) VALUES
(16, 1, 'Beranda', 's-admin', 's-admin', 'home', 1, 1, '-'),
(21, 1, 'Menus', 'menus', 'menus', 'bars', 1, 1, '-'),
(22, 1, 'Role', 'roles', 'roles', 'user', 1, 1, '-'),
(23, 1, 'Users', 'users', 'users', 'users', 1, 1, '-'),
(24, 2, 'Beranda', 'home', 'home', 'home', 1, 1, 'Beranda'),
(25, 2, 'Users', 'users', 'users', 'users', 0, 100, 'users'),
(27, 2, 'Master Data', '#', 'setting', 'home', 1, 1, 'menu sales'),
(28, 27, 'Bank / Kas', 'account', 'account', 'home', 1, 1, 'bank'),
(29, 27, 'Unit', 'cluster', 'cluster', 'home', 1, 2, 'Blok Kluster'),
(30, 27, 'Sales', 'sales', 'sales', 'home', 1, 3, 'sales'),
(31, 2, 'Pelanggan', 'customer', 'customer', 'home', 1, 1, 'pelanggan'),
(32, 2, 'Transaksi', '#', 'transaction', 'home', 1, 1, 'List Transaksi'),
(33, 32, 'Kas Masuk', 'cash_in', 'cash_in', 'home', 1, 1, 'Kas Masuk'),
(34, 32, 'Kas Keluar', 'cash_out', 'cash_out', 'home', 1, 1, 'Kas Keluar'),
(35, 32, 'Kas Transfer', 'cash_transfer', 'cash_transfer', 'home', 1, 1, 'Kas Transfer'),
(36, 27, 'Tipe Pengeluaran', 'type', 'type', 'home', 1, 4, '-');

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
(61, '2014_10_12_000000_create_users_table', 1),
(62, '2014_10_12_100000_create_password_resets_table', 1),
(63, '2020_01_07_171747_create_roles_table', 1),
(64, '2020_01_07_171850_create_user_roles_table', 1),
(65, '2020_01_09_025853_create_menus_table', 2),
(66, '2020_01_11_160655_create_price_lists_table', 2),
(67, '2020_08_20_023828_create_accounts_table', 3),
(68, '2020_08_20_031552_create_sales_table', 4),
(69, '2020_08_20_043832_create_clusters_table', 5),
(70, '2020_08_20_044914_create_states_table', 5),
(71, '2020_08_20_044959_create_customers_table', 6),
(72, '2020_08_20_045917_add_sale_id_to_customers_table', 7),
(74, '2020_08_21_031205_create_transactions_table', 9),
(75, '2020_08_21_153531_create_types_table', 10),
(76, '2020_08_23_024224_create_orders_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `state_id` int(10) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `state_id`, `date`, `description`, `created_at`, `updated_at`) VALUES
(1, 4, 1, '2020-08-21 09:00:00', '-', '2020-08-23 03:10:34', NULL),
(2, 4, 2, '2020-08-23 03:14:47', 'Approve pemesanan untuk unit A1', '2020-08-22 19:14:47', '2020-08-22 19:14:47'),
(3, 10, 1, '2020-08-20 10:00:00', '-', '2020-08-23 03:20:11', NULL),
(4, 10, 3, '2020-08-23 10:00:00', 'Pemesanan untuk unit ini di Reject', '2020-08-23 03:20:11', NULL),
(5, 17, 1, '2020-08-24 12:15:00', '-', '2020-08-23 20:13:29', '2020-08-23 20:13:29'),
(6, 14, 1, '2020-08-24 12:15:00', '-', '2020-08-23 20:13:29', '2020-08-23 20:13:29'),
(7, 17, 3, '2020-08-24 04:14:46', 'Reject Pesanan', '2020-08-23 20:14:46', '2020-08-23 20:14:46');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, NULL),
(2, 'uadmin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(6, 1),
(8, 2),
(11, 13),
(12, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `name`, `phone`, `street`, `created_at`, `updated_at`) VALUES
(1, 'Sales 1', '081234567890', 'Jalan Saranani', '2020-08-20 03:43:10', NULL),
(3, 'Al Zidni', '081234567892', 'Puuwatu', '2020-08-23 17:44:01', '2020-08-23 17:44:01');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'On Process', '2020-08-20 05:53:10', NULL),
(2, 'Approve', '2020-08-20 05:53:10', NULL),
(3, 'Reject', '2020-08-20 05:53:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED DEFAULT NULL,
  `source_acc_id` int(10) UNSIGNED DEFAULT NULL,
  `destination_acc_id` int(10) UNSIGNED DEFAULT NULL,
  `type_id` int(10) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `total` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `customer_id`, `source_acc_id`, `destination_acc_id`, `type_id`, `date`, `total`, `description`, `created_at`, `updated_at`) VALUES
(1, NULL, 4, 3, 3, '2020-08-21 00:00:00', 500000, '-', '2020-08-21 03:22:28', NULL),
(2, 4, NULL, 3, 2, '2020-08-21 00:00:00', 1000000, '-', '2020-08-20 21:50:14', '2020-08-23 22:48:41'),
(3, NULL, 3, NULL, 4, '2020-08-21 00:00:00', 500000, '-', '2020-08-20 22:04:52', '2020-08-20 22:04:52'),
(4, 1, NULL, 6, 1, '2020-08-22 00:45:04', 100000000, 'Saldo Awal', '2020-08-21 16:45:04', '2020-08-21 16:45:04'),
(5, NULL, 6, NULL, 4, '2020-08-22 00:00:00', 100000, '-', NULL, NULL),
(6, 4, NULL, 3, 2, '2020-08-22 09:15:00', 100000, '-', '2020-08-21 17:08:41', '2020-08-21 17:08:41'),
(7, 4, NULL, 6, 2, '2020-08-22 21:15:00', 100000, '-', '2020-08-21 17:11:31', '2020-08-21 17:11:31'),
(8, 1, NULL, 7, 1, '2020-08-24 09:31:14', 10, 'Saldo Awal', '2020-08-24 01:31:14', '2020-08-24 01:31:14'),
(9, NULL, 4, 7, 3, '2020-08-24 11:15:00', 500000, '-', '2020-08-23 19:04:25', '2020-08-23 19:04:25'),
(15, 1, NULL, 4, 2, '2020-08-24 18:30:00', 1000000, '-', '2020-08-24 02:21:25', '2020-08-24 02:21:25');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Saldo Awal', '2020-08-21 08:04:12', '2020-08-21 08:04:12'),
(2, 'Payment', '2020-08-21 08:04:26', '2020-08-21 08:04:26'),
(3, 'Transfer', '2020-08-21 16:35:18', NULL),
(4, 'Bayar Listrik', '2020-08-21 08:19:16', '2020-08-21 08:19:16'),
(5, 'Bayar Sewa', '2020-08-23 20:03:45', '2020-08-23 20:03:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(6, 'sadmin', 'alan@alan.com', 'admin@admin.com', NULL, '$2y$10$I1SOCxcVI0CpsDqidpB7f.rQokSAjLq6jh9X2S7mlv8ddnjZ6UBp2', NULL, '2020-01-07 11:46:43', '2020-02-23 03:06:36'),
(8, 'alin', 'alin@alin.com', 'alin@alin.com', NULL, '$2y$10$TTIvtYFwzRwPiNXqKOt.i.1WpKDT2KdqS5CuhjEKZ5LD5P1xS26iC', NULL, '2020-01-11 05:25:50', '2020-01-11 07:35:38'),
(12, 'uadmin', 'admin_griya@gmail.com', 'admin_griya@gmail.com', NULL, '$2y$10$BAFuCHJE1I8Bd78U5rm22OYH3OBlnAnaUjBAvABwGHzqAM./tQR9G', NULL, '2020-08-18 18:23:54', '2020-08-18 18:23:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clusters`
--
ALTER TABLE `clusters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_state_id_foreign` (`state_id`),
  ADD KEY `customers_cluster_id_foreign` (`cluster_id`),
  ADD KEY `customers_sale_id_foreign` (`sale_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_state_id_foreign` (`state_id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_customer_id_foreign` (`customer_id`),
  ADD KEY `transactions_source_acc_id_foreign` (`source_acc_id`),
  ADD KEY `transactions_destionation_acc_id_foreign` (`destination_acc_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `clusters`
--
ALTER TABLE `clusters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_cluster_id_foreign` FOREIGN KEY (`cluster_id`) REFERENCES `clusters` (`id`),
  ADD CONSTRAINT `customers_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`),
  ADD CONSTRAINT `customers_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `orders_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `transactions_destionation_acc_id_foreign` FOREIGN KEY (`destination_acc_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`),
  ADD CONSTRAINT `transactions_source_acc_id_foreign` FOREIGN KEY (`source_acc_id`) REFERENCES `accounts` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
