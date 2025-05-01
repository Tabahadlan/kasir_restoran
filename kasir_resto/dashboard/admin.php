<?php
session_start();

// Cek apakah sudah login dan role-nya admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }
        .sidebar {
            width: 200px;
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
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 200px;
            margin-top: 50px;
            padding: 30px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Kasir Restoran - Admin</a>
            <div class="ms-auto">
                <a href="../logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="admin.php">🏠 Dashboard</a>
        <a href="meja/index.php">🪑 Kelola Meja</a>
        <a href="menu/index.php">🍽️ Kelola Menu</a>
    </div>

    <!-- Konten -->
    <div class="content">
        <h3>Halo, <?= $_SESSION['namauser']; ?>! 👋</h3>
        <p>Selamat datang di dashboard admin. Silakan pilih menu di sidebar untuk mulai mengelola data restoran.</p>

        <div class="row mt-4">
            <!-- Card: Entri Meja -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Entri Meja</h5>
                        <p class="card-text">Kelola data meja yang tersedia di restoran.</p>
                        <a href="meja/index.php" class="btn btn-primary">Kelola Meja</a>
                    </div>
                </div>
            </div>

            <!-- Card: Entri Menu -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Entri Menu</h5>
                        <p class="card-text">Tambahkan dan atur menu makanan & minuman.</p>
                        <a href="menu/index.php" class="btn btn-primary">Kelola Menu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
