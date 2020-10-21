-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2020 at 04:00 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `id_jenis` int(11) NOT NULL,
  `asal` int(11) NOT NULL,
  `tujuan` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `berat`, `panjang`, `lebar`, `tinggi`, `id_jenis`, `asal`, `tujuan`, `user_id`, `deleted_at`) VALUES
(38, 1, 3, 3, 2, 2, 5, 7, 5, '2020-10-19 01:19:21'),
(39, 1, 20, 20, 5, 2, 5, 7, 5, NULL),
(40, 2, 20, 10, 100, 2, 5, 8, 5, NULL),
(41, 1, 50, 60, 40, 2, 5, 7, 5, NULL),
(42, 2, 130, 200, 142, 2, 5, 8, 5, NULL),
(43, 1, 122, 123, 100, 2, 5, 7, 5, NULL),
(57, 2, 25, 25, 25, 1, 5, 5, 5, NULL),
(58, 12, 120, 120, 50, 1, 5, 6, 5, NULL),
(59, 10, 120, 120, 120, 1, 5, 7, 5, NULL),
(60, 12, 50, 50, 50, 1, 5, 7, 5, NULL),
(61, 4, 123, 125, 110, 1, 5, 9, 5, NULL),
(62, 2, 45, 45, 45, 1, 5, 8, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `id` int(11) NOT NULL,
  `jenis_barang` varchar(32) NOT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_barang`
--

INSERT INTO `jenis_barang` (`id`, `jenis_barang`, `deleted_at`) VALUES
(1, 'Pecah Belah', NULL),
(2, 'Packing Kayu', NULL),
(3, 'Makanan', '2020-05-01');

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
  ADD KEY `barang_ibfk_3` (`tujuan`),
  ADD KEY `id_jenis` (`id_jenis`);

--
-- Indexes for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
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
  ADD CONSTRAINT `barang_ibfk_3` FOREIGN KEY (`tujuan`) REFERENCES `stasiun` (`id`),
  ADD CONSTRAINT `barang_ibfk_4` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_barang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
