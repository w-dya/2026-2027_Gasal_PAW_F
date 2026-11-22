<?php
require 'cek_login.php';
require 'koneksi.php';

$id = (int) ($_GET['id'] ?? 0);

$stmt_master = mysqli_prepare($koneksi, "SELECT transaksi.id, transaksi.waktu_transaksi, transaksi.keterangan, transaksi.total, pelanggan.nama AS nama_pelanggan FROM transaksi JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id WHERE transaksi.id = ?");
mysqli_stmt_bind_param($stmt_master, "i", $id);
mysqli_stmt_execute($stmt_master);
$master = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_master));

if (!$master) {
    echo "Transaksi tidak ditemukan.<br>";
    echo '<a href="transaksi.php">Kembali</a>';
    exit;
}

$barang_id = 0;
$qty = "";
$errors = array();

if (isset($_POST['simpan'])) {
    $barang_id = (int) ($_POST['barang_id'] ?? 0);
    $qty = trim($_POST['qty'] ?? '');

    if ($barang_id == 0) {
        $errors['barang_id'] = 'Barang wajib dipilih';
    }

    if ($qty == '') {
        $errors['qty'] = 'Qty wajib diisi';
    } else if (!preg_match("/^[1-9][0-9]*$/", $qty)) {
        $errors['qty'] = 'Qty harus berupa angka bulat lebih dari 0';
    }

    if (!$errors) {
        $stmt_harga = mysqli_prepare($koneksi, "SELECT harga FROM barang WHERE id = ?");
        mysqli_stmt_bind_param($stmt_harga, "i", $barang_id);
        mysqli_stmt_execute($stmt_harga);
        $barang = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_harga));

        if (!$barang) {
            $errors['barang_id'] = 'Barang tidak ditemukan';
        }
    }

    if (!$errors) {
        $harga = (int) $barang['harga'];
        $jumlah = (int) $qty;

        mysqli_begin_transaction($koneksi);

        $stmt_simpan = mysqli_prepare($koneksi, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt_simpan, "iiii", $id, $barang_id, $harga, $jumlah);
        $berhasil = mysqli_stmt_execute($stmt_simpan);

        if ($berhasil) {
            $stmt_total = mysqli_prepare($koneksi, "UPDATE transaksi SET total = (SELECT SUM(transaksi_detail.harga * transaksi_detail.qty) FROM transaksi_detail WHERE transaksi_detail.transaksi_id = ?) WHERE id = ?");
            mysqli_stmt_bind_param($stmt_total, "ii", $id, $id);
            $berhasil = mysqli_stmt_execute($stmt_total);
        }

        if ($berhasil) {
            mysqli_commit($koneksi);
            header("Location: transaksi_detail.php?id=" . $id);
            exit;
        }

        $kode_error = mysqli_stmt_errno($stmt_simpan);
        mysqli_rollback($koneksi);

        if ($kode_error == 1062) {
            $errors['barang_id'] = 'Barang sudah ada pada transaksi ini';
        } else {
            $errors['database'] = 'Data gagal disimpan';
        }
    }
}

$stmt_detail = mysqli_prepare($koneksi, "SELECT barang.kode_barang, barang.nama_barang, transaksi_detail.harga, transaksi_detail.qty, transaksi_detail.harga * transaksi_detail.qty AS subtotal FROM transaksi_detail JOIN barang ON transaksi_detail.barang_id = barang.id WHERE transaksi_detail.transaksi_id = ? ORDER BY barang.id");
mysqli_stmt_bind_param($stmt_detail, "i", $id);
mysqli_stmt_execute($stmt_detail);
$daftar_detail = mysqli_stmt_get_result($stmt_detail);

$stmt_pilihan = mysqli_prepare($koneksi, "SELECT id, kode_barang, nama_barang, harga FROM barang WHERE id NOT IN (SELECT barang_id FROM transaksi_detail WHERE transaksi_id = ?) ORDER BY nama_barang");
mysqli_stmt_bind_param($stmt_pilihan, "i", $id);
mysqli_stmt_execute($stmt_pilihan);
$pilihan_barang = mysqli_stmt_get_result($stmt_pilihan);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Detail Transaksi</title>
</head>
<body>
<?php require 'menu.php'; ?>
<h2>Detail Transaksi</h2>
<table>
<tr>
<td>No. Transaksi</td>
<td>: <?php echo $master['id']; ?></td>
</tr>
<tr>
<td>Tanggal</td>
<td>: <?php echo $master['waktu_transaksi']; ?></td>
</tr>
<tr>
<td>Pelanggan</td>
<td>: <?php echo htmlspecialchars($master['nama_pelanggan']); ?></td>
</tr>
<tr>
<td>Keterangan</td>
<td>: <?php echo htmlspecialchars($master['keterangan']); ?></td>
</tr>
<tr>
<td>Total</td>
<td>: <?php echo $master['total']; ?></td>
</tr>
</table>

<h3>Daftar Barang</h3>
<table border="1" cellpadding="6" cellspacing="0">
<tr>
<th>No</th>
<th>Kode</th>
<th>Barang</th>
<th>Harga</th>
<th>Qty</th>
<th>Subtotal</th>
</tr>
<?php
$no = 1;
while ($baris = mysqli_fetch_assoc($daftar_detail)) {
?>
<tr>
<td><?php echo $no; ?></td>
<td><?php echo htmlspecialchars($baris['kode_barang']); ?></td>
<td><?php echo htmlspecialchars($baris['nama_barang']); ?></td>
<td><?php echo $baris['harga']; ?></td>
<td><?php echo $baris['qty']; ?></td>
<td><?php echo $baris['subtotal']; ?></td>
</tr>
<?php
    $no++;
}
?>
</table>

<h3>Tambah Barang</h3>
<?php
foreach ($errors as $pesan) {
    echo $pesan . "<br>";
}

if (mysqli_num_rows($pilihan_barang) == 0) {
    echo "Semua barang sudah dimasukkan ke transaksi ini.";
} else {
?>
<form action="transaksi_detail.php?id=<?php echo $id; ?>" method="POST">
<table>
<tr>
<td>Barang</td>
<td>
<select name="barang_id">
<option value="0">[pilih barang]</option>
<?php
while ($b = mysqli_fetch_assoc($pilihan_barang)) {
    echo '<option value="' . $b['id'] . '"';
    if ($barang_id == $b['id']) {
        echo ' selected';
    }
    echo '>' . htmlspecialchars($b['kode_barang'] . ' - ' . $b['nama_barang']) . ' (' . $b['harga'] . ')</option>';
}
?>
</select>
</td>
</tr>
<tr>
<td>Qty</td>
<td><input type="text" name="qty" value="<?php echo htmlspecialchars($qty); ?>"></td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="simpan" value="Simpan"></td>
</tr>
</table>
</form>
<?php
}
?>
<p><a href="transaksi.php">Kembali</a></p>
</body>
</html>
