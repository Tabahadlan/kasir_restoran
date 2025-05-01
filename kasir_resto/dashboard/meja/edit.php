<?php
include '../../session_check.php';
include '../../config/db.php';

$id = $_GET['id'];
$meja = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM meja WHERE idmeja=$id"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor = $_POST['nomormeja'];
    $status = $_POST['status'];

    mysqli_query($conn, "UPDATE meja SET nomormeja='$nomor', status='$status' WHERE idmeja=$id");
    header("Location: index.php");
}
?>

<h2>Edit Meja</h2>
<form method="POST">
    Nomor Meja:<br>
    <input type="number" name="nomormeja" value="<?= $meja['nomormeja'] ?>" required><br><br>
    Status:<br>
    <select name="status">
        <option value="kosong" <?= $meja['status'] == 'kosong' ? 'selected' : '' ?>>Kosong</option>
        <option value="terisi" <?= $meja['status'] == 'terisi' ? 'selected' : '' ?>>Terisi</option>
    </select><br><br>
    <button type="submit">Simpan Perubahan</button>
</form>
<a href="index.php">Kembali</a>