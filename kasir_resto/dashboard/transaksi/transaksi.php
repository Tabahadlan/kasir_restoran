<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'kasir') {
    header("Location: ../../login.php");
    exit;
}

$query = "
    SELECT p.idpesanan, m.nomormeja, pel.namapelanggan, SUM(mn.harga * d.jumlah) AS total
    FROM pesanan p
    JOIN meja m ON p.idmeja = m.idmeja
    JOIN pelanggan pel ON p.idpelanggan = pel.idpelanggan
    JOIN detail_pesanan d ON p.idpesanan = d.idpesanan
    JOIN menu mn ON d.idmenu = mn.idmenu
    WHERE p.idpesanan NOT IN (SELECT idpesanan FROM transaksi)
    GROUP BY p.idpesanan
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Entri Transaksi</title>
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
            <a class="navbar-brand" href="#">Kasir Restoran - Kasir</a>
            <div class="ms-auto">
                <a href="../../logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="../kasir.php">🏠 Dashboard</a>
        <a href="transaksi.php">📋 Entri Transaksi</a>
        <a href="../laporan/index.php">📊 Laporan</a>
    </div>

    <!-- Konten -->
    <div class="content">
        <h3 class="mb-4">Entri Transaksi Pembayaran</h3>

        <form action="proses_transaksi.php" method="POST">
            <div class="mb-3">
                <label for="idpesanan" class="form-label">Pilih Pesanan</label>
                <select name="idpesanan" id="idpesanan" class="form-select" required>
                    <option value="">-- Pilih Pesanan --</option>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <option value="<?= $row['idpesanan'] ?>" data-total="<?= $row['total'] ?>">
                            Pesanan #<?= $row['idpesanan'] ?> (Meja: <?= $row['nomormeja'] ?>, Pelanggan:
                            <?= $row['namapelanggan'] ?>) - Total:
                            Rp <?= number_format($row['total'], 0, ',', '.') ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="bayar" class="form-label">Jumlah Dibayar</label>
                <input type="number" name="bayar" id="bayar" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="kembalian" class="form-label">Kembalian</label>
                <input type="text" id="kembalian" class="form-control" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Proses Pembayaran</button>
            <a href="../kasir.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script>
        function hitungKembalian() {
            const bayarInput = document.getElementById('bayar');
            const kembalianInput = document.getElementById('kembalian');
            const select = document.getElementById('idpesanan');
            const selectedOption = select.options[select.selectedIndex];
            const total = parseInt(selectedOption.getAttribute('data-total')) || 0;
            const bayar = parseInt(bayarInput.value) || 0;
            const kembalian = bayar - total;

            kembalianInput.value = kembalian >= 0 ? 'Rp ' + kembalian.toLocaleString('id-ID') : '';
        }

        document.getElementById('bayar').addEventListener('input', hitungKembalian);
        document.getElementById('idpesanan').addEventListener('change', hitungKembalian);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php
    if (isset($_GET['sukses']) && $_GET['sukses'] == 1 && isset($_GET['idpesanan'])) {
        $idpesanan = $_GET['idpesanan'];

        $sql = "
        SELECT p.idpesanan, m.nomormeja, pel.namapelanggan, SUM(mn.harga * d.jumlah) AS total
        FROM pesanan p
        JOIN meja m ON p.idmeja = m.idmeja
        JOIN pelanggan pel ON p.idpelanggan = pel.idpelanggan
        JOIN detail_pesanan d ON p.idpesanan = d.idpesanan
        JOIN menu mn ON d.idmenu = mn.idmenu
        WHERE p.idpesanan = $idpesanan
        GROUP BY p.idpesanan
    ";

        $result = mysqli_query($conn, $sql);
        $pesanan = mysqli_fetch_assoc($result);

        $items = mysqli_query($conn, "
        SELECT mn.namamenu, d.jumlah, mn.harga
        FROM detail_pesanan d
        JOIN menu mn ON d.idmenu = mn.idmenu
        WHERE d.idpesanan = $idpesanan
    ");
        ?>
        <!-- Modal Bootstrap -->
        <!-- Modal Bootstrap -->
<div class="modal fade" id="strukModal" tabindex="-1" aria-labelledby="strukLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="strukLabel">🧾 Struk Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" id="struk-content">
                <p><strong>ID Pesanan:</strong> <?= $pesanan['idpesanan'] ?></p>
                        <p><strong>Meja:</strong> <?= $pesanan['nomormeja'] ?></p>
                        <p><strong>Pelanggan:</strong> <?= $pesanan['namapelanggan'] ?></p>
                        <hr>
                        <ul class="list-unstyled">
                            <?php while ($item = mysqli_fetch_assoc($items)): ?>
                                <li><?= $item['namamenu'] ?> x<?= $item['jumlah'] ?> - Rp
                                    <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.') ?>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                        <hr>
                        <p><strong>Total Bayar:</strong> Rp <?= number_format($pesanan['total'], 0, ',', '.') ?></p>
                        <p class="text-success fw-bold">✅ Pembayaran Berhasil</p>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-success" onclick="cetakStruk()">🖨️ Cetak Struk</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            const strukModal = new bootstrap.Modal(document.getElementById('strukModal'));
            window.addEventListener('load', () => {
                strukModal.show();
            });

            function cetakStruk() {
                const strukContent = document.getElementById('struk-content').innerHTML;
                const win = window.open('', '', 'width=400,height=600');
                win.document.write(`
                    <html>
                    <head>
                        <title>Struk Pembayaran</title>
                        <style>
                            body { font-family: Arial, sans-serif; font-size: 14px; padding: 20px; }
                            hr { border: 0; border-top: 1px dashed #000; margin: 10px 0; }
                            ul { padding-left: 0; list-style-type: none; }
                            li { margin-bottom: 5px; }
                            .text-success { color: green; }
                            .fw-bold { font-weight: bold; }
                        </style>
                    </head>
                    <body onload="window.print(); window.close();">
                        ${strukContent}
                    </body>
                    </html>
                `);
                win.document.close();
            }
        </script>

    <?php } ?>


</body>

</html>