<?php
require 'cek_owner.php';
require 'koneksi.php';

$id = "";
$nama = "";
$jenis_kelamin = "";
$telp = "";
$alamat = "";
$errors = array();

if (isset($_POST['simpan'])) {
    $id = trim($_POST['id']);
    $nama = trim($_POST['nama']);
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $telp = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    if ($id == '') {
        $errors['id'] = 'ID wajib diisi';
    } else if (!preg_match("/^[A-Za-z0-9]{1,20}$/", $id)) {
        $errors['id'] = 'ID hanya berisi huruf dan angka, maksimal 20 karakter';
    }

    if ($nama == '') {
        $errors['nama'] = 'Nama wajib diisi';
    } else if (strlen($nama) > 100) {
        $errors['nama'] = 'Nama maksimal 100 karakter';
    }

    if ($jenis_kelamin != 'L' && $jenis_kelamin != 'P') {
        $errors['jenis_kelamin'] = 'Jenis kelamin wajib dipilih';
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
        $stmt = mysqli_prepare($koneksi, "INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssss", $id, $nama, $jenis_kelamin, $telp, $alamat);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: pelanggan.php");
            exit;
        }

        if (mysqli_stmt_errno($stmt) == 1062) {
            $errors['id'] = 'ID pelanggan sudah dipakai';
        } else {
            $errors['database'] = 'Data gagal disimpan';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Tambah Pelanggan</title>
</head>
<body>
<?php require 'menu.php'; ?>
<h2>Tambah Data Pelanggan Baru</h2>
<?php
foreach ($errors as $pesan) {
    echo $pesan . "<br>";
}
?>
<form action="pelanggan_tambah.php" method="POST">
<table>
<tr>
<td>ID</td>
<td><input type="text" name="id" maxlength="20" value="<?php echo htmlspecialchars($id); ?>"></td>
</tr>
<tr>
<td>Nama</td>
<td><input type="text" name="nama" value="<?php echo htmlspecialchars($nama); ?>"></td>
</tr>
<tr>
<td>Jenis Kelamin</td>
<td>
<select name="jenis_kelamin">
<option value="">[pilih]</option>
<option value="L"<?php if ($jenis_kelamin == 'L') echo ' selected'; ?>>Laki-laki</option>
<option value="P"<?php if ($jenis_kelamin == 'P') echo ' selected'; ?>>Perempuan</option>
</select>
</td>
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
<td><input type="submit" name="simpan" value="Simpan"> <a href="pelanggan.php">Batal</a></td>
</tr>
</table>
</form>
</body>
</html>
