<?php
include '../../session_check.php';
include '../../config/db.php';

$idpesanan = $_GET['idpesanan'];
$menu = mysqli_query($conn, "SELECT * FROM menu");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idmenu = $_POST['idmenu'];
    $jumlah = $_POST['jumlah'];

    // Cek apakah menu sudah ada di pesanan
    $cek = mysqli_query($conn, "SELECT * FROM detail_pesanan WHERE idpesanan=$idpesanan AND idmenu=$idmenu");
    if (mysqli_num_rows($cek) > 0) {
        // Update jumlah jika sudah ada
        mysqli_query($conn, "UPDATE detail_pesanan SET jumlah = jumlah + $jumlah WHERE idpesanan=$idpesanan AND idmenu=$idmenu");
    } else {
        // Insert baru
        mysqli_query($conn, "INSERT INTO detail_pesanan (idpesanan, idmenu, jumlah) VALUES ($idpesanan, $idmenu, $jumlah)");
    }

    header("Location: tambah.php?idpesanan=$idpesanan");
}
?>

<h2>Tambah Item ke Pesanan</h2>
<form method="POST">
    Pilih Menu:<br>
    <select name="idmenu" required>
        <?php while ($m = mysqli_fetch_assoc($menu)) {
            echo "<option value='{$m['idmenu']}'>{$m['namamenu']} - Rp{$m['harga']}</option>";
        } ?>
    </select><br><br>

    Jumlah:<br>
    <input type="number" name="jumlah" min="1" required><br><br>

    <button type="submit">Tambah</button>
</form>

<hr>
<h3>Daftar Item Pesanan</h3>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Menu</th>
        <th>Jumlah</th>
    </tr>
    <?php
    $items = mysqli_query($conn, "SELECT d.*, m.namamenu FROM detail_pesanan d JOIN menu m ON d.idmenu = m.idmenu WHERE d.idpesanan=$idpesanan");
    $no = 1;
    while ($i = mysqli_fetch_assoc($items)) {
        echo "<tr>
                <td>$no</td>
                <td>{$i['namamenu']}</td>
                <td>{$i['jumlah']}</td>
              </tr>";
        $no++;
    }
    ?>
</table>
<a href="../pesanan/index.php">Kembali ke Daftar Pesanan</a>
