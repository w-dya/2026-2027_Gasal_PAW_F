<?php
session_start();

if (isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit;
}

require 'koneksi.php';

$username = "";
$errors = array();

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username == '') {
        $errors['username'] = 'Username wajib diisi';
    }

    if ($password == '') {
        $errors['password'] = 'Password wajib diisi';
    }

    if (!$errors) {
        $password_md5 = md5($password);

        $stmt = mysqli_prepare($koneksi, "SELECT id_user, username, nama, level FROM `user` WHERE username = ? AND password = ?");
        mysqli_stmt_bind_param($stmt, "ss", $username, $password_md5);
        mysqli_stmt_execute($stmt);
        $data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

        if (!$data) {
            $errors['login'] = 'Username atau password salah';
        } else if ($data['level'] != 1 && $data['level'] != 2) {
            $errors['login'] = 'Level user tidak diizinkan untuk login';
        } else {
            session_regenerate_id(true);
            $_SESSION['id_user'] = $data['id_user'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['level'] = $data['level'];
            header("Location: index.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Login</title>
</head>
<body>
<h2>Sistem Penjualan</h2>
<h3>Login</h3>
<?php
foreach ($errors as $pesan) {
    echo $pesan . "<br>";
}
?>
<form action="login.php" method="POST">
<table>
<tr>
<td>Username</td>
<td><input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>"></td>
</tr>
<tr>
<td>Password</td>
<td><input type="password" name="password"></td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="login" value="Login"></td>
</tr>
</table>
</form>
</body>
</html>
