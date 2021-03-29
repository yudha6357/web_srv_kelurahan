-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2021 at 08:50 AM
-- Server version: 10.5.9-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kelurahan_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggaran`
--

CREATE TABLE `anggaran` (
  `id` int(11) NOT NULL,
  `kode` varchar(255) NOT NULL,
  `kegiatan` varchar(255) NOT NULL,
  `anggaran` varchar(255) NOT NULL,
  `volume` varchar(255) NOT NULL,
  `tahun` int(11) DEFAULT NULL,
  `bulan_realisasi` varchar(255) NOT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `anggaran`
--

INSERT INTO `anggaran` (`id`, `kode`, `kegiatan`, `anggaran`, `volume`, `tahun`, `bulan_realisasi`, `created_at`) VALUES
(1, '5.2.2.20.04', 'Bj. Pemeliharaan Mesin Ketik', '410000', '2', 1, '[\"Februari\",\"Mei\"]', '2021-01-20'),
(3, '5.2.2.20.11', 'Bj. Pemeliharaan Komputer', '200000', '4', 1, '[\"Februari\",\"April\",\"Juni\",\"Agustus\"]', '2021-01-20'),
(4, '5.2.2.02.07', 'Bj. Perkap Rumah Tangga', '3415000', '1', 1, '[\"Maret\"]', '2021-01-20'),
(6, '5.2.2.01.05', 'Bj. Perkap Kebersihan', '2582000', '1', 1, '[\"Februari\"]', '2021-01-20'),
(7, '5.2.2.03.03', 'Bj Listrik', '1000000', '12', 1, '[\"Januari\",\"Februari\",\"Maret\",\"April\",\"Mei\",\"Juni\",\"Juli\",\"Agustus\",\"September\",\"Oktober\",\"November\",\"Desember\"]', '2021-01-20'),
(11, '5.2.2.01.01', 'Bj. ATK', '6285750', '1', 1, '[\"Februari\"]', '2021-01-20'),
(12, '002.024.5.2.2.05.01', 'Bj. Servis kendaraan dinas', '100000', '4', 1, '[\"Maret\",\"Juni\",\"Oktober\",\"November\"]', '2021-01-20'),
(13, '5.2.2.03.01', 'Bj. Telpon', '100000', '12', 1, '[\"Januari\",\"Februari\",\"Maret\",\"April\",\"Mei\",\"Juni\",\"Juli\",\"Agustus\",\"September\",\"Oktober\",\"November\",\"Desember\"]', '2021-01-20'),
(14, '5.2.2.03.02', 'Bj, Air', '100000', '12', 1, '[\"Januari\",\"Februari\",\"Maret\",\"April\",\"Mei\",\"Juni\",\"Juli\",\"Agustus\",\"September\",\"Oktober\",\"November\",\"Desember\"]', '2021-01-20'),
(15, '5.2.2.01.04', 'Bj. Materai', '75000', '12', 1, '[\"Januari\",\"Februari\",\"Maret\",\"April\",\"Mei\",\"Juni\",\"Juli\",\"Agustus\",\"September\",\"Oktober\",\"November\",\"Desember\"]', '2021-01-20'),
(16, '5.2.2.02.06', 'Bj. Bahan Komputer', '435000', '6', 1, '[\"Februari\",\"April\",\"Juni\",\"Agustus\",\"September\",\"November\"]', '2021-01-20'),
(17, '019.5.2.2.20.04', 'Bj. Pemeliharaan AC', '260000', '2', 1, '[\"Maret\",\"Oktober\"]', '2021-01-20'),
(18, '019.5.2.2.01.03', 'Bj, Alat Listrik', '3650000', '1', 1, '[\"Maret\"]', '2021-01-20'),
(19, '5.2.2.06.02', 'Bj. Fotocopy', '500000', '12', 1, '[\"Januari\",\"Februari\",\"Maret\",\"April\",\"Mei\",\"Juni\",\"Juli\",\"Agustus\",\"September\",\"Oktober\",\"November\",\"Desember\"]', '2021-01-20'),
(20, '002.024.5.2.2.05.04', 'Bj, BBM Pertamax', '200000', '12', 1, '[\"Januari\",\"Februari\",\"Maret\",\"April\",\"Mei\",\"Juni\",\"Juli\",\"Agustus\",\"September\",\"Oktober\",\"November\",\"Desember\"]', '2021-01-20'),
(28, '5.2.2.11.07', 'Bj. Makan Minum Harian', '214000', '11', 1, '[\"Januari\",\"Februari\",\"Maret\",\"April\",\"Mei\",\"Juni\",\"Juli\",\"Agustus\",\"September\",\"Oktober\",\"November\"]', '2021-03-28');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'administrator'),
(2, 'operator');

-- --------------------------------------------------------

--
-- Table structure for table `tahun`
--

CREATE TABLE `tahun` (
  `id` int(11) NOT NULL,
  `tahun` varchar(15) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tahun`
--

INSERT INTO `tahun` (`id`, `tahun`, `is_active`, `created_at`) VALUES
(1, '2021', 1, '2021-01-30');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `kode` varchar(255) NOT NULL,
  `kegiatan` varchar(255) NOT NULL,
  `pengeluaran` varchar(255) NOT NULL,
  `tahun` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `update_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `kode`, `kegiatan`, `pengeluaran`, `tahun`, `tanggal`, `created_at`, `update_at`) VALUES
(17, '5.2.2.03.03', 'Bj Listrik', '983750', 1, '2021-03-27', '2021-03-27', NULL),
(25, '5.2.2.03.01', 'Bj. Telpon', '96000', 1, '2021-01-29', '2021-01-30', NULL),
(26, '5.2.2.03.01', 'Bj. Telpon', '90000', 1, '2021-02-02', '2021-03-19', NULL),
(28, '5.2.2.20.04.88', 'Bj Rumah Tangga', '90000', 1, '2021-03-27', '2021-03-27', NULL),
(29, '5.2.2.20.04', 'Bj. Pemeliharaan Mesin Ketik', '390000', 1, '2021-02-17', '2021-03-28', NULL),
(30, '5.2.2.02.07', 'Bj. Perkap Rumah Tangga', '3395500', 1, '2021-03-01', '2021-03-28', NULL),
(31, '002.024.5.2.2.05.01', 'Bj. Servis kendaraan dinas', '98000', 1, '2021-03-19', '2021-03-28', NULL),
(32, '5.2.2.03.02', 'Bj, Air', '89000', 1, '2021-03-17', '2021-03-28', NULL),
(33, '5.2.2.01.04', 'Bj. Materai', '75000', 1, '2021-03-09', '2021-03-28', NULL),
(34, '019.5.2.2.20.04', 'Bj. Pemeliharaan AC', '256000', 1, '2021-03-02', '2021-03-28', NULL),
(35, '019.5.2.2.01.03', 'Bj, Alat Listrik', '3637000', 1, '2021-03-12', '2021-03-28', NULL),
(36, '5.2.2.06.02', 'Bj. Fotocopy', '498000', 1, '2021-03-26', '2021-03-28', NULL),
(37, '002.024.5.2.2.05.04', 'Bj, BBM Pertamax', '180000', 1, '2021-03-26', '2021-03-28', NULL),
(38, '5.2.2.11.07', 'Bj. Makan Minum Harian', '214000', 1, '2021-03-03', '2021-03-28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `images`, `role_id`, `is_active`, `create_at`) VALUES
(1, 'TES 1', 'testing1@mail.com', '1234', '', 2, 1, '0000-00-00 00:00:00'),
(2, 'administrator', 'admin@admin.com', '$2y$10$ALfFMrqwHlmwY4mc3NL.a.yXeCwkHaL8M7XEImJld7MBirVXvHrQ2', '', 1, 1, '2020-11-08 13:58:31'),
(3, 'YUDHA', 'tugas.6357@gmail.com', '$2y$10$ALfFMrqwHlmwY4mc3NL.a.yXeCwkHaL8M7XEImJld7MBirVXvHrQ2', '', 2, 1, '0000-00-00 00:00:00'),
(5, 'mfauzan', 'mfauzan.albaihaqi@gmail.com', '$2y$10$KWAPyE8A1SdxEwEsgZ4SbOZQl5fb8GrP4fNF6YLn2qiuo4/n4n0i6', '', 2, 1, '0000-00-00 00:00:00');

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
-- Indexes for table `tahun`
--
ALTER TABLE `tahun`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tahun`
--
ALTER TABLE `tahun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
