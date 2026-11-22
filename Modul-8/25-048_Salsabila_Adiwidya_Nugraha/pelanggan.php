<?php
require 'cek_owner.php';
require 'koneksi.php';

$status = $_GET['status'] ?? '';
$pesan = "";

if ($status == 'terhapus') {
    $pesan = "Pelanggan berhasil dihapus.";
} else if ($status == 'dipakai') {
    $pesan = "Pelanggan tidak bisa dihapus karena masih digunakan pada transaksi.";
} else if ($status == 'gagal') {
    $pesan = "Pelanggan gagal dihapus.";
}

$hasil = mysqli_query($koneksi, "SELECT id, nama, jenis_kelamin, telp, alamat FROM pelanggan ORDER BY id");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Data Pelanggan</title>
</head>
<body>
<?php require 'menu.php'; ?>
<h2>Data Pelanggan</h2>
<p><a href="pelanggan_tambah.php">Tambah Data</a></p>
<?php
if ($pesan != '') {
    echo "<p>" . $pesan . "</p>";
}
?>
<table border="1" cellpadding="6" cellspacing="0">
<tr>
<th>No</th>
<th>ID</th>
<th>Nama</th>
<th>Jenis Kelamin</th>
<th>Telp</th>
<th>Alamat</th>
<th>Tindakan</th>
</tr>
<?php
$no = 1;
while ($baris = mysqli_fetch_assoc($hasil)) {
    $jk = ($baris['jenis_kelamin'] == 'L') ? "Laki-laki" : "Perempuan";
?>
<tr>
<td><?php echo $no; ?></td>
<td><?php echo htmlspecialchars($baris['id']); ?></td>
<td><?php echo htmlspecialchars($baris['nama']); ?></td>
<td><?php echo $jk; ?></td>
<td><?php echo htmlspecialchars($baris['telp']); ?></td>
<td><?php echo htmlspecialchars($baris['alamat']); ?></td>
<td>
<a href="pelanggan_edit.php?id=<?php echo urlencode($baris['id']); ?>">Edit</a>
<form action="pelanggan_hapus.php" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin akan menghapus pelanggan ini?');">
<input type="hidden" name="id" value="<?php echo htmlspecialchars($baris['id']); ?>">
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
