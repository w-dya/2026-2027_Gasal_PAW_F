<?php
require 'cek_login.php';
require 'koneksi.php';

$hasil = mysqli_query($koneksi, "SELECT transaksi.id, transaksi.waktu_transaksi, transaksi.keterangan, transaksi.total, pelanggan.nama AS nama_pelanggan FROM transaksi JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id ORDER BY transaksi.id");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Data Transaksi</title>
</head>
<body>
<?php require 'menu.php'; ?>
<h2>Data Transaksi</h2>
<p><a href="transaksi_tambah.php">Tambah Transaksi</a></p>
<table border="1" cellpadding="6" cellspacing="0">
<tr>
<th>No</th>
<th>Tanggal</th>
<th>Pelanggan</th>
<th>Keterangan</th>
<th>Total</th>
<th>Tindakan</th>
</tr>
<?php
$no = 1;
while ($baris = mysqli_fetch_assoc($hasil)) {
?>
<tr>
<td><?php echo $no; ?></td>
<td><?php echo $baris['waktu_transaksi']; ?></td>
<td><?php echo htmlspecialchars($baris['nama_pelanggan']); ?></td>
<td><?php echo htmlspecialchars($baris['keterangan']); ?></td>
<td><?php echo $baris['total']; ?></td>
<td><a href="transaksi_detail.php?id=<?php echo $baris['id']; ?>">Detail</a></td>
</tr>
<?php
    $no++;
}
?>
</table>
</body>
</html>
