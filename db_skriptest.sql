-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2022 at 07:02 AM
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
  `status` enum('Menunggu Dijadwalkan','Berkas OK','Berkas tidak lengkap','Terjadwal','Menunggu Verifikasi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu Verifikasi',
  `komentar_admin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `berkas_ujian`
--

CREATE TABLE `berkas_ujian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_semester` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_proposal` bigint(20) UNSIGNED NOT NULL,
  `berkas_ujian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Menunggu Dijadwalkan','Berkas OK','Berkas tidak lengkap','Terjadwal','Menunggu Verifikasi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu Verifikasi',
  `komentar_admin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'Jaringan Komputer', '2022-03-27 18:26:03', NULL),
(2, 'Bisnis Cerdas & Visi Komputer', '2022-03-27 18:26:03', NULL),
(3, 'Komputer Grafis', '2022-03-27 18:26:03', NULL),
(4, 'Komputasi Terapan', '2022-03-27 18:26:03', NULL),
(5, 'Rekayasa Perangkat Lunak', '2022-03-27 18:26:03', NULL);

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
  `ket1` enum('Review','Ok','Lanjut ke bimbingan selanjutnya','Siap ujian') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Review',
  `ket2` enum('Review','Ok','Lanjut ke bimbingan selanjutnya','Siap ujian') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Review',
  `bimbingan_kepada` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0406107004', 'Ahmad Jazuli', 1, 1, NULL, 'Asisten Ahli', 4, 'ahmad.jazuli@umk.ac.id', 'ttd jay.png', '2022-03-27 18:36:50', '2022-03-27 18:36:50'),
(2, '0625028501', 'Ratih Nindyasari', 1, 1, NULL, 'Lektor', 5, 'ratih.nindyasari@umk.ac.id', 'ttd ratih.png', '2022-03-27 18:37:34', '2022-03-27 18:37:34'),
(3, '0604048702', 'Anastasya Latubessy', 1, 2, NULL, 'Lektor', 2, 'anastasya.latubessy@umk.ac.id', 'ttd tasya.png', '2022-03-27 18:38:02', '2022-03-27 18:38:02'),
(4, '0608068502', 'Tutik Khotimah', 1, 1, NULL, 'Lektor', 3, 'tutik.khotimah@umk.ac.id', 'ttd tutik.png', '2022-03-27 18:38:35', '2022-03-27 18:38:35');

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
  `nilai_akhir` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `grade_akhir` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(19, '2021_12_28_041310_create_berkas_ujian_table', 1),
(20, '2021_12_28_041431_create_jadwal_ujian_table', 1),
(21, '2021_12_28_041547_create_hasil_ujian_table', 1),
(22, '2022_03_12_050940_create_pengumuman_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('leonantapramudya7@gmail.com', '$2y$10$UjPkekpJOwtQZWA2jW5e0OS41eoC4A6LjvVFwjpknPpV2rZAE1joG', '2022-07-06 06:15:30'),
('rama@gmail.com', '$2y$10$VB65GjHaHegMhu9wKjdMmurYPdy6aSJkT793JIKyoqslDQXs/491.', '2022-07-06 06:17:44'),
('alfina@gmail.com', '$2y$10$dL0BCRAbHkTVsq4E52Pqqu06R0F9ZjyNx0DYC4LwseyHUS0DlPbt6', '2022-07-07 20:32:11');

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul`, `deskripsi`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'Beasiswa Kampus Merdeka', '<p>Silahkan klik link di bawah ini</p>\r\n<p><a href=\"https://sib-b3.dicodingacademy.com/\" target=\"_blank\" rel=\"noopener\">Link&nbsp;</a></p>', '[[FEED]] Slide 4 Opening registration SIB.jpg', '2022-03-28 01:31:31', '2022-07-07 13:16:18');

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
  `dosbing2` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT '-',
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
(1, 'S. Kom.', '2022-03-27 18:27:24', '2022-03-27 18:27:24'),
(2, 'S. Tr.', '2022-07-08 02:14:51', '2022-07-08 02:14:51');

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
(1, 'M. Kom.', '2022-03-27 18:27:37', '2022-03-27 18:27:37'),
(2, 'M. Cs.', '2022-03-27 18:27:41', '2022-03-27 18:27:41');

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
(1, 'Dr.', 'Y', '2022-03-27 18:27:49', '2022-03-27 18:27:49'),
(2, 'Ph.D.', 'N', '2022-03-27 18:27:55', '2022-03-27 18:27:55');

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
(2, 'GENAP', '2021/2022', 'Y', '2022-03-27 18:27:00', '2022-03-27 18:27:00'),
(3, 'GASAL', '2021/2022', 'N', '2022-07-07 06:17:54', '2022-07-07 06:17:54');

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
(1, '12345678910', 'Admin', 'adminskripsi', 'admin@gmail.com', '2022-03-27 18:26:03', '$2y$10$AEkU1eXTjcfhBEf.oxf7luNihUbkNMOJv.3kDy1qkm7M4/IqbO7la', NULL, 'admin', 'undraw_profile.svg', '2022-03-27 18:26:03', NULL),
(2, '0406107004', 'Ahmad Jazuli, S. Kom., M. Kom.', '0406107004', 'ahmad.jazuli@umk.ac.id', NULL, '$2y$10$4yHxdgBDKZ64hr93UhyNiedUVhE562rtHL9ZNqRyh7fDXhKQuxWai', NULL, 'dosen', 'undraw_profile.svg', NULL, NULL),
(3, '0625028501', 'Ratih Nindyasari, S. Kom., M. Kom.', '0625028501', 'ratih.nindyasari@umk.ac.id', NULL, '$2y$10$wTclSVg6A6phaWVrh8AiFuv4iNR0Ji7WW4yHRumSBxM64YKKeEQSi', NULL, 'dosen', 'undraw_profile.svg', NULL, NULL),
(4, '0604048702', 'Anastasya Latubessy, S. Kom., M. Cs.', '0604048702', 'anastasya.latubessy@umk.ac.id', NULL, '$2y$10$Q1QMzNazwm4KzutiDpoHS.ixfhjW3W5UMKTiszlXvAf0BzNrDz7uq', NULL, 'dosen', 'undraw_profile.svg', NULL, NULL),
(5, '0608068502', 'Tutik Khotimah, S. Kom., M. Kom.', '0608068502', 'tutik.khotimah@umk.ac.id', NULL, '$2y$10$5Rb.nQD45OedyCC312QcZOJsjnNWhONJa71GTe7TvmW8seL5yLYW.', NULL, 'dosen', 'undraw_profile.svg', NULL, NULL);

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
  ADD KEY `bimbingan_bimbingan_kepada_foreign` (`bimbingan_kepada`);

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
  ADD KEY `jadwal_ujian_ketua_penguji_foreign` (`ketua_penguji`),
  ADD KEY `jadwal_ujian_anggota_penguji_1_foreign` (`anggota_penguji_1`),
  ADD KEY `jadwal_ujian_anggota_penguji_2_foreign` (`anggota_penguji_2`);

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
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `berkas_ujian`
--
ALTER TABLE `berkas_ujian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `bidang`
--
ALTER TABLE `bidang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bimbingan`
--
ALTER TABLE `bimbingan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jadwal_sempro`
--
ALTER TABLE `jadwal_sempro`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pesan_bimbingan`
--
ALTER TABLE `pesan_bimbingan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `plot_dosbing`
--
ALTER TABLE `plot_dosbing`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `proposal`
--
ALTER TABLE `proposal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `s1`
--
ALTER TABLE `s1`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `s2`
--
ALTER TABLE `s2`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `s3`
--
ALTER TABLE `s3`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `status_skripsi`
--
ALTER TABLE `status_skripsi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
-- Constraints for table `berkas_ujian`
--
ALTER TABLE `berkas_ujian`
  ADD CONSTRAINT `berkas_ujian_id_proposal_foreign` FOREIGN KEY (`id_proposal`) REFERENCES `proposal` (`id`),
  ADD CONSTRAINT `berkas_ujian_id_semester_foreign` FOREIGN KEY (`id_semester`) REFERENCES `semester` (`id`),
  ADD CONSTRAINT `berkas_ujian_nim_foreign` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`);

--
-- Constraints for table `bimbingan`
--
ALTER TABLE `bimbingan`
  ADD CONSTRAINT `bimbingan_bimbingan_kepada_foreign` FOREIGN KEY (`bimbingan_kepada`) REFERENCES `dosen` (`nidn`),
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
  ADD CONSTRAINT `jadwal_ujian_anggota_penguji_1_foreign` FOREIGN KEY (`anggota_penguji_1`) REFERENCES `dosen` (`nidn`),
  ADD CONSTRAINT `jadwal_ujian_anggota_penguji_2_foreign` FOREIGN KEY (`anggota_penguji_2`) REFERENCES `dosen` (`nidn`),
  ADD CONSTRAINT `jadwal_ujian_id_berkas_ujian_foreign` FOREIGN KEY (`id_berkas_ujian`) REFERENCES `berkas_ujian` (`id`),
  ADD CONSTRAINT `jadwal_ujian_id_semester_foreign` FOREIGN KEY (`id_semester`) REFERENCES `semester` (`id`),
  ADD CONSTRAINT `jadwal_ujian_ketua_penguji_foreign` FOREIGN KEY (`ketua_penguji`) REFERENCES `dosen` (`nidn`),
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
