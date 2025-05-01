<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['kasir', 'waiter'])) {
    header("Location: ../../login.php");
    exit;
}

if (isset($_GET['id'])) {
    $idpesanan = $_GET['id'];

    // Cek apakah pesanan sudah dibayar
    $cekTransaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE idpesanan = $idpesanan");

    if (mysqli_num_rows($cekTransaksi) == 0 && $_SESSION['role'] == 'waiter') {
        // Jika belum dibayar dan role adalah waiter, tampilkan alert dan kembali
        echo "<script>
            alert('Pesanan belum dibayar. Hanya kasir yang bisa menyelesaikan!');
            window.location.href = 'index.php';
        </script>";
        exit;
    }

    // Ambil idmeja yang terkait dengan pesanan
    $q = mysqli_query($conn, "SELECT idmeja FROM pesanan WHERE idpesanan = $idpesanan");
    $data = mysqli_fetch_assoc($q);
    $idmeja = $data['idmeja'];

    // Update status meja jadi kosong
    mysqli_query($conn, "UPDATE meja SET status='kosong' WHERE idmeja=$idmeja");

    // Hapus detail pesanan dan pesanan
    mysqli_query($conn, "DELETE FROM detail_pesanan WHERE idpesanan=$idpesanan");
    mysqli_query($conn, "DELETE FROM pesanan WHERE idpesanan=$idpesanan");

    // Redirect
    header("Location: index.php");
    exit;
}
