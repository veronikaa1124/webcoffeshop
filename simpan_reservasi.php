<?php
include 'koneksi.php';

$nama   = $_POST['nama'];
$no     = $_POST['no_telp'];
$alamat = $_POST['alamat'];
$meja   = $_POST['meja'];
$jumlah = $_POST['jumlah'];

// simpan ke database
$query = "INSERT INTO reservasi (nama, no_telp, alamat, meja, jumlah_orang)
          VALUES ('$nama', '$no', '$alamat', '$meja', '$jumlah')";

mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservasi Berhasil</title>
    <style>
        body {
            font-family: Arial;
            background: #eee;
        }

        .card {
            width: 350px;
            margin: 80px auto;
            background: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        h2 {
            color: #6b3f2b;
        }

        .data {
            text-align: left;
            margin-top: 15px;
        }

        .data p {
            margin: 8px 0;
        }

        .btn {
            margin-top: 20px;
            padding: 10px;
            background: #6b3f2b;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .btn:hover {
            background: #4e2c1d;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>✅ Reservasi Berhasil</h2>

    <div class="data">
        <p><b>Nama:</b> <?= htmlspecialchars($nama); ?></p>
        <p><b>No. Telp:</b> <?= htmlspecialchars($no); ?></p>
        <p><b>Alamat:</b> <?= htmlspecialchars($alamat); ?></p>
        <p><b>Meja:</b> <?= htmlspecialchars($meja); ?></p>
        <p><b>Jumlah Orang:</b> <?= htmlspecialchars($jumlah); ?></p>
    </div>

    <p>Terima kasih sudah reservasi ☕</p>

    <a href="menu.php">
        <button class="btn">Kembali ke Menu</button>
    </a>
</div>

</body>
</html>