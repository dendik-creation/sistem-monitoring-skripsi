-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2022 at 05:26 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_skriptest`
--

-- --------------------------------------------------------

--
-- Table structure for table `berkas_sempro`
--

CREATE TABLE `berkas_sempro` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_semester` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_proposal` bigint(20) UNSIGNED NOT NULL,
  `id_plot_dosbing` bigint(20) UNSIGNED NOT NULL,
  `berkas_sempro` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Menunggu Dijadwalkan','Berkas OK','Berkas tidak lengkap','Terjadwal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu Dijadwalkan',
  `komentar_admin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `berkas_sempro`
--

INSERT INTO `berkas_sempro` (`id`, `id_semester`, `nim`, `id_proposal`, `id_plot_dosbing`, `berkas_sempro`, `status`, `komentar_admin`, `created_at`, `updated_at`) VALUES
(1, 1, '201851048', 1, 1, '204198234Berkas Sempro.zip', 'Terjadwal', 'Terjadwal', '2022-02-09 14:15:12', '2022-02-09 07:15:12'),
(3, 2, '201851060', 2, 3, '1467736756Berkas Sempro.zip', 'Terjadwal', 'Terjadwal', '2022-02-15 06:38:34', '2022-02-14 23:38:34'),
(4, 2, '201851061', 3, 4, '1388452674Berkas Sempro.zip', 'Terjadwal', 'Terjadwal', '2022-02-15 06:39:05', '2022-02-14 23:39:05');

-- --------------------------------------------------------

--
-- Table structure for table `berkas_ujian`
--

CREATE TABLE `berkas_ujian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_semester` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_proposal` bigint(20) UNSIGNED NOT NULL,
  `id_plot_penguji` bigint(20) UNSIGNED DEFAULT NULL,
  `berkas_ujian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Menunggu Dijadwalkan','Berkas OK','Berkas tidak lengkap','Terjadwal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu Dijadwalkan',
  `komentar_admin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `berkas_ujian`
--

INSERT INTO `berkas_ujian` (`id`, `id_semester`, `nim`, `id_proposal`, `id_plot_penguji`, `berkas_ujian`, `status`, `komentar_admin`, `created_at`, `updated_at`) VALUES
(1, 2, '201851060', 2, NULL, '1580324338Berkas Ujian Skripsi.zip', 'Terjadwal', 'Terjadwal', '2022-02-15 07:35:15', '2022-02-15 00:35:15');

-- --------------------------------------------------------

--
-- Table structure for table `bidang`
--

CREATE TABLE `bidang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_bidang` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bidang`
--

INSERT INTO `bidang` (`id`, `nama_bidang`, `created_at`, `updated_at`) VALUES
(1, 'Jaringan Komputer', '2022-02-09 07:00:53', NULL),
(2, 'Bisnis Cerdas & Visi Komputer', '2022-02-09 07:00:53', NULL),
(3, 'Komputer Grafis', '2022-02-09 07:00:53', NULL),
(4, 'Komputasi Terapan', '2022-02-09 07:00:53', NULL),
(5, 'Rekayasa Perangkat Lunak', '2022-02-09 07:00:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bimbingan`
--

CREATE TABLE `bimbingan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_semester` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_proposal` bigint(20) UNSIGNED NOT NULL,
  `id_plot_dosbing` bigint(20) UNSIGNED NOT NULL,
  `bimbingan_ke` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `komentar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ket1` enum('Review','Ok','Lanjut ke bimbingan selanjutnya','Siap ujian','-') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `ket2` enum('Review','Ok','Lanjut ke bimbingan selanjutnya','Siap ujian','-') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `bimbingan_kepada` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bimbingan`
--

INSERT INTO `bimbingan` (`id`, `id_semester`, `nim`, `id_proposal`, `id_plot_dosbing`, `bimbingan_ke`, `file`, `komentar`, `ket1`, `ket2`, `bimbingan_kepada`, `created_at`, `updated_at`) VALUES
(1, 2, '201851048', 1, 1, '1', '1974271672Bimbingan.pdf', NULL, 'Lanjut ke bimbingan selanjutnya', '-', '0625028501', '2022-02-14 14:54:48', '2022-02-14 07:54:48'),
(2, 2, '201851048', 1, 1, '1', '54466393Bimbingan.pdf', NULL, '-', 'Ok', '0604048702', '2022-02-14 15:53:17', '2022-02-14 08:53:17'),
(3, 2, '201851048', 1, 1, '2', '2141150261Bimbingan.pdf', 'Revisi', 'Review', '-', '0625028501', '2022-02-14 17:30:23', '2022-02-14 10:30:23'),
(4, 2, '201851060', 2, 3, '1', '2067937708Bimbingan.pdf', NULL, 'Siap ujian', '-', '0608068502', '2022-02-15 06:53:06', '2022-02-14 23:53:06'),
(5, 2, '201851060', 2, 3, '1', '53319748Bimbingan.pdf', NULL, '-', 'Siap ujian', '0406107004', '2022-02-15 06:53:14', '2022-02-14 23:53:14');

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nidn` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gelar1` bigint(20) UNSIGNED NOT NULL,
  `gelar2` bigint(20) UNSIGNED DEFAULT NULL,
  `gelar3` bigint(20) UNSIGNED DEFAULT NULL,
  `jabatan_fungsional` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_bidang` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ttd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id`, `nidn`, `name`, `gelar1`, `gelar2`, `gelar3`, `jabatan_fungsional`, `id_bidang`, `email`, `ttd`, `created_at`, `updated_at`) VALUES
(1, '0406107004', 'Ahmad Jazuli', 1, 1, NULL, 'Asisten Ahli', 3, 'ahmad.jazuli@umk.ac.id', 'ttd jay.png', '2022-02-09 07:02:32', '2022-02-09 07:02:32'),
(2, '0625028501', 'Ratih Nindyasari', 1, 1, NULL, 'Lektor', 5, 'ratih.nindyasari@umk.ac.id', 'ttd ratih.png', '2022-02-09 07:02:51', '2022-02-09 07:02:51'),
(3, '0604048702', 'Anastasya Latubessy', 1, 2, NULL, 'Lektor', 2, 'anastasya.latubessy@umk.ac.id', 'ttd tasya.png', '2022-02-09 07:03:21', '2022-02-09 07:03:21'),
(4, '0608068502', 'Tutik Khotimah', 1, 1, NULL, 'Lektor', 4, 'tutik.khotimah@umk.ac.id', 'ttd tutik.png', '2022-02-09 07:03:41', '2022-02-09 07:03:41');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hasil_sempro`
--

CREATE TABLE `hasil_sempro` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_semester` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_proposal` bigint(20) UNSIGNED NOT NULL,
  `id_jadwal_sempro` bigint(20) UNSIGNED DEFAULT NULL,
  `berita_acara` enum('Menunggu hasil','Diterima','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu hasil',
  `sikap1` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presentasi1` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penguasaan1` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah1` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade1` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revisi1` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sikap2` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presentasi2` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penguasaan2` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah2` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade2` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revisi2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilai_akhir` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `grade_akhir` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hasil_sempro`
--

INSERT INTO `hasil_sempro` (`id`, `id_semester`, `nim`, `id_proposal`, `id_jadwal_sempro`, `berita_acara`, `sikap1`, `presentasi1`, `penguasaan1`, `jumlah1`, `grade1`, `revisi1`, `sikap2`, `presentasi2`, `penguasaan2`, `jumlah2`, `grade2`, `revisi2`, `file1`, `file2`, `nilai_akhir`, `grade_akhir`, `created_at`, `updated_at`) VALUES
(4, 1, '201851048', 1, 3, 'Diterima', '80', '80', '80', '80', NULL, NULL, NULL, NULL, NULL, '90', NULL, NULL, NULL, NULL, '85', 'A', '2022-02-13 09:14:04', '2022-02-13 09:14:04'),
(6, 2, '201851061', 3, NULL, 'Menunggu hasil', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '-', '-', '2022-02-14 23:40:17', '2022-02-14 23:40:17'),
(7, 2, '201851060', 2, 5, 'Diterima', '80', '80', '86', '83', NULL, NULL, NULL, NULL, NULL, '85', NULL, NULL, NULL, NULL, '84', 'AB', '2022-02-14 23:40:27', '2022-02-14 23:40:27');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_ujian`
--

CREATE TABLE `hasil_ujian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_semester` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_proposal` bigint(20) UNSIGNED NOT NULL,
  `id_jadwal_ujian` bigint(20) UNSIGNED DEFAULT NULL,
  `berita_acara` enum('Menunggu hasil','Lulus','Tidak Lulus') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu hasil',
  `sikap1` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presentasi1` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teori1` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program1` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah1` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan1` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revisi1` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sikap2` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presentasi2` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teori2` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program2` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah2` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan2` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revisi2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sikap3` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presentasi3` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teori3` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program3` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah3` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan3` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revisi3` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sikap4` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presentasi4` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teori4` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program4` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah4` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan4` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revisi4` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilai_akhir` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `grade_akhir` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hasil_ujian`
--

INSERT INTO `hasil_ujian` (`id`, `id_semester`, `nim`, `id_proposal`, `id_jadwal_ujian`, `berita_acara`, `sikap1`, `presentasi1`, `teori1`, `program1`, `jumlah1`, `keterangan1`, `revisi1`, `sikap2`, `presentasi2`, `teori2`, `program2`, `jumlah2`, `keterangan2`, `revisi2`, `sikap3`, `presentasi3`, `teori3`, `program3`, `jumlah3`, `keterangan3`, `revisi3`, `sikap4`, `presentasi4`, `teori4`, `program4`, `jumlah4`, `keterangan4`, `revisi4`, `file1`, `file2`, `file3`, `file4`, `nilai_akhir`, `grade_akhir`, `created_at`, `updated_at`) VALUES
(3, 2, '201851060', 2, 7, 'Lulus', '80', '80', '80', '80', '80', 'Lulus', NULL, '90', '90', '90', '90', '90', 'Lulus', NULL, '80', '80', '80', '74', '77', 'Lulus', NULL, '80', '80', '80', '80', '80', 'Lulus', NULL, NULL, NULL, NULL, NULL, '81.75', 'AB', '2022-02-15 21:32:19', '2022-02-15 21:32:19'),
(4, 2, '201851048', 1, 8, 'Lulus', '80', '80', '80', '80', '80', 'Lulus', NULL, '90', '90', '90', '90', '90', 'Lulus', NULL, '80', '80', '80', '74', '77', 'Lulus', NULL, '80', '80', '80', '80', '80', 'Lulus', NULL, NULL, NULL, NULL, NULL, '81.75', 'AB', '2022-02-15 21:32:19', '2022-02-15 21:32:19');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_sempro`
--

CREATE TABLE `jadwal_sempro` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_semester` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_berkas_sempro` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `tempat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status1` enum('Belum','Sudah') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum',
  `status2` enum('Belum','Sudah') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwal_sempro`
--

INSERT INTO `jadwal_sempro` (`id`, `id_semester`, `nim`, `id_berkas_sempro`, `tanggal`, `jam`, `tempat`, `ket`, `status1`, `status2`, `created_at`, `updated_at`) VALUES
(3, 2, '201851048', 1, '2022-02-14', '09:00:00', 'Zoom Meeting', 'r', 'Sudah', 'Sudah', '2022-02-13 09:14:04', '2022-02-13 09:14:04'),
(4, 2, '201851061', 4, '2022-02-16', '09:00:00', 'Zoom Meeting', 'Link', 'Belum', 'Belum', '2022-02-14 23:40:17', '2022-02-14 23:40:17'),
(5, 2, '201851060', 3, '2022-02-17', '09:00:00', 'Zoom Meeting', 'Link', 'Sudah', 'Sudah', '2022-02-14 23:40:27', '2022-02-14 23:40:27');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_ujian`
--

CREATE TABLE `jadwal_ujian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_semester` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_berkas_ujian` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `tempat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status1` enum('Belum','Sudah') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum',
  `status2` enum('Belum','Sudah') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum',
  `status3` enum('Belum','Sudah') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum',
  `status4` enum('Belum','Sudah') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum',
  `ketua_penguji` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggota_penguji_1` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggota_penguji_2` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwal_ujian`
--

INSERT INTO `jadwal_ujian` (`id`, `id_semester`, `nim`, `id_berkas_ujian`, `tanggal`, `jam`, `tempat`, `ket`, `status1`, `status2`, `status3`, `status4`, `ketua_penguji`, `anggota_penguji_1`, `anggota_penguji_2`, `created_at`, `updated_at`) VALUES
(7, 2, '201851060', 1, '2022-02-20', '09:00:00', 'Zoom', 'Linkk', 'Sudah', 'Sudah', 'Sudah', 'Sudah', '0625028501', '0608068502', '0604048702', '2022-02-15 21:32:19', '2022-02-15 21:32:19'),
(8, 2, '201851048', 1, '2022-02-20', '09:00:00', 'Zoom', 'Linkk', 'Sudah', 'Sudah', 'Sudah', 'Sudah', '0406107004', '0625028501', '0608068502', '2022-02-15 21:32:19', '2022-02-15 21:32:19');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `hp` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `status_proposal` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Belum mengajukan proposal',
  `status_sempro` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Belum seminar proposal',
  `status_bimbingan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Belum melakukan bimbingan',
  `status_skripsi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Belum mengerjakan',
  `status_ujian` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Belum ujian',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nim`, `name`, `email`, `hp`, `status_proposal`, `status_sempro`, `status_bimbingan`, `status_skripsi`, `status_ujian`, `created_at`, `updated_at`) VALUES
(1, '201851048', 'LEONANTA PRAMUDYA KUSUMA', 'leonantapramudya7@gmail.com', '62895392292764', 'Sudah mengajukan proposal', 'Sudah seminar proposal - Diterima', 'Bimbingan Ke-1', 'Sedang dikerjakan', 'Belum ujian', '2022-02-09 07:04:05', '2022-02-09 07:04:05'),
(2, '201851049', 'ANDIKA EKA SAPUTRA', '-', '-', 'Belum mengajukan proposal', 'Belum seminar proposal', 'Belum melakukan bimbingan', 'Belum mengerjakan', 'Belum ujian', '2022-02-13 23:45:12', '2022-02-13 23:45:12'),
(3, '201851060', 'ALFINA FEBRILIANTIKA', 'alfinafebriliantika@gmail.com', '62895392292764', 'Sudah mengajukan proposal', 'Sudah seminar proposal - Diterima', 'Siap ujian', 'Selesai', 'Sudah ujian - Lulus', '2022-02-14 23:31:17', '2022-02-14 23:31:17'),
(4, '201851061', 'AGUSTINA WAHYU RAHMAPUTRI', 'agustina@gmail.com', '62895392292764', 'Sudah mengajukan proposal', 'Belum seminar proposal', 'Belum melakukan bimbingan', 'Belum mengerjakan', 'Belum ujian', '2022-02-14 23:31:46', '2022-02-14 23:31:46');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_12_28_025642_create_semester_table', 1),
(5, '2021_12_28_025750_create_s1_table', 1),
(6, '2021_12_28_025839_create_s2_table', 1),
(7, '2021_12_28_025859_create_s3_table', 1),
(8, '2021_12_28_025953_create_bidang_table', 1),
(9, '2021_12_28_030048_create_mahasiswa_table', 1),
(10, '2021_12_28_030314_create_dosen_table', 1),
(11, '2021_12_28_030519_create_plot_dosbing_table', 1),
(12, '2021_12_28_030858_create_proposal_table', 1),
(13, '2021_12_28_031129_create_berkas_sempro_table', 1),
(14, '2021_12_28_031220_create_jadwal_sempro_table', 1),
(15, '2021_12_28_031430_create_hasil_sempro_table', 1),
(16, '2021_12_28_035230_create_status_skripsi_table', 1),
(17, '2021_12_28_035357_create_bimbingan_table', 1),
(18, '2021_12_28_035442_create_pesan_bimbingan_table', 1),
(19, '2021_12_28_035603_create_plot_penguji_table', 1),
(20, '2021_12_28_041310_create_berkas_ujian_table', 1),
(21, '2021_12_28_041431_create_jadwal_ujian_table', 1),
(22, '2021_12_28_041547_create_hasil_ujian_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesan_bimbingan`
--

CREATE TABLE `pesan_bimbingan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_bimbingan` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_pendukung` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pesan_bimbingan`
--

INSERT INTO `pesan_bimbingan` (`id`, `id_bimbingan`, `id_user`, `pesan`, `file_pendukung`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'Rev', NULL, '2022-02-14 17:29:04', '2022-02-14 10:29:04');

-- --------------------------------------------------------

--
-- Table structure for table `plot_dosbing`
--

CREATE TABLE `plot_dosbing` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `smt` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nim` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dosbing1` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dosbing2` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plot_dosbing`
--

INSERT INTO `plot_dosbing` (`id`, `smt`, `nim`, `name`, `dosbing1`, `dosbing2`, `created_at`, `updated_at`) VALUES
(1, 'GASAL 2021/2022', '201851048', 'LEONANTA PRAMUDYA KUSUMA', '0625028501', '0604048702', NULL, NULL),
(2, 'GENAP 2021/2022', '201851049', 'ANDIKA EKA SAPUTRA', '0625028501', '0604048702', NULL, NULL),
(3, 'GENAP 2021/2022', '201851060', 'ALFINA FEBRILIANTIKA', '0608068502', '0406107004', NULL, NULL),
(4, 'GENAP 2021/2022', '201851061', 'AGUSTINA WAHYU RAHMAPUTRI', '0608068502', '0406107004', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `plot_penguji`
--

CREATE TABLE `plot_penguji` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `smt` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nim` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ketua_penguji` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggota_penguji_1` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggota_penguji_2` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proposal`
--

CREATE TABLE `proposal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_semester` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `topik` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proposal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket1` enum('Menunggu ACC','Disetujui','Ditolak','Revisi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu ACC',
  `ket2` enum('Menunggu ACC','Disetujui','Ditolak','Revisi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu ACC',
  `id_plot_dosbing` bigint(20) UNSIGNED NOT NULL,
  `komentar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `komentar1` text COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `komentar2` text COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `file1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `proposal`
--

INSERT INTO `proposal` (`id`, `id_semester`, `nim`, `topik`, `judul`, `proposal`, `ket1`, `ket2`, `id_plot_dosbing`, `komentar`, `komentar1`, `komentar2`, `file1`, `file2`, `created_at`, `updated_at`) VALUES
(1, 1, '201851048', 'Rekayasa Perangkat Lunak', 'Sistem Monitoring Skripsi', '1236740955Proposal.pdf', 'Disetujui', 'Disetujui', 1, 'Proposal', '-', '-', NULL, NULL, '2022-02-09 07:14:14', '2022-02-09 07:14:14'),
(2, 2, '201851060', 'Komputasi Terapan', 'Sistem Kelola Karyawan', '607743662Proposal.pdf', 'Disetujui', 'Disetujui', 3, NULL, '-', '-', NULL, NULL, '2022-02-14 23:32:50', '2022-02-14 23:32:50'),
(3, 2, '201851061', 'Jaringan Komputer', 'Jaringan RT/RW NET', '1224993828Proposal.pdf', 'Disetujui', 'Disetujui', 4, NULL, '-', '-', NULL, NULL, '2022-02-14 23:33:34', '2022-02-14 23:33:34');

-- --------------------------------------------------------

--
-- Table structure for table `s1`
--

CREATE TABLE `s1` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gelar` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `s1`
--

INSERT INTO `s1` (`id`, `gelar`, `created_at`, `updated_at`) VALUES
(1, 'S. Kom', '2022-02-09 07:01:46', '2022-02-09 07:01:46');

-- --------------------------------------------------------

--
-- Table structure for table `s2`
--

CREATE TABLE `s2` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gelar` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `s2`
--

INSERT INTO `s2` (`id`, `gelar`, `created_at`, `updated_at`) VALUES
(1, 'M. Kom', '2022-02-09 07:01:53', '2022-02-09 07:01:53'),
(2, 'M. Cs', '2022-02-09 07:01:57', '2022-02-09 07:01:57');

-- --------------------------------------------------------

--
-- Table structure for table `s3`
--

CREATE TABLE `s3` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gelar` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `depan` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `s3`
--

INSERT INTO `s3` (`id`, `gelar`, `depan`, `created_at`, `updated_at`) VALUES
(1, 'Dr.', 'Y', '2022-02-09 07:02:04', '2022-02-09 07:02:04');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `semester` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`id`, `semester`, `tahun`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'GASAL', '2021/2022', 'N', NULL, NULL),
(2, 'GENAP', '2021/2022', 'Y', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `status_skripsi`
--

CREATE TABLE `status_skripsi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_proposal` bigint(20) UNSIGNED NOT NULL,
  `status_skripsi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sedang dikerjakan',
  `status_ujian` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum ujian',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_skripsi`
--

INSERT INTO `status_skripsi` (`id`, `nim`, `id_proposal`, `status_skripsi`, `status_ujian`, `created_at`, `updated_at`) VALUES
(1, '201851048', 1, 'Sedang dikerjakan', 'Belum ujian', '2022-02-13 09:09:40', '2022-02-13 09:09:40'),
(2, '201851048', 1, 'Sedang dikerjakan', 'Belum ujian', '2022-02-13 09:15:21', '2022-02-13 09:15:21'),
(3, '201851060', 2, 'Selesai', 'Sudah ujian - Lulus', '2022-02-14 23:43:50', '2022-02-14 23:43:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_induk` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','dosen','mahasiswa') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mahasiswa',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'undraw_profile.svg',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `no_induk`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `photo`, `created_at`, `updated_at`) VALUES
(1, '12345678910', 'Admin', 'adminskripsi', 'admin@gmail.com', '2022-02-09 07:00:53', '$2y$10$cGCioQDlVCjpqblx8OjVrOGNWBwUZ6vANLF0UqVDETFGdpwF0RCpS', NULL, 'admin', 'undraw_profile.svg', '2022-02-09 07:00:53', NULL),
(2, '0406107004', 'Ahmad Jazuli, S. Kom, M. Kom, ', '0406107004', 'ahmad.jazuli@umk.ac.id', NULL, '$2y$10$3dXSgVOUEhK3kXVcP8uk/Od83yAcKs3BLCzsmhezii4jJftkFWrVO', NULL, 'dosen', 'undraw_profile.svg', NULL, NULL),
(3, '0625028501', 'Ratih Nindyasari, S. Kom, M. Kom, ', '0625028501', 'ratih.nindyasari@umk.ac.id', NULL, '$2y$10$GRRrvav9jp/XXGN/yN6ULuAq.ORx3iErxJElOLiXdNpdDjTXiQ/Sy', NULL, 'dosen', 'undraw_profile.svg', NULL, NULL),
(4, '0604048702', 'Anastasya Latubessy, S. Kom, M. Cs, ', '0604048702', 'anastasya.latubessy@umk.ac.id', NULL, '$2y$10$pQsjrP7.E.pRdFEfkZOHX.1j4PhTpkzQ5A1cIoUja0b8MwFcPbi8m', NULL, 'dosen', 'undraw_profile.svg', NULL, NULL),
(5, '0608068502', 'Tutik Khotimah, S. Kom, M. Kom, ', '0608068502', 'tutik.khotimah@umk.ac.id', NULL, '$2y$10$FoQNrLKzEFyNfY68uG/JBOhVTLyoUImNl4j6L.KcvoeyAXdHpHmz6', NULL, 'dosen', 'undraw_profile.svg', NULL, NULL),
(6, '201851048', 'LEONANTA PRAMUDYA KUSUMA', '201851048', 'leonantapramudya7@gmail.com', NULL, '$2y$10$Gk0A3cvET6VapZJw3NZQme85TK5YCr.ppVIoc.lcUZ6Opsf1dDre6', NULL, 'mahasiswa', 'undraw_profile.svg', NULL, NULL),
(7, '201851049', 'ANDIKA EKA SAPUTRA', '201851049', NULL, NULL, '$2y$10$NQ6eD5sAz6TE8r9zymhJ..5dESlDQuoc4fycwmkF/FNFK2Q.tXpnu', NULL, 'mahasiswa', 'undraw_profile.svg', NULL, NULL),
(8, '201851060', 'ALFINA FEBRILIANTIKA', '201851060', 'alfinafebriliantika@gmail.com', NULL, '$2y$10$Qz3Kpv18NzdwBOlU5/jLDORJrTqFvMGTYCmX7LSnbWGmeRHY.mRRe', NULL, 'mahasiswa', 'undraw_profile.svg', NULL, NULL),
(9, '201851061', 'AGUSTINA WAHYU RAHMAPUTRI', '201851061', 'agustina@gmail.com', NULL, '$2y$10$XSYYTP.ZJ2UjxNph9gKsqOZSn89Nm.9YGmMWzCcrXRrtZ5N.p.b8O', NULL, 'mahasiswa', 'undraw_profile.svg', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berkas_sempro`
--
ALTER TABLE `berkas_sempro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `berkas_sempro_id_semester_foreign` (`id_semester`),
  ADD KEY `berkas_sempro_nim_foreign` (`nim`),
  ADD KEY `berkas_sempro_id_proposal_foreign` (`id_proposal`),
  ADD KEY `berkas_sempro_id_plot_dosbing_foreign` (`id_plot_dosbing`);

--
-- Indexes for table `berkas_ujian`
--
ALTER TABLE `berkas_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `berkas_ujian_id_semester_foreign` (`id_semester`),
  ADD KEY `berkas_ujian_nim_foreign` (`nim`),
  ADD KEY `berkas_ujian_id_proposal_foreign` (`id_proposal`);

--
-- Indexes for table `bidang`
--
ALTER TABLE `bidang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bimbingan`
--
ALTER TABLE `bimbingan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bimbingan_id_semester_foreign` (`id_semester`),
  ADD KEY `bimbingan_nim_foreign` (`nim`),
  ADD KEY `bimbingan_id_proposal_foreign` (`id_proposal`),
  ADD KEY `bimbingan_id_plot_dosbing_foreign` (`id_plot_dosbing`),
  ADD KEY `bimbingan_kepada` (`bimbingan_kepada`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dosen_nidn_unique` (`nidn`),
  ADD KEY `dosen_gelar1_foreign` (`gelar1`),
  ADD KEY `dosen_gelar2_foreign` (`gelar2`),
  ADD KEY `dosen_gelar3_foreign` (`gelar3`),
  ADD KEY `dosen_id_bidang_foreign` (`id_bidang`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hasil_sempro`
--
ALTER TABLE `hasil_sempro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hasil_sempro_id_semester_foreign` (`id_semester`),
  ADD KEY `hasil_sempro_nim_foreign` (`nim`),
  ADD KEY `hasil_sempro_id_proposal_foreign` (`id_proposal`),
  ADD KEY `hasil_sempro_id_jadwal_sempro_foreign` (`id_jadwal_sempro`);

--
-- Indexes for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hasil_ujian_id_semester_foreign` (`id_semester`),
  ADD KEY `hasil_ujian_nim_foreign` (`nim`),
  ADD KEY `hasil_ujian_id_proposal_foreign` (`id_proposal`),
  ADD KEY `hasil_ujian_id_jadwal_ujian_foreign` (`id_jadwal_ujian`);

--
-- Indexes for table `jadwal_sempro`
--
ALTER TABLE `jadwal_sempro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_sempro_id_semester_foreign` (`id_semester`),
  ADD KEY `jadwal_sempro_nim_foreign` (`nim`),
  ADD KEY `jadwal_sempro_id_berkas_sempro_foreign` (`id_berkas_sempro`);

--
-- Indexes for table `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_ujian_id_semester_foreign` (`id_semester`),
  ADD KEY `jadwal_ujian_nim_foreign` (`nim`),
  ADD KEY `jadwal_ujian_id_berkas_ujian_foreign` (`id_berkas_ujian`),
  ADD KEY `ketua_penguji` (`ketua_penguji`),
  ADD KEY `anggota_penguji_1` (`anggota_penguji_1`),
  ADD KEY `anggota_penguji_2` (`anggota_penguji_2`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mahasiswa_nim_unique` (`nim`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pesan_bimbingan`
--
ALTER TABLE `pesan_bimbingan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesan_bimbingan_id_bimbingan_foreign` (`id_bimbingan`),
  ADD KEY `pesan_bimbingan_id_user_foreign` (`id_user`);

--
-- Indexes for table `plot_dosbing`
--
ALTER TABLE `plot_dosbing`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plot_dosbing_nim_unique` (`nim`),
  ADD KEY `plot_dosbing_dosbing1_foreign` (`dosbing1`),
  ADD KEY `plot_dosbing_dosbing2_foreign` (`dosbing2`);

--
-- Indexes for table `plot_penguji`
--
ALTER TABLE `plot_penguji`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plot_penguji_nim_unique` (`nim`),
  ADD KEY `plot_penguji_ketua_penguji_foreign` (`ketua_penguji`),
  ADD KEY `plot_penguji_anggota_penguji_1_foreign` (`anggota_penguji_1`),
  ADD KEY `plot_penguji_anggota_penguji_2_foreign` (`anggota_penguji_2`);

--
-- Indexes for table `proposal`
--
ALTER TABLE `proposal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proposal_id_semester_foreign` (`id_semester`),
  ADD KEY `proposal_nim_foreign` (`nim`),
  ADD KEY `proposal_id_plot_dosbing_foreign` (`id_plot_dosbing`);

--
-- Indexes for table `s1`
--
ALTER TABLE `s1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `s2`
--
ALTER TABLE `s2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `s3`
--
ALTER TABLE `s3`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_skripsi`
--
ALTER TABLE `status_skripsi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_skripsi_nim_foreign` (`nim`),
  ADD KEY `status_skripsi_id_proposal_foreign` (`id_proposal`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_no_induk_unique` (`no_induk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berkas_sempro`
--
ALTER TABLE `berkas_sempro`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `berkas_ujian`
--
ALTER TABLE `berkas_ujian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bidang`
--
ALTER TABLE `bidang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bimbingan`
--
ALTER TABLE `bimbingan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hasil_sempro`
--
ALTER TABLE `hasil_sempro`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jadwal_sempro`
--
ALTER TABLE `jadwal_sempro`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pesan_bimbingan`
--
ALTER TABLE `pesan_bimbingan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `plot_dosbing`
--
ALTER TABLE `plot_dosbing`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `plot_penguji`
--
ALTER TABLE `plot_penguji`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `proposal`
--
ALTER TABLE `proposal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `s1`
--
ALTER TABLE `s1`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `s2`
--
ALTER TABLE `s2`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `s3`
--
ALTER TABLE `s3`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status_skripsi`
--
ALTER TABLE `status_skripsi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `berkas_sempro`
--
ALTER TABLE `berkas_sempro`
  ADD CONSTRAINT `berkas_sempro_id_plot_dosbing_foreign` FOREIGN KEY (`id_plot_dosbing`) REFERENCES `plot_dosbing` (`id`),
  ADD CONSTRAINT `berkas_sempro_id_proposal_foreign` FOREIGN KEY (`id_proposal`) REFERENCES `proposal` (`id`),
  ADD CONSTRAINT `berkas_sempro_id_semester_foreign` FOREIGN KEY (`id_semester`) REFERENCES `semester` (`id`),
  ADD CONSTRAINT `berkas_sempro_nim_foreign` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`);

--
-- Constraints for table `bimbingan`
--
ALTER TABLE `bimbingan`
  ADD CONSTRAINT `bimbingan_ibfk_1` FOREIGN KEY (`bimbingan_kepada`) REFERENCES `dosen` (`nidn`),
  ADD CONSTRAINT `bimbingan_id_plot_dosbing_foreign` FOREIGN KEY (`id_plot_dosbing`) REFERENCES `plot_dosbing` (`id`),
  ADD CONSTRAINT `bimbingan_id_proposal_foreign` FOREIGN KEY (`id_proposal`) REFERENCES `proposal` (`id`),
  ADD CONSTRAINT `bimbingan_id_semester_foreign` FOREIGN KEY (`id_semester`) REFERENCES `semester` (`id`),
  ADD CONSTRAINT `bimbingan_nim_foreign` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`);

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_gelar1_foreign` FOREIGN KEY (`gelar1`) REFERENCES `s1` (`id`),
  ADD CONSTRAINT `dosen_gelar2_foreign` FOREIGN KEY (`gelar2`) REFERENCES `s2` (`id`),
  ADD CONSTRAINT `dosen_gelar3_foreign` FOREIGN KEY (`gelar3`) REFERENCES `s3` (`id`),
  ADD CONSTRAINT `dosen_id_bidang_foreign` FOREIGN KEY (`id_bidang`) REFERENCES `bidang` (`id`);

--
-- Constraints for table `hasil_sempro`
--
ALTER TABLE `hasil_sempro`
  ADD CONSTRAINT `hasil_sempro_id_jadwal_sempro_foreign` FOREIGN KEY (`id_jadwal_sempro`) REFERENCES `jadwal_sempro` (`id`),
  ADD CONSTRAINT `hasil_sempro_id_proposal_foreign` FOREIGN KEY (`id_proposal`) REFERENCES `proposal` (`id`),
  ADD CONSTRAINT `hasil_sempro_id_semester_foreign` FOREIGN KEY (`id_semester`) REFERENCES `semester` (`id`),
  ADD CONSTRAINT `hasil_sempro_nim_foreign` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`);

--
-- Constraints for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  ADD CONSTRAINT `hasil_ujian_id_jadwal_ujian_foreign` FOREIGN KEY (`id_jadwal_ujian`) REFERENCES `jadwal_ujian` (`id`),
  ADD CONSTRAINT `hasil_ujian_id_proposal_foreign` FOREIGN KEY (`id_proposal`) REFERENCES `proposal` (`id`),
  ADD CONSTRAINT `hasil_ujian_id_semester_foreign` FOREIGN KEY (`id_semester`) REFERENCES `semester` (`id`),
  ADD CONSTRAINT `hasil_ujian_nim_foreign` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`);

--
-- Constraints for table `jadwal_sempro`
--
ALTER TABLE `jadwal_sempro`
  ADD CONSTRAINT `jadwal_sempro_id_berkas_sempro_foreign` FOREIGN KEY (`id_berkas_sempro`) REFERENCES `berkas_sempro` (`id`),
  ADD CONSTRAINT `jadwal_sempro_id_semester_foreign` FOREIGN KEY (`id_semester`) REFERENCES `semester` (`id`),
  ADD CONSTRAINT `jadwal_sempro_nim_foreign` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`);

--
-- Constraints for table `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  ADD CONSTRAINT `jadwal_ujian_ibfk_1` FOREIGN KEY (`ketua_penguji`) REFERENCES `dosen` (`nidn`),
  ADD CONSTRAINT `jadwal_ujian_ibfk_2` FOREIGN KEY (`anggota_penguji_1`) REFERENCES `dosen` (`nidn`),
  ADD CONSTRAINT `jadwal_ujian_ibfk_3` FOREIGN KEY (`anggota_penguji_2`) REFERENCES `dosen` (`nidn`),
  ADD CONSTRAINT `jadwal_ujian_id_berkas_ujian_foreign` FOREIGN KEY (`id_berkas_ujian`) REFERENCES `berkas_ujian` (`id`),
  ADD CONSTRAINT `jadwal_ujian_id_semester_foreign` FOREIGN KEY (`id_semester`) REFERENCES `semester` (`id`),
  ADD CONSTRAINT `jadwal_ujian_nim_foreign` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`);

--
-- Constraints for table `pesan_bimbingan`
--
ALTER TABLE `pesan_bimbingan`
  ADD CONSTRAINT `pesan_bimbingan_id_bimbingan_foreign` FOREIGN KEY (`id_bimbingan`) REFERENCES `bimbingan` (`id`),
  ADD CONSTRAINT `pesan_bimbingan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `plot_dosbing`
--
ALTER TABLE `plot_dosbing`
  ADD CONSTRAINT `plot_dosbing_dosbing1_foreign` FOREIGN KEY (`dosbing1`) REFERENCES `dosen` (`nidn`),
  ADD CONSTRAINT `plot_dosbing_dosbing2_foreign` FOREIGN KEY (`dosbing2`) REFERENCES `dosen` (`nidn`);

--
-- Constraints for table `plot_penguji`
--
ALTER TABLE `plot_penguji`
  ADD CONSTRAINT `plot_penguji_anggota_penguji_1_foreign` FOREIGN KEY (`anggota_penguji_1`) REFERENCES `dosen` (`nidn`),
  ADD CONSTRAINT `plot_penguji_anggota_penguji_2_foreign` FOREIGN KEY (`anggota_penguji_2`) REFERENCES `dosen` (`nidn`),
  ADD CONSTRAINT `plot_penguji_ketua_penguji_foreign` FOREIGN KEY (`ketua_penguji`) REFERENCES `dosen` (`nidn`);

--
-- Constraints for table `proposal`
--
ALTER TABLE `proposal`
  ADD CONSTRAINT `proposal_id_plot_dosbing_foreign` FOREIGN KEY (`id_plot_dosbing`) REFERENCES `plot_dosbing` (`id`),
  ADD CONSTRAINT `proposal_id_semester_foreign` FOREIGN KEY (`id_semester`) REFERENCES `semester` (`id`),
  ADD CONSTRAINT `proposal_nim_foreign` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`);

--
-- Constraints for table `status_skripsi`
--
ALTER TABLE `status_skripsi`
  ADD CONSTRAINT `status_skripsi_id_proposal_foreign` FOREIGN KEY (`id_proposal`) REFERENCES `proposal` (`id`),
  ADD CONSTRAINT `status_skripsi_nim_foreign` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
