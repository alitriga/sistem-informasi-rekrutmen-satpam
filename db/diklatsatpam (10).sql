-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 05, 2024 at 09:58 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diklatsatpam`
--

-- --------------------------------------------------------

--
-- Table structure for table `bayar`
--

CREATE TABLE `bayar` (
  `idBayar` int NOT NULL,
  `idPaket` int DEFAULT NULL,
  `idDaftar` int DEFAULT NULL,
  `metode` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tglBayar` date DEFAULT NULL,
  `nm` varchar(35) DEFAULT NULL,
  `bank` varchar(35) DEFAULT NULL,
  `upload` varchar(255) DEFAULT NULL,
  `statusBayar` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bayar`
--

INSERT INTO `bayar` (`idBayar`, `idPaket`, `idDaftar`, `metode`, `tglBayar`, `nm`, `bank`, `upload`, `statusBayar`) VALUES
(100, 1, 100, 'Cash', '2024-08-23', NULL, NULL, NULL, 'lulus'),
(101, NULL, 101, NULL, NULL, NULL, NULL, NULL, 'belum'),
(102, NULL, 102, NULL, NULL, NULL, NULL, NULL, 'belum');

--
-- Triggers `bayar`
--
DELIMITER $$
CREATE TRIGGER `updateDiklat` AFTER UPDATE ON `bayar` FOR EACH ROW BEGIN
    -- Cek apakah statusBayar berubah menjadi 'lulus'
    IF OLD.statusBayar <> 'lulus' AND NEW.statusBayar = 'lulus' THEN
        -- Insert ke tabel diklat dengan idDiklat di-set ke idDaftar
        INSERT INTO diklat (idDiklat, idDaftar)
        VALUES (NEW.idDaftar, NEW.idDaftar);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `berkas`
--

CREATE TABLE `berkas` (
  `idBerkas` int NOT NULL,
  `idDaftar` int DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ktp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `skck` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sSehat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `statusBerkas` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `berkas`
--

INSERT INTO `berkas` (`idBerkas`, `idDaftar`, `foto`, `ktp`, `skck`, `sSehat`, `statusBerkas`) VALUES
(100, 100, '../uploads/66b2b47a58885_WIRA NUR TRIATMA.jpg', '../uploads/66b2b47a596dc_code5.png', '../uploads/66b2b47a5a40a_riccardo-trimeloni-lc5iIZ7UO1w-unsplash.jpg', '../uploads/66b2b47a5afef_code4.png', 'lulus'),
(101, 101, NULL, NULL, NULL, NULL, 'dibuka'),
(102, 102, NULL, NULL, NULL, NULL, 'dibuka');

--
-- Triggers `berkas`
--
DELIMITER $$
CREATE TRIGGER `updateStatusBayar` AFTER UPDATE ON `berkas` FOR EACH ROW BEGIN
    IF NEW.statusBerkas = 'lulus' THEN
        UPDATE bayar
        SET statusBayar = 'dibuka'
        WHERE idDaftar = NEW.idDaftar;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `diklat`
--

CREATE TABLE `diklat` (
  `idDiklat` int NOT NULL,
  `idDaftar` int DEFAULT NULL,
  `idJadwal` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `diklat`
--

INSERT INTO `diklat` (`idDiklat`, `idDaftar`, `idJadwal`) VALUES
(100, 100, 2);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `idJadwal` int NOT NULL,
  `nmJadwal` varchar(255) NOT NULL,
  `tglAwal` date NOT NULL,
  `tglAkhir` date NOT NULL,
  `kegiatan` varchar(255) NOT NULL,
  `statusJadwal` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`idJadwal`, `nmJadwal`, `tglAwal`, `tglAkhir`, `kegiatan`, `statusJadwal`) VALUES
(2, 'Gel II Tahun 2024', '2024-08-06', '2024-08-08', 'adsadsad', 'aktif'),
(3, 'Gel. 123', '2024-08-07', '2024-08-31', 'asdasdasd', 'off');

--
-- Triggers `jadwal`
--
DELIMITER $$
CREATE TRIGGER `jadwalAktif` AFTER UPDATE ON `jadwal` FOR EACH ROW BEGIN
    -- Cek apakah statusJadwal berubah menjadi 'aktif'
    IF OLD.statusJadwal <> 'aktif' AND NEW.statusJadwal = 'aktif' THEN
        -- Update tabel diklat untuk menyesuaikan idJadwal
        UPDATE diklat
        SET idJadwal = NEW.idJadwal
        WHERE idJadwal IS NULL AND idDaftar IS NOT NULL;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateJadwal` AFTER UPDATE ON `jadwal` FOR EACH ROW BEGIN
    -- Cek apakah statusJadwal berubah menjadi 'aktif'
    IF OLD.statusJadwal <> 'aktif' AND NEW.statusJadwal = 'aktif' THEN
        -- Update tabel diklat untuk menyesuaikan idJadwal
        UPDATE diklat
        SET idJadwal = NEW.idJadwal
        WHERE idJadwal IS NULL AND idDaftar IS NOT NULL;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `idKaryawan` int NOT NULL,
  `nama` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `jabatan` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `username` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `role` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tglDaftar` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`idKaryawan`, `nama`, `jabatan`, `username`, `password`, `role`, `tglDaftar`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', 'admin', '2024-08-06 20:37:12'),
(2, 'direktur', 'direktur', 'direktur', 'direktur', 'direktur', '2024-08-06 20:37:12');

--
-- Triggers `karyawan`
--
DELIMITER $$
CREATE TRIGGER `deleteKaryawan` AFTER DELETE ON `karyawan` FOR EACH ROW BEGIN
	DELETE FROM login
    WHERE OLD.idKAryawan = idLogin;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insertkaryawan` AFTER INSERT ON `karyawan` FOR EACH ROW BEGIN
	INSERT INTO login SET
    idLogin = NEW.idKaryawan,
    username = NEW.username,
    password = NEW.password,
    role = NEW.role,
    tglDaftar = NEW.tglDaftar;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateKaryawan` AFTER UPDATE ON `karyawan` FOR EACH ROW BEGIN
	UPDATE login SET
    username = NEW.username,
    password = NEW.password,
    role = NEW.role
    WHERE idLogin = NEW.idKaryawan;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `idLogin` varchar(10) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL,
  `role` varchar(10) NOT NULL,
  `tglDaftar` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`idLogin`, `username`, `password`, `role`, `tglDaftar`) VALUES
('1', 'admin', 'admin', 'admin', '2024-08-06 20:37:12'),
('100', '191100038', '191100038', 'peserta', '2024-08-06 20:40:43'),
('101', '1', '1', 'peserta', '2024-08-23 04:19:52'),
('102', '2', '2', 'peserta', '2024-08-27 08:41:42'),
('2', 'direktur', 'direktur', 'direktur', '2024-08-06 20:37:12');

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `idPaket` int NOT NULL,
  `nmPaket` varchar(225) NOT NULL,
  `harga` int NOT NULL,
  `statusPaket` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`idPaket`, `nmPaket`, `harga`, `statusPaket`) VALUES
(1, 'by paket + Seragam', 6500000, 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `idDaftar` int NOT NULL,
  `nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nama` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `jenkel` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `kel` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `kec` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `kabkota` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prov` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `hp` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tb` float DEFAULT NULL,
  `bb` float DEFAULT NULL,
  `penddk` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tLahir` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tglLahir` date DEFAULT NULL,
  `tglDaftar` timestamp NOT NULL,
  `statusDaftar` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`idDaftar`, `nik`, `nama`, `jenkel`, `alamat`, `kel`, `kec`, `kabkota`, `prov`, `hp`, `tb`, `bb`, `penddk`, `tLahir`, `tglLahir`, `tglDaftar`, `statusDaftar`) VALUES
(100, '191100038', 'Wira Nur Triatma', 'Laki-Laki', 'Jl Rambutan 1 No. 41', 'Kuranji', 'Kuranji', 'Padang', 'Sumatera Barat', '082288457224', 165, 60, 'SMA', 'Sungai Sirah', '2000-07-25', '2024-08-06 20:40:43', 'lulus'),
(101, '1', '1', 'Laki-Laki', '1', 'KURANJI', 'KURANJI', 'KOTA PADANG', 'SUMATERA BARAT', '1', 1, 1, 'SMA', '1', '1111-11-11', '2024-08-23 04:19:52', 'proses'),
(102, '2', '2', 'Laki-Laki', '2', 'LABUHAN BAJAU', 'TEUPAH SELATAN', 'KABUPATEN SIMEULUE', 'ACEH', '2', 2, 2, 'SMA', '2', '2222-02-02', '2024-08-27 08:41:42', 'proses');

--
-- Triggers `pendaftaran`
--
DELIMITER $$
CREATE TRIGGER `deleteBayar` AFTER DELETE ON `pendaftaran` FOR EACH ROW BEGIN
	DELETE FROM bayar
    WHERE OLD.idDaftar = idBayar;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `deleteBerkas` AFTER DELETE ON `pendaftaran` FOR EACH ROW BEGIN
	DELETE FROM berkas
    WHERE OLD.idDaftar = idBerkas;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `deleteLogin` AFTER DELETE ON `pendaftaran` FOR EACH ROW BEGIN
	DELETE FROM login
    WHERE OLD.idDaftar = idLogin;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insertBayar` AFTER INSERT ON `pendaftaran` FOR EACH ROW BEGIN
	INSERT INTO bayar SET
    idBayar = NEW.idDaftar,
    idDaftar = NEW.idDaftar,
	statusBayar = 'belum';
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insertBerkas` AFTER INSERT ON `pendaftaran` FOR EACH ROW BEGIN
	INSERT INTO berkas SET
    idBerkas = NEW.idDaftar,
	idDaftar = NEW.idDaftar,
    statusBerkas = 'dibuka';
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insertLogin` AFTER INSERT ON `pendaftaran` FOR EACH ROW BEGIN
	INSERT INTO login SET
    idLogin = NEW.idDaftar,
    username = NEW.nik,
    password = NEW.nik,
    role = 'peserta',
    tglDaftar = NEW.tglDaftar;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateLogin` AFTER UPDATE ON `pendaftaran` FOR EACH ROW BEGIN
	UPDATE login SET
    username = NEW.nik,
    password = NEW.nik
    WHERE idLogin = NEW.idDaftar;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bayar`
--
ALTER TABLE `bayar`
  ADD PRIMARY KEY (`idBayar`),
  ADD KEY `idDaftar` (`idDaftar`),
  ADD KEY `idPaket` (`idPaket`);

--
-- Indexes for table `berkas`
--
ALTER TABLE `berkas`
  ADD PRIMARY KEY (`idBerkas`),
  ADD KEY `idDaftar` (`idDaftar`);

--
-- Indexes for table `diklat`
--
ALTER TABLE `diklat`
  ADD PRIMARY KEY (`idDiklat`),
  ADD KEY `idDaftar` (`idDaftar`),
  ADD KEY `idJadwal` (`idJadwal`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`idJadwal`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`idKaryawan`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`idLogin`);

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`idPaket`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`idDaftar`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bayar`
--
ALTER TABLE `bayar`
  MODIFY `idBayar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `berkas`
--
ALTER TABLE `berkas`
  MODIFY `idBerkas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `diklat`
--
ALTER TABLE `diklat`
  MODIFY `idDiklat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `idJadwal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `idKaryawan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `paket`
--
ALTER TABLE `paket`
  MODIFY `idPaket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `idDaftar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bayar`
--
ALTER TABLE `bayar`
  ADD CONSTRAINT `bayar_ibfk_1` FOREIGN KEY (`idDaftar`) REFERENCES `pendaftaran` (`idDaftar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bayar_ibfk_3` FOREIGN KEY (`idPaket`) REFERENCES `paket` (`idPaket`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `berkas`
--
ALTER TABLE `berkas`
  ADD CONSTRAINT `berkas_ibfk_1` FOREIGN KEY (`idDaftar`) REFERENCES `pendaftaran` (`idDaftar`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `diklat`
--
ALTER TABLE `diklat`
  ADD CONSTRAINT `diklat_ibfk_1` FOREIGN KEY (`idDaftar`) REFERENCES `pendaftaran` (`idDaftar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `diklat_ibfk_2` FOREIGN KEY (`idJadwal`) REFERENCES `jadwal` (`idJadwal`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
