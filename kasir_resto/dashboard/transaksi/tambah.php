<?php
include '../../session_check.php';
include '../../config/db.php';

// Cek apakah ada parameter idpesanan di URL
if (!isset($_GET['idpesanan']) || empty($_GET['idpesanan'])) {
    echo "<div style='margin: 20px; font-family: sans-serif;'>ID Pesanan tidak ditemukan! <a href='../kasir.php'>Kembali</a></div>";
    exit;
}

$idpesanan = (int) $_GET['idpesanan']; // casting ke integer (aman)

$pesanan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pesanan WHERE idpesanan = $idpesanan"));

if (!$pesanan) {
    echo "<div style='margin: 20px; font-family: sans-serif;'>Data pesanan tidak ditemukan! <a href='../kasir.php'>Kembali</a></div>";
    exit;
}

$items = mysqli_query($conn, "
    SELECT dp.*, m.harga, m.namamenu 
    FROM detail_pesanan dp 
    JOIN menu m ON dp.idmenu = m.idmenu 
    WHERE dp.idpesanan = $idpesanan
");

$total = 0;
while ($item = mysqli_fetch_assoc($items)) {
    $total += $item['jumlah'] * $item['harga'];
}

// Proses simpan transaksi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bayar = (int) $_POST['bayar'];
    $kembalian = $bayar - $total;

    mysqli_query($conn, "
        INSERT INTO transaksi (idpesanan, total, bayar, kembalian, iduser) 
        VALUES ($idpesanan, $total, $bayar, $kembalian, {$_SESSION['iduser']})
    ");

    mysqli_query($conn, "UPDATE pesanan SET status = 'selesai' WHERE idpesanan = $idpesanan");
    mysqli_query($conn, "UPDATE meja SET status = 'kosong' WHERE idmeja = {$pesanan['idmeja']}");

    header("Location: index.php");
    exit;
}
?>

<h2>Entri Transaksi</h2>
<p>Pesanan: Meja <?= $pesanan['idmeja'] ?> - Pelanggan: <?= $pesanan['idpelanggan'] ?></p>

<h3>Daftar Item Pesanan</h3>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Menu</th>
        <th>Jumlah</th>
        <th>Harga</th>
        <th>Total</th>
    </tr>
    <?php
    mysqli_data_seek($items, 0); // Reset pointer
    $no = 1;
    while ($item = mysqli_fetch_assoc($items)) {
        $subtotal = $item['jumlah'] * $item['harga'];
        echo "<tr>
                <td>$no</td>
                <td>{$item['namamenu']}</td>
                <td>{$item['jumlah']}</td>
                <td>Rp" . number_format($item['harga'], 0, ',', '.') . "</td>
                <td>Rp" . number_format($subtotal, 0, ',', '.') . "</td>
              </tr>";
        $no++;
    }
    ?>
    <tr>
        <td colspan="4">Total</td>
        <td>Rp<?= number_format($total, 0, ',', '.') ?></td>
    </tr>
</table>

<form method="POST">
    <br>
    <label>Bayar:</label><br>
    <input type="number" name="bayar" min="<?= $total ?>" required><br><br>

    <label>Kembalian:</label><br>
    <input type="number" name="kembalian" readonly><br><br>

    <button type="submit">Proses Transaksi</button>
    <a href="../kasir.php">Batal</a>
</form>

<script>
    document.querySelector('input[name="bayar"]').addEventListener('input', function () {
        let bayar = parseInt(this.value);
        let total = <?= $total ?>;
        let kembalian = bayar - total;
        document.querySelector('input[name="kembalian"]').value = kembalian >= 0 ? kembalian : 0;
    });
</script>