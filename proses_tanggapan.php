<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pengaduan_id'], $_POST['tanggapan'])) {
    $pengaduan_id = $_POST['pengaduan_id'];
    $tanggapan = $_POST['tanggapan'];
    $admin_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO tanggapan (pengaduan_id, tgl_tanggapan, tanggapan, user_id) VALUES (?, NOW(), ?, ?)");
    $stmt->execute([$pengaduan_id, $tanggapan, $admin_id]);

    header("Location: admin.php");
    exit;
}
?>
