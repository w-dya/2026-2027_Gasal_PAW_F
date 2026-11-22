<?php
require 'cek_owner.php';
require 'koneksi.php';

$errors = array();

if (isset($_POST['update'])) {
    $id = (int) $_POST['id'];
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

    if ($password != '' && strlen($password) < 6) {
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
        if ($password == '') {
            $stmt = mysqli_prepare($koneksi, "UPDATE `user` SET username = ?, nama = ?, alamat = ?, hp = ?, level = ? WHERE id_user = ?");
            mysqli_stmt_bind_param($stmt, "ssssii", $username, $nama, $alamat, $hp, $level, $id);
        } else {
            $password_md5 = md5($password);
            $stmt = mysqli_prepare($koneksi, "UPDATE `user` SET username = ?, password = ?, nama = ?, alamat = ?, hp = ?, level = ? WHERE id_user = ?");
            mysqli_stmt_bind_param($stmt, "sssssii", $username, $password_md5, $nama, $alamat, $hp, $level, $id);
        }

        if (mysqli_stmt_execute($stmt)) {
            header("Location: user.php");
            exit;
        }

        if (mysqli_stmt_errno($stmt) == 1062) {
            $errors['username'] = 'Username sudah dipakai';
        } else {
            $errors['database'] = 'Data gagal diperbarui';
        }
    }
} else {
    $id = (int) ($_GET['id'] ?? 0);

    $stmt = mysqli_prepare($koneksi, "SELECT username, nama, alamat, hp, level FROM `user` WHERE id_user = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if (!$data) {
        echo "Data user tidak ditemukan.<br>";
        echo '<a href="user.php">Kembali</a>';
        exit;
    }

    $username = $data['username'];
    $nama = $data['nama'];
    $alamat = $data['alamat'];
    $hp = $data['hp'];
    $level = (int) $data['level'];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit User</title>
</head>
<body>
<?php require 'menu.php'; ?>
<h2>Edit Data User</h2>
<?php
foreach ($errors as $pesan) {
    echo $pesan . "<br>";
}
?>
<form action="user_edit.php" method="POST">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<table>
<tr>
<td>Username</td>
<td><input type="text" name="username" maxlength="30" value="<?php echo htmlspecialchars($username); ?>"></td>
</tr>
<tr>
<td>Password</td>
<td><input type="password" name="password"> (kosongkan jika tidak diganti)</td>
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
<td><input type="submit" name="update" value="Update"> <a href="user.php">Batal</a></td>
</tr>
</table>
</form>
</body>
</html>
