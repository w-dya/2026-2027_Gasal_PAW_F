<?php
require 'koneksi.php';

$hasil = mysqli_query($koneksi, "SELECT id, nama, telp, alamat FROM supplier ORDER BY id");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Data Master Supplier</title>
</head>
<body>
<h2>Data Master Supplier</h2>
<p><a href="supplier_tambah.php">Tambah Data</a></p>
<table border="1" cellpadding="6" cellspacing="0">
<tr>
<th>No</th>
<th>Nama</th>
<th>Telp</th>
<th>Alamat</th>
<th>Tindakan</th>
</tr>
<?php
$no = 1;
while ($baris = mysqli_fetch_assoc($hasil)) {
?>
<tr>
<td><?php echo $no; ?></td>
<td><?php echo htmlspecialchars($baris['nama']); ?></td>
<td><?php echo htmlspecialchars($baris['telp']); ?></td>
<td><?php echo htmlspecialchars($baris['alamat']); ?></td>
<td>
<a href="supplier_edit.php?id=<?php echo $baris['id']; ?>">Edit</a>
<form action="supplier_hapus.php" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin akan menghapus supplier ini?');">
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
