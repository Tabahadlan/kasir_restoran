<?php
include '../../session_check.php';
include '../../config/db.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM menu WHERE idmenu=$id");

header("Location: index.php");
