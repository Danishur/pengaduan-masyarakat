<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'masyarakat') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $is_laporan = $_POST['is_laporan'];
    $status = 'proses';
    $tgl_pengaduan = date("Y-m-d");

    // Handle file upload
    $foto = '';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $foto_name = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_ext = pathinfo($foto_name, PATHINFO_EXTENSION);
        $foto = "uploads/" . uniqid() . "." . $foto_ext;

        // Check if uploads directory exists, if not create it
        if (!is_dir('uploads')) {
            mkdir('uploads', 0755, true);
        }

        move_uploaded_file($foto_tmp, $foto);
    }

    // Insert data into pengaduan table
    $stmt = $pdo->prepare("INSERT INTO pengaduan (tgl_pengaduan, is_laporan, foto, status, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$tgl_pengaduan, $is_laporan, $foto, $status, $user_id]);

    // Redirect back to user page with success message
    $_SESSION['message'] = 'Pengaduan berhasil dikirim!';
    header("Location: user.php");
    exit;
} else {
    header("Location: user.php");
    exit;
}
?>
