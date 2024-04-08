-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 26 Jun 2020 pada 03.42
-- Versi server: 10.3.23-MariaDB
-- Versi PHP: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `buildweb_tanti`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `idbarang` int(11) NOT NULL,
  `merk` varchar(15) DEFAULT NULL COMMENT 'Merk',
  `nama_barang` varchar(15) DEFAULT NULL COMMENT 'Nama Barang',
  `deskripsi` varchar(100) DEFAULT NULL COMMENT 'Deskripsi',
  `kategori` varchar(25) DEFAULT NULL COMMENT 'Kategori'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`idbarang`, `merk`, `nama_barang`, `deskripsi`, `kategori`) VALUES
(1, 'Merk A', 'Barang A', 'ini barang A ukuran sedang', 'Alat Tulis');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `idtransaksi` int(11) NOT NULL,
  `tgl` date DEFAULT NULL COMMENT 'Tanggal Transaksi',
  `jenis` varchar(6) DEFAULT NULL COMMENT 'Jenis Transaksi',
  `idbarang` int(11) DEFAULT NULL COMMENT 'Barang',
  `qty` int(11) DEFAULT NULL COMMENT 'Qty',
  `ket` varchar(100) DEFAULT NULL COMMENT 'Keterangan'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`idtransaksi`, `tgl`, `jenis`, `idbarang`, `qty`, `ket`) VALUES
(1, '2020-06-09', 'Masuk', 1, 25, 'jjj'),
(2, '2020-06-09', 'Keluar', 1, 15, 'Untuk Kelas 1 tahun ajaran 2019'),
(5, '2020-06-17', 'Masuk', 1, 10, 'n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user` varchar(10) NOT NULL COMMENT 'Username',
  `pass` varchar(15) DEFAULT NULL COMMENT 'Password',
  `nama` varchar(25) DEFAULT NULL COMMENT 'Nama Lengkap',
  `level` varchar(15) DEFAULT NULL COMMENT 'Level Akses'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user`, `pass`, `nama`, `level`) VALUES
('admin', 'admin', 'Nama Admin', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`idbarang`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`idtransaksi`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `idbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `idtransaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
