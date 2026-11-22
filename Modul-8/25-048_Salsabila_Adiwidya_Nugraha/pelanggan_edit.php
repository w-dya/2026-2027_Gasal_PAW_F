<?php
require 'cek_owner.php';
require 'koneksi.php';

$errors = array();

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = trim($_POST['nama']);
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $telp = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

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
        $stmt = mysqli_prepare($koneksi, "UPDATE pelanggan SET nama = ?, jenis_kelamin = ?, telp = ?, alamat = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssss", $nama, $jenis_kelamin, $telp, $alamat, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: pelanggan.php");
            exit;
        }

        $errors['database'] = 'Data gagal diperbarui';
    }
} else {
    $id = $_GET['id'] ?? '';

    $stmt = mysqli_prepare($koneksi, "SELECT nama, jenis_kelamin, telp, alamat FROM pelanggan WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if (!$data) {
        echo "Data pelanggan tidak ditemukan.<br>";
        echo '<a href="pelanggan.php">Kembali</a>';
        exit;
    }

    $nama = $data['nama'];
    $jenis_kelamin = $data['jenis_kelamin'];
    $telp = $data['telp'];
    $alamat = $data['alamat'];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Pelanggan</title>
</head>
<body>
<?php require 'menu.php'; ?>
<h2>Edit Data Pelanggan</h2>
<?php
foreach ($errors as $pesan) {
    echo $pesan . "<br>";
}
?>
<form action="pelanggan_edit.php" method="POST">
<input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
<table>
<tr>
<td>ID</td>
<td><?php echo htmlspecialchars($id); ?></td>
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
<td><input type="submit" name="update" value="Update"> <a href="pelanggan.php">Batal</a></td>
</tr>
</table>
</form>
</body>
</html>
