<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['waiter', 'kasir'])) {
    header("Location: ../../login.php");
    exit;
}

$query = "
    SELECT 
        p.idpesanan, p.tanggal, m.nomormeja, m.namameja, 
        pel.namapelanggan, pel.nohp, 
        d.jumlah, mn.namamenu 
    FROM pesanan p
    JOIN meja m ON p.idmeja = m.idmeja
    JOIN pelanggan pel ON p.idpelanggan = pel.idpelanggan
    JOIN detail_pesanan d ON p.idpesanan = d.idpesanan
    JOIN menu mn ON d.idmenu = mn.idmenu
    WHERE p.idpesanan NOT IN (SELECT idpesanan FROM transaksi)
    ORDER BY p.idpesanan DESC
";


$result = mysqli_query($conn, $query);
$pesanan = [];
while ($row = mysqli_fetch_assoc($result)) {
    $pesanan[$row['idpesanan']]['tanggal'] = $row['tanggal'];
    $pesanan[$row['idpesanan']]['meja'] = $row['nomormeja'] . " - " . $row['namameja'];
    $pesanan[$row['idpesanan']]['pelanggan'] = $row['namapelanggan'] . " (" . $row['nohp'] . ")";
    $pesanan[$row['idpesanan']]['menu'][] = [
        'namamenu' => $row['namamenu'],
        'jumlah' => $row['jumlah']
    ];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan</title>
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
            <a class="navbar-brand fw-bold" href="#">Kasir Restoran - Waiter</a>
            <div class="ms-auto">
                <a href="../../logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="../waiter.php">🏠 Dashboard</a>
        <a href="../pesanan/tambah.php">➕ Tambah Pesanan</a>
        <a href="../pesanan/index.php" class="bg-dark">📋 Lihat Pesanan</a>
        <a href="../laporan/index.php">📊 Laporan</a>
    </div>

    <!-- Konten -->
    <div class="content">
        <h3 class="mb-4">📋 Daftar Pesanan</h3>

        <?php if (!empty($pesanan)): ?>
            <?php foreach ($pesanan as $id => $data): ?>
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-light">
                        <strong>ID Pesanan:</strong> <?= $id ?> | <strong>Tanggal:</strong> <?= $data['tanggal'] ?>
                    </div>
                    <div class="card-body">
                        <p><strong>Meja:</strong> <?= $data['meja'] ?></p>
                        <p><strong>Pelanggan:</strong> <?= $data['pelanggan'] ?></p>
                        <p><strong>Menu Dipesan:</strong></p>
                        <ul>
                            <?php foreach ($data['menu'] as $item): ?>
                                <li><?= $item['namamenu'] ?> - <?= $item['jumlah'] ?> porsi</li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="d-flex gap-2">
                            <a href="edit_pesanan.php?id=<?= $id ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="hapus_pesanan.php?id=<?= $id ?>" class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin ingin menghapus pesanan ini?')">Hapus</a>
                            <a href="selesai_pembayaran.php?id=<?= $id ?>" class="btn btn-sm btn-success"
                                onclick="return confirm('Yakin pembayaran telah selesai?')">Selesai</a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Belum ada pesanan.</p>
        <?php endif; ?>

        <a href="../waiter.php" class="btn btn-secondary mt-3">⬅ Kembali ke Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>