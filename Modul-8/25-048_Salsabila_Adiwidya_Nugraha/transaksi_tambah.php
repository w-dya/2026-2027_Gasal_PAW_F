<?php
require 'cek_login.php';
require 'koneksi.php';

$tanggal = date("Y-m-d");
$pelanggan_id = "";
$keterangan = "";
$errors = array();

if (isset($_POST['simpan'])) {
    $tanggal = trim($_POST['tanggal']);
    $pelanggan_id = $_POST['pelanggan_id'];
    $keterangan = trim($_POST['keterangan']);

    if ($tanggal == '') {
        $errors['tanggal'] = 'Tanggal wajib diisi';
    } else if (!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $tanggal)) {
        $errors['tanggal'] = 'Format tanggal harus tahun-bulan-tanggal';
    }

    if ($pelanggan_id == '') {
        $errors['pelanggan_id'] = 'Pelanggan wajib dipilih';
    }

    if ($keterangan == '') {
        $errors['keterangan'] = 'Keterangan wajib diisi';
    }

    if (!$errors) {
        $total = 0;
        $stmt = mysqli_prepare($koneksi, "INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssis", $tanggal, $keterangan, $total, $pelanggan_id);

        if (mysqli_stmt_execute($stmt)) {
            $id_baru = mysqli_stmt_insert_id($stmt);
            header("Location: transaksi_detail.php?id=" . $id_baru);
            exit;
        }

        $errors['database'] = 'Data gagal disimpan';
    }
}

$daftar_pelanggan = mysqli_query($koneksi, "SELECT id, nama FROM pelanggan ORDER BY nama");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Tambah Transaksi</title>
</head>
<body>
<?php require 'menu.php'; ?>
<h2>Tambah Transaksi Baru</h2>
<?php
foreach ($errors as $pesan) {
    echo $pesan . "<br>";
}
?>
<form action="transaksi_tambah.php" method="POST">
<table>
<tr>
<td>Tanggal</td>
<td><input type="date" name="tanggal" value="<?php echo htmlspecialchars($tanggal); ?>"></td>
</tr>
<tr>
<td>Pelanggan</td>
<td>
<select name="pelanggan_id">
<option value="">[pilih pelanggan]</option>
<?php
while ($p = mysqli_fetch_assoc($daftar_pelanggan)) {
    echo '<option value="' . htmlspecialchars($p['id']) . '"';
    if ($pelanggan_id == $p['id']) {
        echo ' selected';
    }
    echo '>' . htmlspecialchars($p['nama']) . '</option>';
}
?>
</select>
</td>
</tr>
<tr>
<td>Keterangan</td>
<td><input type="text" name="keterangan" value="<?php echo htmlspecialchars($keterangan); ?>"></td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="simpan" value="Simpan"> <a href="transaksi.php">Batal</a></td>
</tr>
</table>
</form>
</body>
</html>
