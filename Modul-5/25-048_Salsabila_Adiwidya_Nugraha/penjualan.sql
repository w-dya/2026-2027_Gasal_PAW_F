CREATE DATABASE IF NOT EXISTS penjualan DEFAULT CHARACTER SET utf8mb4;
USE penjualan;

CREATE TABLE supplier (
    id INT(11) NOT NULL AUTO_INCREMENT,
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
    id INT(11) NOT NULL AUTO_INCREMENT,
    kode_barang VARCHAR(10) NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    harga INT(11) NOT NULL,
    stok INT(11) NOT NULL,
    supplier_id INT(11) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (supplier_id) REFERENCES supplier (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `user` (
    id_user TINYINT(2) NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(35) NOT NULL,
    nama VARCHAR(50) NOT NULL,
    alamat VARCHAR(150) NOT NULL,
    hp VARCHAR(20) NOT NULL,
    level TINYINT(1) NOT NULL,
    PRIMARY KEY (id_user)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE transaksi (
    id INT(11) NOT NULL AUTO_INCREMENT,
    waktu_transaksi DATE NOT NULL,
    keterangan TEXT NOT NULL,
    total INT(11) NOT NULL,
    pelanggan_id VARCHAR(20) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE transaksi_detail (
    transaksi_id INT(11) NOT NULL,
    barang_id INT(11) NOT NULL,
    harga INT(11) NOT NULL,
    qty INT(11) NOT NULL,
    PRIMARY KEY (transaksi_id, barang_id),
    FOREIGN KEY (transaksi_id) REFERENCES transaksi (id),
    FOREIGN KEY (barang_id) REFERENCES barang (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE pembayaran (
    id INT(11) NOT NULL AUTO_INCREMENT,
    waktu_bayar DATETIME NOT NULL,
    total INT(11) NOT NULL,
    metode ENUM('TUNAI','TRANSFER','EDC') NOT NULL,
    transaksi_id INT(11) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (transaksi_id) REFERENCES transaksi (id)
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
(10, 'BRG010', 'Mie Instan Goreng', 3500, 400, 1);

INSERT INTO `user` (id_user, username, password, nama, alamat, hp, level) VALUES
(1, 'admin', MD5('admin123'), 'Administrator', 'Jl. Pahlawan No. 1, Surabaya', '081300000001', 1),
(2, 'kasir1', MD5('kasir123'), 'Dina Kartika', 'Jl. Merdeka No. 4, Sidoarjo', '081300000002', 2),
(3, 'kasir2', MD5('kasir123'), 'Eko Prasetyo', 'Jl. Diponegoro No. 7, Gresik', '081300000003', 2),
(4, 'gudang1', MD5('gudang123'), 'Hendra Saputra', 'Jl. Veteran No. 10, Malang', '081300000004', 3),
(5, 'gudang2', MD5('gudang123'), 'Lina Marlina', 'Jl. Sudirman No. 15, Mojokerto', '081300000005', 3),
(6, 'owner', MD5('owner123'), 'Bambang Hartono', 'Jl. Gajah Mada No. 2, Kediri', '081300000006', 1),
(7, 'sales1', MD5('sales123'), 'Yulia Fitri', 'Jl. Pemuda No. 18, Jombang', '081300000007', 2),
(8, 'sales2', MD5('sales123'), 'Tono Wibowo', 'Jl. Ahmad Yani No. 22, Pasuruan', '081300000008', 2),
(9, 'kasir3', MD5('kasir123'), 'Mega Safitri', 'Jl. Hayam Wuruk No. 9, Surabaya', '081300000009', 2),
(10, 'staff1', MD5('staff123'), 'Ilham Ramadhan', 'Jl. Gatot Subroto No. 11, Sidoarjo', '081300000010', 3);

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
(10, '2026-10-20', 'Belanja bulanan', 154000, 'PLG010');

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
(10, 9, 4000, 3);

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
(10, '2026-10-20 12:00:00', 154000, 'TUNAI', 10);
