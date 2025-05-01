<?php
include '../../session_check.php';
include '../../config/db.php';

if (
    !isset($_SESSION['role']) ||
    !in_array($_SESSION['role'], ['owner', 'admin', 'waiter', 'kasir'])
) {
    header("Location: ../../login.php");
    exit;
}

// Filter tanggal
$tanggal_awal = $_GET['awal'] ?? date('Y-m-01');
$tanggal_akhir = $_GET['akhir'] ?? date('Y-m-d');

$query = "
    SELECT t.idtransaksi, p.idpesanan, u.namauser AS kasir, t.total, t.bayar, t.kembalian, t.created_at, m.nomormeja, pel.namapelanggan
    FROM transaksi t
    JOIN pesanan p ON t.idpesanan = p.idpesanan
    JOIN user u ON t.iduser = u.iduser
    JOIN meja m ON p.idmeja = m.idmeja
    JOIN pelanggan pel ON p.idpelanggan = pel.idpelanggan
    WHERE DATE(t.created_at) BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
    ORDER BY t.created_at DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Laporan Transaksi</h2>

        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="awal" class="form-label">Dari Tanggal</label>
                <input type="date" name="awal" id="awal" class="form-control" value="<?= $tanggal_awal ?>">
            </div>
            <div class="col-md-4">
                <label for="akhir" class="form-label">Sampai Tanggal</label>
                <input type="date" name="akhir" id="akhir" class="form-control" value="<?= $tanggal_akhir ?>">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Tampilkan</button>
                <a href="cetak.php?awal=<?= $tanggal_awal ?>&akhir=<?= $tanggal_akhir ?>" target="_blank"
                    class="btn btn-success">Cetak PDF</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Meja</th>
                        <th>Pelanggan</th>
                        <th>Pesanan</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Kembalian</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $grandTotal = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $idpesanan = $row['idpesanan'];

                        // Ambil detail pesanan
                        $detail_query = "
                            SELECT m.namamenu, dp.jumlah, (dp.jumlah * m.harga) AS subtotal
                            FROM detail_pesanan dp
                            JOIN menu m ON dp.idmenu = m.idmenu
                            WHERE dp.idpesanan = '$idpesanan'
                        ";
                        $detail_result = mysqli_query($conn, $detail_query);

                        echo "<tr>
                                <td>$no</td>
                                <td>{$row['created_at']}</td>
                                <td>{$row['nomormeja']}</td>
                                <td>{$row['namapelanggan']}</td>
                                <td><ul class='mb-0'>";
                        while ($detail = mysqli_fetch_assoc($detail_result)) {
                            echo "<li>{$detail['namamenu']} x {$detail['jumlah']} (Rp" . number_format($detail['subtotal'], 0, ',', '.') . ")</li>";
                        }
                        echo "</ul></td>
                                <td>{$row['kasir']}</td>
                                <td>Rp" . number_format($row['total'], 0, ',', '.') . "</td>
                                <td>Rp" . number_format($row['bayar'], 0, ',', '.') . "</td>
                                <td>Rp" . number_format($row['kembalian'], 0, ',', '.') . "</td>
                              </tr>";
                        $grandTotal += $row['total'];
                        $no++;
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6" class="text-end">Grand Total</th>
                        <th colspan="3">Rp<?= number_format($grandTotal, 0, ',', '.') ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-4">
            <?php
            $dashboard = "../owner.php"; // default

            if ($_SESSION['role'] == 'waiter') {
                $dashboard = "../waiter.php";
            } elseif ($_SESSION['role'] == 'kasir') {
                $dashboard = "../kasir.php";
            } elseif ($_SESSION['role'] == 'admin') {
                $dashboard = "../admin.php";
            }
            ?>
            <a href="<?= $dashboard ?>" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>

    </div>
</body>

</html>
