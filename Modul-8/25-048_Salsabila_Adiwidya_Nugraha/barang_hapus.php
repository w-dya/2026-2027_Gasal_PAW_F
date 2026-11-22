<?php
require 'cek_owner.php';
require 'koneksi.php';

if (!isset($_POST['id'])) {
    header("Location: barang.php");
    exit;
}

$id = (int) $_POST['id'];

$stmt_cek = mysqli_prepare($koneksi, "SELECT COUNT(*) AS jumlah FROM transaksi_detail WHERE barang_id = ?");
mysqli_stmt_bind_param($stmt_cek, "i", $id);
mysqli_stmt_execute($stmt_cek);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_cek));

if ($data['jumlah'] > 0) {
    header("Location: barang.php?status=dipakai");
    exit;
}

$stmt_hapus = mysqli_prepare($koneksi, "DELETE FROM barang WHERE id = ?");
mysqli_stmt_bind_param($stmt_hapus, "i", $id);

if (mysqli_stmt_execute($stmt_hapus)) {
    header("Location: barang.php?status=terhapus");
} else {
    header("Location: barang.php?status=gagal");
}
exit;
?>
