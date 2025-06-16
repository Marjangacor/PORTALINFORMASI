<?php
include '../../koneksi/koneksi.php';

$id = $_GET['id'];
$conn->query("DELETE FROM berita WHERE ID_BERITA = $id");


header("Location: beritaadmin.php");
exit();
?>