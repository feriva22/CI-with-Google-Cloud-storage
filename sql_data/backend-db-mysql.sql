-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Jul 2020 pada 07.10
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `backend-db`
--
CREATE DATABASE IF NOT EXISTS `backend-db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `backend-db`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `app_sessions`
--

CREATE TABLE `app_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `timestamp` int(10) DEFAULT NULL,
  `data` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `module`
--

CREATE TABLE `module` (
  `mdl_id` int(11) NOT NULL,
  `mdl_name` varchar(45) DEFAULT NULL,
  `mdl_desc` varchar(45) DEFAULT NULL,
  `mdl_relativeurl` varchar(45) DEFAULT NULL,
  `mdl_status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `module`
--

INSERT INTO `module` (`mdl_id`, `mdl_name`, `mdl_desc`, `mdl_relativeurl`, `mdl_status`) VALUES
(1, 'konfigurasi', '', 'konfigurasi', 0),
(2, 'staff', '', 'staff', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `moduleaccess`
--

CREATE TABLE `moduleaccess` (
  `mda_id` int(11) NOT NULL,
  `mda_staffgroup` int(11) NOT NULL,
  `mda_module` int(11) NOT NULL,
  `mda_create` tinyint(4) DEFAULT 0,
  `mda_read` tinyint(4) DEFAULT 0,
  `mda_update` tinyint(4) DEFAULT 0,
  `mda_delete` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `moduleaccess`
--

INSERT INTO `moduleaccess` (`mda_id`, `mda_staffgroup`, `mda_module`, `mda_create`, `mda_read`, `mda_update`, `mda_delete`) VALUES
(69, 5, 2, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `modulemenu`
--

CREATE TABLE `modulemenu` (
  `mdm_id` int(11) NOT NULL,
  `mdm_title` varchar(45) DEFAULT NULL,
  `mdm_url` varchar(45) DEFAULT NULL,
  `mdm_staffgroup` varchar(255) DEFAULT NULL,
  `mdm_parent` int(11) DEFAULT 0,
  `mdm_group` varchar(45) DEFAULT NULL,
  `mdm_class` varchar(45) DEFAULT NULL,
  `mdm_order` smallint(6) DEFAULT NULL,
  `mdm_status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `modulemenu`
--

INSERT INTO `modulemenu` (`mdm_id`, `mdm_title`, `mdm_url`, `mdm_staffgroup`, `mdm_parent`, `mdm_group`, `mdm_class`, `mdm_order`, `mdm_status`) VALUES
(22, 'Pengguna', 'staff', '5', NULL, 'System', 'ik ik-users', 20, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `staff`
--

CREATE TABLE `staff` (
  `stf_id` int(11) NOT NULL,
  `stf_name` varchar(45) DEFAULT NULL,
  `stf_username` varchar(45) DEFAULT NULL,
  `stf_email` varchar(255) DEFAULT NULL,
  `stf_password` varchar(255) DEFAULT NULL,
  `stf_lastlogin` timestamp NULL DEFAULT NULL,
  `stf_status` tinyint(4) DEFAULT NULL,
  `stf_created` timestamp NULL DEFAULT NULL,
  `stf_updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `staff`
--

INSERT INTO `staff` (`stf_id`, `stf_name`, `stf_username`, `stf_email`, `stf_password`, `stf_lastlogin`, `stf_status`, `stf_created`, `stf_updated`) VALUES
(3, 'admin', 'admin', '', '$2y$10$rLa7p9zhJJxFFctE/J9qRO83rFtnGOF6wweBNezMywXKh2kvCcEbG', '2020-07-22 05:01:12', 1, '2020-07-22 04:57:36', '2020-07-22 04:57:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `staffgroup`
--

CREATE TABLE `staffgroup` (
  `sdg_id` int(11) NOT NULL,
  `sdg_name` varchar(45) DEFAULT NULL,
  `sdg_desc` varchar(45) DEFAULT NULL,
  `sdg_status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `staffgroup`
--

INSERT INTO `staffgroup` (`sdg_id`, `sdg_name`, `sdg_desc`, `sdg_status`) VALUES
(5, 'admin', '', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `staffgroupaccess`
--

CREATE TABLE `staffgroupaccess` (
  `sga_staffgroup` int(11) NOT NULL,
  `sga_staff` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `staffgroupaccess`
--

INSERT INTO `staffgroupaccess` (`sga_staffgroup`, `sga_staff`) VALUES
(5, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stafflog`
--

CREATE TABLE `stafflog` (
  `sdl_id` int(11) NOT NULL,
  `sdl_module` varchar(45) DEFAULT NULL,
  `sdl_action` varchar(45) DEFAULT NULL,
  `sdl_staff` varchar(45) DEFAULT NULL,
  `sdl_date` datetime DEFAULT NULL,
  `sdl_note` text DEFAULT NULL,
  `sdl_ip` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `app_sessions`
--
ALTER TABLE `app_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`mdl_id`);

--
-- Indeks untuk tabel `moduleaccess`
--
ALTER TABLE `moduleaccess`
  ADD PRIMARY KEY (`mda_id`,`mda_staffgroup`,`mda_module`),
  ADD KEY `fk_staffgroup_has_module_module1_idx` (`mda_module`),
  ADD KEY `fk_staffgroup_has_module_staffgroup1_idx` (`mda_staffgroup`);

--
-- Indeks untuk tabel `modulemenu`
--
ALTER TABLE `modulemenu`
  ADD PRIMARY KEY (`mdm_id`);

--
-- Indeks untuk tabel `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`stf_id`);

--
-- Indeks untuk tabel `staffgroup`
--
ALTER TABLE `staffgroup`
  ADD PRIMARY KEY (`sdg_id`);

--
-- Indeks untuk tabel `staffgroupaccess`
--
ALTER TABLE `staffgroupaccess`
  ADD PRIMARY KEY (`sga_staffgroup`,`sga_staff`),
  ADD KEY `fk_staffgroup_has_staff_staff1_idx` (`sga_staff`),
  ADD KEY `fk_staffgroup_has_staff_staffgroup1_idx` (`sga_staffgroup`);

--
-- Indeks untuk tabel `stafflog`
--
ALTER TABLE `stafflog`
  ADD PRIMARY KEY (`sdl_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `module`
--
ALTER TABLE `module`
  MODIFY `mdl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `moduleaccess`
--
ALTER TABLE `moduleaccess`
  MODIFY `mda_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT untuk tabel `modulemenu`
--
ALTER TABLE `modulemenu`
  MODIFY `mdm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `staff`
--
ALTER TABLE `staff`
  MODIFY `stf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `staffgroup`
--
ALTER TABLE `staffgroup`
  MODIFY `sdg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `stafflog`
--
ALTER TABLE `stafflog`
  MODIFY `sdl_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `moduleaccess`
--
ALTER TABLE `moduleaccess`
  ADD CONSTRAINT `fk_staffgroup_has_module_module1` FOREIGN KEY (`mda_module`) REFERENCES `module` (`mdl_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_staffgroup_has_module_staffgroup1` FOREIGN KEY (`mda_staffgroup`) REFERENCES `staffgroup` (`sdg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `staffgroupaccess`
--
ALTER TABLE `staffgroupaccess`
  ADD CONSTRAINT `fk_staffgroup_has_staff_staff1` FOREIGN KEY (`sga_staff`) REFERENCES `staff` (`stf_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_staffgroup_has_staff_staffgroup1` FOREIGN KEY (`sga_staffgroup`) REFERENCES `staffgroup` (`sdg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
