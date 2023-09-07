-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2023 at 06:11 AM
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
-- Database: `projek_akbar`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `tahun` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama_barang`, `type`, `tahun`, `jumlah`, `code`, `gambar`, `created_at`, `updated_at`) VALUES
(23, 'Es Teh 2014', 'Sariwangi', 2014, 21, '23201408', 'Screenshot (50).png', '2023-08-22 19:55:32', '2023-08-23 19:21:39'),
(25, 'Kopi 2010', 'Kapal Api', 2010, 15, '25201008', 'Screenshot (52).png', '2023-08-22 19:56:03', '2023-08-22 22:55:22'),
(28, 'Air Putih 2001', 'Aqua', 2001, 10, '28200108', 'Screenshot (103).png', '2023-08-22 22:54:38', '2023-08-22 22:57:10');

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_barang_id` bigint(20) UNSIGNED NOT NULL,
  `jumlahkeluar` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `kode_barang_keluar` text NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `hp` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id`, `nama_barang_id`, `jumlahkeluar`, `keterangan`, `kode_barang_keluar`, `nama`, `jabatan`, `hp`, `created_at`, `updated_at`) VALUES
(143, 23, 15, 'afk', '232014081,232014082,232014083,232014084,232014085,232014086,232014087,232014088,232014089,2320140810,2320140811,2320140812,2320140813,2320140814,2320140815', 'Akbar', 'Pemimpin Perang Dunia Ke Tiga', '081234567895', '2023-08-22 22:55:52', '2023-08-22 22:55:52'),
(144, 28, 7, 'okey', '282001081,282001082,282001083,282001084,282001085,282001086,282001087', 'Akbar', 'Pemimpin Perang Dunia Ke Tiga', '081234567895', '2023-08-22 22:57:10', '2023-08-22 22:57:10');

-- --------------------------------------------------------

--
-- Table structure for table `barang_kembali`
--

CREATE TABLE `barang_kembali` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_barang_id` bigint(20) UNSIGNED NOT NULL,
  `jumlahkembali` int(11) NOT NULL,
  `status` enum('Baik','Rusak') NOT NULL,
  `kode_barang_kembali` text NOT NULL,
  `keterangan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang_kembali`
--

INSERT INTO `barang_kembali` (`id`, `nama_barang_id`, `jumlahkembali`, `status`, `kode_barang_kembali`, `keterangan`, `created_at`, `updated_at`) VALUES
(40, 23, 5, 'Baik', '232014081,232014082,232014083,232014084,232014085', 'Test', '2023-08-23 17:37:34', '2023-08-23 17:37:34'),
(41, 23, 1, 'Rusak', '232014086', 'ssssssss', '2023-08-23 19:20:32', '2023-08-23 19:20:32');

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_barang_id` bigint(20) UNSIGNED NOT NULL,
  `jumlahmasuk` int(11) NOT NULL,
  `kode_barang_masuk` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id`, `nama_barang_id`, `jumlahmasuk`, `kode_barang_masuk`, `created_at`, `updated_at`) VALUES
(64, 23, 20, '232014081,232014082,232014083,232014084,232014085,232014086,232014087,232014088,232014089,2320140810,2320140811,2320140812,2320140813,2320140814,2320140815,2320140816,2320140817,2320140818,2320140819,2320140820', '2023-08-22 22:55:11', '2023-08-22 22:55:11'),
(65, 25, 15, '252010081,252010082,252010083,252010084,252010085,252010086,252010087,252010088,252010089,2520100810,2520100811,2520100812,2520100813,2520100814,2520100815', '2023-08-22 22:55:22', '2023-08-22 22:55:22'),
(66, 28, 17, '282001081,282001082,282001083,282001084,282001085,282001086,282001087,282001088,282001089,2820010810,2820010811,2820010812,2820010813,2820010814,2820010815,2820010816,2820010817', '2023-08-22 22:55:35', '2023-08-22 22:55:35'),
(69, 23, 1, '2320140821', '2023-08-23 19:21:39', '2023-08-23 19:21:39');

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
-- Table structure for table `kode_barang`
--

CREATE TABLE `kode_barang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_barang_id` bigint(20) UNSIGNED DEFAULT NULL,
  `barang_keluar_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('Tersedia','Keluar','Tidak Bisa Digunakan') NOT NULL DEFAULT 'Tersedia',
  `keterangan` text NOT NULL DEFAULT 'Tersedia',
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kode_barang`
--

INSERT INTO `kode_barang` (`id`, `nama_barang_id`, `barang_keluar_id`, `status`, `keterangan`, `code`, `created_at`, `updated_at`) VALUES
(3252, 23, 143, 'Tersedia', 'Tersedia', '232014081', '2023-08-22 22:55:11', '2023-08-23 17:37:34'),
(3253, 23, 143, 'Tersedia', 'Tersedia', '232014082', '2023-08-22 22:55:11', '2023-08-23 17:37:34'),
(3254, 23, 143, 'Tersedia', 'Tersedia', '232014083', '2023-08-22 22:55:11', '2023-08-23 17:37:34'),
(3255, 23, 143, 'Tersedia', 'Tersedia', '232014084', '2023-08-22 22:55:11', '2023-08-23 17:37:34'),
(3256, 23, 143, 'Tersedia', 'Tersedia', '232014085', '2023-08-22 22:55:11', '2023-08-23 17:37:34'),
(3257, 23, 143, 'Tidak Bisa Digunakan', 'ssssssss', '232014086', '2023-08-22 22:55:11', '2023-08-23 19:20:32'),
(3258, 23, 143, 'Keluar', 'afk', '232014087', '2023-08-22 22:55:11', '2023-08-22 22:55:52'),
(3259, 23, 143, 'Keluar', 'afk', '232014088', '2023-08-22 22:55:11', '2023-08-22 22:55:52'),
(3260, 23, 143, 'Keluar', 'afk', '232014089', '2023-08-22 22:55:11', '2023-08-22 22:55:52'),
(3261, 23, 143, 'Keluar', 'afk', '2320140810', '2023-08-22 22:55:11', '2023-08-22 22:55:52'),
(3262, 23, 143, 'Keluar', 'afk', '2320140811', '2023-08-22 22:55:11', '2023-08-22 22:55:52'),
(3263, 23, 143, 'Keluar', 'afk', '2320140812', '2023-08-22 22:55:11', '2023-08-22 22:55:52'),
(3264, 23, 143, 'Keluar', 'afk', '2320140813', '2023-08-22 22:55:11', '2023-08-22 22:55:52'),
(3265, 23, 143, 'Keluar', 'afk', '2320140814', '2023-08-22 22:55:11', '2023-08-22 22:55:52'),
(3266, 23, 143, 'Keluar', 'afk', '2320140815', '2023-08-22 22:55:11', '2023-08-22 22:55:52'),
(3267, 23, NULL, 'Tersedia', 'Tersedia', '2320140816', '2023-08-22 22:55:11', '2023-08-22 22:55:11'),
(3268, 23, NULL, 'Tersedia', 'Tersedia', '2320140817', '2023-08-22 22:55:11', '2023-08-22 22:55:11'),
(3269, 23, NULL, 'Tersedia', 'Tersedia', '2320140818', '2023-08-22 22:55:11', '2023-08-22 22:55:11'),
(3270, 23, NULL, 'Tersedia', 'Tersedia', '2320140819', '2023-08-22 22:55:11', '2023-08-22 22:55:11'),
(3271, 23, NULL, 'Tersedia', 'Tersedia', '2320140820', '2023-08-22 22:55:11', '2023-08-22 22:55:11'),
(3272, 25, NULL, 'Tersedia', 'Tersedia', '252010081', '2023-08-22 22:55:22', '2023-08-22 22:55:22'),
(3273, 25, NULL, 'Tersedia', 'Tersedia', '252010082', '2023-08-22 22:55:22', '2023-08-22 22:55:22'),
(3274, 25, NULL, 'Tersedia', 'Tersedia', '252010083', '2023-08-22 22:55:22', '2023-08-22 22:55:22'),
(3275, 25, NULL, 'Tersedia', 'Tersedia', '252010084', '2023-08-22 22:55:22', '2023-08-22 22:55:22'),
(3276, 25, NULL, 'Tersedia', 'Tersedia', '252010085', '2023-08-22 22:55:22', '2023-08-22 22:55:22'),
(3277, 25, NULL, 'Tersedia', 'Tersedia', '252010086', '2023-08-22 22:55:22', '2023-08-22 22:55:22'),
(3278, 25, NULL, 'Tersedia', 'Tersedia', '252010087', '2023-08-22 22:55:22', '2023-08-22 22:55:22'),
(3279, 25, NULL, 'Tersedia', 'Tersedia', '252010088', '2023-08-22 22:55:22', '2023-08-22 22:55:22'),
(3280, 25, NULL, 'Tersedia', 'Tersedia', '252010089', '2023-08-22 22:55:22', '2023-08-22 22:55:22'),
(3281, 25, NULL, 'Tersedia', 'Tersedia', '2520100810', '2023-08-22 22:55:22', '2023-08-22 22:55:22'),
(3282, 25, NULL, 'Tersedia', 'Tersedia', '2520100811', '2023-08-22 22:55:22', '2023-08-22 22:55:22'),
(3283, 25, NULL, 'Tersedia', 'Tersedia', '2520100812', '2023-08-22 22:55:22', '2023-08-22 22:55:22'),
(3284, 25, NULL, 'Tersedia', 'Tersedia', '2520100813', '2023-08-22 22:55:22', '2023-08-22 22:55:22'),
(3285, 25, NULL, 'Tersedia', 'Tersedia', '2520100814', '2023-08-22 22:55:22', '2023-08-22 22:55:22'),
(3286, 25, NULL, 'Tersedia', 'Tersedia', '2520100815', '2023-08-22 22:55:22', '2023-08-22 22:55:22'),
(3287, 28, 144, 'Keluar', 'okey', '282001081', '2023-08-22 22:55:35', '2023-08-23 16:34:15'),
(3288, 28, 144, 'Keluar', 'okey', '282001082', '2023-08-22 22:55:35', '2023-08-23 16:34:15'),
(3289, 28, 144, 'Keluar', 'okey', '282001083', '2023-08-22 22:55:35', '2023-08-22 22:57:10'),
(3290, 28, 144, 'Keluar', 'okey', '282001084', '2023-08-22 22:55:35', '2023-08-22 22:57:10'),
(3291, 28, 144, 'Keluar', 'okey', '282001085', '2023-08-22 22:55:35', '2023-08-22 22:57:10'),
(3292, 28, 144, 'Keluar', 'okey', '282001086', '2023-08-22 22:55:35', '2023-08-22 22:57:10'),
(3293, 28, 144, 'Keluar', 'okey', '282001087', '2023-08-22 22:55:35', '2023-08-22 22:57:10'),
(3294, 28, NULL, 'Tersedia', 'Tersedia', '282001088', '2023-08-22 22:55:35', '2023-08-22 22:55:35'),
(3295, 28, NULL, 'Tersedia', 'Tersedia', '282001089', '2023-08-22 22:55:35', '2023-08-22 22:55:35'),
(3296, 28, NULL, 'Tersedia', 'Tersedia', '2820010810', '2023-08-22 22:55:35', '2023-08-22 22:55:35'),
(3297, 28, NULL, 'Tersedia', 'Tersedia', '2820010811', '2023-08-22 22:55:35', '2023-08-22 22:55:35'),
(3298, 28, NULL, 'Tersedia', 'Tersedia', '2820010812', '2023-08-22 22:55:35', '2023-08-22 22:55:35'),
(3299, 28, NULL, 'Tersedia', 'Tersedia', '2820010813', '2023-08-22 22:55:35', '2023-08-22 22:55:35'),
(3300, 28, NULL, 'Tersedia', 'Tersedia', '2820010814', '2023-08-22 22:55:35', '2023-08-22 22:55:35'),
(3301, 28, NULL, 'Tersedia', 'Tersedia', '2820010815', '2023-08-22 22:55:35', '2023-08-22 22:55:35'),
(3302, 28, NULL, 'Tersedia', 'Tersedia', '2820010816', '2023-08-22 22:55:35', '2023-08-22 22:55:35'),
(3303, 28, NULL, 'Tersedia', 'Tersedia', '2820010817', '2023-08-22 22:55:35', '2023-08-22 22:55:35'),
(4309, 23, NULL, 'Tersedia', 'Tersedia', '2320140821', '2023-08-23 19:21:39', '2023-08-23 19:21:39');

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
(8, '2014_10_12_000000_create_users_table', 1),
(9, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(10, '2019_08_19_000000_create_failed_jobs_table', 1),
(11, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(12, '2023_07_05_003926_pembuatan_user', 1),
(13, '2023_07_10_023835_barang', 1),
(14, '2023_07_10_060239_barang_masuk', 1),
(15, '2023_07_12_055634_barang_keluar', 1),
(18, '2023_07_13_041634_kode_barang', 2),
(22, '2014_10_12_100000_create_password_resets_table', 3),
(25, '2023_07_20_005542_barang_kembali', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `hp` varchar(255) NOT NULL,
  `role` enum('admin','karyawan','atasan') NOT NULL DEFAULT 'karyawan',
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `jabatan`, `hp`, `role`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(6, 'Akbar', 'Pemimpin Perang Dunia Ke Tiga', '081234567895', 'admin', 'akbar@gmail.com', NULL, '$2y$10$cqreGb0iotAAwwXoQ7zFheFHLGe3RpmFKkK9SFZUZRVvnYn8Fyk4.', '4afjgqyvvyWRFSG2lGOEHy7PdbduSiTt1OHIViTbvxzYJ1IjVFqxga1ZOwhn', '2023-08-22 21:15:22', '2023-08-22 22:02:49'),
(13, 'Azazel', 'Pemimpin Neraka', '081234567809', 'atasan', 'sarah@gmail.com', NULL, '$2y$10$hRmYGwIW85NQ4KTUiVYNi.BHJp5jkv5GKuz9mKlq91TpSHuudHrA6', NULL, '2023-08-22 21:47:01', '2023-08-22 22:14:55'),
(14, 'Adolf Hitler', 'Veteran Perang Dunia 1', '081234509876', 'karyawan', 'Hitler@gmail.com', NULL, '$2y$10$rgAdWNz0n45fYGuXly5J2eyyke/IdZjscQTrWWI9LWdQShZIC7L.K', NULL, '2023-08-22 21:49:28', '2023-08-22 21:49:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_keluar_nama_barang_id_foreign` (`nama_barang_id`);

--
-- Indexes for table `barang_kembali`
--
ALTER TABLE `barang_kembali`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_kembali_nama_barang_id_foreign` (`nama_barang_id`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_masuk_nama_barang_id_foreign` (`nama_barang_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kode_barang`
--
ALTER TABLE `kode_barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Unique` (`code`),
  ADD KEY `kode_barang_nama_barang_id_foreign` (`nama_barang_id`),
  ADD KEY `kode_barang_barang_keluar_id_foreign` (`barang_keluar_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `barang_kembali`
--
ALTER TABLE `barang_kembali`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kode_barang`
--
ALTER TABLE `kode_barang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4310;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `barang_keluar_nama_barang_id_foreign` FOREIGN KEY (`nama_barang_id`) REFERENCES `barang` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `barang_kembali`
--
ALTER TABLE `barang_kembali`
  ADD CONSTRAINT `barang_kembali_nama_barang_id_foreign` FOREIGN KEY (`nama_barang_id`) REFERENCES `barang` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_nama_barang_id_foreign` FOREIGN KEY (`nama_barang_id`) REFERENCES `barang` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kode_barang`
--
ALTER TABLE `kode_barang`
  ADD CONSTRAINT `kode_barang_barang_keluar_id_foreign` FOREIGN KEY (`barang_keluar_id`) REFERENCES `barang_keluar` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kode_barang_nama_barang_id_foreign` FOREIGN KEY (`nama_barang_id`) REFERENCES `barang` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
