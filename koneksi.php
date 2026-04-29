<?php
$conn = mysqli_connect("localhost", "root", "", "coffeeshop");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>