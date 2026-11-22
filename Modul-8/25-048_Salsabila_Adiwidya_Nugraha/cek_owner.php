<?php
require 'cek_login.php';

if ($_SESSION['level'] != 1) {
    header("Location: index.php?status=ditolak");
    exit;
}
?>
