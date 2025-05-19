-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2025 at 04:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` varchar(12) NOT NULL,
  `nm_ptgs` varchar(255) NOT NULL,
  `tgl` date NOT NULL,
  `almt` varchar(255) NOT NULL,
  `tlp` bigint(15) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pas` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cust`
--

CREATE TABLE `cust` (
  `id_cust` int(12) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cust`
--

INSERT INTO `cust` (`id_cust`, `nama`, `email`, `password`, `no_hp`) VALUES
(2, '', 'ppp@hakha.com', '$2y$10$UEvRmZzLPGzyJFpXMMty3.BXJ7NnOCPEgHmxuJ21mJ.WEHzJ1L.yC', '');

-- --------------------------------------------------------

--
-- Table structure for table `kmr`
--

CREATE TABLE `kmr` (
  `idkmr` int(12) NOT NULL,
  `nokmr` varchar(5) NOT NULL,
  `tipe` varchar(255) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `kap` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `fasilitas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kmr`
--

INSERT INTO `kmr` (`idkmr`, `nokmr`, `tipe`, `harga`, `kap`, `status`, `fasilitas`) VALUES
(6, '0001', 'Deluxe Room', 500000, '2', 'Kosong', 'Air conditioner, shower air panas/dingin, TV LED 32 inci, Brankas kecil'),
(7, '0002', 'Deluxe Room', 500000, '2', 'Terisi', 'Air conditioner, shower air panas/dingin, TV LED 32 inci, Brankas kecil'),
(8, '001', 'Luxury Room', 1000000, '3', 'Kosong', 'Air conditioner, shower air panas/dingin, TV LED 32 inci, Brankas kecil, Mesin kopi espresso dan pilihan teh premium'),
(9, '002', 'Luxury Room', 1000000, '3', 'Terisi', 'Air conditioner, shower air panas/dingin, TV LED 32 inci, Brankas kecil, Mesin kopi espresso dan pilihan teh premium'),
(10, '01', 'Supreme Deluxe Room', 1500000, '5', 'Kosong', 'Air conditioner, shower air panas/dingin, TV LED 32 inci, Brankas kecil, Mesin kopi espresso dan pilihan teh premium, Minibar lengkap dengan minuman premium dan snack gourmet\r\n'),
(11, '02', 'Supreme Deluxe Room', 1500000, '5', 'Terisi', 'Air conditioner, shower air panas/dingin, TV LED 32 inci, Brankas kecil, Mesin kopi espresso dan pilihan teh premium, Minibar lengkap dengan minuman premium dan snack gourmet\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_trans` int(11) NOT NULL,
  `no_kmr` int(11) NOT NULL,
  `fasilitas` varchar(255) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `id_cust` int(12) NOT NULL,
  `tipe_kmr` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cust`
--
ALTER TABLE `cust`
  ADD PRIMARY KEY (`id_cust`);

--
-- Indexes for table `kmr`
--
ALTER TABLE `kmr`
  ADD PRIMARY KEY (`idkmr`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_trans`),
  ADD KEY `id_cust` (`id_cust`),
  ADD KEY `no_kmr` (`no_kmr`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cust`
--
ALTER TABLE `cust`
  MODIFY `id_cust` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kmr`
--
ALTER TABLE `kmr`
  MODIFY `idkmr` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
