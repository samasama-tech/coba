-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 04:49 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cust`
--

CREATE TABLE `cust` (
  `id_cust` int(12) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cust`
--

INSERT INTO `cust` (`id_cust`, `username`, `email`, `password`, `no_hp`) VALUES
(2, '', 'ppp@hakha.com', '$2y$10$UEvRmZzLPGzyJFpXMMty3.BXJ7NnOCPEgHmxuJ21mJ.WEHzJ1L.yC', ''),
(8, 'alek', 'ppp@gamil.com', '$2y$10$Nk8kurKyQXw3uwCWFCPe5uc.DLS3M4y.8BfXS/3/CE/W0K3Is2CVa', ''),
(9, 'lpkojihug', 'hhh@jhk.com', '$2y$10$XDOL59fn8fRYc4egNdfWQuSWHykNWI4EaHPXsDFgkeYH5KMlQ2sYG', '');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kmr`
--

INSERT INTO `kmr` (`idkmr`, `nokmr`, `tipe`, `harga`, `kap`, `status`, `fasilitas`) VALUES
(12, '001', 'Deluxe Room', 600000, '2', '', 'king bed,wifi,ac,luas 28m²'),
(13, '002', 'Deluxe Room', 600000, '2', '', 'king bed,wifi,ac,luas 28m²'),
(14, '003', 'Deluxe Room', 600000, '2', '', 'king bed,wifi,ac,luas 28m²'),
(15, '004', 'Deluxe Room', 600000, '2', '', 'king bed,wifi,ac,luas 28m²'),
(16, '005', 'Deluxe Room', 600000, '2', '', 'king bed,wifi,ac,luas 28m²'),
(17, '011', 'Standar Room', 500000, '1', '', 'twin bed,wifi,ac,luas 20m²'),
(18, '012', 'Standar Room', 500000, '1', '', 'twin bed,wifi,ac,luas 20m²'),
(19, '013', 'Standar Room', 500000, '1', '', 'twin bed,wifi,ac,luas 20m²'),
(20, '014', 'Standar Room', 500000, '1', '', 'twin bed,wifi,ac,luas 20m²'),
(21, '015', 'Standar Room', 500000, '1', '', 'twin bed,wifi,ac,luas 20m²'),
(22, '021', 'Executive Room', 700000, '2', '', 'double bed,wifi,ac,luas 32m²'),
(25, '022', 'Executive Room', 700000, '2', '', 'double bed,wifi,ac,luas 32m²'),
(26, '023', 'Executive Room', 700000, '2', '', 'double bed,wifi,ac,luas 32m²'),
(27, '024', 'Executive Room', 700000, '2', '', 'double bed,wifi,ac,luas 32m²'),
(28, '025', 'Executive Room', 700000, '2', '', 'double bed,wifi,ac,luas 32m²');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  MODIFY `id_cust` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kmr`
--
ALTER TABLE `kmr`
  MODIFY `idkmr` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
