<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'waiter')) {
    header("Location: ../../login.php");
    exit;
}


// Tambah menu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $namamenu = $_POST['namamenu'];
    $harga = $_POST['harga'];
    mysqli_query($conn, "INSERT INTO menu (namamenu, harga) VALUES ('$namamenu', '$harga')");
    header("Location: index.php");
    exit;
}

// Edit menu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $idmenu = $_POST['idmenu'];
    $namamenu = $_POST['namamenu'];
    $harga = $_POST['harga'];
    mysqli_query($conn, "UPDATE menu SET namamenu='$namamenu', harga='$harga' WHERE idmenu=$idmenu");
    header("Location: index.php");
    exit;
}

// Ambil data untuk edit jika ada
$editData = null;
if (isset($_GET['edit'])) {
    $idedit = $_GET['edit'];
    $editResult = mysqli_query($conn, "SELECT * FROM menu WHERE idmenu=$idedit");
    $editData = mysqli_fetch_assoc($editResult);
}

// Hapus menu
if (isset($_GET['hapus'])) {
    $idmenu = $_GET['hapus'];

    // Hapus dulu dari detail_pesanan
    mysqli_query($conn, "DELETE FROM detail_pesanan WHERE idmenu = $idmenu");

    // Lanjut hapus dari menu
    mysqli_query($conn, "DELETE FROM menu WHERE idmenu = $idmenu");

    echo "<script>
        alert('Menu berhasil dihapus beserta data terkait di detail pesanan!');
        window.location.href = 'index.php';
    </script>";
}

$menus = mysqli_query($conn, "SELECT * FROM menu");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Menu</title>
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
            <a class="navbar-brand" href="#">Kelola Menu</a>
            <div class="ms-auto">
                <a href="../../logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <?php
        $dashboard = ($_SESSION['role'] === 'waiter') ? "../waiter.php" : "../admin.php";
        ?>
        <a href="<?= $dashboard ?>">🏠 Dashboard</a>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="../meja/index.php">🪑 Kelola Meja</a>
        <?php endif; ?>
        <a href="../menu/index.php" class="bg-primary">🍽️ Kelola Menu</a>
    </div>

    <!-- Konten -->
    <div class="content">
        <h3 class="mb-4"><?= $editData ? 'Edit Menu' : 'Tambah Menu Baru' ?></h3>

        <!-- Form Tambah/Edit -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST">
                    <?php if ($editData): ?>
                        <input type="hidden" name="idmenu" value="<?= $editData['idmenu'] ?>">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Nama Menu</label>
                        <input type="text" class="form-control" name="namamenu"
                            value="<?= $editData['namamenu'] ?? '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" class="form-control" name="harga" value="<?= $editData['harga'] ?? '' ?>"
                            required>
                    </div>
                    <button type="submit" name="<?= $editData ? 'update' : 'tambah' ?>"
                        class="btn btn-success"><?= $editData ? 'Update' : 'Simpan' ?></button>
                    <?php if ($editData): ?>
                        <a href="index.php" class="btn btn-secondary">Batal</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Daftar Menu -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Daftar Menu</h5>
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Nama Menu</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        while ($menu = mysqli_fetch_assoc($menus)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($menu['namamenu']) ?></td>
                                <td>Rp<?= number_format($menu['harga'], 0, ',', '.') ?></td>
                                <td>
                                    <a href="?edit=<?= $menu['idmenu'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="?hapus=<?= $menu['idmenu'] ?>" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php if (mysqli_num_rows($menus) == 0): ?>
                            <tr>
                                <td colspan="4" class="text-center">Belum ada menu</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>