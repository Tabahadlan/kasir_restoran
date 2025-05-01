<?php
include '../../session_check.php';
include '../../config/db.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM user WHERE iduser=$id");

header("Location: index.php");
