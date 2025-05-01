<?php
include '../../session_check.php';
include '../../config/db.php';

$id = $_GET['id'];
$menu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM menu WHERE idmenu=$id"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['namamenu'];
    $harga = $_POST['harga'];

    mysqli_query($conn, "UPDATE menu SET namamenu='$nama', harga='$harga' WHERE idmenu=$id");
    header("Location: index.php");
}
?>

<h2>Edit Menu</h2>
<form method="POST">
    Nama Menu: <br>
    <input type="text" name="namamenu" value="<?= $menu['namamenu'] ?>" required><br><br>
    Harga: <br>
    <input type="number" name="harga" value="<?= $menu['harga'] ?>" required><br><br>
    <button type="submit">Simpan Perubahan</button>
</form>
<a href="index.php">Kembali</a>