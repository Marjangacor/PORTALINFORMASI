<?php
include '../../koneksi/koneksi.php';

$id = $_GET['id'];
$conn->query("DELETE FROM perpustakaan WHERE ID_buku = $id");


header("Location: perpusadmin.php");
exit();
?>