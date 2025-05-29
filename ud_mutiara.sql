-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Bulan Mei 2025 pada 07.23
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ud_mutiara`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` varchar(100) NOT NULL,
  `barcode` varchar(20) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `stock_minimal` int(11) NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `barcode`, `nama_barang`, `harga_beli`, `harga_jual`, `stock`, `satuan`, `stock_minimal`, `gambar`) VALUES
('BRG-001', '01', 'paku 5cm', 9000, 12000, 184, 'kg', 10, 'BRG-001-5352.jpeg'),
('BRG-002', '02', 'semen', 8000, 10000, 300, 'kg', 10, 'default-brg.png'),
('BRG-003', '40138429', 'lem tembak', 10000, 15000, 299, 'batang', 5, 'default-brg.png'),
('BRG-004', '29418914', 'hollow 4x2', 45000, 70000, 301, 'batang', 5, 'default-brg.png'),
('BRG-005', '953428510', 'pasir', 260000, 300000, 224, 'kubik', 3, 'default-brg.png'),
('BRG-006', '94815209', 'batu split', 280000, 340000, 222, 'kubik', 3, 'default-brg.png'),
('BRG-007', '0591231943', 'hollow 4x4', 56000, 80000, 198, 'batang', 5, 'default-brg.png'),
('BRG-008', '51203480', 'paku 3cm', 13000, 20000, 250, 'kg', 3, 'default-brg.png'),
('BRG-009', '09321432', 'paku 7cm', 12000, 20000, 299, 'kg', 3, 'default-brg.png'),
('BRG-010', '08051342842', 'paku 10cm', 18000, 25000, 352, 'kg', 3, 'default-brg.png'),
('BRG-011', '30218002', 'paku 12cm', 20000, 30000, 87, 'kg', 3, 'default-brg.png'),
('BRG-012', '4908123', 'paku payung 5cm', 15000, 28000, 96, 'kg', 3, 'default-brg.png'),
('BRG-013', '849132809', 'paku payung 7cm', 15000, 28000, 275, 'kg', 3, 'default-brg.png'),
('BRG-014', '132094801', 'paku gypsum', 22000, 30000, 159, 'dus/karton', 3, 'default-brg.png'),
('BRG-015', '480321402', 'paku beton 3cm', 15000, 30000, 286, 'item/piece', 10, 'default-brg.png'),
('BRG-016', '4893210491', 'paku beton 5cm', 250, 500, 239, 'item/piece', 10, 'default-brg.png'),
('BRG-017', '35210840932', 'paku beton 7cm', 350, 700, 236, 'item/piece', 10, 'default-brg.png'),
('BRG-018', '471923794', 'paku beton 10cm', 500, 1000, 320, 'item/piece', 10, 'default-brg.png'),
('BRG-019', '321480890', 'knee 1/2\'', 1500, 3000, 130, 'item/piece', 7, 'default-brg.png'),
('BRG-020', '8409239189', 'knee 1/4\'', 2000, 5000, 113, 'item/piece', 7, 'default-brg.png'),
('BRG-021', '480329189', 'knee 1\'', 3500, 6000, 150, 'item/piece', 7, 'default-brg.png'),
('BRG-022', '0803148901', 'knee 1 1/2\'', 5000, 9000, 163, 'item/piece', 7, 'default-brg.png'),
('BRG-023', '75218340', 'knee 1 1/4\'', 7000, 12000, 163, 'item/piece', 7, 'default-brg.png'),
('BRG-024', '518290321', 'knee 2\'', 8000, 15000, 100, 'item/piece', 7, 'default-brg.png'),
('BRG-025', '1428349013', 'knee 2 1/2\'', 10000, 16000, 100, 'item/piece', 7, 'default-brg.png'),
('BRG-026', '9012390900', 'knee 3\'', 11000, 17000, 100, 'item/piece', 7, 'default-brg.png'),
('BRG-027', '043812809', 'knee 4\'', 12000, 20000, 100, 'item/piece', 7, 'default-brg.png'),
('BRG-028', '897654', 'tee 1/2\'', 1500, 3000, 105, 'item/piece', 7, 'default-brg.png'),
('BRG-029', '564321', 'tee 1/4\'', 2000, 5000, 102, 'item/piece', 7, 'default-brg.png'),
('BRG-030', '987432', 'knee 3/4\'', 2500, 5500, 100, 'item/piece', 7, 'default-brg.png'),
('BRG-031', '76543', 'tee 1\'', 4000, 6000, 108, 'item/piece', 7, 'default-brg.png'),
('BRG-032', '4563', 'tee 1 1/2\'', 6000, 8000, 200, 'item/piece', 7, 'default-brg.png'),
('BRG-033', '435687', 'tee 1 1/4\'', 6500, 10000, 200, 'item/piece', 7, 'default-brg.png'),
('BRG-034', '657890', 'tee 2\'', 9000, 12000, 300, 'item/piece', 7, 'default-brg.png'),
('BRG-035', '45890', 'tee 2 1/2\'', 11000, 13000, 100, 'item/piece', 7, 'default-brg.png'),
('BRG-036', '34219', 'tee 3\'', 12000, 15000, 103, 'item/piece', 7, 'default-brg.png'),
('BRG-037', '56780', 'tee 4', 14000, 20000, 177, 'item/piece', 7, 'default-brg.png'),
('BRG-038', '78065', 'sox 1/2\'', 1500, 4000, 100, 'item/piece', 7, 'default-brg.png'),
('BRG-039', '45670', 'sox 3/4\'', 2000, 5000, 121, 'item/piece', 7, 'default-brg.png'),
('BRG-040', '45231', 'sox 1/4\'', 2500, 7000, 100, 'item/piece', 7, 'default-brg.png'),
('BRG-041', '09324', 'sox 1\'', 3500, 8000, 119, 'item/piece', 7, 'default-brg.png'),
('BRG-042', '79034', 'sox 1 1/2\'', 5000, 10000, 100, 'item/piece', 7, 'default-brg.png'),
('BRG-043', '36474', 'sox 1 1/4\'', 7000, 12000, 79, 'item/piece', 7, 'default-brg.png'),
('BRG-044', '81250', 'sox 2\'', 13000, 16000, 120, 'item/piece', 7, 'default-brg.png'),
('BRG-045', '45687', 'sox 2 1/2\'', 13000, 18000, 98, 'item/piece', 7, 'default-brg.png'),
('BRG-046', '10235', 'sox 3\'', 15000, 20500, 310, 'item/piece', 7, 'default-brg.png'),
('BRG-047', '34520', 'sox 4\'', 2000, 25000, 119, 'item/piece', 7, 'default-brg.png'),
('BRG-048', '90213', 'vlok sox 1/4\'x 1/2\'', 5000, 6000, 100, 'item/piece', 7, 'default-brg.png'),
('BRG-049', '589021', 'vlok sox 1/4\' x 3/4\'', 3000, 5000, 99, 'item/piece', 7, 'default-brg.png'),
('BRG-050', '10654', 'vlok sox 1/4\' x 1\'', 5000, 10000, 150, 'item/piece', 7, 'default-brg.png'),
('BRG-051', '53410', 'vlok sox 1/4\'x 1 1/4\'', 10000, 12000, 98, 'item/piece', 7, 'default-brg.png'),
('BRG-052', '98120', 'vlok sox 1/2\' x 3/4\'', 10000, 13000, 150, 'item/piece', 7, 'default-brg.png'),
('BRG-053', '3128440', 'vlok sox 1/2\'x1 1/4\'', 9000, 14000, 258, 'item/piece', 7, 'default-brg.png'),
('BRG-054', '97394198', 'vlok sox 1/2\'x1 1/2\'', 11000, 15000, 88, 'item/piece', 7, 'default-brg.png'),
('BRG-055', '349128390', 'vlok sox 1/2\'x2\'', 12000, 17000, 130, 'item/piece', 7, 'default-brg.png'),
('BRG-056', '3092180', 'vlok sox 3/4\'x1\'', 9000, 15000, 100, 'item/piece', 7, 'default-brg.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `beli_detail`
--

CREATE TABLE `beli_detail` (
  `id` int(11) NOT NULL,
  `no_beli` varchar(20) NOT NULL,
  `tgl_beli` date NOT NULL,
  `kode_brg` varchar(10) NOT NULL,
  `nama_brg` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `jml_harga` int(11) NOT NULL,
  `suplier` varchar(50) DEFAULT NULL,
  `supplier_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `beli_detail`
--

INSERT INTO `beli_detail` (`id`, `no_beli`, `tgl_beli`, `kode_brg`, `nama_brg`, `qty`, `harga_beli`, `jml_harga`, `suplier`, `supplier_name`) VALUES
(175, 'PB0001', '2025-05-29', 'BRG-005', 'pasir', 230, 260000, 59800000, '28', 'SUPPLIER PASIR'),
(176, 'PB0002', '2025-05-29', 'BRG-008', 'paku 3cm', 250, 13000, 3250000, '24', 'PT PAKU'),
(177, 'PB0002', '2025-05-29', 'BRG-013', 'paku payung 7cm', 178, 15000, 2670000, '24', 'PT PAKU'),
(178, 'PB0002', '2025-05-29', 'BRG-015', 'paku beton 3cm', 189, 150, 28350, '24', 'PT PAKU'),
(179, 'PB0003', '2025-05-29', 'BRG-002', 'semen', 223, 8000, 1784000, '23', 'PT SEMEN JAYA ABADI'),
(180, 'PB0004', '2025-05-29', 'BRG-034', 'tee 2\'', 223, 9000, 2007000, '22', 'PT TEE'),
(181, 'PB0005', '2025-05-29', 'BRG-046', 'sox 3\'', 213, 15000, 3195000, '26', 'PT SOX'),
(182, 'PB0002', '2025-05-29', 'BRG-009', 'paku 7cm', 201, 12000, 2412000, '24', 'PT PAKU'),
(183, 'PB0006', '2025-05-29', 'BRG-053', 'vlok sox 1/2\'x1 1/4\'', 270, 9000, 2430000, '27', 'PT VLOK SOX'),
(184, 'PB0007', '2025-05-29', 'BRG-003', 'lem tembak', 279, 10000, 2790000, '21', 'PT INDOMAR');

-- --------------------------------------------------------

--
-- Struktur dari tabel `beli_head`
--

CREATE TABLE `beli_head` (
  `no_beli` varchar(20) NOT NULL,
  `tgl_beli` date NOT NULL,
  `suplier` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `beli_head`
--

INSERT INTO `beli_head` (`no_beli`, `tgl_beli`, `suplier`, `total`, `keterangan`) VALUES
('PB0001', '2025-05-29', '28', 59800000, ''),
('PB0002', '2025-05-29', '24', 8360350, ''),
('PB0003', '2025-05-29', '23', 1784000, ''),
('PB0004', '2025-05-29', '22', 2007000, ''),
('PB0005', '2025-05-29', '26', 3195000, ''),
('PB0006', '2025-05-29', '27', 2430000, ''),
('PB0007', '2025-05-29', '21', 2790000, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id_customer`, `nama`) VALUES
(16, 'customer TB Mutiara'),
(18, 'iban'),
(19, 'iban'),
(20, 'iban'),
(21, 'akram'),
(22, 'adam'),
(23, 'sandy'),
(24, 'syech'),
(25, 'kang paku');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jual_detail`
--

CREATE TABLE `jual_detail` (
  `id` int(11) NOT NULL,
  `no_jual` varchar(20) NOT NULL,
  `tgl_jual` date NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `nama_brg` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `jml_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jual_detail`
--

INSERT INTO `jual_detail` (`id`, `no_jual`, `tgl_jual`, `barcode`, `nama_brg`, `qty`, `harga_jual`, `jml_harga`) VALUES
(68, 'PJ0001', '2025-05-29', '953428510', 'pasir', 1, 300000, 300000),
(69, 'PJ0001', '2025-05-29', '08051342842', 'paku 10cm', 45, 25000, 1125000),
(70, 'PJ0001', '2025-05-29', '51203480', 'paku 3cm', 100, 20000, 2000000),
(71, 'PJ0001', '2025-05-29', '321480890', 'knee 1/2\'', 20, 3000, 60000),
(72, 'PJ0001', '2025-05-29', '02', 'semen', 120, 10000, 1200000),
(74, 'PJ0001', '2025-05-29', '94815209', 'batu split', 30, 340000, 10200000),
(75, 'PJ0001', '2025-05-29', '657890', 'tee 2\'', 20, 12000, 240000),
(76, 'PJ0002', '2025-05-30', '02', 'semen', 2, 10000, 20000),
(77, 'PJ0002', '2025-05-30', '0591231943', 'hollow 4x4', 5, 80000, 400000),
(78, 'PJ0002', '2025-05-30', '132094801', 'paku gypsum', 20, 30000, 600000),
(79, 'PJ0003', '2025-05-29', '4908123', 'paku payung 5cm', 3, 28000, 84000),
(80, 'PJ0003', '2025-05-29', '45687', 'sox 2 1/2\'', 2, 18000, 36000),
(81, 'PJ0003', '2025-05-29', '29418914', 'hollow 4x2', 1, 70000, 70000),
(82, 'PJ0003', '2025-05-29', '02', 'semen', 3, 10000, 30000),
(83, 'PJ0004', '2025-06-06', '94815209', 'batu split', 1, 340000, 340000),
(84, 'PJ0004', '2025-06-06', '953428510', 'pasir', 4, 300000, 1200000),
(85, 'PJ0004', '2025-06-06', '02', 'semen', 5, 10000, 50000),
(86, 'PJ0004', '2025-06-06', '30218002', 'paku 12cm', 12, 30000, 360000),
(87, 'PJ0004', '2025-06-06', '97394198', 'vlok sox 1/2\'x1 1/2\'', 42, 15000, 630000),
(88, 'PJ0004', '2025-06-06', '36474', 'sox 1 1/4\'', 21, 12000, 252000),
(89, 'PJ0005', '2025-05-29', '01', 'paku 5cm', 2, 12000, 24000),
(90, 'PJ0006', '2025-05-29', '35210840932', 'paku beton 7cm', 64, 700, 44800),
(91, 'PJ0007', '2025-05-29', '953428510', 'pasir', 1, 300000, 300000),
(92, 'PJ0007', '2025-05-29', '09321432', 'paku 7cm', 1, 20000, 20000),
(93, 'PJ0007', '2025-05-29', '4908123', 'paku payung 5cm', 1, 28000, 28000),
(94, 'PJ0007', '2025-05-29', '30218002', 'paku 12cm', 1, 30000, 30000),
(95, 'PJ0007', '2025-05-29', '589021', 'vlok sox 1/4\' x 3/4\'', 1, 5000, 5000),
(96, 'PJ0007', '2025-05-29', '34219', 'tee 3\'', 1, 15000, 15000),
(97, 'PJ0007', '2025-05-10', '40138429', 'lem tembak', 1, 15000, 15000),
(98, 'PJ0007', '2025-05-07', '08051342842', 'paku 10cm', 1, 25000, 25000),
(99, 'PJ0008', '2025-05-29', '3128440', 'vlok sox 1/2\'x1 1/4\'', 142, 14000, 1988000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jual_head`
--

CREATE TABLE `jual_head` (
  `no_jual` varchar(20) NOT NULL,
  `tgl_jual` date NOT NULL,
  `customer` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jml_bayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jual_head`
--

INSERT INTO `jual_head` (`no_jual`, `tgl_jual`, `customer`, `total`, `keterangan`, `jml_bayar`, `kembalian`) VALUES
('PJ0001', '2025-05-29', 'customer TB Mutiara', 15125000, '', 20000000, 4875000),
('PJ0002', '2025-05-30', 'customer TB Mutiara', 1020000, '', 1200000, 180000),
('PJ0003', '2025-05-29', 'customer TB Mutiara', 220000, '', 220000, 0),
('PJ0004', '2025-06-06', 'customer TB Mutiara', 2832000, '', 2900000, 68000),
('PJ0005', '2025-05-29', 'customer TB Mutiara', 24000, '', 27222, 3222),
('PJ0006', '2025-05-29', 'customer TB Mutiara', 44800, '', 80000, 35200),
('PJ0007', '2025-05-07', 'customer TB Mutiara', 438000, '', 500000, 62000),
('PJ0008', '2025-05-29', 'sandy', 1988000, '', 2000000, 12000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk_supplier`
--

CREATE TABLE `produk_supplier` (
  `id_produk_supplier` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `id_barang` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk_supplier`
--

INSERT INTO `produk_supplier` (`id_produk_supplier`, `id_supplier`, `id_barang`) VALUES
(13, 20, 'BRG-006'),
(25, 20, 'BRG-016'),
(70, 21, 'BRG-003'),
(14, 21, 'BRG-004'),
(15, 21, 'BRG-007'),
(18, 22, 'BRG-028'),
(19, 22, 'BRG-029'),
(17, 22, 'BRG-031'),
(67, 22, 'BRG-032'),
(68, 22, 'BRG-033'),
(21, 22, 'BRG-034'),
(20, 22, 'BRG-035'),
(22, 22, 'BRG-036'),
(23, 22, 'BRG-037'),
(26, 23, 'BRG-002'),
(30, 24, 'BRG-001'),
(29, 24, 'BRG-008'),
(31, 24, 'BRG-009'),
(27, 24, 'BRG-010'),
(28, 24, 'BRG-011'),
(36, 24, 'BRG-012'),
(37, 24, 'BRG-013'),
(35, 24, 'BRG-014'),
(33, 24, 'BRG-015'),
(34, 24, 'BRG-017'),
(32, 24, 'BRG-018'),
(41, 25, 'BRG-019'),
(42, 25, 'BRG-020'),
(40, 25, 'BRG-021'),
(38, 25, 'BRG-022'),
(39, 25, 'BRG-023'),
(44, 25, 'BRG-024'),
(43, 25, 'BRG-025'),
(45, 25, 'BRG-026'),
(47, 25, 'BRG-027'),
(46, 25, 'BRG-030'),
(51, 26, 'BRG-038'),
(56, 26, 'BRG-039'),
(52, 26, 'BRG-040'),
(50, 26, 'BRG-041'),
(48, 26, 'BRG-042'),
(49, 26, 'BRG-043'),
(54, 26, 'BRG-044'),
(53, 26, 'BRG-045'),
(55, 26, 'BRG-046'),
(57, 26, 'BRG-047'),
(65, 27, 'BRG-048'),
(63, 27, 'BRG-049'),
(62, 27, 'BRG-050'),
(64, 27, 'BRG-051'),
(58, 27, 'BRG-052'),
(60, 27, 'BRG-053'),
(59, 27, 'BRG-054'),
(61, 27, 'BRG-055'),
(66, 27, 'BRG-056'),
(69, 28, 'BRG-005');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `telp` varchar(25) NOT NULL,
  `deskripsi` varchar(256) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama`, `telp`, `deskripsi`, `alamat`) VALUES
(20, 'PT POCO', '454545454', 'mantap produknya', 'gdgdrgdsdsrfsef'),
(21, 'PT INDOMAR', '343435755', 'Kureng nih produknya', 'jalan mangga'),
(22, 'PT TEE', '563788823', 'ajib', 'Jl. tee 2'),
(23, 'PT SEMEN JAYA ABADI', '76768786786', 'produk semen setia', 'jl.semen jaya'),
(24, 'PT PAKU', '9914885343453', 'banyak pakunya disini', 'jalan paku lima delima'),
(25, 'PT KNEE', '081234566778', 'knee terbaik', 'jalan knee 5'),
(26, 'PT SOX', '08123456634', 'sox 123 jaya', 'jalan sox 5 6 7'),
(27, 'PT VLOK SOX', '08294266423', 'volk sox jaya abadiii', 'jl vlox sox'),
(28, 'SUPPLIER PASIR', '652872321', 'supplier pasir ', 'jlraya bojonglali');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(50) NOT NULL,
  `tanggal` date NOT NULL,
  `id_supplier` int(50) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `id_barang` int(12) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `qty` int(50) NOT NULL,
  `harga_satuan` int(50) NOT NULL,
  `total` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(35) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `level` int(1) NOT NULL COMMENT '1-admin\r\n2-owner\r\n3-kasir',
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `fullname`, `password`, `alamat`, `level`, `foto`) VALUES
(15, 'admin', 'test admin', '$2y$10$e3djMHFE9WMoHk8Cj.1FzugGG0rpyQqKQj8GVtC7raRIJNJK/0Hbe', 'mana aja', 1, '312-admin.png'),
(18, 'kasir', 'kasir2', '$2y$10$rg.Q.4.bUzRJho0ypQcj7.QWTgyHxpawMcbPUe75J7Su8Q0oiMNj6', 'jjj', 3, 'default-icon-user.jpg'),
(19, 'owner', 'owner2', '$2y$10$SRJEcJkSldMtphbwsyJhh.co/pIu3OcNZzk33aHHMyf6c6zLgl6r2', 'ddawawd', 2, 'default-icon-user.jpg'),
(21, 'karyawan', 'kar1', '$2y$10$g1VcKHQWXkK9U9/zZO0xJOs2GF1bMFJ5XI1SgXXDZbF0idhyStAtO', 'daawdawd', 4, 'default-icon-user.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `beli_detail`
--
ALTER TABLE `beli_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `beli_head`
--
ALTER TABLE `beli_head`
  ADD PRIMARY KEY (`no_beli`);

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indeks untuk tabel `jual_detail`
--
ALTER TABLE `jual_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jual_head`
--
ALTER TABLE `jual_head`
  ADD PRIMARY KEY (`no_jual`);

--
-- Indeks untuk tabel `produk_supplier`
--
ALTER TABLE `produk_supplier`
  ADD PRIMARY KEY (`id_produk_supplier`),
  ADD UNIQUE KEY `unique_produk_supplier` (`id_supplier`,`id_barang`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `beli_detail`
--
ALTER TABLE `beli_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `jual_detail`
--
ALTER TABLE `jual_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT untuk tabel `produk_supplier`
--
ALTER TABLE `produk_supplier`
  MODIFY `id_produk_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `produk_supplier`
--
ALTER TABLE `produk_supplier`
  ADD CONSTRAINT `produk_supplier_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE,
  ADD CONSTRAINT `produk_supplier_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
