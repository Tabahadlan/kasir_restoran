<?php
include '../../session_check.php';
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['namapelanggan'];
    $jk = $_POST['jeniskelamin'];
    $nohp = $_POST['nohp'];
    $alamat = $_POST['alamat'];

    mysqli_query($conn, "INSERT INTO pelanggan (namapelanggan, jeniskelamin, nohp, alamat) VALUES ('$nama', '$jk', '$nohp', '$alamat')");
    header("Location: index.php");
}
?>

<h2>Tambah Pelanggan</h2>
<form method="POST">
    Nama: <br>
    <input type="text" name="namapelanggan" required><br><br>
    Jenis Kelamin:<br>
    <select name="jeniskelamin">
        <option value="0">Pria</option>
        <option value="1">Wanita</option>
    </select><br><br>
    No HP:<br>
    <input type="text" name="nohp" required><br><br>
    Alamat:<br>
    <textarea name="alamat" required></textarea><br><br>
    <button type="submit">Simpan</button>
</form>
<a href="index.php">Kembali</a>