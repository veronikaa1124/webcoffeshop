<?php
session_start();
include 'koneksi.php';

$metode = $_POST['metode'] ?? 'Tidak dipilih'; // 🔥 FIX
// simpan transaksi
mysqli_query($conn, "INSERT INTO transaksi (total, metode) 
VALUES ('$total', '$metode')");

$transaksi_id = mysqli_insert_id($conn);

// simpan detail
foreach ($_SESSION['cart'] as $id => $qty) {
    if ($qty > 0) {
        $id = (int)$id;

        $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM menu WHERE id=$id"));

        $subtotal = $data['harga'] * $qty;

        mysqli_query($conn, "INSERT INTO detail_transaksi 
        (transaksi_id, menu_id, qty, subtotal)
        VALUES ($transaksi_id, $id, $qty, $subtotal)");
    }
}
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Tidak ada pesanan!";
    exit;
}

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nota Pembayaran</title>
    <style>
        body {
            font-family: monospace;
            background: #eee;
        }

        .nota {
            width: 300px;
            background: white;
            padding: 20px;
            margin: 50px auto;
            border: 1px solid #ccc;
        }

        h2 {
            text-align: center;
        }

        .line {
            border-top: 1px dashed black;
            margin: 10px 0;
        }
    </style>
</head>
<body>

<div class="nota">
    <h2>☕ Coffee Shop</h2>

    <div class="line"></div>
    <div class="line"></div>

<p>Metode: <?= $metode; ?></p>

    <?php foreach ($_SESSION['cart'] as $id => $qty): ?>
        <?php if ($qty > 0): ?>

            <?php
            $id = (int)$id;
            $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM menu WHERE id=$id"));
            ?>

            <p>
                <?= $data['nama']; ?> x<?= $qty; ?>
                = Rp <?= number_format($data['harga'] * $qty); ?>
            </p>

            <?php $total += $data['harga'] * $qty; ?>

        <?php endif; ?>
    <?php endforeach; ?>

    <div class="line"></div>

    <h3>Total: Rp <?= number_format($total); ?></h3>
    

    <p>Terima kasih 🙏</p>

</div>

</body>
</html>

<?php

// kosongkan cart
unset($_SESSION['cart']);
?>

