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
// HAPUS RESERVASI
// ======================
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM reservasi WHERE id=$id");
    header("Location: admin.php");
    exit;
}

// ======================
// HITUNG DATA
// ======================
$jmlMenu = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM menu"));
$jmlReservasi = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM reservasi"));

// ======================
// AMBIL DATA RESERVASI
// ======================
$data = mysqli_query($conn, "SELECT * FROM reservasi ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>⚙️ Dashboard Admin</h2>

    <div>
        <span><?= $_SESSION['username']; ?></span>
        <a href="menu.php"><button>Menu</button></a>
        <a href="logout.php"><button>Logout</button></a>
    </div>
</div>

<!-- STATISTIK -->
<div class="stats">
    <div class="card">
        <h3>Total Menu</h3>
        <h1><?= $jmlMenu; ?></h1>
    </div>

    <div class="card">
        <h3>Total Reservasi</h3>
        <h1><?= $jmlReservasi; ?></h1>
    </div>
</div>

<!-- TABEL RESERVASI -->
<div class="table-box">
    <h3>Data Reservasi</h3>

    <table>
        <tr>
            <th>Nama</th>
            <th>No HP</th>
            <th>Meja</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>

        <?php while($r = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= $r['nama']; ?></td>
            <td><?= $r['no_telp']; ?></td>
            <td><?= $r['meja']; ?></td>
            <td><?= $r['jumlah_orang']; ?></td>
            <td><?= $r['tanggal']; ?></td>
            <td>
                <a href="admin.php?hapus=<?= $r['id']; ?>" onclick="return confirm('Hapus?')">
                    Hapus
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>