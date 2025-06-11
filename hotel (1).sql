-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2025 at 04:59 PM
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
  `id_admin` int(12) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` bigint(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `email`, `password`, `no_hp`) VALUES
(1, 'Keysa', 'keysa@gmail.com', '1', 123),
(3, 'irul', 'irul@gmail.com', '123', 989887678),
(19, 'adnan', 'adonan@gmail.com', '1', 897654389);

-- --------------------------------------------------------

--
-- Table structure for table `cust`
--

CREATE TABLE `cust` (
  `id_cust` int(12) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `role` enum('customer','admin') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cust`
--

INSERT INTO `cust` (`id_cust`, `username`, `email`, `password`, `no_hp`, `role`) VALUES
(1, 'Keysa', 'keysa@gmail.com', '1', '123', 'admin'),
(3, 'irul', 'irul@gmail.com', '123', '0989887678', 'admin'),
(12, 'alek', 'hhaihdijw@knjec.knscs', '1', '1234', 'customer'),
(13, 'lpkojihug', 'ppp@gamil.com', '1', '12', 'customer'),
(19, 'adnan', 'adonan@gmail.com', '1', '897654389', 'admin');

--
-- Triggers `cust`
--
DELIMITER $$
CREATE TRIGGER `after_insert_admin` AFTER INSERT ON `cust` FOR EACH ROW BEGIN
    IF NEW.role = 'admin' THEN
        INSERT INTO admin (id_admin, username, email, password, no_hp)
        VALUES (NEW.id_cust, NEW.username, NEW.email, NEW.password, NEW.no_hp);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_admin_after_cust_delete` AFTER DELETE ON `cust` FOR EACH ROW BEGIN
  DELETE FROM admin WHERE id_admin = OLD.id_cust;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_admin_after_cust_update` AFTER UPDATE ON `cust` FOR EACH ROW BEGIN
  UPDATE admin 
  SET 
    username = NEW.username, 
    email = NEW.email,
    no_hp = NEW.no_hp
  WHERE id_admin = NEW.id_cust;
END
$$
DELIMITER ;

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
(12, '001', 'Deluxe Room', 600000, '2', 'Terisi', 'double bed,wifi,ac,luas 28m²'),
(13, '002', 'Deluxe Room', 600000, '2', 'Terisi', 'double bed,wifi,ac,luas 28m²'),
(14, '003', 'Deluxe Room', 600000, '2', 'Kosong', 'double bed,wifi,ac,luas 28m²'),
(15, '004', 'Deluxe Room', 600000, '2', 'Kosong', 'double bed,wifi,ac,luas 28m²'),
(16, '005', 'Deluxe Room', 600000, '2', 'Kosong', 'double bed,wifi,ac,luas 28m²'),
(17, '011', 'Suite Room', 500000, '1', 'Terisi', 'twin bed,wifi,ac,luas 20m²'),
(18, '012', 'Suite Room', 500000, '1', 'Terisi', 'twin bed,wifi,ac,luas 20m²'),
(19, '013', 'Suite Room', 500000, '1', 'Kosong', 'twin bed,wifi,ac,luas 20m²'),
(20, '014', 'Suite Room', 500000, '1', 'Kosong', 'twin bed,wifi,ac,luas 20m²'),
(21, '015', 'Suite Room', 500000, '1', 'Kosong', 'twin bed,wifi,ac,luas 20m²'),
(22, '021', 'Executive Room', 700000, '2', 'Terisi', 'king bed,wifi,ac,luas 32m²'),
(25, '022', 'Executive Room', 700000, '2', 'Kosong', 'king bed,wifi,ac,luas 32m²'),
(26, '023', 'Executive Room', 700000, '2', 'Kosong', 'king bed,wifi,ac,luas 32m²'),
(27, '024', 'Executive Room', 700000, '2', 'Kosong', 'king bed,wifi,ac,luas 32m²'),
(28, '025', 'Executive Room', 700000, '2', 'Kosong', 'king bed,wifi,ac,luas 32m²');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id_review` int(11) NOT NULL,
  `idkmr` int(11) NOT NULL,
  `nokmr` int(11) NOT NULL,
  `id_cust` int(11) NOT NULL,
  `bintang` int(5) NOT NULL,
  `komen` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id_review`, `idkmr`, `nokmr`, `id_cust`, `bintang`, `komen`, `created_at`) VALUES
(5, 18, 0, 13, 5, 'gut', '2025-06-11 14:35:44'),
(6, 13, 2, 13, 4, 'nais', '2025-06-11 14:56:30'),
(7, 18, 12, 13, 4, 'ok', '2025-06-11 14:56:46'),
(8, 17, 11, 13, 5, 'gutt', '2025-06-11 14:56:55'),
(9, 12, 1, 13, 5, 'boleh', '2025-06-11 14:57:05'),
(10, 22, 21, 13, 5, 'gokil', '2025-06-11 14:57:14');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_trans` int(11) NOT NULL,
  `nokmr` int(11) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `id_cust` int(12) NOT NULL,
  `tipe` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_trans`, `nokmr`, `no_hp`, `harga`, `id_cust`, `tipe`) VALUES
(1, 12, '12', 1000000, 13, 'Suite Room'),
(2, 11, '12', 444000000, 13, 'Suite Room'),
(3, 1, '12', 596400000, 13, 'Deluxe Room'),
(4, 21, '12', 2534000000, 13, 'Executive Room'),
(5, 2, '12', 1200000, 13, 'Deluxe Room');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `id_admin` (`id_admin`);

--
-- Indexes for table `cust`
--
ALTER TABLE `cust`
  ADD PRIMARY KEY (`id_cust`),
  ADD UNIQUE KEY `id_cust` (`id_cust`);

--
-- Indexes for table `kmr`
--
ALTER TABLE `kmr`
  ADD PRIMARY KEY (`idkmr`),
  ADD UNIQUE KEY `idkmr` (`idkmr`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id_review`),
  ADD KEY `idkmr` (`idkmr`),
  ADD KEY `id_cust` (`id_cust`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_trans`),
  ADD KEY `id_cust` (`id_cust`),
  ADD KEY `no_kmr` (`nokmr`),
  ADD KEY `nokmr` (`nokmr`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cust`
--
ALTER TABLE `cust`
  MODIFY `id_cust` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `kmr`
--
ALTER TABLE `kmr`
  MODIFY `idkmr` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_trans` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `cust` (`id_cust`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`idkmr`) REFERENCES `kmr` (`idkmr`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`id_cust`) REFERENCES `cust` (`id_cust`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_cust`) REFERENCES `cust` (`id_cust`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
