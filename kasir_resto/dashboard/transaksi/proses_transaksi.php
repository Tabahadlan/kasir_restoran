<?php
session_start();
include '../../config/db.php';

$idpesanan = $_POST['idpesanan'];
$bayar = $_POST['bayar'];

// Ambil total dan idmeja dari pesanan
$query = "
    SELECT SUM(mn.harga * d.jumlah) AS total, p.idmeja
    FROM detail_pesanan d
    JOIN menu mn ON d.idmenu = mn.idmenu
    JOIN pesanan p ON d.idpesanan = p.idpesanan
    WHERE d.idpesanan = $idpesanan
";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$total = $data['total'];
$idmeja = $data['idmeja'];

// Hitung kembalian
$kembalian = $bayar - $total;

// Simpan transaksi
$query = "
    INSERT INTO transaksi (idpesanan, total, bayar, kembalian, iduser)
    VALUES ($idpesanan, $total, $bayar, $kembalian, {$_SESSION['iduser']})
";
mysqli_query($conn, $query);

// Ubah status meja jadi kosong
mysqli_query($conn, "UPDATE meja SET status = 'kosong' WHERE idmeja = $idmeja");

header("Location: transaksi.php?sukses=1&idpesanan=$idpesanan");
exit;

