<?php
session_start();
include 'koneksi.php';

// ======================
// CEK LOGIN
// ======================
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// ======================
// HAPUS MENU (ADMIN)
// ======================
if (isset($_GET['hapus']) && $_SESSION['role'] == 'admin') {
    $id = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM menu WHERE id=$id");
    header("Location: menu.php");
    exit;
}

// ======================
// CART (USER SAJA)
// ======================
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['action']) && isset($_GET['id']) && $_SESSION['role'] != 'admin') {
    $id = (int)$_GET['id'];

    if ($_GET['action'] == "tambah") {
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    }

    if ($_GET['action'] == "kurang" && isset($_SESSION['cart'][$id]) && $_SESSION['cart'][$id] > 0) {
        $_SESSION['cart'][$id]--;
    }
}

// ======================
// AMBIL MENU
// ======================
$data = mysqli_query($conn, "SELECT * FROM menu");

// ======================
// HITUNG TOTAL (USER)
// ======================
$total = 0;
if ($_SESSION['role'] != 'admin') {
    foreach ($_SESSION['cart'] as $id => $qty) {
        $id = (int)$id;
        $q = mysqli_query($conn, "SELECT harga FROM menu WHERE id=$id");
        if ($row = mysqli_fetch_assoc($q)) {
            $total += $qty * $row['harga'];
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu Coffee</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>☕ Coffee Shop</h2>

    <div>
        <span><?= $_SESSION['username']; ?> (<?= $_SESSION['role']; ?>)</span>

        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="admin.php"><button>Dashboard</button></a>
            <a href="laporan.php"><button>Laporan</button></a>
            <a href="tambah.php"><button>+ Menu</button></a>
        <?php endif; ?>

        <a href="logout.php"><button>Logout</button></a>
    </div>
</div>

<div class="container">

    <!-- MENU -->
    <div class="menu-list">
    <?php while($row = mysqli_fetch_assoc($data)): ?>
        
        <div class="card">
            <img src="upload/<?= $row['foto']; ?>">

            <h3><?= $row['nama']; ?></h3>
            <p>Rp <?= number_format($row['harga']); ?></p>

            <!-- USER -->
            <?php if ($_SESSION['role'] != 'admin'): ?>
            <div class="qty">
                <a href="?action=kurang&id=<?= $row['id']; ?>"><button>-</button></a>
                <span><?= $_SESSION['cart'][$row['id']] ?? 0 ?></span>
                <a href="?action=tambah&id=<?= $row['id']; ?>"><button>+</button></a>
            </div>
            <?php endif; ?>

            <!-- ADMIN -->
            <?php if ($_SESSION['role'] == 'admin'): ?>
            <div class="action">
                <a href="edit.php?id=<?= $row['id']; ?>" class="btn-edit">Edit</a>
                <a href="menu.php?hapus=<?= $row['id']; ?>" 
                   class="btn-hapus"
                   onclick="return confirm('Yakin hapus?')">Hapus</a>
            </div>
            <?php endif; ?>

        </div>

    <?php endwhile; ?>
</div>
    <!-- SIDEBAR (USER SAJA) -->
    <?php if ($_SESSION['role'] != 'admin'): ?>
    <div class="sidebar">

        <h3>Total</h3>
        <h2>Rp <?= number_format($total); ?></h2>

        <form action="nota.php" method="POST">
            <select name="metode" required>
                <option value="">-- Pilih Pembayaran --</option>
                <option value="Cash">Cash</option>
                <option value="QRIS">QRIS</option>
                <option value="Debit">Debit</option>
            </select>

            <button type="submit">Bayar</button>
        </form>

        <a href="reservasi.php">
            <button>Reservasi</button>
        </a>

    </div>
    <?php endif; ?>

</div>

</body>
</html>