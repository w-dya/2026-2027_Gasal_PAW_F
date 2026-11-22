<?php
require 'cek_owner.php';
require 'koneksi.php';

$status = $_GET['status'] ?? '';
$pesan = "";

if ($status == 'terhapus') {
    $pesan = "User berhasil dihapus.";
} else if ($status == 'diri_sendiri') {
    $pesan = "Akun yang sedang dipakai tidak bisa dihapus.";
} else if ($status == 'gagal') {
    $pesan = "User gagal dihapus.";
}

$hasil = mysqli_query($koneksi, "SELECT id_user, username, nama, alamat, hp, level FROM `user` ORDER BY id_user");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Data User</title>
</head>
<body>
<?php require 'menu.php'; ?>
<h2>Data User</h2>
<p><a href="user_tambah.php">Tambah Data</a></p>
<?php
if ($pesan != '') {
    echo "<p>" . $pesan . "</p>";
}
?>
<table border="1" cellpadding="6" cellspacing="0">
<tr>
<th>No</th>
<th>Username</th>
<th>Nama</th>
<th>Alamat</th>
<th>HP</th>
<th>Level</th>
<th>Tindakan</th>
</tr>
<?php
$no = 1;
while ($baris = mysqli_fetch_assoc($hasil)) {
    $nama_level = ($baris['level'] == 1) ? "Owner" : "Kasir";
?>
<tr>
<td><?php echo $no; ?></td>
<td><?php echo htmlspecialchars($baris['username']); ?></td>
<td><?php echo htmlspecialchars($baris['nama']); ?></td>
<td><?php echo htmlspecialchars($baris['alamat']); ?></td>
<td><?php echo htmlspecialchars($baris['hp']); ?></td>
<td><?php echo $nama_level; ?></td>
<td>
<a href="user_edit.php?id=<?php echo $baris['id_user']; ?>">Edit</a>
<form action="user_hapus.php" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin akan menghapus user ini?');">
<input type="hidden" name="id" value="<?php echo $baris['id_user']; ?>">
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
