<?php
include '../../session_check.php';
include '../../config/db.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM pelanggan WHERE idpelanggan=$id");

header("Location: index.php");
