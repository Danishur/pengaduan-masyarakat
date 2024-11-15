<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Mendapatkan daftar pengaduan
$stmt = $pdo->prepare("SELECT p.*, u.username, u.phone FROM pengaduan p JOIN users u ON p.user_id = u.id ORDER BY p.tgl_pengaduan DESC");
$stmt->execute();
$pengaduan = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="admint.css">
</head>
<body>
    <div class="container">
        <h1>Dashboard Admin</h1>
        <h2>Daftar Pengaduan</h2>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Username</th>
                    <th>Telepon</th>
                    <th>Isi Laporan</th>
                    <th>Foto Pendukung</th>
                    <th>Status</th>
                    <th>Tanggapan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pengaduan as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['tgl_pengaduan']); ?></td>
                        <td><?= htmlspecialchars($item['username']); ?></td>
                        <td><?= htmlspecialchars($item['phone']); ?></td>
                        <td><?= htmlspecialchars($item['is_laporan']); ?></td>
                        <td>
                            <?php if ($item['foto']): ?>
                                <img src="<?= htmlspecialchars($item['foto']); ?>" alt="Foto Pengaduan" class="thumbnail">
                            <?php else: ?>
                                Tidak ada
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($item['status']); ?></td>
                        <td>
                            <form action="proses_tanggapan.php" method="POST">
                                <input type="hidden" name="pengaduan_id" value="<?= $item['id']; ?>">
                                <textarea name="tanggapan" required></textarea>
                                <button type="submit">Kirim Tanggapan</button>
                            </form>
                        </td>
                        <td>
                            <form action="update_status.php" method="POST">
                                <input type="hidden" name="pengaduan_id" value="<?= $item['id']; ?>">
                                <select name="status">
                                    <option value="proses" <?= $item['status'] == 'proses' ? 'selected' : ''; ?>>Proses</option>
                                    <option value="selesai" <?= $item['status'] == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                                </select>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
