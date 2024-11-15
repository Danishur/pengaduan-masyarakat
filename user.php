<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'masyarakat') {
     header("Location: index.php");
     exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data pengguna
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Ambil data pengaduan pengguna
$stmt = $pdo->prepare("SELECT * FROM pengaduan WHERE user_id = ? ORDER BY tgl_pengaduan DESC");
$stmt->execute([$user_id]);
$pengaduan = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <title>Dashboard Masyarakat</title>
     <link rel="stylesheet" href="style_1.css">
</head>

<body>
     <div class="container">
          <header>
               <h2>Selamat Datang, <?php echo htmlspecialchars($user['username']); ?>!</h2>
               <a href="logout.php" class="logout-button">Logout</a>
          </header>

          <section class="profile">
               <h3>Profil Anda</h3>
               <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
               <p><strong>Telepon:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
          </section>

          <section class="complaints">
               <h3>Pengaduan Anda</h3>
               <?php if (count($pengaduan) > 0): ?>
                    <table>
                         <thead>
                              <tr>
                                   <th>Tanggal</th>
                                   <th>Isi Laporan</th>
                                   <th>Status</th>
                              </tr>
                         </thead>
                         <tbody>
                              <?php foreach ($pengaduan as $p): ?>
                                   <tr>
                                        <td><?php echo htmlspecialchars($p['tgl_pengaduan']); ?></td>
                                        <td><?php echo htmlspecialchars($p['is_laporan']); ?></td>
                                        <td><?php echo htmlspecialchars($p['status']); ?></td>
                                   </tr>
                              <?php endforeach; ?>
                         </tbody>
                    </table>
               <?php else: ?>
                    <p>Belum ada pengaduan.</p>
               <?php endif; ?>
          </section>

          <section class="add-complaint">
               <h3>Buat Pengaduan Baru</h3>
               <form action="proses_pengaduan.php" method="POST" enctype="multipart/form-data">
                    <label for="is_laporan">Isi Laporan:</label>
                    <textarea name="is_laporan" required></textarea>

                    <label for="foto">Foto Pendukung:</label>
                    <input type="file" name="foto" id="file">

                    <button type="submit">Kirim Pengaduan</button>
               </form>
          </section>
     </div>
</body>

</html>