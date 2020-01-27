-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 27, 2020 at 05:22 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ki8`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `berat` int(11) NOT NULL,
  `panjang` int(11) NOT NULL,
  `lebar` int(11) NOT NULL,
  `tinggi` int(11) NOT NULL,
  `asal` int(11) NOT NULL,
  `tujuan` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `berat`, `panjang`, `lebar`, `tinggi`, `asal`, `tujuan`, `user_id`, `deleted_at`) VALUES
(1, 1, 120, 100, 80, 7, 6, 5, NULL),
(2, 1, 140, 120, 90, 7, 6, 5, NULL),
(3, 1, 90, 80, 70, 5, 6, 5, NULL),
(4, 2, 80, 90, 120, 5, 7, 5, NULL),
(5, 2, 70, 80, 85, 5, 7, 5, NULL),
(6, 3, 150, 140, 50, 5, 5, 5, NULL),
(7, 5, 120, 140, 100, 5, 5, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_rute`
--

CREATE TABLE `detail_rute` (
  `id` int(11) NOT NULL,
  `id_rute` int(11) NOT NULL,
  `id_stasiun` int(11) NOT NULL,
  `urutan` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_rute`
--

INSERT INTO `detail_rute` (`id`, `id_rute`, `id_stasiun`, `urutan`, `deleted_at`) VALUES
(1, 1, 5, 0, NULL),
(2, 1, 7, 1, NULL),
(9, 2, 5, 0, NULL),
(10, 2, 7, 1, NULL),
(11, 3, 5, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kontainer`
--

CREATE TABLE `kontainer` (
  `id` int(11) NOT NULL,
  `panjang` int(11) NOT NULL,
  `lebar` int(11) NOT NULL,
  `tinggi` int(11) NOT NULL,
  `berat_maksimal` int(11) NOT NULL,
  `rute_id` int(11) NOT NULL,
  `tanggal_digunakan` date NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kontainer`
--

INSERT INTO `kontainer` (`id`, `panjang`, `lebar`, `tinggi`, `berat_maksimal`, `rute_id`, `tanggal_digunakan`, `deleted_at`) VALUES
(1, 11, 12, 12, 1, 2, '2019-09-05', NULL),
(2, 13, 12, 11, 1, 2, '2019-09-05', NULL),
(3, 13, 14, 11, 1, 2, '2019-09-05', NULL),
(4, 13, 14, 16, 1, 2, '2019-09-05', NULL),
(5, 10, 3, 3, 80, 1, '2019-10-24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `penataan`
--

CREATE TABLE `penataan` (
  `id` int(11) NOT NULL,
  `id_kontainer` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rute`
--

CREATE TABLE `rute` (
  `id` int(11) NOT NULL,
  `nama_rute` varchar(32) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rute`
--

INSERT INTO `rute` (`id`, `nama_rute`, `deleted_at`) VALUES
(1, '1', NULL),
(2, '2', NULL),
(3, '3', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stasiun`
--

CREATE TABLE `stasiun` (
  `id` int(11) NOT NULL,
  `kota` varchar(32) NOT NULL,
  `nama_stasiun` varchar(32) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stasiun`
--

INSERT INTO `stasiun` (`id`, `kota`, `nama_stasiun`, `deleted_at`) VALUES
(5, 'Banyuwangi', 'Kalibaru', NULL),
(6, 'Malang', 'Malang Kota', NULL),
(7, 'Lumajang', 'Klakah', NULL),
(8, 'Jember', 'Kalisat', NULL),
(9, 'Pasuruan', 'Pasuruan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `id_stasiun` int(32) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'petugas',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `id_stasiun`, `status`, `deleted_at`) VALUES
(5, 'petugas', '123456', 'syamsR', 5, 'petugas', NULL),
(6, 'admin', '123456', 'admin', 0, 'admin', NULL),
(8, 'bambang', '123456', 'bambank', 5, 'petugas', '2019-12-09 03:24:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`user_id`),
  ADD KEY `barang_ibfk_2` (`asal`),
  ADD KEY `barang_ibfk_3` (`tujuan`);

--
-- Indexes for table `detail_rute`
--
ALTER TABLE `detail_rute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_rute` (`id_rute`),
  ADD KEY `id_stasiun` (`id_stasiun`);

--
-- Indexes for table `kontainer`
--
ALTER TABLE `kontainer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rute_id` (`rute_id`);

--
-- Indexes for table `penataan`
--
ALTER TABLE `penataan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_kontainer` (`id_kontainer`);

--
-- Indexes for table `rute`
--
ALTER TABLE `rute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stasiun`
--
ALTER TABLE `stasiun`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_stasiun` (`nama_stasiun`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `detail_rute`
--
ALTER TABLE `detail_rute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `kontainer`
--
ALTER TABLE `kontainer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penataan`
--
ALTER TABLE `penataan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rute`
--
ALTER TABLE `rute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stasiun`
--
ALTER TABLE `stasiun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`asal`) REFERENCES `stasiun` (`id`),
  ADD CONSTRAINT `barang_ibfk_3` FOREIGN KEY (`tujuan`) REFERENCES `stasiun` (`id`);

--
-- Constraints for table `detail_rute`
--
ALTER TABLE `detail_rute`
  ADD CONSTRAINT `detail_rute_ibfk_1` FOREIGN KEY (`id_rute`) REFERENCES `rute` (`id`),
  ADD CONSTRAINT `detail_rute_ibfk_2` FOREIGN KEY (`id_stasiun`) REFERENCES `stasiun` (`id`);

--
-- Constraints for table `kontainer`
--
ALTER TABLE `kontainer`
  ADD CONSTRAINT `kontainer_ibfk_1` FOREIGN KEY (`rute_id`) REFERENCES `rute` (`id`);

--
-- Constraints for table `penataan`
--
ALTER TABLE `penataan`
  ADD CONSTRAINT `penataan_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`),
  ADD CONSTRAINT `penataan_ibfk_2` FOREIGN KEY (`id_kontainer`) REFERENCES `kontainer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
