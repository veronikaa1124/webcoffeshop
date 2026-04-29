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
// AMBIL DATA
// ======================
$id = (int)$_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM menu WHERE id=$id"));

// ======================
// UPDATE DATA
// ======================
if (isset($_POST['update'])) {

    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];

    // cek upload foto baru
    if ($_FILES['foto']['name'] != "") {
        $foto = $_FILES['foto']['name'];
        $tmp  = $_FILES['foto']['tmp_name'];

        move_uploaded_file($tmp, "upload/" . $foto);

        mysqli_query($conn, "UPDATE menu 
            SET nama='$nama', harga='$harga', foto='$foto' 
            WHERE id=$id");
    } else {
        mysqli_query($conn, "UPDATE menu 
            SET nama='$nama', harga='$harga' 
            WHERE id=$id");
    }

    header("Location: menu.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Menu</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="form-container">

    <h2>✏️ Edit Menu</h2>

    <form method="POST" enctype="multipart/form-data">

        <input type="text" name="nama" value="<?= $data['nama']; ?>" required>

        <input type="number" name="harga" value="<?= $data['harga']; ?>" required>

        <p>Foto Saat Ini:</p>
        <img src="upload/<?= $data['foto']; ?>" width="120" style="border-radius:10px;"><br><br>

        <input type="file" name="foto">

        <button name="update">Update</button>

    </form>

    <a href="menu.php">
        <button class="back">Kembali</button>
    </a>

</div>

</body>
</html>