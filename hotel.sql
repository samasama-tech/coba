-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Jun 2025 pada 11.21
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

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
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(12) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` bigint(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `email`, `password`, `no_hp`) VALUES
(1, 'Keysa', 'keysa@gmail.com', '1', 123),
(3, 'irul', 'irul@gmail.com', '123', 989887678),
(19, 'adnan', 'adonan@gmail.com', '1', 897654389),
(23, 'admin', 'admin@gmail.com', 'admin123', 8898978678);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cust`
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
-- Dumping data untuk tabel `cust`
--

INSERT INTO `cust` (`id_cust`, `username`, `email`, `password`, `no_hp`, `role`) VALUES
(1, 'Keysa', 'keysa@gmail.com', '1', '123', 'admin'),
(3, 'irul', 'irul@gmail.com', '123', '0989887678', 'admin'),
(12, 'alek', 'hhaihdijw@knjec.knscs', '1', '1234', 'customer'),
(13, 'ajojing', 'ppp@gamil.com', '1', '12', 'customer'),
(19, 'adnan', 'adonan@gmail.com', '1', '897654389', 'admin'),
(22, 'sugi', 'hhh@jhk.com', '1', '12', 'customer'),
(23, 'admin', 'admin@gmail.com', 'admin123', '08898978678', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kmr`
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
-- Dumping data untuk tabel `kmr`
--

INSERT INTO `kmr` (`idkmr`, `nokmr`, `tipe`, `harga`, `kap`, `status`, `fasilitas`) VALUES
(12, '001', 'Deluxe Room', 600000, '2', 'Kosong', 'double bed,wifi,ac,luas 28m²'),
(13, '002', 'Deluxe Room', 600000, '2', 'Kosong', 'double bed,wifi,ac,luas 28m²'),
(14, '003', 'Deluxe Room', 600000, '2', 'Kosong', 'double bed,wifi,ac,luas 28m²'),
(15, '004', 'Deluxe Room', 600000, '2', 'Kosong', 'double bed,wifi,ac,luas 28m²'),
(16, '005', 'Deluxe Room', 600000, '2', 'Kosong', 'double bed,wifi,ac,luas 28m²'),
(17, '011', 'Suite Room', 500000, '1', 'Kosong', 'twin bed,wifi,ac,luas 20m²'),
(18, '012', 'Suite Room', 500000, '1', 'Kosong', 'twin bed,wifi,ac,luas 20m²'),
(19, '013', 'Suite Room', 500000, '1', 'Kosong', 'twin bed,wifi,ac,luas 20m²'),
(20, '014', 'Suite Room', 500000, '1', 'Kosong', 'twin bed,wifi,ac,luas 20m²'),
(21, '015', 'Suite Room', 500000, '1', 'Kosong', 'twin bed,wifi,ac,luas 20m²'),
(22, '021', 'Executive Room', 700000, '2', 'Kosong', 'king bed,wifi,ac,luas 32m²'),
(25, '022', 'Executive Room', 700000, '2', 'Kosong', 'king bed,wifi,ac,luas 32m²'),
(26, '023', 'Executive Room', 700000, '2', 'Kosong', 'king bed,wifi,ac,luas 32m²'),
(27, '024', 'Executive Room', 700000, '2', 'Kosong', 'king bed,wifi,ac,luas 32m²'),
(28, '025', 'Executive Room', 700000, '2', 'Kosong', 'king bed,wifi,ac,luas 32m²');

-- --------------------------------------------------------

--
-- Struktur dari tabel `review`
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_trans` int(11) NOT NULL,
  `nokmr` int(11) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `id_cust` int(12) NOT NULL,
  `tipe` varchar(25) NOT NULL,
  `check_out` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `id_admin` (`id_admin`);

--
-- Indeks untuk tabel `cust`
--
ALTER TABLE `cust`
  ADD PRIMARY KEY (`id_cust`),
  ADD UNIQUE KEY `id_cust` (`id_cust`);

--
-- Indeks untuk tabel `kmr`
--
ALTER TABLE `kmr`
  ADD PRIMARY KEY (`idkmr`),
  ADD UNIQUE KEY `idkmr` (`idkmr`);

--
-- Indeks untuk tabel `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id_review`),
  ADD KEY `idkmr` (`idkmr`),
  ADD KEY `id_cust` (`id_cust`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_trans`),
  ADD KEY `id_cust` (`id_cust`),
  ADD KEY `no_kmr` (`nokmr`),
  ADD KEY `nokmr` (`nokmr`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cust`
--
ALTER TABLE `cust`
  MODIFY `id_cust` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `kmr`
--
ALTER TABLE `kmr`
  MODIFY `idkmr` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `review`
--
ALTER TABLE `review`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_trans` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `cust` (`id_cust`);

--
-- Ketidakleluasaan untuk tabel `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`idkmr`) REFERENCES `kmr` (`idkmr`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`id_cust`) REFERENCES `cust` (`id_cust`);

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_cust`) REFERENCES `cust` (`id_cust`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
