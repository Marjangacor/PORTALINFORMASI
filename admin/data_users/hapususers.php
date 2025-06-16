<?php
include '../../koneksi/koneksi.php';

$id = $_GET['id'];
$conn->query("DELETE FROM users WHERE ID_USERS = $id");


header("Location: usersadmin.php");
exit();
?>