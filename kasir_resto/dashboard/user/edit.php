<?php
include '../../session_check.php';
include '../../config/db.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE iduser=$id"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    mysqli_query($conn, "UPDATE user SET password='$password', role='$role' WHERE iduser=$id");
    header("Location: index.php");
}
?>

<h2>Edit User</h2>
<form method="POST">
    Ganti Password Baru: <br>
    <input type="password" name="password" required><br><br>
    Role:<br>
    <select name="role">
        <option value="admin" <?= $data['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="waiter" <?= $data['role'] == 'waiter' ? 'selected' : '' ?>>Waiter</option>
        <option value="kasir" <?= $data['role'] == 'kasir' ? 'selected' : '' ?>>Kasir</option>
        <option value="owner" <?= $data['role'] == 'owner' ? 'selected' : '' ?>>Owner</option>
    </select><br><br>
    <button type="submit">Simpan Perubahan</button>
</form>
<a href="index.php">Kembali</a>
