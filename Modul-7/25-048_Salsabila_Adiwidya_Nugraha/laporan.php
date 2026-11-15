<?php
require 'koneksi.php';
require 'fungsi.php';

$batas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT MIN(waktu_transaksi) AS awal, MAX(waktu_transaksi) AS akhir FROM transaksi"));

$mulai = $batas['awal'] ?? '';
$selesai = $batas['akhir'] ?? '';
$tampil = false;
$error = "";
$rekap = array();
$labels = array();
$nilai = array();
$ringkasan = array();

if (isset($_GET['tampilkan'])) {
    $mulai = $_GET['tanggal_mulai'] ?? '';
    $selesai = $_GET['tanggal_selesai'] ?? '';

    if (!tanggalValid($mulai) || !tanggalValid($selesai)) {
        $error = "Tanggal mulai dan tanggal selesai wajib diisi dengan benar.";
    } else if ($mulai > $selesai) {
        $error = "Tanggal mulai tidak boleh lebih besar dari tanggal selesai.";
    } else {
        $tampil = true;
    }
}

if ($tampil) {
    $hasil = ambilRekap($koneksi, $mulai, $selesai);
    $ringkasan = ambilRingkasan($koneksi, $mulai, $selesai);

    while ($row = mysqli_fetch_assoc($hasil)) {
        $rekap[] = $row;
        $labels[] = $row['tanggal'];
        $nilai[] = (int) $row['total_pendapatan'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Laporan Penjualan</title>
<style>
@media print {
    .no-print {
        display: none;
    }
}
</style>
</head>
<body>
<h2>Laporan Penjualan</h2>

<form action="laporan.php" method="GET" class="no-print">
Tanggal Mulai:
<input type="date" name="tanggal_mulai" value="<?php echo htmlspecialchars($mulai); ?>">
Tanggal Selesai:
<input type="date" name="tanggal_selesai" value="<?php echo htmlspecialchars($selesai); ?>">
<input type="submit" name="tampilkan" value="Tampilkan">
</form>
<?php
if ($error != '') {
    echo "<p>" . $error . "</p>";
}

if ($tampil && count($rekap) == 0) {
    echo "<p>Tidak ada transaksi pada rentang tanggal tersebut.</p>";
}

if ($tampil && count($rekap) > 0) {
?>
<p>Periode: <?php echo $mulai; ?> sampai <?php echo $selesai; ?></p>

<div class="no-print">
<button type="button" onclick="window.print()">Cetak</button>
<form action="ekspor_excel.php" method="GET" style="display:inline;">
<input type="hidden" name="tanggal_mulai" value="<?php echo $mulai; ?>">
<input type="hidden" name="tanggal_selesai" value="<?php echo $selesai; ?>">
<input type="submit" value="Excel">
</form>
</div>

<div style="max-width: 800px;">
<canvas id="grafik"></canvas>
</div>

<h3>Rekapitulasi Penjualan Harian</h3>
<table border="1" cellpadding="6" cellspacing="0">
<tr>
<th>No</th>
<th>Total Pendapatan</th>
<th>Tanggal Transaksi</th>
</tr>
<?php
    $no = 1;
    foreach ($rekap as $row) {
        echo "<tr>";
        echo "<td>" . $no . "</td>";
        echo "<td>" . number_format($row['total_pendapatan'], 0, ',', '.') . "</td>";
        echo "<td>" . $row['tanggal'] . "</td>";
        echo "</tr>";
        $no++;
    }
?>
</table>

<div style="border: 1px solid black; padding: 10px; margin-top: 10px; max-width: 320px;">
<p>Jumlah Pelanggan Unik: <b><?php echo $ringkasan['jumlah_pelanggan']; ?></b></p>
<p>Total Pendapatan Keseluruhan: <b>Rp <?php echo number_format($ringkasan['total_keseluruhan'], 0, ',', '.'); ?></b></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('grafik'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Total Pendapatan',
            data: <?php echo json_encode($nilai); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.6)'
        }]
    },
    options: {
        scales: {
            x: {
                title: { display: true, text: 'Tanggal Transaksi' }
            },
            y: {
                beginAtZero: true,
                title: { display: true, text: 'Total Pendapatan (Rp)' }
            }
        }
    }
});
</script>
<?php
}
?>
</body>
</html>
