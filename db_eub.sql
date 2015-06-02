-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2015 at 04:42 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_eub`
--

-- --------------------------------------------------------

--
-- Table structure for table `akademik`
--

CREATE TABLE IF NOT EXISTS `akademik` (
  `id_user` varchar(5) NOT NULL,
  `username` varchar(32) NOT NULL,
  `pwd` varchar(128) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `posisi` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akademik`
--

INSERT INTO `akademik` (`id_user`, `username`, `pwd`, `nama`, `posisi`) VALUES
('A001', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Admin', 'Staf akademik'),
('A002', 'akademik', 'f2a53d8dadeaa7643eb0ae91346e72af3317ac67', 'Akademik', 'Staf Akademik');

-- --------------------------------------------------------

--
-- Table structure for table `bobotnilai`
--

CREATE TABLE IF NOT EXISTS `bobotnilai` (
  `nilai` decimal(10,2) NOT NULL,
  `ket` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bobotnilai`
--

INSERT INTO `bobotnilai` (`nilai`, `ket`) VALUES
('55.10', 'B (Memuaskan)'),
('65.10', 'A (Sangat Memuaskan)'),
('45.10', 'C (Cukup Memuaskan)'),
('35.10', 'D (Kurang Memuaskan)'),
('25.10', 'E (Sangat Kurang Memuaskan)');

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE IF NOT EXISTS `dosen` (
  `id_dosen` varchar(5) NOT NULL,
  `nama_dosen` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id_dosen`, `nama_dosen`) VALUES
('D001', 'Muhammad Nuh, S.E., M.Si.'),
('D002', 'Hendro Purwoko, S.Kom., M.Kom.'),
('D003', 'Ade Sobari, S.Kom., M.M.S.I'),
('D004', 'Drs. Mulyadi'),
('D005', 'Efendi, S.Pd.I'),
('D006', 'D006'),
('D007', 'd007'),
('D008', 'D008'),
('D009', 'D009'),
('D010', 'D010'),
('D011', 'D011');

-- --------------------------------------------------------

--
-- Table structure for table `dosen_detail`
--

CREATE TABLE IF NOT EXISTS `dosen_detail` (
  `id_dosen` varchar(5) NOT NULL,
  `id_kls` varchar(5) NOT NULL,
  `matakuliah` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dosen_detail`
--

INSERT INTO `dosen_detail` (`id_dosen`, `id_kls`, `matakuliah`) VALUES
('D001', 'IK006', 'Pengantar Akuntansi'),
('D001', 'MM', 'Kewirausahaan'),
('D002', 'IK006', 'MPP'),
('D002', 'MM06', 'Desain Grafis I'),
('D001', 'KA14', 'KA'),
('D001', 'AP14', 'AP'),
('D001', 'MM06', 'KWH'),
('D001', 'KA15', 'Pajak'),
('D001', 'KA14', 'ASP'),
('D001', 'AP14', 'Typing'),
('D002', 'AP14', 'MJK'),
('D002', 'KA14', 'Excel 2'),
('D002', 'IK006', 'Pemrograman Web 3'),
('D002', 'AP14', 'Database 2'),
('D002', 'MM06', 'Animasi Web I'),
('D003', 'AP14', 'BHNN'),
('D003', 'IK006', 'Pemrograman Visual 2'),
('D003', 'IK006', 'Application Project 2'),
('D004', 'KA15', 'MYOB'),
('D003', 'IK006', 'Web 3'),
('D002', 'IK005', 'Analisa Perancangan Sistem'),
('D002', 'IK005', 'Basis Data 2'),
('D001', 'IK005', 'Pengantar Akuntansi'),
('D003', 'IK005', 'Pemrograman Visual 3'),
('D004', 'IK005', 'MYOB'),
('D005', 'KA14', 'Database 2'),
('D005', 'KA15', 'Database 2');

-- --------------------------------------------------------

--
-- Table structure for table `eub_dosen`
--

CREATE TABLE IF NOT EXISTS `eub_dosen` (
  `id_eub_dosen` int(11) NOT NULL,
  `nim` varchar(15) NOT NULL,
  `id_dosen` varchar(5) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eub_dosen`
--

INSERT INTO `eub_dosen` (`id_eub_dosen`, `nim`, `id_dosen`, `total`) VALUES
(1, '120442010030', 'D001', 61),
(2, '120442010030', 'D002', 62),
(3, '120442010030', 'D003', 59),
(4, '13044201050', 'D001', 49),
(5, '13044201050', 'D002', 43);

-- --------------------------------------------------------

--
-- Table structure for table `eub_dosen_detail`
--

CREATE TABLE IF NOT EXISTS `eub_dosen_detail` (
  `id_eub_dosen` int(11) NOT NULL,
  `id_soal` int(3) NOT NULL,
  `jwb` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eub_dosen_detail`
--

INSERT INTO `eub_dosen_detail` (`id_eub_dosen`, `id_soal`, `jwb`) VALUES
(1, 1, 5),
(1, 2, 1),
(1, 3, 5),
(1, 4, 5),
(1, 5, 2),
(1, 6, 5),
(1, 7, 5),
(1, 8, 5),
(1, 9, 5),
(1, 10, 5),
(1, 11, 5),
(1, 12, 5),
(1, 13, 1),
(1, 14, 1),
(1, 15, 3),
(1, 16, 3),
(2, 1, 5),
(2, 2, 5),
(2, 3, 4),
(2, 4, 4),
(2, 5, 4),
(2, 6, 3),
(2, 7, 3),
(2, 8, 3),
(2, 9, 4),
(2, 10, 4),
(2, 11, 2),
(2, 12, 4),
(2, 13, 4),
(2, 14, 4),
(2, 15, 4),
(2, 16, 5),
(3, 1, 5),
(3, 2, 4),
(3, 3, 4),
(3, 4, 3),
(3, 5, 1),
(3, 6, 2),
(3, 7, 2),
(3, 8, 5),
(3, 9, 4),
(3, 10, 4),
(3, 11, 5),
(3, 12, 3),
(3, 13, 5),
(3, 14, 4),
(3, 15, 3),
(3, 16, 5),
(4, 1, 5),
(4, 2, 4),
(4, 3, 3),
(4, 4, 3),
(4, 5, 3),
(4, 6, 2),
(4, 7, 3),
(4, 8, 2),
(4, 9, 3),
(4, 10, 3),
(4, 11, 3),
(4, 12, 3),
(4, 13, 3),
(4, 14, 3),
(4, 15, 3),
(4, 16, 3),
(5, 1, 3),
(5, 2, 3),
(5, 3, 2),
(5, 4, 2),
(5, 5, 2),
(5, 6, 3),
(5, 7, 3),
(5, 8, 4),
(5, 9, 5),
(5, 10, 3),
(5, 11, 2),
(5, 12, 2),
(5, 13, 2),
(5, 14, 2),
(5, 15, 2),
(5, 16, 3);

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE IF NOT EXISTS `kelas` (
  `id_kls` varchar(5) NOT NULL,
  `kelas` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kls`, `kelas`) VALUES
('AP14', 'AP14'),
('IK005', 'IK005'),
('IK006', 'IK006'),
('KA14', 'KA14'),
('KA15', 'KA15'),
('MM05', 'MM05'),
('MM06', 'MM06');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE IF NOT EXISTS `mahasiswa` (
  `nim` varchar(15) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jekel` varchar(2) NOT NULL,
  `angkatan` varchar(5) NOT NULL,
  `id_kls` varchar(5) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `jekel`, `angkatan`, `id_kls`, `pwd`, `status`) VALUES
('120442010030', 'Ahmad', 'L', '2012', 'IK005', '37e3751f09cb2bf0719f777b7e959234671e6990', 1),
('13044201050', 'ABCDEF', 'P', '2013', 'AP14', 'cfab834c46a7816490f0d0ec2b9e3781542eaf70', 1);

-- --------------------------------------------------------

--
-- Table structure for table `soal`
--

CREATE TABLE IF NOT EXISTS `soal` (
  `id_soal` int(3) NOT NULL,
  `soal` text NOT NULL,
  `id_user` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `soal`
--

INSERT INTO `soal` (`id_soal`, `soal`, `id_user`) VALUES
(1, 'Dosen Anda selalu berpakaian rapih dan senada (Pria menggunakan dasi dan Wanita menggunakan blaser).', 0),
(2, 'Dosen Anda tidak pernah menggunakan celana jeans atau T-shirt.', 0),
(3, 'Dosen Anda selalu datang tepat waktu.', 0),
(4, 'Dosen Anda selalu pulang tepat waktu, sesuai dengan jadwal mengajar.', 0),
(5, 'Dosen Anda terlalu sering meninggalkan kelas diluar dari keperluan perkuliahan pada saat pembelajaran.', 0),
(6, 'Dosen Anda sering memberikan motivasi yang membangun semangat dan termotivasi untuk belajar lebih giat.', 0),
(7, 'Dosen Anda selalu memberikan perhatian, serta memberikan solusi dan hasil yang akan di kerjakan di Lab/Kelas.', 0),
(8, 'Dosen Anda dalam menyampaikan kuliah mudah di pahami, ringkas dan jelas sehingga anda mudah dalam memahami isi kuliah tersebut.', 0),
(9, 'Dosen Anda sangat menguasai materi yang di ajarkan.', 0),
(10, 'Dosen Anda selalu memberikan kesempatan mahasiswa untuk bertanya.', 0),
(11, 'Dosen Anda selalu memberikan jawaban jika ada pertanyaan dari mahasiswa dengan baik dan memberikan solusi dan pertanyaan yang di ajukan.', 0),
(12, 'Dosen Anda mengajar sangat menyenangkan (fun) tidak pernah menegangkan.', 0),
(13, 'Dosen Anda tidak pernah pilih kasih dalam memberikan solusi ketika mengerjakan tugas di Lab/Kelas.', 0),
(14, 'Dosen Anda tidak pernah melakukan pelecehan seksual kepada mahasiswa.', 0),
(15, 'Dosen Anda selalu memberikan tugas /PR disetiap akhir pertemuan.', 0),
(16, 'Dosen Anda memberikan formatif/quiz.', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akademik`
--
ALTER TABLE `akademik`
 ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
 ADD PRIMARY KEY (`id_dosen`);

--
-- Indexes for table `eub_dosen`
--
ALTER TABLE `eub_dosen`
 ADD PRIMARY KEY (`id_eub_dosen`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
 ADD PRIMARY KEY (`id_kls`), ADD UNIQUE KEY `id_kls` (`id_kls`), ADD KEY `id_kls_2` (`id_kls`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
 ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `soal`
--
ALTER TABLE `soal`
 ADD PRIMARY KEY (`id_soal`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
