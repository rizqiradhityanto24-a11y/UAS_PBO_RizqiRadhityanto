-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 23, 2026 at 01:26 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_uas_pbo_trpl1b_rizqiradhityanto`
--

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int NOT NULL,
  `nama_karyawan` varchar(100) NOT NULL,
  `hari_kerja_masuk` int NOT NULL DEFAULT '0',
  `gaji_dasar_perhari` decimal(10,2) NOT NULL,
  `jenis_karyawan` enum('kontrak','tetap','magang') NOT NULL,
  `durasi_kontrak_bulan` int DEFAULT NULL,
  `uang_saku_bulanan` decimal(10,2) DEFAULT NULL,
  `sertifikat_kampus_merdeka` enum('Ya','Tidak') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama_karyawan`, `hari_kerja_masuk`, `gaji_dasar_perhari`, `jenis_karyawan`, `durasi_kontrak_bulan`, `uang_saku_bulanan`, `sertifikat_kampus_merdeka`) VALUES
(1, 'Budi Santoso', 22, 150000.00, 'tetap', NULL, NULL, NULL),
(2, 'Siti Aminah', 21, 160000.00, 'tetap', NULL, NULL, NULL),
(3, 'Dewi Lestari', 23, 175000.00, 'tetap', NULL, NULL, NULL),
(4, 'Ahmad Fauzi', 22, 150000.00, 'tetap', NULL, NULL, NULL),
(5, 'Rina Permata', 20, 155000.00, 'tetap', NULL, NULL, NULL),
(6, 'Eko Prasetyo', 22, 165000.00, 'tetap', NULL, NULL, NULL),
(7, 'Andi Wijaya', 24, 180000.00, 'tetap', NULL, NULL, NULL),
(8, 'Rian Wijaya', 20, 120000.00, 'kontrak', 12, NULL, NULL),
(9, 'Sari Utami', 19, 115000.00, 'kontrak', 6, NULL, NULL),
(10, 'Hendra Setiawan', 21, 125000.00, 'kontrak', 24, NULL, NULL),
(11, 'Megaawati Putri', 22, 130000.00, 'kontrak', 12, NULL, NULL),
(12, 'Taufik Hidayat', 18, 110000.00, 'kontrak', 6, NULL, NULL),
(13, 'Bambang Pamungkas', 20, 120000.00, 'kontrak', 12, NULL, NULL),
(14, 'Fitriani', 21, 125000.00, 'kontrak', 24, NULL, NULL),
(15, 'Kevin Sanjaya', 18, 75000.00, 'magang', NULL, 1500000.00, 'Ya'),
(16, 'Marcus Gideon', 17, 75000.00, 'magang', NULL, 1500000.00, 'Ya'),
(17, 'Fajar Alfian', 19, 70000.00, 'magang', NULL, 1200000.00, 'Tidak'),
(18, 'Muhammad Rian', 16, 70000.00, 'magang', NULL, 1200000.00, 'Tidak'),
(19, 'Jonatan Christie', 20, 80000.00, 'magang', NULL, 1800000.00, 'Ya'),
(20, 'Anthony Ginting', 18, 80000.00, 'magang', NULL, 1800000.00, 'Ya');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
