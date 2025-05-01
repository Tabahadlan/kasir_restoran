<?php
include '../../session_check.php';
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['namauser'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    mysqli_query($conn, "INSERT INTO user (namauser, password, role) VALUES ('$nama', '$password', '$role')");
    header("Location: index.php");
}
?>

<h2>Tambah User</h2>
<form method="POST">
    Nama: <br>
    <input type="text" name="namauser" required><br><br>
    Password: <br>
    <input type="password" name="password" required><br><br>
    Role:<br>
    <select name="role">
        <option value="admin">Admin</option>
        <option value="waiter">Waiter</option>
        <option value="kasir">Kasir</option>
        <option value="owner">Owner</option>
    </select><br><br>
    <button type="submit">Simpan</button>
</form>
<a href="index.php">Kembali</a>