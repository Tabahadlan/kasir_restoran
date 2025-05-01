<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'waiter') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Waiter</title>
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
            background-color: #343a40; /* dark gray */
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
        <a class="navbar-brand fw-bold" href="#">Kasir Restoran - Waiter</a>
        <div class="ms-auto">
            <a href="../logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar">
    <a href="index.php">🏠 Dashboard</a>
    <a href="pesanan/tambah.php">➕ Tambah Pesanan</a>
    <a href="pesanan/index.php">📋 Lihat Pesanan</a>
    <a href="menu/index.php">🍽️ Kelola Menu</a>
    <a href="laporan/index.php">📊 Laporan</a>
</div>

<!-- Konten -->
<div class="content">
    <h3 class="mb-4">Halo, <?= $_SESSION['namauser']; ?>! 👋</h3>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Tambah Pesanan</h5>
                    <p class="card-text">Catat pesanan pelanggan yang datang.</p>
                    <a href="pesanan/tambah.php" class="btn btn-primary">Tambah Pesanan</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Lihat Pesanan</h5>
                    <p class="card-text">Lihat dan kelola daftar pesanan pelanggan.</p>
                    <a href="pesanan/index.php" class="btn btn-primary">Lihat Pesanan</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Kelola menu</h5>
                    <p class="card-text">Tambahkan dan atur menu makanan & minuman..</p>
                    <a href="menu/index.php" class="btn btn-primary">Kelola menu</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Laporan Penjualan</h5>
                    <p class="card-text">Lihat laporan penjualan harian/mingguan.</p>
                    <a href="laporan/index.php" class="btn btn-primary">Lihat Laporan</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
