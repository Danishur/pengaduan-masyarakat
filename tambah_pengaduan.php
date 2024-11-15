<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pengaduan = $_POST['is_laporan'];
    $stmt = $pdo->prepare("INSERT INTO pengaduan (tgl_pengaduan, is_laporan, status, user_id) VALUES (NOW(), ?, '0', ?)");
    $stmt->execute([$pengaduan, $_SESSION['user_id']]);
    
    header("Location: user.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pengaduan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Tambah Pengaduan</h2>
    <form method="POST">
        <label for="is_laporan">Pengaduan:</label>
        <textarea name="is_laporan" required></textarea>
        <button type="submit">Kirim Pengaduan</button>
    </form>
</div>
</body>
</html>
