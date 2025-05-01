<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

// Tambah meja
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $nomormeja = $_POST['nomormeja'];
    $namameja = $_POST['namameja'];
    mysqli_query($conn, "INSERT INTO meja (nomormeja, namameja, status) VALUES ('$nomormeja', '$namameja', 'kosong')");
    header("Location: index.php");
    exit;
}

// Update meja
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $idmeja = $_POST['idmeja'];
    $nomormeja = $_POST['nomormeja'];
    $namameja = $_POST['namameja'];
    $status = $_POST['status'];
    mysqli_query($conn, "UPDATE meja SET nomormeja='$nomormeja', namameja='$namameja', status='$status' WHERE idmeja=$idmeja");
    header("Location: index.php");
    exit;
}

// Ambil data untuk edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM meja WHERE idmeja=$id");
    $editData = mysqli_fetch_assoc($res);
}

// Hapus meja
if (isset($_GET['hapus'])) {
    $idmeja = $_GET['hapus'];

    // 1. Ambil semua idpesanan yang terkait dengan meja ini
    $result = mysqli_query($conn, "SELECT idpesanan FROM pesanan WHERE idmeja = $idmeja");
    while ($row = mysqli_fetch_assoc($result)) {
        $idpesanan = $row['idpesanan'];

        // 2. Hapus transaksi berdasarkan idpesanan
        mysqli_query($conn, "DELETE FROM transaksi WHERE idpesanan = $idpesanan");

        // 3. Hapus detail_pesanan berdasarkan idpesanan
        mysqli_query($conn, "DELETE FROM detail_pesanan WHERE idpesanan = $idpesanan");
    }

    // 4. Hapus pesanan yang terkait dengan meja ini
    mysqli_query($conn, "DELETE FROM pesanan WHERE idmeja = $idmeja");

    // 5. Hapus meja itu sendiri
    mysqli_query($conn, "DELETE FROM meja WHERE idmeja = $idmeja");

    echo "<script>
        alert('Meja dan seluruh data terkait berhasil dihapus!');
        window.location.href = 'index.php';
    </script>";
}


$mejaList = mysqli_query($conn, "SELECT * FROM meja");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Entri Meja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
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
            <a class="navbar-brand" href="#">Kasir Restoran - Admin</a>
            <div class="ms-auto">
                <a href="../../logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="../admin.php">🏠 Dashboard</a>
        <a href="../meja/index.php" class="bg-secondary">🪑 Kelola Meja</a>
        <a href="../menu/index.php">🍽️ Kelola Menu</a>
    </div>

    <!-- Konten -->
    <div class="content">
        <h3 class="mb-4">Kelola Meja</h3>

        <!-- Form Entri / Edit -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title"><?= $editData ? 'Edit Meja' : 'Tambah Meja Baru' ?></h5>
                <form method="POST">
                    <?php if ($editData): ?>
                        <input type="hidden" name="idmeja" value="<?= $editData['idmeja'] ?>">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Nomor Meja</label>
                        <input type="number" class="form-control" name="nomormeja"
                            value="<?= $editData['nomormeja'] ?? '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Meja</label>
                        <input type="text" class="form-control" name="namameja"
                            value="<?= $editData['namameja'] ?? '' ?>" required>
                    </div>
                    <?php if ($editData): ?>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="kosong" <?= $editData['status'] === 'kosong' ? 'selected' : '' ?>>Kosong
                                </option>
                                <option value="terisi" <?= $editData['status'] === 'terisi' ? 'selected' : '' ?>>Terisi
                                </option>
                            </select>
                        </div>
                    <?php endif; ?>
                    <button type="submit" name="<?= $editData ? 'update' : 'tambah' ?>"
                        class="btn btn-success"><?= $editData ? 'Update' : 'Simpan' ?></button>
                    <?php if ($editData): ?>
                        <a href="index.php" class="btn btn-secondary">Batal</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Daftar Meja -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Daftar Meja</h5>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nomor</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        while ($meja = mysqli_fetch_assoc($mejaList)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $meja['nomormeja'] ?></td>
                                <td><?= $meja['namameja'] ?></td>
                                <td><?= ucfirst($meja['status']) ?></td>
                                <td>
                                    <a href="?edit=<?= $meja['idmeja'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="?hapus=<?= $meja['idmeja'] ?>" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php if (mysqli_num_rows($mejaList) == 0): ?>
                            <tr>
                                <td colspan="5" class="text-center">Belum ada meja</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>