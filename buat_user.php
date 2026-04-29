<?php
include 'koneksi.php';

$username = "admin";
$password = password_hash("123", PASSWORD_DEFAULT);
$role = "admin";

mysqli_query($conn, "INSERT INTO users (username, password, role)
VALUES ('$username','$password','$role')");

echo "User berhasil dibuat!";
?>