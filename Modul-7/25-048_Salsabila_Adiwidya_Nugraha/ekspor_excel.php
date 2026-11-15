<?php
require 'koneksi.php';
require 'fungsi.php';

$mulai = $_GET['tanggal_mulai'] ?? '';
$selesai = $_GET['tanggal_selesai'] ?? '';

if (!tanggalValid($mulai) || !tanggalValid($selesai) || $mulai > $selesai) {
    die("Rentang tanggal tidak valid.");
}

$hasil = ambilRekap($koneksi, $mulai, $selesai);
$ringkasan = ambilRingkasan($koneksi, $mulai, $selesai);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=rekap_penjualan_" . $mulai . "_sd_" . $selesai . ".xls");
?>
<html>
<head>
<meta charset="UTF-8">
</head>
<body>
<table border="1">
<tr>
<th>No</th>
<th>Total Pendapatan</th>
<th>Tanggal Transaksi</th>
</tr>
<?php
$no = 1;
while ($row = mysqli_fetch_assoc($hasil)) {
    echo "<tr>";
    echo "<td>" . $no . "</td>";
    echo "<td>" . $row['total_pendapatan'] . "</td>";
    echo "<td>" . $row['tanggal'] . "</td>";
    echo "</tr>";
    $no++;
}
?>
<tr>
<td colspan="2">Jumlah Pelanggan Unik</td>
<td><?php echo $ringkasan['jumlah_pelanggan']; ?></td>
</tr>
<tr>
<td colspan="2">Total Pendapatan Keseluruhan</td>
<td><?php echo $ringkasan['total_keseluruhan']; ?></td>
</tr>
</table>
</body>
</html>
