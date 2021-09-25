-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 25, 2021 at 12:15 AM
-- Server version: 10.3.31-MariaDB-cll-lve
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u1114281_hidroponik`
--

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
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `komentar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `produk_id`, `user_id`, `komentar`, `rating`, `created_at`, `updated_at`) VALUES
(1, 15, 1, 'hmmm bagus sih', '5', '2021-09-04 08:08:06', '2021-09-04 08:08:06'),
(2, 2, 1, 'Hmm bagus sih', '3', '2021-09-04 08:59:13', '2021-09-04 08:59:13');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `path_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `produk_id`, `path_image`, `created_at`, `updated_at`) VALUES
(1, 1, 'http://hidroponik.mtsn4acehbesar.sch.id/gambar/1629038570_1.jpg', '2021-08-15 07:42:50', '2021-08-15 07:42:50'),
(2, 1, 'http://hidroponik.mtsn4acehbesar.sch.id/images/1629038594_1.jpg', '2021-08-15 07:43:14', '2021-08-15 07:43:14'),
(3, 1, 'http://hidroponik.mtsn4acehbesar.sch.id/images/1629038594_2.jpg', '2021-08-15 07:43:14', '2021-08-15 07:43:14'),
(4, 1, 'http://hidroponik.mtsn4acehbesar.sch.id/images/1629038594_3.jpg', '2021-08-15 07:43:14', '2021-08-15 07:43:14'),
(5, 1, 'http://hidroponik.mtsn4acehbesar.sch.id/images/1629038594_4.jpg', '2021-08-15 07:43:14', '2021-08-15 07:43:14'),
(6, 2, 'http://hidroponik.mtsn4acehbesar.sch.id/uploads/1629038927_dummy1629038888453.jpg', '2021-08-15 07:48:47', '2021-08-15 07:48:47'),
(7, 2, 'http://hidroponik.mtsn4acehbesar.sch.id/uploads/1629038927_dummy1629038901974.jpg', '2021-08-15 07:48:47', '2021-08-15 07:48:47'),
(8, 3, 'http://hidroponik.mtsn4acehbesar.sch.id/gambar/1629039324_4103276443.jpg', '2021-08-15 07:55:24', '2021-08-15 07:55:24'),
(9, 3, 'http://hidroponik.mtsn4acehbesar.sch.id/gambar/1629039324_Tanaman-Hidroponik-7.jpg', '2021-08-15 07:55:24', '2021-08-15 07:55:24'),
(10, 3, 'http://hidroponik.mtsn4acehbesar.sch.id/gambar/1629039324_TOMAT-1.jpg', '2021-08-15 07:55:24', '2021-08-15 07:55:24'),
(11, 4, 'http://hidroponik.mtsn4acehbesar.sch.id/gambar/1629039387_OIP (3).jpeg', '2021-08-15 07:56:27', '2021-08-15 07:56:27'),
(12, 4, 'http://hidroponik.mtsn4acehbesar.sch.id/gambar/1629039387_OIP (4).jpeg', '2021-08-15 07:56:27', '2021-08-15 07:56:27'),
(13, 4, 'http://hidroponik.mtsn4acehbesar.sch.id/gambar/1629039387_stroberi-hidroponik_169.jpeg', '2021-08-15 07:56:27', '2021-08-15 07:56:27'),
(14, 5, 'http://hidroponik.mtsn4acehbesar.sch.id/uploads/1629080818_dummy1629080805315.jpg', '2021-08-15 19:26:58', '2021-08-15 19:26:58'),
(15, 6, 'http://hidroponik.mtsn4acehbesar.sch.id/gambar/1629345627_Manfaat-Sawi-Hijau.jpg', '2021-08-18 21:00:27', '2021-08-18 21:00:27'),
(16, 6, 'http://hidroponik.mtsn4acehbesar.sch.id/gambar/1629345627_OIP (1).jpeg', '2021-08-18 21:00:27', '2021-08-18 21:00:27'),
(17, 6, 'http://hidroponik.mtsn4acehbesar.sch.id/gambar/1629345627_sami.jpg', '2021-08-18 21:00:27', '2021-08-18 21:00:27'),
(18, 6, 'http://hidroponik.mtsn4acehbesar.sch.id/images/1629345681_2791644.png', '2021-08-18 21:01:21', '2021-08-18 21:01:21'),
(19, 8, 'http://hidroponik.mtsn4acehbesar.sch.id/uploads/1629728811_4a54455fb700f257258da63e28495c72.jpg', '2021-08-23 07:26:51', '2021-08-23 07:26:51'),
(20, 9, 'http://hidroponik.mtsn4acehbesar.sch.id/uploads/1629728900_dummy1629728886850.jpg', '2021-08-23 07:28:20', '2021-08-23 07:28:20'),
(21, 10, 'http://hidroponik.mtsn4acehbesar.sch.id/uploads/1629952158_dummy1629952097362.jpg', '2021-08-25 21:29:18', '2021-08-25 21:29:18'),
(22, 10, 'http://hidroponik.mtsn4acehbesar.sch.id/uploads/1629952158_dummy1629952101947.jpg', '2021-08-25 21:29:18', '2021-08-25 21:29:18'),
(23, 11, 'http://hidroponik.mtsn4acehbesar.sch.id/uploads/1629955076_dummy1629955042610.jpg', '2021-08-25 22:17:56', '2021-08-25 22:17:56'),
(24, 12, 'http://hidroponik.mtsn4acehbesar.sch.id/uploads/1629955664_dummy1629955638955.jpg', '2021-08-25 22:27:44', '2021-08-25 22:27:44'),
(25, 13, 'http://hidroponik.mtsn4acehbesar.sch.id/uploads/1629956298_dummy1629956287730.jpg', '2021-08-25 22:38:18', '2021-08-25 22:38:18'),
(26, 14, 'http://hidroponik.mtsn4acehbesar.sch.id/uploads/1629958042_dummy1629958032299.jpg', '2021-08-25 23:07:22', '2021-08-25 23:07:22'),
(28, 15, 'http://hidroponik.mtsn4acehbesar.sch.id/uploads/1631954395_dummy1631954389515.jpg', '2021-09-18 01:39:55', '2021-09-18 01:39:55');

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
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2021_05_04_075256_create_promos_table', 1),
(5, '2021_05_05_051044_create_users_table', 1),
(6, '2021_05_08_080807_create_produks_table', 1),
(7, '2021_06_17_140117_create_table_orders', 1),
(8, '2021_06_17_160807_create_table_reports', 1),
(9, '2021_07_18_042747_create_images_table', 1),
(10, '2021_07_18_042757_create_notificationtokens_table', 1),
(11, '2021_07_29_090936_create_feedbacks_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification_tokens`
--

CREATE TABLE `notification_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `notificationToken` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_tokens`
--

INSERT INTO `notification_tokens` (`id`, `user_id`, `notificationToken`, `created_at`, `updated_at`) VALUES
(1, 1, 'ExponentPushToken[5N086SPToodXJ2f5pxmUHI]', '2021-08-14 21:46:34', '2021-08-14 21:46:34'),
(2, 4, 'ExponentPushToken[pIgFlqKIkkt9dR38OkX0uk]', '2021-08-14 21:54:56', '2021-08-14 21:54:56'),
(4, 1, 'ExponentPushToken[ImG3VHIH_Jvzz4uXw5CZMT]', '2021-08-24 07:44:55', '2021-08-24 07:44:55'),
(5, 3, 'ExponentPushToken[pO1a_JNYaPyCfjjY3-Yf-W]', '2021-09-12 10:55:52', '2021-09-12 10:55:52'),
(6, 14, 'ExponentPushToken[1pC1oXGDrd14swv1IOnYwD]', '2021-09-12 10:57:01', '2021-09-12 10:57:01');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pembeli_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status_checkout` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_order` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date DEFAULT NULL,
  `harga_jasa_pengiriman` int(5) NOT NULL DEFAULT 0 COMMENT 'Ini harga ongkir yaa. defaultnya 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `pembeli_id`, `produk_id`, `jumlah`, `total_harga`, `status_checkout`, `status_order`, `tanggal`, `harga_jasa_pengiriman`, `created_at`, `updated_at`) VALUES
(16, 1, 4, 1, 25000, 'Beli', 'Selesai', NULL, 2000, '2021-08-26 00:04:54', '2021-09-23 08:33:36'),
(18, 1, 2, 2, 100000, 'Beli', 'Selesai', NULL, 5000, '2021-08-26 00:25:17', '2021-09-23 08:38:15'),
(19, 1, 15, 1, 5000, 'Beli', 'Batal', NULL, 0, '2021-08-26 00:34:35', '2021-09-01 00:48:02'),
(20, 1, 4, 1, 25000, 'Beli', 'Diproses', NULL, 0, '2021-08-26 01:49:31', '2021-08-26 01:49:41'),
(21, 1, 15, 5, 25000, 'Beli', 'Selesai', NULL, 0, '2021-08-26 01:57:20', '2021-09-04 03:45:35'),
(22, 1, 2, 1, 50000, 'Beli', 'Belum', NULL, 9000, '2021-08-26 02:02:39', '2021-09-24 09:37:51'),
(31, 1, 2, 1, 50000, 'Beli', 'Belum', NULL, 5000, '2021-08-29 00:30:39', '2021-09-24 09:06:35'),
(35, 14, 2, 5, 250000, 'Beli', 'Selesai', NULL, 0, '2021-09-12 10:57:29', '2021-09-12 11:01:14'),
(36, 1, 4, 2, 50000, 'Beli', 'Belum', NULL, 0, '2021-09-18 01:50:45', '2021-09-18 01:51:00'),
(37, 1, 2, 2, 100000, 'keranjang', 'Belum', NULL, 0, '2021-09-18 01:51:26', '2021-09-18 01:51:31');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produks`
--

CREATE TABLE `produks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penjual_id` bigint(20) UNSIGNED NOT NULL,
  `promo_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `total_feedback` int(11) NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produks`
--

INSERT INTO `produks` (`id`, `penjual_id`, `promo_id`, `nama`, `harga`, `stok`, `total_feedback`, `keterangan`, `created_at`, `updated_at`) VALUES
(2, 2, NULL, 'Tomat', 50000, 50, 3, 'ket', '2021-08-15 07:48:47', '2021-09-12 10:59:45'),
(4, 2, NULL, 'Stroberi', 25000, 10, 0, NULL, '2021-08-15 07:56:27', '2021-09-18 01:51:00'),
(15, 13, NULL, 'Cabai', 5005, 5000, 5, 'Yayayaya', '2021-08-25 23:16:02', '2021-09-18 01:43:39');

-- --------------------------------------------------------

--
-- Table structure for table `promos`
--

CREATE TABLE `promos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `potongan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `periode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pembeli_id` bigint(20) UNSIGNED NOT NULL,
  `penjual_id` bigint(20) UNSIGNED NOT NULL,
  `isi_laporan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `pembeli_id`, `penjual_id`, `isi_laporan`, `tanggal`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'peliiittttt', '2021-09-22', '2021-09-22 07:21:02', '2021-09-22 07:21:02'),
(2, 1, 2, 'Mau testing api nya', '2021-09-22', '2021-09-22 08:44:30', '2021-09-22 08:44:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) DEFAULT 1,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama_lengkap`, `username`, `email`, `nomor_hp`, `password`, `status`, `alamat`, `level`, `profile_image`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'yaumil', 'yaumil', 'yaumil@gmail.com', '082377812738', '$2y$10$hhJajIgdvbJoKUVArb85DeEungyvTrpFvVXmsOnxwJQ59EgSKOLb6', 1, 'Jln teuku', 'pembeli', NULL, NULL, NULL, '2021-08-05 08:07:05', '2021-08-05 08:08:23'),
(2, 'Liza Maiyuni', 'lizashop', 'liza@gmail.com', '08527635763', '$2y$10$hhJajIgdvbJoKUVArb85DeEungyvTrpFvVXmsOnxwJQ59EgSKOLb6', 1, 'energy', 'penjual', 'http://hidroponik.mtsn4acehbesar.sch.id/images/1632299012_dummy1632299008993.jpg', NULL, NULL, '2021-08-08 05:41:37', '2021-09-22 01:35:21'),
(3, 'aqil', 'aqil', 'aqil@gmail.com', '829378', '$2y$10$0Sv516CmR5twW9BAhZ1oaejgfU0umH/ZgrNym39LGYj.7h./sUN3a', 1, '', 'pembeli', NULL, NULL, NULL, '2021-08-14 21:43:41', '2021-08-14 21:43:41'),
(4, 'aqilfiqrN', 'aqilfiqran', 'tes@gmail.com', '737373', '$2y$10$txS7CozhpfWGdEcYPXq0t.0exo3IdFoAC1IU06yMQE2hKftmEJnoW', 1, 'Jsjsj', 'pembeli', NULL, NULL, NULL, '2021-08-14 21:54:17', '2021-08-14 21:54:36'),
(5, 'belajar', 'belajar', 'belajar@gmail.com', '737272', '$2y$10$/iKZq6bxoQI3ir2qTyXj6uRDI2l29kMRuQgPFb1uAqkpH/UMjSABa', 1, 'Hshshshs', 'pembeli', NULL, NULL, NULL, '2021-08-15 08:24:01', '2021-08-15 08:24:08'),
(6, 'Kausar', 'Kausar123', 'kausar@gmail.com', '084736262616', '$2y$10$BG1uLduoZsMt2k.0WBTPleh8iXwLOWk2RkoymfIcgAPssxecGbleS', 1, 'Darussalam', 'superadmin', 'http://hidroponik.mtsn4acehbesar.sch.id/images/images (1).jpeg', NULL, NULL, '2021-08-15 08:25:15', '2021-08-18 06:05:16'),
(7, 'tes aja', 'tes', 'tes2@gmail.com', '123547489', '$2y$10$jCm4xo2xLaac9sjEW7IRzOMUTySjDu6nqu6503H82LM3dwPdJQ1wq', 1, 'Batoh', 'pembeli', NULL, NULL, NULL, '2021-08-15 19:17:54', '2021-08-15 19:18:15'),
(8, 'm kausar', 'mkausar', 'mkausar@gmail.com', '09676875674', '$2y$10$hhJajIgdvbJoKUVArb85DeEungyvTrpFvVXmsOnxwJQ59EgSKOLb6', 1, 'rumah', 'superadmin', NULL, NULL, NULL, NULL, NULL),
(9, 'admin', 'admin123', 'admin@gmail.com', NULL, '$2y$10$zIc287oWXXQ87oiMtlNXxelQEIFNdg6SRaiNKtb1T83Kecg89cjb.', 1, NULL, 'admin', NULL, NULL, NULL, '2021-08-18 06:51:17', '2021-08-18 06:51:17'),
(10, 'Testing pagi', 'Pagi', 'pagi@gmail.com', '1363838', '$2y$10$4NCpom6Tw3kUNzu67zP6vu7Gz8MoahMCFXsZM/mKxT4Zc1GNmw1nC', 1, 'Rumaaah', 'pembeli', NULL, NULL, NULL, '2021-08-18 18:59:24', '2021-08-18 18:59:31'),
(11, 'seller hidroponik', 'Kausar123', 'mhdkautsar@mail.com', '082353264326', '$2y$10$REbW/GEDZBbAXSkJqF68YOX89LFqoAF7qMavJ6ITUwBA83KoUAlHi', 1, 'Kuala Namu', 'admin', 'http://hidroponik.mtsn4acehbesar.sch.id/images/team-1-800x800.fa5a7ac2.jpg', NULL, NULL, '2021-08-18 20:39:24', '2021-08-18 20:56:42'),
(13, 'seller', 'seller123', 'seller@gmail.com', NULL, '$2y$10$RxWgJvyvGCQmbOGhO.871.rQNg881qI4Z5B6t007AlW8rWRIFdaGq', 1, NULL, 'penjual', NULL, NULL, NULL, '2021-08-18 20:54:51', '2021-08-18 20:54:51'),
(14, 'Aqila', 'aqila', 'aqila@gmail.com', 'Seeempak', '$2y$10$T7aX/aoBFoqpnYtCXJF4zu5kbwgMkvTUZdoTLAgg0p6NK/V6htdda', 1, 'Batoh', 'pembeli', NULL, NULL, NULL, '2021-09-12 10:56:32', '2021-09-12 10:56:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedbacks_produk_id_foreign` (`produk_id`),
  ADD KEY `feedbacks_user_id_foreign` (`user_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_tokens`
--
ALTER TABLE `notification_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_pembeli_id_foreign` (`pembeli_id`),
  ADD KEY `orders_produk_id_foreign` (`produk_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `produks`
--
ALTER TABLE `produks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produks_penjual_id_foreign` (`penjual_id`),
  ADD KEY `produks_promo_id_foreign` (`promo_id`);

--
-- Indexes for table `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_pembeli_id_foreign` (`pembeli_id`),
  ADD KEY `reports_penjual_id_foreign` (`penjual_id`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notification_tokens`
--
ALTER TABLE `notification_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produks`
--
ALTER TABLE `produks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `feedbacks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_pembeli_id_foreign` FOREIGN KEY (`pembeli_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produks`
--
ALTER TABLE `produks`
  ADD CONSTRAINT `produks_penjual_id_foreign` FOREIGN KEY (`penjual_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produks_promo_id_foreign` FOREIGN KEY (`promo_id`) REFERENCES `promos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_pembeli_id_foreign` FOREIGN KEY (`pembeli_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_penjual_id_foreign` FOREIGN KEY (`penjual_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
