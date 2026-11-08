<?php
require 'koneksi.php';

$status = $_GET['status'] ?? '';
$pesan = "";

if ($status == 'terhapus') {
    $pesan = "Barang berhasil dihapus.";
} else if ($status == 'dipakai') {
    $pesan = "Barang tidak bisa dihapus karena masih digunakan pada transaksi.";
} else if ($status == 'gagal') {
    $pesan = "Barang gagal dihapus.";
}

$hasil = mysqli_query($koneksi, "SELECT barang.id, barang.kode_barang, barang.nama_barang, barang.harga, barang.stok, supplier.nama AS nama_supplier FROM barang JOIN supplier ON barang.supplier_id = supplier.id ORDER BY barang.id");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Data Barang</title>
</head>
<body>
<p><a href="transaksi.php">Transaksi</a> | <a href="barang.php">Barang</a></p>
<h2>Data Barang</h2>
<?php
if ($pesan != '') {
    echo "<p>" . $pesan . "</p>";
}
?>
<table border="1" cellpadding="6" cellspacing="0">
<tr>
<th>No</th>
<th>Kode</th>
<th>Nama Barang</th>
<th>Harga</th>
<th>Stok</th>
<th>Supplier</th>
<th>Tindakan</th>
</tr>
<?php
$no = 1;
while ($baris = mysqli_fetch_assoc($hasil)) {
?>
<tr>
<td><?php echo $no; ?></td>
<td><?php echo htmlspecialchars($baris['kode_barang']); ?></td>
<td><?php echo htmlspecialchars($baris['nama_barang']); ?></td>
<td><?php echo $baris['harga']; ?></td>
<td><?php echo $baris['stok']; ?></td>
<td><?php echo htmlspecialchars($baris['nama_supplier']); ?></td>
<td>
<form action="barang_hapus.php" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin akan menghapus barang ini?');">
<input type="hidden" name="id" value="<?php echo $baris['id']; ?>">
<input type="submit" value="Hapus">
</form>
</td>
</tr>
<?php
    $no++;
}
?>
</table>
</body>
</html>
