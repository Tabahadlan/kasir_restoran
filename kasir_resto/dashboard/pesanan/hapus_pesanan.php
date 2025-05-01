<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'waiter') {
    header("Location: ../../login.php");
    exit;
}

$id = $_GET['id'] ?? null;

if ($id) {
    // Ambil idmeja dari pesanan
    $q = mysqli_query($conn, "SELECT idmeja FROM pesanan WHERE idpesanan = $id");
    $data = mysqli_fetch_assoc($q);
    $idmeja = $data['idmeja'] ?? null;

    // Update status meja menjadi kosong jika ada
    if ($idmeja) {
        mysqli_query($conn, "UPDATE meja SET status = 'kosong' WHERE idmeja = $idmeja");
    }

    // Hapus detail pesanan dan pesanan
    mysqli_query($conn, "DELETE FROM detail_pesanan WHERE idpesanan = $id");
    mysqli_query($conn, "DELETE FROM pesanan WHERE idpesanan = $id");
}

header("Location: index.php");
exit;
