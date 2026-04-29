<!DOCTYPE html>
<html>
<head>
    <title>Reservasi</title>
    <link rel="stylesheet" href="reservasi.css">
</head>
<body>

<div class="navbar">
    <h2>☕ Coffee Shop</h2>
</div>

<div class="reservasi-container">

    <div class="left">
        <h1>Reservasi Meja</h1>
        <p>Booking tempat terbaik untuk kamu dan orang tersayang 💕</p>
    </div>

    <div class="form-box">
        <h2>Data Diri</h2>

        <form action="simpan_reservasi.php" method="POST">
            <input type="text" name="nama" placeholder="Nama" required>
            <input type="text" name="no_telp" placeholder="No. Telp" required>
            <input type="text" name="alamat" placeholder="Alamat">

            <select name="meja">
                <option>Nomor Meja</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
            </select>

            <select name="jumlah">
                <option>Banyak Orang</option>
                <option>2 Orang</option>
                <option>4 Orang</option>
                <option>6 Orang</option>
            </select>

            <button type="submit">Kirim Reservasi</button>
        </form>
    </div>

</div>

</body>
</html>