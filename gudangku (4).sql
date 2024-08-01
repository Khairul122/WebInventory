-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 01, 2024 at 10:37 PM
-- Server version: 8.0.30
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gudangku`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int NOT NULL,
  `namaBarang` varchar(32) NOT NULL,
  `waktu` datetime DEFAULT NULL,
  `nama_mesin` varchar(50) NOT NULL,
  `qty` int NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `hapus` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `namaBarang`, `waktu`, `nama_mesin`, `qty`, `stok`, `hapus`) VALUES
(29, 'Pupuk ADS', '2024-07-27 15:01:08', 'Mesin 1', 10, 5, 0),
(41, 'Pupuk ADS', '2024-07-27 15:37:19', 'Mesin 1', 10, 15, 0),
(42, 'Pupuk ADS', '2024-07-27 16:13:53', 'Mesin 1', 10, 10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mesin`
--

CREATE TABLE `mesin` (
  `id_mesin` int NOT NULL,
  `nama_mesin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mesin`
--

INSERT INTO `mesin` (`id_mesin`, `nama_mesin`) VALUES
(2, 'Mesin 1');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int NOT NULL,
  `tgl_transaksi` datetime NOT NULL,
  `nama_costumer` varchar(100) NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `qty` int NOT NULL,
  `no_mobil` varchar(15) NOT NULL,
  `nama_supir` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `metode_bayar` enum('cash','credit') NOT NULL,
  `shift` enum('pagi','malam') NOT NULL,
  `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_barang` int DEFAULT NULL,
  `nama_admin` varchar(255) DEFAULT NULL,
  `is_checked` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `tgl_transaksi`, `nama_costumer`, `tujuan`, `qty`, `no_mobil`, `nama_supir`, `no_hp`, `metode_bayar`, `shift`, `status`, `id_barang`, `nama_admin`, `is_checked`) VALUES
(16, '2024-08-02 02:05:04', 'Budi', 'Hendra', 1, 'BA 1010 ACS', 'Hendra', '082165443677', 'cash', 'pagi', 'acc', 42, 'Admin Kantor', 0),
(17, '2024-08-02 02:09:07', 'Budi', 'Bekasi Barat', 1, 'BA 2020 ACS', 'Hendrawan', '082165443677', 'cash', 'pagi', 'terkirim', 42, NULL, 0),
(18, '2024-08-02 05:22:46', 'CIka', 'Bekasi', 1, 'BA 3030 ACS', 'Hendra', '082165443677', 'cash', 'pagi', 'pengajuan', 42, NULL, 0),
(19, '2024-08-02 05:30:58', 'Haris', 'Bekasi', 1, 'BA 1010 ACS', 'Hendra', '082165443677', 'cash', 'pagi', 'on proses', 42, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `nama` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `rule` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `password`, `rule`) VALUES
(1, 'Admin Kantor', '$2y$10$yuPmzFjZKTHojkqnWote0Ob.jR4M9PbRwgN7FrkXs8Z.CLw0ygA86', '1'),
(2, 'Admin Gudang', '$2y$10$q95JNtXMWaoZFTmOxWYwOeNcL3iRyELos94.9SBvpWXZqQ4OvPfpC', '0'),
(3, 'Budi', '$2y$10$pOpahwYrIbRt8Hrj4rcO/eEQSrKTl4k6dTqB79uYDMXda3QqcXU8u', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mesin`
--
ALTER TABLE `mesin`
  ADD PRIMARY KEY (`id_mesin`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `fk_barang` (`id_barang`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `mesin`
--
ALTER TABLE `mesin`
  MODIFY `id_mesin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
