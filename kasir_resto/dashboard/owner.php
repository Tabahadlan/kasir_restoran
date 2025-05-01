<?php
include '../session_check.php';
if ($_SESSION['role'] != 'owner') {
    header("Location: ../login/index.php");
    exit();
}

include '../config/db.php';

// Pendapatan Hari Ini
$today = date('Y-m-d');
$qToday = mysqli_query($conn, "SELECT SUM(total) AS total FROM transaksi WHERE DATE(created_at) = '$today'");
$todayTotal = mysqli_fetch_assoc($qToday)['total'] ?? 0;

// Pendapatan Minggu Ini
$qWeek = mysqli_query($conn, "SELECT SUM(total) AS total FROM transaksi WHERE YEARWEEK(created_at, 1) = YEARWEEK(NOW(), 1)");
$weekTotal = mysqli_fetch_assoc($qWeek)['total'] ?? 0;

// Pendapatan Bulan Ini
$month = date('Y-m');
$qMonth = mysqli_query($conn, "SELECT SUM(total) AS total FROM transaksi WHERE DATE_FORMAT(created_at, '%Y-%m') = '$month'");
$monthTotal = mysqli_fetch_assoc($qMonth)['total'] ?? 0;

// Jumlah Transaksi Hari Ini
$qTransToday = mysqli_query($conn, "SELECT COUNT(*) AS total FROM transaksi WHERE DATE(created_at) = '$today'");
$totalTransToday = mysqli_fetch_assoc($qTransToday)['total'] ?? 0;

// Menu Terlaris
$qMenu = mysqli_query($conn, "
    SELECT m.namamenu, SUM(dp.jumlah) AS total_terjual
    FROM detail_pesanan dp
    JOIN menu m ON m.idmenu = dp.idmenu
    GROUP BY dp.idmenu
    ORDER BY total_terjual DESC
    LIMIT 1
");
$menuTerlaris = mysqli_fetch_assoc($qMenu);
$namaMenuTerlaris = $menuTerlaris['namamenu'] ?? 'Belum Ada';
$jumlahTerjual = $menuTerlaris['total_terjual'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Owner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        min-height: 100vh;
        display: flex;
        background-color: #f8f9fa;
    }

    .sidebar {
        width: 250px;
        background-color: #343a40;
        color: white;
        padding: 1rem;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
        display: block;
        padding: 8px 0;
    }

    .sidebar a:hover {
        background-color: #495057;
        border-radius: 5px;
    }

    .content {
        flex-grow: 1;
        padding: 2rem;
    }

    .card-custom {
        background-color: #343a40;
        color: white;
        border: none;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .card-custom .card-title {
        font-weight: 500;
    }
</style>

</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Owner Panel</h4>
        <hr>
        <a href="../dashboard/laporan/index.php">📊 Laporan Transaksi</a>
        <a href="../logout.php">🚪 Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <h2>Selamat Datang, Owner!</h2>
        <p>Gunakan menu di sebelah kiri untuk melihat laporan keuangan dan performa restoran Anda.</p>

        <!-- <div class="row mt-4">
    <div class="col-md-4">
        <div class="card card-custom mb-3">
            <div class="card-body">
                <h5 class="card-title">💰 Pendapatan Hari Ini</h5>
                <p class="card-text fs-4">Rp <?= number_format($todayTotal, 0, ',', '.') ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom mb-3">
                    <div class="card-body">
                        <h5 class="card-title">📅 Pendapatan Minggu Ini</h5>
                        <p class="card-text fs-4">Rp <?= number_format($weekTotal, 0, ',', '.') ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom mb-3">
                    <div class="card-body">
                        <h5 class="card-title">🗓️ Pendapatan Bulan Ini</h5>
                        <p class="card-text fs-4">Rp <?= number_format($monthTotal, 0, ',', '.') ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card card-custom mb-3">
                    <div class="card-body">
                        <h5 class="card-title">📈 Jumlah Transaksi Hari Ini</h5>
                        <p class="card-text fs-4"><?= $totalTransToday ?> transaksi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-custom mb-3">
                    <div class="card-body">
                        <h5 class="card-title">🍽️ Menu Terlaris</h5>
                        <p class="card-text fs-5"><?= $namaMenuTerlaris ?> (<?= $jumlahTerjual ?> terjual)</p>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

</body>

</html>
