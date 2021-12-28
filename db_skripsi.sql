-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2021 at 03:02 PM
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
-- Database: `db_skripsi`
--

-- --------------------------------------------------------

--
-- Table structure for table `berkas_sempro`
--

CREATE TABLE `berkas_sempro` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_proposal` bigint(20) UNSIGNED NOT NULL,
  `id_plot_dosbing` bigint(20) UNSIGNED NOT NULL,
  `berkas_sempro` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Menunggu Dijadwalkan','Terjadwal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu Dijadwalkan',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `berkas_ujian`
--

CREATE TABLE `berkas_ujian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_proposal` bigint(20) UNSIGNED NOT NULL,
  `id_plot_penguji` bigint(20) UNSIGNED NOT NULL,
  `berkas_ujian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Menunggu Dijadwalkan','Terjadwal') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bidang`
--

CREATE TABLE `bidang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_bidang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bidang`
--

INSERT INTO `bidang` (`id`, `nama_bidang`, `created_at`, `updated_at`) VALUES
(1, 'Website', NULL, NULL),
(2, 'Android', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bimbingan`
--

CREATE TABLE `bimbingan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_semester` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_proposal` bigint(20) UNSIGNED NOT NULL,
  `id_plot_dosbing` bigint(20) UNSIGNED NOT NULL,
  `bimbingan_ke` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bab` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `komentar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket1` enum('Review','Ok','Selesai Bimbingan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Review',
  `ket2` enum('Review','Ok','Selesai Bimbingan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Review',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nidn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gelar1` bigint(20) UNSIGNED NOT NULL,
  `gelar2` bigint(20) UNSIGNED DEFAULT NULL,
  `gelar3` bigint(20) UNSIGNED DEFAULT NULL,
  `jabatan_fungsional` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_bidang` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hasil_sempro`
--

CREATE TABLE `hasil_sempro` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_proposal` bigint(20) UNSIGNED NOT NULL,
  `id_jadwal_sempro` bigint(20) UNSIGNED DEFAULT NULL,
  `berita_acara` enum('Diterima','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Diterima',
  `sikap1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presentasi1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penguasaan1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revisi1` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sikap2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presentasi2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penguasaan2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revisi2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hasil_ujian`
--

CREATE TABLE `hasil_ujian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_proposal` bigint(20) UNSIGNED NOT NULL,
  `id_jadwal_ujian` bigint(20) UNSIGNED DEFAULT NULL,
  `berita_acara` enum('Lulus','Tidak Lulus') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Lulus',
  `sikap1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presentasi1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teori1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revisi1` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sikap2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presentasi2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teori2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revisi2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sikap3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presentasi3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teori3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revisi3` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_sempro`
--

CREATE TABLE `jadwal_sempro` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_berkas_sempro` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `tempat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status1` enum('Belum','Sudah') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum',
  `status2` enum('Belum','Sudah') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_ujian`
--

CREATE TABLE `jadwal_ujian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_berkas_ujian` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `tempat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status1` enum('Belum','Sudah') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum',
  `status2` enum('Belum','Sudah') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum',
  `status3` enum('Belum','Sudah') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
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
(4, '2021_10_08_052033_create_dosen_table', 2),
(5, '2021_10_08_120045_create_mahasiswa_table', 3),
(6, '2021_10_11_120126_create_plot_dosbing_table', 4),
(7, '2021_10_11_121722_create_table_dosen', 5),
(8, '2021_10_11_130028_create_plot_dosbing_table', 6),
(9, '2021_10_12_020848_create_proposal_table', 7),
(10, '2021_10_12_143001_create_berkas_sempro_table', 8),
(11, '2021_10_13_131031_create_jadwal_sempro_table', 9),
(12, '2021_10_18_005758_create_semester_table', 10),
(13, '2021_10_27_020205_create_hasil_sempro_table', 11),
(14, '2021_10_27_021334_create_hasil_sempro_table', 12),
(15, '2021_10_27_022758_create_hasil_sempro_table', 13),
(16, '2021_11_03_013754_create_bimbingan_table', 14),
(17, '2021_11_03_014928_create_pesan_bimbingan_table', 14),
(18, '2021_11_04_031658_create_status_skripsi_table', 15),
(19, '2021_12_08_113707_create_bidang_table', 16),
(20, '2021_12_08_123842_create_s1_table', 16),
(21, '2021_12_08_123945_create_s2_table', 16),
(22, '2021_12_08_124007_create_s3_table', 16),
(23, '2021_12_15_021724_create_berkas_ujian_table', 17),
(24, '2021_12_15_021800_create_jadwal_ujian_table', 17),
(25, '2021_12_15_021823_create_hasil_ujian_table', 17);

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
('leonantapramudya7@gmail.com', '$2y$10$UfTytnMY.xaEc2.g9fxME.OdAjrgrT3yoDmwoPcdnUeCsDqrCkcD.', '2021-10-27 08:52:23');

-- --------------------------------------------------------

--
-- Table structure for table `pesan_bimbingan`
--

CREATE TABLE `pesan_bimbingan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_bimbingan` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `pesan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plot_dosbing`
--

CREATE TABLE `plot_dosbing` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `smt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dosbing1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dosbing2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plot_penguji`
--

CREATE TABLE `plot_penguji` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `smt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ketua_penguji` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggota_penguji_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggota_penguji_2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `topik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proposal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket1` enum('Menunggu ACC','Disetujui','Ditolak','Revisi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu ACC',
  `ket2` enum('Menunggu ACC','Disetujui','Ditolak','Revisi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu ACC',
  `id_plot_dosbing` bigint(20) UNSIGNED NOT NULL,
  `komentar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `komentar1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `komentar2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `s1`
--

CREATE TABLE `s1` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gelar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `s1`
--

INSERT INTO `s1` (`id`, `gelar`, `created_at`, `updated_at`) VALUES
(1, 'S.Ag.', NULL, NULL),
(2, 'S.Pd.', NULL, NULL),
(3, 'S.Si.', NULL, NULL),
(4, 'S.Psi.', NULL, NULL),
(5, 'S.Hum.', NULL, NULL),
(6, 'S.Kom.', NULL, NULL),
(7, 'S.Sn.', NULL, NULL),
(8, 'S.Pt.', NULL, NULL),
(9, 'S.Ked.', NULL, NULL),
(10, 'S.Th.I.', NULL, NULL),
(11, 'S.Kes.', NULL, NULL),
(12, 'S.Sos.', NULL, NULL),
(13, 'S.Kar.', NULL, NULL),
(14, 'S.Fhil.', NULL, NULL),
(15, 'S.T.', NULL, NULL),
(16, 'S.P.', NULL, NULL),
(17, 'S.S.', NULL, NULL),
(18, 'S.H.', NULL, NULL),
(19, 'S.E.', NULL, NULL),
(20, 'S.Th.K.', NULL, NULL),
(21, 'S.I.P.', NULL, NULL),
(22, 'S.K.M.', NULL, NULL),
(23, 'S.H.I.', NULL, NULL),
(24, 'S.Sos.I.', NULL, NULL),
(25, 'S.Fil.I.', NULL, NULL),
(26, 'S.Pd.I.', NULL, NULL),
(27, 'M.Mus.', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `s2`
--

CREATE TABLE `s2` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gelar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `s2`
--

INSERT INTO `s2` (`id`, `gelar`, `created_at`, `updated_at`) VALUES
(1, 'M.A.B.', NULL, NULL),
(2, 'M.A.Pd.', NULL, NULL),
(3, 'M.A.P.', NULL, NULL),
(4, 'M.A.R.S.', NULL, NULL),
(5, 'M.Ag.', NULL, NULL),
(6, 'M.A.Hk.', NULL, NULL),
(7, 'M.A.Hum.', NULL, NULL),
(8, 'M.A.Ked.', NULL, NULL),
(9, 'M.A.Pd.', NULL, NULL),
(10, 'M.A.Si.', NULL, NULL),
(11, 'M.Agri.', NULL, NULL),
(12, 'M.Ak.', NULL, NULL),
(13, 'M.Ars.', NULL, NULL),
(14, 'M.Biomed', NULL, NULL),
(15, 'M.Ds.', NULL, NULL),
(16, 'M.Div.', NULL, NULL),
(17, 'M.E.', NULL, NULL),
(18, 'M.E.I.', NULL, NULL),
(19, 'M.E.Sy.', NULL, NULL),
(20, 'M.Epid.', NULL, NULL),
(21, 'M.Farm.', NULL, NULL),
(22, 'M.Farm.Klin.', NULL, NULL),
(23, 'M.Fil.', NULL, NULL),
(24, 'M.Fil.I.', NULL, NULL),
(25, 'M.H.', NULL, NULL),
(26, 'M.H.I.', NULL, NULL),
(27, 'M.H.Kes.', NULL, NULL),
(28, 'M.Hum.', NULL, NULL),
(29, 'M.A.', NULL, NULL),
(30, 'M.Si.Biomed.', NULL, NULL),
(31, 'M.I.K.', NULL, NULL),
(32, 'M.Kesos.', NULL, NULL),
(33, 'M.Kom.', NULL, NULL),
(34, 'M.I.Kom.', NULL, NULL),
(35, 'M.Han.', NULL, NULL),
(36, 'M.I.Pol.', NULL, NULL),
(37, 'M.Sy.', NULL, NULL),
(38, 'M.Ud.', NULL, NULL),
(39, 'M.Keb.', NULL, NULL),
(40, 'M.K.K.', NULL, NULL),
(41, 'M.Ked.Tro', NULL, NULL),
(42, 'M.Hut.', NULL, NULL),
(43, 'M.Kn.', NULL, NULL),
(44, 'M.Kor.', NULL, NULL),
(45, 'M.Kep.', NULL, NULL),
(46, 'M.Kes..', NULL, NULL),
(47, 'M.K.M.', NULL, NULL),
(48, 'M.K.K.K.', NULL, NULL),
(49, 'M.Kom.', NULL, NULL),
(50, 'M.M.', NULL, NULL),
(51, 'M.M.A.', NULL, NULL),
(52, 'M.Par.', NULL, NULL),
(53, 'M.M.Pd.', NULL, NULL),
(54, 'M.M.R.', NULL, NULL),
(55, 'M.M.S.I.', NULL, NULL),
(56, 'M.M.T.', NULL, NULL),
(57, 'M.Mar.', NULL, NULL),
(58, 'M.Li.', NULL, NULL),
(59, 'M.P.I.', NULL, NULL),
(60, 'M.Pd.', NULL, NULL),
(61, 'M.Pd.I.', NULL, NULL),
(62, 'M.Pd.Si.', NULL, NULL),
(63, 'M.P.Fis.', NULL, NULL),
(64, 'M.P.Kim.', NULL, NULL),
(65, 'M.P.Mat.', NULL, NULL),
(66, 'M.P.', NULL, NULL),
(67, 'M.Psi.', NULL, NULL),
(68, 'M.Si.', NULL, NULL),
(69, 'M.S.Ak.', NULL, NULL),
(70, 'M.Si.(Han).', NULL, NULL),
(71, 'M.S.E.', NULL, NULL),
(72, 'M.S.M.', NULL, NULL),
(73, 'M.Sn.', NULL, NULL),
(74, 'M.Sos.I.', NULL, NULL),
(75, 'M.Stat.', NULL, NULL),
(76, 'M.S.I.', NULL, NULL),
(77, 'M.T.', NULL, NULL),
(78, 'M.T.A.', NULL, NULL),
(79, 'M.TI.', NULL, NULL),
(80, 'M.T.P.', NULL, NULL),
(81, 'M.Div.', NULL, NULL),
(82, 'M.Th.I.', NULL, NULL),
(83, 'M.Min.', NULL, NULL),
(84, 'M.Th.', NULL, NULL),
(85, 'M.Tr.', NULL, NULL),
(86, 'M.Tr. Ha', NULL, NULL),
(87, 'M.Tr.Hanla.', NULL, NULL),
(88, 'M.Vet.', NULL, NULL),
(89, 'M.Acc.', NULL, NULL),
(90, 'M.A.', NULL, NULL),
(91, 'M.A.Ed.', NULL, NULL),
(92, 'M.B.A.', NULL, NULL),
(93, 'M.Com.', NULL, NULL),
(94, 'M.Cs.', NULL, NULL),
(95, 'M.Ec.', NULL, NULL),
(96, 'M.Ed.', NULL, NULL),
(97, 'M.Eng.', NULL, NULL),
(98, 'LL.M.', NULL, NULL),
(99, 'M.Med.Ed.', NULL, NULL),
(100, 'M.Phil.', NULL, NULL),
(101, 'M.P.A.', NULL, NULL),
(102, 'M.P.H.', NULL, NULL),
(103, 'M.Sc.', NULL, NULL),
(104, 'M.Sc.Soc.', NULL, NULL),
(105, 'M.S.E.', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `s3`
--

CREATE TABLE `s3` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gelar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `s3`
--

INSERT INTO `s3` (`id`, `gelar`, `created_at`, `updated_at`) VALUES
(1, 'Dr.', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`id`, `semester`, `tahun`, `aktif`, `created_at`, `updated_at`) VALUES
(3, 'GASAL', '2021/2022', 'N', '2021-10-18 04:50:29', '2021-10-18 04:50:29'),
(4, 'GENAP', '2021/2022', 'N', '2021-11-08 05:10:39', '2021-11-08 05:10:39'),
(5, 'GENAP', '2021/2022', 'N', '2021-12-05 23:44:00', '2021-12-05 23:44:00'),
(6, 'GASAL', '2021/2022', 'Y', '2021-12-05 23:44:13', '2021-12-05 23:44:13');

-- --------------------------------------------------------

--
-- Table structure for table `status_skripsi`
--

CREATE TABLE `status_skripsi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_proposal` bigint(20) UNSIGNED NOT NULL,
  `status_skripsi` enum('Sedang Dikerjakan','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sedang Dikerjakan',
  `status_ujian` enum('Belum Ujian','Lulus','Tidak Lulus') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Ujian',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_induk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','dosen','mahasiswa') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mahasiswa',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'undraw_profile.svg',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `no_induk`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `photo`, `created_at`, `updated_at`) VALUES
(1, '12345678910', 'Admin', 'adminskripsi', NULL, '2021-09-22 02:52:53', '$2y$10$f3DuEvp3mflK9tvKe3.FD.FHUqsL167dYWwCXkJwcXnZtcaU/mMoO', NULL, 'admin', 'undraw_profile.svg', '2021-09-22 02:52:53', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berkas_sempro`
--
ALTER TABLE `berkas_sempro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `berkas_sempro_nim_foreign` (`nim`),
  ADD KEY `berkas_sempro_id_proposal_foreign` (`id_proposal`),
  ADD KEY `berkas_sempro_id_plot_dosbing_foreign` (`id_plot_dosbing`);

--
-- Indexes for table `berkas_ujian`
--
ALTER TABLE `berkas_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nim` (`nim`),
  ADD KEY `id_proposal` (`id_proposal`),
  ADD KEY `id_plot_penguji` (`id_plot_penguji`);

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
  ADD KEY `bimbingan_nim_foreign` (`nim`),
  ADD KEY `bimbingan_id_proposal_foreign` (`id_proposal`),
  ADD KEY `bimbingan_id_plot_dosbing_foreign` (`id_plot_dosbing`),
  ADD KEY `id_semester` (`id_semester`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nidn` (`nidn`),
  ADD KEY `gelar1` (`gelar1`),
  ADD KEY `gelar2` (`gelar2`),
  ADD KEY `gelar3` (`gelar3`),
  ADD KEY `id_bidang` (`id_bidang`);

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
  ADD KEY `hasil_sempro_nim_foreign` (`nim`),
  ADD KEY `hasil_sempro_id_proposal_foreign` (`id_proposal`),
  ADD KEY `hasil_sempro_id_jadwal_sempro_foreign` (`id_jadwal_sempro`);

--
-- Indexes for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nim` (`nim`),
  ADD KEY `id_proposal` (`id_proposal`),
  ADD KEY `id_jadwal_ujian` (`id_jadwal_ujian`);

--
-- Indexes for table `jadwal_sempro`
--
ALTER TABLE `jadwal_sempro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_sempro_nim_foreign` (`nim`),
  ADD KEY `jadwal_sempro_id_berkas_sempro_foreign` (`id_berkas_sempro`);

--
-- Indexes for table `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nim` (`nim`),
  ADD KEY `id_berkas_ujian` (`id_berkas_ujian`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`);

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
  ADD KEY `dosbing1` (`dosbing1`),
  ADD KEY `dosbing2` (`dosbing2`);

--
-- Indexes for table `plot_penguji`
--
ALTER TABLE `plot_penguji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ketua_penguji` (`ketua_penguji`),
  ADD KEY `anggota_penguji_1` (`anggota_penguji_1`),
  ADD KEY `anggota_penguji_2` (`anggota_penguji_2`),
  ADD KEY `nim` (`nim`);

--
-- Indexes for table `proposal`
--
ALTER TABLE `proposal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proposal_id_plot_dosbing_foreign` (`id_plot_dosbing`),
  ADD KEY `nim` (`nim`),
  ADD KEY `id_semester` (`id_semester`);

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berkas_sempro`
--
ALTER TABLE `berkas_sempro`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `berkas_ujian`
--
ALTER TABLE `berkas_ujian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bidang`
--
ALTER TABLE `bidang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bimbingan`
--
ALTER TABLE `bimbingan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hasil_sempro`
--
ALTER TABLE `hasil_sempro`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jadwal_sempro`
--
ALTER TABLE `jadwal_sempro`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pesan_bimbingan`
--
ALTER TABLE `pesan_bimbingan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `plot_dosbing`
--
ALTER TABLE `plot_dosbing`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `plot_penguji`
--
ALTER TABLE `plot_penguji`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `proposal`
--
ALTER TABLE `proposal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `s1`
--
ALTER TABLE `s1`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `s2`
--
ALTER TABLE `s2`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `s3`
--
ALTER TABLE `s3`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `status_skripsi`
--
ALTER TABLE `status_skripsi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `berkas_sempro`
--
ALTER TABLE `berkas_sempro`
  ADD CONSTRAINT `berkas_sempro_id_plot_dosbing_foreign` FOREIGN KEY (`id_plot_dosbing`) REFERENCES `plot_dosbing` (`id`),
  ADD CONSTRAINT `berkas_sempro_id_proposal_foreign` FOREIGN KEY (`id_proposal`) REFERENCES `proposal` (`id`),
  ADD CONSTRAINT `berkas_sempro_nim_foreign` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`);

--
-- Constraints for table `berkas_ujian`
--
ALTER TABLE `berkas_ujian`
  ADD CONSTRAINT `berkas_ujian_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`),
  ADD CONSTRAINT `berkas_ujian_ibfk_2` FOREIGN KEY (`id_proposal`) REFERENCES `proposal` (`id`),
  ADD CONSTRAINT `berkas_ujian_ibfk_4` FOREIGN KEY (`id_plot_penguji`) REFERENCES `plot_penguji` (`id`);

--
-- Constraints for table `bimbingan`
--
ALTER TABLE `bimbingan`
  ADD CONSTRAINT `bimbingan_ibfk_1` FOREIGN KEY (`id_semester`) REFERENCES `semester` (`id`),
  ADD CONSTRAINT `bimbingan_id_plot_dosbing_foreign` FOREIGN KEY (`id_plot_dosbing`) REFERENCES `plot_dosbing` (`id`),
  ADD CONSTRAINT `bimbingan_id_proposal_foreign` FOREIGN KEY (`id_proposal`) REFERENCES `proposal` (`id`),
  ADD CONSTRAINT `bimbingan_nim_foreign` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`);

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`gelar1`) REFERENCES `s1` (`id`),
  ADD CONSTRAINT `dosen_ibfk_2` FOREIGN KEY (`gelar2`) REFERENCES `s2` (`id`),
  ADD CONSTRAINT `dosen_ibfk_3` FOREIGN KEY (`gelar3`) REFERENCES `s3` (`id`),
  ADD CONSTRAINT `dosen_ibfk_4` FOREIGN KEY (`id_bidang`) REFERENCES `bidang` (`id`);

--
-- Constraints for table `hasil_sempro`
--
ALTER TABLE `hasil_sempro`
  ADD CONSTRAINT `hasil_sempro_id_jadwal_sempro_foreign` FOREIGN KEY (`id_jadwal_sempro`) REFERENCES `jadwal_sempro` (`id`),
  ADD CONSTRAINT `hasil_sempro_id_proposal_foreign` FOREIGN KEY (`id_proposal`) REFERENCES `proposal` (`id`),
  ADD CONSTRAINT `hasil_sempro_nim_foreign` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`);

--
-- Constraints for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  ADD CONSTRAINT `hasil_ujian_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`),
  ADD CONSTRAINT `hasil_ujian_ibfk_2` FOREIGN KEY (`id_proposal`) REFERENCES `proposal` (`id`),
  ADD CONSTRAINT `hasil_ujian_ibfk_3` FOREIGN KEY (`id_jadwal_ujian`) REFERENCES `jadwal_ujian` (`id`);

--
-- Constraints for table `jadwal_sempro`
--
ALTER TABLE `jadwal_sempro`
  ADD CONSTRAINT `jadwal_sempro_id_berkas_sempro_foreign` FOREIGN KEY (`id_berkas_sempro`) REFERENCES `berkas_sempro` (`id`),
  ADD CONSTRAINT `jadwal_sempro_nim_foreign` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`);

--
-- Constraints for table `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  ADD CONSTRAINT `jadwal_ujian_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`),
  ADD CONSTRAINT `jadwal_ujian_ibfk_2` FOREIGN KEY (`id_berkas_ujian`) REFERENCES `berkas_ujian` (`id`);

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
  ADD CONSTRAINT `plot_dosbing_ibfk_1` FOREIGN KEY (`dosbing1`) REFERENCES `dosen` (`nidn`),
  ADD CONSTRAINT `plot_dosbing_ibfk_2` FOREIGN KEY (`dosbing2`) REFERENCES `dosen` (`nidn`);

--
-- Constraints for table `plot_penguji`
--
ALTER TABLE `plot_penguji`
  ADD CONSTRAINT `plot_penguji_ibfk_1` FOREIGN KEY (`ketua_penguji`) REFERENCES `dosen` (`nidn`),
  ADD CONSTRAINT `plot_penguji_ibfk_2` FOREIGN KEY (`anggota_penguji_1`) REFERENCES `dosen` (`nidn`),
  ADD CONSTRAINT `plot_penguji_ibfk_3` FOREIGN KEY (`anggota_penguji_2`) REFERENCES `dosen` (`nidn`),
  ADD CONSTRAINT `plot_penguji_ibfk_4` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`);

--
-- Constraints for table `proposal`
--
ALTER TABLE `proposal`
  ADD CONSTRAINT `proposal_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`),
  ADD CONSTRAINT `proposal_ibfk_2` FOREIGN KEY (`id_semester`) REFERENCES `semester` (`id`),
  ADD CONSTRAINT `proposal_id_plot_dosbing_foreign` FOREIGN KEY (`id_plot_dosbing`) REFERENCES `plot_dosbing` (`id`);

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
