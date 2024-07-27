-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 27 Jul 2024 pada 11.02
-- Versi server: 10.11.8-MariaDB-cll-lve
-- Versi PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u688631693_gudangku`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `namaBarang` varchar(32) NOT NULL,
  `waktu` datetime DEFAULT NULL,
  `nama_mesin` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `hapus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mesin`
--

CREATE TABLE `mesin` (
  `id_mesin` int(11) NOT NULL,
  `nama_mesin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mesin`
--

INSERT INTO `mesin` (`id_mesin`, `nama_mesin`) VALUES
(2, 'Mesin 1'),
(3, 'Mesin 2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `tgl_transaksi` datetime NOT NULL,
  `nama_costumer` varchar(100) NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `no_mobil` varchar(15) NOT NULL,
  `nama_supir` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `metode_bayar` enum('cash','credit') NOT NULL,
  `shift` enum('pagi','malam') NOT NULL,
  `status` enum('pengajuan','antrian','jalan','batal','acc') NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `nama_admin` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `tgl_transaksi`, `nama_costumer`, `tujuan`, `qty`, `no_mobil`, `nama_supir`, `no_hp`, `metode_bayar`, `shift`, `status`, `id_barang`, `nama_admin`) VALUES
(9, '2024-07-27 18:00:35', '1', 'Bekasi', 1, 'BA 1010 ACS', 'Budi', '082165443677', 'cash', 'pagi', 'acc', 38, 'Admin Kantor');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `rule` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `password`, `rule`) VALUES
(1, 'Admin Kantor', '$2y$10$yuPmzFjZKTHojkqnWote0Ob.jR4M9PbRwgN7FrkXs8Z.CLw0ygA86', '1'),
(2, 'Admin Gudang', '$2y$10$q95JNtXMWaoZFTmOxWYwOeNcL3iRyELos94.9SBvpWXZqQ4OvPfpC', '0'),
(3, 'Budi', '$2y$10$pOpahwYrIbRt8Hrj4rcO/eEQSrKTl4k6dTqB79uYDMXda3QqcXU8u', '0');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mesin`
--
ALTER TABLE `mesin`
  ADD PRIMARY KEY (`id_mesin`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `mesin`
--
ALTER TABLE `mesin`
  MODIFY `id_mesin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
