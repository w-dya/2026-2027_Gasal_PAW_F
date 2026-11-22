<?php
require 'cek_owner.php';
require 'koneksi.php';

$errors = array();

if (isset($_POST['update'])) {
    $id = (int) $_POST['id'];
    $kode_barang = trim($_POST['kode_barang']);
    $nama_barang = trim($_POST['nama_barang']);
    $harga = trim($_POST['harga']);
    $stok = trim($_POST['stok']);
    $supplier_id = (int) ($_POST['supplier_id'] ?? 0);

    if ($kode_barang == '') {
        $errors['kode_barang'] = 'Kode barang wajib diisi';
    } else if (strlen($kode_barang) > 10) {
        $errors['kode_barang'] = 'Kode barang maksimal 10 karakter';
    }

    if ($nama_barang == '') {
        $errors['nama_barang'] = 'Nama barang wajib diisi';
    } else if (strlen($nama_barang) > 100) {
        $errors['nama_barang'] = 'Nama barang maksimal 100 karakter';
    }

    if ($harga == '') {
        $errors['harga'] = 'Harga wajib diisi';
    } else if (!preg_match("/^[0-9]{1,9}$/", $harga)) {
        $errors['harga'] = 'Harga hanya berisi angka, maksimal 9 digit';
    }

    if ($stok == '') {
        $errors['stok'] = 'Stok wajib diisi';
    } else if (!preg_match("/^[0-9]{1,9}$/", $stok)) {
        $errors['stok'] = 'Stok hanya berisi angka, maksimal 9 digit';
    }

    if ($supplier_id == 0) {
        $errors['supplier_id'] = 'Supplier wajib dipilih';
    }

    if (!$errors) {
        $harga_angka = (int) $harga;
        $stok_angka = (int) $stok;

        $stmt = mysqli_prepare($koneksi, "UPDATE barang SET kode_barang = ?, nama_barang = ?, harga = ?, stok = ?, supplier_id = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssiiii", $kode_barang, $nama_barang, $harga_angka, $stok_angka, $supplier_id, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: barang.php");
            exit;
        }

        if (mysqli_stmt_errno($stmt) == 1062) {
            $errors['kode_barang'] = 'Kode barang sudah dipakai';
        } else if (mysqli_stmt_errno($stmt) == 1452) {
            $errors['supplier_id'] = 'Supplier tidak ditemukan';
        } else {
            $errors['database'] = 'Data gagal diperbarui';
        }
    }
} else {
    $id = (int) ($_GET['id'] ?? 0);

    $stmt = mysqli_prepare($koneksi, "SELECT kode_barang, nama_barang, harga, stok, supplier_id FROM barang WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if (!$data) {
        echo "Data barang tidak ditemukan.<br>";
        echo '<a href="barang.php">Kembali</a>';
        exit;
    }

    $kode_barang = $data['kode_barang'];
    $nama_barang = $data['nama_barang'];
    $harga = $data['harga'];
    $stok = $data['stok'];
    $supplier_id = (int) $data['supplier_id'];
}

$daftar_supplier = mysqli_query($koneksi, "SELECT id, nama FROM supplier ORDER BY nama");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Barang</title>
</head>
<body>
<?php require 'menu.php'; ?>
<h2>Edit Data Barang</h2>
<?php
foreach ($errors as $pesan) {
    echo $pesan . "<br>";
}
?>
<form action="barang_edit.php" method="POST">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<table>
<tr>
<td>Kode Barang</td>
<td><input type="text" name="kode_barang" maxlength="10" value="<?php echo htmlspecialchars($kode_barang); ?>"></td>
</tr>
<tr>
<td>Nama Barang</td>
<td><input type="text" name="nama_barang" value="<?php echo htmlspecialchars($nama_barang); ?>"></td>
</tr>
<tr>
<td>Harga</td>
<td><input type="text" name="harga" value="<?php echo htmlspecialchars($harga); ?>"></td>
</tr>
<tr>
<td>Stok</td>
<td><input type="text" name="stok" value="<?php echo htmlspecialchars($stok); ?>"></td>
</tr>
<tr>
<td>Supplier</td>
<td>
<select name="supplier_id">
<option value="0">[pilih supplier]</option>
<?php
while ($s = mysqli_fetch_assoc($daftar_supplier)) {
    echo '<option value="' . $s['id'] . '"';
    if ($supplier_id == $s['id']) {
        echo ' selected';
    }
    echo '>' . htmlspecialchars($s['nama']) . '</option>';
}
?>
</select>
</td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="update" value="Update"> <a href="barang.php">Batal</a></td>
</tr>
</table>
</form>
</body>
</html>
