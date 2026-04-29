<?php
session_start();
include 'koneksi.php';

if ($_SESSION['role'] != 'admin') {
    exit("Akses ditolak!");
}

// ambil data laporan
$data = mysqli_query($conn, "
    SELECT m.nama, SUM(d.qty) as total_laku
    FROM detail_transaksi d
    JOIN menu m ON d.menu_id = m.id
    GROUP BY m.id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>

    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
            margin: 0;
        }

        /* NAVBAR */
        .navbar {
            background: #6b3f2b;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
        }

        .navbar button {
            background: white;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            margin-left: 5px;
        }

        /* CONTAINER */
        .container {
            padding: 30px;
        }

        /* CARD */
        .card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 20px;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #6b3f2b;
            color: white;
            padding: 10px;
        }

        td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background: #f9f9f9;
        }

        /* BUTTON */
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .excel {
            background: green;
            color: white;
        }

        .back {
            background: gray;
            color: white;
        }

        .top-action {
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>📊 Laporan Penjualan</h2>

    <div>
        <a href="menu.php"><button>Menu</button></a>
        <a href="logout.php"><button>Logout</button></a>
    </div>
</div>

<div class="container">

    <div class="card">

        <div class="top-action">
            <h3>Data Penjualan</h3>

            <a href="export_excel.php">
                <button class="btn excel">Download Excel</button>
            </a>
        </div>

        <table>
            <tr>
                <th>No</th>
                <th>Menu</th>
                <th>Jumlah Terjual</th>
            </tr>

            <?php $no = 1; ?>
            <?php while($row = mysqli_fetch_assoc($data)): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['total_laku']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

    </div>

</div>

</body>
</html>