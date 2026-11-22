<?php
require 'cek_owner.php';
require 'koneksi.php';

if (!isset($_POST['id'])) {
    header("Location: user.php");
    exit;
}

$id = (int) $_POST['id'];

if ($id == $_SESSION['id_user']) {
    header("Location: user.php?status=diri_sendiri");
    exit;
}

$stmt = mysqli_prepare($koneksi, "DELETE FROM `user` WHERE id_user = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: user.php?status=terhapus");
} else {
    header("Location: user.php?status=gagal");
}
exit;
?>
