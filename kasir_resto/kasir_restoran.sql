-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2025 at 03:14 PM
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
-- Database: `kasir_restoran`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `iddetail` int(11) NOT NULL,
  `idpesanan` int(11) DEFAULT NULL,
  `idmenu` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meja`
--

CREATE TABLE `meja` (
  `idmeja` int(11) NOT NULL,
  `nomormeja` int(11) NOT NULL,
  `status` enum('kosong','terisi') DEFAULT 'kosong',
  `namameja` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meja`
--

INSERT INTO `meja` (`idmeja`, `nomormeja`, `status`, `namameja`) VALUES
(19, 1, 'kosong', 'sunflower');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `idmenu` int(11) NOT NULL,
  `namamenu` char(50) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`idmenu`, `namamenu`, `harga`) VALUES
(20, 'Caramel macchiato', 30000);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `idpelanggan` int(11) NOT NULL,
  `namapelanggan` char(50) DEFAULT NULL,
  `jeniskelamin` tinyint(1) DEFAULT NULL,
  `nohp` char(15) DEFAULT NULL,
  `alamat` char(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`idpelanggan`, `namapelanggan`, `jeniskelamin`, `nohp`, `alamat`) VALUES
(1, 'Tabah', 0, '08564323467', 'jakarta'),
(2, 'Tabah', 0, '08543466334', 'jakarta'),
(3, 'gawjaw', 0, '086423565424', 'jakarta'),
(4, 'gawjaw', 0, '08653476563', 'jakarta'),
(5, 'rudjaw', 0, '087754656', 'jakarta'),
(6, 'Tabah', 0, '0987864646', 'jakarta'),
(7, 'Tabah', 0, '08564323467', 'jakarta'),
(8, 'ayam', 0, '087654319', 'jakarta'),
(9, 'ayam', 1, '08987654321', 'jakarta'),
(10, 'ayam', 0, '08987654321', 'jakarta'),
(11, 'ayam', 0, '08987654321', 'jakarta'),
(12, 'ayam', 0, '08987654321', 'jakarta'),
(13, 'ayam', 0, '08987654321', 'jakarta'),
(14, 'ayam', 0, '08987654321', 'jakarta'),
(15, 'ayam', 0, '08987654321', 'jakarta'),
(16, 'ayam', 0, '08987654321', 'jakarta'),
(17, 'ayam', 0, '08987654321', 'jakarta'),
(18, 'ayam', 0, '08987654321', 'jakarta'),
(19, 'ayam', 0, '08987654321', 'jakarta'),
(20, 'ayam', 0, '08987654321', 'jakarta'),
(21, 'ayam', 1, '08987654321', 'jakarta'),
(22, 'ayam', 0, '08987654321', 'jakarta'),
(23, 'ayam', 0, '08987654321', 'jakarta'),
(24, 'ayam', 0, '08987654321', 'jakarta'),
(25, 'ayam', 0, '08987654321', 'jakarta'),
(26, 'ayam', 0, '08987654321', 'jakarta'),
(27, 'ayam', 1, '08987654321', 'jakarta'),
(28, 'Tabah', 1, '08987654321', 'jakarta'),
(29, 'ayam', 1, '08987654321', ''),
(30, 'ayam', 1, '08987654321', 'jakarta'),
(31, 'ayam', 0, '08987654321', 'jakarta'),
(32, 'Tabah', 0, '08987654321', 'jakarta'),
(33, 'ayam', 0, '08987654321', 'jakarta'),
(34, 'ayam', 0, '08987654321', 'Jl. H rafii sarpin'),
(35, 'ayam', 1, '08987654321', 'jakarta'),
(36, 'ayam', 0, '08987654321', 'jakarta'),
(37, 'ayam', 0, '08987654321', 'jakarta'),
(38, 'ayam', 1, '08987654321', 'jakarta'),
(39, 'ayam', 1, '08987654321', 'jakarta'),
(40, 'ayam', 0, '08987654321', 'jakarta'),
(41, 'ayam', 0, '08987654321', 'jakarta'),
(42, 'ayam', 1, '08987654321', 'jakarta'),
(43, 'ayam', 1, '08987654321', 'jakarta'),
(44, 'ayam', 1, '08987654321', 'jakarta'),
(45, 'ayam', 0, '08987654321', 'jakarta'),
(46, 'ayam', 1, '08987654321', 'jakarta'),
(47, 'ayam', 0, '08987654321', 'jakarta'),
(48, 'ayam', 0, '08987654321', ''),
(49, 'ayam', 0, '08987654321', 'jakarta'),
(50, 'ayam', 1, '08987654321', 'jakarta'),
(51, 'ayam', 0, '08987654321', 'jakarta'),
(52, 'ayam', 0, '08987654321', 'jakarta'),
(53, 'ayam', 0, '08987654321', 'jakarta');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `idpesanan` int(11) NOT NULL,
  `idmeja` int(11) DEFAULT NULL,
  `idpelanggan` int(11) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `idtransaksi` int(11) NOT NULL,
  `idpesanan` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `bayar` int(11) DEFAULT NULL,
  `kembalian` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `iduser` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `iduser` int(11) NOT NULL,
  `namauser` char(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','waiter','kasir','owner') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`iduser`, `namauser`, `password`, `role`) VALUES
(2, 'admin', 'admin123', 'admin'),
(3, 'waiter', 'waiter123', 'waiter'),
(4, 'kasir', 'kasir123', 'kasir'),
(5, 'owner', 'owner123', 'owner');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`iddetail`),
  ADD KEY `idpesanan` (`idpesanan`),
  ADD KEY `idmenu` (`idmenu`);

--
-- Indexes for table `meja`
--
ALTER TABLE `meja`
  ADD PRIMARY KEY (`idmeja`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idmenu`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`idpelanggan`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`idpesanan`),
  ADD KEY `idmeja` (`idmeja`),
  ADD KEY `idpelanggan` (`idpelanggan`),
  ADD KEY `iduser` (`iduser`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`idtransaksi`),
  ADD KEY `idpesanan` (`idpesanan`),
  ADD KEY `iduser` (`iduser`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `iddetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `meja`
--
ALTER TABLE `meja`
  MODIFY `idmeja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `idmenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `idpelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `idpesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `idtransaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`idpesanan`) REFERENCES `pesanan` (`idpesanan`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`idmenu`) REFERENCES `menu` (`idmenu`);

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`idmeja`) REFERENCES `meja` (`idmeja`),
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`idpelanggan`) REFERENCES `pelanggan` (`idpelanggan`),
  ADD CONSTRAINT `pesanan_ibfk_3` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`idpesanan`) REFERENCES `pesanan` (`idpesanan`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
