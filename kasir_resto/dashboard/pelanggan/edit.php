<?php
include '../../session_check.php';
include '../../config/db.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pelanggan WHERE idpelanggan=$id"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['namapelanggan'];
    $jk = $_POST['jeniskelamin'];
    $nohp = $_POST['nohp'];
    $alamat = $_POST['alamat'];

    mysqli_query($conn, "UPDATE pelanggan SET namapelanggan='$nama', jeniskelamin='$jk', nohp='$nohp', alamat='$alamat' WHERE idpelanggan=$id");
    header("Location: index.php");
}
?>

<h2>Edit Pelanggan</h2>
<form method="POST">
    Nama: <br>
    <input type="text" name="namapelanggan" value="<?= $data['namapelanggan'] ?>" required><br><br>
    Jenis Kelamin:<br>
    <select name="jeniskelamin">
        <option value="0" <?= $data['jeniskelamin'] == 0 ? 'selected' : '' ?>>Pria</option>
        <option value="1" <?= $data['jeniskelamin'] == 1 ? 'selected' : '' ?>>Wanita</option>
    </select><br><br>
    No HP:<br>
    <input type="text" name="nohp" value="<?= $data['nohp'] ?>" required><br><br>
    Alamat:<br>
    <textarea name="alamat" required><?= $data['alamat'] ?></textarea><br><br>
    <button type="submit">Simpan Perubahan</button>
</form>
<a href="index.php">Kembali</a>
