<?php
session_start();

// Cek apakah sudah login dan role-nya kasir
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'kasir') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #343a40;
            padding-top: 60px;
        }

        .sidebar a {
            color: #fff;
            padding: 15px;
            display: block;
            text-decoration: none;
            font-weight: 500;
        }

        .sidebar a:hover {
            background-color: #495057;
            color: #f8f9fa;
        }

        .content {
            margin-left: 250px;
            margin-top: 30px;
            padding: 30px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Kasir Restoran - Kasir</a>
            <div class="ms-auto">
                <a href="../logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="kasir.php">🏠 Dashboard</a>
        <a href="transaksi/transaksi.php">📋 Entri Transaksi</a>
        <a href="laporan/index.php">📊 Laporan</a>
    </div>

    <!-- Konten -->
    <div class="content">
        <h3 class="mb-4">Halo, <?= $_SESSION['namauser']; ?>! 👋</h3>

        <div class="row">
            <!-- Card: Entri Transaksi -->

            <!-- Card: Lihat Transaksi -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Entri Transaksi</h5>
                        <p class="card-text">Lihat dan kelola transaksi pelanggan.</p>
                        <a href="transaksi/transaksi.php" class="btn btn-primary">Lihat Transaksi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>