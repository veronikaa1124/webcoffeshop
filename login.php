<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $u = $_POST['username'];
    $p = $_POST['password'];

    $data = mysqli_query($conn, "SELECT * FROM users WHERE username='$u' AND password='$p'");
    $user = mysqli_fetch_assoc($data);

    if ($user) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: menu.php");
        exit;
    } else {
        $error = "Login gagal! Username atau password salah";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body>

<div class="login-box">
    <h2>☕ Login Coffee Shop</h2>

    <?php if(isset($error)): ?>
        <p class="error"><?= $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <!-- WAJIB name="username" -->
        <input type="text" name="username" placeholder="Username" required>

        <!-- WAJIB name="password" -->
        <input type="password" name="password" placeholder="Password" required>

        <!-- WAJIB name="login" -->
        <button type="submit" name="login">Login</button>
    </form>
</div>

</body>
</html>