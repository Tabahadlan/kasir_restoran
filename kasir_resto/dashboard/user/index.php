<?php
include '../../session_check.php';
include '../../config/db.php';

if ($_SESSION['role'] != 'admin') {
    echo "Akses ditolak.";
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM user");
?>

<h2>Daftar User</h2>
<a href="tambah.php">+ Tambah User</a>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>
    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($data)) {
        echo "<tr>
                <td>$no</td>
                <td>{$row['namauser']}</td>
                <td>{$row['role']}</td>
                <td>
                    <a href='edit.php?id={$row['iduser']}'>Edit</a> |
                    <a href='hapus.php?id={$row['iduser']}' onclick='return confirm(\"Yakin?\")'>Hapus</a>
                </td>
              </tr>";
        $no++;
    }
    ?>
</table>
<a href="../admin.php">Kembali ke Dashboard</a>