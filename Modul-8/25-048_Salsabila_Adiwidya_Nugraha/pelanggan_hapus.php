<?php
require 'cek_owner.php';
require 'koneksi.php';

if (!isset($_POST['id'])) {
    header("Location: pelanggan.php");
    exit;
}

$id = $_POST['id'];

$stmt = mysqli_prepare($koneksi, "DELETE FROM pelanggan WHERE id = ?");
mysqli_stmt_bind_param($stmt, "s", $id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: pelanggan.php?status=terhapus");
} else if (mysqli_stmt_errno($stmt) == 1451) {
    header("Location: pelanggan.php?status=dipakai");
} else {
    header("Location: pelanggan.php?status=gagal");
}
exit;
?>
