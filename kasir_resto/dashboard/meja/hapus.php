<?php
include '../../session_check.php';
include '../../config/db.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM meja WHERE idmeja=$id");

header("Location: index.php");
