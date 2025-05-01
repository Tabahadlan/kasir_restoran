<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'waiter') {
    header("Location: ../../login.php");
    exit;
}

$mejaList = mysqli_query($conn, "SELECT * FROM meja");
$menuList = mysqli_query($conn, "SELECT * FROM menu");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['namapelanggan'];
    $jk = $_POST['jeniskelamin'];
    $nohp = $_POST['nohp'];
    $alamat = $_POST['alamat'];
    mysqli_query($conn, "INSERT INTO pelanggan (namapelanggan, jeniskelamin, nohp, alamat) VALUES ('$nama', '$jk', '$nohp', '$alamat')");
    $idpelanggan = mysqli_insert_id($conn);

    $idmeja = $_POST['idmeja'];
    $iduser = $_SESSION['iduser'];
    mysqli_query($conn, "INSERT INTO pesanan (idmeja, idpelanggan, iduser) VALUES ('$idmeja', '$idpelanggan', '$iduser')");
    $idpesanan = mysqli_insert_id($conn);

    mysqli_query($conn, "UPDATE meja SET status='terisi' WHERE idmeja='$idmeja'");

    foreach ($_POST['idmenu'] as $key => $idmenu) {
        $jumlah = $_POST['jumlah'][$key];
        if ($jumlah > 0) {
            mysqli_query($conn, "INSERT INTO detail_pesanan (idpesanan, idmenu, jumlah) VALUES ('$idpesanan', '$idmenu', '$jumlah')");
        }
    }

    echo "<script>alert('Pesanan berhasil dibuat'); window.location='index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-color: #f8f9fa;">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Kasir Restoran - Waiter</a>
            <div class="ms-auto">
                <a href="../../logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <h3 class="mb-4">Tambah Pesanan</h3>

        <form method="POST">
            <!-- Informasi Pelanggan -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">Informasi Pelanggan</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Pelanggan</label>
                            <input type="text" name="namapelanggan" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jeniskelamin" class="form-select" required>
                                <option value="0">Pria</option>
                                <option value="1">Wanita</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">No HP</label>
                            <input type="text" name="nohp" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilih Meja</label>
                        <select name="idmeja" class="form-select" required>
                            <?php while ($meja = mysqli_fetch_assoc($mejaList)): ?>
                                <?php if ($meja['status'] === 'kosong'): ?>
                                    <option value="<?= $meja['idmeja'] ?>">Meja <?= $meja['nomormeja'] ?>
                                        (<?= $meja['namameja'] ?>)</option>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Pilih Menu -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-success text-white">Pilih Menu</div>
                <div class="card-body">
                    <?php while ($menu = mysqli_fetch_assoc($menuList)): ?>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-6">
                                <?= $menu['namamenu'] ?> <span
                                    class="text-muted">(Rp<?= number_format($menu['harga']) ?>)</span>
                            </div>
                            <div class="col-md-3">
                                <input type="hidden" name="idmenu[]" value="<?= $menu['idmenu'] ?>">
                                <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" min="0"
                                    value="0">
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="mb-5">
                <button type="submit" class="btn btn-primary">Simpan Pesanan</button>
                <a href="../waiter.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>