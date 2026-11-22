<?php
require 'cek_owner.php';
require 'koneksi.php';

$username = "";
$nama = "";
$alamat = "";
$hp = "";
$level = 0;
$errors = array();

if (isset($_POST['simpan'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $nama = trim($_POST['nama']);
    $alamat = trim($_POST['alamat']);
    $hp = trim($_POST['hp']);
    $level = (int) ($_POST['level'] ?? 0);

    if ($username == '') {
        $errors['username'] = 'Username wajib diisi';
    } else if (!preg_match("/^[A-Za-z0-9_]{3,30}$/", $username)) {
        $errors['username'] = 'Username 3 sampai 30 karakter, hanya huruf, angka, dan garis bawah';
    }

    if ($password == '') {
        $errors['password'] = 'Password wajib diisi';
    } else if (strlen($password) < 6) {
        $errors['password'] = 'Password minimal 6 karakter';
    }

    if ($nama == '') {
        $errors['nama'] = 'Nama wajib diisi';
    } else if (strlen($nama) > 50) {
        $errors['nama'] = 'Nama maksimal 50 karakter';
    }

    if ($alamat == '') {
        $errors['alamat'] = 'Alamat wajib diisi';
    } else if (strlen($alamat) > 150) {
        $errors['alamat'] = 'Alamat maksimal 150 karakter';
    }

    if ($hp == '') {
        $errors['hp'] = 'HP wajib diisi';
    } else if (!preg_match("/^[0-9]{1,20}$/", $hp)) {
        $errors['hp'] = 'HP hanya berisi angka, maksimal 20 digit';
    }

    if ($level != 1 && $level != 2) {
        $errors['level'] = 'Level wajib dipilih';
    }

    if (!$errors) {
        $password_md5 = md5($password);

        $stmt = mysqli_prepare($koneksi, "INSERT INTO `user` (username, password, nama, alamat, hp, level) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssssi", $username, $password_md5, $nama, $alamat, $hp, $level);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: user.php");
            exit;
        }

        if (mysqli_stmt_errno($stmt) == 1062) {
            $errors['username'] = 'Username sudah dipakai';
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
<title>Tambah User</title>
</head>
<body>
<?php require 'menu.php'; ?>
<h2>Tambah Data User Baru</h2>
<?php
foreach ($errors as $pesan) {
    echo $pesan . "<br>";
}
?>
<form action="user_tambah.php" method="POST">
<table>
<tr>
<td>Username</td>
<td><input type="text" name="username" maxlength="30" value="<?php echo htmlspecialchars($username); ?>"></td>
</tr>
<tr>
<td>Password</td>
<td><input type="password" name="password"></td>
</tr>
<tr>
<td>Nama</td>
<td><input type="text" name="nama" maxlength="50" value="<?php echo htmlspecialchars($nama); ?>"></td>
</tr>
<tr>
<td>Alamat</td>
<td><input type="text" name="alamat" maxlength="150" value="<?php echo htmlspecialchars($alamat); ?>"></td>
</tr>
<tr>
<td>HP</td>
<td><input type="text" name="hp" maxlength="20" value="<?php echo htmlspecialchars($hp); ?>"></td>
</tr>
<tr>
<td>Level</td>
<td>
<select name="level">
<option value="0">[pilih level]</option>
<option value="1"<?php if ($level == 1) echo ' selected'; ?>>1 - Owner</option>
<option value="2"<?php if ($level == 2) echo ' selected'; ?>>2 - Kasir</option>
</select>
</td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="simpan" value="Simpan"> <a href="user.php">Batal</a></td>
</tr>
</table>
</form>
</body>
</html>
