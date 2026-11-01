<?php
require 'koneksi.php';

$nama = "";
$telp = "";
$alamat = "";
$errors = array();

if (isset($_POST['simpan'])) {
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
        $stmt = mysqli_prepare($koneksi, "INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $nama, $telp, $alamat);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: supplier.php");
            exit;
        }

        $errors['database'] = 'Data gagal disimpan';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Tambah Data Master Supplier</title>
</head>
<body>
<h2>Tambah Data Master Supplier Baru</h2>
<?php
foreach ($errors as $pesan) {
    echo $pesan . "<br>";
}
?>
<form action="supplier_tambah.php" method="POST">
<table>
<tr>
<td>Nama</td>
<td><input type="text" name="nama" placeholder="Nama" value="<?php echo htmlspecialchars($nama); ?>"></td>
</tr>
<tr>
<td>Telp</td>
<td><input type="text" name="telp" placeholder="telp" maxlength="12" value="<?php echo htmlspecialchars($telp); ?>"></td>
</tr>
<tr>
<td>Alamat</td>
<td><input type="text" name="alamat" placeholder="alamat" value="<?php echo htmlspecialchars($alamat); ?>"></td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="simpan" value="Simpan"> <a href="supplier.php">Batal</a></td>
</tr>
</table>
</form>
</body>
</html>
