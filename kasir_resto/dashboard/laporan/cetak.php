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
    <title>Cetak Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
            vertical-align: top;
        }
        ul {
            margin: 0;
            padding-left: 15px;
            text-align: left;
        }
        .total {
            font-weight: bold;
        }
        .noprint {
            margin-top: 20px;
        }
        @media print {
            .noprint {
                display: none;
            }
        }
    </style>
</head>
<body>

<h2>Laporan Transaksi<br>
<small><?= date('d M Y', strtotime($tanggal_awal)) ?> - <?= date('d M Y', strtotime($tanggal_akhir)) ?></small></h2>

<table>
    <thead>
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

            $pesananList = "<ul>";
            while ($detail = mysqli_fetch_assoc($detail_result)) {
                $pesananList .= "<li>{$detail['namamenu']} x {$detail['jumlah']} (Rp" . number_format($detail['subtotal'], 0, ',', '.') . ")</li>";
            }
            $pesananList .= "</ul>";

            echo "<tr>
                    <td>$no</td>
                    <td>{$row['created_at']}</td>
                    <td>{$row['nomormeja']}</td>
                    <td>{$row['namapelanggan']}</td>
                    <td>$pesananList</td>
                    <td>{$row['kasir']}</td>
                    <td>Rp" . number_format($row['total'], 0, ',', '.') . "</td>
                    <td>Rp" . number_format($row['bayar'], 0, ',', '.') . "</td>
                    <td>Rp" . number_format($row['kembalian'], 0, ',', '.') . "</td>
                  </tr>";
            $grandTotal += $row['total'];
            $no++;
        }
        ?>
        <tr>
            <td colspan="6" class="total">Grand Total</td>
            <td colspan="3" class="total">Rp<?= number_format($grandTotal, 0, ',', '.') ?></td>
        </tr>
    </tbody>
</table>

<div class="noprint">
    <button onclick="window.print()">🖨️ Cetak PDF</button>
    <a href="index.php">← Kembali</a>
</div>

</body>
</html>
