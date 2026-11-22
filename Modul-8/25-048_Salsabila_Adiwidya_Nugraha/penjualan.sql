CREATE DATABASE IF NOT EXISTS penjualan DEFAULT CHARACTER SET utf8mb4;
USE penjualan;

DROP TABLE IF EXISTS pembayaran;
DROP TABLE IF EXISTS transaksi_detail;
DROP TABLE IF EXISTS transaksi;
DROP TABLE IF EXISTS barang;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS pelanggan;
DROP TABLE IF EXISTS supplier;

CREATE TABLE supplier (
    id INT NOT NULL AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    telp VARCHAR(12) NOT NULL,
    alamat TEXT NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE pelanggan (
    id VARCHAR(20) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L','P') NOT NULL,
    telp VARCHAR(12) NOT NULL,
    alamat TEXT NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE barang (
    id INT NOT NULL AUTO_INCREMENT,
    kode_barang VARCHAR(10) NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL,
    supplier_id INT NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uk_kode_barang (kode_barang),
    CONSTRAINT fk_barang_supplier FOREIGN KEY (supplier_id) REFERENCES supplier (id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `user` (
    id_user TINYINT NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(35) NOT NULL,
    nama VARCHAR(50) NOT NULL,
    alamat VARCHAR(150) NOT NULL,
    hp VARCHAR(20) NOT NULL,
    level TINYINT(1) NOT NULL,
    PRIMARY KEY (id_user),
    UNIQUE KEY uk_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE transaksi (
    id INT NOT NULL AUTO_INCREMENT,
    waktu_transaksi DATE NOT NULL,
    keterangan TEXT NOT NULL,
    total INT NOT NULL,
    pelanggan_id VARCHAR(20) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_transaksi_pelanggan FOREIGN KEY (pelanggan_id) REFERENCES pelanggan (id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE transaksi_detail (
    transaksi_id INT NOT NULL,
    barang_id INT NOT NULL,
    harga INT NOT NULL,
    qty INT NOT NULL,
    PRIMARY KEY (transaksi_id, barang_id),
    CONSTRAINT fk_detail_transaksi FOREIGN KEY (transaksi_id) REFERENCES transaksi (id) ON DELETE CASCADE,
    CONSTRAINT fk_detail_barang FOREIGN KEY (barang_id) REFERENCES barang (id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE pembayaran (
    id INT NOT NULL AUTO_INCREMENT,
    waktu_bayar DATETIME NOT NULL,
    total INT NOT NULL,
    metode ENUM('TUNAI','TRANSFER','EDC') NOT NULL,
    transaksi_id INT NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_pembayaran_transaksi FOREIGN KEY (transaksi_id) REFERENCES transaksi (id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO supplier (id, nama, telp, alamat) VALUES
(1, 'PT. Maju Bersama', '08123456', 'Surabaya'),
(2, 'PT. Senang Sekali', '081515563', 'Bangkalan'),
(3, 'PT. Segar Segar', '0845454663', 'Surabaya'),
(4, 'CV. Sumber Rezeki', '081234567801', 'Sidoarjo'),
(5, 'PT. Mitra Pangan', '082134567802', 'Gresik'),
(6, 'UD. Berkah Jaya', '085234567803', 'Malang'),
(7, 'PT. Sinar Abadi', '087834567804', 'Mojokerto'),
(8, 'CV. Karya Makmur', '081334567805', 'Kediri'),
(9, 'PT. Tirta Murni', '082234567806', 'Jombang'),
(10, 'UD. Cahaya Baru', '085334567807', 'Pasuruan'),
(11, 'CV. Bintang Timur', '081934567808', 'Sidoarjo'),
(12, 'PT. Prima Sejahtera', '087734567809', 'Surabaya');

INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('PLG001', 'Budi Santoso', 'L', '081211110001', 'Jl. Mawar No. 12, Surabaya'),
('PLG002', 'Siti Aminah', 'P', '081211110002', 'Jl. Melati No. 5, Sidoarjo'),
('PLG003', 'Agus Wijaya', 'L', '081211110003', 'Jl. Kenanga No. 8, Gresik'),
('PLG004', 'Dewi Lestari', 'P', '081211110004', 'Jl. Anggrek No. 21, Malang'),
('PLG005', 'Rizky Pratama', 'L', '081211110005', 'Jl. Dahlia No. 3, Mojokerto'),
('PLG006', 'Nur Hidayah', 'P', '081211110006', 'Jl. Cempaka No. 17, Kediri'),
('PLG007', 'Andi Kurniawan', 'L', '081211110007', 'Jl. Flamboyan No. 9, Jombang'),
('PLG008', 'Rina Marlina', 'P', '081211110008', 'Jl. Teratai No. 14, Pasuruan'),
('PLG009', 'Fajar Nugroho', 'L', '081211110009', 'Jl. Kamboja No. 6, Surabaya'),
('PLG010', 'Putri Ayu', 'P', '081211110010', 'Jl. Seruni No. 30, Sidoarjo');

INSERT INTO barang (id, kode_barang, nama_barang, harga, stok, supplier_id) VALUES
(1, 'BRG001', 'Beras 5 Kg', 65000, 100, 5),
(2, 'BRG002', 'Minyak Goreng 1 Liter', 18000, 150, 1),
(3, 'BRG003', 'Gula Pasir 1 Kg', 16000, 120, 2),
(4, 'BRG004', 'Telur Ayam 1 Kg', 28000, 80, 3),
(5, 'BRG005', 'Tepung Terigu 1 Kg', 12000, 90, 4),
(6, 'BRG006', 'Kopi Bubuk 200 gram', 15000, 70, 6),
(7, 'BRG007', 'Teh Celup 25 pcs', 8000, 110, 7),
(8, 'BRG008', 'Sabun Mandi Batang', 5000, 200, 8),
(9, 'BRG009', 'Air Mineral 600 ml', 4000, 300, 9),
(10, 'BRG010', 'Mie Instan Goreng', 3500, 400, 1),
(11, 'BRG011', 'Garam Dapur 250 gram', 3000, 50, 2),
(12, 'BRG012', 'Kecap Manis 275 ml', 14000, 60, 3);

INSERT INTO `user` (id_user, username, password, nama, alamat, hp, level) VALUES
(1, 'owner', MD5('owner123'), 'Budi Santoso', 'Jl. Pahlawan No. 1, Surabaya', '081300000001', 1),
(2, 'admin', MD5('admin123'), 'Administrator', 'Jl. Merdeka No. 4, Sidoarjo', '081300000002', 1),
(3, 'kasir1', MD5('kasir123'), 'Wati Lestari', 'Jl. Diponegoro No. 7, Gresik', '081300000003', 2),
(4, 'kasir2', MD5('kasir123'), 'Eko Prasetyo', 'Jl. Veteran No. 10, Malang', '081300000004', 2),
(5, 'kasir3', MD5('kasir123'), 'Mega Safitri', 'Jl. Sudirman No. 15, Mojokerto', '081300000005', 2),
(6, 'kasir4', MD5('kasir123'), 'Dina Kartika', 'Jl. Gajah Mada No. 2, Kediri', '081300000006', 2),
(7, 'kasir5', MD5('kasir123'), 'Hendra Saputra', 'Jl. Pemuda No. 18, Jombang', '081300000007', 2),
(8, 'kasir6', MD5('kasir123'), 'Lina Marlina', 'Jl. Ahmad Yani No. 22, Pasuruan', '081300000008', 2),
(9, 'kasir7', MD5('kasir123'), 'Yulia Fitri', 'Jl. Hayam Wuruk No. 9, Surabaya', '081300000009', 2),
(10, 'kasir8', MD5('kasir123'), 'Tono Wibowo', 'Jl. Gatot Subroto No. 11, Sidoarjo', '081300000010', 2);

INSERT INTO transaksi (id, waktu_transaksi, keterangan, total, pelanggan_id) VALUES
(1, '2026-10-01', 'Pembelian bulanan', 101000, 'PLG001'),
(2, '2026-10-02', 'Belanja harian', 60000, 'PLG002'),
(3, '2026-10-03', 'Pembelian grosir', 70000, 'PLG003'),
(4, '2026-10-05', 'Belanja dapur', 74000, 'PLG004'),
(5, '2026-10-06', 'Belanja harian', 24000, 'PLG005'),
(6, '2026-10-08', 'Kebutuhan rumah', 85000, 'PLG006'),
(7, '2026-10-09', 'Pembelian rutin', 34000, 'PLG007'),
(8, '2026-10-12', 'Belanja mingguan', 91000, 'PLG008'),
(9, '2026-10-15', 'Pembelian kopi dan teh', 61000, 'PLG009'),
(10, '2026-10-20', 'Belanja bulanan', 154000, 'PLG010'),
(11, '2026-10-01', 'Pembelian tambahan sore', 34000, 'PLG002'),
(12, '2026-10-02', 'Belanja susulan', 18000, 'PLG001'),
(13, '2026-10-03', 'Pembelian tambahan', 38000, 'PLG005'),
(14, '2026-10-05', 'Belanja susulan', 48000, 'PLG004'),
(15, '2026-10-08', 'Pembelian tambahan', 39000, 'PLG001'),
(16, '2026-10-12', 'Belanja susulan', 65000, 'PLG003'),
(17, '2026-10-15', 'Pembelian tambahan', 32000, 'PLG009'),
(18, '2026-10-20', 'Belanja susulan', 57000, 'PLG006'),
(19, '2026-10-22', 'Belanja akhir bulan', 56000, 'PLG007'),
(20, '2026-10-25', 'Belanja akhir bulan', 81000, 'PLG010'),
(21, '2026-10-25', 'Pembelian tambahan', 15000, 'PLG002');

INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1, 1, 65000, 1),
(1, 2, 18000, 2),
(2, 3, 16000, 2),
(2, 4, 28000, 1),
(3, 10, 3500, 20),
(4, 5, 12000, 3),
(4, 6, 15000, 2),
(4, 7, 8000, 1),
(5, 9, 4000, 6),
(6, 8, 5000, 4),
(6, 1, 65000, 1),
(7, 2, 18000, 1),
(7, 3, 16000, 1),
(8, 4, 28000, 2),
(8, 10, 3500, 10),
(9, 6, 15000, 3),
(9, 7, 8000, 2),
(10, 1, 65000, 2),
(10, 5, 12000, 1),
(10, 9, 4000, 3),
(11, 9, 4000, 5),
(11, 10, 3500, 4),
(12, 2, 18000, 1),
(13, 4, 28000, 1),
(13, 8, 5000, 2),
(14, 3, 16000, 3),
(15, 7, 8000, 3),
(15, 6, 15000, 1),
(16, 1, 65000, 1),
(17, 5, 12000, 2),
(17, 9, 4000, 2),
(18, 10, 3500, 6),
(18, 2, 18000, 2),
(19, 4, 28000, 2),
(20, 1, 65000, 1),
(20, 3, 16000, 1),
(21, 8, 5000, 3);

INSERT INTO pembayaran (id, waktu_bayar, total, metode, transaksi_id) VALUES
(1, '2026-10-01 10:15:00', 101000, 'TUNAI', 1),
(2, '2026-10-02 14:30:00', 60000, 'TRANSFER', 2),
(3, '2026-10-03 09:05:00', 70000, 'TUNAI', 3),
(4, '2026-10-05 16:45:00', 74000, 'EDC', 4),
(5, '2026-10-06 11:20:00', 24000, 'TUNAI', 5),
(6, '2026-10-08 13:10:00', 85000, 'TRANSFER', 6),
(7, '2026-10-09 15:55:00', 34000, 'TUNAI', 7),
(8, '2026-10-12 10:40:00', 91000, 'EDC', 8),
(9, '2026-10-15 17:25:00', 61000, 'TRANSFER', 9),
(10, '2026-10-20 12:00:00', 154000, 'TUNAI', 10),
(11, '2026-10-01 15:30:00', 34000, 'TRANSFER', 11),
(12, '2026-10-02 17:10:00', 18000, 'TUNAI', 12),
(13, '2026-10-03 14:20:00', 38000, 'EDC', 13),
(14, '2026-10-05 18:00:00', 48000, 'TUNAI', 14),
(15, '2026-10-08 16:15:00', 39000, 'TRANSFER', 15),
(16, '2026-10-12 14:45:00', 65000, 'EDC', 16),
(17, '2026-10-15 18:30:00', 32000, 'TUNAI', 17),
(18, '2026-10-20 15:05:00', 57000, 'TRANSFER', 18),
(19, '2026-10-22 11:40:00', 56000, 'TUNAI', 19),
(20, '2026-10-25 10:25:00', 81000, 'EDC', 20),
(21, '2026-10-25 13:50:00', 15000, 'TUNAI', 21);
