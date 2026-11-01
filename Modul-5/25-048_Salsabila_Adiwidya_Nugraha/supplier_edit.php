<?php
require 'koneksi.php';

$errors = array();

if (isset($_POST['update'])) {
    $id = (int) $_POST['id'];
    $nama = trim($_POST['nama']);
    $telp = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    if ($nama == '') {
        $errors['nama'] = 'Nama wajib diisi';
    } else if (strlen($nama) > 100) {
        $errors['nama'] = 'Nama maksimal 100 karakter';
    }

    if ($telp == '') {
        $errors['telp'] = 'Telp wajib diisi';
    } else if (!preg_match("/^[0-9]{1,12}$/", $telp)) {
        $errors['telp'] = 'Telp hanya berisi angka, maksimal 12 digit';
    }

    if ($alamat == '') {
        $errors['alamat'] = 'Alamat wajib diisi';
    }

    if (!$errors) {
        $stmt = mysqli_prepare($koneksi, "UPDATE supplier SET nama = ?, telp = ?, alamat = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssi", $nama, $telp, $alamat, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: supplier.php");
            exit;
        }

        $errors['database'] = 'Data gagal diperbarui';
    }
} else {
    $id = (int) ($_GET['id'] ?? 0);

    $stmt = mysqli_prepare($koneksi, "SELECT nama, telp, alamat FROM supplier WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $hasil = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($hasil);

    if (!$data) {
        echo "Data supplier tidak ditemukan.<br>";
        echo '<a href="supplier.php">Kembali</a>';
        exit;
    }

    $nama = $data['nama'];
    $telp = $data['telp'];
    $alamat = $data['alamat'];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Data Master Supplier</title>
</head>
<body>
<h2>Edit Data Master Supplier</h2>
<?php
foreach ($errors as $pesan) {
    echo $pesan . "<br>";
}
?>
<form action="supplier_edit.php" method="POST">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<table>
<tr>
<td>Nama</td>
<td><input type="text" name="nama" value="<?php echo htmlspecialchars($nama); ?>"></td>
</tr>
<tr>
<td>Telp</td>
<td><input type="text" name="telp" maxlength="12" value="<?php echo htmlspecialchars($telp); ?>"></td>
</tr>
<tr>
<td>Alamat</td>
<td><input type="text" name="alamat" value="<?php echo htmlspecialchars($alamat); ?>"></td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="update" value="Update"> <a href="supplier.php">Batal</a></td>
</tr>
</table>
</form>
</body>
</html>
