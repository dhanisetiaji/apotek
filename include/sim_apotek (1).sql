-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Jul 2021 pada 16.26
-- Versi server: 10.1.32-MariaDB
-- Versi PHP: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sim_apotek`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id` varchar(15) NOT NULL,
  `id_pegawai` varchar(15) NOT NULL,
  `tgl` date NOT NULL,
  `total_harga` decimal(12,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_keluar`
--

INSERT INTO `barang_keluar` (`id`, `id_pegawai`, `tgl`, `total_harga`) VALUES
('BK0001', 'P001', '2021-07-16', '50000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id` varchar(15) NOT NULL,
  `id_supplier` varchar(15) NOT NULL,
  `id_pegawai` varchar(15) NOT NULL,
  `no_faktur` varchar(20) NOT NULL,
  `po_number` varchar(45) NOT NULL,
  `salesman` varchar(45) NOT NULL,
  `tgl` date NOT NULL,
  `diskon` decimal(10,0) NOT NULL,
  `total_harga` decimal(12,0) NOT NULL,
  `payment_term` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_masuk`
--

INSERT INTO `barang_masuk` (`id`, `id_supplier`, `id_pegawai`, `no_faktur`, `po_number`, `salesman`, `tgl`, `diskon`, `total_harga`, `payment_term`) VALUES
('BM0001', 'S003', 'P001', 'F122334', 'PO12233', 'Dhani S', '2021-07-09', '10', '76500', '2021-07-06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_barang_keluar`
--

CREATE TABLE `detail_barang_keluar` (
  `id_detail` int(11) NOT NULL,
  `id_barang_keluar` varchar(15) NOT NULL,
  `id_barang` varchar(15) NOT NULL,
  `id_supplier` varchar(15) NOT NULL,
  `jumlah` decimal(12,0) NOT NULL,
  `harga_beli` decimal(12,0) NOT NULL,
  `expired` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_barang_keluar`
--

INSERT INTO `detail_barang_keluar` (`id_detail`, `id_barang_keluar`, `id_barang`, `id_supplier`, `jumlah`, `harga_beli`, `expired`) VALUES
(6, 'BK0001', 'BR00001', 'S002', '2', '10000', '2021-07-01'),
(7, 'BK0001', 'BR00002', 'S002', '3', '10000', '2021-07-16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_barang_masuk`
--

CREATE TABLE `detail_barang_masuk` (
  `id_detail` int(11) NOT NULL,
  `id_barang_masuk` varchar(15) NOT NULL,
  `id_barang` varchar(15) NOT NULL,
  `jumlah` decimal(12,0) NOT NULL,
  `harga_beli` decimal(12,0) NOT NULL,
  `expired` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_barang_masuk`
--

INSERT INTO `detail_barang_masuk` (`id_detail`, `id_barang_masuk`, `id_barang`, `jumlah`, `harga_beli`, `expired`) VALUES
(9, 'BM0001', 'BR00001', '2', '10000', '2021-06-30'),
(10, 'BM0001', 'BR00002', '5', '10000', '2021-07-17'),
(11, 'BM0001', 'BR00003', '3', '5000', '2021-06-30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kat` varchar(6) NOT NULL,
  `nama_kategori` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kat`, `nama_kategori`) VALUES
('1', 'Anti Depresan'),
('2', 'Alat Kesehatan'),
('4', 'Anti Covid'),
('5', 'Anti Antian');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat_alkes`
--

CREATE TABLE `obat_alkes` (
  `id` varchar(15) NOT NULL,
  `id_kategori` varchar(6) NOT NULL,
  `nama` varchar(125) NOT NULL,
  `satuan` enum('Box','Strip','Botol','Sachet') NOT NULL,
  `harga_beli` decimal(12,0) NOT NULL,
  `jumlah` decimal(12,0) NOT NULL,
  `stok` decimal(12,0) NOT NULL,
  `dosis` varchar(45) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `obat_alkes`
--

INSERT INTO `obat_alkes` (`id`, `id_kategori`, `nama`, `satuan`, `harga_beli`, `jumlah`, `stok`, `dosis`, `keterangan`) VALUES
('BR00001', '1', 'Amoxillin', 'Strip', '12000', '120', '118', '500 mg', 'Obat Anti Biotik'),
('BR00002', '1', 'Tolak Angin', 'Box', '1500000', '120', '120', '100 ml', 'hanyut'),
('BR00003', '1', 'Mixagrip', 'Strip', '900000', '118', '120', '100 mg', 'dfkdfjkl'),
('BR00005', '1', 'Komik', 'Box', '45000', '9', '9', '1 Sachet', 'Obat sakit kepala');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id` varchar(15) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `jenis_kelamin` enum('L','P','','') NOT NULL,
  `tempat_lahir` varchar(45) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(45) NOT NULL,
  `telepon` varchar(45) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `posisi` enum('Super Admin','Admin','Karyawan') NOT NULL,
  `status` enum('aktif','blokir') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id`, `username`, `password`, `nama`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `telepon`, `foto`, `posisi`, `status`) VALUES
('P001', 'iki', 'iki', 'Rizky', 'L', 'Barabai', '2021-06-02', 'Barabai', '0813129912', NULL, 'Admin', 'aktif'),
('P002', 'dhani', '123', 'Dhani Setiaji', 'L', 'Cilacap', '1999-09-06', 'Jalan jago no 1 yogyakarta', '08213213213', NULL, 'Karyawan', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id` varchar(15) NOT NULL,
  `nama_supplier` varchar(45) NOT NULL,
  `alamat` varchar(80) NOT NULL,
  `fax` varchar(45) NOT NULL,
  `telepon` varchar(45) NOT NULL,
  `cp` varchar(45) NOT NULL,
  `telp_cp` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id`, `nama_supplier`, `alamat`, `fax`, `telepon`, `cp`, `telp_cp`) VALUES
('S001', 'Kimia Farma', 'Pelaihari', '023233122', '0819230123', 'Rahmat', '0832291231'),
('S002', 'Obat Farmasi', 'Banjarmasin', '021389123', '021938', 'Haris', '123901'),
('S003', 'K24', 'Yogyakarta', '02331233', '082123332', 'Yoga', '081222332');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indeks untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indeks untuk tabel `detail_barang_keluar`
--
ALTER TABLE `detail_barang_keluar`
  ADD PRIMARY KEY (`id_detail`) USING BTREE,
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_barang_keluar` (`id_barang_keluar`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indeks untuk tabel `detail_barang_masuk`
--
ALTER TABLE `detail_barang_masuk`
  ADD PRIMARY KEY (`id_detail`) USING BTREE,
  ADD KEY `id_barang_masuk` (`id_barang_masuk`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kat`);

--
-- Indeks untuk tabel `obat_alkes`
--
ALTER TABLE `obat_alkes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_barang_keluar`
--
ALTER TABLE `detail_barang_keluar`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `detail_barang_masuk`
--
ALTER TABLE `detail_barang_masuk`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `id_barang_masuk` FOREIGN KEY (`id`) REFERENCES `detail_barang_masuk` (`id_barang_masuk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_supplier` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `obat_alkes`
--
ALTER TABLE `obat_alkes`
  ADD CONSTRAINT `obat_alkes` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kat`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
