-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 06, 2021 at 11:17 AM
-- Server version: 8.0.22-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kelurahan`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggaran`
--

CREATE TABLE `anggaran` (
  `id` int NOT NULL,
  `kode` varchar(255) NOT NULL,
  `kegiatan` varchar(255) NOT NULL,
  `anggaran` varchar(255) NOT NULL,
  `volume` varchar(255) NOT NULL,
  `bulan_realisasi` varchar(255) NOT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `anggaran`
--

INSERT INTO `anggaran` (`id`, `kode`, `kegiatan`, `anggaran`, `volume`, `bulan_realisasi`, `created_at`) VALUES
(1, '001', 'pulpen', '100000', '2', '[\"Februari\",\"April\",\"November\",\"Desember\"]', '2020-01-02'),
(3, '002', 'spidol', '100000', '2', '[\"Mei\",\"November\"]', NULL),
(4, '003', 'jancok', '100000', '3', '[\"Januari\",\"Maret\",\"November\"]', NULL),
(6, '00008', 'pelatihan', '100000', '4', '[\"Januari\",\"April\",\"Agustus\",\"November\"]', NULL),
(7, '0009', 'training', '100000', '2', '[\"Januari\",\"Oktober\"]', '2021-01-02');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'administrator'),
(2, 'member');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `kode` varchar(255) NOT NULL,
  `kegiatan` varchar(255) NOT NULL,
  `pengeluaran` varchar(255) NOT NULL,
  `created_at` date DEFAULT NULL,
  `update_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `kode`, `kegiatan`, `pengeluaran`, `created_at`, `update_at`) VALUES
(1, '001', 'pulpen', '10000', '2020-05-13', NULL),
(3, '002', 'spidol', '10000', '2020-11-14', NULL),
(4, '001', 'pulpen', '10000', '2020-11-28', NULL),
(5, '001', 'pulpen', '10000', '2020-12-17', NULL),
(10, '00008', 'pelatihan', '1000', '2021-01-02', NULL),
(11, '0009', 'training', '1000', '2021-01-04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `role_id` int NOT NULL,
  `is_active` int NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `images`, `role_id`, `is_active`, `create_at`) VALUES
(1, 'TES', 'testing@mail.com', '$2y$10$ALfFMrqwHlmwY4mc3NL.a.yXeCwkHaL8M7XEImJld7MBirVXvHrQ2', '', 2, 1, '0000-00-00 00:00:00'),
(2, 'administrator', 'admin@admin.com', '$2y$10$ALfFMrqwHlmwY4mc3NL.a.yXeCwkHaL8M7XEImJld7MBirVXvHrQ2', '', 1, 1, '2020-11-08 13:58:31'),
(3, 'YUDHA', 'tugas.6357@gmail.com', '$2y$10$ALfFMrqwHlmwY4mc3NL.a.yXeCwkHaL8M7XEImJld7MBirVXvHrQ2', '', 2, 1, '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggaran`
--
ALTER TABLE `anggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
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
-- AUTO_INCREMENT for table `anggaran`
--
ALTER TABLE `anggaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
