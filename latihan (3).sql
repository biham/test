-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2022 at 04:01 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `latihan`
--

-- --------------------------------------------------------

--
-- Table structure for table `bimbingan`
--

CREATE TABLE `bimbingan` (
  `id` int(11) NOT NULL,
  `id_judul` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_dosen` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bimbingan`
--

INSERT INTO `bimbingan` (`id`, `id_judul`, `id_mahasiswa`, `id_dosen`, `status`) VALUES
(5, 54, 7, 13, 0),
(13, 54, 5, 13, 0);

-- --------------------------------------------------------

--
-- Table structure for table `detail_bimbingan`
--

CREATE TABLE `detail_bimbingan` (
  `id` int(11) NOT NULL,
  `id_bimbingan` int(11) NOT NULL,
  `materi` varchar(255) NOT NULL,
  `files` varchar(255) NOT NULL,
  `files_2` varchar(255) DEFAULT NULL,
  `ket` text NOT NULL,
  `ket_2` text DEFAULT NULL,
  `paraf` varchar(20) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_bimbingan`
--

INSERT INTO `detail_bimbingan` (`id`, `id_bimbingan`, `materi`, `files`, `files_2`, `ket`, `ket_2`, `paraf`, `status`) VALUES
(6, 5, 'BAB I', '2018000_Biham Maulana_1669242659_47f4c79ed9140ce995c3.docx', NULL, 'test data', 'perbaiki lagi penulisannya dan gambarnya', '', 1),
(25, 5, 'BAB II', '2018000_Biham Maulana_1669435647_4a5ff8b5014064248402.pdf', NULL, 'tesr', 'teszt', '', 1),
(26, 13, 'BAB II', '2018000_Biham Maulana_1670057713_2b872d780ef3d04417c3.pdf', NULL, 'mencoba', NULL, '', 0),
(27, 13, 'BAB II', '2018000_Biham Maulana_1670765768_873bbbbb2145b95b2ab3.docx', NULL, 'mencoa 1', NULL, '', 0),
(28, 13, 'BAB II', '2018000_Biham Maulana_1670802698_74d4425b4b3715def746.docx', NULL, 'a', NULL, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id` int(11) NOT NULL,
  `nip` int(12) NOT NULL,
  `nama_dsn` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `telp` bigint(12) NOT NULL,
  `id_jabatan` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` time NOT NULL,
  `updated_at` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id`, `nip`, `nama_dsn`, `foto`, `telp`, `id_jabatan`, `email`, `created_at`, `updated_at`) VALUES
(9, 2019002, 'test 2', '', 82299210986, 1, 'admin@gmail.com', '10:53:35', '10:53:35'),
(13, 2019000, 'test 1', '', 0, 1, 'admin@gmail.com', '12:05:45', '12:05:45');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`) VALUES
(1, 'Dosen'),
(2, 'Kaprodi');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `levelid` int(11) NOT NULL,
  `levelnama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`levelid`, `levelnama`) VALUES
(1, 'Administrator'),
(2, 'Mahasiswa'),
(3, 'Dosen');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `npm` char(12) NOT NULL,
  `nama_mhs` varchar(100) DEFAULT NULL,
  `jenkel` char(1) DEFAULT NULL,
  `mhsprodiid` int(11) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `npm`, `nama_mhs`, `jenkel`, `mhsprodiid`, `foto`, `created_at`, `updated_at`) VALUES
(5, '2018000', 'Biham Maulana', 'L', 1, NULL, '2022-11-17 15:53:57', '2022-11-17 15:53:57'),
(7, '2018001', 'test 1', 'L', 3, NULL, '2022-11-17 18:27:26', '2022-11-17 18:27:26');

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `prodiid` int(11) NOT NULL,
  `prodinama` varchar(100) DEFAULT NULL,
  `Jenjang` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`prodiid`, `prodinama`, `Jenjang`) VALUES
(1, 'Sistem Informasi', 'Sarjana'),
(2, 'Sistem Komputer', 'Sarjana'),
(3, 'Manajemen Informatika', 'D3');

-- --------------------------------------------------------

--
-- Table structure for table `proposal`
--

CREATE TABLE `proposal` (
  `id_judul` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `id_dosen` int(11) DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `files` varchar(255) NOT NULL,
  `tahunakademikid` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `proposal`
--

INSERT INTO `proposal` (`id_judul`, `judul`, `id_mahasiswa`, `status`, `id_dosen`, `ket`, `files`, `tahunakademikid`, `created_at`, `updated_at`) VALUES
(54, 'sistem informasi pengembangan website ', 5, 1, 13, '', '/assets/proposal/2018000_Biham Maulana_sistem informasi pengembangan website .docx', 41, '2022-11-21 20:53:37', '2022-11-21 20:55:03');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_akademik`
--

CREATE TABLE `tahun_akademik` (
  `TahunAkademikID` int(11) NOT NULL,
  `TahunAkademik` varchar(100) NOT NULL,
  `Semester` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tahun_akademik`
--

INSERT INTO `tahun_akademik` (`TahunAkademikID`, `TahunAkademik`, `Semester`, `Status`, `created_at`, `updated_at`) VALUES
(1, '2021', 1, 0, '2022-11-16 04:47:45', '2022-11-24 08:12:35'),
(41, '2022', 2, 1, '2022-11-17 13:25:32', '2022-11-24 09:28:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `userlevelid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `userlevelid`) VALUES
(4, 'admin', '$2y$10$z2X1f5yz7hEtz83ZCxygwOIcX.FvdGiWwgQM8S4DE1c.ClOPrpkaq', 1),
(5, '2018000', '$2y$10$mAxi6TS03GUHXcUAXSGKRuOuVt6.GBs6aodP0PJ6/MPTVTBYsH/w.', 2),
(13, '2019000', '$2y$10$iwc03DSdv9Z0.tWPW8EB3O12levwBwK9lfefMD/Ad2hBsARcmxQfO', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bimbingan`
--
ALTER TABLE `bimbingan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_bimbingan`
--
ALTER TABLE `detail_bimbingan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_judul` (`id_bimbingan`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`levelid`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mhsprodiid` (`mhsprodiid`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`prodiid`);

--
-- Indexes for table `proposal`
--
ALTER TABLE `proposal`
  ADD PRIMARY KEY (`id_judul`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`),
  ADD KEY `id_dosen` (`id_dosen`),
  ADD KEY `tahunakademikid` (`tahunakademikid`);

--
-- Indexes for table `tahun_akademik`
--
ALTER TABLE `tahun_akademik`
  ADD PRIMARY KEY (`TahunAkademikID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `userlevelid` (`userlevelid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bimbingan`
--
ALTER TABLE `bimbingan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `detail_bimbingan`
--
ALTER TABLE `detail_bimbingan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `levelid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `prodiid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `proposal`
--
ALTER TABLE `proposal`
  MODIFY `id_judul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `tahun_akademik`
--
ALTER TABLE `tahun_akademik`
  MODIFY `TahunAkademikID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_ibfk_1` FOREIGN KEY (`mhsprodiid`) REFERENCES `prodi` (`prodiid`) ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`userlevelid`) REFERENCES `levels` (`levelid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
