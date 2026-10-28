-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 27, 2026 at 03:29 PM
-- Server version: 8.0.46-cll-lve
-- PHP Version: 8.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bpombeng_kjk`
--

-- --------------------------------------------------------

--
-- Table structure for table `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `id_jenis` varchar(50) NOT NULL,
  `jenis_brg` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pemasukan`
--

CREATE TABLE `pemasukan` (
  `id` int NOT NULL,
  `unit` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kode_brg` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` int NOT NULL,
  `tgl_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id_pengajuan` int NOT NULL,
  `unit` varchar(100) NOT NULL,
  `kode_brg` varchar(7) NOT NULL,
  `id_jenis` int NOT NULL,
  `jumlah` int NOT NULL,
  `satuan` varchar(11) NOT NULL,
  `hargabarang` double NOT NULL,
  `total` double NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_sementara`
--

CREATE TABLE `pengajuan_sementara` (
  `id_pengajuan_sementara` int NOT NULL,
  `unit` varchar(100) NOT NULL,
  `kode_brg` varchar(7) NOT NULL,
  `id_jenis` int NOT NULL,
  `jumlah` int NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `hargabarang` double NOT NULL,
  `total` double NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id` int NOT NULL,
  `unit` varchar(100) NOT NULL,
  `kode_brg` varchar(7) NOT NULL,
  `jumlah` int NOT NULL,
  `tgl_keluar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permintaan`
--

CREATE TABLE `permintaan` (
  `id_permintaan` int NOT NULL,
  `unit` varchar(200) NOT NULL,
  `instansi` varchar(20) NOT NULL,
  `kode_brg` varchar(7) NOT NULL,
  `id_jenis` int NOT NULL,
  `jumlah` int NOT NULL,
  `keperluan` text NOT NULL,
  `tgl_permintaan` date NOT NULL,
  `no_surat` varchar(100) NOT NULL,
  `katim` int NOT NULL,
  `status` int NOT NULL,
  `rating` enum('nilai','buruk sekali','buruk','cukup','baik','baik sekali') NOT NULL DEFAULT 'nilai',
  `saran` text NOT NULL,
  `delivery_option` enum('diantarkan','diambil') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sementara`
--

CREATE TABLE `sementara` (
  `id_sementara` int NOT NULL,
  `unit` varchar(100) NOT NULL,
  `instansi` varchar(20) NOT NULL,
  `kode_brg` varchar(7) NOT NULL,
  `id_jenis` int NOT NULL,
  `jumlah` int NOT NULL,
  `keperluan` text NOT NULL,
  `tgl_permintaan` date NOT NULL,
  `no_surat` varchar(100) NOT NULL,
  `katim` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '0',
  `rating` varchar(100) NOT NULL DEFAULT 'nilai',
  `saran` text NOT NULL,
  `delivery_option` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stokbarang`
--

CREATE TABLE `stokbarang` (
  `id_kode_brg` int NOT NULL,
  `kode_brg` varchar(7) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_jenis` int NOT NULL,
  `nama_brg` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `satuan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `stok` int NOT NULL,
  `keluar` int NOT NULL,
  `sisa` int NOT NULL,
  `keterangan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `exp` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` bigint NOT NULL,
  `username` varchar(47) DEFAULT NULL,
  `password` varchar(33) DEFAULT NULL,
  `level` varchar(9) DEFAULT NULL,
  `jabatan` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id_pengajuan`);

--
-- Indexes for table `pengajuan_sementara`
--
ALTER TABLE `pengajuan_sementara`
  ADD PRIMARY KEY (`id_pengajuan_sementara`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permintaan`
--
ALTER TABLE `permintaan`
  ADD PRIMARY KEY (`id_permintaan`);

--
-- Indexes for table `sementara`
--
ALTER TABLE `sementara`
  ADD PRIMARY KEY (`id_sementara`);

--
-- Indexes for table `stokbarang`
--
ALTER TABLE `stokbarang`
  ADD PRIMARY KEY (`id_kode_brg`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pemasukan`
--
ALTER TABLE `pemasukan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id_pengajuan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=941;

--
-- AUTO_INCREMENT for table `pengajuan_sementara`
--
ALTER TABLE `pengajuan_sementara`
  MODIFY `id_pengajuan_sementara` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=941;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3077;

--
-- AUTO_INCREMENT for table `permintaan`
--
ALTER TABLE `permintaan`
  MODIFY `id_permintaan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3409;

--
-- AUTO_INCREMENT for table `sementara`
--
ALTER TABLE `sementara`
  MODIFY `id_sementara` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3409;

--
-- AUTO_INCREMENT for table `stokbarang`
--
ALTER TABLE `stokbarang`
  MODIFY `id_kode_brg` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1250;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
