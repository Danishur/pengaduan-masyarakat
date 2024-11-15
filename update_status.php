<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pengaduan_id'], $_POST['status'])) {
    $pengaduan_id = $_POST['pengaduan_id'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE pengaduan SET status = ? WHERE id = ?");
    $stmt->execute([$status, $pengaduan_id]);

    header("Location: admin.php");
    exit;
}
?>
