<?php
include '../../session_check.php';
include '../../config/db.php';

$data = mysqli_query($conn, "SELECT * FROM pelanggan");
?>

<h2>Daftar Pelanggan</h2>
<a href="tambah.php">+ Tambah Pelanggan</a>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>No HP</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>
    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($data)) {
        $jk = $row['jeniskelamin'] == 1 ? "Wanita" : "Pria";
        echo "<tr>
                <td>$no</td>
                <td>{$row['namapelanggan']}</td>
                <td>$jk</td>
                <td>{$row['nohp']}</td>
                <td>{$row['alamat']}</td>
                <td>
                    <a href='edit.php?id={$row['idpelanggan']}'>Edit</a> |
                    <a href='hapus.php?id={$row['idpelanggan']}' onclick='return confirm(\"Yakin?\")'>Hapus</a>
                </td>
              </tr>";
        $no++;
    }
    ?>
</table>
<a href="../admin.php">Kembali ke Dashboard</a>
