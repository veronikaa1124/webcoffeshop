<?php
session_start();
include 'koneksi.php';

// ======================
// CEK ADMIN
// ======================
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    echo "Akses ditolak!";
    exit;
}

// ======================
// SIMPAN DATA
// ======================
if (isset($_POST['simpan'])) {

    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];

    // upload foto
    $foto = $_FILES['foto']['name'];
    $tmp  = $_FILES['foto']['tmp_name'];

    if ($foto != "") {
        move_uploaded_file($tmp, "upload/" . $foto);
    } else {
        $foto = "default.jpg"; // kalau tidak upload
    }

    mysqli_query($conn, "INSERT INTO menu (nama,harga,foto)
                         VALUES ('$nama','$harga','$foto')");

    header("Location: menu.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Menu</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="form-container">

    <h2>➕ Tambah Menu</h2>

    <form method="POST" enctype="multipart/form-data">

        <input type="text" name="nama" placeholder="Nama Menu" required>

        <input type="number" name="harga" placeholder="Harga" required>

        <input type="file" name="foto">

        <button name="simpan">Simpan</button>

    </form>

    <a href="menu.php">
        <button class="back">Kembali</button>
    </a>

</div>

</body>
</html>