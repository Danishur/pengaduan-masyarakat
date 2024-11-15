<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style_2.css">
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <?php if (isset($error)) { echo "<p class='alert'>$error</p>"; } ?>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" placeholder="Username" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Password" required>
        
        <button type="submit">Login</button>
    </form>
    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
</div>
<script src="script.js"></script>
</body>
</html>
