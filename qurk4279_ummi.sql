-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2024 at 04:59 PM
-- Server version: 10.6.17-MariaDB-cll-lve
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qurk4279_ummi`
--

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `lembaga` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `sertifikasi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `lembaga`, `nama`, `status`, `sertifikasi`) VALUES
(1, 'SDIT Akhlakul Karimah', 'Abu Bakar, S.Pd', 'Koordinator', 'Sudah'),
(2, 'SDIT Akhlakul Karimah', 'Umar, S.Ag', 'Guru', 'Sudah'),
(3, 'SDIT Akhlakul Karimah', 'Utsman, S.Pd.I', 'Guru', 'Belum');

-- --------------------------------------------------------

--
-- Table structure for table `kelompok`
--

CREATE TABLE `kelompok` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `guru` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelompok`
--

INSERT INTO `kelompok` (`id`, `nama`, `guru`) VALUES
(1, 'Adam', 'Umar, S.Ag'),
(2, 'Idris', 'Umar, S.Ag'),
(3, 'Hud', 'Utsman, S.Pd.I'),
(4, 'Nuh', 'Utsman, S.Pd.I'),
(5, 'Ibrahim', 'Umar, S.Ag'),
(6, 'Sholeh', 'Umar, S.Ag'),
(7, 'Ismail', 'Utsman, S.Pd.I'),
(8, 'Luth', 'Utsman, S.Pd.I'),
(9, 'Ishaq', 'Umar, S.Ag'),
(10, 'Yakub', 'Umar, S.Ag'),
(11, 'Ayyub', 'Utsman, S.Pd.I'),
(12, 'Yusuf', 'Utsman, S.Pd.I'),
(13, 'Musa', 'Umar, S.Ag'),
(14, 'Syuaib', 'Umar, S.Ag'),
(15, 'Harun', 'Utsman, S.Pd.I'),
(16, 'Zulkifli', 'Utsman, S.Pd.I'),
(17, 'Daud', 'Umar, S.Ag'),
(18, 'Sulaiman', 'Umar, S.Ag'),
(19, 'Ilyas', 'Utsman, S.Pd.I'),
(20, 'Ilyasa', 'Utsman, S.Pd.I'),
(21, 'Yunus', 'Umar, S.Ag'),
(22, 'Zakaria', 'Umar, S.Ag'),
(23, 'Isa', 'Utsman, S.Pd.I'),
(24, 'Yahya', 'Utsman, S.Pd.I');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `bulan` varchar(100) NOT NULL,
  `jilid` varchar(100) NOT NULL,
  `halaman` varchar(100) NOT NULL,
  `ketuntasan_tartil` varchar(100) NOT NULL,
  `juz` varchar(100) NOT NULL,
  `surat` varchar(100) NOT NULL,
  `ketuntasan_tahfizh` varchar(100) NOT NULL,
  `catatan` text NOT NULL,
  `guru` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `nama`, `bulan`, `jilid`, `halaman`, `ketuntasan_tartil`, `juz`, `surat`, `ketuntasan_tahfizh`, `catatan`, `guru`) VALUES
(3, 'Adam', 'Juni', '2', '15', 'Tuntas', '30', 'An Naba', 'Tuntas', '', 'Umar, S.Ag'),
(4, 'Idris', 'Juni', '2', '15', 'Tuntas', '30', 'An Naba', 'Tuntas', '', 'Umar, S.Ag');

-- --------------------------------------------------------

--
-- Table structure for table `lulus`
--

CREATE TABLE `lulus` (
  `id` int(11) NOT NULL,
  `id_tes` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `keterangan_mun` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lulus`
--

INSERT INTO `lulus` (`id`, `id_tes`, `nama`, `kategori`, `keterangan_mun`) VALUES
(1, '3', 'Ibrahim', 'Tartil', 'Lulus'),
(2, '2', 'Daud', 'Tartil', 'Lulus'),
(3, '6', 'Daud', 'Tahfizh Juz 30', 'Lulus');

-- --------------------------------------------------------

--
-- Table structure for table `nomor`
--

CREATE TABLE `nomor` (
  `id` int(11) NOT NULL,
  `id_tes` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nomor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nomor`
--

INSERT INTO `nomor` (`id`, `id_tes`, `nama`, `nomor`) VALUES
(1, '3', 'Ibrahim', '99'),
(2, '2', 'Daud', '88'),
(3, '6', 'Daud', '77');

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `id` int(11) NOT NULL,
  `lembaga` varchar(100) NOT NULL,
  `paket` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`id`, `lembaga`, `paket`, `status`) VALUES
(1, 'SDIT Akhlakul Karimah', 'Standar', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `lembaga` varchar(100) NOT NULL,
  `tgl_bayar` varchar(100) NOT NULL,
  `metode_bayar` varchar(100) NOT NULL,
  `jumlah` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `lembaga`, `tgl_bayar`, `metode_bayar`, `jumlah`) VALUES
(1, 'SDIT Akhlakul Karimah', '2024-06-14', 'Cash', '0');

-- --------------------------------------------------------

--
-- Table structure for table `placement`
--

CREATE TABLE `placement` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jilid` varchar(100) NOT NULL,
  `halaman` varchar(100) NOT NULL,
  `catatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `placement`
--

INSERT INTO `placement` (`id`, `nama`, `jilid`, `halaman`, `catatan`) VALUES
(1, 'Adam', '1', '1', ''),
(2, 'Idris', '1', '1', ''),
(3, 'Hud', '1', '1', ''),
(4, 'Nuh', '1', '1', ''),
(5, 'Ibrahim', '5', '1', ''),
(6, 'Sholeh', '5', '1', ''),
(7, 'Ismail', '5', '1', ''),
(8, 'Luth', '5', '1', ''),
(9, 'Ishaq', 'Al Quran', '1', ''),
(10, 'Yakub', 'Al Quran', '1', ''),
(11, 'Ayyub', 'Al Quran', '1', ''),
(12, 'Yusuf', 'Al Quran', '1', ''),
(13, 'Musa', 'Tajwid', '1', ''),
(14, 'Syuaib', 'Tajwid', '1', ''),
(15, 'Harun', 'Tajwid', '1', ''),
(16, 'Zulkifli', 'Tajwid', '1', ''),
(17, 'Daud', 'Tahfizh', 'An Naba', ''),
(18, 'Sulaiman', 'Tahfizh', 'An Naba', ''),
(19, 'Ilyas', 'Tahfizh', 'An Naba', ''),
(20, 'Ilyasa', 'Tahfizh', 'An Naba', ''),
(21, 'Yunus', 'Tahfizh', 'Al Mulk', ''),
(22, 'Zakaria', 'Tahfizh', 'Al Mulk', ''),
(23, 'Isa', 'Tahfizh', 'Al Mulk', ''),
(24, 'Yahya', 'Tahfizh', 'Al Mulk', '');

-- --------------------------------------------------------

--
-- Table structure for table `pra_munaqosyah`
--

CREATE TABLE `pra_munaqosyah` (
  `id` int(11) NOT NULL,
  `id_tes` varchar(100) NOT NULL,
  `lembaga` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(100) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `catatan` text NOT NULL,
  `keterangan_pra` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pra_munaqosyah`
--

INSERT INTO `pra_munaqosyah` (`id`, `id_tes`, `lembaga`, `nama`, `kelas`, `kategori`, `catatan`, `keterangan_pra`) VALUES
(1, '3', 'SDIT Akhlakul Karimah', 'Ibrahim', '2A', 'Tartil', '', 'Lolos'),
(2, '2', 'SDIT Akhlakul Karimah', 'Daud', '5A', 'Tartil', '', 'Lolos'),
(3, '6', 'SDIT Akhlakul Karimah', 'Daud', '5A', 'Tahfizh Juz 30', '', 'Lolos');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `lembaga` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(100) NOT NULL,
  `no_hp` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tgl_lahir` varchar(100) NOT NULL,
  `ayah` varchar(100) NOT NULL,
  `ibu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `lembaga`, `nama`, `kelas`, `jenis_kelamin`, `no_hp`, `alamat`, `tempat_lahir`, `tgl_lahir`, `ayah`, `ibu`) VALUES
(1, 'SDIT Akhlakul Karimah', 'Adam', '1A', '', '', '', '', '', '', ''),
(2, 'SDIT Akhlakul Karimah', 'Idris', '1A', '', '', '', '', '', '', ''),
(3, 'SDIT Akhlakul Karimah', 'Nuh', '1B', '', '', '', '', '', '', ''),
(4, 'SDIT Akhlakul Karimah', 'Hud', '1B', '', '', '', '', '', '', ''),
(5, 'SDIT Akhlakul Karimah', 'Sholeh', '2A', '', '', '', '', '', '', ''),
(6, 'SDIT Akhlakul Karimah', 'Ibrahim', '2A', '', '', '', '', '', '', ''),
(7, 'SDIT Akhlakul Karimah', 'Luth', '2B', '', '', '', '', '', '', ''),
(8, 'SDIT Akhlakul Karimah', 'Ismail', '2B', '', '', '', '', '', '', ''),
(9, 'SDIT Akhlakul Karimah', 'Ishaq', '3A', '', '', '', '', '', '', ''),
(10, 'SDIT Akhlakul Karimah', 'Yakub', '3A', '', '', '', '', '', '', ''),
(11, 'SDIT Akhlakul Karimah', 'Yusuf', '3B', '', '', '', '', '', '', ''),
(12, 'SDIT Akhlakul Karimah', 'Ayyub', '3B', '', '', '', '', '', '', ''),
(13, 'SDIT Akhlakul Karimah', 'Syuaib', '4A', '', '', '', '', '', '', ''),
(14, 'SDIT Akhlakul Karimah', 'Musa', '4A', '', '', '', '', '', '', ''),
(15, 'SDIT Akhlakul Karimah', 'Harun', '4B', '', '', '', '', '', '', ''),
(16, 'SDIT Akhlakul Karimah', 'Zulkifli', '4B', '', '', '', '', '', '', ''),
(17, 'SDIT Akhlakul Karimah', 'Daud', '5A', 'L', '087712345678', 'Jl. Guntur No. 26', 'Jakarta', '2020-02-03', 'Muhammad Salah', 'Ainun Sholihah'),
(18, 'SDIT Akhlakul Karimah', 'Sulaiman', '5A', '', '', '', '', '', '', ''),
(19, 'SDIT Akhlakul Karimah', 'Ilyas', '5B', '', '', '', '', '', '', ''),
(20, 'SDIT Akhlakul Karimah', 'Ilyasa', '5B', '', '', '', '', '', '', ''),
(21, 'SDIT Akhlakul Karimah', 'Yunus', '6A', '', '', '', '', '', '', ''),
(22, 'SDIT Akhlakul Karimah', 'Zakaria', '6A', '', '', '', '', '', '', ''),
(23, 'SDIT Akhlakul Karimah', 'Yahya', '6B', '', '', '', '', '', '', ''),
(24, 'SDIT Akhlakul Karimah', 'Isa', '6B', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id` int(11) NOT NULL,
  `tahun_ajaran` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id`, `tahun_ajaran`) VALUES
(1, '2024 - 2025');

-- --------------------------------------------------------

--
-- Table structure for table `tes`
--

CREATE TABLE `tes` (
  `id` int(11) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nama` varchar(100) NOT NULL,
  `jilid` varchar(100) NOT NULL,
  `juz` varchar(100) NOT NULL,
  `surat` varchar(100) NOT NULL,
  `nilai1` varchar(100) NOT NULL,
  `nilai2` varchar(100) NOT NULL,
  `nilai3` varchar(100) NOT NULL,
  `catatan` text NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `guru` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tes`
--

INSERT INTO `tes` (`id`, `waktu`, `nama`, `jilid`, `juz`, `surat`, `nilai1`, `nilai2`, `nilai3`, `catatan`, `keterangan`, `kategori`, `guru`) VALUES
(1, '2024-06-13 22:26:52', 'Adam', 'Al Quran', '', '', '', '', '', '', 'Lulus', 'Tartil', 'Umar, S.Ag'),
(2, '2024-06-13 22:27:11', 'Adam', '30', '30', 'An Naba', '', '', '', '', 'Ke Pra Munaqosyah', 'Tahfizh', 'Umar, S.Ag');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `lembaga` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `role`, `nama`, `lembaga`) VALUES
(1, 'fajar@qurma.site', 'fajarabd90', 'admin', 'Administrator', 'SDIT Akhlakul Karimah'),
(2, 'abu@qurma.site', 'abu2024', 'koordinator', 'Abu Bakar, S.Pd', 'SDIT Akhlakul Karimah'),
(3, 'umar@qurma.site', 'umar2024', 'guru', 'Umar, S.Ag', 'SDIT Akhlakul Karimah'),
(4, 'utsman@qurma.site', 'utsman2024', 'guru', 'Utsman, S.Pd.I', 'SDIT Akhlakul Karimah'),
(5, 'ali@qurma.site', 'ali2024', 'walikelas', 'Ali, S.Pd', 'SDIT Akhlakul Karimah'),
(6, 'demo_koordinator', '', 'koordinator', 'Demo Koordinator', 'SDIT Akhlakul Karimah'),
(7, 'demo_guru', '', 'guru', 'Demo Guru', 'SDIT Akhlakul Karimah');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelompok`
--
ALTER TABLE `kelompok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lulus`
--
ALTER TABLE `lulus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nomor`
--
ALTER TABLE `nomor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `placement`
--
ALTER TABLE `placement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pra_munaqosyah`
--
ALTER TABLE `pra_munaqosyah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tes`
--
ALTER TABLE `tes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kelompok`
--
ALTER TABLE `kelompok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lulus`
--
ALTER TABLE `lulus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nomor`
--
ALTER TABLE `nomor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `paket`
--
ALTER TABLE `paket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `placement`
--
ALTER TABLE `placement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `pra_munaqosyah`
--
ALTER TABLE `pra_munaqosyah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tes`
--
ALTER TABLE `tes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
