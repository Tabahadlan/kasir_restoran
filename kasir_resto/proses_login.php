<?php
session_start();
include 'config/db.php';

$namauser = $_POST['namauser'];
$password = $_POST['password'];

$query = "SELECT * FROM user WHERE namauser='$namauser' AND password='$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);

    $_SESSION['iduser'] = $user['iduser'];
    $_SESSION['namauser'] = $user['namauser'];
    $_SESSION['role'] = $user['role'];

    // Redirect sesuai role
    switch ($user['role']) {
        case 'admin':
            header("Location: dashboard/admin.php");
            break;
        case 'waiter':
            header("Location: dashboard/waiter.php");
            break;
        case 'kasir':
            header("Location: dashboard/kasir.php");
            break;
        case 'owner':
            header("Location: dashboard/owner.php");
            break;
    }
} else {
    echo "Login gagal. <a href='login.php'>Coba lagi</a>";
}
?>