<?php
function tanggalValid($tanggal)
{
    if (!is_string($tanggal)) {
        return false;
    }

    if (!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $tanggal)) {
        return false;
    }

    return checkdate((int) substr($tanggal, 5, 2), (int) substr($tanggal, 8, 2), (int) substr($tanggal, 0, 4));
}

function ambilRekap($koneksi, $mulai, $selesai)
{
    $stmt = mysqli_prepare($koneksi, "SELECT DATE(waktu_transaksi) AS tanggal, SUM(total) AS total_pendapatan FROM transaksi WHERE DATE(waktu_transaksi) BETWEEN ? AND ? GROUP BY DATE(waktu_transaksi) ORDER BY tanggal");
    mysqli_stmt_bind_param($stmt, "ss", $mulai, $selesai);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function ambilRingkasan($koneksi, $mulai, $selesai)
{
    $stmt = mysqli_prepare($koneksi, "SELECT COUNT(DISTINCT pelanggan_id) AS jumlah_pelanggan, COALESCE(SUM(total), 0) AS total_keseluruhan FROM transaksi WHERE DATE(waktu_transaksi) BETWEEN ? AND ?");
    mysqli_stmt_bind_param($stmt, "ss", $mulai, $selesai);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}
?>
