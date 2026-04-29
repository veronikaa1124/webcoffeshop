<?php
include 'koneksi.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");

$data = mysqli_query($conn, "
    SELECT m.nama, SUM(d.qty) as total_laku
    FROM detail_transaksi d
    JOIN menu m ON d.menu_id = m.id
    GROUP BY m.id
");

echo "<table border='1'>";
echo "<tr><th>Menu</th><th>Jumlah Terjual</th></tr>";

while($row = mysqli_fetch_assoc($data)) {
    echo "<tr>";
    echo "<td>".$row['nama']."</td>";
    echo "<td>".$row['total_laku']."</td>";
    echo "</tr>";
}

echo "</table>";
?>