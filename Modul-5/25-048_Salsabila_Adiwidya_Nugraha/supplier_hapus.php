<?php
require 'koneksi.php';

if (!isset($_POST['id'])) {
    header("Location: supplier.php");
    exit;
}

$id = (int) $_POST['id'];

$stmt = mysqli_prepare($koneksi, "DELETE FROM supplier WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: supplier.php");
    exit;
}

if (mysqli_stmt_errno($stmt) == 1451) {
    $pesan = "Supplier tidak bisa dihapus karena masih dipakai oleh data barang.";
} else {
    $pesan = "Data gagal dihapus.";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Hapus Supplier</title>
</head>
<body>
<p><?php echo $pesan; ?></p>
<p><a href="supplier.php">Kembali</a></p>
</body>
</html>
