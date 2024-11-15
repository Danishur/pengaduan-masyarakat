<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $role = 'masyarakat';

    // Enkripsi password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah username sudah ada
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $existing_user = $stmt->fetch();

    if ($existing_user) {
        $error = "Username sudah digunakan. Silakan pilih username lain.";
    } else {
        // Simpan pengguna baru
        $stmt = $pdo->prepare("INSERT INTO users (username, password, phone, role) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$username, $hashed_password, $phone, $role])) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Terjadi kesalahan. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="style_2.css">
</head>
<body>
<div class="container">
    <h2>Register</h2>
    <?php if (isset($error)) { echo "<p class='alert'>$error</p>"; } ?>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" placeholder="Username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Password" required>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" placeholder="Phone" required>

        <button type="submit">Register</button>
    </form>
    <p>Sudah punya akun? <a href="index.php">Login di sini</a></p>
</div>
</body>
</html>
