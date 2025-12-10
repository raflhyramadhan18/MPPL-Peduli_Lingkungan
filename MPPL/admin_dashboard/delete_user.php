<?php
session_start();
require '../Akses/auth_check.php';
if ($_SESSION['role'] !== 'admin') { header("Location: ../User/dashboard_user.php"); exit; }

$username = $_GET['username'] ?? 'Tidak Ditemukan';
?>
<!DOCTYPE html>
<html lang="en"><body>
    <h1>[DELETE USER] - Kode Belum Diimplementasi</h1>
    <p>Admin sedang menghapus user: <strong><?= htmlspecialchars($username) ?></strong></p>
    <p>Tombol 'Hapus' sudah berfungsi. Logika penghapusan ke database perlu ditambahkan di sini.</p>
    <a href="data_user.php">Kembali ke Data User</a>
</body></html>