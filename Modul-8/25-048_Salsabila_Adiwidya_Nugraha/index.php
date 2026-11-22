<?php
require 'cek_login.php';

$pesan = "";

if (($_GET['status'] ?? '') == 'ditolak') {
    $pesan = "Anda tidak memiliki akses ke halaman tersebut.";
}

$nama_level = ($_SESSION['level'] == 1) ? "Owner" : "Kasir";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Home</title>
</head>
<body>
<?php require 'menu.php'; ?>
<h2>Home</h2>
<?php
if ($pesan != '') {
    echo "<p>" . $pesan . "</p>";
}
?>
<p>Selamat datang, <b><?php echo htmlspecialchars($_SESSION['nama']); ?></b> (<?php echo $nama_level; ?>).</p>
</body>
</html>
