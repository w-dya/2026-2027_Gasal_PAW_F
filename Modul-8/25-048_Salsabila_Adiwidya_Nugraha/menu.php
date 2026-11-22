<div class="no-print" style="display:flex; justify-content:space-between; border-bottom:1px solid black; padding-bottom:6px; margin-bottom:10px;">
<div>
<b>Sistem Penjualan</b> |
<a href="index.php">Home</a> |
<?php if ($_SESSION['level'] == 1) { ?>
<details style="display:inline-block; vertical-align:top;">
<summary>Data Master</summary>
<a href="barang.php">Data Barang</a><br>
<a href="supplier.php">Data Supplier</a><br>
<a href="pelanggan.php">Data Pelanggan</a><br>
<a href="user.php">Data User</a>
</details> |
<?php } ?>
<a href="transaksi.php">Transaksi</a> |
<a href="laporan.php">Laporan</a>
</div>
<div>
<details style="display:inline-block; vertical-align:top;">
<summary><?php echo htmlspecialchars($_SESSION['nama']); ?></summary>
<a href="logout.php">Logout</a>
</details>
</div>
</div>
