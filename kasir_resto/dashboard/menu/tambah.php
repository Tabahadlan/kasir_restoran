<?php
include '../../session_check.php';
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['namamenu'];
    $harga = $_POST['harga'];

    mysqli_query($conn, "INSERT INTO menu (namamenu, harga) VALUES ('$nama', '$harga')");
    header("Location: index.php");
}
?>

<h2>Tambah Menu</h2>
<form method="POST">
    Nama Menu: <br>
    <input type="text" name="namamenu" required><br><br>
    Harga: <br>
    <input type="number" name="harga" required><br><br>
    <button type="submit">Simpan</button>
</form>
<a href="index.php">Kembali</a>