<?php
session_start();
include '../../config/db.php';

$idpesanan = $_POST['idpesanan'];
$idmenu = $_POST['idmenu']; // array
$jumlah = $_POST['jumlah']; // array

// Hapus detail lama
mysqli_query($conn, "DELETE FROM detail_pesanan WHERE idpesanan = $idpesanan");

// Insert semua menu baru
for ($i = 0; $i < count($idmenu); $i++) {
    $idm = $idmenu[$i];
    $jml = $jumlah[$i];
    mysqli_query($conn, "INSERT INTO detail_pesanan (idpesanan, idmenu, jumlah) VALUES ($idpesanan, $idm, $jml)");
}

header("Location: index.php");
exit;
